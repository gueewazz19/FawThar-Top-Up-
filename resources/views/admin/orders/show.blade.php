@extends('layouts.admin')

@section('page_title', 'Detail Pesanan ' . $order->order_number)

@section('content')
<div class="space-y-6">
    <!-- Header with Back Button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.orders.index') }}" class="p-2 rounded-xl bg-slate-800/80 text-slate-400 hover:text-white hover:bg-slate-700 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-xl font-black text-white font-['Outfit'] flex items-center space-x-2">
                    <span>{{ $order->order_number }}</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $order->status->badgeClass() }}">
                        {{ $order->status->label() }}
                    </span>
                </h1>
                <p class="text-xs text-slate-400 mt-0.5">Dibuat pada {{ $order->created_at->translatedFormat('d F Y, H:i:s') }} WIB</p>
            </div>
        </div>
        <div>
            <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan {{ $order->order_number }} secara permanen?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center space-x-2 px-3.5 py-2 rounded-xl text-xs font-bold bg-rose-500/10 text-rose-300 hover:bg-rose-500/20 border border-rose-500/30 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    <span>Hapus Pesanan</span>
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Column (Order Info, Items, Payment) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Account & Game Info -->
            <div class="glass-card p-6 border-dark-border/80 bg-[#121B2F]/80">
                <h3 class="text-base font-bold text-white font-['Outfit'] mb-4 flex items-center space-x-2">
                    <span class="p-1.5 rounded-lg bg-cyan-500/10 text-cyan-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </span>
                    <span>Target Akun Pelanggan</span>
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div class="p-3.5 rounded-xl bg-slate-900/60 border border-slate-800">
                        <span class="text-xs text-slate-400 block mb-1">Game</span>
                        <span class="font-bold text-white text-base">{{ $order->game->name ?? '-' }}</span>
                    </div>
                    <div class="p-3.5 rounded-xl bg-slate-900/60 border border-slate-800">
                        <span class="text-xs text-slate-400 block mb-1">Player / User ID</span>
                        <span class="font-mono font-bold text-cyan-400 text-base">{{ $order->player_id }}</span>
                    </div>
                    @if($order->server_id)
                        <div class="p-3.5 rounded-xl bg-slate-900/60 border border-slate-800">
                            <span class="text-xs text-slate-400 block mb-1">Server / Zone ID</span>
                            <span class="font-mono font-bold text-amber-300 text-base">{{ $order->server_id }}</span>
                        </div>
                    @endif
                    <div class="p-3.5 rounded-xl bg-slate-900/60 border border-slate-800">
                        <span class="text-xs text-slate-400 block mb-1">Data Pelanggan</span>
                        <span class="font-semibold text-white block">{{ $order->user->name ?? 'Guest User' }}</span>
                        <span class="text-xs text-slate-500">{{ $order->user->email ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Items Purchased -->
            <div class="glass-card p-6 border-dark-border/80 bg-[#121B2F]/80">
                <h3 class="text-base font-bold text-white font-['Outfit'] mb-4 flex items-center space-x-2">
                    <span class="p-1.5 rounded-lg bg-emerald-500/10 text-emerald-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </span>
                    <span>Rincian Item Produk</span>
                </h3>
                <div class="divide-y divide-dark-border/40">
                    @foreach($order->items as $item)
                        <div class="py-3 flex items-center justify-between">
                            <div>
                                <div class="font-bold text-white text-sm">{{ $item->product_name }}</div>
                                <div class="text-xs text-slate-400">{{ $item->quantity }}x @ Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                            </div>
                            <div class="font-bold text-emerald-400 text-sm">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="pt-4 mt-2 border-t border-dark-border/80 space-y-2 text-sm">
                    <div class="flex justify-between text-slate-400">
                        <span>Subtotal</span>
                        <span>{{ $order->formatted_subtotal }}</span>
                    </div>
                    @if($order->discount > 0)
                        <div class="flex justify-between text-emerald-400">
                            <span>Diskon Voucher</span>
                            <span>- {{ $order->formatted_discount }}</span>
                        </div>
                    @endif
                    @if($order->payment_fee > 0)
                        <div class="flex justify-between text-slate-400">
                            <span>Biaya Layanan Gateway</span>
                            <span>{{ $order->formatted_fee }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between text-white font-black text-lg pt-2 border-t border-dark-border/60">
                        <span>Total Pembayaran</span>
                        <span class="text-emerald-400 font-['Outfit']">{{ $order->formatted_total }}</span>
                    </div>
                </div>
            </div>

            <!-- Notes & Audit Trail -->
            @if($order->notes)
                <div class="glass-card p-6 border-dark-border/80 bg-[#121B2F]/80">
                    <h3 class="text-base font-bold text-white font-['Outfit'] mb-2">Riwayat Catatan</h3>
                    <div class="p-3.5 rounded-xl bg-slate-950/80 border border-slate-800 font-mono text-xs text-slate-300 whitespace-pre-line leading-relaxed">
                        {{ $order->notes }}
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar Column (Status Action Form) -->
        <div class="space-y-6">
            <div class="glass-card p-6 border-dark-border/80 bg-[#121B2F]/80 sticky top-28">
                <h3 class="text-base font-bold text-white font-['Outfit'] mb-4 flex items-center space-x-2">
                    <span class="p-1.5 rounded-lg bg-amber-500/10 text-amber-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </span>
                    <span>Kelola Status Pesanan</span>
                </h3>

                <form method="POST" action="{{ route('admin.orders.update_status', $order) }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="form-label text-xs">Ubah Status Menjadi</label>
                        <select name="status" class="form-input text-sm w-full bg-[#0d1424]">
                            @foreach($statuses as $status)
                                <option value="{{ $status->value }}" {{ $order->status->value === $status->value ? 'selected' : '' }}>
                                    {{ $status->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="form-label text-xs">Catatan Internal Admin (Opsional)</label>
                        <textarea name="notes" rows="3" class="form-input text-xs w-full" placeholder="Contoh: Top-up manual sukses via admin provider, serial number #12345."></textarea>
                    </div>

                    <button type="submit" class="btn-primary w-full text-sm">
                        Perbarui Status Pesanan
                    </button>
                </form>

                <div class="mt-6 pt-4 border-t border-dark-border/60 text-xs text-slate-500 space-y-1">
                    <div>Terakhir diperbarui: {{ $order->updated_at->diffForHumans() }}</div>
                    <div>Order ID Database: #{{ $order->id }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
