@extends('layouts.app')

@section('title', 'Profil Pengguna - ' . config('app.name', 'GameTopUp'))

@section('content')
<div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
    <!-- Breadcrumb -->
    <nav class="flex items-center space-x-2 text-xs text-slate-500 dark:text-slate-400">
        <a href="{{ route('home') }}" class="hover:text-emerald-500 transition-colors">Beranda</a>
        <span>/</span>
        <span class="text-slate-900 dark:text-white font-semibold">Profil Saya</span>
    </nav>

    <!-- Profile Header Card -->
    <div class="glass-card p-6 sm:p-8 border-slate-200 dark:border-dark-border/80 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 relative overflow-hidden">
        <div class="absolute -right-16 -top-16 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="flex items-center space-x-5 z-10">
            <!-- Gamer Avatar with Initials -->
            <div class="w-20 h-20 rounded-2xl bg-gradient-to-tr from-indigo-600 via-indigo-500 to-cyan-400 flex items-center justify-center text-white font-black text-2xl shadow-xl shadow-indigo-500/20 border-2 border-white/20 flex-shrink-0">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>

            <div class="space-y-1">
                <div class="flex items-center space-x-3 flex-wrap gap-y-1">
                    <h1 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white font-['Outfit']">
                        {{ $user->name }}
                    </h1>
                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-black uppercase tracking-wider border {{ $stats['loyalty_tier']['badge'] }}">
                        <span class="mr-1">{{ $stats['loyalty_tier']['icon'] }}</span>
                        <span>{{ $stats['loyalty_tier']['name'] }}</span>
                    </span>
                </div>
                <div class="text-xs text-slate-500 dark:text-slate-400 flex items-center space-x-3">
                    <span>{{ $user->email }}</span>
                    <span>•</span>
                    <span>Bergabung {{ $user->created_at->translatedFormat('d F Y') }}</span>
                </div>
                @if($user->phone)
                    <div class="text-xs text-slate-500 dark:text-slate-400">
                        WhatsApp: <strong class="text-slate-700 dark:text-slate-300 font-mono">{{ $user->phone }}</strong>
                    </div>
                @endif
            </div>
        </div>

        <div class="flex items-center space-x-2 z-10">
            <a href="{{ route('dashboard') }}" class="btn-secondary text-xs px-4 py-2.5 flex items-center space-x-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <span>Riwayat Pesanan</span>
            </a>
        </div>
    </div>

    <!-- User KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="glass-card p-5 border-slate-200 dark:border-dark-border/80">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Transaksi</span>
            <div class="text-2xl font-black text-slate-900 dark:text-white font-['Outfit'] mt-2">
                {{ $stats['total_orders'] }} Pesanan
            </div>
            <div class="text-[11px] text-slate-400 mt-0.5">Semua riwayat pengisian</div>
        </div>

        <div class="glass-card p-5 border-slate-200 dark:border-dark-border/80">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Transaksi Sukses</span>
            <div class="text-2xl font-black text-emerald-500 font-['Outfit'] mt-2">
                {{ $stats['successful_orders'] }} Sukses
            </div>
            <div class="text-[11px] text-slate-400 mt-0.5">Diamond berhasil terkirim</div>
        </div>

        <div class="glass-card p-5 border-slate-200 dark:border-dark-border/80">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Belanja</span>
            <div class="text-2xl font-black text-indigo-600 dark:text-indigo-400 font-['Outfit'] mt-2">
                Rp {{ number_format($stats['total_spent'], 0, ',', '.') }}
            </div>
            <div class="text-[11px] text-slate-400 mt-0.5">Akumulasi pengeluaran akun</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Forms Column (7 cols) -->
        <div class="lg:col-span-7 space-y-8">
            <!-- Edit Profile Form -->
            <div class="glass-card p-6 sm:p-8 border-slate-200 dark:border-dark-border/80 space-y-5">
                <h3 class="text-base font-bold text-slate-900 dark:text-white font-['Outfit'] flex items-center space-x-2">
                    <span class="p-1.5 rounded-lg bg-indigo-500/10 text-indigo-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </span>
                    <span>Informasi Biodata & Kontak</span>
                </h3>

                <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="form-label text-xs font-bold text-slate-700 dark:text-slate-300">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="form-input text-sm w-full">
                    </div>

                    <div>
                        <label class="form-label text-xs font-bold text-slate-700 dark:text-slate-300">Alamat Email</label>
                        <input type="email" value="{{ $user->email }}" disabled class="form-input text-sm w-full bg-slate-100 dark:bg-slate-900/60 opacity-70 cursor-not-allowed">
                        <p class="text-[11px] text-slate-400 mt-1">Email akun terdaftar tidak dapat diubah demi keamanan akun.</p>
                    </div>

                    <div>
                        <label class="form-label text-xs font-bold text-slate-700 dark:text-slate-300">Nomor WhatsApp</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 081234567890" class="form-input text-sm w-full">
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="btn-primary text-xs px-5 py-2.5">
                            Simpan Perubahan Biodata
                        </button>
                    </div>
                </form>
            </div>

            <!-- Change Password Form -->
            <div class="glass-card p-6 sm:p-8 border-slate-200 dark:border-dark-border/80 space-y-5">
                <h3 class="text-base font-bold text-slate-900 dark:text-white font-['Outfit'] flex items-center space-x-2">
                    <span class="p-1.5 rounded-lg bg-amber-500/10 text-amber-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </span>
                    <span>Keamanan Akun & Ganti Kata Sandi</span>
                </h3>

                <form method="POST" action="{{ route('profile.password') }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="form-label text-xs font-bold text-slate-700 dark:text-slate-300">Kata Sandi Saat Ini</label>
                        <input type="password" name="current_password" required placeholder="Masukkan kata sandi saat ini" class="form-input text-sm w-full">
                        @error('current_password')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label text-xs font-bold text-slate-700 dark:text-slate-300">Kata Sandi Baru</label>
                            <input type="password" name="password" required minlength="8" placeholder="Minimal 8 karakter" class="form-input text-sm w-full">
                            @error('password')
                                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label text-xs font-bold text-slate-700 dark:text-slate-300">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" name="password_confirmation" required minlength="8" placeholder="Ulangi kata sandi baru" class="form-input text-sm w-full">
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="btn-primary text-xs px-5 py-2.5">
                            Perbarui Kata Sandi
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Recent Orders Sidebar (5 cols) -->
        <div class="lg:col-span-5 space-y-6">
            <div class="glass-card p-6 border-slate-200 dark:border-dark-border/80 space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-bold text-slate-900 dark:text-white font-['Outfit']">Pesanan Terbaru</h3>
                    <a href="{{ route('dashboard') }}" class="text-xs text-indigo-500 hover:underline">Semua</a>
                </div>

                <div class="divide-y divide-slate-200 dark:divide-dark-border/40">
                    @forelse($recentOrders as $order)
                        <div class="py-3.5 flex items-center justify-between text-xs">
                            <div>
                                <div class="font-bold text-slate-900 dark:text-white">{{ $order->game->name ?? 'Game' }}</div>
                                <div class="text-[11px] text-slate-400 font-mono">{{ $order->order_number }}</div>
                                <div class="text-[10px] text-slate-500 mt-0.5">{{ $order->created_at->diffForHumans() }}</div>
                            </div>
                            <div class="text-right space-y-1">
                                <div class="font-black text-slate-900 dark:text-white">{{ $order->formatted_total }}</div>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $order->status->badgeClass() }}">
                                    {{ $order->status->label() }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="py-8 text-center text-slate-400 text-xs">
                            Belum ada pesanan yang tercatat.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
