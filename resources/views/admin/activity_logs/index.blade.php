@extends('layouts.admin')

@section('page_title', 'Audit Log & WAF Shield Monitoring')

@section('content')
<div class="space-y-6">
    <!-- Header & Summary -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-white font-['Outfit'] flex items-center space-x-2">
                <span>Audit & WAF Defense Monitor</span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-500/15 text-rose-400 border border-rose-500/30">
                    Active Shield
                </span>
            </h1>
            <p class="text-sm text-slate-400 mt-0.5">Monitoring real-time proteksi WAF anti-pentest, SQLi, XSS, Path Traversal, serta jejak audit operasional.</p>
        </div>
    </div>

    <!-- Security KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="glass-card p-5 border-dark-border/80 bg-[#121B2F]/80">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Serangan Terblokir (WAF)</span>
            <div class="text-2xl sm:text-3xl font-black text-rose-400 font-['Outfit'] mt-2 flex items-center space-x-2">
                <span>{{ $stats['attacks_blocked'] }}</span>
                <span class="p-1 rounded-lg bg-rose-500/10 text-rose-400 text-xs">Blocked</span>
            </div>
            <div class="text-xs text-slate-500 mt-1">SQLi, XSS & Directory Traversal</div>
        </div>

        <div class="glass-card p-5 border-dark-border/80 bg-[#121B2F]/80">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tindakan Admin</span>
            <div class="text-2xl sm:text-3xl font-black text-cyan-400 font-['Outfit'] mt-2">
                {{ $stats['admin_actions'] }}
            </div>
            <div class="text-xs text-slate-500 mt-1">Perubahan katalog & konfigurasi</div>
        </div>

        <div class="glass-card p-5 border-dark-border/80 bg-[#121B2F]/80">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Login Berhasil Hari Ini</span>
            <div class="text-2xl sm:text-3xl font-black text-emerald-400 font-['Outfit'] mt-2">
                {{ $stats['logins_today'] }}
            </div>
            <div class="text-xs text-slate-500 mt-1">Aktivitas autentikasi user</div>
        </div>

        <div class="glass-card p-5 border-dark-border/80 bg-[#121B2F]/80">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Audit Log</span>
            <div class="text-2xl sm:text-3xl font-black text-white font-['Outfit'] mt-2">
                {{ $stats['total_logs'] }}
            </div>
            <div class="text-xs text-slate-500 mt-1">Immutable security ledger</div>
        </div>
    </div>

    <!-- Filter Buttons & Search -->
    <div class="glass-card p-4 border-dark-border/80 bg-[#121B2F]/80">
        <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
                <a href="{{ route('admin.activity-logs.index') }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold {{ !request()->has('filter') ? 'bg-indigo-600 text-white' : 'bg-slate-800 text-slate-400 hover:text-white' }} transition-colors">
                    Semua Log
                </a>
                <a href="{{ route('admin.activity-logs.index', ['filter' => 'attacks']) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold {{ request('filter') === 'attacks' ? 'bg-rose-600 text-white' : 'bg-rose-500/10 text-rose-300 hover:bg-rose-500/20' }} transition-colors flex items-center space-x-1.5">
                    <span class="w-2 h-2 rounded-full bg-rose-400 animate-pulse"></span>
                    <span>WAF Serangan Terblokir ({{ $stats['attacks_blocked'] }})</span>
                </a>
            </div>
            <div class="w-full sm:w-72">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari IP, deskripsi, payload..." class="form-input text-xs w-full">
            </div>
        </form>
    </div>

    <!-- Activity Logs Table -->
    <div class="glass-card overflow-hidden border-dark-border/80 bg-[#121B2F]/80">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="border-b border-dark-border/80 text-[11px] font-bold text-slate-400 uppercase tracking-wider bg-dark-card/50">
                        <th class="py-3.5 px-6">Waktu</th>
                        <th class="py-3.5 px-6">Jenis Event</th>
                        <th class="py-3.5 px-6">Deskripsi</th>
                        <th class="py-3.5 px-6">Pelaku (User)</th>
                        <th class="py-3.5 px-6">IP Address & Agent</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-dark-border/40 font-mono text-xs">
                    @forelse($logs as $log)
                        @php
                            $isAttack = $log->action === 'SECURITY_ATTACK_BLOCKED';
                            $isAdmin = str_starts_with($log->action, 'ADMIN_');
                        @endphp
                        <tr class="hover:bg-slate-800/40 transition-colors {{ $isAttack ? 'bg-rose-950/20' : '' }}">
                            <td class="py-4 px-6 text-slate-400 whitespace-nowrap">
                                {{ $log->created_at->format('d/m/Y H:i:s') }}
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap">
                                @if($isAttack)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-rose-500/20 text-rose-300 border border-rose-500/40">
                                        🛡️ WAF_ATTACK_BLOCKED
                                    </span>
                                @elseif($isAdmin)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-amber-500/15 text-amber-300 border border-amber-500/30">
                                        ⚙️ {{ $log->action }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-blue-500/15 text-blue-300 border border-blue-500/30">
                                        {{ $log->action }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 font-sans text-slate-200">
                                <div>{{ $log->description }}</div>
                                @if($log->new_values)
                                    <div class="mt-1 text-[11px] text-slate-500 truncate max-w-md font-mono">
                                        {{ json_encode($log->new_values) }}
                                    </div>
                                @endif
                            </td>
                            <td class="py-4 px-6 font-sans">
                                @if($log->user)
                                    <span class="font-semibold text-white">{{ $log->user->name }}</span>
                                    <div class="text-[11px] text-slate-500">{{ $log->user->email }}</div>
                                @else
                                    <span class="text-slate-500 italic">Unauthenticated</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-slate-400">
                                <div class="text-cyan-400 font-semibold">{{ $log->ip_address ?? '-' }}</div>
                                <div class="text-[10px] text-slate-500 truncate max-w-xs" title="{{ $log->user_agent }}">
                                    {{ $log->user_agent ?? '-' }}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-500 font-sans">
                                Belum ada log aktivitas yang tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($logs->hasPages())
            <div class="p-4 border-t border-dark-border/80">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
