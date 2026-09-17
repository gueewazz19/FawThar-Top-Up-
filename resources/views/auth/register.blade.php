@extends('layouts.auth')

@section('title', 'Daftar Akun Baru')

@section('content')
@php
    $siteName = \App\Models\Setting::get('site_name', 'Fawthar TopUp');
@endphp

<!-- Main Container -->
<div class="max-w-[440px] mx-auto transition-all">

    <!-- STEPPER HEADER (Visible on Step 2 & Step 3 - Screenshot 5) -->
    <div id="stepHeader" class="hidden mb-6">
        <div class="flex items-center justify-between px-2 text-center text-xs">
            <!-- Step 1 Indicator -->
            <div id="badgeStep1" class="flex flex-col items-center space-y-1">
                <div class="w-8 h-8 rounded-full bg-emerald-500 text-white font-bold flex items-center justify-center text-sm shadow-md">
                    1
                </div>
                <span class="text-emerald-600 dark:text-emerald-400 font-bold text-[11px]">Verifikasi Email</span>
            </div>

            <!-- Connector line 1-2 -->
            <div class="flex-1 h-[2px] bg-slate-200 dark:bg-dark-border mx-2 -mt-4 relative">
                <div id="connector12" class="h-full bg-emerald-500 w-0 transition-all duration-300"></div>
            </div>

            <!-- Step 2 Indicator -->
            <div id="badgeStep2" class="flex flex-col items-center space-y-1 opacity-50">
                <div class="w-8 h-8 rounded-full bg-slate-300 dark:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold flex items-center justify-center text-sm">
                    2
                </div>
                <span class="text-slate-500 dark:text-slate-400 font-medium text-[11px]">Buat password</span>
            </div>

            <!-- Connector line 2-3 -->
            <div class="flex-1 h-[2px] bg-slate-200 dark:bg-dark-border mx-2 -mt-4 relative">
                <div id="connector23" class="h-full bg-emerald-500 w-0 transition-all duration-300"></div>
            </div>

            <!-- Step 3 Indicator -->
            <div id="badgeStep3" class="flex flex-col items-center space-y-1 opacity-50">
                <div class="w-8 h-8 rounded-full bg-slate-300 dark:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold flex items-center justify-center text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <span class="text-slate-500 dark:text-slate-400 font-medium text-[11px]">Selesai</span>
            </div>
        </div>
    </div>

    <!-- CARD CONTAINER -->
    <div class="bg-white dark:bg-[#121826] border border-slate-200/80 dark:border-dark-border shadow-xl rounded-2xl sm:rounded-3xl p-6 sm:p-9 transition-all relative">

        <!-- ======================================================== -->
        <!-- STEP 1: Shopee Register Form (Screenshot 3)               -->
        <!-- ======================================================== -->
        <div id="step1View" class="space-y-5">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white font-['Outfit']">
                    Daftar
                </h2>
                <span class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Buat Akun Baru</span>
            </div>

            <div id="step1Alert" class="hidden p-3 rounded-xl bg-rose-500/10 border border-rose-500/30 text-xs text-rose-500"></div>

            <form id="step1Form" onsubmit="handleStep1Submit(event)" class="space-y-4">
                <!-- Email Input -->
                <div>
                    <label for="registerEmail" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Alamat Email Asli</label>
                    <input id="registerEmail" type="email" required autofocus
                        placeholder="Alamat Email (cth: nama@gmail.com)"
                        class="w-full px-4 py-3 rounded-lg bg-white dark:bg-[#0B101B] border border-slate-300 dark:border-slate-700 text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-[#EE4D2D] focus:ring-1 focus:ring-[#EE4D2D] transition-colors">
                    <p class="text-[11px] text-slate-400 mt-1">Kode verifikasi OTP 6-digit akan dikirimkan ke kotak masuk email ini.</p>
                </div>

                <!-- Phone Input -->
                <div>
                    <label for="registerPhone" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Nomor Telepon / WhatsApp</label>
                    <input id="registerPhone" type="tel" required
                        placeholder="Nomor Telepon (cth: 081234567890)"
                        class="w-full px-4 py-3 rounded-lg bg-white dark:bg-[#0B101B] border border-slate-300 dark:border-slate-700 text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-[#EE4D2D] focus:ring-1 focus:ring-[#EE4D2D] transition-colors">
                    <p class="text-[11px] text-slate-400 mt-1">Nomor telepon harus aktif dan sesuai untuk verifikasi akun Anda.</p>
                </div>

                <!-- Submit Button: BERIKUTNYA -->
                <button type="submit" id="btnNextStep1" class="w-full py-3.5 px-4 rounded-lg bg-[#EE4D2D] hover:bg-[#d73f1f] active:scale-[0.99] text-white font-bold text-sm tracking-wide shadow-md shadow-[#EE4D2D]/20 transition-all uppercase">
                    BERIKUTNYA
                </button>

                <!-- Tetap Login Checkbox -->
                <div class="flex items-center space-x-2 pt-1">
                    <label class="flex items-center space-x-2 text-xs text-slate-600 dark:text-slate-400 cursor-pointer select-none">
                        <input type="checkbox" checked class="w-4 h-4 rounded bg-white dark:bg-slate-900 border-slate-300 dark:border-slate-700 text-[#EE4D2D] focus:ring-[#EE4D2D]">
                        <span>Tetap Login</span>
                    </label>
                    <span class="text-slate-400 cursor-help" title="Menyimpan sesi login pendaftaran Anda di perangkat ini.">
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

            <!-- ONLY Google Button -->
            <div>
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

            <!-- Bottom Link: Masuk -->
            <div class="mt-6 pt-5 border-t border-slate-200 dark:border-dark-border text-center text-xs text-slate-600 dark:text-slate-400">
                Punya akun?
                <a href="{{ route('login') }}" class="text-[#EE4D2D] hover:underline font-bold ml-1">
                    Masuk
                </a>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- STEP 2: Masukkan Kode OTP (Screenshot 5)                  -->
        <!-- ======================================================== -->
        <div id="step2View" class="hidden space-y-6">
            <div class="flex items-center space-x-3">
                <button type="button" onclick="goToStep(1)" class="p-1.5 -ml-2 rounded-lg text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors" title="Kembali">
                    <svg class="w-5 h-5 text-[#EE4D2D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </button>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white font-['Outfit']">
                    Masukkan Kode OTP
                </h2>
            </div>

            <div class="text-center space-y-2">
                <p class="text-xs text-slate-600 dark:text-slate-400">
                    Kode OTP telah dikirim via Email ke
                </p>
                <div class="inline-flex items-center space-x-2 text-sm font-bold text-slate-900 dark:text-white bg-slate-100 dark:bg-slate-800/80 px-3.5 py-1.5 rounded-full border border-slate-200 dark:border-slate-700">
                    <svg class="w-4 h-4 text-[#EE4D2D]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span id="targetEmailLabel">user@email.com</span>
                </div>
            </div>

            <div id="step2Alert" class="hidden p-3 rounded-xl bg-rose-500/10 border border-rose-500/30 text-xs text-rose-500"></div>

            <!-- 6-digit OTP Inputs (Screenshot 5 style) -->
            <div class="flex justify-center items-center space-x-2.5 sm:space-x-3 py-2">
                <input type="text" maxlength="1" class="otp-digit w-10 h-12 sm:w-11 sm:h-13 text-center text-xl font-bold rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-[#0B101B] text-slate-900 dark:text-white focus:outline-none focus:border-[#EE4D2D] focus:ring-1 focus:ring-[#EE4D2D]" inputmode="numeric" pattern="[0-9]*">
                <input type="text" maxlength="1" class="otp-digit w-10 h-12 sm:w-11 sm:h-13 text-center text-xl font-bold rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-[#0B101B] text-slate-900 dark:text-white focus:outline-none focus:border-[#EE4D2D] focus:ring-1 focus:ring-[#EE4D2D]" inputmode="numeric" pattern="[0-9]*">
                <input type="text" maxlength="1" class="otp-digit w-10 h-12 sm:w-11 sm:h-13 text-center text-xl font-bold rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-[#0B101B] text-slate-900 dark:text-white focus:outline-none focus:border-[#EE4D2D] focus:ring-1 focus:ring-[#EE4D2D]" inputmode="numeric" pattern="[0-9]*">
                <input type="text" maxlength="1" class="otp-digit w-10 h-12 sm:w-11 sm:h-13 text-center text-xl font-bold rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-[#0B101B] text-slate-900 dark:text-white focus:outline-none focus:border-[#EE4D2D] focus:ring-1 focus:ring-[#EE4D2D]" inputmode="numeric" pattern="[0-9]*">
                <input type="text" maxlength="1" class="otp-digit w-10 h-12 sm:w-11 sm:h-13 text-center text-xl font-bold rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-[#0B101B] text-slate-900 dark:text-white focus:outline-none focus:border-[#EE4D2D] focus:ring-1 focus:ring-[#EE4D2D]" inputmode="numeric" pattern="[0-9]*">
                <input type="text" maxlength="1" class="otp-digit w-10 h-12 sm:w-11 sm:h-13 text-center text-xl font-bold rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-[#0B101B] text-slate-900 dark:text-white focus:outline-none focus:border-[#EE4D2D] focus:ring-1 focus:ring-[#EE4D2D]" inputmode="numeric" pattern="[0-9]*">
            </div>

            <!-- Resend Countdown Timer (Screenshot 5) -->
            <div class="text-center text-xs text-slate-500 dark:text-slate-400">
                <span id="resendCountdownContainer">
                    Mohon tunggu <strong id="countdownSec" class="text-slate-700 dark:text-slate-200">55</strong> detik untuk mengirim ulang.
                </span>
                <span id="resendActionContainer" class="hidden">
                    Tidak menerima kode? 
                    <button type="button" onclick="resendOtpCode()" class="text-[#EE4D2D] font-bold hover:underline ml-1">
                        Kirim Ulang OTP
                    </button>
                </span>
            </div>

            <!-- Button: LANJUT -->
            <button type="button" id="btnSubmitOtp" onclick="handleVerifyOtp()" class="w-full py-3.5 px-4 rounded-lg bg-[#EE4D2D] hover:bg-[#d73f1f] active:scale-[0.99] text-white font-bold text-sm tracking-wide shadow-md shadow-[#EE4D2D]/20 transition-all uppercase">
                LANJUT
            </button>
        </div>

        <!-- ======================================================== -->
        <!-- STEP 3: Buat Password & Nama Lengkap                      -->
        <!-- ======================================================== -->
        <div id="step3View" class="hidden space-y-5">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white font-['Outfit']">
                    Atur Akun Anda
                </h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Masukkan nama lengkap dan kata sandi baru untuk menyelesaikan pendaftaran.</p>
            </div>

            <form method="POST" action="{{ route('register.complete') }}" class="space-y-4">
                @csrf

                <!-- Name Field -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">
                        Nama Lengkap
                    </label>
                    <input type="text" name="name" required placeholder="Contoh: Muhammad Fawwaz"
                        class="w-full px-4 py-3 rounded-lg bg-white dark:bg-[#0B101B] border border-slate-300 dark:border-slate-700 text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-[#EE4D2D] focus:ring-1 focus:ring-[#EE4D2D]">
                </div>

                <!-- Password Field -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">
                        Kata Sandi Baru
                    </label>
                    <input type="password" name="password" required minlength="8" placeholder="Minimal 8 karakter"
                        class="w-full px-4 py-3 rounded-lg bg-white dark:bg-[#0B101B] border border-slate-300 dark:border-slate-700 text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-[#EE4D2D] focus:ring-1 focus:ring-[#EE4D2D]">
                </div>

                <!-- Confirm Password Field -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1">
                        Ulangi Kata Sandi
                    </label>
                    <input type="password" name="password_confirmation" required minlength="8" placeholder="Ulangi kata sandi di atas"
                        class="w-full px-4 py-3 rounded-lg bg-white dark:bg-[#0B101B] border border-slate-300 dark:border-slate-700 text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-[#EE4D2D] focus:ring-1 focus:ring-[#EE4D2D]">
                </div>

                <button type="submit" class="w-full py-3.5 px-4 rounded-lg bg-[#EE4D2D] hover:bg-[#d73f1f] active:scale-[0.99] text-white font-bold text-sm tracking-wide shadow-md shadow-[#EE4D2D]/20 transition-all uppercase">
                    SELESAIKAN PENDAFTARAN
                </button>
            </form>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL: PUZZLE SLIDER CAPTCHA (Screenshot 4)               -->
