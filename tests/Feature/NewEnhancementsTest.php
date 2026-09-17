<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Models\Game;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class NewEnhancementsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
    }

    private function createFakeImage(string $name = 'test.png'): UploadedFile
    {
        $png1x1 = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==');
        $tempPath = tempnam(sys_get_temp_dir(), 'img_') . '.png';
        file_put_contents($tempPath, $png1x1);

        return new UploadedFile($tempPath, $name, 'image/png', null, true);
    }

    public function test_admin_can_delete_order_and_its_relations(): void
    {
        $admin = User::where('role', 'admin')->first() ?? User::factory()->create(['role' => 'admin']);
        $game = Game::first() ?? Game::create(['category_id' => 1, 'name' => 'Test Game', 'slug' => 'test-game', 'developer' => 'Dev', 'is_active' => true]);
        $product = Product::first() ?? Product::create(['game_id' => $game->id, 'name' => '50 Gems', 'price' => 10000, 'stock' => 100, 'is_active' => true]);

        $order = Order::create([
            'game_id' => $game->id,
            'order_number' => 'GTU-TEST-' . uniqid(),
            'player_id' => '123456',
            'subtotal' => 10000,
            'discount' => 0,
            'payment_fee' => 0,
            'total' => 10000,
            'status' => OrderStatus::PENDING_PAYMENT,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'price' => 10000,
            'quantity' => 1,
            'subtotal' => 10000,
        ]);

        Payment::create([
            'order_id' => $order->id,
            'payment_reference' => 'PAY-' . uniqid(),
            'payment_method' => 'qris',
            'amount' => 10000,
            'status' => \App\Enums\PaymentStatus::UNPAID,
        ]);

        $this->assertDatabaseHas('orders', ['id' => $order->id]);
        $this->assertDatabaseHas('order_items', ['order_id' => $order->id]);

        $response = $this->actingAs($admin)->delete("/admin/orders/{$order->id}");
        $response->assertRedirect('/admin/orders');

        $this->assertDatabaseMissing('orders', ['id' => $order->id]);
        $this->assertDatabaseMissing('order_items', ['order_id' => $order->id]);
    }

    public function test_admin_can_upload_logo_file(): void
    {
        $admin = User::where('role', 'admin')->first() ?? User::factory()->create(['role' => 'admin']);
        $logoFile = $this->createFakeImage('custom_logo.png');

        $response = $this->actingAs($admin)->post('/admin/settings', [
            'site_name' => 'Fawthar TopUp Official',
            'site_tagline' => 'Fastest Game Top Up',
            'support_email' => 'admin@fawthar.com',
            'support_whatsapp' => '081234567890',
            'site_logo_file' => $logoFile,
        ]);

        $response->assertRedirect(route('admin.settings.index'));
        $this->assertStringContainsString('/uploads/logos/', Setting::get('site_logo'));
    }

    public function test_customer_can_upload_profile_avatar(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $avatarFile = $this->createFakeImage('my_avatar.png');

        $response = $this->actingAs($user)->put('/profile', [
            'name' => 'Gamer Sultan',
            'avatar' => $avatarFile,
        ]);

        $response->assertRedirect(route('profile.index'));
        $user->refresh();
        $this->assertStringContainsString('/uploads/avatars/', $user->avatar);
        $this->assertEquals('Gamer Sultan', $user->name);
    }

    public function test_register_flow_with_puzzle_and_otp(): void
    {
        $testEmail = 'newuser' . uniqid() . '@example.com';
        $testPhone = '08129' . rand(1000000, 9999999);

        // 1. Send OTP with phone and puzzle verification
        $sendResponse = $this->postJson('/register/send-otp', [
            'email' => $testEmail,
            'phone' => $testPhone,
            'puzzle_verified' => true,
        ]);

        $sendResponse->assertStatus(200);
        $sendResponse->assertJson(['success' => true]);

        $otp = session('register_otp');
        $this->assertNotEmpty($otp);

        // 2. Verify OTP with correct code
        $verifyResponse = $this->postJson('/register/verify-otp', [
            'otp' => $otp,
        ]);

        $verifyResponse->assertStatus(200);
        $verifyResponse->assertJson(['success' => true]);
        $this->assertTrue(session('register_otp_verified'));

        // 3. Complete registration
        $completeResponse = $this->post('/register/complete', [
            'name' => 'User Sukses OTP',
            'password' => 'PasswordAman123!',
            'password_confirmation' => 'PasswordAman123!',
        ]);

        $completeResponse->assertRedirect('/dashboard');
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => $testEmail,
            'phone' => $testPhone,
            'name' => 'User Sukses OTP',
        ]);
    }

    public function test_login_rejects_unregistered_account_preventing_bodong(): void
    {
        $response = $this->post('/login', [
            'login' => 'fake_user_bodong@example.com',
            'password' => 'apapun123',
        ]);

        $response->assertSessionHasErrors('login');
        $this->assertGuest();
    }

    public function test_forgot_password_and_reset_password_flow(): void
    {
        $phone = '0813' . rand(10000000, 99999999);
        $email = 'member_sultan_' . uniqid() . '@example.com';
        $user = User::factory()->create([
            'email' => $email,
            'phone' => $phone,
            'password' => \Illuminate\Support\Facades\Hash::make('OldPassword123!'),
        ]);

        // 1. Send Reset OTP
        $sendResponse = $this->postJson('/forgot-password/send-otp', [
            'email' => $user->email,
            'phone' => $phone,
            'puzzle_verified' => true,
        ]);

        $sendResponse->assertStatus(200);
        $sendResponse->assertJson(['success' => true]);

        $otp = session('reset_otp');
        $this->assertNotEmpty($otp);

        // 2. Verify Reset OTP
        $verifyResponse = $this->postJson('/forgot-password/verify-otp', [
            'otp' => $otp,
        ]);

        $verifyResponse->assertStatus(200);
        $verifyResponse->assertJson(['success' => true]);
        $this->assertTrue(session('reset_otp_verified'));

        // 3. View reset password form
        $formResponse = $this->get('/reset-password');
        $formResponse->assertStatus(200);
        $formResponse->assertSee($user->email);

        // 4. Update Password
        $updateResponse = $this->post('/reset-password', [
            'password' => 'NewPasswordBaru123!',
            'password_confirmation' => 'NewPasswordBaru123!',
        ]);

        $updateResponse->assertRedirect(route('login'));
        $updateResponse->assertSessionHas('success');

        // 5. Verify user can log in with new password
        $loginResponse = $this->post('/login', [
            'login' => $user->email,
            'password' => 'NewPasswordBaru123!',
        ]);
        $loginResponse->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_google_auth_redirects_to_official_google_oauth_server(): void
    {
        $response = $this->get('/auth/google');
        $response->assertStatus(302);
        $redirectUrl = $response->headers->get('Location');
        $this->assertStringContainsString('accounts.google.com/o/oauth2/v2/auth', $redirectUrl);
        $this->assertStringContainsString('761156082768-klf69eatoo93nk1j76dm8qe7salosi2i', $redirectUrl);
    }
}
