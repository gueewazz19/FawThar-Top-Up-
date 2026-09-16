<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserProfileAndEnhancementsTest extends TestCase
{
    public function test_guest_cannot_access_profile(): void
    {
        $response = $this->get('/profile');
        $response->assertRedirect('/login');
    }

    public function test_customer_can_access_profile_page(): void
    {
        $user = User::where('role', 'user')->first();

        $response = $this->actingAs($user)->get('/profile');
        $response->assertStatus(200);
        $response->assertSee($user->name);
        $response->assertSee('Informasi Biodata');
        $response->assertSee('Riwayat Pesanan');
    }

    public function test_customer_can_update_profile_information(): void
    {
        $user = User::where('role', 'user')->first();

        $response = $this->actingAs($user)->put('/profile', [
            'name' => 'Gamer Sultan Update',
            'phone' => '081299998888',
        ]);

        $response->assertRedirect('/profile');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Gamer Sultan Update',
            'phone' => '081299998888',
        ]);
    }

    public function test_customer_can_update_password(): void
    {
        $user = User::where('role', 'user')->first();

        $response = $this->actingAs($user)->put('/profile/password', [
            'current_password' => 'password123',
            'password' => 'newsecretpassword123',
            'password_confirmation' => 'newsecretpassword123',
        ]);

        $response->assertRedirect('/profile');
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertTrue(Hash::check('newsecretpassword123', $user->password));

        // Restore original password for other tests
        $user->update(['password' => Hash::make('password123')]);
    }

    public function test_customer_cannot_update_password_with_wrong_current_password(): void
    {
        $user = User::where('role', 'user')->first();

        $response = $this->actingAs($user)->put('/profile/password', [
            'current_password' => 'wrongcurrentpassword',
            'password' => 'anotherextrapassword123',
            'password_confirmation' => 'anotherextrapassword123',
        ]);

        $response->assertSessionHasErrors('current_password');
    }

    public function test_non_admin_cannot_access_user_management(): void
    {
        $customer = User::where('role', 'user')->first();

        $response = $this->actingAs($customer)->get('/admin/users');
        $response->assertStatus(403);
    }

    public function test_admin_can_access_user_management(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get('/admin/users');
        $response->assertStatus(200);
        $response->assertSee('Kelola Pengguna');
        $response->assertSee('Total Pengguna');
        $response->assertSee('Terakhir Login');
    }

    public function test_admin_can_toggle_user_role(): void
    {
        $admin = User::where('role', 'admin')->first();
        $targetUser = User::where('role', 'user')->where('email', '!=', 'customer@gametopup.test')->first();

        if (!$targetUser) {
            $targetUser = User::create([
                'name' => 'Temp Test User',
                'email' => 'temptestuser@gametopup.test',
                'password' => Hash::make('password123'),
                'role' => 'user',
            ]);
        }

        $initialRole = $targetUser->role;

        $response = $this->actingAs($admin)->post('/admin/users/' . $targetUser->id . '/toggle-role');
        $response->assertRedirect('/admin/users');
        $response->assertSessionHas('success');

        $targetUser->refresh();
        $this->assertNotEquals($initialRole, $targetUser->role);

        // Toggle back
        $this->actingAs($admin)->post('/admin/users/' . $targetUser->id . '/toggle-role');
        $targetUser->refresh();
        $this->assertEquals($initialRole, $targetUser->role);
    }

    public function test_admin_cannot_demote_themselves(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->post('/admin/users/' . $admin->id . '/toggle-role');
        $response->assertRedirect('/admin/users');
        $response->assertSessionHas('error');

        $admin->refresh();
        $this->assertEquals('admin', $admin->role);
    }

    public function test_admin_can_update_logo_and_social_media_settings(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->post('/admin/settings', [
            'site_name' => 'Fawthar TopUp Pro',
            'site_logo' => 'https://via.placeholder.com/150',
            'site_tagline' => 'Platform Top Up Tercepat',
            'support_email' => 'cs@fawthartopup.test',
            'support_phone' => '081122334455',
            'support_whatsapp' => '+6281122334455',
            'social_instagram' => 'https://instagram.com/fawthartopup',
            'social_facebook' => 'https://facebook.com/fawthartopup',
            'social_tiktok' => 'https://tiktok.com/@fawthartopup',
        ]);

        $response->assertRedirect('/admin/settings');
        $response->assertSessionHas('success');

        $this->assertEquals('Fawthar TopUp Pro', Setting::get('site_name'));
        $this->assertEquals('https://via.placeholder.com/150', Setting::get('site_logo'));
        $this->assertEquals('https://instagram.com/fawthartopup', Setting::get('social_instagram'));
        $this->assertEquals('https://facebook.com/fawthartopup', Setting::get('social_facebook'));
        $this->assertEquals('https://tiktok.com/@fawthartopup', Setting::get('social_tiktok'));
    }

    public function test_locale_switcher_changes_language_and_persists(): void
    {
        $response = $this->get('/locale/en');
        $response->assertRedirect('/');
        $response->assertSessionHas('locale', 'en');

        // Verify session persists in subsequent request
        $followUp = $this->withSession(['locale' => 'en'])->get('/');
        $followUp->assertStatus(200);
        $this->assertEquals('en', app()->getLocale());
    }

    public function test_login_records_last_login_timestamp_and_ip(): void
    {
        $user = User::where('role', 'user')->first();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ], ['REMOTE_ADDR' => '127.0.0.1']);

        $response->assertRedirect('/dashboard');

        $user->refresh();
        $this->assertNotNull($user->last_login_at);
        $this->assertNotNull($user->last_login_ip);
    }
}
