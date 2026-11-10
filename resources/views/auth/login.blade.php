@extends('layouts.auth')

@section('title', 'Masuk')

@section('content')
@php
    $siteName = \App\Models\Setting::get('site_name', 'Fawthar TopUp');
@endphp

<!-- Modern Glassmorphism Login Card -->
<div class="glass-card backdrop-blur-xl border border-white/40 dark:border-white/10 shadow-2xl rounded-3xl p-6 sm:p-8 max-w-[420px] mx-auto relative overflow-hidden">
    <!-- Decorative glow in the corner -->
    <div class="absolute -top-10 -right-10 w-32 h-32 bg-brand opacity-10 rounded-full blur-2xl pointer-events-none"></div>
    <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-brand opacity-10 rounded-full blur-2xl pointer-events-none"></div>

    <!-- Header: Masuk -->
    <div class="flex flex-col mb-6 relative z-10 text-center">
        <h2 class="text-3xl font-black text-slate-900 dark:text-white font-['Outfit'] tracking-tight">
            Selamat Datang!
        </h2>
        <span class="text-sm text-slate-500 dark:text-slate-400 mt-1">Silakan masuk ke akun Anda</span>
    </div>

    @if(session('success'))
        <div class="mb-5 p-3.5 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-xs text-emerald-600 dark:text-emerald-400 font-medium flex items-center space-x-2.5 relative z-10">
            <svg class="w-4 h-4 flex-shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('info'))
        <div class="mb-5 p-3.5 rounded-xl bg-indigo-500/10 border border-indigo-500/30 text-xs text-indigo-600 dark:text-indigo-400 font-medium flex items-center space-x-2.5 relative z-10">
            <svg class="w-4 h-4 flex-shrink-0 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('info') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-5 p-3.5 rounded-xl bg-rose-500/10 border border-rose-500/30 text-xs text-rose-500 font-medium flex items-center space-x-2.5 relative z-10">
            <svg class="w-4 h-4 flex-shrink-0 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('login.submit') }}" autocomplete="off" class="space-y-5 relative z-10">
        @csrf

        <!-- Username Field -->
        <div>
            <div class="input-wrapper">
                <div class="input-icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                      <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus
                    placeholder="Username"
                    class="glass-input w-full pr-4 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700/50 text-[13px] font-semibold text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none ring-brand transition-all @error('username') border-rose-500 @enderror">
            </div>
            @error('username')
                <p class="text-xs text-rose-500 mt-1.5 pl-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password Field with Show/Hide & Lupa Password? -->
        <div>
            <div class="input-wrapper">
                <div class="input-icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                      <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 00-5.25 5.25v3a3 3 0 00-3 3v6.75a3 3 0 003 3h10.5a3 3 0 003-3v-6.75a3 3 0 00-3-3v-3c0-2.9-2.35-5.25-5.25-5.25zm3.75 8.25v-3a3.75 3.75 0 10-7.5 0v3h7.5z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    placeholder="Kata Sandi"
                    class="glass-input w-full pr-12 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700/50 text-[13px] font-semibold text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none ring-brand transition-all @error('password') border-rose-500 @enderror">
                
                <div class="password-toggle-btn">
                    <!-- Eye Toggle Icon -->
                    <button type="button" onclick="togglePasswordVisibility('password', this)" class="text-slate-400 hover:text-brand transition-colors p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800" title="Tampilkan sandi">
                        <svg class="w-4 h-4 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>
            @error('password')
                <p class="text-xs text-rose-500 mt-1.5 pl-1">{{ $message }}</p>
            @enderror
            
            <div class="flex justify-between items-center mt-3">
                <!-- Tetap Login Checkbox -->
                <label class="flex items-center space-x-2 text-xs text-slate-600 dark:text-slate-400 cursor-pointer select-none group/check">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 dark:border-slate-600 text-brand focus:ring-brand focus:ring-2 focus:ring-offset-2 dark:bg-slate-800">
                    <span class="group-hover/check:text-slate-900 dark:group-hover/check:text-white transition-colors">Ingat Saya</span>
                </label>

                <!-- Forgot Password Link -->
                <a href="{{ route('password.request') }}" class="text-xs text-brand hover:text-brand font-semibold transition-colors">
                    Lupa Sandi?
                </a>
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn-auth-primary mt-2">
            MASUK SEKARANG
        </button>
    </form>

    <!-- Agreement Note -->
    <div class="mt-6 text-center text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed">
        Dengan login, kamu menyetujui 
        <a href="{{ route('home') }}" class="text-brand hover:underline">Syarat, Ketentuan</a> 
        dan Kebijakan dari {{ $siteName }} & 
        <a href="{{ route('home') }}" class="text-brand hover:underline">Kebijakan Privasi</a> {{ $siteName }}.
    </div>

    <!-- Bottom Link: Register -->
    <div class="mt-6 pt-5 border-t border-slate-200 dark:border-dark-border text-center text-xs text-slate-600 dark:text-slate-400">
        Baru di {{ $siteName }}?
        <a href="{{ route('register') }}" class="text-brand hover:underline font-bold ml-1">
            Daftar
        </a>
    </div>
</div>

<script>
    // Ensure password field is never pre-filled automatically on page load
    window.addEventListener('DOMContentLoaded', function () {
        const passInput = document.getElementById('password');
        if (passInput) {
            passInput.value = '';
            setTimeout(() => { passInput.value = ''; }, 50);
            setTimeout(() => { passInput.value = ''; }, 250);
            setTimeout(() => { passInput.value = ''; }, 600);
        }
    });
</script>
@endsection
