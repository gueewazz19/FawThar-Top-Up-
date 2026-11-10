@extends('layouts.auth')

@section('title', 'Lupa Kata Sandi')

@section('content')
@php
    $siteName = \App\Models\Setting::get('site_name', 'Fawthar TopUp');
    $turnstileSiteKey = config('services.turnstile.key', '1x00000000000000000000AA');
@endphp

<!-- Cloudflare Turnstile Script -->
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>

<div class="max-w-[420px] mx-auto transition-all">
    <!-- Main Card with Glassmorphism -->
    <div class="glass-card backdrop-blur-xl border border-white/40 dark:border-white/10 shadow-2xl rounded-3xl p-6 sm:p-8 relative overflow-hidden transition-all">
        
        <!-- Decorative glow in the corner -->
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-brand opacity-10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-brand opacity-10 rounded-full blur-2xl pointer-events-none"></div>

        <!-- Header with Back Button -->
        <div class="flex items-center space-x-3 mb-6 relative z-10">
            <a href="{{ route('login') }}" class="p-2 rounded-xl text-slate-500 hover:text-[#EE4D2D] dark:text-slate-400 transition-colors" title="Kembali ke Masuk">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h2 class="text-2xl font-black text-slate-900 dark:text-white font-['Outfit'] tracking-tight">
                    Lupa Sandi
                </h2>
                <span class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 block">Pemulihan via Email</span>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-5 p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-xs text-emerald-600 dark:text-emerald-400 relative z-10">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-5 p-3 rounded-xl bg-rose-500/10 border border-rose-500/30 text-xs text-rose-500 relative z-10">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-5 p-3 rounded-xl bg-rose-500/10 border border-rose-500/30 text-xs text-rose-500 relative z-10">
                <ul class="list-disc pl-4 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4 relative z-10">
            @csrf
            
            <!-- Email Field -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2.5 ml-1">
                    Alamat Email Terdaftar
                </label>
                <div class="input-wrapper">
                    <div class="input-icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                          <path d="M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z" />
                          <path d="M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z" />
                        </svg>
                    </div>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        placeholder="contoh@email.com"
                        class="glass-input w-full pr-4 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700/50 text-[13px] font-semibold text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none ring-brand transition-all @error('email') border-rose-500 @enderror">
                </div>
                <p class="text-[11px] text-slate-400 mt-1.5 ml-1">Kami akan mengirimkan OTP ke email ini.</p>
            </div>

            <!-- Cloudflare Turnstile -->
            <div class="flex justify-center mt-2 min-h-[68px]">
                <div class="cf-turnstile" data-sitekey="{{ $turnstileSiteKey }}" data-theme="auto"></div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-auth-primary mt-2">
                KIRIM KODE OTP
            </button>
        </form>

        <!-- Back Link -->
        <div class="mt-6 pt-5 border-t border-slate-200 dark:border-dark-border text-center text-xs text-slate-600 dark:text-slate-400 relative z-10">
            Ingat kata sandi?
            <a href="{{ route('login') }}" class="text-brand font-bold ml-1 transition-colors">
                Masuk
            </a>
        </div>
    </div>
</div>
@endsection
