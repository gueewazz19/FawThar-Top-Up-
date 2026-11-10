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
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-6">
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
                <label class="form-label text-xs">Unggah Logo Website (PNG / JPG / WEBP / SVG)</label>
                <div class="flex flex-col sm:flex-row sm:items-center gap-4 p-4 rounded-2xl bg-slate-900/60 border border-slate-800">
                    <div id="logo_preview_container" class="w-16 h-16 rounded-2xl bg-slate-800/90 border border-slate-700 flex items-center justify-center overflow-hidden flex-shrink-0 shadow-lg relative group transition-opacity">
                        @if(!empty($settings['site_logo']))
                            <img id="logo_preview_img" src="{{ $settings['site_logo'] }}" class="w-full h-full object-contain p-1.5">
                        @else
                            <div id="logo_preview_placeholder" class="flex flex-col items-center justify-center text-slate-500">
                                <svg class="w-7 h-7 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-[9px] font-bold mt-0.5 text-slate-400">Default</span>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 space-y-2">
                        <div class="flex flex-wrap items-center gap-3">
                            <label for="site_logo_file" class="cursor-pointer inline-flex items-center space-x-2 px-4 py-2 rounded-xl text-xs font-bold bg-cyan-500/10 text-cyan-300 hover:bg-cyan-500/20 border border-cyan-500/30 transition-colors shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                <span>Pilih File Logo Baru</span>
                            </label>
                            <input type="file" id="site_logo_file" name="site_logo_file" accept="image/*" class="hidden" onchange="previewUploadedLogo(this)">
                            
                            @if(!empty($settings['site_logo']))
                                <label class="inline-flex items-center space-x-2 text-xs text-rose-400 hover:text-rose-300 cursor-pointer select-none px-3 py-1.5 rounded-lg bg-rose-500/10 border border-rose-500/20">
                                    <input type="checkbox" name="remove_logo" value="1" class="w-3.5 h-3.5 rounded bg-slate-800 border-slate-700 text-rose-500 focus:ring-rose-500" onchange="toggleRemoveLogo(this)">
                                    <span>Hapus Logo Saat Ini</span>
                                </label>
                            @endif
                        </div>
                        <p id="file_selected_name" class="text-[11px] text-slate-400">
                            Upload file logo tanpa perlu URL (format PNG transparan, JPG, WEBP, atau SVG, maks. 2MB).
                        </p>
                    </div>
                </div>
            </div>

            <div>
                <label class="form-label text-xs">Deskripsi Meta SEO</label>
                <textarea name="meta_description" rows="2" class="form-input text-sm w-full">{{ old('meta_description', $settings['meta_description']) }}</textarea>
                <p class="text-[11px] text-slate-500 mt-0.5">Teks ringkasan toko di mesin pencarian Google.</p>
            </div>
        </div>

        <!-- Guest / Landing Page Background Section -->
        <div class="glass-card p-6 border-dark-border/80 bg-[#121B2F]/80 space-y-5">
            <div class="flex items-center justify-between flex-wrap gap-2">
                <h3 class="text-base font-bold text-white font-['Outfit'] flex items-center space-x-2">
                    <span class="p-1.5 rounded-lg bg-indigo-500/10 text-indigo-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </span>
                    <span>Latar Belakang Tampilan Tamu / Beranda (Guest Background)</span>
                </h3>
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-indigo-500/15 text-indigo-300 border border-indigo-500/30">
                    Tampilan Awal Pengunjung
                </span>
            </div>
            <p class="text-xs text-slate-400 -mt-2">
                Sesuaikan tampilan latar belakang untuk pengunjung yang belum login atau saat berada di halaman depan website. Anda dapat memilih warna solid, mengunggah gambar latar kustom, dan mengaktifkan pola garis grid geometris.
            </p>

            <!-- Background Type Selector -->
            <div>
                <label class="form-label text-xs block mb-2 font-semibold text-slate-300">Pilih Tipe Latar Belakang</label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <label class="relative flex items-center p-3.5 rounded-xl bg-slate-900/80 border cursor-pointer transition-all {{ $settings['guest_bg_type'] === 'default' ? 'border-indigo-500 ring-2 ring-indigo-500/30 bg-indigo-950/20' : 'border-slate-800 hover:border-slate-700' }}">
                        <input type="radio" name="guest_bg_type" value="default" class="sr-only" {{ $settings['guest_bg_type'] === 'default' ? 'checked' : '' }} onchange="switchBgType('default')">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-800 border border-slate-700 flex items-center justify-center text-indigo-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div>
                                <span class="text-xs font-bold text-white block">Bawaan Sistem</span>
                                <span class="text-[10px] text-slate-400 block">Mesh gradient halus & ambient glow</span>
                            </div>
                        </div>
                    </label>

                    <label class="relative flex items-center p-3.5 rounded-xl bg-slate-900/80 border cursor-pointer transition-all {{ $settings['guest_bg_type'] === 'color' ? 'border-indigo-500 ring-2 ring-indigo-500/30 bg-indigo-950/20' : 'border-slate-800 hover:border-slate-700' }}">
                        <input type="radio" name="guest_bg_type" value="color" class="sr-only" {{ $settings['guest_bg_type'] === 'color' ? 'checked' : '' }} onchange="switchBgType('color')">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-cyan-500 to-indigo-500 border border-slate-700 flex items-center justify-center text-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                </svg>
                            </div>
                            <div>
                                <span class="text-xs font-bold text-white block">Warna Solid</span>
                                <span class="text-[10px] text-slate-400 block">Pilihan warna kustom atau preset</span>
                            </div>
                        </div>
                    </label>

                    <label class="relative flex items-center p-3.5 rounded-xl bg-slate-900/80 border cursor-pointer transition-all {{ $settings['guest_bg_type'] === 'image' ? 'border-indigo-500 ring-2 ring-indigo-500/30 bg-indigo-950/20' : 'border-slate-800 hover:border-slate-700' }}">
                        <input type="radio" name="guest_bg_type" value="image" class="sr-only" {{ $settings['guest_bg_type'] === 'image' ? 'checked' : '' }} onchange="switchBgType('image')">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-600/20 border border-emerald-500/40 flex items-center justify-center text-emerald-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <span class="text-xs font-bold text-white block">Gambar Kustom</span>
                                <span class="text-[10px] text-slate-400 block">Unggah foto atau artwork game</span>
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Panel 1: Color Configuration -->
            <div id="panel_bg_color" class="p-4 rounded-2xl bg-slate-900/60 border border-slate-800 space-y-3 {{ $settings['guest_bg_type'] === 'color' ? '' : 'hidden' }}">
                <div class="flex items-center justify-between">
                    <label class="form-label text-xs font-bold text-white">Pilih Warna Background</label>
                    <span class="text-[10px] text-slate-400">Klik warna atau masukkan kode Hex</span>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <div class="flex items-center space-x-2.5 p-2 rounded-xl bg-slate-800 border border-slate-700">
                        <input type="color" id="bg_color_picker" value="{{ old('guest_bg_color', $settings['guest_bg_color']) }}" class="w-8 h-8 rounded-lg cursor-pointer bg-transparent border-0" oninput="syncColorInput(this.value)">
                        <input type="text" id="guest_bg_color" name="guest_bg_color" value="{{ old('guest_bg_color', $settings['guest_bg_color']) }}" placeholder="#080C14" class="form-input text-xs w-28 bg-slate-900 border-slate-700 uppercase font-mono font-bold" oninput="syncColorPicker(this.value)">
                    </div>

                    <!-- Popular Preset Chips -->
                    <div class="flex flex-wrap items-center gap-1.5">
                        <span class="text-[10px] text-slate-500 font-semibold mr-1">Preset:</span>
                        <button type="button" onclick="setColorPreset('#080C14')" class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-[#080C14] text-white border border-slate-700 hover:border-indigo-400 flex items-center space-x-1">
                            <span class="w-2 h-2 rounded-full bg-slate-600"></span>
                            <span>Dark Slate</span>
                        </button>
                        <button type="button" onclick="setColorPreset('#0B132B')" class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-[#0B132B] text-white border border-slate-700 hover:border-indigo-400 flex items-center space-x-1">
                            <span class="w-2 h-2 rounded-full bg-cyan-400"></span>
                            <span>Midnight Blue</span>
                        </button>
                        <button type="button" onclick="setColorPreset('#0F172A')" class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-[#0F172A] text-white border border-slate-700 hover:border-indigo-400 flex items-center space-x-1">
                            <span class="w-2 h-2 rounded-full bg-indigo-400"></span>
                            <span>Deep Navy</span>
                        </button>
                        <button type="button" onclick="setColorPreset('#071E1B')" class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-[#071E1B] text-white border border-slate-700 hover:border-indigo-400 flex items-center space-x-1">
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                            <span>Cyber Emerald</span>
                        </button>
                        <button type="button" onclick="setColorPreset('#180F2A')" class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-[#180F2A] text-white border border-slate-700 hover:border-indigo-400 flex items-center space-x-1">
                            <span class="w-2 h-2 rounded-full bg-purple-400"></span>
                            <span>Mystic Violet</span>
                        </button>
                        <button type="button" onclick="setColorPreset('#F8FAFC')" class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-[#F8FAFC] text-slate-900 border border-slate-300 hover:border-indigo-400 flex items-center space-x-1">
                            <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                            <span>Clean Light</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Panel 2: Image Configuration -->
            <div id="panel_bg_image" class="p-4 rounded-2xl bg-slate-900/60 border border-slate-800 space-y-4 {{ $settings['guest_bg_type'] === 'image' ? '' : 'hidden' }}">
                <label class="form-label text-xs font-bold text-white block">Unggah Gambar Latar Belakang (PNG / JPG / WEBP)</label>
                
                <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                    <div id="bg_image_preview_container" class="w-28 h-20 rounded-2xl bg-slate-800/90 border border-slate-700 flex items-center justify-center overflow-hidden flex-shrink-0 shadow-lg relative group transition-all">
                        @if(!empty($settings['guest_bg_image']))
                            <img id="bg_image_preview_img" src="{{ $settings['guest_bg_image'] }}" class="w-full h-full object-cover">
                        @else
                            <div id="bg_image_placeholder" class="flex flex-col items-center justify-center text-slate-500">
                                <svg class="w-6 h-6 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-[9px] font-bold mt-1 text-slate-400">Belum ada</span>
                            </div>
                        @endif
                    </div>

                    <div class="flex-1 space-y-2">
                        <div class="flex flex-wrap items-center gap-3">
                            <label for="guest_bg_image_file" class="cursor-pointer inline-flex items-center space-x-2 px-4 py-2 rounded-xl text-xs font-bold bg-indigo-500/10 text-indigo-300 hover:bg-indigo-500/20 border border-indigo-500/30 transition-colors shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                <span>Pilih File Gambar Latar</span>
                            </label>
                            <input type="file" id="guest_bg_image_file" name="guest_bg_image_file" accept="image/*" class="hidden" onchange="previewUploadedBgImage(this)">

                            @if(!empty($settings['guest_bg_image']))
                                <label class="inline-flex items-center space-x-2 text-xs text-rose-400 hover:text-rose-300 cursor-pointer select-none px-3 py-1.5 rounded-lg bg-rose-500/10 border border-rose-500/20">
                                    <input type="checkbox" name="remove_guest_bg_image" value="1" class="w-3.5 h-3.5 rounded bg-slate-800 border-slate-700 text-rose-500 focus:ring-rose-500" onchange="toggleRemoveBgImage(this)">
                                    <span>Hapus Gambar Latar Saat Ini</span>
                                </label>
                            @endif
                        </div>
                        <p id="bg_file_selected_name" class="text-[11px] text-slate-400">
                            Disarankan menggunakan gambar beresolusi 1920x1080px (Maks. 4MB). Gambar akan otomatis beradaptasi (cover) di layar desktop & HP.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Grid Lines Pattern Toggle (sesuai garis-garis setiap tampilannya) -->
            <div class="p-4 rounded-xl bg-slate-900/60 border border-slate-800 flex items-start space-x-3">
                <input type="checkbox" id="guest_bg_pattern" name="guest_bg_pattern" value="1" {{ $settings['guest_bg_pattern'] ? 'checked' : '' }} class="mt-1 rounded border-slate-700 text-brand-600 focus:ring-brand-500" onchange="updateLivePreview()">
                <label for="guest_bg_pattern" class="cursor-pointer">
                    <span class="font-bold text-white text-xs block">Aktifkan Pola Garis Grid Geometris (Grid Lines Pattern)</span>
                    <span class="text-[11px] text-slate-400 block mt-0.5">
                        Menampilkan tekstur garis-garis grid tipis transparan yang selaras dengan garis pembatas tiap section (Hero, Promo, Katalog Game, Panduan, FAQ) agar halaman terlihat futuristik dan modern.
                    </span>
                </label>
            </div>

            <!-- Interactive Live Preview Box -->
            <div>
                <span class="text-xs font-bold text-slate-300 block mb-2">Simulasi Tampilan Latar Belakang (Live Preview):</span>
                <div id="live_bg_preview" class="relative rounded-2xl p-4 overflow-hidden border border-slate-700 h-28 flex items-center justify-between shadow-inner transition-all duration-300" style="background-color: {{ $settings['guest_bg_type'] === 'color' ? $settings['guest_bg_color'] : '#080C14' }};">
                    <!-- Preview Pattern Overlay -->
                    <div id="preview_grid_lines" class="absolute inset-0 pointer-events-none transition-opacity duration-200 {{ $settings['guest_bg_pattern'] ? 'opacity-100' : 'opacity-0' }}" style="background-image: linear-gradient(to right, rgba(255,255,255,0.06) 1px, transparent 1px), linear-gradient(to bottom, rgba(255,255,255,0.06) 1px, transparent 1px); background-size: 24px 24px;"></div>
                    
                    <!-- Preview Background Image Layer -->
                    <div id="preview_img_layer" class="absolute inset-0 bg-cover bg-center pointer-events-none transition-opacity duration-300 {{ $settings['guest_bg_type'] === 'image' && !empty($settings['guest_bg_image']) ? 'opacity-100' : 'opacity-0' }}" style="{{ !empty($settings['guest_bg_image']) ? 'background-image: url(' . $settings['guest_bg_image'] . ');' : '' }}"></div>
                    <div class="absolute inset-0 bg-slate-950/40 pointer-events-none"></div>

                    <!-- Mock Floating Card Content to demonstrate contrast -->
                    <div class="relative z-10 flex items-center space-x-3 bg-white/10 dark:bg-slate-900/80 backdrop-blur-md px-3.5 py-2 rounded-xl border border-white/20">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold text-xs border border-emerald-500/30">
                            🎮
                        </div>
                        <div>
                            <div class="text-xs font-bold text-white">Mobile Legends: Bang Bang</div>
                            <div class="text-[10px] text-emerald-400 font-medium">Contoh Konten Kartu Game</div>
                        </div>
                    </div>

                    <div class="relative z-10 px-3 py-1.5 rounded-xl bg-indigo-600 text-white text-[11px] font-bold shadow-md">
                        Top Up Sekarang
                    </div>
                </div>
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
    let currentBgType = "{{ $settings['guest_bg_type'] }}";

    function switchBgType(type) {
        currentBgType = type;
        const colorPanel = document.getElementById('panel_bg_color');
        const imagePanel = document.getElementById('panel_bg_image');

        if (type === 'color') {
            colorPanel.classList.remove('hidden');
            imagePanel.classList.add('hidden');
        } else if (type === 'image') {
            colorPanel.classList.add('hidden');
            imagePanel.classList.remove('hidden');
        } else {
            colorPanel.classList.add('hidden');
            imagePanel.classList.add('hidden');
        }

        // Highlight active radio parent card
        document.querySelectorAll('input[name="guest_bg_type"]').forEach(radio => {
            const card = radio.closest('label');
            if (radio.value === type) {
                card.classList.add('border-indigo-500', 'ring-2', 'ring-indigo-500/30', 'bg-indigo-950/20');
                card.classList.remove('border-slate-800');
            } else {
                card.classList.remove('border-indigo-500', 'ring-2', 'ring-indigo-500/30', 'bg-indigo-950/20');
                card.classList.add('border-slate-800');
            }
        });

        updateLivePreview();
    }

    function syncColorInput(val) {
        document.getElementById('guest_bg_color').value = val.toUpperCase();
        updateLivePreview();
    }

    function syncColorPicker(val) {
        if (/^#[0-9A-F]{6}$/i.test(val)) {
            document.getElementById('bg_color_picker').value = val;
            updateLivePreview();
        }
    }

    function setColorPreset(hex) {
        document.getElementById('bg_color_picker').value = hex;
        document.getElementById('guest_bg_color').value = hex;
        updateLivePreview();
    }

    function previewUploadedBgImage(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const nameEl = document.getElementById('bg_file_selected_name');
            if (nameEl) {
                nameEl.innerHTML = `<span class="text-emerald-400 font-semibold">File siap diupload: ${file.name} (${(file.size / 1024).toFixed(1)} KB)</span>`;
            }
            const reader = new FileReader();
            reader.onload = function(e) {
                const container = document.getElementById('bg_image_preview_container');
                container.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                container.classList.remove('opacity-40');

                // Update live preview layer
                const imgLayer = document.getElementById('preview_img_layer');
                if (imgLayer) {
                    imgLayer.style.backgroundImage = `url(${e.target.result})`;
                    imgLayer.classList.remove('opacity-0');
                    imgLayer.classList.add('opacity-100');
                }
            };
            reader.readAsDataURL(file);
        }
    }

    function toggleRemoveBgImage(checkbox) {
        const container = document.getElementById('bg_image_preview_container');
        const imgLayer = document.getElementById('preview_img_layer');
        if (checkbox.checked) {
            container.classList.add('opacity-30', 'grayscale');
            if (imgLayer) imgLayer.classList.add('opacity-0');
        } else {
            container.classList.remove('opacity-30', 'grayscale');
            if (imgLayer && currentBgType === 'image') imgLayer.classList.remove('opacity-0');
        }
    }

    function updateLivePreview() {
        const previewBox = document.getElementById('live_bg_preview');
        const gridLines = document.getElementById('preview_grid_lines');
        const imgLayer = document.getElementById('preview_img_layer');
        const patternChecked = document.getElementById('guest_bg_pattern').checked;
        const colorVal = document.getElementById('guest_bg_color').value || '#080C14';

        if (gridLines) {
            if (patternChecked) {
                gridLines.classList.remove('opacity-0');
                gridLines.classList.add('opacity-100');
            } else {
                gridLines.classList.add('opacity-0');
                gridLines.classList.remove('opacity-100');
            }
        }

        if (currentBgType === 'color') {
            previewBox.style.backgroundColor = colorVal;
            if (imgLayer) imgLayer.classList.add('opacity-0');
        } else if (currentBgType === 'image') {
            previewBox.style.backgroundColor = '#080C14';
            if (imgLayer) imgLayer.classList.remove('opacity-0');
        } else {
            previewBox.style.backgroundColor = '#080C14';
            if (imgLayer) imgLayer.classList.add('opacity-0');
        }
    }

    function previewUploadedLogo(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const nameEl = document.getElementById('file_selected_name');
            if (nameEl) {
                nameEl.innerHTML = `<span class="text-emerald-400 font-semibold">File siap diupload: ${file.name} (${(file.size / 1024).toFixed(1)} KB)</span>`;
            }
            const reader = new FileReader();
            reader.onload = function(e) {
                const container = document.getElementById('logo_preview_container');
                container.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-contain p-1.5">`;
                container.classList.remove('opacity-40');
            };
            reader.readAsDataURL(file);
        }
    }

    function toggleRemoveLogo(checkbox) {
        const container = document.getElementById('logo_preview_container');
        if (checkbox.checked) {
            container.classList.add('opacity-30', 'grayscale');
        } else {
            container.classList.remove('opacity-30', 'grayscale');
        }
    }
</script>
@endsection
