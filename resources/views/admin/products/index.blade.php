@extends('layouts.admin')

@section('page_title', 'Kelola Paket Top-Up')

@section('content')
<div class="space-y-6">
    <!-- Header & Actions Toolbar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white font-['Outfit']">Paket & Denominasi Top-Up</h1>
            <p class="text-sm text-slate-400 mt-0.5">Kelola varian diamond, credit, atau paket langganan untuk setiap game.</p>
        </div>
        <div>
            <button type="button" onclick="document.getElementById('addProductModal').classList.remove('hidden')" class="btn-primary inline-flex items-center space-x-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Tambah Paket Baru</span>
            </button>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="glass-card p-4 border-dark-border/80 bg-[#121B2F]/80">
        <form method="GET" action="{{ route('admin.products.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
            <div>
                <select name="game_id" class="form-input text-sm w-full bg-[#0d1424]">
                    <option value="">-- Semua Game --</option>
                    @foreach($games as $g)
                        <option value="{{ $g->id }}" {{ request('game_id') == $g->id ? 'selected' : '' }}>{{ $g->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama paket/diamond..." class="form-input text-sm w-full">
            </div>
            <div>
                <select name="status" class="form-input text-sm w-full bg-[#0d1424]">
                    <option value="">-- Semua Ketersediaan --</option>
                    <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Tersedia</option>
                    <option value="unavailable" {{ request('status') === 'unavailable' ? 'selected' : '' }}>Habis (Unavailable)</option>
                </select>
            </div>
            <div class="flex space-x-2">
                <button type="submit" class="w-full px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-sm transition-colors">
                    Filter
                </button>
                @if(request()->hasAny(['q', 'game_id', 'status']))
                    <a href="{{ route('admin.products.index') }}" class="px-3 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-sm flex items-center justify-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Products Table -->
    <div class="glass-card overflow-hidden border-dark-border/80 bg-[#121B2F]/80">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="border-b border-dark-border/80 text-[11px] font-bold text-slate-400 uppercase tracking-wider bg-dark-card/50">
                        <th class="py-3.5 px-6">Game</th>
                        <th class="py-3.5 px-6">Nama Paket / Nominal</th>
                        <th class="py-3.5 px-6">Harga Jual</th>
                        <th class="py-3.5 px-6">HPP Modal</th>
                        <th class="py-3.5 px-6">Margin Keuntungan</th>
                        <th class="py-3.5 px-6 text-center">Status</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-dark-border/40">
                    @forelse($products as $product)
                        @php
                            $margin = $product->price - $product->cost;
                            $marginPercent = $product->price > 0 ? round(($margin / $product->price) * 100, 1) : 0;
                        @endphp
                        <tr class="hover:bg-slate-800/40 transition-colors">
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-cyan-500/10 text-cyan-300 border border-cyan-500/20">
                                    {{ $product->game->name ?? '-' }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center space-x-2">
                                    <div class="font-bold text-white">{{ $product->name }}</div>
                                    @if($product->is_popular)
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-amber-500/15 text-amber-400 border border-amber-500/30">
                                            POPULER
                                        </span>
                                    @endif
                                </div>
                                <div class="text-xs text-slate-500">{{ $product->currency_amount }} Unit</div>
                            </td>
                            <td class="py-4 px-6 font-bold text-emerald-400">
                                {{ $product->formatted_price }}
                            </td>
                            <td class="py-4 px-6 text-slate-400">
                                Rp {{ number_format($product->cost, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="text-xs font-semibold text-cyan-300">
                                    Rp {{ number_format($margin, 0, ',', '.') }}
                                    <span class="text-[11px] text-slate-400">({{ $marginPercent }}%)</span>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if($product->is_available)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-500/15 text-emerald-400 border border-emerald-500/30">
                                        Tersedia
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-rose-500/15 text-rose-400 border border-rose-500/30">
                                        Habis
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <form method="POST" action="{{ route('admin.products.toggle', $product) }}">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-semibold {{ $product->is_available ? 'bg-amber-500/10 text-amber-300 hover:bg-amber-500/20 border border-amber-500/30' : 'bg-emerald-500/10 text-emerald-300 hover:bg-emerald-500/20 border border-emerald-500/30' }} transition-colors">
                                            {{ $product->is_available ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Hapus paket {{ $product->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-rose-400 hover:bg-rose-500/10 hover:text-rose-300 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-500">
                                Belum ada paket top-up yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($products->hasPages())
            <div class="p-4 border-t border-dark-border/80">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal Tambah Paket -->
<div id="addProductModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="glass-card w-full max-w-lg p-6 bg-[#0E1524] border border-dark-border shadow-2xl relative">
        <button type="button" onclick="document.getElementById('addProductModal').classList.add('hidden')" class="absolute top-4 right-4 text-slate-400 hover:text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <h3 class="text-xl font-bold text-white font-['Outfit'] mb-1">Tambah Paket Top-Up</h3>
        <p class="text-xs text-slate-400 mb-6">Tambahkan nominal diamond atau paket langganan ke game pilihan.</p>

        <form method="POST" action="{{ route('admin.products.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="form-label text-xs">Pilih Game</label>
                <select name="game_id" required class="form-input text-sm w-full bg-[#0d1424]">
                    @foreach($games as $g)
                        <option value="{{ $g->id }}" {{ request('game_id') == $g->id ? 'selected' : '' }}>{{ $g->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label text-xs">Nama Tampilan Paket</label>
                    <input type="text" name="name" required placeholder="cth: 250 Diamonds" class="form-input text-sm w-full">
                </div>
                <div>
                    <label class="form-label text-xs">Nominal Currency</label>
                    <input type="text" name="currency_amount" required placeholder="cth: 250" class="form-input text-sm w-full">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="form-label text-xs">Harga Jual (Rp)</label>
                    <input type="number" name="price" required min="100" placeholder="cth: 65000" class="form-input text-sm w-full">
                </div>
                <div>
                    <label class="form-label text-xs">Modal / HPP (Rp)</label>
                    <input type="number" name="cost" required min="0" placeholder="cth: 60000" class="form-input text-sm w-full">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 items-center pt-2">
                <div>
                    <label class="form-label text-xs">Urutan Tampil (Sort Order)</label>
                    <input type="number" name="sort_order" value="10" class="form-input text-sm w-full">
                </div>
                <div class="pt-5">
                    <label class="flex items-center space-x-2 text-sm text-slate-300 cursor-pointer">
                        <input type="checkbox" name="is_popular" value="1" class="rounded border-slate-700 text-brand-600 focus:ring-brand-500">
                        <span>Tandai Sebagai Populer</span>
                    </label>
                </div>
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t border-dark-border">
                <button type="button" onclick="document.getElementById('addProductModal').classList.add('hidden')" class="px-4 py-2 rounded-xl bg-slate-800 text-slate-300 text-sm hover:bg-slate-700">
                    Batal
                </button>
                <button type="submit" class="btn-primary text-sm">
                    Simpan Paket
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
