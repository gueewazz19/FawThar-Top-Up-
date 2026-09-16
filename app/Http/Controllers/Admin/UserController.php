<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withCount('orders')
            ->withSum(['orders as total_spent' => function ($q) {
                $q->where('status', \App\Enums\OrderStatus::SUCCESS);
            }], 'total');

        if ($request->filled('q')) {
            $search = $request->get('q');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->get('role'));
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total_users' => User::count(),
            'total_customers' => User::where('role', 'user')->count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'active_today' => User::whereDate('last_login_at', today())->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    public function toggleRole(Request $request, User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak dapat mengubah role akun administrator Anda sendiri.');
        }

        $oldRole = $user->role;
        $user->role = $user->role === 'admin' ? 'user' : 'admin';
        $user->save();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'ADMIN_TOGGLE_USER_ROLE',
            'description' => "Role pengguna {$user->name} diubah dari {$oldRole} menjadi {$user->role}",
            'old_values' => ['role' => $oldRole],
            'new_values' => ['role' => $user->role],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.users.index')->with('success', "Role pengguna {$user->name} berhasil diperbarui menjadi {$user->role}.");
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $userName = $user->name;

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'ADMIN_DELETE_USER',
            'description' => "Admin menghapus akun pengguna: {$userName} ({$user->email})",
            'old_values' => $user->toArray(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', "Pengguna {$userName} berhasil dihapus.");
    }
}
