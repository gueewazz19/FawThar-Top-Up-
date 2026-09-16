@extends('layouts.auth')

@section('title', 'Daftar Akun Baru')

@section('content')
<div class="glass-card overflow-hidden border-slate-200 dark:border-dark-border shadow-2xl rounded-3xl">
    <!-- E-Commerce Tab Switcher (Shopee Style) -->
    <div class="grid grid-cols-2 border-b border-slate-200 dark:border-dark-border bg-slate-100/60 dark:bg-dark-surface/40">
        <a href="{{ route('login') }}" class="py-4 text-center text-sm font-semibold text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white transition-all flex items-center justify-center space-x-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
            </svg>
            <span>Masuk</span>
        </a>
        <a href="{{ route('register') }}" class="py-4 text-center text-sm font-black border-b-2 border-indigo-600 dark:border-indigo-400 text-indigo-600 dark:text-indigo-400 bg-white dark:bg-dark-card/60 transition-all flex items-center justify-center space-x-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
            <span>Daftar</span>
        </a>
    </div>

    <!-- Form Container -->
    <div class="p-6 sm:p-8">
        <div class="mb-5">
            <h2 class="text-2xl font-black text-slate-900 dark:text-white font-['Outfit']">Buat Akun Baru</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Daftar sekarang untuk mendapatkan diskon member spesial dan transaksi kilat otomatis.</p>
        </div>

        <form method="POST" action="{{ route('register.submit') }}" class="space-y-4">
            @csrf

            <!-- Full Name -->
            <div>
                <label for="name" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                    Nama Lengkap
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        placeholder="Contoh: Budi Pratama"
                        autocomplete="name"
                        class="form-input pl-10 @error('name') border-rose-500 @enderror">
                </div>
                @error('name')
                    <p class="text-xs text-rose-500 dark:text-rose-400 mt-1.5 flex items-center space-x-1">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <!-- Email -->
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
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        placeholder="nama@email.com"
                        autocomplete="email"
                        class="form-input pl-10 @error('email') border-rose-500 @enderror">
                </div>
                @error('email')
                    <p class="text-xs text-rose-500 dark:text-rose-400 mt-1.5 flex items-center space-x-1">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <!-- WhatsApp Phone -->
            <div>
                <label for="phone" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                    Nomor WhatsApp / HP (Opsional)
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <input id="phone" type="tel" name="phone" value="{{ old('phone') }}"
                        placeholder="Contoh: 081234567890"
                        autocomplete="tel"
                        class="form-input pl-10 @error('phone') border-rose-500 @enderror">
                </div>
                @error('phone')
                    <p class="text-xs text-rose-500 dark:text-rose-400 mt-1.5 flex items-center space-x-1">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <!-- Password with Strength Meter -->
            <div>
                <label for="reg_password" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                    Kata Sandi (Min. 8 Karakter)
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input id="reg_password" type="password" name="password" required
                        placeholder="••••••••"
                        autocomplete="new-password"
                        oninput="checkPasswordStrength(this.value)"
                        class="form-input pl-10 pr-10 @error('password') border-rose-500 @enderror">
                    <button type="button" onclick="togglePasswordVisibility('reg_password', this)"
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors"
                        aria-label="Lihat kata sandi">
                        <svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>

                <!-- Password Strength Indicator -->
                <div class="mt-2 space-y-1">
                    <div class="h-1 w-full bg-slate-200 dark:bg-dark-border rounded-full overflow-hidden flex">
                        <div id="strengthBar" class="h-full w-0 transition-all duration-300 rounded-full"></div>
                    </div>
                    <div class="flex justify-between text-[10px] text-slate-500">
                        <span>Kekuatan sandi:</span>
                        <span id="strengthText" class="font-bold">-</span>
                    </div>
                </div>

                @error('password')
                    <p class="text-xs text-rose-500 dark:text-rose-400 mt-1.5 flex items-center space-x-1">
                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ $message }}</span>
                    </p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                    Konfirmasi Kata Sandi
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        placeholder="••••••••"
                        autocomplete="new-password"
                        class="form-input pl-10 pr-10">
                    <button type="button" onclick="togglePasswordVisibility('password_confirmation', this)"
                        class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors"
                        aria-label="Lihat kata sandi">
                        <svg class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Terms & Privacy Agreement -->
            <div class="pt-1">
                <label class="flex items-start space-x-2.5 text-xs text-slate-600 dark:text-slate-400 cursor-pointer select-none">
                    <input type="checkbox" required class="w-4 h-4 mt-0.5 rounded bg-white dark:bg-dark-bg border-slate-300 dark:border-dark-border text-indigo-600 focus:ring-indigo-500">
                    <span>Saya menyetujui <a href="#" class="text-indigo-600 dark:text-indigo-400 hover:underline">Syarat & Ketentuan</a> serta <a href="#" class="text-indigo-600 dark:text-indigo-400 hover:underline">Kebijakan Privasi</a>.</span>
                </label>
            </div>

            <!-- Submit Button (Royal Electric Indigo) -->
            <button type="submit" class="btn-primary w-full py-3.5 text-sm font-bold shadow-lg shadow-indigo-500/25">
                <span>Daftar Sekarang</span>
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </form>

        <!-- Security Trust Footer -->
        <div class="mt-6 pt-5 border-t border-slate-200 dark:border-dark-border text-center space-y-3">
            <div class="flex items-center justify-center space-x-1.5 text-[11px] text-slate-500 dark:text-slate-400">
                <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span>Privasi data Anda terjamin & dilindungi enkripsi SSL 256-bit</span>
            </div>

            <div class="text-xs text-slate-600 dark:text-slate-400">
                Sudah memiliki akun?
                <a href="{{ route('login') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline font-bold ml-1">
                    Masuk di Sini
                </a>
            </div>
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

    function checkPasswordStrength(val) {
        const bar = document.getElementById('strengthBar');
        const text = document.getElementById('strengthText');
        if (!val) {
            bar.className = 'h-full w-0 transition-all duration-300 rounded-full';
            text.textContent = '-';
            text.className = 'font-bold';
            return;
        }

        let score = 0;
        if (val.length >= 8) score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        if (score <= 1) {
            bar.className = 'h-full w-1/4 bg-rose-500 transition-all duration-300 rounded-full';
            text.textContent = 'Lemah';
            text.className = 'font-bold text-rose-500';
        } else if (score <= 3) {
            bar.className = 'h-full w-2/3 bg-amber-500 transition-all duration-300 rounded-full';
            text.textContent = 'Sedang';
            text.className = 'font-bold text-amber-500';
        } else {
            bar.className = 'h-full w-full bg-emerald-500 transition-all duration-300 rounded-full';
            text.textContent = 'Sangat Kuat 🔒';
            text.className = 'font-bold text-emerald-500';
        }
    }
</script>
@endsection
