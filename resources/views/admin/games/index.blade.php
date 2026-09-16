@extends('layouts.admin')

@section('page_title', 'Kelola Game & Katalog')

@section('content')
<div class="space-y-6">
    <!-- Header & Actions Toolbar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white font-['Outfit']">Katalog Game</h1>
            <p class="text-sm text-slate-400 mt-0.5">Kelola daftar game yang ditampilkan dan dapat di-topup oleh pelanggan.</p>
        </div>
        <div>
            <button type="button" onclick="document.getElementById('addGameModal').classList.remove('hidden')" class="btn-primary inline-flex items-center space-x-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Tambah Game Baru</span>
            </button>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="glass-card p-4 border-dark-border/80 bg-[#121B2F]/80">
        <form method="GET" action="{{ route('admin.games.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
            <div>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau slug..." class="form-input text-sm w-full">
            </div>
            <div>
                <select name="category_id" class="form-input text-sm w-full bg-[#0d1424]">
                    <option value="">-- Semua Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="status" class="form-input text-sm w-full bg-[#0d1424]">
                    <option value="">-- Semua Status --</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif (Tampil)</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif (Tersembunyi)</option>
                </select>
            </div>
            <div class="flex space-x-2">
                <button type="submit" class="w-full px-4 py-2 rounded-xl bg-cyan-600 hover:bg-cyan-500 text-white font-semibold text-sm transition-colors">
                    Filter
                </button>
                @if(request()->hasAny(['q', 'category_id', 'status']))
                    <a href="{{ route('admin.games.index') }}" class="px-3 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-sm flex items-center justify-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Games Table -->
    <div class="glass-card overflow-hidden border-dark-border/80 bg-[#121B2F]/80">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="border-b border-dark-border/80 text-[11px] font-bold text-slate-400 uppercase tracking-wider bg-dark-card/50">
                        <th class="py-3.5 px-6">Game</th>
                        <th class="py-3.5 px-6">Kategori</th>
                        <th class="py-3.5 px-6 text-center">Paket Top-Up</th>
                        <th class="py-3.5 px-6">Ketentuan Akun</th>
                        <th class="py-3.5 px-6 text-center">Status</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-dark-border/40">
                    @forelse($games as $game)
                        <tr class="hover:bg-slate-800/40 transition-colors">
                            <td class="py-4 px-6">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-cyan-500/20 to-blue-600/20 border border-cyan-500/30 flex items-center justify-center text-cyan-400 font-black text-sm">
                                        {{ strtoupper(substr($game->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-white">{{ $game->name }}</div>
                                        <div class="text-xs text-slate-500">/game/{{ $game->slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-slate-300">
                                <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-purple-500/10 text-purple-300 border border-purple-500/20">
                                    {{ $game->category->name ?? '-' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <a href="{{ route('admin.products.index', ['game_id' => $game->id]) }}" class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 hover:bg-emerald-500/20 transition-colors">
                                    <span>{{ $game->products_count }} Paket</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex flex-wrap gap-1.5">
                                    @if($game->requires_user_id)
                                        <span class="text-[11px] px-2 py-0.5 rounded bg-slate-800 text-cyan-300 border border-slate-700">
                                            {{ $game->user_id_label ?? 'User ID' }}
                                        </span>
                                    @endif
                                    @if($game->requires_server_id)
                                        <span class="text-[11px] px-2 py-0.5 rounded bg-slate-800 text-amber-300 border border-slate-700">
                                            {{ $game->server_id_label ?? 'Server ID' }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if($game->is_active)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-500/15 text-emerald-400 border border-emerald-500/30">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-rose-500/15 text-rose-400 border border-rose-500/30">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end space-x-2">
                                    <form method="POST" action="{{ route('admin.games.toggle', $game) }}">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-semibold {{ $game->is_active ? 'bg-amber-500/10 text-amber-300 hover:bg-amber-500/20 border border-amber-500/30' : 'bg-emerald-500/10 text-emerald-300 hover:bg-emerald-500/20 border border-emerald-500/30' }} transition-colors">
                                            {{ $game->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.products.index', ['game_id' => $game->id]) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-cyan-500/10 text-cyan-300 hover:bg-cyan-500/20 border border-cyan-500/30 transition-colors">
                                        Kelola Paket
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-500">
                                Tidak ada game yang ditemukan sesuai filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($games->hasPages())
            <div class="p-4 border-t border-dark-border/80">
                {{ $games->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal Tambah Game -->
<div id="addGameModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="glass-card w-full max-w-lg p-6 bg-[#0E1524] border border-dark-border shadow-2xl relative">
        <button type="button" onclick="document.getElementById('addGameModal').classList.add('hidden')" class="absolute top-4 right-4 text-slate-400 hover:text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <h3 class="text-xl font-bold text-white font-['Outfit'] mb-1">Tambah Game Baru</h3>
        <p class="text-xs text-slate-400 mb-6">Lengkapi informasi konfigurasi game untuk ditampilkan di katalog.</p>

        <form method="POST" action="{{ route('admin.games.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="form-label text-xs">Nama Game</label>
                <input type="text" name="name" required placeholder="Contoh: Genshin Impact" class="form-input text-sm w-full">
            </div>

            <div>
                <label class="form-label text-xs">Kategori Game</label>
                <select name="category_id" required class="form-input text-sm w-full bg-[#0d1424]">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="form-label text-xs">Deskripsi Singkat</label>
                <textarea name="description" rows="2" class="form-input text-sm w-full" placeholder="Layanan top up instan dan legal."></textarea>
            </div>

            <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-800 space-y-3">
                <div class="text-xs font-bold text-slate-300 uppercase tracking-wider">Ketentuan Akun Pelanggan</div>
                
                <label class="flex items-center space-x-2 text-sm text-slate-300 cursor-pointer">
                    <input type="checkbox" name="requires_user_id" value="1" checked class="rounded border-slate-700 text-brand-600 focus:ring-brand-500">
                    <span>Wajib User ID</span>
                </label>
                <div>
                    <input type="text" name="user_id_label" value="User ID" placeholder="Label User ID (cth: Player ID / UID)" class="form-input text-xs w-full">
                </div>

                <label class="flex items-center space-x-2 text-sm text-slate-300 cursor-pointer pt-2">
                    <input type="checkbox" name="requires_server_id" value="1" class="rounded border-slate-700 text-brand-600 focus:ring-brand-500">
                    <span>Wajib Server / Zone ID</span>
                </label>
                <div>
                    <input type="text" name="server_id_label" value="Zone ID" placeholder="Label Server (cth: Server / Zone ID)" class="form-input text-xs w-full">
                </div>
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t border-dark-border">
                <button type="button" onclick="document.getElementById('addGameModal').classList.add('hidden')" class="px-4 py-2 rounded-xl bg-slate-800 text-slate-300 text-sm hover:bg-slate-700">
                    Batal
                </button>
                <button type="submit" class="btn-primary text-sm">
                    Simpan Game
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
