<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentSecurityPolicy
{
    public function handle(Request $request, Closure $next)
    {
        // Generate & expose nonce (optional, harmless even if using 'unsafe-inline')
        $nonce = base64_encode(random_bytes(16));
        app()->instance('csp_nonce', $nonce);
        $request->attributes->set('cspNonce', $nonce);

        $response = $next($request);

        // Zego primary domains (https + wss)
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

        // Additional relay/logging/edge domains observed from Zego SDK runs
        $relays = [
            "wss://*.coolbcloud.com",
            "https://*.coolbcloud.com",
            "wss://*.coolzcloud.com",
            "https://*.coolzcloud.com",
            "wss://*.coolfcloud.com",
            "https://*.coolfcloud.com",
            // explicitly add Zego’s access hub (critical)
            //"wss://accesshub-wss.coolfcloud.com",
            //"https://accesshub-wss.coolfcloud.com",
            // keep wildcard for other vendor-hosted relays the SDK may use
            "wss://*.zegocloudrelay.com",
            "https://*.zegocloudrelay.com",
        ];

        // join them
        $connectList = array_merge($zegoDomains, $relays, [
            "https://cdn.jsdelivr.net",
            "https://cdnjs.cloudflare.com",
            "https://unpkg.com",
            "blob:", // sometimes used for media/proxying
            "data:",
        ]);

        // Build the CSP header lines
        $policies = [
            "default-src 'self'",
            // scripts: allow inline (SDK uses inline/dynamic), eval (SDK uses), and trusted CDNs
            "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://code.jquery.com https://unpkg.com https://*.zegocloud.com https://zegocloud.com",
            "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://fonts.googleapis.com https://cdnjs.cloudflare.com https://fonts.bunny.net",
            "font-src 'self' data: https://fonts.gstatic.com https://cdn.jsdelivr.net https://fonts.bunny.net",
            "img-src 'self' data: blob: https://cdn.jsdelivr.net https://images.unsplash.com",
            // connect-src: allow our assembled list (https + wss wildcards)
            "connect-src 'self' " . implode(' ', $connectList),
            "object-src 'none'",
            "frame-src 'self' https://*.zegocloud.com",
            "worker-src 'self' blob:",
        ];

        $response->headers->set('Content-Security-Policy', implode('; ', $policies));

        return $response;
    }
}
