<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordOtpMail;
use App\Models\ActivityLog;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
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
     * Kirim OTP ke Email
     */
    public function sendOtpEmail(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email:rfc'],
            'cf-turnstile-response' => ['required', 'string'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'cf-turnstile-response.required' => 'Harap selesaikan verifikasi captcha.',
        ]);

        // Cloudflare Turnstile Validation
        $turnstileSecret = config('services.turnstile.secret', '1x0000000000000000000000000000000AA');
        
        try {
            $response = \Illuminate\Support\Facades\Http::timeout(10)->asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'secret' => $turnstileSecret,
                'response' => $validated['cf-turnstile-response'],
                'remoteip' => $request->ip(),
            ]);

            if (!$response->json('success')) {
                return back()->withInput()->withErrors(['cf-turnstile-response' => 'Verifikasi captcha gagal. Silakan coba lagi.']);
            }
        } catch (\Exception $e) {
            Log::error('Turnstile verification error: ' . $e->getMessage());
            return back()->withInput()->withErrors(['cf-turnstile-response' => 'Gagal menghubungi server captcha. Silakan coba lagi.']);
        }

        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            return back()->withInput()->withErrors(['email' => 'Akun dengan email ini tidak ditemukan di sistem kami.']);
        }

        // Generate 6-digit OTP
        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Save OTP to password_reset_tokens table
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => Hash::make($otp),
                'created_at' => now()
            ]
        );

        $siteName = Setting::get('site_name', 'Fawthar TopUp');

        // Send OTP via Email
        try {
            Mail::to($user->email)->send(new ResetPasswordOtpMail($otp, $siteName, $user->username));
        } catch (\Exception $e) {
            Log::error("Failed to send reset OTP email to {$user->email}: " . $e->getMessage());
            return back()->withInput()->withErrors(['email' => 'Gagal mengirim email OTP. Pastikan konfigurasi SMTP benar.']);
        }

        ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'USER_PASSWORD_RESET_OTP_SENT',
            'description' => "Pengguna {$user->username} meminta kode OTP pemulihan kata sandi via email.",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Store email in session to verify OTP later
        session(['reset_email' => $user->email]);

        return redirect()->route('password.verify.form')->with('success', 'Kode OTP pemulihan kata sandi telah dikirim ke email Anda. Silakan periksa kotak masuk atau spam.');
    }

    /**
     * Tampilkan form verifikasi OTP dan kata sandi baru
     */
    public function showVerifyForm()
    {
        if (!session()->has('reset_email')) {
            return redirect()->route('password.request')->with('error', 'Sesi Anda telah kedaluwarsa. Silakan minta kode OTP baru.');
        }

        return view('auth.verify-reset-otp', [
            'email' => session('reset_email')
        ]);
    }

    /**
     * Ganti akun email penerima OTP dan kirim ulang kode OTP
     */
    public function changeEmailAndResendOtp(Request $request)
    {
        $validated = $request->validate([
            'new_email' => ['required', 'email:rfc'],
        ], [
            'new_email.required' => 'Email baru wajib diisi.',
            'new_email.email' => 'Format email tidak valid.',
        ]);

        $user = User::where('email', $validated['new_email'])->first();

        if (!$user) {
            return back()->withInput()->withErrors(['new_email' => 'Akun dengan email ini tidak ditemukan di sistem kami.']);
        }

        // Hapus token OTP lama
        $oldEmail = session('reset_email');
        if ($oldEmail) {
            DB::table('password_reset_tokens')->where('email', $oldEmail)->delete();
        }
        DB::table('password_reset_tokens')->where('email', $user->email)->delete();

        // Buat 6-digit OTP baru
        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        DB::table('password_reset_tokens')->insert([
            'email' => $user->email,
            'token' => Hash::make($otp),
            'created_at' => now(),
        ]);

        $siteName = Setting::get('site_name', 'Fawthar TopUp');

        // Kirim OTP via Email
        try {
            Mail::to($user->email)->send(new ResetPasswordOtpMail($otp, $siteName, $user->username));
        } catch (\Exception $e) {
            Log::error("Failed to send reset OTP email to {$user->email}: " . $e->getMessage());
            return back()->withInput()->withErrors(['new_email' => 'Gagal mengirim email OTP ke alamat baru. Pastikan konfigurasi SMTP benar.']);
        }

        ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'USER_PASSWORD_RESET_EMAIL_CHANGED',
            'description' => "Pengguna {$user->username} mengganti email pemulihan sandi dari " . ($oldEmail ?: '-') . " ke {$user->email}.",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Simpan email baru di session
        session(['reset_email' => $user->email]);

        return redirect()->route('password.verify.form')->with('success', "Email berhasil diubah ke {$user->email}. Kode OTP baru telah dikirim!");
    }

    /**
     * Verifikasi OTP dan atur kata sandi baru
     */
    public function resetPassword(Request $request)
    {
        if (!session()->has('reset_email')) {
            return redirect()->route('password.request')->with('error', 'Sesi Anda telah kedaluwarsa. Silakan minta kode OTP baru.');
        }

        $email = session('reset_email');

        $validated = $request->validate([
            'otp' => ['required', 'string', 'size:6'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)],
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.size' => 'Kode OTP harus 6 digit.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
        ]);

        $record = DB::table('password_reset_tokens')->where('email', $email)->first();

        if (!$record) {
            return back()->withErrors(['otp' => 'Permintaan reset tidak valid atau kode OTP telah kedaluwarsa.']);
        }

        // Check if expired (> 10 minutes)
        if (\Carbon\Carbon::parse($record->created_at)->addMinutes(10)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return back()->withErrors(['otp' => 'Kode OTP telah kedaluwarsa. Silakan minta kode OTP baru.']);
        }

        if (!Hash::check($validated['otp'], $record->token)) {
            return back()->withErrors(['otp' => 'Kode OTP tidak valid.']);
        }

        // Update password
        $user = User::where('email', $email)->first();
        if ($user) {
            $user->update([
                'password' => Hash::make($validated['password']),
            ]);

            ActivityLog::create([
                'user_id' => $user->id,
                'action' => 'USER_PASSWORD_RESET_SUCCESS',
                'description' => "Pengguna {$user->username} berhasil mengatur ulang kata sandi.",
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        // Clean up
        DB::table('password_reset_tokens')->where('email', $email)->delete();
        session()->forget('reset_email');

        return redirect()->route('login')->with('success', 'Kata sandi berhasil diatur ulang. Silakan login dengan kata sandi baru Anda.');
    }
}

