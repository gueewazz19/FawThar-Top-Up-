<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\ActivityLog;
use App\Models\Game;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TopUpController extends Controller
{
    public function show(string $slug)
    {
        $game = Game::where('slug', $slug)
            ->where('is_active', true)
            ->with(['category', 'products' => function ($query) {
                $query->where('is_available', true)->orderBy('sort_order', 'asc');
            }])
            ->firstOrFail();

        $paymentMethods = [
            'qris' => [
                'name' => 'QRIS Real-Time',
                'description' => 'Scan dengan GoPay, OVO, DANA, BCA, Livin, ShopeePay & Semua M-Banking',
                'channels' => [
                    [
                        'code' => 'QRIS',
                        'name' => 'QRIS (Semua E-Wallet & Bank)',
                        'fee' => 750,
                        'badge' => 'INSTAN 24 JAM',
                        'icon' => 'qris',
                    ],
                ],
            ],
            'va' => [
                'name' => 'Virtual Account (Transfer Otomatis)',
                'description' => 'Konfirmasi pembayaran otomatis tanpa upload bukti transfer',
                'channels' => [
                    ['code' => 'BCA_VA', 'name' => 'BCA Virtual Account', 'fee' => 2500, 'badge' => 'Otomatis', 'icon' => 'bca'],
                    ['code' => 'MANDIRI_VA', 'name' => 'Mandiri Virtual Account', 'fee' => 2500, 'badge' => 'Otomatis', 'icon' => 'mandiri'],
                    ['code' => 'BRI_VA', 'name' => 'BRI Virtual Account', 'fee' => 2500, 'badge' => 'Otomatis', 'icon' => 'bri'],
                    ['code' => 'BNI_VA', 'name' => 'BNI Virtual Account', 'fee' => 2500, 'badge' => 'Otomatis', 'icon' => 'bni'],
                ],
            ],
            'ewallet' => [
                'name' => 'E-Wallet',
                'description' => 'Bayar langsung via aplikasi dompet digital favorit Anda',
                'channels' => [
                    ['code' => 'DANA', 'name' => 'DANA Wallet', 'fee' => 1000, 'badge' => 'Populer', 'icon' => 'dana'],
                    ['code' => 'GOPAY', 'name' => 'GoPay', 'fee' => 1000, 'badge' => 'Instan', 'icon' => 'gopay'],
                    ['code' => 'SHOPEEPAY', 'name' => 'ShopeePay', 'fee' => 1000, 'badge' => 'Cashback', 'icon' => 'shopeepay'],
                ],
            ],
        ];

        return view('topup.show', compact('game', 'paymentMethods'));
    }

    public function checkout(Request $request, string $slug)
    {
        $game = Game::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $rules = [
            'player_id' => 'required|string|max:50',
            'product_id' => 'required|exists:products,id',
            'payment_method' => 'required|string|max:50',
            'whatsapp' => 'required|string|max:30',
        ];

        if ($game->requires_server_id) {
            $rules['server_id'] = 'required|string|max:50';
        } else {
            $rules['server_id'] = 'nullable|string|max:50';
        }

        $validated = $request->validate($rules, [
            'player_id.required' => 'User ID / Player ID wajib diisi.',
            'server_id.required' => ($game->server_id_label ?? 'Server / Zone ID') . ' wajib diisi.',
            'product_id.required' => 'Silakan pilih salah satu nominal top-up terlebih dahulu.',
            'payment_method.required' => 'Silakan pilih metode pembayaran.',
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi untuk bukti transaksi.',
        ]);

        $product = Product::where('id', $validated['product_id'])
            ->where('game_id', $game->id)
            ->where('is_available', true)
            ->firstOrFail();

        // Calculate Fee based on payment channel
        $feeMap = [
            'QRIS' => 750,
            'BCA_VA' => 2500,
            'MANDIRI_VA' => 2500,
            'BRI_VA' => 2500,
            'BNI_VA' => 2500,
            'DANA' => 1000,
            'GOPAY' => 1000,
            'SHOPEEPAY' => 1000,
        ];
        $paymentFee = $feeMap[$validated['payment_method']] ?? 1000;

        $subtotal = $product->price;
        $total = $subtotal + $paymentFee;
        $orderNumber = Order::generateOrderNumber();

        $order = Order::create([
            'user_id' => auth()->id(),
            'game_id' => $game->id,
            'order_number' => $orderNumber,
            'player_id' => $validated['player_id'],
            'server_id' => $validated['server_id'] ?? null,
            'subtotal' => $subtotal,
            'discount' => 0,
            'payment_fee' => $paymentFee,
            'total' => $total,
            'status' => OrderStatus::PENDING_PAYMENT,
            'notes' => 'Kontak WhatsApp: ' . $validated['whatsapp'],
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
            'subtotal' => $product->price,
        ]);

        Payment::create([
            'order_id' => $order->id,
            'payment_method' => $validated['payment_method'],
            'payment_reference' => 'PAY-' . strtoupper(Str::random(10)),
            'amount' => $total,
            'status' => PaymentStatus::UNPAID,
            'expired_at' => now()->addHours(24),
            'provider_response' => [
                'va_number' => '8801' . rand(10000000, 99999999),
                'channel_name' => $validated['payment_method'],
            ],
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'CUSTOMER_PLACE_ORDER',
            'description' => "Pesanan baru dibuat: #{$order->order_number} ({$game->name} - {$product->name})",
            'new_values' => [
                'order_number' => $order->order_number,
                'game' => $game->name,
                'product' => $product->name,
                'total' => $total,
                'player_id' => $order->player_id,
            ],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('topup.invoice', $order->order_number)
            ->with('success', 'Pesanan Anda berhasil dibuat! Silakan selesaikan pembayaran.');
    }

    public function invoice(string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with(['game', 'items.product', 'payment', 'user'])
            ->firstOrFail();

        return view('topup.invoice', compact('order'));
    }

    public function simulatePay(Request $request, string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->with('payment')->firstOrFail();

        if ($order->status === OrderStatus::SUCCESS) {
            return redirect()->back()->with('info', 'Pesanan ini sudah berstatus LUNAS dan telah berhasil diproses sebelumnya.');
        }

        // Update Payment
        if ($order->payment) {
            $order->payment->update([
                'status' => PaymentStatus::PAID,
                'paid_at' => now(),
            ]);
        }

        // Update Order to SUCCESS
        $order->update([
            'status' => OrderStatus::SUCCESS,
            'notes' => ($order->notes ? $order->notes . "\n" : '') . "[" . now()->format('d/m/Y H:i') . "] Sistem: Pembayaran terverifikasi otomatis. Item top-up berhasil ditambahkan ke ID " . $order->player_id . ".",
        ]);

        ActivityLog::create([
            'user_id' => auth()->id() ?? $order->user_id,
            'action' => 'ORDER_PAYMENT_SUCCESS',
            'description' => "Pembayaran berhasil untuk pesanan #{$order->order_number} sebesar Rp " . number_format($order->total, 0),
            'new_values' => ['order_number' => $order->order_number, 'status' => 'SUCCESS'],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->back()->with('success', '🎉 Selamat! Pembayaran Anda telah terverifikasi secara otomatis. Diamond / item game Anda berhasil masuk ke akun!');
    }
}
