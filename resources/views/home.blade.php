@extends('layouts.app')

@section('content')
<!-- Hero Section with Smooth Staggered Entrance Animations -->
<section id="hero" class="relative pt-12 pb-20 lg:pt-20 lg:pb-28 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <!-- Left Hero Content -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                <!-- Entrance Item 1: Pill Badge -->
                <div class="inline-flex items-center space-x-2 px-4 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 text-xs font-bold text-emerald-600 dark:text-emerald-400 shadow-sm animate-fade-in-up">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 dark:bg-emerald-400 animate-pulse"></span>
                    <span>Platform Top Up Game Terpercaya #1</span>
                </div>

                <!-- Entrance Item 2: Heading -->
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 dark:text-white tracking-tight leading-tight font-['Outfit'] animate-fade-in-up anim-delay-100">
                    Top Up Game Favoritmu, <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 via-teal-400 to-cyan-500 dark:from-emerald-400 dark:via-teal-300 dark:to-cyan-400">
                        Kilat & 100% Aman
                    </span>
                </h1>

                <!-- Entrance Item 3: Subtitle -->
                <p class="text-base sm:text-lg text-slate-600 dark:text-slate-300 max-w-xl mx-auto lg:mx-0 leading-relaxed font-normal animate-fade-in-up anim-delay-200">
                    Beli Diamond Mobile Legends, Free Fire, UC PUBG Mobile, dan game populer lainnya dengan harga termurah. Proses otomatis 24 jam nonstop langsung ke akun!
                </p>

                <!-- Entrance Item 4: CTA Action Buttons (Handcrafted, Non-AI) -->
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start space-y-3 sm:space-y-0 sm:space-x-4 pt-2 animate-fade-in-up anim-delay-300">
                    <a href="#games" class="btn-primary w-full sm:w-auto text-base px-8 py-3.5 group">
                        <span>Top Up Sekarang</span>
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                    <a href="#games" class="btn-secondary w-full sm:w-auto text-base px-6 py-3.5">
                        <svg class="w-5 h-5 mr-2 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <span>Cari Game</span>
                    </a>
                </div>

                <!-- Entrance Item 5: Trust Badges -->
                <div class="pt-6 grid grid-cols-3 gap-4 border-t border-slate-200 dark:border-dark-border/80 max-w-md mx-auto lg:mx-0 animate-fade-in-up anim-delay-400">
                    <div>
                        <div class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white font-['Outfit']">99.9%</div>
                        <div class="text-xs text-slate-500 dark:text-slate-400">Transaksi Sukses</div>
                    </div>
                    <div>
                        <div class="text-xl sm:text-2xl font-black text-emerald-500 dark:text-emerald-400 font-['Outfit']">&lt; 3 Mnt</div>
                        <div class="text-xs text-slate-500 dark:text-slate-400">Proses Kilat</div>
                    </div>
                    <div>
                        <div class="text-xl sm:text-2xl font-black text-cyan-600 dark:text-cyan-400 font-['Outfit']">24/7</div>
                        <div class="text-xs text-slate-500 dark:text-slate-400">Layanan Otomatis</div>
                    </div>
                </div>
            </div>

            <!-- Right Hero Visual Card with Smooth Slide-In from Side & Float Effect -->
            <div class="lg:col-span-5 relative animate-slide-in-right anim-delay-200">
                <div class="relative mx-auto max-w-sm lg:max-w-none animate-float">
                    <!-- Glow behind card -->
                    <div class="absolute -inset-1.5 bg-gradient-to-r from-emerald-500/30 to-teal-500/20 rounded-3xl blur-xl opacity-60"></div>
                    
                    <div class="glass-card p-6 border-slate-200/80 dark:border-dark-border relative space-y-5 shadow-2xl">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Game Terpopuler Hari Ini</span>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-500/15 text-amber-600 dark:text-amber-400 border border-amber-500/30 shadow-sm">
                                HOT DEAL 🔥
                            </span>
                        </div>

                        <!-- Featured Showcase Game -->
                        @if($popularGames->isNotEmpty())
                            @php $featured = $popularGames->first(); @endphp
                            <div class="flex items-center space-x-4 p-3.5 rounded-2xl bg-slate-100/90 dark:bg-[#0B101D] border border-slate-200 dark:border-dark-border">
                                <img src="{{ $featured->logo }}" alt="{{ $featured->name }}" class="w-16 h-16 rounded-xl object-cover border border-slate-200 dark:border-dark-border shadow-md">
                                <div>
                                    <h3 class="text-base font-bold text-slate-900 dark:text-white font-['Outfit']">{{ $featured->name }}</h3>
                                    <p class="text-xs text-emerald-600 dark:text-emerald-400 font-semibold">{{ $featured->category->name ?? 'Mobile Game' }}</p>
                                    <div class="flex items-center space-x-1.5 text-[11px] text-slate-500 dark:text-slate-400 mt-1">
                                        <svg class="w-3.5 h-3.5 text-emerald-500 dark:text-emerald-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        <span>Item otomatis langsung masuk</span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="space-y-2">
                            <div class="text-xs font-semibold text-slate-700 dark:text-slate-300">Pilihan Nominal Cepat:</div>
                            <div class="grid grid-cols-2 gap-2.5">
                                <div class="p-3 rounded-xl bg-slate-100 dark:bg-[#0B101D] border border-slate-200 dark:border-dark-border text-left hover:border-slate-400 dark:hover:border-slate-600 transition-colors">
                                    <div class="text-xs font-bold text-slate-900 dark:text-white">86 Diamonds</div>
                                    <div class="text-xs text-emerald-600 dark:text-emerald-400 font-bold mt-0.5">Rp 21.000</div>
                                </div>
                                <div class="p-3 rounded-xl bg-slate-100 dark:bg-[#0B101D] border border-indigo-500/40 text-left relative shadow-sm">
                                    <span class="absolute -top-2 right-2 text-[9px] bg-indigo-600 text-white font-black px-2 py-0.5 rounded-full uppercase tracking-wider shadow-sm">Populer</span>
                                    <div class="text-xs font-bold text-slate-900 dark:text-white">172 Diamonds</div>
                                    <div class="text-xs text-emerald-600 dark:text-emerald-400 font-bold mt-0.5">Rp 42.000</div>
                                </div>
                            </div>
                        </div>

                        <a href="#games" class="btn-primary w-full py-3 text-sm">
                            Lihat Semua Game & Nominal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Active Promotions Section -->
