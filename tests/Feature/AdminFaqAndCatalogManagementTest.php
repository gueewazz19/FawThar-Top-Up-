<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\FAQ;
use App\Models\Game;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AdminFaqAndCatalogManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
            'username' => 'admin_' . uniqid(),
            'email' => 'admin_' . uniqid() . '@example.com',
        ]);

        $this->category = Category::create([
            'name' => 'Mobile Games',
            'slug' => 'mobile-games',
            'is_active' => true,
        ]);
    }

    private function createFakeImage(string $filename = 'test.png'): UploadedFile
    {
        $pngHeader = hex2bin('89504e470d0a1a0a0000000d49484452000000010000000108060000001f15c4890000000a49444154789c63000100000500010d0a2d450000000049454e44ae426082');
        $tmpPath = tempnam(sys_get_temp_dir(), 'img_') . '.png';
        file_put_contents($tmpPath, $pngHeader);

        return new UploadedFile(
            $tmpPath,
            $filename,
            'image/png',
            null,
            true
        );
    }

    public function test_admin_can_view_faq_index_page(): void
    {
        FAQ::create([
            'question' => 'Bagaimana cara top up?',
            'answer' => 'Pilih game, pilih paket, lakukan pembayaran.',
            'category' => 'general',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.faqs.index'));

        $response->assertStatus(200);
        $response->assertSee('Kelola FAQ');
        $response->assertSee('Bagaimana cara top up?');
    }

    public function test_admin_can_create_new_faq_and_it_shows_on_guest_homepage(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.faqs.store'), [
            'question' => 'Apakah pembayaran QRIS otomatis?',
            'answer' => 'Ya, sistem membaca pembayaran QRIS secara real-time.',
            'category' => 'payment',
            'sort_order' => 2,
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.faqs.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('faqs', [
            'question' => 'Apakah pembayaran QRIS otomatis?',
            'category' => 'payment',
            'is_active' => true,
        ]);

        // Verify it appears on guest homepage
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('Apakah pembayaran QRIS otomatis?');
        $homeResponse->assertSee('Ya, sistem membaca pembayaran QRIS secara real-time.');
    }

    public function test_admin_can_update_existing_faq(): void
    {
        $faq = FAQ::create([
            'question' => 'Pertanyaan Lama',
            'answer' => 'Jawaban Lama',
            'category' => 'general',
            'sort_order' => 5,
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.faqs.update', $faq), [
            'question' => 'Pertanyaan yang Sudah Diupdate',
            'answer' => 'Jawaban Baru yang Sangat Lengkap',
            'category' => 'order',
            'sort_order' => 1,
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.faqs.index'));
        $response->assertSessionHas('success');

        $faq->refresh();
        $this->assertEquals('Pertanyaan yang Sudah Diupdate', $faq->question);
        $this->assertEquals('Jawaban Baru yang Sangat Lengkap', $faq->answer);
        $this->assertEquals('order', $faq->category);
    }

    public function test_admin_can_toggle_faq_status_and_delete_faq(): void
    {
        $faq = FAQ::create([
            'question' => 'Pertanyaan Toggle',
            'answer' => 'Jawaban Toggle',
            'category' => 'general',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // Toggle to inactive
        $toggleResponse = $this->actingAs($this->admin)->post(route('admin.faqs.toggle', $faq));
        $toggleResponse->assertRedirect();
        $faq->refresh();
        $this->assertFalse($faq->is_active);

        // Inactive FAQ should not display on guest homepage
        $homeResponse = $this->get('/');
        $homeResponse->assertDontSee('Pertanyaan Toggle');

        // Delete FAQ
        $deleteResponse = $this->actingAs($this->admin)->delete(route('admin.faqs.destroy', $faq));
        $deleteResponse->assertRedirect(route('admin.faqs.index'));
        $this->assertDatabaseMissing('faqs', ['id' => $faq->id]);
    }

    public function test_admin_can_edit_game_and_upload_new_photo(): void
    {
        $game = Game::create([
            'category_id' => $this->category->id,
            'name' => 'Original Game Name',
            'slug' => 'original-game-name',
            'description' => 'Original Description',
            'logo' => null,
            'is_active' => true,
            'requires_user_id' => true,
            'requires_server_id' => false,
            'user_id_label' => 'Player ID',
        ]);

        $photoFile = $this->createFakeImage('game_cover.png');

        $response = $this->actingAs($this->admin)->put(route('admin.games.update', $game), [
            'name' => 'Updated Game Super',
            'category_id' => $this->category->id,
            'description' => 'Super fast top up updated description.',
            'photo' => $photoFile,
            'requires_user_id' => '1',
            'user_id_label' => 'Player UID',
            'requires_server_id' => '1',
            'server_id_label' => 'Zone ID',
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.games.index'));
        $response->assertSessionHas('success');

        $game->refresh();
        $this->assertEquals('Updated Game Super', $game->name);
        $this->assertEquals('updated-game-super', $game->slug);
        $this->assertNotNull($game->logo);
        $this->assertStringContainsString('/uploads/games/', $game->logo);

        // Verify guest homepage shows updated name and logo
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('Updated Game Super');
        $homeResponse->assertSee($game->logo);

        // Clean up created file if on disk
        if (file_exists(public_path($game->logo))) {
            @unlink(public_path($game->logo));
        }
    }

    public function test_admin_can_edit_product_package(): void
    {
        $game = Game::create([
            'category_id' => $this->category->id,
            'name' => 'Game For Product',
            'slug' => 'game-for-product',
            'description' => 'Description',
            'is_active' => true,
        ]);

        $product = Product::create([
            'game_id' => $game->id,
            'name' => '50 Diamonds',
            'currency_amount' => '50',
            'price' => 15000,
            'cost' => 13000,
            'sort_order' => 1,
            'is_popular' => false,
            'is_available' => true,
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.products.update', $product), [
            'game_id' => $game->id,
            'name' => '100 Diamonds + 10 Bonus',
            'currency_amount' => '110',
            'price' => 28000,
            'cost' => 24000,
            'sort_order' => 2,
            'is_popular' => '1',
            'is_available' => '1',
        ]);

        $response->assertRedirect(route('admin.products.index', ['game_id' => $game->id]));
        $response->assertSessionHas('success');

        $product->refresh();
        $this->assertEquals('100 Diamonds + 10 Bonus', $product->name);
        $this->assertEquals('110', $product->currency_amount);
        $this->assertEquals(28000, (float) $product->price);
        $this->assertEquals(24000, (float) $product->cost);
        $this->assertTrue($product->is_popular);
        $this->assertTrue($product->is_available);
    }
}
