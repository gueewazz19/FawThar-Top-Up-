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
                                    @if($game->logo)
                                        <img src="{{ $game->logo }}" alt="{{ $game->name }}" class="w-11 h-11 rounded-xl object-cover border border-cyan-500/30 flex-shrink-0 bg-slate-900 shadow">
                                    @else
                                        <div class="w-11 h-11 rounded-xl bg-gradient-to-tr from-cyan-500/20 to-blue-600/20 border border-cyan-500/30 flex items-center justify-center text-cyan-400 font-black text-sm flex-shrink-0">
                                            {{ strtoupper(substr($game->name, 0, 2)) }}
                                        </div>
                                    @endif
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
                                    <button type="button" onclick="openEditGameModal({{ json_encode($game) }})" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-cyan-500/10 text-cyan-300 hover:bg-cyan-500/20 border border-cyan-500/30 transition-colors flex items-center space-x-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        <span>Edit</span>
                                    </button>
                                    <form method="POST" action="{{ route('admin.games.toggle', $game) }}">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-semibold {{ $game->is_active ? 'bg-amber-500/10 text-amber-300 hover:bg-amber-500/20 border border-amber-500/30' : 'bg-emerald-500/10 text-emerald-300 hover:bg-emerald-500/20 border border-emerald-500/30' }} transition-colors">
                                            {{ $game->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.products.index', ['game_id' => $game->id]) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-indigo-500/10 text-indigo-300 hover:bg-indigo-500/20 border border-indigo-500/30 transition-colors">
                                        Paket
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

        <form method="POST" action="{{ route('admin.games.store') }}" enctype="multipart/form-data" class="space-y-4">
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
                <label class="form-label text-xs">Foto / Cover Game (Maks 4MB)</label>
                <input type="file" name="photo" accept="image/*" class="form-input text-xs w-full bg-[#0d1424] file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-cyan-600 file:text-white hover:file:bg-cyan-500">
                <p class="text-[11px] text-slate-500 mt-1">Format: JPG, PNG, WEBP. Foto ini akan tampil di katalog beranda dan halaman checkout.</p>
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

<!-- Modal Edit Game -->
<div id="editGameModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="glass-card w-full max-w-lg p-6 bg-[#0E1524] border border-dark-border shadow-2xl relative">
        <button type="button" onclick="document.getElementById('editGameModal').classList.add('hidden')" class="absolute top-4 right-4 text-slate-400 hover:text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <h3 class="text-xl font-bold text-white font-['Outfit'] mb-1">Edit Game</h3>
        <p class="text-xs text-slate-400 mb-6">Ubah data game, foto cover, dan konfigurasi akun pelanggan.</p>

        <form id="editGameForm" method="POST" action="" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="form-label text-xs">Nama Game</label>
                <input type="text" id="edit_game_name" name="name" required class="form-input text-sm w-full">
            </div>

            <div>
                <label class="form-label text-xs">Kategori Game</label>
                <select id="edit_game_category_id" name="category_id" required class="form-input text-sm w-full bg-[#0d1424]">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="form-label text-xs">Foto / Cover Game Saat Ini & Ganti Baru</label>
                <div class="flex items-center space-x-3 mb-2">
                    <img id="edit_game_photo_preview" src="" alt="Cover" class="w-14 h-14 rounded-xl object-cover border border-slate-700 bg-slate-900 hidden">
                    <div id="edit_game_photo_placeholder" class="w-14 h-14 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center text-xs text-slate-500">
                        No Foto
                    </div>
                    <div class="flex-grow">
                        <input type="file" name="photo" accept="image/*" onchange="previewGamePhoto(this)" class="form-input text-xs w-full bg-[#0d1424] file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-cyan-600 file:text-white hover:file:bg-cyan-500">
                        <p class="text-[11px] text-slate-500 mt-1">Unggah file gambar baru (JPG, PNG, WEBP) untuk mengganti foto yang tampil di guest.</p>
                    </div>
                </div>
            </div>

            <div>
                <label class="form-label text-xs">Deskripsi Singkat</label>
                <textarea id="edit_game_description" name="description" rows="2" class="form-input text-sm w-full"></textarea>
            </div>

            <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-800 space-y-3">
                <div class="text-xs font-bold text-slate-300 uppercase tracking-wider">Ketentuan Akun Pelanggan</div>
                
                <label class="flex items-center space-x-2 text-sm text-slate-300 cursor-pointer">
                    <input type="checkbox" id="edit_requires_user_id" name="requires_user_id" value="1" class="rounded border-slate-700 text-brand-600 focus:ring-brand-500">
                    <span>Wajib User ID</span>
                </label>
                <div>
                    <input type="text" id="edit_user_id_label" name="user_id_label" placeholder="Label User ID (cth: Player ID / UID)" class="form-input text-xs w-full">
                </div>

                <label class="flex items-center space-x-2 text-sm text-slate-300 cursor-pointer pt-2">
                    <input type="checkbox" id="edit_requires_server_id" name="requires_server_id" value="1" class="rounded border-slate-700 text-brand-600 focus:ring-brand-500">
                    <span>Wajib Server / Zone ID</span>
                </label>
                <div>
                    <input type="text" id="edit_server_id_label" name="server_id_label" placeholder="Label Server (cth: Server / Zone ID)" class="form-input text-xs w-full">
                </div>
            </div>

            <div class="pt-1">
                <label class="flex items-center space-x-2 text-sm text-slate-300 cursor-pointer">
                    <input type="checkbox" id="edit_game_is_active" name="is_active" value="1" class="rounded border-slate-700 text-brand-600 focus:ring-brand-500">
                    <span>Status Aktif (Tampilkan di Katalog Tamu)</span>
                </label>
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t border-dark-border">
                <button type="button" onclick="document.getElementById('editGameModal').classList.add('hidden')" class="px-4 py-2 rounded-xl bg-slate-800 text-slate-300 text-sm hover:bg-slate-700">
                    Batal
                </button>
                <button type="submit" class="btn-primary text-sm">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditGameModal(game) {
        const modal = document.getElementById('editGameModal');
        const form = document.getElementById('editGameForm');

        form.action = `/admin/games/${game.id}`;
        document.getElementById('edit_game_name').value = game.name || '';
        document.getElementById('edit_game_category_id').value = game.category_id || '';
        document.getElementById('edit_game_description').value = game.description || '';
        document.getElementById('edit_requires_user_id').checked = Boolean(game.requires_user_id);
        document.getElementById('edit_user_id_label').value = game.user_id_label || 'User ID';
        document.getElementById('edit_requires_server_id').checked = Boolean(game.requires_server_id);
        document.getElementById('edit_server_id_label').value = game.server_id_label || 'Zone ID';
        document.getElementById('edit_game_is_active').checked = Boolean(game.is_active);

        const previewImg = document.getElementById('edit_game_photo_preview');
        const placeholder = document.getElementById('edit_game_photo_placeholder');

        if (game.logo) {
            previewImg.src = game.logo;
            previewImg.classList.remove('hidden');
            placeholder.classList.add('hidden');
        } else {
            previewImg.src = '';
            previewImg.classList.add('hidden');
            placeholder.classList.remove('hidden');
        }

        modal.classList.remove('hidden');
    }

    function previewGamePhoto(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImg = document.getElementById('edit_game_photo_preview');
                const placeholder = document.getElementById('edit_game_photo_placeholder');
                previewImg.src = e.target.result;
                previewImg.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
