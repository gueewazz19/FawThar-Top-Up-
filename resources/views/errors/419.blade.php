<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>419 - Sesi Kedaluwarsa | GameTopUp</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#080C14] text-slate-100 min-h-screen flex items-center justify-center p-4">
    <div class="glass-card max-w-md w-full p-8 text-center space-y-5 border-amber-500/30">
        <div class="w-16 h-16 rounded-2xl bg-amber-500/15 text-amber-400 flex items-center justify-center mx-auto border border-amber-500/30">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <h1 class="text-3xl font-black text-white font-['Outfit']">419 - Sesi Kedaluwarsa</h1>
        <p class="text-sm text-slate-400">
            Token keamanan form telah kedaluwarsa demi melindungi akun Anda. Silakan muat ulang halaman dan ulangi tindakan Anda.
        </p>
        <div class="pt-2">
            <button onclick="window.location.reload()" class="btn-primary w-full py-2.5 text-xs">
                Muat Ulang Halaman
            </button>
        </div>
    </div>
</body>
</html>
