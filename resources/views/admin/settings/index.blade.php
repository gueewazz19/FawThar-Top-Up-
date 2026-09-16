@extends('layouts.admin')

@section('page_title', 'Pengaturan Situs & Konfigurasi')

@section('content')
<div class="space-y-6 max-w-4xl">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-black text-white font-['Outfit']">Pengaturan Situs</h1>
        <p class="text-sm text-slate-400 mt-0.5">Konfigurasikan informasi umum toko, kontak bantuan pelanggan, dan pengaturan keamanan situs.</p>
    </div>

    <!-- Settings Form -->
    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
        @csrf

        <!-- General Info Section -->
        <div class="glass-card p-6 border-dark-border/80 bg-[#121B2F]/80 space-y-4">
            <h3 class="text-base font-bold text-white font-['Outfit'] flex items-center space-x-2">
                <span class="p-1.5 rounded-lg bg-indigo-500/10 text-indigo-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </span>
                <span>Informasi Umum Toko</span>
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label text-xs">Nama Website</label>
                    <input type="text" name="site_name" value="{{ old('site_name', $settings['site_name']) }}" required class="form-input text-sm w-full">
                </div>
                <div>
                    <label class="form-label text-xs">Tagline / Slogan</label>
                    <input type="text" name="site_tagline" value="{{ old('site_tagline', $settings['site_tagline']) }}" required class="form-input text-sm w-full">
                </div>
            </div>

            <div>
                <label class="form-label text-xs">Deskripsi Meta SEO</label>
                <textarea name="meta_description" rows="3" class="form-input text-sm w-full">{{ old('meta_description', $settings['meta_description']) }}</textarea>
                <p class="text-[11px] text-slate-500 mt-1">Ditampilkan di mesin pencari Google saat pengguna mencari website Anda.</p>
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
                <span>Kontak Bantuan & Customer Service</span>
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="form-label text-xs">Email Dukungan Pelanggan</label>
                    <input type="email" name="support_email" value="{{ old('support_email', $settings['support_email']) }}" required class="form-input text-sm w-full">
                </div>
                <div>
                    <label class="form-label text-xs">WhatsApp Customer Care</label>
                    <input type="text" name="support_whatsapp" value="{{ old('support_whatsapp', $settings['support_whatsapp']) }}" required class="form-input text-sm w-full">
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
@endsection
