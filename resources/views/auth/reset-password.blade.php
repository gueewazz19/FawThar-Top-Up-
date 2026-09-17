@extends('layouts.auth')

@section('title', 'Buat Kata Sandi Baru')

@section('content')
@php
    $siteName = \App\Models\Setting::get('site_name', 'Fawthar TopUp');
@endphp

<div class="max-w-[420px] mx-auto transition-all">
    <!-- Main Card -->
    <div class="bg-white dark:bg-[#121826] border border-slate-200/80 dark:border-dark-border shadow-xl rounded-2xl sm:rounded-3xl p-6 sm:p-9 transition-all relative">
        
        <!-- Header -->
        <div class="flex flex-col mb-6">
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white font-['Outfit']">
                Buat Kata Sandi Baru
            </h2>
            <span class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                Untuk akun: <strong class="text-slate-700 dark:text-slate-200">{{ $user->email }}</strong>
            </span>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-3 rounded-xl bg-rose-500/10 border border-rose-500/30 text-xs text-rose-500 space-y-1">
                @foreach ($errors->all() as $error)
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ $error }}</span>
                    </div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf

            <!-- Password Baru -->
            <div>
                <label for="password" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Kata Sandi Baru
                </label>
                <div class="relative flex items-center">
                    <input id="password" type="password" name="password" required autofocus
                        placeholder="Minimal 8 karakter"
                        class="w-full pl-4 pr-12 py-3 rounded-lg bg-white dark:bg-[#0B101B] border border-slate-300 dark:border-slate-700 text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-[#EE4D2D] focus:ring-1 focus:ring-[#EE4D2D] transition-colors @error('password') border-rose-500 @enderror">
                    
                    <button type="button" onclick="toggleVisibility('password', this)" class="absolute right-3 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 p-1" title="Tampilkan sandi">
                        <svg class="w-4 h-4 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Konfirmasi Password Baru -->
            <div>
                <label for="password_confirmation" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                    Konfirmasi Kata Sandi Baru
                </label>
                <div class="relative flex items-center">
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        placeholder="Ketik ulang kata sandi baru"
                        class="w-full pl-4 pr-12 py-3 rounded-lg bg-white dark:bg-[#0B101B] border border-slate-300 dark:border-slate-700 text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-[#EE4D2D] focus:ring-1 focus:ring-[#EE4D2D] transition-colors">
                    
                    <button type="button" onclick="toggleVisibility('password_confirmation', this)" class="absolute right-3 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 p-1" title="Tampilkan sandi">
                        <svg class="w-4 h-4 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-3.5 px-4 rounded-lg bg-[#EE4D2D] hover:bg-[#d73f1f] active:scale-[0.99] text-white font-bold text-sm tracking-wide shadow-md shadow-[#EE4D2D]/20 transition-all uppercase mt-2">
                SIMPAN KATA SANDI BARU
            </button>
        </form>
    </div>
</div>

<script>
    function toggleVisibility(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon = btn.querySelector('.eye-icon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />';
        } else {
            input.type = 'password';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
        }
    }
</script>
@endsection
