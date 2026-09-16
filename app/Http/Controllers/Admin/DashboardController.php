<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders' => Order::count(),
            'orders_today' => Order::whereDate('created_at', today())->count(),
            'successful_orders' => Order::where('status', OrderStatus::SUCCESS)->count(),
            'failed_orders' => Order::whereIn('status', [OrderStatus::FAILED, OrderStatus::TOPUP_FAILED])->count(),
            'total_revenue' => Order::where('status', OrderStatus::SUCCESS)->sum('total'),
            'total_users' => User::where('role', 'user')->count(),
            'total_games' => Game::where('is_active', true)->count(),
        ];

        $recentOrders = Order::with(['user', 'game', 'items', 'payment'])
            ->latest()
            ->take(10)
            ->get();

        $popularGames = Game::withCount('orders')
            ->orderBy('orders_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'popularGames'));
    }
}
