@extends('layouts.auth')

@section('title', 'Daftar Akun Baru')

@section('content')
<div class="glass-card p-6 sm:p-8 border-slate-200 dark:border-dark-border">
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-slate-900 dark:text-white font-['Outfit']">Buat Akun Baru</h2>
        <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Daftar sekarang untuk mendapatkan diskon member dan transaksi instan.</p>
    </div>

    <form method="POST" action="{{ route('register.submit') }}" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                placeholder="Contoh: Budi Pratama"
                class="form-input @error('name') border-rose-500 @enderror">
            @error('name')
                <p class="text-xs text-rose-500 dark:text-rose-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Alamat Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                placeholder="nama@email.com"
                class="form-input @error('email') border-rose-500 @enderror">
            @error('email')
                <p class="text-xs text-rose-500 dark:text-rose-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="phone" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Nomor WhatsApp / HP (Opsional)</label>
            <input id="phone" type="tel" name="phone" value="{{ old('phone') }}"
                placeholder="Contoh: 081234567890"
                class="form-input @error('phone') border-rose-500 @enderror">
            @error('phone')
                <p class="text-xs text-rose-500 dark:text-rose-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Kata Sandi (Min. 8 Karakter)</label>
            <input id="password" type="password" name="password" required
                placeholder="••••••••"
                class="form-input @error('password') border-rose-500 @enderror">
            @error('password')
                <p class="text-xs text-rose-500 dark:text-rose-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">Konfirmasi Kata Sandi</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                placeholder="••••••••"
                class="form-input">
        </div>

        <button type="submit" class="btn-primary w-full py-3 mt-4">
            Daftar Sekarang
        </button>
    </form>

    <div class="mt-6 pt-5 border-t border-slate-200 dark:border-dark-border text-center text-xs text-slate-500 dark:text-slate-400">
        Sudah memiliki akun?
        <a href="{{ route('login') }}" class="text-emerald-600 dark:text-emerald-400 hover:underline font-semibold ml-1">
            Masuk di Sini
        </a>
    </div>
</div>
@endsection
