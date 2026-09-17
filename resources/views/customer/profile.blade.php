@extends('layouts.app')

@section('title', 'Profil Pengguna - ' . config('app.name', 'GameTopUp'))

@section('content')
<div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
    <!-- Breadcrumb -->
    <nav class="flex items-center space-x-2 text-xs text-slate-500 dark:text-slate-400">
        <a href="{{ route('home') }}" class="hover:text-emerald-500 transition-colors">Beranda</a>
        <span>/</span>
        <span class="text-slate-900 dark:text-white font-semibold">Profil Saya</span>
    </nav>

    <!-- Profile Header Card -->
    <div class="glass-card p-6 sm:p-8 border-slate-200 dark:border-dark-border/80 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 relative overflow-hidden">
        <div class="absolute -right-16 -top-16 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="flex items-center space-x-5 z-10">
            <!-- Gamer Avatar with Photo / Initials -->
            <div class="relative group flex-shrink-0">
                <img id="avatar_display" src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-20 h-20 rounded-2xl object-cover shadow-xl shadow-indigo-500/20 border-2 border-white/20 bg-slate-800">
                @if($user->provider === 'google')
                    <span title="Akun Terhubung Google" class="absolute -bottom-1 -right-1 p-1 bg-white dark:bg-slate-800 rounded-full shadow-md border border-slate-200 dark:border-slate-700">
                        <svg class="w-4 h-4" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                        </svg>
                    </span>
                @endif
            </div>

            <div class="space-y-1">
                <div class="flex items-center space-x-3 flex-wrap gap-y-1">
                    <h1 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white font-['Outfit']">
                        {{ $user->name }}
                    </h1>
                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-black uppercase tracking-wider border {{ $stats['loyalty_tier']['badge'] }}">
                        <span class="mr-1">{{ $stats['loyalty_tier']['icon'] }}</span>
                        <span>{{ $stats['loyalty_tier']['name'] }}</span>
                    </span>
                </div>
                <div class="text-xs text-slate-500 dark:text-slate-400 flex items-center space-x-3">
                    <span>{{ $user->email }}</span>
                    <span>•</span>
                    <span>Bergabung {{ $user->created_at->translatedFormat('d F Y') }}</span>
                </div>
                @if($user->phone)
                    <div class="text-xs text-slate-500 dark:text-slate-400">
                        WhatsApp: <strong class="text-slate-700 dark:text-slate-300 font-mono">{{ $user->phone }}</strong>
                    </div>
                @endif
            </div>
        </div>

        <div class="flex items-center space-x-2 z-10">
            <a href="{{ route('dashboard') }}" class="btn-secondary text-xs px-4 py-2.5 flex items-center space-x-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <span>Riwayat Pesanan</span>
            </a>
        </div>
    </div>

    <!-- User KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="glass-card p-5 border-slate-200 dark:border-dark-border/80">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Transaksi</span>
            <div class="text-2xl font-black text-slate-900 dark:text-white font-['Outfit'] mt-2">
                {{ $stats['total_orders'] }} Pesanan
            </div>
            <div class="text-[11px] text-slate-400 mt-0.5">Semua riwayat pengisian</div>
        </div>

        <div class="glass-card p-5 border-slate-200 dark:border-dark-border/80">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Transaksi Sukses</span>
            <div class="text-2xl font-black text-emerald-500 font-['Outfit'] mt-2">
                {{ $stats['successful_orders'] }} Sukses
            </div>
            <div class="text-[11px] text-slate-400 mt-0.5">Diamond berhasil terkirim</div>
        </div>

        <div class="glass-card p-5 border-slate-200 dark:border-dark-border/80">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Belanja</span>
            <div class="text-2xl font-black text-indigo-600 dark:text-indigo-400 font-['Outfit'] mt-2">
                Rp {{ number_format($stats['total_spent'], 0, ',', '.') }}
            </div>
            <div class="text-[11px] text-slate-400 mt-0.5">Akumulasi pengeluaran akun</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Forms Column (7 cols) -->
        <div class="lg:col-span-7 space-y-8">
            <!-- Edit Profile Form -->
            <div class="glass-card p-6 sm:p-8 border-slate-200 dark:border-dark-border/80 space-y-5">
                <h3 class="text-base font-bold text-slate-900 dark:text-white font-['Outfit'] flex items-center space-x-2">
                    <span class="p-1.5 rounded-lg bg-indigo-500/10 text-indigo-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </span>
                    <span>Informasi Biodata & Kontak</span>
                </h3>

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <!-- Avatar Upload -->
                    <div>
                        <label class="form-label text-xs font-bold text-slate-700 dark:text-slate-300">Foto Profil</label>
                        <div class="flex items-center space-x-4 p-3 rounded-xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800">
                            <img id="form_avatar_preview" src="{{ $user->avatar_url }}" class="w-14 h-14 rounded-xl object-cover border border-slate-300 dark:border-slate-700 flex-shrink-0 bg-slate-800">
                            <div class="space-y-1.5 flex-1">
                                <div class="flex flex-wrap items-center gap-2">
                                    <label for="avatar_input" class="cursor-pointer inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-500/20 border border-indigo-500/30 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                        </svg>
                                        <span>Ganti Foto</span>
                                    </label>
                                    <input type="file" id="avatar_input" name="avatar" accept="image/*" class="hidden" onchange="previewUserAvatar(this)">

                                    @if($user->avatar)
                                        <label class="inline-flex items-center space-x-1.5 text-xs text-rose-500 hover:text-rose-600 cursor-pointer select-none px-2.5 py-1.5 rounded-lg bg-rose-500/10 border border-rose-500/20">
                                            <input type="checkbox" name="remove_avatar" value="1" class="w-3.5 h-3.5 rounded bg-slate-800 border-slate-700 text-rose-500 focus:ring-rose-500">
                                            <span>Hapus Foto</span>
                                        </label>
                                    @endif
                                </div>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400">
                                    @if($user->provider === 'google')
                                        Foto profil saat ini disinkronkan otomatis dari Google. Anda juga dapat mengunggah foto custom.
                                    @else
                                        Format JPG, PNG, atau WEBP (Maksimal 2MB).
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="form-label text-xs font-bold text-slate-700 dark:text-slate-300">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="form-input text-sm w-full">
                    </div>

                    <div>
                        <label class="form-label text-xs font-bold text-slate-700 dark:text-slate-300">Alamat Email</label>
                        <input type="email" value="{{ $user->email }}" disabled class="form-input text-sm w-full bg-slate-100 dark:bg-slate-900/60 opacity-70 cursor-not-allowed">
                        <p class="text-[11px] text-slate-400 mt-1">Email akun terdaftar tidak dapat diubah demi keamanan akun.</p>
                    </div>

                    <div>
                        <label class="form-label text-xs font-bold text-slate-700 dark:text-slate-300">Nomor WhatsApp</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 081234567890" class="form-input text-sm w-full">
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="btn-primary text-xs px-5 py-2.5">
                            Simpan Perubahan Biodata
                        </button>
                    </div>
                </form>
            </div>

            <!-- Change Password Form -->
            <div class="glass-card p-6 sm:p-8 border-slate-200 dark:border-dark-border/80 space-y-5">
                <h3 class="text-base font-bold text-slate-900 dark:text-white font-['Outfit'] flex items-center space-x-2">
                    <span class="p-1.5 rounded-lg bg-amber-500/10 text-amber-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </span>
                    <span>Keamanan Akun & Ganti Kata Sandi</span>
                </h3>

                <form method="POST" action="{{ route('profile.password') }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="form-label text-xs font-bold text-slate-700 dark:text-slate-300">Kata Sandi Saat Ini</label>
                        <input type="password" name="current_password" required placeholder="Masukkan kata sandi saat ini" class="form-input text-sm w-full">
                        @error('current_password')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label text-xs font-bold text-slate-700 dark:text-slate-300">Kata Sandi Baru</label>
                            <input type="password" name="password" required minlength="8" placeholder="Minimal 8 karakter" class="form-input text-sm w-full">
                            @error('password')
                                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="form-label text-xs font-bold text-slate-700 dark:text-slate-300">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" name="password_confirmation" required minlength="8" placeholder="Ulangi kata sandi baru" class="form-input text-sm w-full">
                        </div>
                    </div>

                    <div class="flex justify-end pt-2">
                        <button type="submit" class="btn-primary text-xs px-5 py-2.5">
                            Perbarui Kata Sandi
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Recent Orders Sidebar (5 cols) -->
        <div class="lg:col-span-5 space-y-6">
            <div class="glass-card p-6 border-slate-200 dark:border-dark-border/80 space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-bold text-slate-900 dark:text-white font-['Outfit']">Pesanan Terbaru</h3>
                    <a href="{{ route('dashboard') }}" class="text-xs text-indigo-500 hover:underline">Semua</a>
                </div>

                <div class="divide-y divide-slate-200 dark:divide-dark-border/40">
                    @forelse($recentOrders as $order)
                        <div class="py-3.5 flex items-center justify-between text-xs">
                            <div>
                                <div class="font-bold text-slate-900 dark:text-white">{{ $order->game->name ?? 'Game' }}</div>
                                <div class="text-[11px] text-slate-400 font-mono">{{ $order->order_number }}</div>
                                <div class="text-[10px] text-slate-500 mt-0.5">{{ $order->created_at->diffForHumans() }}</div>
                            </div>
                            <div class="text-right space-y-1">
                                <div class="font-black text-slate-900 dark:text-white">{{ $order->formatted_total }}</div>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $order->status->badgeClass() }}">
                                    {{ $order->status->label() }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="py-8 text-center text-slate-400 text-xs">
                            Belum ada pesanan yang tercatat.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewUserAvatar(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('form_avatar_preview');
                const display = document.getElementById('avatar_display');
                if (preview) preview.src = e.target.result;
                if (display) display.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
