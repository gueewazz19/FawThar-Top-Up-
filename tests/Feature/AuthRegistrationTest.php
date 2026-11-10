<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AuthRegistrationTest extends TestCase
{
    public function test_register_page_loads_and_has_turnstile_and_csp_allowed(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('challenges.cloudflare.com/turnstile/v0/api.js', false);
        $response->assertSee('cf-turnstile', false);

        // Check CSP includes challenges.cloudflare.com
        $csp = $response->headers->get('Content-Security-Policy');
        $this->assertNotNull($csp);
        $this->assertStringContainsString('script-src', $csp);
        $this->assertStringContainsString('https://challenges.cloudflare.com', $csp);
        $this->assertStringContainsString('frame-src', $csp);
        $this->assertStringContainsString('connect-src', $csp);
    }

    public function test_registration_validation_requires_turnstile(): void
    {
        $response = $this->post('/register', [
            'username' => 'testuser' . rand(1000, 9999),
            'email' => 'test' . rand(1000, 9999) . '@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertSessionHasErrors('cf-turnstile-response');
    }

    public function test_registration_succeeds_with_valid_data_and_turnstile(): void
    {
        Http::fake([
            'https://challenges.cloudflare.com/turnstile/v0/siteverify' => Http::response([
                'success' => true,
            ], 200),
        ]);

        $unique = rand(10000, 99999);
        $username = 'fawwaz_' . $unique;
        $email = 'fawwaz_' . $unique . '@gmail.com';

        $response = $this->post('/register', [
            'username' => $username,
            'email' => $email,
            'password' => 'PasswordAman123!',
            'password_confirmation' => 'PasswordAman123!',
            'cf-turnstile-response' => 'test-turnstile-token',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'username' => $username,
            'email' => $email,
        ]);
    }
}