<!-- ======================================================== -->
<div id="puzzleModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-950/70 backdrop-blur-sm transition-opacity">
    <div class="bg-white dark:bg-[#121826] border border-slate-200 dark:border-dark-border rounded-2xl shadow-2xl w-full max-w-[340px] overflow-hidden">
        <!-- Modal Header -->
        <div class="px-5 py-3.5 flex items-center justify-between border-b border-slate-100 dark:border-dark-border/60">
            <h3 class="text-sm font-bold text-slate-800 dark:text-white">Verifikasi untuk melanjutkan</h3>
            <button type="button" onclick="closePuzzleModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 text-lg leading-none p-1">
                ✕
            </button>
        </div>

        <!-- Puzzle Image Area -->
        <div class="p-4 space-y-4">
            <div id="puzzleCanvasContainer" class="relative w-[308px] h-[160px] rounded-xl overflow-hidden shadow-inner select-none mx-auto bg-slate-800">
                <!-- Background Scenery Image -->
                <img id="puzzleBgImg" src="https://images.unsplash.com/photo-1509316975850-ff9c5deb0cd9?w=600&auto=format&fit=crop&q=80" 
                    class="w-full h-full object-cover pointer-events-none">

                <!-- Target Cutout Slot (Dotted Notch) -->
                <div id="puzzleSlot" class="absolute w-[44px] h-[44px] rounded-lg bg-black/60 border-2 border-white/80 shadow-lg"
                    style="top: 55px; left: 180px;">
                    <div class="w-full h-full flex items-center justify-center opacity-40">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                </div>

                <!-- Draggable Puzzle Piece Piece Shape -->
                <div id="puzzlePiece" class="absolute w-[44px] h-[44px] rounded-lg border-2 border-amber-300 shadow-2xl overflow-hidden cursor-grab active:cursor-grabbing z-10 bg-slate-700"
                    style="top: 55px; left: 10px;">
                    <img id="puzzlePieceImg" src="https://images.unsplash.com/photo-1509316975850-ff9c5deb0cd9?w=600&auto=format&fit=crop&q=80"
                        class="absolute w-[308px] h-[160px] max-w-none pointer-events-none"
                        style="top: -55px; left: -180px;">
                </div>

                <!-- Success Overlay -->
                <div id="puzzleSuccessOverlay" class="absolute inset-0 bg-emerald-600/90 hidden flex flex-col items-center justify-center text-white z-20">
                    <svg class="w-12 h-12 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="text-xs font-bold mt-1">Verifikasi Berhasil!</span>
                </div>
            </div>

            <!-- Slider Bar (Screenshot 4) -->
            <div id="sliderTrack" class="relative w-[308px] h-[42px] mx-auto bg-slate-100 dark:bg-slate-800/90 rounded-full border border-slate-300 dark:border-slate-700 flex items-center select-none overflow-hidden">
                <div id="sliderProgressBar" class="absolute left-0 top-0 bottom-0 bg-[#EE4D2D]/20 w-0 pointer-events-none"></div>
                <div class="w-full text-center text-xs text-slate-500 dark:text-slate-400 font-medium pointer-events-none pl-8">
                    Geser untuk menyelesaikan puzzle
                </div>
                <!-- Slider Draggable Thumb -->
                <div id="sliderThumb" class="absolute left-0 top-0 bottom-0 w-[44px] h-[42px] bg-[#EE4D2D] hover:bg-[#d73f1f] rounded-full shadow-md flex items-center justify-center text-white font-bold cursor-grab active:cursor-grabbing transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </div>
            </div>

            <!-- Bottom Tooltips & Session ID (Screenshot 4) -->
            <div class="flex items-center justify-between text-[10px] text-slate-400 dark:text-slate-500 pt-1 px-1">
                <span id="puzzleSessionId">ID: aKnzHrzqi3JfbSVq04LoHUuMU7KjoNAv</span>
                <div class="flex items-center space-x-2">
                    <button type="button" onclick="randomizePuzzle()" title="Muat ulang puzzle" class="p-1 hover:text-[#EE4D2D] transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </button>
                    <span title="Verifikasi Anti-Bot Manusia" class="p-1 cursor-help hover:text-slate-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // State Variables
    let currentEmail = '';
    let currentPhone = '';
    let targetSlotX = 180;
    let puzzleVerified = false;
    let resendTimer = null;
    let countdownSecs = 55;

    const puzzleImages = [
        'https://images.unsplash.com/photo-1509316975850-ff9c5deb0cd9?w=600&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?w=600&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1534447677768-be436bb09401?w=600&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1542751371-adc38448a05e?w=600&auto=format&fit=crop&q=80'
    ];

    function handleStep1Submit(e) {
        e.preventDefault();
        const emailInput = document.getElementById('registerEmail');
        const phoneInput = document.getElementById('registerPhone');
        currentEmail = emailInput.value.trim().toLowerCase();
        currentPhone = phoneInput.value.trim();

        if (!currentEmail || !currentEmail.includes('@')) {
            showStepAlert(1, 'Harap masukkan format alamat email yang valid.');
            return;
        }

        if (!currentPhone || currentPhone.length < 9) {
            showStepAlert(1, 'Harap masukkan nomor telepon yang valid (minimal 9-10 digit).');
            return;
        }

        // Open puzzle verification modal (Screenshot 4)
        openPuzzleModal();
    }

    function openPuzzleModal() {
        randomizePuzzle();
        document.getElementById('puzzleModal').classList.remove('hidden');
    }

    function closePuzzleModal() {
        document.getElementById('puzzleModal').classList.add('hidden');
    }

    function randomizePuzzle() {
        // Randomize target position between 120px and 240px
        targetSlotX = Math.floor(Math.random() * 120) + 120;
        const slotEl = document.getElementById('puzzleSlot');
        const pieceImg = document.getElementById('puzzlePieceImg');
        const bgImg = document.getElementById('puzzleBgImg');
        
        // Randomize image
        const randomImg = puzzleImages[Math.floor(Math.random() * puzzleImages.length)];
        bgImg.src = randomImg;
        pieceImg.src = randomImg;

        slotEl.style.left = targetSlotX + 'px';
        pieceImg.style.left = (-targetSlotX) + 'px';

        // Reset pieces & slider
        resetSliderPosition();

        // Random Session ID
        const randId = 'ID:' + Math.random().toString(36).substring(2, 12) + Math.random().toString(36).substring(2, 10);
        document.getElementById('puzzleSessionId').textContent = randId;

        document.getElementById('puzzleSuccessOverlay').classList.add('hidden');
    }

    function resetSliderPosition() {
        const thumb = document.getElementById('sliderThumb');
        const piece = document.getElementById('puzzlePiece');
        const bar = document.getElementById('sliderProgressBar');
        thumb.style.transform = 'translateX(0px)';
        piece.style.left = '10px';
        bar.style.width = '0px';
    }

    // Interactive Slider Logic
    const sliderThumb = document.getElementById('sliderThumb');
    const sliderTrack = document.getElementById('sliderTrack');
    const puzzlePiece = document.getElementById('puzzlePiece');
    const sliderProgressBar = document.getElementById('sliderProgressBar');

    let isDragging = false;
    let startX = 0;
    const maxTrackDrag = 308 - 44; // 264px

    function onDragStart(e) {
        if (puzzleVerified) return;
        isDragging = true;
        startX = (e.type === 'touchstart') ? e.touches[0].clientX : e.clientX;
    }

    function onDragMove(e) {
        if (!isDragging) return;
        const currentX = (e.type === 'touchmove') ? e.touches[0].clientX : e.clientX;
        let deltaX = currentX - startX;
        if (deltaX < 0) deltaX = 0;
        if (deltaX > maxTrackDrag) deltaX = maxTrackDrag;

        sliderThumb.style.transform = `translateX(${deltaX}px)`;
        sliderProgressBar.style.width = `${deltaX + 22}px`;

        // Map deltaX to puzzle piece position (10px to 270px)
        const pieceX = 10 + (deltaX / maxTrackDrag) * (264);
        puzzlePiece.style.left = `${pieceX}px`;
    }

    function onDragEnd() {
        if (!isDragging) return;
        isDragging = false;

        const currentPieceX = parseFloat(puzzlePiece.style.left) || 10;
        const diff = Math.abs(currentPieceX - targetSlotX);

        // Tolerance check: within 8 pixels
        if (diff <= 8) {
            // SUCCESS!
            puzzleVerified = true;
            document.getElementById('puzzleSuccessOverlay').classList.remove('hidden');

            setTimeout(() => {
                closePuzzleModal();
                dispatchOtpToEmail();
            }, 650);
        } else {
            // Failed: bounce back with small shake
            sliderThumb.style.transition = 'transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
            puzzlePiece.style.transition = 'left 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
            sliderProgressBar.style.transition = 'width 0.3s ease';

            resetSliderPosition();

            setTimeout(() => {
                sliderThumb.style.transition = '';
                puzzlePiece.style.transition = '';
                sliderProgressBar.style.transition = '';
            }, 300);
        }
    }

    sliderThumb.addEventListener('mousedown', onDragStart);
    window.addEventListener('mousemove', onDragMove);
    window.addEventListener('mouseup', onDragEnd);

    sliderThumb.addEventListener('touchstart', onDragStart, { passive: true });
    window.addEventListener('touchmove', onDragMove, { passive: true });
    window.addEventListener('touchend', onDragEnd);

    // Dispatch OTP Request via AJAX
    function dispatchOtpToEmail() {
        const btnNext = document.getElementById('btnNextStep1');
        btnNext.disabled = true;
        btnNext.innerHTML = `<span class="animate-pulse">MENGIRIM KODE OTP...</span>`;

        fetch('{{ route("register.send_otp") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                email: currentEmail,
                phone: currentPhone,
                puzzle_verified: true
            })
        })
        .then(res => res.json())
        .then(data => {
            btnNext.disabled = false;
            btnNext.innerHTML = 'BERIKUTNYA';

            if (data.success) {
                document.getElementById('targetEmailLabel').textContent = `${currentEmail} (No. HP: ${currentPhone})`;
                goToStep(2);
                startResendCountdown();

                // If in dev mode and email server is off, inform testing dev
                if (data.dev_otp) {
                    console.info('%c[DEV MODE] KODE OTP: ' + data.dev_otp, 'color: #EE4D2D; font-size: 16px; font-weight: bold;');
                    showStepAlert(2, `Kode OTP telah dikirim ke email (${currentEmail}). Untuk kemudahan testing: kode OTP Anda adalah: ${data.dev_otp}`);
                }
            } else {
                showStepAlert(1, data.message || 'Gagal mengirim kode OTP.');
                puzzleVerified = false;
            }
        })
        .catch(err => {
            btnNext.disabled = false;
            btnNext.innerHTML = 'BERIKUTNYA';
            showStepAlert(1, 'Terjadi kendala jaringan saat menghubungi server.');
            puzzleVerified = false;
        });
    }

    // Step Switching
    function goToStep(step) {
        document.getElementById('step1View').classList.add('hidden');
        document.getElementById('step2View').classList.add('hidden');
        document.getElementById('step3View').classList.add('hidden');
        document.getElementById('stepHeader').classList.add('hidden');

        if (step === 1) {
            document.getElementById('step1View').classList.remove('hidden');
        } else if (step === 2) {
            document.getElementById('stepHeader').classList.remove('hidden');
            document.getElementById('step2View').classList.remove('hidden');
            document.getElementById('badgeStep1').classList.remove('opacity-50');
            document.getElementById('badgeStep2').classList.add('opacity-50');
            document.getElementById('connector12').style.width = '0%';
            // Focus first digit box
            setTimeout(() => {
                const firstDigit = document.querySelector('.otp-digit');
                if (firstDigit) firstDigit.focus();
            }, 100);
        } else if (step === 3) {
            document.getElementById('stepHeader').classList.remove('hidden');
            document.getElementById('step3View').classList.remove('hidden');
            document.getElementById('badgeStep1').classList.remove('opacity-50');
            document.getElementById('badgeStep2').classList.remove('opacity-50');
            document.getElementById('badgeStep2').querySelector('div').className = 'w-8 h-8 rounded-full bg-emerald-500 text-white font-bold flex items-center justify-center text-sm shadow-md';
            document.getElementById('connector12').style.width = '100%';
        }
    }

    // Step Alerts
    function showStepAlert(step, msg) {
        const el = document.getElementById(`step${step}Alert`);
        if (el) {
            el.innerHTML = msg;
            el.classList.remove('hidden');
        }
    }

    // OTP Input Boxes behavior (Auto Jump & Paste)
    const otpInputs = document.querySelectorAll('.otp-digit');
    otpInputs.forEach((input, index) => {
        input.addEventListener('input', (e) => {
            const val = e.target.value;
            if (val.length === 1 && index < otpInputs.length - 1) {
                otpInputs[index + 1].focus();
            }
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !e.target.value && index > 0) {
                otpInputs[index - 1].focus();
            }
        });

        input.addEventListener('paste', (e) => {
            e.preventDefault();
            const text = (e.clipboardData || window.clipboardData).getData('text').trim();
            if (/^\d+$/.test(text)) {
                for (let i = 0; i < Math.min(text.length, otpInputs.length); i++) {
                    otpInputs[i].value = text[i];
                }
                if (text.length >= 6) {
                    otpInputs[5].focus();
                }
            }
        });
    });

    // Handle Verify OTP
    function handleVerifyOtp() {
        let code = '';
        otpInputs.forEach(i => code += i.value.trim());

        if (code.length !== 6) {
            showStepAlert(2, 'Harap lengkapi 6 digit kode OTP yang dikirimkan.');
            return;
        }

        const btn = document.getElementById('btnSubmitOtp');
        btn.disabled = true;
        btn.innerHTML = `<span class="animate-pulse">MEMVERIFIKASI...</span>`;

        fetch('{{ route("register.verify_otp") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ otp: code })
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = 'LANJUT';

            if (data.success) {
                goToStep(3);
            } else {
                showStepAlert(2, data.message || 'Kode OTP tidak valid.');
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.innerHTML = 'LANJUT';
            showStepAlert(2, 'Terjadi kesalahan sistem saat memverifikasi.');
        });
    }

    // Resend Countdown
    function startResendCountdown() {
        if (resendTimer) clearInterval(resendTimer);
        countdownSecs = 55;
        document.getElementById('resendCountdownContainer').classList.remove('hidden');
        document.getElementById('resendActionContainer').classList.add('hidden');
        document.getElementById('countdownSec').textContent = countdownSecs;

        resendTimer = setInterval(() => {
            countdownSecs--;
            document.getElementById('countdownSec').textContent = countdownSecs;
            if (countdownSecs <= 0) {
                clearInterval(resendTimer);
                document.getElementById('resendCountdownContainer').classList.add('hidden');
                document.getElementById('resendActionContainer').classList.remove('hidden');
            }
        }, 1000);
    }

    function resendOtpCode() {
        puzzleVerified = true;
        dispatchOtpToEmail();
    }
</script>
@endsection
