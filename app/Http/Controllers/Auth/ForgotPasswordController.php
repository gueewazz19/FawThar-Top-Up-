<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordOtpMail;
use App\Models\ActivityLog;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class ForgotPasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Tampilkan formulir permintaan pemulihan kata sandi
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Normalisasi format nomor telepon Indonesia (cth: +62812... -> 0812...)
     */
    private function normalizePhone(?string $phone): string
    {
        if (!$phone) {
            return '';
        }
        $cleaned = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($cleaned, '62')) {
            $cleaned = '0' . substr($cleaned, 2);
        }
        return $cleaned;
    }

    /**
     * Kirim kode OTP Reset Kata Sandi ke email pengguna via SMTP
     */
    public function sendResetOtp(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email'],
            'phone' => ['required', 'string', 'min:9', 'max:20'],
            'puzzle_verified' => ['required', 'boolean'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'puzzle_verified.required' => 'Harap selesaikan verifikasi puzzle terlebih dahulu.',
        ]);

        if (!$validated['puzzle_verified']) {
            return response()->json([
                'success' => false,
                'message' => 'Verifikasi puzzle tidak valid. Silakan geser puzzle dengan tepat.',
            ], 422);
        }

        $email = strtolower(trim($validated['email']));
        $inputPhone = $this->normalizePhone($validated['phone']);

        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Akun dengan alamat email ini tidak ditemukan di sistem kami. Pastikan email Anda sudah terdaftar.',
            ], 422);
        }

        // Cek jika akun terdaftar lewat Google murni
        if ($user->provider === 'google' && empty($user->password)) {
            return response()->json([
                'success' => false,
                'is_google' => true,
                'message' => 'Akun ini terdaftar menggunakan Akun Google Resmi. Kata sandi Anda dikelola langsung oleh Google. Silakan klik tombol "Pulihkan di Google Resmi" di atas.',
            ], 422);
        }

        // Cek kecocokan nomor telepon
        $userPhone = $this->normalizePhone($user->phone);
        if (!empty($userPhone) && $userPhone !== $inputPhone) {
            return response()->json([
                'success' => false,
                'message' => 'Nomor telepon tidak cocok dengan nomor yang terdaftar pada email ini. Mohon masukkan nomor telepon yang sesuai.',
            ], 422);
        }

        // Generate 6-digit OTP
        $otp = (string) random_int(100000, 999999);
        $siteName = Setting::get('site_name', 'Fawthar TopUp');

        session([
            'reset_user_id' => $user->id,
            'reset_email' => $user->email,
            'reset_phone' => $user->phone,
            'reset_otp' => $otp,
            'reset_otp_expires' => now()->addMinutes(10),
            'reset_otp_verified' => false,
        ]);

        // Dispatch Email via SMTP
        $mailSent = false;
        try {
            Mail::to($user->email)->send(new ResetPasswordOtpMail($otp, $siteName, $user->name));
            $mailSent = true;
        } catch (\Exception $e) {
            Log::warning("Gagal mengirim email reset OTP ke {$user->email}: " . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => "Kode OTP pemulihan kata sandi 6-digit telah dikirim ke kotak masuk email {$user->email}.",
            'email' => $user->email,
            'mail_sent' => $mailSent,
            'dev_otp' => config('app.debug') ? $otp : null,
        ]);
    }

    /**
     * Verifikasi kode 6-digit OTP Reset Kata Sandi
     */
    public function verifyResetOtp(Request $request)
    {
        $validated = $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.size' => 'Kode OTP harus berupa 6 digit angka.',
        ]);

        $sessionUserId = session('reset_user_id');
        $sessionOtp = session('reset_otp');
        $expires = session('reset_otp_expires');

        if (!$sessionUserId || !$sessionOtp) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi permintaan pemulihan kata sandi tidak ditemukan atau kedaluwarsa. Silakan ajukan ulang.',
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
                'message' => 'Kode OTP yang Anda masukkan tidak sesuai. Periksa kembali email Anda.',
            ], 422);
        }

        session(['reset_otp_verified' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Verifikasi OTP berhasil! Silakan buat kata sandi baru Anda.',
            'redirect' => route('password.reset'),
        ]);
    }

    /**
     * Tampilkan formulir buat kata sandi baru setelah OTP diverifikasi
     */
    public function showResetForm()
    {
        if (!session('reset_otp_verified') || !session('reset_user_id')) {
            return redirect()->route('password.request')->with('error', 'Silakan selesaikan verifikasi email dan nomor telepon terlebih dahulu.');
        }

        $user = User::find(session('reset_user_id'));
        if (!$user) {
            return redirect()->route('password.request')->with('error', 'Data pengguna tidak ditemukan.');
        }

        return view('auth.reset-password', [
            'user' => $user,
        ]);
    }

    /**
     * Simpan kata sandi baru
     */
    public function resetPassword(Request $request)
    {
        if (!session('reset_otp_verified') || !session('reset_user_id')) {
            return redirect()->route('password.request')->with('error', 'Sesi telah kedaluwarsa. Silakan lakukan pemulihan kembali.');
        }

        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi minimal terdiri dari 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $user = User::findOrFail(session('reset_user_id'));

        $user->update([
            'password' => Hash::make($request->password),
            'provider' => 'manual', // If user sets a password, they can also log in manually
        ]);

        ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'USER_PASSWORD_RESET',
            'description' => "Pengguna {$user->name} ({$user->email}) berhasil memperbarui kata sandi melalui verifikasi OTP email.",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Clear reset session
        $request->session()->forget(['reset_user_id', 'reset_email', 'reset_phone', 'reset_otp', 'reset_otp_expires', 'reset_otp_verified']);

        return redirect()->route('login')->with('success', 'Kata sandi Anda berhasil diperbarui! Silakan masuk menggunakan kata sandi baru Anda.');
    }
}
