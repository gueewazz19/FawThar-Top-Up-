@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Welcome Header Banner -->
    <div class="glass-card p-6 sm:p-8 mb-8 relative overflow-hidden border-emerald-500/30">
        <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-emerald-500/10 rounded-full blur-2xl"></div>
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 relative z-10">
            <div class="flex items-center space-x-4">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-600 flex items-center justify-center text-xl font-black text-slate-950 shadow-lg shadow-emerald-500/20">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div>
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white font-['Outfit']">
                        Selamat Datang, {{ $user->name }}!
                    </h1>
                    <p class="text-sm text-slate-600 dark:text-slate-400 mt-0.5">
                        Kelola akun, pantau transaksi top up, dan nikmati kemudahan bertransaksi di GameTopUp.
                    </p>
                </div>
            </div>

            <!-- Quick Action Button -->
            <a href="{{ url('/#games') }}" class="btn-primary px-6 py-3 text-sm">
                <span>+ Top Up Game Baru</span>
            </a>
        </div>
    </div>

    <!-- Customer Statistics Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-10">
        <div class="glass-card p-5 border-slate-200 dark:border-dark-border/80">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Total Transaksi</span>
                <span class="p-2 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </span>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white font-['Outfit'] mt-3">
                {{ $stats['total_orders'] }}
            </div>
            <div class="text-xs text-slate-500 mt-1">Semua pesanan yang pernah dibuat</div>
        </div>

        <div class="glass-card p-5 border-slate-200 dark:border-dark-border/80">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Transaksi Sukses</span>
                <span class="p-2 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-emerald-600 dark:text-emerald-400 font-['Outfit'] mt-3">
                {{ $stats['successful_orders'] }}
            </div>
            <div class="text-xs text-slate-500 mt-1">Item berhasil terkirim ke game</div>
        </div>

        <div class="glass-card p-5 border-slate-200 dark:border-dark-border/80">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Menunggu / Proses</span>
                <span class="p-2 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-amber-600 dark:text-amber-400 font-['Outfit'] mt-3">
                {{ $stats['pending_orders'] }}
            </div>
            <div class="text-xs text-slate-500 mt-1">Menunggu pembayaran / diproses</div>
        </div>

        <div class="glass-card p-5 border-slate-200 dark:border-dark-border/80">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Total Pembelian</span>
                <span class="p-2 rounded-xl bg-indigo-500/10 text-indigo-600 dark:text-indigo-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </span>
            </div>
            <div class="text-xl sm:text-2xl font-black text-indigo-600 dark:text-indigo-300 font-['Outfit'] mt-3 truncate">
                Rp {{ number_format($stats['total_spent'], 0, ',', '.') }}
            </div>
            <div class="text-xs text-slate-500 mt-1">Akumulasi transaksi sukses</div>
        </div>
    </div>

    <!-- Recent Transactions Card -->
    <div class="glass-card p-6 border-slate-200 dark:border-dark-border/80">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white font-['Outfit']">Pesanan Terbaru</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400">Pantau status transaksi top-up terbaru Anda secara real-time.</p>
            </div>
        </div>

        @if($recentOrders->isEmpty())
            <div class="text-center py-12 space-y-4">
                <div class="w-16 h-16 rounded-2xl bg-slate-100 dark:bg-dark-bg border border-slate-200 dark:border-dark-border flex items-center justify-center mx-auto text-slate-400">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-semibold text-slate-900 dark:text-white">Belum Ada Transaksi</h4>
                    <p class="text-xs text-slate-600 dark:text-slate-400 max-w-sm mx-auto mt-1">Anda belum melakukan pesanan top-up. Pilih game favorit Anda dan lakukan pembelian pertama.</p>
                </div>
                <a href="{{ url('/#games') }}" class="btn-primary text-xs px-5 py-2.5">
                    Mulai Top Up
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-dark-border text-slate-500 dark:text-slate-400 text-xs uppercase tracking-wider font-semibold">
                            <th class="py-3 px-4">No. Pesanan</th>
                            <th class="py-3 px-4">Game</th>
                            <th class="py-3 px-4">Item / Nominal</th>
                            <th class="py-3 px-4">Total</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-dark-border/60">
                        @foreach($recentOrders as $order)
                            <tr class="hover:bg-slate-100/60 dark:hover:bg-dark-surface/50 transition-colors">
                                <td class="py-3.5 px-4 font-mono font-semibold text-xs text-emerald-600 dark:text-emerald-400">
                                    {{ $order->order_number }}
                                </td>
                                <td class="py-3.5 px-4 font-medium text-slate-900 dark:text-white">
                                    {{ $order->game->name ?? '-' }}
                                </td>
                                <td class="py-3.5 px-4 text-slate-700 dark:text-slate-300">
                                    {{ $order->items->first()->product_name ?? '-' }}
                                </td>
                                <td class="py-3.5 px-4 font-bold text-slate-900 dark:text-white">
                                    {{ $order->formatted_total }}
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="badge-status {{ $order->status->badgeClass() }}">
                                        {{ $order->status->label() }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-xs text-slate-500 dark:text-slate-400">
                                    {{ $order->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    <a href="{{ url('/orders/' . $order->order_number) }}" class="btn-secondary text-xs px-3 py-1.5">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
