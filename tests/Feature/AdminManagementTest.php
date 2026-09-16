<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Game;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminManagementTest extends TestCase
{
    private User $admin;
    private User $customer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::firstOrCreate(
            ['email' => 'admin_test@gametopup.test'],
            [
                'name' => 'Admin Tester',
                'password' => bcrypt('password123'),
                'role' => 'admin',
                'phone' => '08123456789',
                'email_verified_at' => now(),
            ]
        );

        $this->customer = User::firstOrCreate(
            ['email' => 'customer_test@gametopup.test'],
            [
                'name' => 'Customer Tester',
                'password' => bcrypt('password123'),
                'role' => 'user',
                'phone' => '08987654321',
                'email_verified_at' => now(),
            ]
        );
    }

    public function test_guest_cannot_access_admin_submodules(): void
    {
        $this->get('/admin/games')->assertRedirect('/login');
        $this->get('/admin/products')->assertRedirect('/login');
        $this->get('/admin/orders')->assertRedirect('/login');
        $this->get('/admin/activity-logs')->assertRedirect('/login');
        $this->get('/admin/settings')->assertRedirect('/login');
    }

    public function test_customer_cannot_access_admin_submodules(): void
    {
        $this->actingAs($this->customer);

        $this->get('/admin/games')->assertStatus(403);
        $this->get('/admin/products')->assertStatus(403);
        $this->get('/admin/orders')->assertStatus(403);
        $this->get('/admin/activity-logs')->assertStatus(403);
        $this->get('/admin/settings')->assertStatus(403);
    }

    public function test_admin_can_access_all_dedicated_submodules(): void
    {
        $this->actingAs($this->admin);

        $this->get('/admin/games')->assertStatus(200)->assertSee('Katalog Game');
        $this->get('/admin/products')->assertStatus(200)->assertSee('Denominasi Top-Up');
        $this->get('/admin/orders')->assertStatus(200)->assertSee('Semua Pesanan');
        $this->get('/admin/activity-logs')->assertStatus(200)->assertSee('WAF Defense Monitor');
        $this->get('/admin/settings')->assertStatus(200)->assertSee('Pengaturan Situs');
    }

    public function test_admin_can_toggle_game_status(): void
    {
        $this->actingAs($this->admin);

        $category = Category::first() ?? Category::create(['name' => 'MOBA', 'slug' => 'moba', 'is_active' => true]);
        $unique = uniqid();
        $game = Game::create([
            'category_id' => $category->id,
            'name' => 'Test Toggle Game ' . $unique,
            'slug' => 'test-toggle-game-' . $unique,
            'is_active' => true,
        ]);

        $this->post("/admin/games/{$game->id}/toggle")->assertRedirect();
        $this->assertFalse((bool) $game->fresh()->is_active);

        $this->post("/admin/games/{$game->id}/toggle")->assertRedirect();
        $this->assertTrue((bool) $game->fresh()->is_active);
    }

    public function test_admin_can_update_settings(): void
    {
        $this->actingAs($this->admin);

        $response = $this->post('/admin/settings', [
            'site_name' => 'GameTopUp Updated',
            'site_tagline' => 'Tagline baru terpercaya',
            'support_email' => 'cs@gametopup.test',
            'support_whatsapp' => '+6289999999',
            'meta_description' => 'Meta description updated test.',
        ]);

        $response->assertRedirect('/admin/settings');
        $this->assertEquals('GameTopUp Updated', Setting::get('site_name'));
    }
}
