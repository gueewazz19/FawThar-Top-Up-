<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Game;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class GuestCustomizationAndOtpTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
    }

    private function createFakeImage(string $name = 'test_bg.png'): UploadedFile
    {
        $png1x1 = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==');
        $tempPath = tempnam(sys_get_temp_dir(), 'bg_') . '.png';
        file_put_contents($tempPath, $png1x1);

        return new UploadedFile($tempPath, $name, 'image/png', null, true);
    }

    public function test_admin_can_update_guest_background_settings_with_color_and_pattern(): void
    {
        $admin = User::where('role', 'admin')->first() ?? User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post('/admin/settings', [
            'site_name' => 'Fawthar TopUp',
            'site_tagline' => 'Top Up Game Tercepat',
            'support_email' => 'support@fawthar.test',
            'support_whatsapp' => '081234567890',
            'guest_bg_type' => 'color',
            'guest_bg_color' => '#0B132B',
            'guest_bg_pattern' => '1',
        ]);

        $response->assertRedirect(route('admin.settings.index'));
        $response->assertSessionHas('success');

        $this->assertEquals('color', Setting::get('guest_bg_type'));
        $this->assertEquals('#0B132B', Setting::get('guest_bg_color'));
        $this->assertTrue(Setting::get('guest_bg_pattern'));

        // Check homepage as guest displays custom background color
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('#0B132B');
    }

    public function test_admin_can_upload_guest_background_image(): void
    {
        $admin = User::where('role', 'admin')->first() ?? User::factory()->create(['role' => 'admin']);
        $bgFile = $this->createFakeImage('epic_game_wallpaper.png');

        $response = $this->actingAs($admin)->post('/admin/settings', [
            'site_name' => 'Fawthar TopUp',
            'site_tagline' => 'Top Up Game Tercepat',
            'support_email' => 'support@fawthar.test',
            'support_whatsapp' => '081234567890',
            'guest_bg_type' => 'image',
            'guest_bg_image_file' => $bgFile,
            'guest_bg_pattern' => '1',
        ]);

        $response->assertRedirect(route('admin.settings.index'));
        $this->assertEquals('image', Setting::get('guest_bg_type'));
        $this->assertStringContainsString('/uploads/backgrounds/', Setting::get('guest_bg_image'));

        // Check homepage includes background image
        $homeResponse = $this->get('/');
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee(Setting::get('guest_bg_image'));
    }

    public function test_guest_sees_login_prompt_modal_and_game_topup_button_triggers_it(): void
    {
        $category = Category::first() ?? Category::create(['name' => 'Mobile Games', 'slug' => 'mobile-games', 'is_active' => true]);
        $game = Game::where('slug', 'mobile-legends')->first() ?? Game::create([
            'category_id' => $category->id,
            'name' => 'Mobile Legends: Bang Bang',
            'slug' => 'mobile-legends',
            'developer' => 'Moonton',
            'is_active' => true,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        // Modal exists for guests
        $response->assertSee('guestLoginModal');
        $response->assertSee('Login Terlebih Dahulu');
        $response->assertSee('openGuestLoginModal');

        // Check that close button X icon exists in HTML
        $response->assertSee('closeGuestLoginModal()');
    }

    public function test_authenticated_user_sees_direct_link_without_guest_login_modal(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $category = Category::first() ?? Category::create(['name' => 'Mobile Games', 'slug' => 'mobile-games', 'is_active' => true]);
        $game = Game::first() ?? Game::create([
            'category_id' => $category->id,
            'name' => 'Valorant',
            'slug' => 'valorant',
            'developer' => 'Riot Games',
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);
        $response->assertDontSee('id="guestLoginModal"', false);
        $response->assertSee(route('topup.show', $game->slug));
    }

    public function test_forgot_password_change_email_sends_new_otp_and_redirects(): void
    {
        $initialUser = User::factory()->create([
            'email' => 'old_user_' . uniqid() . '@example.com',
            'username' => 'olduser_' . uniqid(),
        ]);

        $realUser = User::factory()->create([
            'email' => 'real_user_' . uniqid() . '@example.com',
            'username' => 'realuser_' . uniqid(),
        ]);

        // Put initial email in session (as if user already requested OTP for initialUser)
        $this->withSession(['reset_email' => $initialUser->email]);

        // Post to change email to realUser's email
        $response = $this->post('/forgot-password/change-email', [
            'new_email' => $realUser->email,
        ]);

        $response->assertRedirect(route('password.verify.form'));
        $response->assertSessionHas('success');
        $this->assertEquals($realUser->email, session('reset_email'));

        // Verify that OTP token was saved for the new email
        $tokenRecord = DB::table('password_reset_tokens')->where('email', $realUser->email)->first();
        $this->assertNotNull($tokenRecord);

        // Verify old token was removed
        $oldTokenRecord = DB::table('password_reset_tokens')->where('email', $initialUser->email)->first();
        $this->assertNull($oldTokenRecord);

        // Verify mail was sent
        Mail::assertSent(\App\Mail\ResetPasswordOtpMail::class, function ($mail) use ($realUser) {
            return $mail->hasTo($realUser->email);
        });
    }

    public function test_forgot_password_change_email_fails_if_new_email_not_registered(): void
    {
        $this->withSession(['reset_email' => 'someuser@example.com']);

        $response = $this->post('/forgot-password/change-email', [
            'new_email' => 'email_bodong_tidak_ada_' . uniqid() . '@example.com',
        ]);

        $response->assertSessionHasErrors('new_email');
        $this->assertEquals('someuser@example.com', session('reset_email'));
    }
}
