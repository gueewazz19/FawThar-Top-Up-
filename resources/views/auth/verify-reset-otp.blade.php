@extends('layouts.auth')

@section('title', 'Verifikasi OTP & Reset Sandi')

@section('content')
@php
    $siteName = \App\Models\Setting::get('site_name', 'Fawthar TopUp');
@endphp

<div class="max-w-[420px] mx-auto transition-all">
    <!-- Main Card with Glassmorphism -->
    <div class="glass-card backdrop-blur-xl border border-white/40 dark:border-white/10 shadow-2xl rounded-3xl p-6 sm:p-8 relative overflow-hidden transition-all">
        
        <!-- Decorative glow in the corner -->
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-brand opacity-10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-brand opacity-10 rounded-full blur-2xl pointer-events-none"></div>

        <!-- Header -->
        <div class="text-center mb-5 relative z-10">
            <h2 class="text-2xl font-black text-slate-900 dark:text-white font-['Outfit'] tracking-tight">
                Verifikasi OTP
            </h2>
            <span class="text-xs text-slate-500 dark:text-slate-400 mt-1 block">Masukkan kode OTP yang telah dikirim ke email Anda</span>
        </div>

        <!-- Target Email Info Card & Change Email Option -->
        <div class="mb-5 p-3.5 rounded-2xl bg-slate-100/90 dark:bg-slate-900/80 border border-slate-200 dark:border-slate-800 text-xs relative z-10 shadow-sm">
            <div class="flex items-center justify-between gap-2">
                <div class="flex items-center space-x-2 min-w-0">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse flex-shrink-0"></span>
                    <span class="text-slate-500 dark:text-slate-400 text-[11px] truncate">
                        Dikirim ke: <strong class="text-slate-800 dark:text-slate-200">{{ $email }}</strong>
                    </span>
                </div>
                <button type="button" onclick="toggleChangeEmailForm()" class="text-xs font-bold text-brand hover:underline flex items-center space-x-1 flex-shrink-0 cursor-pointer">
                    <span>Ganti Email</span>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                </button>
            </div>

            <!-- Collapsible Form for Changing Email -->
            <div id="changeEmailFormContainer" class="{{ $errors->has('new_email') ? '' : 'hidden' }} mt-3 pt-3 border-t border-slate-200 dark:border-slate-800 space-y-2.5">
                <p class="text-[11px] text-slate-500 dark:text-slate-400">
                    OTP belum masuk atau salah ketik? Masukkan alamat email akun Anda yang benar di bawah ini:
                </p>
                <form method="POST" action="{{ route('password.change_email') }}" class="space-y-2">
                    @csrf
                    <div>
                        <input type="email" name="new_email" required value="{{ old('new_email') }}" placeholder="contoh@email-asli.com"
                            class="glass-input w-full px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-medium text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none ring-brand @error('new_email') border-rose-500 @enderror">
                        @error('new_email')
                            <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center space-x-2">
                        <button type="submit" class="btn-auth-primary text-xs py-2 px-3 flex-1">
                            Kirim OTP ke Email Baru
                        </button>
                        <button type="button" onclick="toggleChangeEmailForm()" class="px-3 py-2 rounded-xl bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs font-semibold hover:bg-slate-300 dark:hover:bg-slate-700">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-5 p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-xs text-emerald-600 dark:text-emerald-400 relative z-10 flex items-center space-x-2">
                <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-5 p-3 rounded-xl bg-rose-500/10 border border-rose-500/30 text-xs text-rose-500 relative z-10">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any() && !$errors->has('new_email'))
            <div class="mb-5 p-3 rounded-xl bg-rose-500/10 border border-rose-500/30 text-xs text-rose-500 relative z-10">
                <ul class="list-disc pl-4 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="space-y-4 relative z-10">
            @csrf
            
            <!-- OTP Field -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2.5 ml-1">
                    Kode OTP (6 Digit)
                </label>
                <div class="input-wrapper">
                    <div class="input-icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                          <path fill-rule="evenodd" d="M15.75 1.5a6.75 6.75 0 00-6.651 7.906c-.067.39-.142.832-.44 1.201-.317.391-.81.656-1.393.922L6.1 12.067a.75.75 0 00-.22.53v1.653a.75.75 0 00.22.53l1.5 1.5a.75.75 0 00.53.22h1.653a.75.75 0 00.53-.22l.5-.5a.75.75 0 00.22-.53V14.6l.89-.89c.39-.39.924-.575 1.458-.667A6.75 6.75 0 1015.75 1.5zm0 3a1.5 1.5 0 100 3 1.5 1.5 0 000-3z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" name="otp" required autofocus maxlength="6"
                        placeholder="Contoh: 123456"
                        class="glass-input w-full pr-4 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700/50 text-[13px] font-semibold text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none ring-brand transition-all @error('otp') border-rose-500 @enderror">
                </div>
            </div>

            <!-- Password Field -->
            <div>
                <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2.5 ml-1">
                    Kata Sandi Baru
                </label>
                <div class="input-wrapper">
                    <div class="input-icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                          <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 00-5.25 5.25v3a3 3 0 00-3 3v6.75a3 3 0 003 3h10.5a3 3 0 003-3v-6.75a3 3 0 00-3-3v-3c0-2.9-2.35-5.25-5.25-5.25zm3.75 8.25v-3a3.75 3.75 0 10-7.5 0v3h7.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="password" id="reset_password" name="password" required minlength="8"
                        placeholder="Kata sandi baru"
                        class="glass-input w-full pr-12 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700/50 text-[13px] font-semibold text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none ring-brand transition-all">
                    <div class="password-toggle-btn">
                        <button type="button" onclick="togglePasswordVisibility('reset_password', this)" class="text-slate-400 hover:text-brand transition-colors p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800" title="Tampilkan sandi">
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
                    Ulangi Kata Sandi
                </label>
                <div class="input-wrapper">
                    <div class="input-icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                          <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm13.36-1.814a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 11.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="password" id="reset_password_confirmation" name="password_confirmation" required minlength="8"
                        placeholder="Ulangi kata sandi"
                        class="glass-input w-full pr-12 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700/50 text-[13px] font-semibold text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none ring-brand transition-all">
                    <div class="password-toggle-btn">
                        <button type="button" onclick="togglePasswordVisibility('reset_password_confirmation', this)" class="text-slate-400 hover:text-brand transition-colors p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800" title="Tampilkan sandi">
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
                UBAH KATA SANDI
            </button>
        </form>

        <!-- Cancel Link -->
        <div class="mt-6 pt-5 border-t border-slate-200 dark:border-dark-border text-center text-xs text-slate-600 dark:text-slate-400 relative z-10">
            <a href="{{ route('password.request') }}" class="text-brand font-bold transition-colors">
                Batalkan & Minta Ulang OTP
            </a>
        </div>
    </div>
</div>

<script>
    function toggleChangeEmailForm() {
        const formContainer = document.getElementById('changeEmailFormContainer');
        if (formContainer) {
            formContainer.classList.toggle('hidden');
            if (!formContainer.classList.contains('hidden')) {
                const input = formContainer.querySelector('input[name="new_email"]');
                if (input) input.focus();
            }
        }
    }
</script>
@endsection
