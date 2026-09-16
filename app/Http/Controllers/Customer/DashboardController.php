<?php

namespace App\Http\Controllers\Customer;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $recentOrders = $user->orders()
            ->with(['game', 'items'])
            ->latest()
            ->take(5)
            ->get();

        $stats = [
            'total_orders' => $user->orders()->count(),
            'successful_orders' => $user->orders()->where('status', OrderStatus::SUCCESS)->count(),
            'pending_orders' => $user->orders()->whereIn('status', [OrderStatus::PENDING_PAYMENT, OrderStatus::PROCESSING])->count(),
            'total_spent' => $user->orders()->where('status', OrderStatus::SUCCESS)->sum('total'),
        ];

        return view('customer.dashboard', compact('user', 'recentOrders', 'stats'));
    }
}
