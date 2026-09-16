<?php

namespace App\Http\Middleware;

use App\Models\ActivityLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AttackDetectionMiddleware
{
    /**
     * Malicious regex signatures commonly used in web pentesting and exploitation attempts.
     */
    protected array $maliciousPatterns = [
        // Path Traversal
        '/\.\.\//',
        '/\.\.\\\\/',
        '/etc\/passwd/i',
        '/win\.ini/i',
        '/boot\.ini/i',
        '/\%00/', // Null byte

        // SQL Injection probes
        '/union(\s+all)?\s+select/i',
        '/information_schema/i',
        '/benchmark\s*\(/i',
        '/sleep\s*\(\s*[0-9]+\s*\)/i',
        '/waitfor\s+delay/i',
        '/order\s+by\s+[0-9]{2,}/i',
        '/\'\s+or\s+\'1\'=\'1/i',
        '/\"\s+or\s+\"1\"=\"1/i',

        // Remote Code Execution / PHP Wrappers
        '/php:\/\/input/i',
        '/php:\/\/filter/i',
        '/data:\/\/text/i',
        '/base64_decode\s*\(/i',
        '/system\s*\(/i',
        '/passthru\s*\(/i',
        '/shell_exec\s*\(/i',
        '/exec\s*\(/i',

        // Malicious Script Injection tags
        '/<script\b[^>]*>/i',
        '/javascript\s*:/i',
        '/onload\s*=/i',
        '/onerror\s*=/i',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $queryString = rawurldecode($request->getQueryString() ?? '');
        $path = rawurldecode($request->path());
        $payload = json_encode($request->except(['_token', 'password', 'password_confirmation']));

        $rawInput = "{$path} {$queryString} {$payload}";

        foreach ($this->maliciousPatterns as $pattern) {
            if (preg_match($pattern, $rawInput)) {
                // Log the security incident
                try {
                    ActivityLog::create([
                        'user_id' => $request->user()?->id,
                        'action' => 'SECURITY_ATTACK_BLOCKED',
                        'description' => 'Upaya eksploitasi/pentest diblokir otomatis oleh Web Application Firewall (WAF) internal.',
                        'old_values' => [
                            'pattern' => $pattern,
                            'path' => $request->path(),
                            'query' => $queryString,
                        ],
                        'new_values' => [
                            'status' => 'BLOCKED_403',
                        ],
                        'ip_address' => $request->ip(),
                        'user_agent' => $request->userAgent(),
                    ]);
                } catch (\Throwable $e) {
                    // Fail gracefully
                }

                if ($request->expectsJson()) {
                    return response()->json([
                        'error' => 'Permintaan ditolak oleh filter keamanan server.',
                        'code' => 'WAF_BLOCKED',
                    ], 403);
                }

                abort(403, 'Akses ditolak: Pola permintaan terdeteksi berbahaya oleh filter keamanan server (WAF).');
            }
        }

        return $next($request);
    }
}
