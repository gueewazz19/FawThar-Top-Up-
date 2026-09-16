<?php

namespace App\Http\Controllers\Customer;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $recentOrders = $user->orders()->with(['game', 'items', 'payment'])->latest()->take(5)->get();

        $stats = [
            'total_orders' => $user->orders()->count(),
            'successful_orders' => $user->orders()->where('status', OrderStatus::SUCCESS)->count(),
            'total_spent' => (float) $user->orders()->where('status', OrderStatus::SUCCESS)->sum('total'),
            'loyalty_tier' => $user->loyalty_tier,
        ];

        return view('customer.profile', compact('user', 'stats', 'recentOrders'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'nullable|string|max:30',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
        ]);

        $old = ['name' => $user->name, 'phone' => $user->phone];
        $user->update($validated);

        ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'USER_UPDATE_PROFILE',
            'description' => "Pengguna {$user->name} memperbarui informasi biodata profil",
            'old_values' => $old,
            'new_values' => $validated,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('profile.index')->with('success', 'Profil Anda berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Kata sandi saat ini wajib diisi.',
            'current_password.current_password' => 'Kata sandi saat ini tidak cocok dengan catatan kami.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi baru minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'USER_CHANGE_PASSWORD',
            'description' => "Pengguna {$user->name} berhasil mengubah kata sandi akun",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('profile.index')->with('success', 'Kata sandi Anda berhasil diperbarui!');
    }
}
