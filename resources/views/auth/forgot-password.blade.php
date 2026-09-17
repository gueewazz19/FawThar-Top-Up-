@extends('layouts.auth')

@section('title', 'Lupa Kata Sandi')

@section('content')
@php
    $siteName = \App\Models\Setting::get('site_name', 'Fawthar TopUp');
@endphp

<div class="max-w-[460px] mx-auto transition-all">
    <!-- Main Card -->
    <div class="bg-white dark:bg-[#121826] border border-slate-200/80 dark:border-dark-border shadow-xl rounded-2xl sm:rounded-3xl p-6 sm:p-9 transition-all relative">
        
        <!-- Header with Back Button -->
        <div class="flex items-center space-x-3 mb-6">
            <a href="{{ route('login') }}" class="p-2 rounded-xl text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-dark-surface transition-colors" title="Kembali ke Masuk">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h2 class="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white font-['Outfit']">
                    Lupa Kata Sandi
                </h2>
                <span class="text-xs text-slate-500 dark:text-slate-400">Pilih metode pemulihan akun Anda</span>
            </div>
        </div>


        <div id="forgotAlert" class="hidden mb-4 p-3 rounded-xl bg-rose-500/10 border border-rose-500/30 text-xs text-rose-500"></div>

        <!-- ======================================================== -->
        <!-- OPSI 1: AKUN GOOGLE RESMI                                -->
        <!-- ======================================================== -->
        <div class="p-4 rounded-xl bg-slate-50 dark:bg-[#0B101B] border border-slate-200 dark:border-slate-800/80 mb-6">
            <div class="flex items-start space-x-3">
                <div class="p-2 rounded-lg bg-white dark:bg-dark-card border border-slate-200 dark:border-slate-700 shadow-sm flex-shrink-0">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-xs font-bold text-slate-900 dark:text-white">Akun Google Resmi</h3>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">
                        Jika Anda mendaftar atau masuk menggunakan akun Google, kata sandi dikelola langsung oleh server Google.
                    </p>
                    <a href="https://accounts.google.com/signin/recovery" target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center space-x-1.5 mt-2.5 text-xs font-semibold text-white bg-[#4285F4] hover:bg-[#3367d6] px-3.5 py-2 rounded-lg shadow-sm transition-all">
                        <span>Pulihkan di Google Resmi</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Divider: ATAU -->
        <div class="relative my-6 text-center">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-slate-200 dark:border-dark-border"></div>
            </div>
            <span class="relative px-4 text-xs font-bold text-slate-400 uppercase bg-white dark:bg-[#121826]">
                ATAU PEMULIHAN VIA EMAIL & NO. HP
            </span>
        </div>

        <!-- ======================================================== -->
        <!-- OPSI 2: AKUN EMAIL & NO. TELEPON                         -->
        <!-- ======================================================== -->
        <form id="forgotForm" onsubmit="handleForgotSubmit(event)" class="space-y-4">
            <!-- Email Field -->
            <div>
                <label for="forgotEmail" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Alamat Email Terdaftar
                </label>
                <input id="forgotEmail" type="email" required autofocus
                    placeholder="nama@email.com"
                    class="w-full px-4 py-3 rounded-lg bg-white dark:bg-[#0B101B] border border-slate-300 dark:border-slate-700 text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-[#EE4D2D] focus:ring-1 focus:ring-[#EE4D2D] transition-colors">
            </div>

            <!-- Phone Field -->
            <div>
                <label for="forgotPhone" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Nomor Telepon / WhatsApp Terdaftar
                </label>
                <input id="forgotPhone" type="tel" required
                    placeholder="081234567890"
                    class="w-full px-4 py-3 rounded-lg bg-white dark:bg-[#0B101B] border border-slate-300 dark:border-slate-700 text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-[#EE4D2D] focus:ring-1 focus:ring-[#EE4D2D] transition-colors">
                <p class="text-[11px] text-slate-400 mt-1">Sistem akan memverifikasi kecocokan nomor telepon dan email akun Anda.</p>
            </div>

            <!-- Submit Button -->
            <button type="submit" id="btnForgotSubmit" class="w-full py-3.5 px-4 rounded-lg bg-[#EE4D2D] hover:bg-[#d73f1f] active:scale-[0.99] text-white font-bold text-sm tracking-wide shadow-md shadow-[#EE4D2D]/20 transition-all uppercase">
                KIRIM KODE OTP PEMULIHAN
            </button>
        </form>

        <!-- Bottom Link -->
        <div class="mt-6 pt-5 border-t border-slate-200 dark:border-dark-border text-center text-xs text-slate-600 dark:text-slate-400">
            Ingat kata sandi Anda?
            <a href="{{ route('login') }}" class="text-[#EE4D2D] hover:underline font-bold ml-1">
                Masuk Sekarang
            </a>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL 1: SLIDER PUZZLE CAPTCHA (Verifikasi Anti-Bot)     -->
<!-- ======================================================== -->
<div id="puzzleModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm hidden animate-fade-in">
    <div class="bg-white dark:bg-[#121826] border border-slate-200 dark:border-dark-border rounded-2xl shadow-2xl w-full max-w-[340px] p-5 relative select-none">
        
        <!-- Header Modal -->
        <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-100 dark:border-dark-border">
            <span class="text-sm font-bold text-slate-900 dark:text-white font-['Outfit']">Verifikasi untuk melanjutkan</span>
            <button type="button" onclick="closePuzzleModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 p-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Puzzle Image Area (300 x 150) -->
        <div class="relative w-[300px] h-[150px] mx-auto rounded-xl overflow-hidden bg-slate-200 dark:bg-slate-800 shadow-inner">
            <img id="puzzleBgImg" src="" alt="Background" class="w-full h-full object-cover">

            <!-- Fixed Slot Target (Hole) -->
            <div id="puzzleSlot" class="absolute top-[35px] w-[46px] h-[46px] bg-black/60 border-2 border-white/80 rounded-lg shadow-inner pointer-events-none"></div>

            <!-- Movable Floating Piece -->
            <div id="puzzlePiece" class="absolute top-[35px] left-[10px] w-[46px] h-[46px] rounded-lg shadow-2xl overflow-hidden border-2 border-white pointer-events-none z-10">
                <img id="puzzlePieceImg" src="" alt="Piece" class="absolute top-[-35px] left-[-180px] w-[300px] h-[150px] max-w-none object-cover">
            </div>

            <!-- Success Overlay Badge -->
            <div id="puzzleSuccessOverlay" class="absolute inset-0 bg-emerald-600/90 flex flex-col items-center justify-center text-white hidden transition-opacity z-20">
                <div class="w-12 h-12 rounded-full bg-white text-emerald-600 flex items-center justify-center shadow-lg mb-1 animate-bounce">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <span class="text-xs font-bold uppercase tracking-wider">Verifikasi Berhasil!</span>
            </div>
        </div>

        <!-- Slider Control Bar -->
        <div class="mt-4 relative">
            <div id="sliderTrack" class="w-[300px] h-[44px] mx-auto bg-slate-100 dark:bg-[#0B101B] border border-slate-200 dark:border-slate-800 rounded-full flex items-center px-1 relative overflow-hidden">
                <div id="sliderProgressBar" class="absolute left-0 top-0 bottom-0 bg-[#EE4D2D]/20 rounded-full w-0 pointer-events-none"></div>
                <span class="w-full text-center text-xs text-slate-400 font-medium select-none pointer-events-none pl-8">
                    Geser untuk menyelesaikan puzzle
                </span>
                
                <!-- Draggable Thumb Button -->
                <div id="sliderThumb" class="absolute left-[3px] top-[3px] bottom-[3px] w-[38px] rounded-full bg-[#EE4D2D] hover:bg-[#d73f1f] text-white flex items-center justify-center shadow-md cursor-grab active:cursor-grabbing z-10 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Footer Info & Reload -->
        <div class="flex items-center justify-between mt-4 text-[11px] text-slate-400">
            <div class="flex items-center space-x-2">
                <button type="button" onclick="randomizePuzzle()" class="hover:text-slate-600 dark:hover:text-slate-200 p-1" title="Muat ulang puzzle">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </button>
                <span id="puzzleSessionId" class="text-[10px] text-slate-400 font-mono">ID:---</span>
            </div>
            <span class="text-[10px] text-slate-400">Anti-Bot Shield</span>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL 2: VERIFIKASI 6-DIGIT OTP RESET PASSWORD          -->
<!-- ======================================================== -->
<div id="otpModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm hidden animate-fade-in">
    <div class="bg-white dark:bg-[#121826] border border-slate-200 dark:border-dark-border rounded-2xl shadow-2xl w-full max-w-[420px] p-6 sm:p-8 relative">
        <button type="button" onclick="closeOtpModal()" class="absolute right-4 top-4 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 p-1">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="text-center mb-6">
            <div class="w-12 h-12 rounded-2xl bg-[#EE4D2D]/10 text-[#EE4D2D] flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-900 dark:text-white font-['Outfit']">Masukkan Kode OTP</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                Kode OTP 6-digit telah dikirim via Email ke <br>
                <strong id="targetEmailLabel" class="text-slate-800 dark:text-slate-200"></strong>
            </p>
        </div>

        <div id="otpAlert" class="hidden mb-4 p-3 rounded-xl bg-rose-500/10 border border-rose-500/30 text-xs text-rose-500 text-center"></div>

        <!-- 6 OTP Input Boxes -->
        <div class="flex justify-center items-center space-x-2 sm:space-x-3 mb-6">
            @for ($i = 0; $i < 6; $i++)
                <input type="text" maxlength="1" inputmode="numeric"
                    class="otp-digit w-10 h-12 sm:w-12 sm:h-14 text-center text-xl font-bold rounded-xl bg-white dark:bg-[#0B101B] border-2 border-slate-300 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:border-[#EE4D2D] focus:ring-1 focus:ring-[#EE4D2D] transition-colors">
            @endfor
        </div>

        <!-- Countdown / Resend -->
        <div class="text-center text-xs mb-6">
            <div id="resendCountdownContainer" class="text-slate-500 dark:text-slate-400">
                Mohon tunggu <span id="countdownSec" class="text-[#EE4D2D] font-bold">55</span> detik untuk mengirim ulang.
            </div>
            <div id="resendActionContainer" class="hidden">
                <button type="button" onclick="resendOtpCode()" class="text-[#EE4D2D] font-bold hover:underline">
                    Kirim Ulang Kode OTP
                </button>
            </div>
        </div>

        <!-- Submit OTP Button -->
        <button type="button" id="btnSubmitOtp" onclick="handleVerifyOtp()"
            class="w-full py-3.5 px-4 rounded-lg bg-[#EE4D2D] hover:bg-[#d73f1f] active:scale-[0.99] text-white font-bold text-sm tracking-wide shadow-md shadow-[#EE4D2D]/20 transition-all uppercase">
            LANJUT KE KATA SANDI BARU
        </button>
    </div>
</div>

<script>
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

    function handleForgotSubmit(e) {
        e.preventDefault();
        const emailInput = document.getElementById('forgotEmail');
        const phoneInput = document.getElementById('forgotPhone');
        currentEmail = emailInput.value.trim().toLowerCase();
        currentPhone = phoneInput.value.trim();

        if (!currentEmail || !currentEmail.includes('@')) {
            showError('Harap masukkan alamat email yang valid.');
            return;
        }

        if (!currentPhone || currentPhone.length < 9) {
            showError('Harap masukkan nomor telepon yang valid (minimal 9 digit).');
            return;
        }

        openPuzzleModal();
    }

    function showError(msg) {
        const el = document.getElementById('forgotAlert');
        el.innerHTML = msg;
        el.classList.remove('hidden');
    }

    function openPuzzleModal() {
        randomizePuzzle();
        document.getElementById('puzzleModal').classList.remove('hidden');
    }

    function closePuzzleModal() {
        document.getElementById('puzzleModal').classList.add('hidden');
    }

    function openOtpModal() {
        document.getElementById('otpModal').classList.remove('hidden');
        document.getElementById('targetEmailLabel').textContent = `${currentEmail} (No. HP: ${currentPhone})`;
        startResendCountdown();
        setTimeout(() => {
            const firstInput = document.querySelector('.otp-digit');
            if (firstInput) firstInput.focus();
        }, 200);
    }

    function closeOtpModal() {
        document.getElementById('otpModal').classList.add('hidden');
    }

    function randomizePuzzle() {
        targetSlotX = Math.floor(Math.random() * 120) + 120;
        const slotEl = document.getElementById('puzzleSlot');
        const pieceImg = document.getElementById('puzzlePieceImg');
        const bgImg = document.getElementById('puzzleBgImg');
        
        const randomImg = puzzleImages[Math.floor(Math.random() * puzzleImages.length)];
        bgImg.src = randomImg;
        pieceImg.src = randomImg;

        slotEl.style.left = targetSlotX + 'px';
        pieceImg.style.left = (-targetSlotX) + 'px';

        resetSliderPosition();

        const randId = 'ID:' + Math.random().toString(36).substring(2, 12);
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
    const puzzlePiece = document.getElementById('puzzlePiece');
    const sliderProgressBar = document.getElementById('sliderProgressBar');

    let isDragging = false;
    let startX = 0;
    const maxTrackDrag = 300 - 44;

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

        const pieceX = 10 + (deltaX / maxTrackDrag) * (260);
        puzzlePiece.style.left = `${pieceX}px`;
    }

    function onDragEnd() {
        if (!isDragging) return;
        isDragging = false;

        const currentPieceX = parseFloat(puzzlePiece.style.left) || 10;
        const diff = Math.abs(currentPieceX - targetSlotX);

        if (diff <= 8) {
            puzzleVerified = true;
            document.getElementById('puzzleSuccessOverlay').classList.remove('hidden');

            setTimeout(() => {
                closePuzzleModal();
                dispatchResetOtp();
            }, 650);
        } else {
            sliderThumb.style.transition = 'transform 0.3s ease';
            puzzlePiece.style.transition = 'left 0.3s ease';
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

    // Send Reset OTP via AJAX
    function dispatchResetOtp() {
        const btn = document.getElementById('btnForgotSubmit');
        btn.disabled = true;
        btn.innerHTML = '<span class="animate-pulse">MEMVERIFIKASI & MENGIRIM OTP...</span>';

        fetch('{{ route("password.send_otp") }}', {
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
            btn.disabled = false;
            btn.innerHTML = 'KIRIM KODE OTP PEMULIHAN';

            if (data.success) {
                openOtpModal();
                if (data.dev_otp) {
                    console.info('%c[DEV MODE] OTP RESET: ' + data.dev_otp, 'color: #EE4D2D; font-size: 16px; font-weight: bold;');
                    const alertEl = document.getElementById('otpAlert');
                    alertEl.innerHTML = `Kode OTP terkirim ke email (${currentEmail}). Untuk kemudahan testing: ${data.dev_otp}`;
                    alertEl.classList.remove('hidden');
                }
            } else {
                showError(data.message || 'Gagal mengirim kode OTP pemulihan.');
                puzzleVerified = false;
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.innerHTML = 'KIRIM KODE OTP PEMULIHAN';
            showError('Terjadi kendala jaringan saat menghubungi server.');
            puzzleVerified = false;
        });
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

    // Handle Verify Reset OTP
    function handleVerifyOtp() {
        let code = '';
        otpInputs.forEach(i => code += i.value.trim());

        if (code.length !== 6) {
            const el = document.getElementById('otpAlert');
            el.innerHTML = 'Harap lengkapi 6 digit kode OTP yang dikirimkan.';
            el.classList.remove('hidden');
            return;
        }

        const btn = document.getElementById('btnSubmitOtp');
        btn.disabled = true;
        btn.innerHTML = '<span class="animate-pulse">MEMVERIFIKASI...</span>';

        fetch('{{ route("password.verify_otp") }}', {
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
            btn.innerHTML = 'LANJUT KE KATA SANDI BARU';

            if (data.success && data.redirect) {
                window.location.href = data.redirect;
            } else {
                const el = document.getElementById('otpAlert');
                el.innerHTML = data.message || 'Kode OTP tidak valid.';
                el.classList.remove('hidden');
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.innerHTML = 'LANJUT KE KATA SANDI BARU';
            const el = document.getElementById('otpAlert');
            el.innerHTML = 'Terjadi kesalahan sistem saat memverifikasi.';
            el.classList.remove('hidden');
        });
    }

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
        dispatchResetOtp();
    }
</script>
@endsection
