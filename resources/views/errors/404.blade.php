<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Halaman Tidak Ditemukan | GameTopUp</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#080C14] text-slate-100 min-h-screen flex items-center justify-center p-4">
    <div class="glass-card max-w-md w-full p-8 text-center space-y-5 border-dark-border">
        <div class="w-16 h-16 rounded-2xl bg-emerald-500/15 text-emerald-400 flex items-center justify-center mx-auto border border-emerald-500/30">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <h1 class="text-3xl font-black text-white font-['Outfit']">404 - Tidak Ditemukan</h1>
        <p class="text-sm text-slate-400">
            Halaman atau konten yang Anda cari tidak tersedia atau telah dipindahkan.
        </p>
        <div class="pt-2">
            <a href="{{ url('/') }}" class="btn-primary w-full py-2.5 text-xs">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>
