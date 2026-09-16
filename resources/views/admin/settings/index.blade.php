@extends('layouts.admin')

@section('page_title', 'Pengaturan Situs & Konfigurasi')

@section('content')
<div class="space-y-6 max-w-4xl">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-black text-white font-['Outfit']">Pengaturan Situs</h1>
        <p class="text-sm text-slate-400 mt-0.5">Konfigurasikan logo, nama toko, kontak bantuan, dan akun media sosial resmi website Anda.</p>
    </div>

    <!-- Settings Form -->
    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
        @csrf

        <!-- Branding & Logo Section -->
        <div class="glass-card p-6 border-dark-border/80 bg-[#121B2F]/80 space-y-4">
            <h3 class="text-base font-bold text-white font-['Outfit'] flex items-center space-x-2">
                <span class="p-1.5 rounded-lg bg-cyan-500/10 text-cyan-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                    </svg>
                </span>
                <span>Branding & Logo Website</span>
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label text-xs">Nama Website / Toko</label>
                    <input type="text" name="site_name" value="{{ old('site_name', $settings['site_name']) }}" required placeholder="Contoh: Fawthar TopUp" class="form-input text-sm w-full">
                    <p class="text-[11px] text-slate-500 mt-1">Nama ini akan tampil di navbar publik, footer, dan sidebar admin.</p>
                </div>
                <div>
                    <label class="form-label text-xs">Tagline / Slogan</label>
                    <input type="text" name="site_tagline" value="{{ old('site_tagline', $settings['site_tagline']) }}" required placeholder="Top Up Game Tercepat, Termurah & Terpercaya" class="form-input text-sm w-full">
                </div>
            </div>

            <div>
                <label class="form-label text-xs">URL Logo Website (Opsional)</label>
                <div class="flex items-center space-x-3">
                    <input type="text" id="site_logo_input" name="site_logo" value="{{ old('site_logo', $settings['site_logo']) }}" placeholder="https://domain.com/logo.png atau kosongkan untuk icon bawaan" class="form-input text-sm w-full" oninput="previewLogo(this.value)">
                    <div id="logo_preview_container" class="w-10 h-10 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center overflow-hidden flex-shrink-0">
                        @if($settings['site_logo'])
                            <img id="logo_preview_img" src="{{ $settings['site_logo'] }}" class="w-full h-full object-cover">
                        @else
                            <span id="logo_preview_placeholder" class="text-xs font-bold text-amber-400">Logo</span>
                        @endif
                    </div>
                </div>
                <p class="text-[11px] text-slate-500 mt-1">Jika diisi, logo gambar ini akan menggantikan ikon default di navbar guest dan admin.</p>
            </div>

            <div>
                <label class="form-label text-xs">Deskripsi Meta SEO</label>
                <textarea name="meta_description" rows="2" class="form-input text-sm w-full">{{ old('meta_description', $settings['meta_description']) }}</textarea>
                <p class="text-[11px] text-slate-500 mt-0.5">Teks ringkasan toko di mesin pencarian Google.</p>
            </div>
        </div>

        <!-- Contact Support Section -->
        <div class="glass-card p-6 border-dark-border/80 bg-[#121B2F]/80 space-y-4">
            <h3 class="text-base font-bold text-white font-['Outfit'] flex items-center space-x-2">
                <span class="p-1.5 rounded-lg bg-emerald-500/10 text-emerald-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                </span>
                <span>Kontak Layanan & Bantuan (Tersambung ke Footer)</span>
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="form-label text-xs">Nomor WhatsApp CS</label>
                    <input type="text" name="support_whatsapp" value="{{ old('support_whatsapp', $settings['support_whatsapp']) }}" required placeholder="+628123456789" class="form-input text-sm w-full">
                    <p class="text-[10px] text-slate-500 mt-1">Otomatis membuka chat WhatsApp saat diklik di footer.</p>
                </div>
                <div>
                    <label class="form-label text-xs">Nomor Telepon / Call Center</label>
                    <input type="text" name="support_phone" value="{{ old('support_phone', $settings['support_phone']) }}" placeholder="0812-3456-7890" class="form-input text-sm w-full">
                    <p class="text-[10px] text-slate-500 mt-1">Nomor telepon bantuan yang tampil di footer.</p>
                </div>
                <div>
                    <label class="form-label text-xs">Email Dukungan Pelanggan</label>
                    <input type="email" name="support_email" value="{{ old('support_email', $settings['support_email']) }}" required placeholder="cs@domain.com" class="form-input text-sm w-full">
                    <p class="text-[10px] text-slate-500 mt-1">Otomatis membuka form kirim email di footer.</p>
                </div>
            </div>
        </div>

        <!-- Social Media Channels Section -->
        <div class="glass-card p-6 border-dark-border/80 bg-[#121B2F]/80 space-y-4">
            <h3 class="text-base font-bold text-white font-['Outfit'] flex items-center space-x-2">
                <span class="p-1.5 rounded-lg bg-pink-500/10 text-pink-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                    </svg>
                </span>
                <span>Akun Media Sosial Resmi (Tersambung ke Footer)</span>
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="form-label text-xs flex items-center space-x-1.5">
                        <span class="text-pink-400 font-bold">Instagram URL</span>
                    </label>
                    <input type="url" name="social_instagram" value="{{ old('social_instagram', $settings['social_instagram']) }}" placeholder="https://instagram.com/akun_anda" class="form-input text-sm w-full">
                    <p class="text-[10px] text-slate-500 mt-1">Link saat ikon Instagram di footer diklik.</p>
                </div>
                <div>
                    <label class="form-label text-xs flex items-center space-x-1.5">
                        <span class="text-blue-400 font-bold">Facebook URL</span>
                    </label>
                    <input type="url" name="social_facebook" value="{{ old('social_facebook', $settings['social_facebook']) }}" placeholder="https://facebook.com/halaman_anda" class="form-input text-sm w-full">
                    <p class="text-[10px] text-slate-500 mt-1">Link saat ikon Facebook di footer diklik.</p>
                </div>
                <div>
                    <label class="form-label text-xs flex items-center space-x-1.5">
                        <span class="text-cyan-400 font-bold">TikTok URL</span>
                    </label>
                    <input type="url" name="social_tiktok" value="{{ old('social_tiktok', $settings['social_tiktok']) }}" placeholder="https://tiktok.com/@akun_anda" class="form-input text-sm w-full">
                    <p class="text-[10px] text-slate-500 mt-1">Link saat ikon TikTok di footer diklik.</p>
                </div>
            </div>
        </div>

        <!-- Maintenance & Operation Mode -->
        <div class="glass-card p-6 border-dark-border/80 bg-[#121B2F]/80 space-y-4">
            <h3 class="text-base font-bold text-white font-['Outfit'] flex items-center space-x-2">
                <span class="p-1.5 rounded-lg bg-amber-500/10 text-amber-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </span>
                <span>Mode Pemeliharaan (Maintenance Mode)</span>
            </h3>

            <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-800 flex items-start space-x-3">
                <input type="checkbox" id="maintenance_mode" name="maintenance_mode" value="1" {{ $settings['maintenance_mode'] ? 'checked' : '' }} class="mt-1 rounded border-slate-700 text-brand-600 focus:ring-brand-500">
                <label for="maintenance_mode" class="cursor-pointer">
                    <span class="font-bold text-white text-sm block">Aktifkan Mode Maintenance</span>
                    <span class="text-xs text-slate-400 block mt-0.5">Jika diaktifkan, pengunjung umum akan melihat halaman pemeliharaan dan tidak dapat melakukan pesanan baru. Admin tetap dapat mengakses portal.</span>
                </label>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="btn-primary text-sm px-6 py-2.5">
                Simpan Perubahan Pengaturan
            </button>
        </div>
    </form>
</div>

<script>
    function previewLogo(url) {
        const container = document.getElementById('logo_preview_container');
        if (url && url.startsWith('http')) {
            container.innerHTML = `<img src="${url}" class="w-full h-full object-cover" onerror="this.onerror=null; this.parentElement.innerHTML='<span class=\\'text-xs text-rose-400\\'>Error</span>'">`;
        } else {
            container.innerHTML = `<span class="text-xs font-bold text-amber-400">Logo</span>`;
        }
    }
</script>
@endsection
