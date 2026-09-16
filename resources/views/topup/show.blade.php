@extends('layouts.app')

@section('title', 'Top Up ' . $game->name . ' - ' . config('app.name', 'GameTopUp'))

@section('content')
<div class="py-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <nav class="flex items-center space-x-2 text-xs text-slate-500 dark:text-slate-400 mb-6">
        <a href="{{ route('home') }}" class="hover:text-emerald-500 transition-colors">Beranda</a>
        <span>/</span>
        <a href="{{ route('home') }}#games" class="hover:text-emerald-500 transition-colors">Game</a>
        <span>/</span>
        <span class="text-slate-900 dark:text-white font-semibold">{{ $game->name }}</span>
    </nav>

    <form method="POST" action="{{ route('topup.checkout', $game->slug) }}" id="topupForm">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left Column: Game Profile & Instructions (4 cols) -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Game Info Card -->
                <div class="glass-card overflow-hidden border-slate-200 dark:border-dark-border/80 sticky top-28">
                    <!-- Banner / Logo -->
                    <div class="aspect-[16/9] w-full relative bg-slate-900 overflow-hidden">
                        <img src="{{ $game->banner ?: $game->logo }}" alt="{{ $game->name }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 right-4 flex items-center space-x-3">
                            <img src="{{ $game->logo }}" alt="{{ $game->name }}" class="w-14 h-14 rounded-xl border-2 border-white/20 shadow-lg object-cover flex-shrink-0">
                            <div>
                                <h1 class="text-lg font-black text-white font-['Outfit'] truncate">{{ $game->name }}</h1>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 uppercase">
                                    {{ $game->category->name ?? 'Mobile Game' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Description & Guarantees -->
                    <div class="p-6 space-y-4">
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                            {{ $game->description }}
                        </p>

                        <div class="p-3.5 rounded-xl bg-slate-100 dark:bg-[#0B101D] border border-slate-200 dark:border-dark-border/60 space-y-2.5 text-xs">
                            <div class="flex items-center space-x-2 text-slate-700 dark:text-slate-300">
                                <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span>Proses Pengisian Otomatis 1 - 3 Detik</span>
                            </div>
                            <div class="flex items-center space-x-2 text-slate-700 dark:text-slate-300">
                                <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span>100% Legal & Bergaransi Anti-Banned</span>
                            </div>
                            <div class="flex items-center space-x-2 text-slate-700 dark:text-slate-300">
                                <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span>Layanan Customer Care 24 Jam Nonstop</span>
                            </div>
                        </div>

                        <!-- How to Find ID -->
                        <div class="pt-2 border-t border-slate-200 dark:border-dark-border/60">
                            <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Cara Menemukan Akun:</div>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">
                                Buka profil game Anda di dalam aplikasi, klik avatar/nama pemain Anda untuk melihat dan menyalin nomor ID Anda.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: 4 Order Steps (8 cols) -->
            <div class="lg:col-span-8 space-y-8">
                @if ($errors->any())
                    <div class="p-4 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-400 text-sm space-y-1">
                        <div class="font-bold flex items-center space-x-2">
                            <svg class="w-5 h-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Terdapat data yang belum lengkap:</span>
                        </div>
                        <ul class="list-disc list-inside text-xs pl-2 space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- STEP 1: Akun Game -->
                <div class="glass-card p-6 sm:p-8 border-slate-200 dark:border-dark-border/80">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-8 h-8 rounded-full bg-indigo-600 text-white font-black text-sm flex items-center justify-center flex-shrink-0 shadow-md shadow-indigo-600/30">
                            1
                        </div>
                        <div>
                            <h2 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white font-['Outfit']">Masukkan Data Akun</h2>
                            <p class="text-xs text-slate-500">Pastikan ID game Anda sudah benar sebelum melakukan transaksi.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 {{ $game->requires_server_id ? 'sm:grid-cols-2' : '' }} gap-4">
                        <div>
                            <label class="form-label text-xs font-bold text-slate-700 dark:text-slate-300">
                                {{ $game->user_id_label ?? 'User ID / Player ID' }} <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="player_id" value="{{ old('player_id') }}" required
                                placeholder="Masukkan {{ $game->user_id_label ?? 'User ID' }}"
                                class="form-input text-sm w-full font-mono bg-white dark:bg-[#0B101D] border-slate-300 dark:border-dark-border focus:border-indigo-500">
                        </div>

                        @if($game->requires_server_id)
                            <div>
                                <label class="form-label text-xs font-bold text-slate-700 dark:text-slate-300">
                                    {{ $game->server_id_label ?? 'Server / Zone ID' }} <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="server_id" value="{{ old('server_id') }}" required
                                    placeholder="Masukkan {{ $game->server_id_label ?? 'Zone ID' }}"
                                    class="form-input text-sm w-full font-mono bg-white dark:bg-[#0B101D] border-slate-300 dark:border-dark-border focus:border-indigo-500">
                            </div>
                        @endif
                    </div>
                </div>

                <!-- STEP 2: Pilih Nominal -->
                <div class="glass-card p-6 sm:p-8 border-slate-200 dark:border-dark-border/80">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-8 h-8 rounded-full bg-indigo-600 text-white font-black text-sm flex items-center justify-center flex-shrink-0 shadow-md shadow-indigo-600/30">
                            2
                        </div>
                        <div>
                            <h2 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white font-['Outfit']">Pilih Nominal Top-Up</h2>
                            <p class="text-xs text-slate-500">Pilih paket diamond, voucher, atau pass yang ingin dibeli.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 sm:gap-4">
                        @forelse($game->products as $product)
                            <label class="product-card cursor-pointer relative p-4 rounded-xl border border-slate-200 dark:border-dark-border/80 bg-slate-50/70 dark:bg-[#0B101D] hover:border-indigo-500 transition-all flex flex-col justify-between select-none group">
                                <input type="radio" name="product_id" value="{{ $product->id }}" data-price="{{ (int) $product->price }}" data-name="{{ $product->name }}"
                                    class="hidden" {{ old('product_id') == $product->id ? 'checked' : '' }} onchange="selectProduct(this)">
                                
                                @if($product->is_popular)
                                    <span class="absolute -top-2.5 right-2 px-2 py-0.5 rounded-full text-[9px] font-black uppercase tracking-wider bg-amber-500 text-slate-950 shadow-sm">
                                        Populer
                                    </span>
                                @endif

                                <div>
                                    <div class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                        {{ $product->name }}
                                    </div>
                                    <div class="text-[11px] text-slate-500 mt-0.5">
                                        {{ $product->currency_amount }} Unit
                                    </div>
                                </div>

                                <div class="mt-3 pt-2 border-t border-slate-200 dark:border-dark-border/60 flex items-center justify-between">
                                    <span class="text-xs sm:text-sm font-black text-emerald-600 dark:text-emerald-400 font-['Outfit']">
                                        {{ $product->formatted_price }}
                                    </span>
                                    <div class="check-icon hidden w-4 h-4 rounded-full bg-indigo-600 text-white items-center justify-center text-[10px]">
                                        ✓
                                    </div>
                                </div>
                            </label>
                        @empty
                            <div class="col-span-full py-8 text-center text-slate-500">
                                Paket untuk game ini sedang dipersiapkan.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- STEP 3: Pilih Metode Pembayaran -->
                <div class="glass-card p-6 sm:p-8 border-slate-200 dark:border-dark-border/80">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-8 h-8 rounded-full bg-indigo-600 text-white font-black text-sm flex items-center justify-center flex-shrink-0 shadow-md shadow-indigo-600/30">
                            3
                        </div>
                        <div>
                            <h2 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white font-['Outfit']">Pilih Metode Pembayaran</h2>
                            <p class="text-xs text-slate-500">Tersedia pembayaran instan via QRIS, Virtual Account, dan E-Wallet.</p>
                        </div>
                    </div>

                    <div class="space-y-5">
                        @foreach($paymentMethods as $groupKey => $group)
                            <div class="space-y-2.5">
                                <div class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider flex items-center space-x-2">
                                    <span>{{ $group['name'] }}</span>
                                    <span class="text-[10px] text-slate-400 font-normal">({{ $group['description'] }})</span>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    @foreach($group['channels'] as $channel)
                                        <label class="payment-card cursor-pointer p-3.5 rounded-xl border border-slate-200 dark:border-dark-border/80 bg-slate-50/70 dark:bg-[#0B101D] hover:border-indigo-500 transition-all flex items-center justify-between select-none relative">
                                            <input type="radio" name="payment_method" value="{{ $channel['code'] }}" data-fee="{{ $channel['fee'] }}" data-name="{{ $channel['name'] }}"
                                                class="hidden" {{ old('payment_method') == $channel['code'] ? 'checked' : '' }} onchange="selectPayment(this)">
                                            
                                            <div class="flex items-center space-x-3">
                                                <div class="w-10 h-10 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center font-bold text-xs text-indigo-600 dark:text-indigo-400 uppercase shadow-sm">
                                                    {{ substr($channel['code'], 0, 4) }}
                                                </div>
                                                <div>
                                                    <div class="text-xs font-bold text-slate-900 dark:text-white">{{ $channel['name'] }}</div>
                                                    <div class="text-[11px] text-slate-500">Biaya: Rp {{ number_format($channel['fee'], 0, ',', '.') }}</div>
                                                </div>
                                            </div>

                                            <div class="flex items-center space-x-2">
                                                <span class="text-[10px] px-2 py-0.5 rounded bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 font-bold border border-emerald-500/20">
                                                    {{ $channel['badge'] }}
                                                </span>
                                                <div class="pay-check-icon hidden w-4 h-4 rounded-full bg-indigo-600 text-white items-center justify-center text-[10px]">
                                                    ✓
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- STEP 4: Konfirmasi & Beli -->
                <div class="glass-card p-6 sm:p-8 border-slate-200 dark:border-dark-border/80">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-8 h-8 rounded-full bg-indigo-600 text-white font-black text-sm flex items-center justify-center flex-shrink-0 shadow-md shadow-indigo-600/30">
                            4
                        </div>
                        <div>
                            <h2 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white font-['Outfit']">Nomor Kontak & Konfirmasi</h2>
                            <p class="text-xs text-slate-500">Bukti transaksi dan kode invoice akan otomatis dikirimkan ke kontak Anda.</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label class="form-label text-xs font-bold text-slate-700 dark:text-slate-300">
                                Nomor WhatsApp Anda <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="whatsapp" value="{{ old('whatsapp', auth()->user()->phone ?? '') }}" required
                                placeholder="Contoh: 081234567890"
                                class="form-input text-sm w-full bg-white dark:bg-[#0B101D] border-slate-300 dark:border-dark-border focus:border-indigo-500">
                            <p class="text-[11px] text-slate-500 mt-1">Kami menggunakan nomor WhatsApp ini untuk konfirmasi status otomatis jika terjadi kendala pengisian.</p>
                        </div>

                        <!-- Live Order Summary Box -->
                        <div class="p-5 rounded-2xl bg-indigo-950/20 border border-indigo-500/30 dark:bg-[#0E1527] space-y-3 text-sm">
                            <div class="text-xs font-bold text-indigo-400 uppercase tracking-wider">Ringkasan Pembelian</div>
                            
                            <div class="flex justify-between text-slate-600 dark:text-slate-400 text-xs">
                                <span>Game</span>
                                <span class="font-bold text-slate-900 dark:text-white">{{ $game->name }}</span>
                            </div>
                            <div class="flex justify-between text-slate-600 dark:text-slate-400 text-xs">
                                <span>Paket Terpilih</span>
                                <span id="summaryProductName" class="font-bold text-slate-900 dark:text-white text-right">Belum Dipilih</span>
                            </div>
                            <div class="flex justify-between text-slate-600 dark:text-slate-400 text-xs">
                                <span>Metode Pembayaran</span>
                                <span id="summaryPaymentName" class="font-bold text-slate-900 dark:text-white text-right">Belum Dipilih</span>
                            </div>
                            <div class="flex justify-between text-slate-600 dark:text-slate-400 text-xs">
                                <span>Biaya Layanan Gateway</span>
                                <span id="summaryFee" class="font-bold text-slate-900 dark:text-white">Rp 0</span>
                            </div>
                            
                            <div class="pt-3 border-t border-indigo-500/20 flex items-center justify-between">
                                <span class="font-bold text-slate-900 dark:text-white text-sm">Total Tagihan:</span>
                                <span id="summaryTotalPrice" class="text-xl sm:text-2xl font-black text-emerald-500 font-['Outfit']">
                                    Rp 0
                                </span>
                            </div>
                        </div>

                        <button type="submit" id="submitBtn" class="btn-primary w-full py-3.5 text-sm sm:text-base font-bold flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span>Beli Sekarang & Bayar</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    let selectedPrice = 0;
    let selectedFee = 0;

    function formatRupiah(number) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
    }

    function selectProduct(input) {
        document.querySelectorAll('.product-card').forEach(card => {
            card.classList.remove('border-indigo-600', 'ring-2', 'ring-indigo-500/30', 'bg-indigo-500/10');
            const icon = card.querySelector('.check-icon');
            if (icon) icon.classList.add('hidden');
            if (icon) icon.classList.remove('flex');
        });

        const card = input.closest('.product-card');
        card.classList.add('border-indigo-600', 'ring-2', 'ring-indigo-500/30', 'bg-indigo-500/10');
        const icon = card.querySelector('.check-icon');
        if (icon) {
            icon.classList.remove('hidden');
            icon.classList.add('flex');
        }

        selectedPrice = parseInt(input.getAttribute('data-price')) || 0;
        document.getElementById('summaryProductName').textContent = input.getAttribute('data-name');
        updateTotal();
    }

    function selectPayment(input) {
        document.querySelectorAll('.payment-card').forEach(card => {
            card.classList.remove('border-indigo-600', 'ring-2', 'ring-indigo-500/30', 'bg-indigo-500/10');
            const icon = card.querySelector('.pay-check-icon');
            if (icon) icon.classList.add('hidden');
            if (icon) icon.classList.remove('flex');
        });

        const card = input.closest('.payment-card');
        card.classList.add('border-indigo-600', 'ring-2', 'ring-indigo-500/30', 'bg-indigo-500/10');
        const icon = card.querySelector('.pay-check-icon');
        if (icon) {
            icon.classList.remove('hidden');
            icon.classList.add('flex');
        }

        selectedFee = parseInt(input.getAttribute('data-fee')) || 0;
        document.getElementById('summaryPaymentName').textContent = input.getAttribute('data-name');
        document.getElementById('summaryFee').textContent = formatRupiah(selectedFee);
        updateTotal();
    }

    function updateTotal() {
        const total = selectedPrice + selectedFee;
        document.getElementById('summaryTotalPrice').textContent = formatRupiah(total);
    }

    // Auto-select if re-populating from validation old input
    document.addEventListener('DOMContentLoaded', function() {
        const checkedProduct = document.querySelector('input[name="product_id"]:checked');
        if (checkedProduct) selectProduct(checkedProduct);

        const checkedPayment = document.querySelector('input[name="payment_method"]:checked');
        if (checkedPayment) selectPayment(checkedPayment);
    });
</script>
@endsection
