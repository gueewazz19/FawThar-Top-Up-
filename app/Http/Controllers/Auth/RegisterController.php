<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\RegisterOtpMail;
use App\Models\ActivityLog;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Verify puzzle captcha and dispatch OTP to user's email inbox
     */
    public function sendOtp(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:191'],
            'phone' => ['required', 'string', 'min:9', 'max:20'],
            'puzzle_verified' => ['required', 'boolean'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.min' => 'Nomor telepon minimal 9 digit.',
            'puzzle_verified.required' => 'Harap selesaikan verifikasi puzzle terlebih dahulu.',
        ]);

        $email = strtolower(trim($validated['email']));
        $phone = preg_replace('/[^0-9]/', '', $validated['phone']);
        if (str_starts_with($phone, '62')) {
            $phone = '0' . substr($phone, 2);
        }

        // Check if email already registered
        if (User::where('email', $email)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Email ini sudah terdaftar. Silakan login atau gunakan email lain.',
            ], 422);
        }

        // Check if phone already registered
        if (User::where('phone', $phone)->orWhere('phone', $validated['phone'])->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor telepon ini sudah terdaftar. Silakan login atau gunakan nomor lain.',
            ], 422);
        }

        if (!$validated['puzzle_verified']) {
            return response()->json([
                'success' => false,
                'message' => 'Verifikasi puzzle tidak valid. Silakan geser puzzle dengan tepat.',
            ], 422);
        }

        // Generate 6-digit cryptographic random OTP
        $otp = (string) random_int(100000, 999999);
        $siteName = Setting::get('site_name', 'Fawthar TopUp');

        session([
            'register_email' => $email,
            'register_phone' => $phone,
            'register_otp' => $otp,
            'register_otp_expires' => now()->addMinutes(10),
            'register_otp_verified' => false,
        ]);

        // Dispatch OTP Mail
        $mailSent = false;
        try {
            Mail::to($email)->send(new RegisterOtpMail($otp, $siteName));
            $mailSent = true;
        } catch (\Exception $e) {
            Log::warning("Gagal mengirim email OTP ke {$email}: " . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => "Kode OTP 6-digit telah dikirim ke kotak masuk email {$email}.",
            'email' => $email,
            'mail_sent' => $mailSent,
            'dev_otp' => config('app.debug') ? $otp : null, // Display in console/alert if local mail server is off
        ]);
    }

    /**
     * Validate 6-digit OTP entered by user
     */
    public function verifyOtp(Request $request)
    {
        $validated = $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.size' => 'Kode OTP harus berupa 6 digit angka.',
        ]);

        $sessionEmail = session('register_email');
        $sessionOtp = session('register_otp');
        $expires = session('register_otp_expires');

        if (!$sessionEmail || !$sessionOtp) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi OTP tidak ditemukan atau telah kedaluwarsa. Silakan minta kode baru.',
            ], 422);
        }

        if (now()->greaterThan($expires)) {
            return response()->json([
                'success' => false,
                'message' => 'Kode OTP telah kedaluwarsa. Silakan minta kode OTP baru.',
            ], 422);
        }

        if ($validated['otp'] !== $sessionOtp) {
            return response()->json([
                'success' => false,
                'message' => 'Kode OTP yang Anda masukkan salah. Periksa email Anda kembali.',
            ], 422);
        }

        // Mark OTP verified in session
        session(['register_otp_verified' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Verifikasi OTP berhasil! Silakan tentukan nama dan kata sandi Anda.',
        ]);
    }

    /**
     * Complete registration after OTP is verified
     */
    public function completeRegistration(Request $request)
    {
        $sessionEmail = session('register_email');
        $sessionPhone = session('register_phone');
        $isVerified = session('register_otp_verified');

        if (!$sessionEmail || !$isVerified) {
            return redirect()->route('register')->with('error', 'Harap lakukan verifikasi email dan OTP terlebih dahulu.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $sessionEmail,
            'phone' => $sessionPhone,
            'role' => 'user',
            'provider' => 'manual',
            'password' => Hash::make($validated['password']),
            'email_verified_at' => now(),
            'last_login_at' => now(),
            'last_login_ip' => $request->ip(),
        ]);

        // Clean up session
        session()->forget(['register_email', 'register_phone', 'register_otp', 'register_otp_expires', 'register_otp_verified']);

        Auth::login($user);
        $request->session()->regenerate();

        ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'USER_REGISTER',
            'description' => "Pengguna baru {$user->name} berhasil mendaftar via verifikasi Email OTP ({$user->email})",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Pendaftaran akun berhasil! Selamat datang di ' . Setting::get('site_name', 'Fawthar TopUp') . '.');
    }

    /**
     * Legacy direct register fallback
     */
    public function register(Request $request)
    {
        return $this->completeRegistration($request);
    }
}
