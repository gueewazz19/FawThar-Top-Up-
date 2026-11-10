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

    <!-- Custom CSS for Auth since Tailwind JIT might not be running -->
    <style>
        .glass-card {
            background-color: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
        }
        html.dark .glass-card {
            background-color: rgba(18, 24, 38, 0.85); /* #121826 with 85% opacity */
        }
        .glass-input {
            background-color: #ffffff !important;
            padding-left: 2.75rem !important; /* 44px so text never collides with icon */
            position: relative;
            z-index: 1;
            color: #0f172a !important;
            font-size: 0.8125rem !important; /* 13px: agak kecil dikit */
            font-weight: 600 !important; /* di bold */
            letter-spacing: 0.01em;
        }
        .glass-input::placeholder {
            font-size: 0.8125rem !important;
            font-weight: 600 !important;
            color: #94a3b8 !important;
            opacity: 1 !important;
        }
        html.dark .glass-input::placeholder {
            color: #64748b !important;
        }
        html.dark .glass-input {
            background-color: #0f172a !important;
            border-color: #334155 !important;
            color: #f8fafc !important;
        }
        /* Override browser autofill (Chrome/Edge blue/yellow background) */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 1000px #ffffff inset !important;
            box-shadow: 0 0 0 1000px #ffffff inset !important;
            -webkit-text-fill-color: #0f172a !important;
            transition: background-color 5000s ease-in-out 0s;
        }
        html.dark input:-webkit-autofill,
        html.dark input:-webkit-autofill:hover, 
        html.dark input:-webkit-autofill:focus, 
        html.dark input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 1000px #0f172a inset !important;
            box-shadow: 0 0 0 1000px #0f172a inset !important;
            -webkit-text-fill-color: #ffffff !important;
        }
        .text-brand {
            color: #6366f1 !important;
        }
        .text-brand:hover {
            color: #4f46e5 !important;
        }
        html.dark .text-brand {
            color: #818cf8 !important;
        }
        .bg-brand {
            background: linear-gradient(180deg, #4f46e5 0%, #4338ca 100%) !important;
            color: #ffffff !important;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.25), 0 4px 14px -2px rgba(79, 70, 229, 0.4) !important;
        }
        .bg-brand:hover {
            background: linear-gradient(180deg, #6366f1 0%, #4f46e5 100%) !important;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.3), 0 6px 22px rgba(79, 70, 229, 0.5) !important;
        }
        .border-brand {
            border-color: #6366f1 !important;
        }
        .ring-brand:focus {
            --tw-ring-color: rgba(99, 102, 241, 0.2) !important;
            --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
            --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(4px + var(--tw-ring-offset-width)) var(--tw-ring-color);
            box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000);
            border-color: #6366f1 !important;
        }
        /* Royal Indigo / Ungu Button matching Guest Primary Button */
        .btn-auth-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            position: relative;
            width: 100%;
            padding: 0.875rem 1rem;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            font-weight: 700;
            letter-spacing: 0.025em;
            color: #ffffff !important;
            background: linear-gradient(180deg, #4f46e5 0%, #4338ca 100%) !important;
            border: 1px solid rgba(165, 180, 252, 0.35) !important;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.25), 0 4px 14px -2px rgba(79, 70, 229, 0.4) !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            text-decoration: none;
            overflow: hidden;
        }
        .btn-auth-primary:hover {
            background: linear-gradient(180deg, #6366f1 0%, #4f46e5 100%) !important;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.3), 0 6px 22px rgba(79, 70, 229, 0.5) !important;
            transform: translateY(-1px);
        }
        .btn-auth-primary:active {
            transform: translateY(1px) scale(0.99);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.15), 0 2px 8px rgba(79, 70, 229, 0.35) !important;
        }
        html.dark .btn-auth-primary {
            background: linear-gradient(180deg, #6366f1 0%, #4f46e5 100%) !important;
            border-color: rgba(199, 210, 254, 0.3) !important;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 4px 20px rgba(99, 102, 241, 0.45) !important;
        }
        html.dark .btn-auth-primary:hover {
            background: linear-gradient(180deg, #818cf8 0%, #6366f1 100%) !important;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.25), 0 6px 28px rgba(99, 102, 241, 0.6) !important;
        }
        /* Reliable, High-Contrast Icon Wrapper */
        .input-wrapper {
            position: relative;
            display: block;
        }
        .input-icon-wrapper {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            width: 2.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
            z-index: 10 !important;
            color: #64748b; /* crisp slate-500 in light mode */
            transition: color 0.2s ease-in-out;
        }
        html.dark .input-icon-wrapper {
            color: #94a3b8; /* clear slate-400 in dark mode */
        }
        .input-wrapper:focus-within .input-icon-wrapper {
            color: #6366f1 !important;
        }
        .input-icon-wrapper svg {
            width: 1.25rem;
            height: 1.25rem;
            display: block;
        }
        .password-toggle-btn {
            position: absolute;
            right: 0.5rem;
            top: 0;
            bottom: 0;
            display: flex;
            align-items: center;
            z-index: 10 !important;
        }
        /* Hide Microsoft Edge / IE native eye icon to prevent duplicate eye buttons */
        input::-ms-reveal,
        input::-ms-clear,
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
        }
    </style>
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
                            Pusat Autentikasi Pengguna
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
        <div class="w-full flex items-center justify-center">
            
            <!-- Right Column: Interactive Auth Form Card -->
            <div class="w-full max-w-md mx-auto">
                <!-- Flash Notification Error -->
                @if(session('error'))
                    <div class="bg-rose-50 dark:bg-rose-950/80 border border-rose-300 dark:border-rose-500/40 text-rose-800 dark:text-rose-200 px-4 py-3 rounded-xl flex items-center space-x-3 shadow-lg mb-4 text-sm">
                        <svg class="w-5 h-5 text-rose-500 dark:text-rose-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Flash Notification Success -->
                @if(session('success'))
                    <div class="bg-emerald-50 dark:bg-emerald-950/80 border border-emerald-300 dark:border-emerald-500/40 text-emerald-800 dark:text-emerald-200 px-4 py-3 rounded-xl flex items-center space-x-3 shadow-lg mb-4 text-sm">
                        <svg class="w-5 h-5 text-emerald-500 dark:text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ session('success') }}</span>
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

        function togglePasswordVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            if (!input) return;
            const icon = btn.querySelector('.eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                if (icon) {
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />';
                }
                btn.title = 'Sembunyikan sandi';
            } else {
                input.type = 'password';
                if (icon) {
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
                }
                btn.title = 'Tampilkan sandi';
            }
        }
    </script>
</body>
</html>
