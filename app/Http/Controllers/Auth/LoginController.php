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
        $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $username = trim($request->input('username'));
        $password = $request->input('password');
        $remember = $request->boolean('remember');

        $existingUser = User::where('username', $username)->first();

        if (!$existingUser) {
            throw ValidationException::withMessages([
                'username' => 'Akun belum terdaftar. Silakan lakukan pendaftaran akun baru terlebih dahulu.',
            ]);
        }

        $attempt = Auth::attempt(['username' => $username, 'password' => $password], $remember);

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
