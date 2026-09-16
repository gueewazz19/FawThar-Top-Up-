<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user');

        if ($request->filled('action')) {
            $query->where('action', $request->get('action'));
        }

        if ($request->get('filter') === 'attacks') {
            $query->where('action', 'SECURITY_ATTACK_BLOCKED');
        }

        if ($request->filled('q')) {
            $search = $request->get('q');
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%")
                  ->orWhere('action', 'like', "%{$search}%");
            });
        }

        $logs = $query->latest()->paginate(20)->withQueryString();

        $stats = [
            'total_logs' => ActivityLog::count(),
            'attacks_blocked' => ActivityLog::where('action', 'SECURITY_ATTACK_BLOCKED')->count(),
            'admin_actions' => ActivityLog::where('action', 'like', 'ADMIN_%')->count(),
            'logins_today' => ActivityLog::where('action', 'like', '%LOGIN%')->whereDate('created_at', today())->count(),
        ];

        return view('admin.activity_logs.index', compact('logs', 'stats'));
    }
}
