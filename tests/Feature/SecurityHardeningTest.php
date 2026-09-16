<?php

namespace Tests\Feature;

use App\Models\ActivityLog;
use Tests\TestCase;

class SecurityHardeningTest extends TestCase
{
    public function test_security_headers_are_present_in_responses(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-XSS-Protection', '1; mode=block');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $this->assertTrue($response->headers->has('Content-Security-Policy'));
    }

    public function test_attack_detection_middleware_blocks_sql_injection(): void
    {
        $response = $this->get('/?search=' . urlencode("' UNION SELECT null, username, password FROM users --"));

        $response->assertStatus(403);
        $response->assertSee('Akses Ditolak');

        $this->assertDatabaseHas('activity_logs', [
            'action' => 'SECURITY_ATTACK_BLOCKED',
        ]);
    }

    public function test_attack_detection_middleware_blocks_path_traversal(): void
    {
        $response = $this->get('/?file=' . urlencode('../../../../etc/passwd'));

        $response->assertStatus(403);
        $response->assertSee('Akses Ditolak');
    }

    public function test_attack_detection_middleware_blocks_php_wrapper_and_rce(): void
    {
        $response = $this->get('/?payload=' . urlencode('php://input'));

        $response->assertStatus(403);
        $response->assertSee('Akses Ditolak');
    }

    public function test_custom_404_view_renders_cleanly_without_information_leakage(): void
    {
        $response = $this->get('/non-existent-page-url-xyz');

        $response->assertStatus(404);
        $response->assertSee('Halaman Tidak Ditemukan');
        $response->assertSee('Kembali ke Beranda');
    }
}
