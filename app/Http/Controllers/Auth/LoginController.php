<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $loginInput = trim($request->input('login') ?: $request->input('email') ?: '');

        if (empty($loginInput)) {
            throw ValidationException::withMessages([
                'login' => __('Nomor handphone, username, atau email wajib diisi.'),
            ]);
        }

        $request->validate([
            'password' => ['required', 'string'],
        ], [
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $password = $request->input('password');
        $remember = $request->boolean('remember');

        // Check if user exists to prevent fake/unregistered logins
        $existingUser = User::where('email', strtolower($loginInput))
            ->orWhere('phone', $loginInput)
            ->orWhere('name', $loginInput)
            ->first();

        if (!$existingUser) {
            $cleanPhone = preg_replace('/[^0-9]/', '', $loginInput);
            if (!empty($cleanPhone)) {
                if (str_starts_with($cleanPhone, '62')) {
                    $cleanPhone = '0' . substr($cleanPhone, 2);
                }
                $existingUser = User::where('phone', $cleanPhone)->first();
            }
        }

        if (!$existingUser) {
            throw ValidationException::withMessages([
                'login' => 'Akun tidak ditemukan. Harap lakukan pendaftaran akun baru terlebih dahulu sebelum masuk.',
            ]);
        }

        if ($existingUser->provider === 'google' && empty($existingUser->password)) {
            throw ValidationException::withMessages([
                'login' => 'Akun ini terdaftar via Akun Google resmi. Silakan masuk menggunakan tombol Masuk dengan Google di bawah.',
            ]);
        }

        // Check if input is email, phone, or username
        $fieldType = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : (preg_match('/^[0-9+]+$/', $loginInput) ? 'phone' : 'name');

        // Attempt primary field
        $attempt = Auth::attempt([$fieldType => $loginInput, 'password' => $password], $remember);

        // Fallback: If not found by primary, attempt email or name or phone
        if (!$attempt && $fieldType !== 'email' && str_contains($loginInput, '@')) {
            $attempt = Auth::attempt(['email' => strtolower($loginInput), 'password' => $password], $remember);
        } elseif (!$attempt && isset($cleanPhone) && !empty($cleanPhone)) {
            $attempt = Auth::attempt(['phone' => $cleanPhone, 'password' => $password], $remember);
        } elseif (!$attempt && $fieldType !== 'name') {
            $attempt = Auth::attempt(['name' => $loginInput, 'password' => $password], $remember);
        }

        if ($attempt) {
            $request->session()->regenerate();

            $user = Auth::user();
            $user->update([
                'last_login_at' => now(),
                'last_login_ip' => $request->ip(),
            ]);

            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'))->with('success', 'Selamat datang kembali, Administrator ' . $user->name);
            }

            return redirect()->intended(route('dashboard'))->with('success', 'Selamat datang kembali, ' . $user->name . '!');
        }

        throw ValidationException::withMessages([
            'password' => 'Kata sandi yang Anda masukkan salah. Jika Anda lupa kata sandi, silakan gunakan fitur Lupa Sandi?.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah berhasil keluar dari akun.');
    }
}
