<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 - Akses Ditolak | GameTopUp</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#080C14] text-slate-100 min-h-screen flex items-center justify-center p-4">
    <div class="glass-card max-w-md w-full p-8 text-center space-y-5 border-rose-500/30">
        <div class="w-16 h-16 rounded-2xl bg-rose-500/15 text-rose-400 flex items-center justify-center mx-auto border border-rose-500/30">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v.01M12 9v2m9-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <h1 class="text-3xl font-black text-white font-['Outfit']">403 - Akses Ditolak</h1>
        <p class="text-sm text-slate-400">
            {{ $exception->getMessage() ?: 'Anda tidak memiliki izin untuk mengakses resource atau halaman ini.' }}
        </p>
        <div class="pt-2">
            <a href="{{ url('/') }}" class="btn-primary w-full py-2.5 text-xs">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>
