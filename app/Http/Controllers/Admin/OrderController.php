<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'game', 'payment', 'items']);

        if ($request->filled('q')) {
            $search = $request->get('q');
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('player_id', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        if ($request->filled('game_id')) {
            $query->where('game_id', $request->get('game_id'));
        }

        $orders = $query->latest()->paginate(15)->withQueryString();
        $statuses = OrderStatus::cases();

        return view('admin.orders.index', compact('orders', 'statuses'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'game', 'items.product', 'payment', 'topUpTransaction', 'voucherUsages']);
        $statuses = OrderStatus::cases();

        return view('admin.orders.show', compact('order', 'statuses'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => ['required', new Enum(OrderStatus::class)],
            'notes' => 'nullable|string|max:500',
        ]);

        $oldStatus = $order->status->value;
        $order->status = OrderStatus::from($validated['status']);
        
        if (!empty($validated['notes'])) {
            $order->notes = ($order->notes ? $order->notes . "\n" : '') . "[" . now()->format('d/m/Y H:i') . "] Admin: " . $validated['notes'];
        }
        
        $order->save();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'ADMIN_UPDATE_ORDER_STATUS',
            'description' => "Status pesanan {$order->order_number} diubah dari {$oldStatus} ke {$order->status->value}",
            'old_values' => ['status' => $oldStatus],
            'new_values' => ['status' => $order->status->value, 'notes' => $order->notes],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->back()->with('success', "Status pesanan {$order->order_number} berhasil diubah menjadi: {$order->status->label()}");
    }

    public function destroy(Request $request, Order $order)
    {
        $orderNumber = $order->order_number;

        // Cascade delete child relations
        $order->items()->delete();
        if ($order->payment) {
            $order->payment->delete();
        }
        if ($order->topUpTransaction) {
            $order->topUpTransaction->delete();
        }
        $order->voucherUsages()->delete();

        // Delete order
        $order->delete();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'ADMIN_DELETE_ORDER',
            'description' => "Pesanan {$orderNumber} berhasil dihapus oleh admin",
            'old_values' => ['order_number' => $orderNumber],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.orders.index')->with('success', "Pesanan {$orderNumber} berhasil dihapus dari sistem.");
    }
}
