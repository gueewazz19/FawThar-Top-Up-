@extends('layouts.app')

@section('title', 'Invoice Pembayaran #' . $order->order_number . ' - ' . config('app.name', 'GameTopUp'))

@section('content')
<div class="py-12 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <nav class="flex items-center space-x-2 text-xs text-slate-500 dark:text-slate-400 mb-6">
        <a href="{{ route('home') }}" class="hover:text-emerald-500 transition-colors">Beranda</a>
        <span>/</span>
        <span class="text-slate-900 dark:text-white font-semibold">Invoice #{{ $order->order_number }}</span>
    </nav>

    <!-- Top Status Banner -->
    @if($order->status->value === 'SUCCESS')
        <div class="mb-8 p-6 rounded-2xl bg-emerald-500/10 border-2 border-emerald-500/40 text-emerald-300 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-500 text-slate-950 flex items-center justify-center flex-shrink-0 font-black text-xl shadow-lg shadow-emerald-500/30">
                    ✓
                </div>
                <div>
                    <h2 class="text-lg font-black text-white font-['Outfit']">Pembayaran Berhasil & Top-Up Selesai!</h2>
                    <p class="text-xs text-emerald-400 mt-0.5">Item game telah otomatis ditambahkan ke akun {{ $order->player_id }}. Terima kasih telah berbelanja!</p>
                </div>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-emerald-500 text-slate-950">
                Lunas
            </span>
        </div>
    @else
        <div class="mb-8 p-6 rounded-2xl bg-amber-500/10 border-2 border-amber-500/30 text-amber-300 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-500 text-slate-950 flex items-center justify-center flex-shrink-0 font-black text-xl shadow-lg shadow-amber-500/30 animate-pulse">
                    ⏳
                </div>
                <div>
                    <h2 class="text-lg font-black text-white font-['Outfit']">Menunggu Pembayaran</h2>
                    <p class="text-xs text-amber-400/90 mt-0.5">Selesaikan pembayaran sebelum batas waktu berakhir agar pesanan segera diproses otomatis.</p>
                </div>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-amber-500 text-slate-950 animate-pulse">
                Pending
            </span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
        <!-- Main Invoice Body (8 cols) -->
        <div class="md:col-span-8 space-y-6">
            <!-- Payment Channel Instruction Box -->
            <div class="glass-card p-6 sm:p-8 border-slate-200 dark:border-dark-border/80 text-center space-y-4">
                <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Tagihan Yang Harus Dibayar</div>
                <div class="text-3xl sm:text-4xl font-black text-emerald-500 font-['Outfit'] tracking-tight flex items-center justify-center space-x-2">
                    <span>{{ $order->formatted_total }}</span>
                    <button type="button" onclick="copyToClipboard('{{ (int) $order->total }}', 'Jumlah tagihan disalin!')" title="Salin Jumlah" class="p-1 text-slate-400 hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                        </svg>
                    </button>
                </div>

                @if($order->status->value === 'PENDING_PAYMENT')
                    <!-- Payment QR / VA Display -->
                    @if(str_contains(strtoupper($order->payment->payment_method ?? ''), 'QRIS'))
                        <div class="pt-4 border-t border-slate-200 dark:border-dark-border/60 flex flex-col items-center">
                            <div class="p-4 bg-white rounded-2xl shadow-xl inline-block border-2 border-slate-300">
                                <!-- Standard QRIS Stylized Matrix SVG -->
                                <svg class="w-48 h-48 text-slate-950" viewBox="0 0 100 100" fill="currentColor">
                                    <path d="M0 0h30v30H0zm5 5v20h20V5zm5 5h10v10H10zM70 0h30v30H70zm5 5v20h20V5zm5 5h10v10H80zM0 70h30v30H0zm5 5v20h20V75zm5 5h10v10H10zM40 10h10v10H40zm10 0h10v10H50zm-10 20h10v10H40zm20 0h10v10H60zm-20 20h10v10H40zm20 0h10v10H60zm10 0h10v10H70zm20 0h10v10H90zm-50 10h10v10H40zm20 0h10v10H60zm-20 20h10v10H40zm10 0h10v10H50zm10 0h10v10H60zm20 0h10v10H80zm10 0h10v10H90z"/>
                                </svg>
                            </div>
                            <div class="mt-3 text-xs font-bold text-slate-700 dark:text-slate-300">
                                QRIS Standar Nasional Indonesia
                            </div>
                            <p class="text-[11px] text-slate-500 max-w-sm mt-1">
                                Buka aplikasi GoPay, OVO, DANA, ShopeePay, BCA Mobile, Livin, atau Mobile Banking lainnya lalu scan kode QR di atas.
                            </p>
                        </div>
                    @else
                        <!-- Virtual Account Code Display -->
                        <div class="pt-4 border-t border-slate-200 dark:border-dark-border/60 space-y-2">
                            <div class="text-xs text-slate-400">Nomor Virtual Account (VA):</div>
                            <div class="flex items-center justify-center space-x-3">
                                <span class="font-mono text-2xl font-black text-white tracking-widest bg-slate-900 px-4 py-2 rounded-xl border border-slate-700">
                                    {{ $order->payment->provider_response['va_number'] ?? '880192847192' }}
                                </span>
                                <button type="button" onclick="copyToClipboard('{{ $order->payment->provider_response['va_number'] ?? '880192847192' }}', 'Nomor Virtual Account disalin!')" class="px-3 py-2 rounded-xl bg-indigo-600 text-white text-xs font-bold hover:bg-indigo-500 transition-colors">
                                    Salin
                                </button>
                            </div>
                            <p class="text-[11px] text-slate-500">
                                Masukkan nomor VA di atas pada menu Transfer Virtual Account m-Banking atau ATM Anda.
                            </p>
                        </div>
                    @endif
                @endif
            </div>

            <!-- Testing / Simulation Mode Box -->
            @if($order->status->value === 'PENDING_PAYMENT')
                <div class="p-6 rounded-2xl bg-indigo-950/40 border border-indigo-500/40 space-y-3">
                    <div class="flex items-center space-x-2 text-indigo-400 text-xs font-bold uppercase tracking-wider">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <span>Mode Uji Coba Cepat (Simulator Pembayaran)</span>
                    </div>
                    <p class="text-xs text-slate-300">
                        Ingin menguji apakah sistem berhasil memproses order hingga status sukses? Klik tombol di bawah ini untuk mensimulasikan pembayaran lunas seketika.
                    </p>
                    <form method="POST" action="{{ route('topup.simulate_pay', $order->order_number) }}">
                        @csrf
                        <button type="submit" class="btn-primary w-full py-2.5 text-xs font-bold flex items-center justify-center space-x-2">
                            <span>⚡ Konfirmasi & Simulasikan Pembayaran Lunas Sekarang</span>
                        </button>
                    </form>
                </div>
            @endif

            <!-- Order Items Detail -->
            <div class="glass-card p-6 border-slate-200 dark:border-dark-border/80 space-y-4">
                <h3 class="text-sm font-bold text-slate-900 dark:text-white font-['Outfit'] uppercase tracking-wider">
                    Rincian Pembelian
                </h3>
                <div class="divide-y divide-slate-200 dark:divide-dark-border/40 text-sm">
                    @foreach($order->items as $item)
                        <div class="py-3 flex justify-between items-center">
                            <div>
                                <div class="font-bold text-slate-900 dark:text-white">{{ $item->product_name }}</div>
                                <div class="text-xs text-slate-500">{{ $order->game->name }} ({{ $item->quantity }}x)</div>
                            </div>
                            <div class="font-bold text-slate-900 dark:text-white">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                    <div class="py-3 flex justify-between text-xs text-slate-500">
                        <span>Biaya Pembayaran (Gateway)</span>
                        <span class="font-semibold text-slate-700 dark:text-slate-300">{{ $order->formatted_fee }}</span>
                    </div>
                    <div class="pt-4 flex justify-between items-center text-base font-black text-slate-900 dark:text-white">
                        <span>Total Akhir</span>
                        <span class="text-emerald-500 font-['Outfit'] text-xl">{{ $order->formatted_total }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Summary Info (4 cols) -->
        <div class="md:col-span-4 space-y-6">
            <!-- Account Destination Info -->
            <div class="glass-card p-6 border-slate-200 dark:border-dark-border/80 space-y-4 text-xs">
                <h3 class="font-bold text-slate-900 dark:text-white font-['Outfit'] uppercase tracking-wider text-sm">
                    Data Tujuan Top-Up
                </h3>

                <div class="space-y-3">
                    <div class="p-3 rounded-xl bg-slate-100 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800">
                        <span class="text-slate-500 block mb-0.5">Game</span>
                        <span class="font-bold text-slate-900 dark:text-white text-sm">{{ $order->game->name }}</span>
                    </div>

                    <div class="p-3 rounded-xl bg-slate-100 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800">
                        <span class="text-slate-500 block mb-0.5">User ID / Player ID</span>
                        <span class="font-mono font-bold text-cyan-500 dark:text-cyan-400 text-sm">{{ $order->player_id }}</span>
                    </div>

                    @if($order->server_id)
                        <div class="p-3 rounded-xl bg-slate-100 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800">
                            <span class="text-slate-500 block mb-0.5">Server / Zone ID</span>
                            <span class="font-mono font-bold text-amber-500 dark:text-amber-400 text-sm">{{ $order->server_id }}</span>
                        </div>
                    @endif

                    <div class="p-3 rounded-xl bg-slate-100 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800">
                        <span class="text-slate-500 block mb-0.5">Nomor Pesanan</span>
                        <span class="font-mono font-bold text-slate-700 dark:text-slate-300 text-xs">{{ $order->order_number }}</span>
                    </div>

                    <div class="p-3 rounded-xl bg-slate-100 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800">
                        <span class="text-slate-500 block mb-0.5">Waktu Transaksi</span>
                        <span class="text-slate-700 dark:text-slate-300">{{ $order->created_at->translatedFormat('d M Y, H:i') }} WIB</span>
                    </div>
                </div>

                <div class="pt-2 border-t border-slate-200 dark:border-dark-border/60">
                    <a href="{{ route('home') }}" class="btn-secondary w-full py-2.5 text-xs text-center flex items-center justify-center space-x-1">
                        <span>Kembali ke Beranda</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="toastNotification" class="hidden fixed bottom-6 right-6 z-50 px-4 py-3 rounded-xl bg-slate-900 text-white text-xs shadow-2xl border border-slate-700 flex items-center space-x-2">
    <span class="text-emerald-400">✓</span>
    <span id="toastMessage">Teks berhasil disalin!</span>
</div>

<script>
    function copyToClipboard(text, message) {
        navigator.clipboard.writeText(text).then(() => {
            const toast = document.getElementById('toastNotification');
            document.getElementById('toastMessage').textContent = message || 'Berhasil disalin!';
            toast.classList.remove('hidden');
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 2500);
        });
    }
</script>
@endsection
