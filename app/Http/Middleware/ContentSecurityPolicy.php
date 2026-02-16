<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ContentSecurityPolicy
{
    public function handle(Request $request, Closure $next)
    {
        if (app()->environment('local')) {
            // ⚡ Development CSP (relaxed for Vite)
            $policies = [
                "default-src 'self'",
                "script-src 'self' 'unsafe-inline' 'unsafe-eval' http://127.0.0.1:5173 http://localhost:5173 https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://code.jquery.com https://unpkg.com",
                "style-src 'self' 'unsafe-inline' http://127.0.0.1:5173 http://localhost:5173 https://cdn.jsdelivr.net https://fonts.googleapis.com https://cdnjs.cloudflare.com https://fonts.bunny.net",
                "font-src 'self' data: https://fonts.gstatic.com https://cdn.jsdelivr.net https://fonts.bunny.net",
                "img-src 'self' data: blob: https://cdn.jsdelivr.net https://images.unsplash.com",                
                "connect-src 'self' https: wss: ws://127.0.0.1:5173 ws://localhost:5173 http://127.0.0.1:5173 http://localhost:5173 https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://unpkg.com https://*.zegocloud.com wss://*.zegocloud.com https://zegocloud.com https://zego.im https://zegoapi.com https://webliveroom-api.zegocloud.com https://webrtcproxy.zegocloud.com https://webrtc-api.zegocloud.com https://webrtc-tc.zegocloud.com https://webrtcstream.zegocloud.com wss://weblogger-wss.coolbcloud.com wss://accesshub-wss.coolbcloud.com wss://webrtc-ws.coolbcloud.com wss://relay-wss.coolbcloud.com https://relay-api.coolbcloud.com https://relay.coolbcloud.com wss://weblogger-wss.coolzcloud.com wss://accesshub-wss.coolzcloud.com wss://webrtc-ws.coolzcloud.com wss://relay-wss.coolzcloud.com https://relay-api.coolzcloud.com https://relay.coolzcloud.com wss://weblogger-wss.coolfcloud.com wss://accesshub-wss.coolfcloud.com wss://webrtc-ws.coolfcloud.com wss://relay-wss.coolfcloud.com https://relay-api.coolfcloud.com https://relay.coolfcloud.com",
                "object-src 'none'",
                "frame-src 'self'",
                "worker-src 'self' blob:",
            ];
        } else {
            // 🔒 Production CSP (stricter)    //these are added in connect-src ON live Site     //https://api.zegocloud.com https://*.zego.im wss://*.zego.im https://zego.link wss://*.coolbcloud.com https://*.coolbcloud.com wss://*.coolzcloud.com https://*.coolzcloud.com wss://*.coolfcloud.com https://*.coolfcloud.com wss://*.zegocloudrelay.com https://*.zegocloudrelay.com
            $policies = [
                "default-src 'self'",
                "script-src 'self' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://code.jquery.com https://unpkg.com",
                "style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net https://fonts.googleapis.com https://cdnjs.cloudflare.com https://fonts.bunny.net",
                "font-src 'self' data: https://fonts.gstatic.com https://cdn.jsdelivr.net https://fonts.bunny.net",
                "img-src 'self' data: blob: https://cdn.jsdelivr.net https://images.unsplash.com",                
                "connect-src 'self' https: wss: ws://127.0.0.1:5173 ws://localhost:5173 http://127.0.0.1:5173 http://localhost:5173 https://cdn.jsdelivr.net https://cdnjs.cloudflare.com https://unpkg.com https://*.zegocloud.com wss://*.zegocloud.com https://zegocloud.com https://zego.im https://zegoapi.com https://webliveroom-api.zegocloud.com https://webrtcproxy.zegocloud.com https://webrtc-api.zegocloud.com https://webrtc-tc.zegocloud.com https://webrtcstream.zegocloud.com wss://weblogger-wss.coolbcloud.com wss://accesshub-wss.coolbcloud.com wss://webrtc-ws.coolbcloud.com wss://relay-wss.coolbcloud.com https://relay-api.coolbcloud.com https://relay.coolbcloud.com wss://weblogger-wss.coolzcloud.com wss://accesshub-wss.coolzcloud.com wss://webrtc-ws.coolzcloud.com wss://relay-wss.coolzcloud.com https://relay-api.coolzcloud.com https://relay.coolzcloud.com wss://weblogger-wss.coolfcloud.com wss://accesshub-wss.coolfcloud.com wss://webrtc-ws.coolfcloud.com wss://relay-wss.coolfcloud.com https://relay-api.coolfcloud.com https://relay.coolfcloud.com",
                "object-src 'none'",
                "frame-src 'self'",
                "worker-src 'self' blob:",
            ];
        }

        $policy = implode('; ', $policies);

        // Use Laravel response headers instead of raw PHP header()
        $response = $next($request);
        $response->headers->set('Content-Security-Policy', $policy);

        return $response;
    }
}
