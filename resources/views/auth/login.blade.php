@extends('layouts.auth')

@section('title', 'Masuk')

@section('content')
@php
    $siteName = \App\Models\Setting::get('site_name', 'Fawthar TopUp');
@endphp

<!-- Shopee-Accurate Login Card -->
<div class="bg-white dark:bg-[#121826] border border-slate-200/80 dark:border-dark-border shadow-xl rounded-2xl sm:rounded-3xl p-6 sm:p-9 max-w-[420px] mx-auto transition-all">
    <!-- Header: Masuk -->
    <div class="flex flex-col mb-6">
        <h2 class="text-2xl font-bold text-slate-900 dark:text-white font-['Outfit']">
            Masuk
        </h2>
        <span class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Masuk ke Akun Anda</span>
    </div>

    @if (session('error'))
        <div class="mb-4 p-3 rounded-xl bg-rose-500/10 border border-rose-500/30 text-xs text-rose-500 flex items-center space-x-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('login.submit') }}" class="space-y-4">
        @csrf

        <!-- Username / Phone / Email Field -->
        <div>
            <div class="relative">
                <input id="login" type="text" name="login" value="{{ old('login') }}" required autofocus
                    placeholder="No. Handphone/Username/Email"
                    class="w-full px-4 py-3 rounded-lg bg-white dark:bg-[#0B101B] border border-slate-300 dark:border-slate-700 text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-[#EE4D2D] focus:ring-1 focus:ring-[#EE4D2D] transition-colors @error('login') border-rose-500 @enderror">
            </div>
            @error('login')
                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password Field with Show/Hide & Lupa Password? -->
        <div>
            <div class="relative flex items-center">
                <input id="password" type="password" name="password" required
                    placeholder="Kata Sandi"
                    class="w-full pl-4 pr-36 py-3 rounded-lg bg-white dark:bg-[#0B101B] border border-slate-300 dark:border-slate-700 text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-[#EE4D2D] focus:ring-1 focus:ring-[#EE4D2D] transition-colors @error('password') border-rose-500 @enderror">
                
                <div class="absolute right-3 flex items-center space-x-2 text-xs">
                    <!-- Eye Toggle Icon -->
                    <button type="button" onclick="togglePasswordVisibility('password', this)" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors p-1" title="Tampilkan sandi">
                        <svg class="w-4 h-4 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                    <span class="text-slate-300 dark:text-slate-700">|</span>
                    <!-- Forgot Password Link -->
                    <a href="{{ route('password.request') }}" class="text-[#106bdc] hover:underline font-medium whitespace-nowrap">
                        Lupa Sandi?
                    </a>
                </div>
            </div>
            @error('password')
                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button (Coral Red Shopee) -->
        <button type="submit" class="w-full py-3.5 px-4 rounded-lg bg-[#EE4D2D] hover:bg-[#d73f1f] active:scale-[0.99] text-white font-bold text-sm tracking-wide shadow-md shadow-[#EE4D2D]/20 transition-all uppercase">
            MASUK
        </button>

        <!-- Tetap Login Checkbox -->
        <div class="flex items-center space-x-2 pt-1">
            <label class="flex items-center space-x-2 text-xs text-slate-600 dark:text-slate-400 cursor-pointer select-none">
                <input type="checkbox" name="remember" class="w-4 h-4 rounded bg-white dark:bg-slate-900 border-slate-300 dark:border-slate-700 text-[#EE4D2D] focus:ring-[#EE4D2D]">
                <span>Tetap Login</span>
            </label>
            <span class="text-slate-400 cursor-help" title="Menyimpan sesi login Anda di perangkat ini agar tidak perlu login berulang kali.">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </span>
        </div>
    </form>

    <!-- Divider: ATAU -->
    <div class="relative my-6 text-center">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-slate-200 dark:border-dark-border"></div>
        </div>
        <span class="relative px-4 text-xs font-bold text-slate-400 uppercase bg-white dark:bg-[#121826]">
            ATAU
        </span>
    </div>

    <!-- Social Login: ONLY Google Button -->
    <div class="space-y-3">
        <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center space-x-3 py-2.5 px-4 rounded-lg bg-white dark:bg-[#1a2234] hover:bg-slate-50 dark:hover:bg-[#20293e] border border-slate-300 dark:border-slate-700 text-sm font-semibold text-slate-700 dark:text-slate-200 shadow-sm transition-all">
            <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
            </svg>
            <span>Google</span>
        </a>
    </div>

    <!-- Agreement Note -->
    <div class="mt-6 text-center text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed">
        Dengan login, kamu menyetujui 
        <a href="{{ route('home') }}" class="text-[#EE4D2D] hover:underline">Syarat, Ketentuan</a> 
        dan Kebijakan dari {{ $siteName }} & 
        <a href="{{ route('home') }}" class="text-[#EE4D2D] hover:underline">Kebijakan Privasi</a> {{ $siteName }}.
    </div>

    <!-- Bottom Link: Register -->
    <div class="mt-6 pt-5 border-t border-slate-200 dark:border-dark-border text-center text-xs text-slate-600 dark:text-slate-400">
        Baru di {{ $siteName }}?
        <a href="{{ route('register') }}" class="text-[#EE4D2D] hover:underline font-bold ml-1">
            Daftar
        </a>
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
