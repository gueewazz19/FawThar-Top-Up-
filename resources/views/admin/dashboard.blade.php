@extends('layouts.admin')

@section('page_title', 'Ringkasan & Statistik Sistem')

@section('content')
<div class="space-y-8">
    <!-- Top KPI Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Revenue Card -->
        <div class="glass-card p-6 border-dark-border/80 bg-[#121B2F]/80">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pendapatan</span>
                <span class="p-2 rounded-xl bg-emerald-500/10 text-emerald-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-emerald-400 font-['Outfit'] mt-3 truncate">
                Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}
            </div>
            <div class="text-xs text-slate-500 mt-1">Akumulasi pesanan berstatus Sukses</div>
        </div>

        <!-- Total Orders Card -->
        <div class="glass-card p-6 border-dark-border/80 bg-[#121B2F]/80">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pesanan</span>
                <span class="p-2 rounded-xl bg-blue-500/10 text-blue-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </span>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-white font-['Outfit'] mt-3">
                {{ number_format($stats['total_orders'], 0, ',', '.') }}
            </div>
            <div class="text-xs text-slate-500 mt-1">Hari ini: <strong class="text-slate-300">{{ $stats['orders_today'] }}</strong> pesanan</div>
        </div>

        <!-- Success vs Fail Card -->
        <div class="glass-card p-6 border-dark-border/80 bg-[#121B2F]/80">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tingkat Keberhasilan</span>
                <span class="p-2 rounded-xl bg-cyan-500/10 text-cyan-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-cyan-400 font-['Outfit'] mt-3">
                {{ $stats['successful_orders'] }}
                <span class="text-xs font-normal text-slate-400">/ {{ $stats['failed_orders'] }} gagal</span>
            </div>
            <div class="text-xs text-slate-500 mt-1">
                Rasio Sukses: 
                <strong class="text-emerald-400">
                    {{ $stats['total_orders'] > 0 ? round(($stats['successful_orders'] / $stats['total_orders']) * 100, 1) : 100 }}%
                </strong>
            </div>
        </div>

        <!-- Registered Users Card -->
        <div class="glass-card p-6 border-dark-border/80 bg-[#121B2F]/80">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pengguna Terdaftar</span>
                <span class="p-2 rounded-xl bg-purple-500/10 text-purple-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </span>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-purple-300 font-['Outfit'] mt-3">
                {{ $stats['total_users'] }}
            </div>
            <div class="text-xs text-slate-500 mt-1">{{ $stats['total_games'] }} game aktif di katalog</div>
        </div>
    </div>

    <!-- Main Grid: Recent Orders and Popular Games -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Recent Orders (8 cols) -->
        <div class="lg:col-span-8 glass-card p-6 border-dark-border/80 bg-[#121B2F]/80">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-white font-['Outfit']">Pesanan Masuk Terkini</h3>
                    <p class="text-xs text-slate-400">Audit transaksi dan pemantauan status fulfillment game.</p>
                </div>
                <a href="{{ url('/admin/orders') }}" class="btn-secondary text-xs px-3.5 py-2">
                    Lihat Semua
                </a>
            </div>

            @if($recentOrders->isEmpty())
                <div class="text-center py-12 text-slate-500 text-sm">
                    Belum ada data pesanan di sistem.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="border-b border-dark-border text-slate-400 text-xs uppercase tracking-wider font-semibold">
                                <th class="py-3 px-3">No. Pesanan</th>
                                <th class="py-3 px-3">Pelanggan</th>
                                <th class="py-3 px-3">Game</th>
                                <th class="py-3 px-3">Total</th>
                                <th class="py-3 px-3">Status</th>
                                <th class="py-3 px-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-dark-border/60">
                            @foreach($recentOrders as $order)
                                <tr class="hover:bg-dark-surface/50 transition-colors">
                                    <td class="py-3 px-3 font-mono font-semibold text-xs text-amber-300">
                                        {{ $order->order_number }}
                                    </td>
                                    <td class="py-3 px-3 text-slate-200">
                                        {{ $order->user->name ?? 'Guest/User' }}
                                    </td>
                                    <td class="py-3 px-3 text-white font-medium">
                                        {{ $order->game->name ?? '-' }}
                                    </td>
                                    <td class="py-3 px-3 font-bold text-white">
                                        {{ $order->formatted_total }}
                                    </td>
                                    <td class="py-3 px-3">
                                        <span class="badge-status {{ $order->status->badgeClass() }}">
                                            {{ $order->status->label() }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-3 text-right">
                                        <a href="{{ url('/admin/orders/' . $order->order_number) }}" class="btn-secondary text-xs px-2.5 py-1">
                                            Audit
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Popular Games Ranking (4 cols) -->
        <div class="lg:col-span-4 glass-card p-6 border-dark-border/80 bg-[#121B2F]/80 flex flex-col justify-between">
            <div>
                <h3 class="text-lg font-bold text-white font-['Outfit'] mb-1">Game Terlaris</h3>
                <p class="text-xs text-slate-400 mb-6">Peringkat game berdasarkan volume transaksi.</p>

                <div class="space-y-4">
                    @forelse($popularGames as $index => $g)
                        <div class="flex items-center justify-between p-3 rounded-xl bg-dark-bg/60 border border-dark-border/60">
                            <div class="flex items-center space-x-3">
                                <span class="w-6 h-6 rounded-lg bg-dark-surface text-slate-400 font-bold text-xs flex items-center justify-center">
                                    {{ $index + 1 }}
                                </span>
                                <img src="{{ $g->logo }}" alt="{{ $g->name }}" class="w-8 h-8 rounded-lg object-cover">
                                <div>
                                    <div class="text-xs font-bold text-white">{{ $g->name }}</div>
                                    <div class="text-[10px] text-slate-400">{{ $g->category->name ?? 'Game' }}</div>
                                </div>
                            </div>
                            <span class="text-xs font-bold text-amber-400">
                                {{ $g->orders_count }} Transaksi
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-6 text-xs text-slate-500">
                            Belum ada statistik game.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="mt-8 pt-5 border-t border-dark-border/80">
                <a href="{{ url('/admin/games') }}" class="btn-primary w-full text-xs py-2.5">
                    Kelola Katalog Game & Paket
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
