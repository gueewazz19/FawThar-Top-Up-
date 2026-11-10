@extends('layouts.admin')

@section('page_title', 'Kelola FAQ')

@section('content')
<div class="space-y-6">
    <!-- Header & Actions Toolbar -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white font-['Outfit']">Kelola FAQ</h1>
            <p class="text-sm text-slate-400 mt-0.5">Atur pertanyaan dan jawaban yang ditampilkan pada halaman beranda pengunjung.</p>
        </div>
        <div>
            <button type="button" onclick="document.getElementById('addFaqModal').classList.remove('hidden')" class="btn-primary inline-flex items-center space-x-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Tambah FAQ Baru</span>
            </button>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="glass-card p-4 border-dark-border/80 bg-[#121B2F]/80">
        <form method="GET" action="{{ route('admin.faqs.index') }}" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
            <div>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari pertanyaan atau jawaban..." class="form-input text-sm w-full">
            </div>
            <div>
                <select name="category" class="form-input text-sm w-full bg-[#0d1424]">
                    <option value="">-- Semua Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="status" class="form-input text-sm w-full bg-[#0d1424]">
                    <option value="">-- Semua Status --</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif (Tampil di Guest)</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif (Disembunyikan)</option>
                </select>
            </div>
            <div class="flex space-x-2">
                <button type="submit" class="w-full px-4 py-2 rounded-xl bg-cyan-600 hover:bg-cyan-500 text-white font-semibold text-sm transition-colors">
                    Filter
                </button>
                @if(request()->hasAny(['q', 'category', 'status']))
                    <a href="{{ route('admin.faqs.index') }}" class="px-3 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-sm flex items-center justify-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- FAQs Table -->
    <div class="glass-card overflow-hidden border-dark-border/80 bg-[#121B2F]/80">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="border-b border-dark-border/80 text-[11px] font-bold text-slate-400 uppercase tracking-wider bg-dark-card/50">
                        <th class="py-3.5 px-6">Urutan</th>
                        <th class="py-3.5 px-6">Pertanyaan & Jawaban</th>
                        <th class="py-3.5 px-6">Kategori</th>
                        <th class="py-3.5 px-6 text-center">Status</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-dark-border/40">
                    @forelse($faqs as $faq)
                        <tr class="hover:bg-slate-800/40 transition-colors">
                            <td class="py-4 px-6 text-center w-16">
                                <span class="px-2 py-1 rounded bg-slate-800 text-xs font-mono text-cyan-400 border border-slate-700">
                                    {{ $faq->sort_order }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-white text-base">{{ $faq->question }}</div>
                                <div class="text-xs text-slate-400 mt-1 line-clamp-2 leading-relaxed">{{ $faq->answer }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-indigo-500/15 text-indigo-300 border border-indigo-500/30">
                                    {{ ucfirst($faq->category) }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if($faq->is_active)
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
                                    <!-- Edit Button -->
                                    <button type="button" onclick="openEditFaqModal({{ json_encode($faq) }})" class="px-3 py-1.5 rounded-lg text-xs font-semibold bg-cyan-500/10 text-cyan-300 hover:bg-cyan-500/20 border border-cyan-500/30 transition-colors flex items-center space-x-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        <span>Edit</span>
                                    </button>

                                    <!-- Toggle Status Button -->
                                    <form method="POST" action="{{ route('admin.faqs.toggle', $faq) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 rounded-lg text-xs font-semibold {{ $faq->is_active ? 'bg-amber-500/10 text-amber-300 hover:bg-amber-500/20 border border-amber-500/30' : 'bg-emerald-500/10 text-emerald-300 hover:bg-emerald-500/20 border border-emerald-500/30' }} transition-colors">
                                            {{ $faq->is_active ? 'Sembunyikan' : 'Tampilkan' }}
                                        </button>
                                    </form>

                                    <!-- Delete Button -->
                                    <form method="POST" action="{{ route('admin.faqs.destroy', $faq) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus FAQ ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg text-rose-400 hover:bg-rose-500/10 hover:text-rose-300 transition-colors" title="Hapus FAQ">
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
                            <td colspan="5" class="py-8 text-center text-slate-500">
                                Tidak ada data FAQ yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($faqs->hasPages())
            <div class="p-4 border-t border-dark-border/80">
                {{ $faqs->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal Tambah FAQ Baru -->
<div id="addFaqModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="glass-card w-full max-w-lg p-6 bg-[#0E1524] border border-dark-border shadow-2xl relative">
        <button type="button" onclick="document.getElementById('addFaqModal').classList.add('hidden')" class="absolute top-4 right-4 text-slate-400 hover:text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <h3 class="text-xl font-bold text-white font-['Outfit'] mb-1">Tambah FAQ Baru</h3>
        <p class="text-xs text-slate-400 mb-6">Pertanyaan ini akan langsung muncul di section FAQ halaman depan tamu.</p>

        <form method="POST" action="{{ route('admin.faqs.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="form-label text-xs">Pertanyaan (Question)</label>
                <input type="text" name="question" required placeholder="Contoh: Berapa lama diamond masuk ke akun?" class="form-input text-sm w-full">
            </div>

            <div>
                <label class="form-label text-xs">Jawaban (Answer)</label>
                <textarea name="answer" rows="4" required class="form-input text-sm w-full" placeholder="Jelaskan secara detail dan ramah..."></textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="form-label text-xs">Kategori</label>
                    <input type="text" name="category" value="general" placeholder="general, order, payment" class="form-input text-sm w-full">
                </div>
                <div>
                    <label class="form-label text-xs">Urutan Tampil (Sort Order)</label>
                    <input type="number" name="sort_order" value="0" min="0" class="form-input text-sm w-full">
                </div>
            </div>

            <div class="pt-2">
                <label class="flex items-center space-x-2 text-sm text-slate-300 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" checked class="rounded border-slate-700 text-brand-600 focus:ring-brand-500">
                    <span>Aktifkan langsung (Tampilkan di Beranda)</span>
                </label>
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t border-dark-border">
                <button type="button" onclick="document.getElementById('addFaqModal').classList.add('hidden')" class="px-4 py-2 rounded-xl bg-slate-800 text-slate-300 text-sm hover:bg-slate-700">
                    Batal
                </button>
                <button type="submit" class="btn-primary text-sm">
                    Simpan FAQ
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit FAQ -->
<div id="editFaqModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="glass-card w-full max-w-lg p-6 bg-[#0E1524] border border-dark-border shadow-2xl relative">
        <button type="button" onclick="document.getElementById('editFaqModal').classList.add('hidden')" class="absolute top-4 right-4 text-slate-400 hover:text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <h3 class="text-xl font-bold text-white font-['Outfit'] mb-1">Edit FAQ</h3>
        <p class="text-xs text-slate-400 mb-6">Ubah pertanyaan, jawaban, atau urutan tampil FAQ ini.</p>

        <form id="editFaqForm" method="POST" action="" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="form-label text-xs">Pertanyaan (Question)</label>
                <input type="text" id="edit_question" name="question" required class="form-input text-sm w-full">
            </div>

            <div>
                <label class="form-label text-xs">Jawaban (Answer)</label>
                <textarea id="edit_answer" name="answer" rows="4" required class="form-input text-sm w-full"></textarea>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="form-label text-xs">Kategori</label>
                    <input type="text" id="edit_category" name="category" class="form-input text-sm w-full">
                </div>
                <div>
                    <label class="form-label text-xs">Urutan Tampil (Sort Order)</label>
                    <input type="number" id="edit_sort_order" name="sort_order" min="0" class="form-input text-sm w-full">
                </div>
            </div>

            <div class="pt-2">
                <label class="flex items-center space-x-2 text-sm text-slate-300 cursor-pointer">
                    <input type="checkbox" id="edit_is_active" name="is_active" value="1" class="rounded border-slate-700 text-brand-600 focus:ring-brand-500">
                    <span>Aktifkan langsung (Tampilkan di Beranda)</span>
                </label>
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t border-dark-border">
                <button type="button" onclick="document.getElementById('editFaqModal').classList.add('hidden')" class="px-4 py-2 rounded-xl bg-slate-800 text-slate-300 text-sm hover:bg-slate-700">
                    Batal
                </button>
                <button type="submit" class="btn-primary text-sm">
                    Perbarui FAQ
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditFaqModal(faq) {
        const modal = document.getElementById('editFaqModal');
        const form = document.getElementById('editFaqForm');

        form.action = `/admin/faqs/${faq.id}`;
        document.getElementById('edit_question').value = faq.question || '';
        document.getElementById('edit_answer').value = faq.answer || '';
        document.getElementById('edit_category').value = faq.category || 'general';
        document.getElementById('edit_sort_order').value = faq.sort_order ?? 0;
        document.getElementById('edit_is_active').checked = Boolean(faq.is_active);

        modal.classList.remove('hidden');
    }
</script>
@endsection