@if($promotions->isNotEmpty())
<section id="promo" class="py-16 border-t border-slate-200 dark:border-dark-border/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <div class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 text-xs font-bold uppercase tracking-wider mb-2 border border-emerald-500/20">
                    <span>🎉 Penawaran Terbatas</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white font-['Outfit']">Promo Spesial Hari Ini</h2>
                <p class="text-sm text-slate-600 dark:text-slate-400">Gunakan promo dan voucher untuk harga top up lebih hemat.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($promotions as $promo)
                <div class="glass-card overflow-hidden group flex flex-col sm:flex-row border-slate-200 dark:border-dark-border/80 hover:border-emerald-500/40 transition-all">
                    @if($promo->image)
                        <div class="sm:w-1/3 h-40 sm:h-auto overflow-hidden relative bg-slate-100 dark:bg-dark-bg">
                            <img src="{{ $promo->image }}" alt="{{ $promo->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 dark:from-dark-surface sm:hidden"></div>
                        </div>
                    @endif
                    <div class="p-6 sm:w-2/3 flex flex-col justify-between space-y-3">
                        <div>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-500/15 text-emerald-700 dark:text-emerald-300 border border-emerald-500/30">
                                Diskon {{ $promo->discount_type === 'percentage' ? $promo->discount_value . '%' : 'Rp ' . number_format($promo->discount_value, 0, ',', '.') }}
                            </span>
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white font-['Outfit'] mt-2">{{ $promo->title }}</h3>
                            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed mt-1">{{ $promo->description }}</p>
                        </div>
                        <div class="text-[11px] text-slate-500 pt-2 border-t border-slate-200 dark:border-dark-border/60">
                            Berlaku s/d: <span class="text-slate-700 dark:text-slate-300 font-medium">{{ $promo->end_date->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Games Catalog Section -->
<section id="games" class="py-16 border-t border-slate-200 dark:border-dark-border/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center max-w-2xl mx-auto mb-10 space-y-3">
            <div class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 text-xs font-bold uppercase tracking-wider border border-cyan-500/20">
                <span>⚡ Katalog Lengkap</span>
            </div>
            <h2 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white font-['Outfit']">Pilih Game Favoritmu</h2>
            <p class="text-slate-600 dark:text-slate-400 text-sm sm:text-base">Pilih game di bawah ini untuk memulai pengisian diamond atau currency game Anda secara instan.</p>
        </div>

        <!-- Search Bar -->
        <div class="max-w-md mx-auto mb-10">
            <div class="relative">
                <input id="gameSearch" type="text" placeholder="Cari nama game (e.g. Mobile Legends, Valorant)..."
                    class="form-input pl-11 pr-4 py-3.5 text-sm bg-white dark:bg-[#0E1524] border-slate-300 dark:border-dark-border shadow-md dark:shadow-lg focus:border-emerald-500 text-slate-900 dark:text-white placeholder-slate-400"
                    onkeyup="filterGames()">
                <svg class="w-5 h-5 text-slate-400 absolute left-4 top-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>

        <!-- Games Grid -->
        <div id="gamesGrid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            @forelse($popularGames as $game)
                <div class="game-item glass-card glass-card-hover overflow-hidden group flex flex-col justify-between border-slate-200/90 dark:border-dark-border"
                    data-name="{{ strtolower($game->name) }}" data-category="{{ strtolower($game->category->name ?? '') }}">
                    
                    <div>
                        <!-- Game Cover Image -->
                        <div class="aspect-[4/3] w-full overflow-hidden relative bg-slate-100 dark:bg-dark-bg">
                            <img src="{{ $game->logo }}" alt="{{ $game->name }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 dark:from-dark-surface via-transparent to-transparent opacity-85"></div>
                            <span class="absolute top-2.5 left-2.5 px-2.5 py-0.5 rounded-lg text-[10px] font-bold bg-slate-900/80 dark:bg-dark-bg/85 backdrop-blur-md text-emerald-300 border border-slate-700 dark:border-dark-border">
                                {{ $game->category->name ?? 'Game' }}
                            </span>
                        </div>

                        <!-- Game Details -->
                        <div class="p-4">
                            <h3 class="text-base font-bold text-slate-900 dark:text-white group-hover:text-emerald-500 dark:group-hover:text-emerald-400 transition-colors font-['Outfit'] truncate">
                                {{ $game->name }}
                            </h3>
                            <p class="text-xs text-slate-600 dark:text-slate-400 line-clamp-2 mt-1 leading-relaxed">
                                {{ $game->description }}
                            </p>
                        </div>
                    </div>

                    <!-- Top Up Action Button -->
                    <div class="p-4 pt-0">
                        @guest
                            <button type="button" onclick="openGuestLoginModal('{{ addslashes($game->name) }}')" class="btn-primary w-full py-2.5 text-xs text-center flex items-center justify-center space-x-1 cursor-pointer">
                                <span>Top Up Sekarang</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </button>
                        @else
                            <a href="{{ route('topup.show', $game->slug) }}" class="btn-primary w-full py-2.5 text-xs text-center flex items-center justify-center space-x-1">
                                <span>Top Up Sekarang</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        @endguest
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-slate-500 dark:text-slate-400">
                    Belum ada game aktif di database.
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section id="how-it-works" class="py-16 bg-slate-100/60 dark:bg-[#0B101D]/70 border-t border-slate-200 dark:border-dark-border/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12 space-y-3">
            <div class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 text-xs font-bold uppercase tracking-wider border border-emerald-500/20">
                <span>📖 Panduan</span>
            </div>
            <h2 class="text-3xl font-black text-slate-900 dark:text-white font-['Outfit']">Cara Melakukan Top Up</h2>
            <p class="text-slate-600 dark:text-slate-400 text-sm">Hanya butuh 5 langkah mudah untuk mengisi saldo game Anda dalam hitungan detik.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
            <div class="glass-card p-6 text-center space-y-3 border-slate-200 dark:border-dark-border/80 hover:border-emerald-500/40 transition-colors">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 font-black text-lg flex items-center justify-center mx-auto border border-emerald-500/30">
                    1
                </div>
                <h4 class="text-sm font-bold text-slate-900 dark:text-white font-['Outfit']">Pilih Game</h4>
                <p class="text-xs text-slate-600 dark:text-slate-400">Tentukan game yang ingin Anda top-up dari katalog kami.</p>
            </div>

            <div class="glass-card p-6 text-center space-y-3 border-slate-200 dark:border-dark-border/80 hover:border-emerald-500/40 transition-colors">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 font-black text-lg flex items-center justify-center mx-auto border border-emerald-500/30">
                    2
                </div>
                <h4 class="text-sm font-bold text-slate-900 dark:text-white font-['Outfit']">Masukkan ID</h4>
                <p class="text-xs text-slate-600 dark:text-slate-400">Input Player ID atau UID game Anda secara akurat.</p>
            </div>

            <div class="glass-card p-6 text-center space-y-3 border-slate-200 dark:border-dark-border/80 hover:border-emerald-500/40 transition-colors">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 font-black text-lg flex items-center justify-center mx-auto border border-emerald-500/30">
                    3
                </div>
                <h4 class="text-sm font-bold text-slate-900 dark:text-white font-['Outfit']">Pilih Nominal</h4>
                <p class="text-xs text-slate-600 dark:text-slate-400">Pilih paket currency atau item yang ingin Anda beli.</p>
            </div>

            <div class="glass-card p-6 text-center space-y-3 border-slate-200 dark:border-dark-border/80 hover:border-emerald-500/40 transition-colors">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 font-black text-lg flex items-center justify-center mx-auto border border-emerald-500/30">
                    4
                </div>
                <h4 class="text-sm font-bold text-slate-900 dark:text-white font-['Outfit']">Bayar Pesanan</h4>
                <p class="text-xs text-slate-600 dark:text-slate-400">Pilih metode pembayaran (QRIS, VA, E-Wallet) dan selesaikan.</p>
            </div>

            <div class="glass-card p-6 text-center space-y-3 border-slate-200 dark:border-dark-border/80 hover:border-emerald-500/40 transition-colors">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500 text-slate-950 font-black text-lg flex items-center justify-center mx-auto shadow-glow-emerald">
                    5
                </div>
                <h4 class="text-sm font-bold text-slate-900 dark:text-white font-['Outfit']">Item Masuk</h4>
                <p class="text-xs text-slate-600 dark:text-slate-400">Sistem otomatis langsung mengirimkan item ke akun game Anda!</p>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
@if($faqs->isNotEmpty())
<section id="faq" class="py-16 border-t border-slate-200 dark:border-dark-border/60">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 space-y-3">
            <div class="inline-flex items-center space-x-1.5 px-3 py-1 rounded-full bg-cyan-500/10 text-cyan-600 dark:text-cyan-400 text-xs font-bold uppercase tracking-wider border border-cyan-500/20">
                <span>💬 FAQ</span>
            </div>
            <h2 class="text-3xl font-black text-slate-900 dark:text-white font-['Outfit']">Pertanyaan yang Sering Diajukan</h2>
            <p class="text-slate-600 dark:text-slate-400 text-sm">Temukan jawaban cepat atas pertanyaan seputar layanan dan pembayaran kami.</p>
        </div>

        <div class="space-y-4">
            @foreach($faqs as $faq)
                <div class="glass-card p-6 border-slate-200 dark:border-dark-border/80 hover:border-slate-400 dark:hover:border-slate-600 transition-colors">
                    <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center space-x-3 font-['Outfit']">
                        <span class="w-6 h-6 rounded-lg bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 font-black flex items-center justify-center text-xs flex-shrink-0 border border-emerald-500/30">Q</span>
                        <span>{{ $faq->question }}</span>
                    </h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400 mt-3 pl-9 leading-relaxed">
                        {{ $faq->answer }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Guest Login Prompt Modal (Muncul saat user belum login mengklik 'Top Up Sekarang') -->
@guest
<div id="guestLoginModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-950/75 backdrop-blur-md flex items-center justify-center p-4 transition-all duration-300" onclick="handleBackdropClick(event)">
    <div class="relative w-full max-w-md bg-white dark:bg-[#0B101D] border border-slate-200/90 dark:border-slate-800/90 rounded-3xl shadow-2xl dark:shadow-[0_20px_60px_rgba(0,0,0,0.85)] p-6 sm:p-8 text-center overflow-hidden transform transition-all">
        <!-- Ambient Glow Elements behind card content -->
        <div class="absolute -top-16 -left-16 w-36 h-36 bg-emerald-500/10 dark:bg-emerald-500/15 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -bottom-16 -right-16 w-36 h-36 bg-indigo-500/10 dark:bg-indigo-500/15 rounded-full blur-2xl pointer-events-none"></div>

        <!-- Close Button (Tanda Silang X) -->
        <button type="button" onclick="closeGuestLoginModal()" class="absolute top-4 right-4 p-2 rounded-xl text-slate-400 hover:text-slate-700 dark:hover:text-white bg-slate-100/80 hover:bg-slate-200/80 dark:bg-slate-800/60 dark:hover:bg-slate-700/80 border border-slate-200/60 dark:border-slate-700/50 transition-all duration-200 group" title="Tutup Pop Up" aria-label="Tutup Pop Up">
            <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="relative space-y-5">
            <!-- Glowing 3D-effect Lock Badge with Ambient Ring -->
            <div class="relative mx-auto w-20 h-20 flex items-center justify-center">
                <div class="absolute inset-0 rounded-2xl bg-gradient-to-tr from-emerald-500 to-indigo-600 opacity-20 dark:opacity-30 blur-lg animate-pulse"></div>
                <div class="relative w-16 h-16 rounded-2xl bg-gradient-to-b from-indigo-50 to-emerald-50/40 dark:from-[#151F36] dark:to-[#0C1220] border border-indigo-200/80 dark:border-indigo-500/30 flex items-center justify-center shadow-lg shadow-indigo-500/10 dark:shadow-indigo-500/20">
                    <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
            </div>

            <!-- Title & Status Pill -->
            <div class="space-y-2">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/25">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-ping"></span>
                    <span>Akses Transaksi Akun</span>
                </div>

                <h3 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white font-['Outfit'] tracking-tight">
                    Login Terlebih Dahulu
                </h3>

                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed max-w-sm mx-auto">
                    Untuk melakukan transaksi top up game <span id="modalGameTarget" class="font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded-md border border-emerald-500/20"></span> dan memastikan pesanan tercatat aman, silakan masuk ke akun Anda.
                </p>
            </div>

            <!-- Micro-Perks / Trust Points -->
            <div class="grid grid-cols-3 gap-2 py-3 px-2 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200/70 dark:border-slate-800/80 text-[11px] font-medium text-slate-600 dark:text-slate-300">
                <div class="flex flex-col items-center gap-1 text-center">
                    <span class="text-base">⚡</span>
                    <span class="font-semibold text-slate-800 dark:text-slate-200">1-3 Detik</span>
                    <span class="text-[10px] text-slate-500">Proses Kilat</span>
                </div>
                <div class="flex flex-col items-center gap-1 text-center border-x border-slate-200 dark:border-slate-800">
                    <span class="text-base">🛡️</span>
                    <span class="font-semibold text-slate-800 dark:text-slate-200">100% Legal</span>
                    <span class="text-[10px] text-slate-500">Aman Terjamin</span>
                </div>
                <div class="flex flex-col items-center gap-1 text-center">
                    <span class="text-base">🎁</span>
                    <span class="font-semibold text-slate-800 dark:text-slate-200">Poin & Promo</span>
                    <span class="text-[10px] text-slate-500">Reward Khusus</span>
                </div>
            </div>

            <!-- Action CTA Buttons -->
            <div class="space-y-2.5 pt-1">
                <a href="{{ route('login') }}" class="w-full py-3 px-5 rounded-xl font-bold text-sm text-white bg-gradient-to-r from-indigo-600 via-indigo-700 to-indigo-800 hover:from-indigo-500 hover:to-indigo-700 shadow-md shadow-indigo-600/30 hover:shadow-indigo-600/50 hover:-translate-y-0.5 active:translate-y-0 transition-all flex items-center justify-center gap-2 group">
                    <span>Masuk / Login Sekarang</span>
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
                <a href="{{ route('register') }}" class="w-full py-2.5 px-4 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white bg-slate-100 hover:bg-slate-200/80 dark:bg-slate-800/70 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-700 transition-all block text-center">
                    Belum Punya Akun? <span class="text-indigo-600 dark:text-indigo-400 font-bold underline decoration-indigo-400/40 underline-offset-2">Daftar Akun Baru</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endguest

<script>
    function filterGames() {
        const query = document.getElementById('gameSearch').value.toLowerCase();
        const items = document.querySelectorAll('.game-item');

        items.forEach(item => {
            const name = item.getAttribute('data-name');
            const category = item.getAttribute('data-category');
            if (name.includes(query) || category.includes(query)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    }

    function openGuestLoginModal(gameName) {
        const modal = document.getElementById('guestLoginModal');
        const targetEl = document.getElementById('modalGameTarget');
        if (targetEl) {
            targetEl.textContent = gameName ? `"${gameName}"` : '';
        }
        if (modal) {
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }
    }

    function closeGuestLoginModal() {
        const modal = document.getElementById('guestLoginModal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    }

    function handleBackdropClick(event) {
        if (event.target === document.getElementById('guestLoginModal')) {
            closeGuestLoginModal();
        }
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeGuestLoginModal();
        }
    });
</script>
@endsection
