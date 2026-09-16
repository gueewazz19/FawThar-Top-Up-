<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GameTopUp') }} - Top Up Game Cepat, Murah & Terpercaya</title>
    <meta name="description" content="Platform top up voucher dan game credits Mobile Legends, Free Fire, PUBG Mobile, Valorant, dan Genshin Impact resmi dan terpercaya.">

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
<body class="bg-slate-50 text-slate-900 dark:bg-[#080C14] dark:text-slate-100 min-h-screen flex flex-col antialiased selection:bg-emerald-500 selection:text-slate-950 transition-colors duration-200">
    <!-- Ambient Background Lighting with Slow Pulse -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl animate-pulse-slow"></div>
        <div class="absolute top-1/3 -right-40 w-96 h-96 bg-cyan-500/10 rounded-full blur-3xl animate-pulse-slow" style="animation-delay: 2s;"></div>
        <div class="absolute -bottom-40 left-1/3 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl animate-pulse-slow" style="animation-delay: 4s;"></div>
    </div>

    <!-- Header / Navbar -->
    <header class="glass-nav">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Brand Logo -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                        <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-500/25 group-hover:scale-105 transition-transform">
                            <svg class="w-6 h-6 text-slate-950 font-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-2xl font-black tracking-tight text-slate-900 dark:text-white font-['Outfit'] group-hover:text-emerald-500 transition-colors">
                                Game<span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-cyan-500">TopUp</span>
                            </span>
                            <span class="text-[10px] text-slate-500 dark:text-slate-400 font-semibold tracking-widest uppercase -mt-1">Digital Game Store</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links with ScrollSpy & Dynamic Green Active Pill -->
                <nav id="navbar-links" class="hidden md:flex items-center p-1.5 rounded-2xl bg-slate-100/80 dark:bg-dark-surface/60 border border-slate-200 dark:border-dark-border/60 space-x-1">
                    <a href="{{ url('/#hero') }}" data-target="hero" class="nav-pill active">
                        Beranda
                    </a>
                    <a href="{{ url('/#games') }}" data-target="games" class="nav-pill">
                        Daftar Game
                    </a>
                    <a href="{{ url('/#promo') }}" data-target="promo" class="nav-pill">
                        Promo
                    </a>
                    <a href="{{ url('/#how-it-works') }}" data-target="how-it-works" class="nav-pill">
                        Cara Top Up
                    </a>
                    <a href="{{ url('/#faq') }}" data-target="faq" class="nav-pill">
                        FAQ
                    </a>
                </nav>

                <!-- Auth, Theme Switcher & Mobile Actions -->
                <div class="flex items-center space-x-2.5 sm:space-x-3">
                    <!-- Dark / Light Mode Toggle Button -->
                    <button id="themeToggleBtn" type="button" aria-label="Ganti Tema Gelap / Terang" title="Ganti Mode Terang / Gelap"
                        class="p-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-dark-surface dark:hover:bg-dark-hover border border-slate-300/80 dark:border-dark-border text-slate-700 dark:text-slate-200 hover:text-emerald-600 dark:hover:text-emerald-400 transition-all hover:scale-105 active:scale-95 shadow-sm">
                        <!-- Sun Icon (appears when in Dark mode, click to make Light) -->
                        <svg id="themeSunIcon" class="w-5 h-5 hidden dark:block text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <!-- Moon Icon (appears when in Light mode, click to make Dark) -->
                        <svg id="themeMoonIcon" class="w-5 h-5 block dark:hidden text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>

                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center space-x-2 px-3.5 py-2 rounded-xl text-xs font-bold text-amber-600 dark:text-amber-300 bg-amber-500/10 border border-amber-500/30 hover:bg-amber-500/20 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="hidden sm:inline">Admin Panel</span>
                            </a>
                        @endif

                        <div class="relative group">
                            <a href="{{ route('dashboard') }}" class="flex items-center space-x-2.5 py-1.5 px-3 rounded-xl bg-slate-100 dark:bg-dark-card border border-slate-200 dark:border-dark-border hover:border-emerald-500/40 transition-colors">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-emerald-500 to-teal-600 flex items-center justify-center text-xs font-extrabold text-slate-950">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                </div>
                                <div class="hidden sm:flex flex-col text-left">
                                    <span class="text-xs font-semibold text-slate-900 dark:text-white leading-tight truncate max-w-[100px]">{{ auth()->user()->name }}</span>
                                    <span class="text-[10px] text-slate-500 dark:text-slate-400 capitalize">{{ auth()->user()->role }}</span>
                                </div>
                            </a>
                        </div>

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" title="Keluar" class="p-2.5 text-slate-500 hover:text-rose-500 dark:text-slate-400 dark:hover:text-rose-400 rounded-xl hover:bg-slate-100 dark:hover:bg-dark-surface border border-transparent hover:border-slate-200 dark:hover:border-dark-border transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn-secondary text-xs sm:text-sm">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="btn-primary text-xs sm:text-sm">
                            Daftar
                        </a>
                    @endauth

                    <!-- Mobile Menu Hamburger Button -->
                    <button id="mobileMenuBtn" type="button" class="md:hidden p-2.5 rounded-xl bg-slate-100 dark:bg-dark-surface border border-slate-200 dark:border-dark-border text-slate-700 dark:text-slate-300 hover:text-emerald-500" aria-label="Buka Menu Navigasi">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Navigation Drawer -->
            <div id="mobileMenu" class="hidden md:hidden pb-4 pt-2 border-t border-slate-200 dark:border-dark-border/60">
                <nav class="flex flex-col space-y-1">
                    <a href="{{ url('/#hero') }}" data-target="hero" class="nav-pill active text-left">
                        Beranda
                    </a>
                    <a href="{{ url('/#games') }}" data-target="games" class="nav-pill text-left">
                        Daftar Game
                    </a>
                    <a href="{{ url('/#promo') }}" data-target="promo" class="nav-pill text-left">
                        Promo
                    </a>
                    <a href="{{ url('/#how-it-works') }}" data-target="how-it-works" class="nav-pill text-left">
                        Cara Top Up
                    </a>
                    <a href="{{ url('/#faq') }}" data-target="faq" class="nav-pill text-left">
                        FAQ
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Flash Notifications -->
    @if(session('success') || session('error') || session('info') || $errors->any())
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 relative z-10">
            @if(session('success'))
                <div class="bg-emerald-50 dark:bg-emerald-950/80 border border-emerald-300 dark:border-emerald-500/40 text-emerald-800 dark:text-emerald-200 px-4 py-3 rounded-xl flex items-center space-x-3 shadow-lg mb-4">
                    <svg class="w-5 h-5 text-emerald-500 dark:text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-rose-50 dark:bg-rose-950/80 border border-rose-300 dark:border-rose-500/40 text-rose-800 dark:text-rose-200 px-4 py-3 rounded-xl flex items-center space-x-3 shadow-lg mb-4">
                    <svg class="w-5 h-5 text-rose-500 dark:text-rose-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm font-medium">{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-rose-50 dark:bg-rose-950/80 border border-rose-300 dark:border-rose-500/40 text-rose-800 dark:text-rose-200 px-4 py-3 rounded-xl shadow-lg mb-4">
                    <div class="flex items-center space-x-2 font-semibold text-sm mb-1 text-rose-700 dark:text-rose-300">
                        <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span>Mohon periksa kembali input Anda:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs space-y-0.5 text-rose-700 dark:text-rose-300">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    @endif

    <!-- Main Body Content -->
    <main class="flex-grow relative z-10">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-dark-surface/90 border-t border-slate-200 dark:border-dark-border mt-20 relative z-10 transition-colors duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Brand Info -->
                <div class="md:col-span-2 space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-lg bg-gradient-to-tr from-emerald-500 to-teal-600 flex items-center justify-center text-slate-950 font-black">
                            GT
                        </div>
                        <span class="text-2xl font-black text-slate-900 dark:text-white font-['Outfit']">
                            Game<span class="text-emerald-500 dark:text-emerald-400">TopUp</span>
                        </span>
                    </div>
                    <p class="text-slate-600 dark:text-slate-400 text-sm max-w-md leading-relaxed">
                        Platform top up voucher dan game online terpercaya di Indonesia. Dapatkan pengisian instan otomatis 24 jam dengan berbagai metode pembayaran aman dan harga kompetitif.
                    </p>
                    <div class="flex items-center space-x-4 pt-2">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/30">
                            ● Sistem Otomatis 24 Jam
                        </span>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 border border-cyan-500/30">
                            🛡️ 100% Legal & Aman
                        </span>
                    </div>
                </div>

                <!-- Navigation Quick Links -->
                <div>
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-4 font-['Outfit']">Navigasi Cepat</h4>
                    <ul class="space-y-2 text-sm text-slate-600 dark:text-slate-400">
                        <li><a href="{{ url('/#games') }}" class="hover:text-emerald-500 dark:hover:text-emerald-400 transition-colors">Semua Game</a></li>
                        <li><a href="{{ url('/#promo') }}" class="hover:text-emerald-500 dark:hover:text-emerald-400 transition-colors">Promo & Diskon</a></li>
                        <li><a href="{{ url('/#how-it-works') }}" class="hover:text-emerald-500 dark:hover:text-emerald-400 transition-colors">Panduan Top Up</a></li>
                        <li><a href="{{ url('/#faq') }}" class="hover:text-emerald-500 dark:hover:text-emerald-400 transition-colors">Pertanyaan Umum (FAQ)</a></li>
                    </ul>
                </div>

                <!-- Customer Care & Security -->
                <div>
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-4 font-['Outfit']">Bantuan & Kontak</h4>
                    <ul class="space-y-2 text-sm text-slate-600 dark:text-slate-400">
                        <li>Email: <span class="text-slate-800 dark:text-slate-300">support@gametopup.test</span></li>
                        <li>WhatsApp: <span class="text-slate-800 dark:text-slate-300">+62 812-3456-7890</span></li>
                        <li>Jam Operasional: <span class="text-emerald-600 dark:text-emerald-400 font-medium">24/7 Nonstop</span></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-slate-200 dark:border-dark-border mt-10 pt-6 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} GameTopUp. Seluruh hak cipta dilindungi undang-undang.</p>
                <p class="mt-2 sm:mt-0">Semua logo dan merek dagang game merupakan properti dari masing-masing penerbit resmi.</p>
            </div>
        </div>
    </footer>

    <!-- Interactive Theme Switcher, ScrollSpy & Mobile Navigation Controller -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Theme Switcher Logic
            const themeToggleBtn = document.getElementById('themeToggleBtn');
            if (themeToggleBtn) {
                themeToggleBtn.addEventListener('click', () => {
                    if (document.documentElement.classList.contains('dark')) {
                        document.documentElement.classList.remove('dark');
                        localStorage.theme = 'light';
                    } else {
                        document.documentElement.classList.add('dark');
                        localStorage.theme = 'dark';
                    }
                });
            }

            // ScrollSpy Navigation
            const navLinks = document.querySelectorAll('.nav-pill');
            const sectionIds = ['hero', 'games', 'promo', 'how-it-works', 'faq'];
            const sections = sectionIds.map(id => document.getElementById(id)).filter(Boolean);
            let isManualScroll = false;
            let scrollTimer = null;

            // Mobile menu toggle
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const mobileMenu = document.getElementById('mobileMenu');
            if (mobileMenuBtn && mobileMenu) {
                mobileMenuBtn.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                });
            }

            function setActive(targetId) {
                navLinks.forEach(link => {
                    if (link.getAttribute('data-target') === targetId) {
                        link.classList.add('active');
                    } else {
                        link.classList.remove('active');
                    }
                });
            }

            // Click listener on nav links: immediate active pill update + smooth scroll
            navLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    const targetId = link.getAttribute('data-target');
                    const targetEl = document.getElementById(targetId);
                    
                    if (targetEl) {
                        e.preventDefault();
                        setActive(targetId);
                        isManualScroll = true;
                        clearTimeout(scrollTimer);

                        const headerHeight = 85;
                        const elementPosition = targetEl.getBoundingClientRect().top + window.pageYOffset;
                        const offsetPosition = elementPosition - headerHeight;

                        window.scrollTo({
                            top: Math.max(0, offsetPosition),
                            behavior: 'smooth'
                        });

                        // Release lock after smooth scroll completes
                        scrollTimer = setTimeout(() => {
                            isManualScroll = false;
                        }, 800);

                        // Close mobile drawer if open
                        if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                            mobileMenu.classList.add('hidden');
                        }
                    }
                });
            });

            // Scroll listener: update the green pill according to which section is currently in view
            function handleScroll() {
                if (isManualScroll) return;

                const scrollY = window.pageYOffset;
                const headerOffset = 130;
                let currentSectionId = 'hero';

                for (let i = 0; i < sections.length; i++) {
                    const section = sections[i];
                    const top = section.offsetTop - headerOffset;
                    const height = section.offsetHeight;

                    if (scrollY >= top && scrollY < top + height) {
                        currentSectionId = section.id;
                        break;
                    }
                }

                // If scrolled near bottom of page, highlight the last section (e.g. FAQ)
                if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 80) {
                    if (sections.length > 0) {
                        currentSectionId = sections[sections.length - 1].id;
                    }
                }

                setActive(currentSectionId);
            }

            window.addEventListener('scroll', handleScroll, { passive: true });
            handleScroll(); // Trigger immediately on initial load
        });
    </script>
</body>
</html>
