@php
    $siteName = \App\Models\Setting::get('site_name', 'GameTopUp');
    $siteLogo = \App\Models\Setting::get('site_logo');
    $supportWhatsapp = \App\Models\Setting::get('support_whatsapp', '+628123456789');
    $currentLocale = app()->getLocale();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Autentikasi') - {{ $siteName }}</title>

    <!-- Anti-Clickjacking & Frame protection fallback -->
    <style id="antiClickjack">body{display:none !important;}</style>
    <script>
        if (self === top) {
            var antiClickjack = document.getElementById("antiClickjack");
            antiClickjack.parentNode.removeChild(antiClickjack);
        } else {
            top.location = self.location;
        }
    </script>

    <!-- Theme Initialization (Prevents FOUC) -->
    <script>
        if (localStorage.theme === 'light' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: light)').matches)) {
            document.documentElement.classList.remove('dark');
        } else {
            document.documentElement.classList.add('dark');
        }
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@600;700;800;900&display=swap" rel="stylesheet">

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900 dark:bg-[#080C14] dark:text-slate-100 min-h-screen flex flex-col antialiased selection:bg-emerald-500 selection:text-slate-950 relative transition-colors duration-200">
    <!-- Ambient Background Glow -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-cyan-500/10 rounded-full blur-3xl"></div>
    </div>

    <!-- Marketplace-Style Top Navbar -->
    <header class="w-full bg-white/90 dark:bg-dark-surface/90 backdrop-blur-md border-b border-slate-200 dark:border-dark-border relative z-20 py-4 px-4 sm:px-8">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <!-- Brand Logo & Page Title -->
            <div class="flex items-center space-x-3 sm:space-x-4">
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    @if($siteLogo)
                        <img src="{{ $siteLogo }}" alt="{{ $siteName }}" class="w-10 h-10 rounded-xl object-contain shadow-md">
                    @else
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-500/25 group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6 text-slate-950 font-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                    @endif
                    <div class="flex flex-col">
                        <span class="text-xl sm:text-2xl font-black tracking-tight text-slate-900 dark:text-white font-['Outfit'] group-hover:text-emerald-500 transition-colors">
                            {{ $siteName }}
                        </span>
                        <span class="text-[10px] text-slate-500 dark:text-slate-400 font-semibold tracking-wider uppercase -mt-1">
                            {{ __('Authentication Center') }}
                        </span>
                    </div>
                </a>
            </div>

            <!-- Navbar Right Actions -->
            <div class="flex items-center space-x-2 sm:space-x-3">
                <!-- Customer Support Link -->
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $supportWhatsapp) }}" target="_blank" rel="noopener noreferrer"
                    class="hidden sm:inline-flex items-center space-x-1.5 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 px-3 py-1.5 rounded-xl hover:bg-slate-100 dark:hover:bg-dark-card transition-colors">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span>Butuh Bantuan?</span>
                </a>

                <!-- Language Switcher -->
                <a href="{{ route('locale.switch', $currentLocale === 'id' ? 'en' : 'id') }}" 
                    title="{{ $currentLocale === 'id' ? 'Switch to English' : 'Ganti ke Bahasa Indonesia' }}"
                    class="inline-flex items-center space-x-1 px-2.5 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-dark-surface dark:hover:bg-dark-hover border border-slate-300/80 dark:border-dark-border text-xs font-bold text-slate-700 dark:text-slate-200 transition-all shadow-sm">
                    <span>{{ $currentLocale === 'id' ? '🇮🇩 ID' : '🇬🇧 EN' }}</span>
                </a>

                <!-- Dark / Light Mode Toggle Button -->
                <button id="authThemeToggle" type="button" aria-label="Ganti Tema"
                    class="p-2 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-dark-surface dark:hover:bg-dark-hover border border-slate-300/80 dark:border-dark-border text-slate-700 dark:text-slate-200 transition-all shadow-sm">
                    <svg class="w-4 h-4 hidden dark:block text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <svg class="w-4 h-4 block dark:hidden text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content Container with Split Layout -->
    <main class="flex-grow flex items-center justify-center p-4 sm:p-6 lg:p-8 relative z-10">
        <div class="max-w-6xl w-full mx-auto grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
            
            <!-- Left Column: Marketplace Gaming Showcase Banner -->
            <div class="hidden lg:flex lg:col-span-6 flex-col justify-center space-y-6 pr-4">
                <div class="space-y-3">
                    <span class="inline-flex items-center space-x-2 px-3 py-1 rounded-full text-xs font-bold bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 border border-indigo-500/30">
                        <span>✨ Platform Top Up Game #1 Indonesia</span>
                    </span>
                    <h1 class="text-3xl xl:text-4xl font-black text-slate-900 dark:text-white font-['Outfit'] leading-tight">
                        Beli Voucher Game Favoritmu dengan <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">Harga Termurah</span> & Pengiriman Instan!
                    </h1>
                    <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                        Nikmati kemudahan transaksi top up game 24 jam nonstop dengan sistem otomatis tercanggih dan perlindungan akun maksimal.
                    </p>
                </div>

                <!-- 3 Key Value Propositions -->
                <div class="grid grid-cols-1 gap-3.5 pt-2">
                    <div class="flex items-center space-x-3.5 p-3.5 rounded-2xl bg-white/70 dark:bg-dark-surface/50 border border-slate-200 dark:border-dark-border shadow-sm">
                        <div class="w-10 h-10 rounded-xl bg-amber-500/15 text-amber-500 flex items-center justify-center font-bold flex-shrink-0">
                            ⚡
                        </div>
                        <div>
                            <div class="text-sm font-bold text-slate-900 dark:text-white">Pengisian Kilat 1-3 Detik</div>
                            <div class="text-xs text-slate-500 dark:text-slate-400">Pesanan diproses otomatis via server direct API tanpa delay</div>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3.5 p-3.5 rounded-2xl bg-white/70 dark:bg-dark-surface/50 border border-slate-200 dark:border-dark-border shadow-sm">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500/15 text-emerald-500 flex items-center justify-center font-bold flex-shrink-0">
                            🛡️
                        </div>
                        <div>
                            <div class="text-sm font-bold text-slate-900 dark:text-white">100% Legal & Bergaransi</div>
                            <div class="text-xs text-slate-500 dark:text-slate-400">Semua voucher resmi bersumber dari publisher game</div>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3.5 p-3.5 rounded-2xl bg-white/70 dark:bg-dark-surface/50 border border-slate-200 dark:border-dark-border shadow-sm">
                        <div class="w-10 h-10 rounded-xl bg-indigo-500/15 text-indigo-500 flex items-center justify-center font-bold flex-shrink-0">
                            💳
                        </div>
                        <div>
                            <div class="text-sm font-bold text-slate-900 dark:text-white">Metode Pembayaran Lengkap</div>
                            <div class="text-xs text-slate-500 dark:text-slate-400">QRIS, BCA, Mandiri, BRI, BNI, GoPay, OVO, Dana & ShopeePay</div>
                        </div>
                    </div>
                </div>

                <!-- Trusted By Gamers Badge Bar -->
                <div class="pt-2 flex items-center space-x-4 text-xs font-semibold text-slate-500 dark:text-slate-400">
                    <span class="flex items-center space-x-1">
                        <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>256-bit SSL Protection</span>
                    </span>
                    <span class="flex items-center space-x-1">
                        <svg class="w-4 h-4 text-cyan-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>Automated Fulfillment</span>
                    </span>
                </div>
            </div>

            <!-- Right Column: Interactive Auth Form Card -->
            <div class="lg:col-span-6 w-full max-w-lg mx-auto">
                <!-- Flash Notification Error -->
                @if(session('error'))
                    <div class="bg-rose-100 dark:bg-rose-950/80 border border-rose-300 dark:border-rose-500/40 text-rose-800 dark:text-rose-200 px-4 py-3 rounded-xl flex items-center space-x-3 shadow-lg mb-4 text-sm">
                        <svg class="w-5 h-5 text-rose-500 dark:text-rose-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')

                <!-- Back to Home Link -->
                <div class="mt-4 text-center text-xs text-slate-500">
                    <a href="{{ route('home') }}" class="hover:text-emerald-500 dark:hover:text-emerald-400 transition-colors inline-flex items-center space-x-1 font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span>{{ __('Kembali ke Beranda') }}</span>
                    </a>
                </div>
            </div>

        </div>
    </main>

    <!-- Marketplace-Style Footer -->
    <footer class="w-full border-t border-slate-200 dark:border-dark-border py-4 px-4 text-center text-xs text-slate-500 dark:text-slate-400 relative z-10">
        <p>&copy; {{ date('Y') }} {{ $siteName }}. {{ __('All rights reserved.') }}</p>
    </footer>

    <script>
        document.getElementById('authThemeToggle')?.addEventListener('click', function () {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            }
        });
    </script>
</body>
</html>
