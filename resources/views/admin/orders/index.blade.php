@extends('layouts.admin')

@section('page_title', 'Kelola Pesanan & Fulfillment')

@section('content')
<div class="space-y-6">
    <!-- Header & Summary -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white font-['Outfit']">Semua Pesanan</h1>
            <p class="text-sm text-slate-400 mt-0.5">Monitoring transaksi masuk, verifikasi pembayaran, dan status delivery ke akun pelanggan.</p>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="glass-card p-4 border-dark-border/80 bg-[#121B2F]/80">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari No. Pesanan, Player ID, Pelanggan..." class="form-input text-sm w-full">
            </div>
            <div>
                <select name="status" class="form-input text-sm w-full bg-[#0d1424]">
                    <option value="">-- Semua Status Pesanan --</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status->value }}" {{ request('status') === $status->value ? 'selected' : '' }}>{{ $status->label() }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex space-x-2">
                <button type="submit" class="w-full px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-semibold text-sm transition-colors">
                    Filter Pesanan
                </button>
                @if(request()->hasAny(['q', 'status']))
                    <a href="{{ route('admin.orders.index') }}" class="px-3 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-sm flex items-center justify-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="glass-card overflow-hidden border-dark-border/80 bg-[#121B2F]/80">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="border-b border-dark-border/80 text-[11px] font-bold text-slate-400 uppercase tracking-wider bg-dark-card/50">
                        <th class="py-3.5 px-6">No. Pesanan / Tanggal</th>
                        <th class="py-3.5 px-6">Pelanggan</th>
                        <th class="py-3.5 px-6">Game & ID Akun</th>
                        <th class="py-3.5 px-6">Total Pembayaran</th>
                        <th class="py-3.5 px-6 text-center">Status</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-dark-border/40">
                    @forelse($orders as $order)
                        <tr class="hover:bg-slate-800/40 transition-colors">
                            <td class="py-4 px-6">
                                <div class="font-mono font-bold text-cyan-400 text-xs">{{ $order->order_number }}</div>
                                <div class="text-[11px] text-slate-500">{{ $order->created_at->translatedFormat('d M Y, H:i') }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-semibold text-white">{{ $order->user->name ?? 'Guest User' }}</div>
                                <div class="text-xs text-slate-500">{{ $order->user->email ?? '-' }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-200">{{ $order->game->name ?? '-' }}</div>
                                <div class="text-xs font-mono text-amber-300">
                                    ID: {{ $order->player_id }}
                                    @if($order->server_id)
                                        <span class="text-slate-500">({{ $order->server_id }})</span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-emerald-400 font-['Outfit']">{{ $order->formatted_total }}</div>
                                <div class="text-[10px] text-slate-500 uppercase">{{ $order->payment->payment_method ?? 'Bank Transfer' }}</div>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $order->status->badgeClass() }}">
                                    {{ $order->status->label() }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="inline-flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center space-x-1 px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-500/10 text-blue-300 hover:bg-blue-500/20 border border-blue-500/30 transition-colors">
                                        <span>Detail</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan {{ $order->order_number }} secara permanen? Data pesanan, item, dan pembayaran akan dihapus.');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus Pesanan" class="inline-flex items-center space-x-1 px-2.5 py-1.5 rounded-lg text-xs font-semibold bg-rose-500/10 text-rose-300 hover:bg-rose-500/20 border border-rose-500/30 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-500">
                                Belum ada pesanan yang sesuai kriteria pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($orders->hasPages())
            <div class="p-4 border-t border-dark-border/80">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
