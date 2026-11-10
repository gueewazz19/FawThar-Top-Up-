@extends('layouts.auth')

@section('title', 'Buat Kata Sandi Baru')

@section('content')
@php
    $siteName = \App\Models\Setting::get('site_name', 'Fawthar TopUp');
@endphp

<div class="max-w-[420px] mx-auto transition-all">
    <!-- Main Card -->
    <div class="glass-card backdrop-blur-xl border border-white/40 dark:border-white/10 shadow-2xl rounded-3xl p-6 sm:p-8 relative overflow-hidden transition-all">
        
        <!-- Decorative glow in the corner -->
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-brand opacity-10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-brand opacity-10 rounded-full blur-2xl pointer-events-none"></div>

        <!-- Header -->
        <div class="text-center mb-6 relative z-10">
            <h2 class="text-2xl font-black text-slate-900 dark:text-white font-['Outfit'] tracking-tight">
                Buat Kata Sandi Baru
            </h2>
            <span class="text-xs text-slate-500 dark:text-slate-400 mt-1 block">
                Untuk akun: <strong class="text-slate-700 dark:text-slate-200">{{ $user->email }}</strong>
            </span>
        </div>

        @if ($errors->any())
            <div class="mb-5 p-3 rounded-xl bg-rose-500/10 border border-rose-500/30 text-xs text-rose-500 relative z-10 space-y-1">
                @foreach ($errors->all() as $error)
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ $error }}</span>
                    </div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="space-y-4 relative z-10">
            @csrf

            <!-- Password Baru -->
            <div>
                <label for="password" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2.5 ml-1">
                    Kata Sandi Baru
                </label>
                <div class="input-wrapper">
                    <div class="input-icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                          <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 00-5.25 5.25v3a3 3 0 00-3 3v6.75a3 3 0 003 3h10.5a3 3 0 003-3v-6.75a3 3 0 00-3-3v-3c0-2.9-2.35-5.25-5.25-5.25zm3.75 8.25v-3a3.75 3.75 0 10-7.5 0v3h7.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input id="password" type="password" name="password" required autofocus
                        placeholder="Minimal 8 karakter"
                        class="glass-input w-full pr-12 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700/50 text-[13px] font-semibold text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none ring-brand transition-all @error('password') border-rose-500 @enderror">
                    
                    <div class="password-toggle-btn">
                        <button type="button" onclick="togglePasswordVisibility('password', this)" class="text-slate-400 hover:text-brand transition-colors p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800" title="Tampilkan sandi">
                            <svg class="w-4 h-4 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Konfirmasi Password Baru -->
            <div>
                <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2.5 ml-1">
                    Konfirmasi Kata Sandi Baru
                </label>
                <div class="input-wrapper">
                    <div class="input-icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                          <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 11.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        placeholder="Ketik ulang kata sandi baru"
                        class="glass-input w-full pr-12 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700/50 text-[13px] font-semibold text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none ring-brand transition-all">
                    
                    <div class="password-toggle-btn">
                        <button type="button" onclick="togglePasswordVisibility('password_confirmation', this)" class="text-slate-400 hover:text-brand transition-colors p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800" title="Tampilkan sandi">
                            <svg class="w-4 h-4 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-auth-primary mt-2">
                SIMPAN KATA SANDI BARU
            </button>
        </form>
    </div>
</div>
@endsection
