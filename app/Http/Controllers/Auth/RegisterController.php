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

    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'email' => ['required', 'string', 'email:rfc', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)],
            'cf-turnstile-response' => ['required', 'string'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username ini sudah terdaftar. Silakan pilih username lain.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
            'cf-turnstile-response.required' => 'Harap selesaikan verifikasi captcha (Turnstile).',
        ]);

        $validated['username'] = trim($validated['username']);

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

        $user = User::create([
            'username' => $validated['username'],
            'name' => $validated['username'], // Default name to username
            'email' => $validated['email'],
            'role' => 'user',
            'provider' => 'manual',
            'password' => Hash::make($validated['password']),
            'email_verified_at' => now(),
            'last_login_at' => null, // Not logged in yet
        ]);

        ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'USER_REGISTER',
            'description' => "Pengguna baru {$user->username} berhasil mendaftar.",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Redirect to login instead of auto-login
        return redirect()->route('login')->with('success', 'Pendaftaran akun berhasil! Silakan masuk menggunakan Username dan Kata Sandi Anda.');
    }
}
