<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentSecurityPolicy
{
    public function handle(Request $request, Closure $next)
    {
        // Shared CSP building blocks (aligned with live)
        $zegoDomains = [
            "https://*.zegocloud.com",
            "https://zegocloud.com",
            "wss://*.zegocloud.com",
            "https://api.zegocloud.com",
            "https://webliveroom-api.zegocloud.com",
            "https://webrtcproxy.zegocloud.com",
            "https://webrtc-api.zegocloud.com",
            "https://webrtc-tc.zegocloud.com",
            "https://webrtcstream.zegocloud.com",
            "https://zego.im",
            "https://*.zego.im",
            "wss://*.zego.im",
            "https://zego.link",
        ];

        $relays = [
            "wss://*.coolbcloud.com",
            "https://*.coolbcloud.com",
            "wss://*.coolzcloud.com",
            "https://*.coolzcloud.com",
            "wss://*.coolfcloud.com",
            "https://*.coolfcloud.com",
            "wss://*.zegocloudrelay.com",
            "https://*.zegocloudrelay.com",
        ];

        $connectList = array_merge($zegoDomains, $relays, [
            "https://cdn.jsdelivr.net",
            "https://storage.googleapis.com",
            "https://cdnjs.cloudflare.com",
            "https://unpkg.com",
            "https://www.google-analytics.com",
            "https://region1.google-analytics.com",
            "https://www.googletagmanager.com",
            "blob:",
            "data:",
        ]);

        $scriptList = [
            "'self'",
            "'unsafe-inline'",
            "'unsafe-eval'",
            "'wasm-unsafe-eval'",
            "https://cdn.jsdelivr.net",
            "https://cdnjs.cloudflare.com",
            "https://code.jquery.com",
            "https://unpkg.com",
            "https://*.zegocloud.com",
            "https://zegocloud.com",
            "https://www.googletagmanager.com",
            "https://www.google-analytics.com",
        ];

        $styleList = [
            "'self'",
            "'unsafe-inline'",
            "https://cdn.jsdelivr.net",
            "https://fonts.googleapis.com",
            "https://cdnjs.cloudflare.com",
            "https://fonts.bunny.net",
        ];

        if (app()->environment('local')) {
            // ⚡ Development CSP (relaxed for Vite)
            $scriptList = array_merge($scriptList, [
                "http://127.0.0.1:5173",
                "http://localhost:5173",
            ]);

            $styleList = array_merge($styleList, [
                "http://127.0.0.1:5173",
                "http://localhost:5173",
            ]);

            $connectList = array_merge($connectList, [
                "https:",
                "wss:",
                "ws://127.0.0.1:5173",
                "ws://localhost:5173",
                "http://127.0.0.1:5173",
                "http://localhost:5173",
            ]);
        }

        $policies = [
            "default-src 'self'",
            "script-src " . implode(' ', $scriptList),
            "style-src " . implode(' ', $styleList),
            "font-src 'self' data: https://fonts.gstatic.com https://cdn.jsdelivr.net https://fonts.bunny.net",
            "img-src 'self' data: blob: https://cdn.jsdelivr.net https://storage.googleapis.com https://images.unsplash.com",
            "connect-src 'self' " . implode(' ', $connectList),
            "object-src 'none'",
            "frame-src 'self' https://*.zegocloud.com",
            "worker-src 'self' blob:",
        ];

        $policy = implode('; ', $policies);

        // Use Laravel response headers instead of raw PHP header()
        $response = $next($request);
        $response->headers->set('Content-Security-Policy', $policy);

        return $response;
    }
}
