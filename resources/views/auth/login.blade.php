@extends('layouts.auth')

@section('title', 'Masuk Akun')

@section('content')
<div class="glass-card p-6 sm:p-8 border-slate-200 dark:border-dark-border shadow-2xl">
    <div class="mb-6 text-center">
        <div class="w-12 h-12 rounded-2xl bg-indigo-500/15 text-indigo-600 dark:text-indigo-400 flex items-center justify-center mx-auto mb-3 border border-indigo-500/30">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>
        <h2 class="text-2xl font-black text-slate-900 dark:text-white font-['Outfit']">Masuk ke Akun Anda</h2>
        <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Lakukan top up game lebih cepat dan amankan riwayat transaksi Anda.</p>
    </div>

    <form method="POST" action="{{ route('login.submit') }}" class="space-y-4">
        @csrf

        <!-- Email Field with Icon Prefix -->
        <div>
            <label for="email" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                Alamat Email
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    placeholder="nama@email.com"
                    autocomplete="email"
                    class="form-input pl-10 @error('email') border-rose-500 @enderror">
            </div>
            @error('email')
                <p class="text-xs text-rose-500 dark:text-rose-400 mt-1.5 flex items-center space-x-1">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <span>{{ $message }}</span>
                </p>
            @enderror
        </div>

        <!-- Password Field with Icon Prefix & Toggle Visibility -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                    Kata Sandi
                </label>
                <a href="#" onclick="alert('Silakan hubungi customer service kami melalui WhatsApp/Email untuk bantuan reset akun.'); return false;" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline font-medium">
                    Lupa sandi?
                </a>
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input id="password" type="password" name="password" required
                    placeholder="••••••••"
                    autocomplete="current-password"
                    class="form-input pl-10 pr-10 @error('password') border-rose-500 @enderror">
                <button type="button" onclick="togglePasswordVisibility('password', this)"
                    class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors"
                    aria-label="Lihat kata sandi">
                    <!-- Eye Icon -->
                    <svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="text-xs text-rose-500 dark:text-rose-400 mt-1.5 flex items-center space-x-1">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <span>{{ $message }}</span>
                </p>
            @enderror
        </div>

        <!-- Remember Me Checkbox -->
        <div class="flex items-center justify-between pt-1">
            <label class="flex items-center space-x-2.5 text-xs text-slate-600 dark:text-slate-400 cursor-pointer select-none">
                <input type="checkbox" name="remember" class="w-4 h-4 rounded bg-white dark:bg-dark-bg border-slate-300 dark:border-dark-border text-indigo-600 focus:ring-indigo-500">
                <span>Ingat saya di perangkat ini</span>
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn-primary w-full py-3 mt-2 text-sm shadow-md">
            <span>Masuk Sekarang</span>
            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </button>
    </form>

    <!-- Security Trust Footer -->
    <div class="mt-6 pt-5 border-t border-slate-200 dark:border-dark-border text-center space-y-3">
        <div class="flex items-center justify-center space-x-1.5 text-[11px] text-slate-500 dark:text-slate-400">
            <svg class="w-3.5 h-3.5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <span>Dilindungi enkripsi TLS & proteksi WAF anti-bruteforce</span>
        </div>

        <div class="text-xs text-slate-600 dark:text-slate-400">
            Belum memiliki akun?
            <a href="{{ route('register') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline font-bold ml-1">
                Daftar Akun Baru
            </a>
        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon = btn.querySelector('.eye-icon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />';
        } else {
            input.type = 'password';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
        }
    }
</script>
@endsection
