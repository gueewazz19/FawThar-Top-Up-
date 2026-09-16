<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Control Center - {{ config('app.name', 'GameTopUp') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@600;700;800;900&display=swap" rel="stylesheet">

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#080C15] text-slate-100 min-h-screen flex antialiased selection:bg-brand-500 selection:text-white">
    <!-- Admin Sidebar -->
    <aside class="w-64 bg-[#0E1524] border-r border-dark-border flex flex-col flex-shrink-0 min-h-screen sticky top-0">
        <!-- Brand Header -->
        <div class="h-20 flex items-center px-6 border-b border-dark-border">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-amber-500 to-orange-600 flex items-center justify-center text-white font-bold shadow-md shadow-amber-500/20">
                    AD
                </div>
                <div class="flex flex-col">
                    <span class="text-lg font-black text-white font-['Outfit']">Admin Panel</span>
                    <span class="text-[10px] text-amber-400 font-semibold tracking-wider uppercase">GameTopUp Ops</span>
                </div>
            </a>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-grow p-4 space-y-1.5 overflow-y-auto">
            <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider px-3 py-2">Ringkasan</div>
            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('admin.dashboard*') ? 'bg-amber-500/15 text-amber-300 border border-amber-500/30 font-semibold' : 'text-slate-400 hover:text-white hover:bg-dark-card' }} transition-colors">
                <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                <span>Dashboard</span>
            </a>

            <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider px-3 pt-4 pb-1">Katalog & Produk</div>
            <a href="{{ route('admin.games.index') }}" class="flex items-center space-x-3 px-3.5 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('admin.games*') ? 'bg-cyan-500/15 text-cyan-300 border border-cyan-500/30 font-semibold' : 'text-slate-400 hover:text-white hover:bg-dark-card' }} transition-colors">
                <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5" />
                </svg>
                <span>Kelola Game</span>
            </a>
            <a href="{{ route('admin.products.index') }}" class="flex items-center space-x-3 px-3.5 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('admin.products*') ? 'bg-emerald-500/15 text-emerald-300 border border-emerald-500/30 font-semibold' : 'text-slate-400 hover:text-white hover:bg-dark-card' }} transition-colors">
                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Paket Top-Up</span>
            </a>

            <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider px-3 pt-4 pb-1">Transaksi & Fulfillment</div>
            <a href="{{ route('admin.orders.index') }}" class="flex items-center space-x-3 px-3.5 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('admin.orders*') ? 'bg-blue-500/15 text-blue-300 border border-blue-500/30 font-semibold' : 'text-slate-400 hover:text-white hover:bg-dark-card' }} transition-colors">
                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                <span>Semua Pesanan</span>
            </a>

            <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider px-3 pt-4 pb-1">Sistem & Keamanan</div>
            <a href="{{ route('admin.activity-logs.index') }}" class="flex items-center space-x-3 px-3.5 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('admin.activity-logs*') ? 'bg-rose-500/15 text-rose-300 border border-rose-500/30 font-semibold' : 'text-slate-400 hover:text-white hover:bg-dark-card' }} transition-colors">
                <svg class="w-5 h-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <span>Audit & WAF Shield</span>
            </a>
            <a href="{{ route('admin.settings.index') }}" class="flex items-center space-x-3 px-3.5 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('admin.settings*') ? 'bg-indigo-500/15 text-indigo-300 border border-indigo-500/30 font-semibold' : 'text-slate-400 hover:text-white hover:bg-dark-card' }} transition-colors">
                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>Pengaturan Situs</span>
            </a>
        </nav>

        <!-- Admin Profile Footer -->
        <div class="p-4 border-t border-dark-border bg-[#0a101d]">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3 truncate">
                    <div class="w-9 h-9 rounded-xl bg-amber-500/20 text-amber-400 font-bold flex items-center justify-center text-xs border border-amber-500/30">
                        {{ strtoupper(substr(auth()->user()->name ?? 'AD', 0, 2)) }}
                    </div>
                    <div class="flex flex-col truncate">
                        <span class="text-xs font-semibold text-white truncate">{{ auth()->user()->name ?? 'Admin' }}</span>
                        <span class="text-[10px] text-amber-400 font-medium">Administrator</span>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" title="Keluar" class="p-2 text-slate-400 hover:text-rose-400 rounded-lg hover:bg-dark-surface transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>
            </div>
            <div class="mt-3 pt-3 border-t border-dark-border/60">
                <a href="{{ route('home') }}" class="text-xs text-brand-400 hover:underline flex items-center space-x-1">
                    <span>Lihat Toko Publik</span>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>
            </div>
        </div>
    </aside>

    <!-- Main Admin Area -->
    <div class="flex-grow flex flex-col min-w-0">
        <!-- Top Navigation Bar -->
        <header class="h-20 bg-[#0E1524]/90 backdrop-blur-md border-b border-dark-border px-8 flex items-center justify-between sticky top-0 z-30">
            <div class="flex items-center space-x-4">
                <h2 class="text-xl font-bold text-white font-['Outfit']">@yield('page_title', 'Dashboard')</h2>
            </div>
            <div class="flex items-center space-x-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/30">
                    ● Server Aktif
                </span>
                <div class="text-xs text-slate-400">
                    {{ now()->translatedFormat('l, d F Y') }}
                </div>
            </div>
        </header>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mx-8 mt-6 bg-emerald-950/80 border border-emerald-500/40 text-emerald-200 px-4 py-3 rounded-xl flex items-center space-x-3 text-sm">
                <svg class="w-5 h-5 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mx-8 mt-6 bg-rose-950/80 border border-rose-500/40 text-rose-200 px-4 py-3 rounded-xl flex items-center space-x-3 text-sm">
                <svg class="w-5 h-5 text-rose-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Admin Content Area -->
        <main class="flex-grow p-8">
            @yield('content')
        </main>
    </div>
</body>
</html>
