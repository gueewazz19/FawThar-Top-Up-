@extends('layouts.admin')

@section('page_title', 'Kelola Pengguna Terdaftar')

@section('content')
<div class="space-y-6">
    <!-- Header & Summary -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white font-['Outfit']">Kelola Pengguna</h1>
            <p class="text-sm text-slate-400 mt-0.5">Pantau seluruh akun pelanggan terdaftar, rekam jejak login terakhir, dan kelola hak akses administrator.</p>
        </div>
    </div>

    <!-- User KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="glass-card p-5 border-dark-border/80 bg-[#121B2F]/80">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pengguna</span>
            <div class="text-2xl sm:text-3xl font-black text-white font-['Outfit'] mt-2">
                {{ $stats['total_users'] }}
            </div>
            <div class="text-xs text-slate-500 mt-1">Akun terdaftar di sistem</div>
        </div>

        <div class="glass-card p-5 border-dark-border/80 bg-[#121B2F]/80">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pelanggan (Gamers)</span>
            <div class="text-2xl sm:text-3xl font-black text-cyan-400 font-['Outfit'] mt-2">
                {{ $stats['total_customers'] }}
            </div>
            <div class="text-xs text-slate-500 mt-1">Pengguna biasa / pembeli</div>
        </div>

        <div class="glass-card p-5 border-dark-border/80 bg-[#121B2F]/80">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Administrator</span>
            <div class="text-2xl sm:text-3xl font-black text-amber-400 font-['Outfit'] mt-2">
                {{ $stats['total_admins'] }}
            </div>
            <div class="text-xs text-slate-500 mt-1">Akses penuh panel operasional</div>
        </div>

        <div class="glass-card p-5 border-dark-border/80 bg-[#121B2F]/80">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Login Hari Ini</span>
            <div class="text-2xl sm:text-3xl font-black text-emerald-400 font-['Outfit'] mt-2">
                {{ $stats['active_today'] }}
            </div>
            <div class="text-xs text-slate-500 mt-1">User yang aktif hari ini</div>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="glass-card p-4 border-dark-border/80 bg-[#121B2F]/80">
        <form method="GET" action="{{ route('admin.users.index') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, email, nomor HP..." class="form-input text-sm w-full">
            </div>
            <div>
                <select name="role" class="form-input text-sm w-full bg-[#0d1424]">
                    <option value="">-- Semua Role --</option>
                    <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>Pelanggan (User)</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Administrator</option>
                </select>
            </div>
            <div class="flex space-x-2">
                <button type="submit" class="w-full px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-semibold text-sm transition-colors">
                    Filter Pengguna
                </button>
                @if(request()->hasAny(['q', 'role']))
                    <a href="{{ route('admin.users.index') }}" class="px-3 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-sm flex items-center justify-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Users Table -->
    <div class="glass-card overflow-hidden border-dark-border/80 bg-[#121B2F]/80">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="border-b border-dark-border/80 text-[11px] font-bold text-slate-400 uppercase tracking-wider bg-dark-card/50">
                        <th class="py-3.5 px-6">Pengguna</th>
                        <th class="py-3.5 px-6 text-center">Role</th>
                        <th class="py-3.5 px-6">Terakhir Login & IP</th>
                        <th class="py-3.5 px-6">Total Belanja</th>
                        <th class="py-3.5 px-6">Terdaftar Sejak</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-dark-border/40">
                    @forelse($users as $u)
                        <tr class="hover:bg-slate-800/40 transition-colors">
                            <td class="py-4 px-6">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500/20 to-purple-600/20 border border-indigo-500/30 flex items-center justify-center text-indigo-400 font-bold text-xs">
                                        {{ strtoupper(substr($u->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-white flex items-center space-x-1.5">
                                            <span>{{ $u->name }}</span>
                                            @if($u->id === auth()->id())
                                                <span class="text-[9px] px-1.5 py-0.2 rounded bg-indigo-500/20 text-indigo-300 border border-indigo-500/30">Anda</span>
                                            @endif
                                        </div>
                                        <div class="text-xs text-slate-400">{{ $u->email }}</div>
                                        @if($u->phone)
                                            <div class="text-[11px] text-slate-500 font-mono">{{ $u->phone }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if($u->isAdmin())
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-amber-500/15 text-amber-400 border border-amber-500/30">
                                        Administrator
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-cyan-500/15 text-cyan-400 border border-cyan-500/30">
                                        Pelanggan
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                @if($u->last_login_at)
                                    <div class="text-xs text-slate-200 font-semibold">
                                        {{ $u->last_login_at->translatedFormat('d M Y, H:i') }}
                                    </div>
                                    <div class="text-[11px] font-mono text-cyan-400">
                                        IP: {{ $u->last_login_ip ?? '-' }}
                                    </div>
                                @else
                                    <span class="text-xs text-slate-500 italic">Belum pernah login</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-bold text-emerald-400 font-['Outfit']">
                                    Rp {{ number_format($u->total_spent ?? 0, 0, ',', '.') }}
                                </div>
                                <div class="text-xs text-slate-500">{{ $u->orders_count }} Transaksi</div>
                            </td>
                            <td class="py-4 px-6 text-slate-400 text-xs">
                                {{ $u->created_at->translatedFormat('d M Y') }}
                            </td>
                            <td class="py-4 px-6 text-right">
                                @if($u->id !== auth()->id())
                                    <div class="flex items-center justify-end space-x-2">
                                        <form method="POST" action="{{ route('admin.users.toggle_role', $u) }}" onsubmit="return confirm('Ubah role {{ $u->name }} menjadi {{ $u->isAdmin() ? 'PELANGGAN' : 'ADMINISTRATOR' }}?')">
                                            @csrf
                                            <button type="submit" class="px-2.5 py-1.5 rounded-lg text-xs font-semibold {{ $u->isAdmin() ? 'bg-cyan-500/10 text-cyan-300 hover:bg-cyan-500/20 border border-cyan-500/30' : 'bg-amber-500/10 text-amber-300 hover:bg-amber-500/20 border border-amber-500/30' }} transition-colors">
                                                {{ $u->isAdmin() ? 'Jadikan User' : 'Jadikan Admin' }}
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('admin.users.destroy', $u) }}" onsubmit="return confirm('Hapus akun {{ $u->name }} secara permanen?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded-lg text-rose-400 hover:bg-rose-500/10 hover:text-rose-300 transition-colors" title="Hapus User">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-xs text-slate-500 italic">Akun Saat Ini</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-500">
                                Tidak ada data pengguna yang sesuai filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
            <div class="p-4 border-t border-dark-border/80">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
