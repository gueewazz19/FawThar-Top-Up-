<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Category;
use App\Models\Game;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Tests\TestCase;

class TopUpCheckoutTest extends TestCase
{
    private Game $game;
    private Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $category = Category::first() ?? Category::create(['name' => 'MOBA', 'slug' => 'moba', 'is_active' => true]);

        $this->game = Game::where('slug', 'honor-of-kings')->first() ?? Game::create([
            'category_id' => $category->id,
            'name' => 'Honor of Kings',
            'slug' => 'honor-of-kings',
            'description' => 'Isi Token Honor of Kings cepat dan praktis.',
            'is_active' => true,
            'requires_user_id' => true,
            'requires_server_id' => false,
            'user_id_label' => 'Player ID',
        ]);

        $this->product = Product::where('game_id', $this->game->id)->first() ?? Product::create([
            'game_id' => $this->game->id,
            'name' => '80 Tokens',
            'currency_amount' => '80',
            'price' => 15000,
            'cost' => 13500,
            'is_available' => true,
            'sort_order' => 1,
        ]);
    }

    public function test_topup_page_loads_successfully(): void
    {
        $response = $this->get('/topup/' . $this->game->slug);

        $response->assertStatus(200);
        $response->assertSee($this->game->name);
        $response->assertSee($this->product->name);
        $response->assertSee('QRIS');
    }

    public function test_topup_order_checkout_flow(): void
    {
        $response = $this->post('/topup/' . $this->game->slug . '/order', [
            'player_id' => '982741920',
            'product_id' => $this->product->id,
            'payment_method' => 'QRIS',
            'whatsapp' => '081234567890',
        ]);

        $order = Order::latest()->first();
        $this->assertNotNull($order);
        $this->assertEquals('982741920', $order->player_id);
        $this->assertEquals(OrderStatus::PENDING_PAYMENT, $order->status);

        $response->assertRedirect('/order/' . $order->order_number);

        // Verify invoice page loads
        $invoiceResponse = $this->get('/order/' . $order->order_number);
        $invoiceResponse->assertStatus(200);
        $invoiceResponse->assertSee($order->order_number);
        $invoiceResponse->assertSee('Menunggu Pembayaran');
    }

    public function test_simulate_payment_flow(): void
    {
        $order = Order::create([
            'user_id' => null,
            'game_id' => $this->game->id,
            'order_number' => Order::generateOrderNumber(),
            'player_id' => '123456789',
            'subtotal' => 15000,
            'payment_fee' => 750,
            'total' => 15750,
            'status' => OrderStatus::PENDING_PAYMENT,
        ]);

        $response = $this->post('/order/' . $order->order_number . '/simulate-pay');
        $response->assertRedirect();

        $this->assertEquals(OrderStatus::SUCCESS, $order->fresh()->status);
    }

    public function test_non_existent_game_returns_404(): void
    {
        $response = $this->get('/topup/game-yang-tidak-ada-xyz');
        $response->assertStatus(404);
        $response->assertSee('Halaman Tidak Ditemukan');
    }
}
