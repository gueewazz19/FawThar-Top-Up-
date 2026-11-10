@extends('layouts.auth')

@section('title', 'Daftar Akun Baru')

@section('content')
@php
    $siteName = \App\Models\Setting::get('site_name', 'Fawthar TopUp');
    $turnstileSiteKey = config('services.turnstile.key', '1x00000000000000000000AA');
@endphp

<!-- Cloudflare Turnstile Script -->
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>

<!-- Main Container -->
<div class="max-w-[440px] mx-auto transition-all">

    <!-- CARD CONTAINER -->
    <div class="glass-card backdrop-blur-xl border border-white/40 dark:border-white/10 shadow-2xl rounded-3xl p-6 sm:p-8 relative overflow-hidden transition-all">
        <!-- Decorative glow in the corner -->
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-brand opacity-10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-brand opacity-10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="space-y-5 relative z-10">
            <div class="text-center mb-6">
                <h2 class="text-3xl font-black text-slate-900 dark:text-white font-['Outfit'] tracking-tight">
                    Daftar Baru
                </h2>
                <span class="text-sm text-slate-500 dark:text-slate-400 mt-1">Buat akun Anda sekarang</span>
            </div>

            @if ($errors->any())
                <div class="p-3 rounded-xl bg-rose-500/10 border border-rose-500/30 text-xs text-rose-500">
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.submit') }}" class="space-y-4">
                @csrf
                
                <!-- Username Input -->
                <div>
                    <label for="username" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2.5 ml-1">Username</label>
                    <div class="input-wrapper">
                        <div class="input-icon-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                              <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus
                            placeholder="Contoh: fawthar123"
                            class="glass-input w-full pr-4 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700/50 text-[13px] font-semibold text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none ring-brand transition-all">
                    </div>
                </div>

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2.5 ml-1">Alamat Email</label>
                    <div class="input-wrapper">
                        <div class="input-icon-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                              <path d="M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z" />
                              <path d="M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z" />
                            </svg>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            placeholder="contoh@email.com"
                            class="glass-input w-full pr-4 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700/50 text-[13px] font-semibold text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none ring-brand transition-all">
                    </div>
                    <p class="text-[11px] text-slate-400 mt-1.5 ml-1">Digunakan untuk konfirmasi dan lupa password.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Password Field -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2.5 ml-1">
                            Kata Sandi
                        </label>
                        <div class="input-wrapper">
                            <div class="input-icon-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                  <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 00-5.25 5.25v3a3 3 0 00-3 3v6.75a3 3 0 003 3h10.5a3 3 0 003-3v-6.75a3 3 0 00-3-3v-3c0-2.9-2.35-5.25-5.25-5.25zm3.75 8.25v-3a3.75 3.75 0 10-7.5 0v3h7.5z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="password" id="reg_password" name="password" required minlength="8" placeholder="Minimal 8 char"
                                class="glass-input w-full pr-12 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700/50 text-[13px] font-semibold text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none ring-brand transition-all">
                            <div class="password-toggle-btn">
                                <button type="button" onclick="togglePasswordVisibility('reg_password', this)" class="text-slate-400 hover:text-brand transition-colors p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800" title="Tampilkan sandi">
                                    <svg class="w-4 h-4 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2.5 ml-1">
                            Ulangi Sandi
                        </label>
                        <div class="input-wrapper">
                            <div class="input-icon-wrapper">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                  <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 11.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="password" id="reg_password_confirmation" name="password_confirmation" required minlength="8" placeholder="Ulangi sandi"
                                class="glass-input w-full pr-12 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700/50 text-[13px] font-semibold text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none ring-brand transition-all">
                            <div class="password-toggle-btn">
                                <button type="button" onclick="togglePasswordVisibility('reg_password_confirmation', this)" class="text-slate-400 hover:text-brand transition-colors p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800" title="Tampilkan sandi">
                                    <svg class="w-4 h-4 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cloudflare Turnstile -->
                <div class="flex justify-center mt-4 min-h-[68px]">
                    <div class="cf-turnstile" data-sitekey="{{ $turnstileSiteKey }}" data-theme="auto"></div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-auth-primary mt-2">
                    DAFTAR SEKARANG
                </button>
            </form>

            <!-- Bottom Link: Masuk -->
            <div class="mt-6 pt-5 border-t border-slate-200 dark:border-dark-border text-center text-xs text-slate-600 dark:text-slate-400">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-brand font-bold ml-1 transition-colors">
                    Masuk
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
