@extends('layouts.auth')

@section('title', 'Masuk Akun')

@section('content')
<div class="glass-card p-6 sm:p-8">
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-white font-['Outfit']">Masuk ke Akun Anda</h2>
        <p class="text-sm text-slate-400 mt-1">Lakukan top up game lebih cepat dan amankan riwayat transaksi Anda.</p>
    </div>

    <!-- Demo Account Quick Fill helper -->
    <div class="mb-6 p-3 rounded-xl bg-dark-bg/80 border border-dark-border/80">
        <div class="text-[11px] font-bold text-brand-400 uppercase tracking-wider mb-2 flex items-center space-x-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>Akun Demo Cepat (Klik untuk Mengisi):</span>
        </div>
        <div class="grid grid-cols-2 gap-2">
            <button type="button" onclick="fillAdmin()" class="px-2.5 py-1.5 rounded-lg text-xs font-medium text-amber-300 bg-amber-500/15 hover:bg-amber-500/25 border border-amber-500/30 transition-all text-left">
                👑 <strong>Akun Admin</strong><br><span class="text-[10px] text-slate-400">admin@gametopup.test</span>
            </button>
            <button type="button" onclick="fillCustomer()" class="px-2.5 py-1.5 rounded-lg text-xs font-medium text-cyan-300 bg-cyan-500/15 hover:bg-cyan-500/25 border border-cyan-500/30 transition-all text-left">
                🎮 <strong>Akun Customer</strong><br><span class="text-[10px] text-slate-400">customer@gametopup.test</span>
            </button>
        </div>
    </div>

    <form method="POST" action="{{ route('login.submit') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">Alamat Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                placeholder="nama@email.com"
                class="form-input @error('email') border-rose-500 @enderror">
            @error('email')
                <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Kata Sandi</label>
            </div>
            <input id="password" type="password" name="password" required
                placeholder="••••••••"
                class="form-input @error('password') border-rose-500 @enderror">
            @error('password')
                <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between pt-1">
            <label class="flex items-center space-x-2 text-xs text-slate-400 cursor-pointer">
                <input type="checkbox" name="remember" class="rounded bg-dark-bg border-dark-border text-brand-500 focus:ring-brand-400">
                <span>Ingat saya di perangkat ini</span>
            </label>
        </div>

        <button type="submit" class="btn-primary w-full py-3 mt-2">
            Masuk Sekarang
        </button>
    </form>

    <div class="mt-6 pt-5 border-t border-dark-border text-center text-xs text-slate-400">
        Belum memiliki akun?
        <a href="{{ route('register') }}" class="text-brand-400 hover:text-brand-300 font-semibold ml-1">
            Daftar Gratis
        </a>
    </div>
</div>

<script>
    function fillAdmin() {
        document.getElementById('email').value = 'admin@gametopup.test';
        document.getElementById('password').value = 'password123';
    }
    function fillCustomer() {
        document.getElementById('email').value = 'customer@gametopup.test';
        document.getElementById('password').value = 'password123';
    }
</script>
@endsection
