<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>500 - Gangguan Server | GameTopUp</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#080C14] text-slate-100 min-h-screen flex items-center justify-center p-4">
    <div class="glass-card max-w-md w-full p-8 text-center space-y-5 border-rose-500/30">
        <div class="w-16 h-16 rounded-2xl bg-rose-500/15 text-rose-400 flex items-center justify-center mx-auto border border-rose-500/30">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
        <h1 class="text-3xl font-black text-white font-['Outfit']">500 - Terjadi Kesalahan</h1>
        <p class="text-sm text-slate-400">
            Terjadi kendala teknis internal pada server. Tim kami telah diberitahu dan sedang menanganinya. Silakan coba kembali beberapa saat lagi.
        </p>
        <div class="pt-2">
            <a href="{{ url('/') }}" class="btn-primary w-full py-2.5 text-xs">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>
