<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    /**
     * Redirect directly to official Google OAuth 2.0 Authorization Server
     */
    public function redirect(Request $request)
    {
        $clientId = config('services.google.client_id');
        $redirectUri = route('auth.google.callback');

        if (!$clientId) {
            return redirect()->route('login')->with('error', 'Integrasi Google OAuth resmi belum dikonfigurasi. Harap isi GOOGLE_CLIENT_ID dan GOOGLE_CLIENT_SECRET pada berkas .env untuk mengaktifkan login Google asli.');
        }

        $state = Str::random(40);
        $request->session()->put('google_oauth_state', $state);

        $params = [
            'client_id' => $clientId,
            'redirect_uri' => $redirectUri,
            'response_type' => 'code',
            'scope' => 'openid profile email',
            'access_type' => 'offline',
            'prompt' => 'select_account consent',
            'state' => $state,
        ];

        return redirect('https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params));
    }

    /**
     * Handle callback directly from Google OAuth 2.0 Server
     */
    public function callback(Request $request)
    {
        if ($request->has('error')) {
            return redirect()->route('login')->with('error', 'Autentikasi Google dibatalkan atau terjadi kesalahan: ' . $request->input('error_description', $request->input('error')));
        }

        $code = $request->input('code');
        if (!$code) {
            return redirect()->route('login')->with('error', 'Kode otorisasi Google tidak valid.');
        }

        $clientId = config('services.google.client_id');
        $clientSecret = config('services.google.client_secret');
        $redirectUri = route('auth.google.callback');

        if (!$clientId || !$clientSecret) {
            return redirect()->route('login')->with('error', 'Kredensial Google OAuth di server belum lengkap.');
        }

        try {
            // Exchange authorization code for tokens
            $tokenResponse = Http::asForm()->post('https://oauth2.googleapis.com/token', [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'code' => $code,
                'grant_type' => 'authorization_code',
                'redirect_uri' => $redirectUri,
            ]);

            if (!$tokenResponse->successful()) {
                Log::error('Google OAuth Token Error: ' . $tokenResponse->body());
                return redirect()->route('login')->with('error', 'Gagal memverifikasi token dari Google. Silakan coba lagi.');
            }

            $tokenData = $tokenResponse->json();
            $accessToken = $tokenData['access_token'] ?? null;

            if (!$accessToken) {
                return redirect()->route('login')->with('error', 'Akses token Google tidak ditemukan.');
            }

            // Fetch authentic user profile from Google API
            $userInfoResponse = Http::withToken($accessToken)->get('https://www.googleapis.com/oauth2/v3/userinfo');

            if (!$userInfoResponse->successful()) {
                Log::error('Google OAuth UserInfo Error: ' . $userInfoResponse->body());
                return redirect()->route('login')->with('error', 'Gagal mengambil data profil dari Google.');
            }

            $googleUser = $userInfoResponse->json();

            $googleId = $googleUser['sub'] ?? null;
            $email = strtolower($googleUser['email'] ?? '');
            $name = $googleUser['name'] ?? 'Pengguna Google';
            $avatar = $googleUser['picture'] ?? null;

            if (!$email) {
                return redirect()->route('login')->with('error', 'Email tidak ditemukan dari akun Google yang dipilih.');
            }

            // Find existing user by email or provider_id
            $user = User::where('email', $email)->orWhere(function ($query) use ($googleId) {
                if ($googleId) {
                    $query->where('provider', 'google')->where('provider_id', $googleId);
                }
            })->first();

            if ($user) {
                // Update with real Google profile info
                $user->update([
                    'name' => $user->name ?: $name,
                    'provider' => 'google',
                    'provider_id' => $googleId,
                    'avatar' => $avatar ?: $user->avatar,
                    'email_verified_at' => $user->email_verified_at ?: now(),
                    'last_login_at' => now(),
                    'last_login_ip' => $request->ip(),
                ]);
            } else {
                // Create authentic Google user
                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make(Str::random(32)),
                    'provider' => 'google',
                    'provider_id' => $googleId,
                    'avatar' => $avatar,
                    'role' => 'user',
                    'email_verified_at' => now(),
                    'last_login_at' => now(),
                    'last_login_ip' => $request->ip(),
                ]);
            }

            Auth::login($user, true);
            $request->session()->regenerate();

            ActivityLog::create([
                'user_id' => $user->id,
                'action' => 'USER_LOGIN_GOOGLE',
                'description' => "Pengguna {$user->name} berhasil masuk melalui Akun Google Resmi ({$user->email})",
                'new_values' => ['provider' => 'google', 'provider_id' => $googleId, 'email' => $email],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'))->with('success', "Selamat datang Administrator {$user->name} (Google Resmi)");
            }

            return redirect()->intended(route('dashboard'))->with('success', "Berhasil masuk dengan akun Google resmi {$user->name}!");

        } catch (\Exception $e) {
            Log::error('Google OAuth Exception: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Terjadi kesalahan sistem saat menghubungi server Google: ' . $e->getMessage());
        }
    }
}
