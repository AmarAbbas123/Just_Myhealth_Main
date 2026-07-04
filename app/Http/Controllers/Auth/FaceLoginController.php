<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\FaceDescriptor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class FaceLoginController extends Controller
{
    // Lower distance = stricter match. face-api.js's own FaceMatcher defaults
    // to 0.6; we use a slightly tighter threshold since this is 1:N search
    // (no email typed first) and false-accepts matter more here.
    private const MATCH_THRESHOLD = 0.5;

    public function attempt(Request $request)
    {
        $key = 'face-login:' . $request->ip();

        // Basic brute-force / spam protection: 10 attempts per minute per IP.
        if (RateLimiter::tooManyAttempts($key, 10)) {
            return response()->json([
                'message' => 'Too many attempts. Please wait a minute and try again, or log in with your password.',
            ], 429);
        }
        RateLimiter::hit($key, 60);

        $validated = $request->validate([
            'descriptor' => ['required', 'array', 'size:128'],
            'descriptor.*' => ['numeric'],
        ]);

        $candidate = $validated['descriptor'];

        $bestMatch = null;
        $bestDistance = INF;

        // Fine for hundreds-to-low-thousands of registered users. If your
        // user base grows much larger, move this comparison into a proper
        // vector index (e.g. pgvector) instead of comparing in a PHP loop.
        FaceDescriptor::with('user')->chunk(200, function ($chunk) use ($candidate, &$bestMatch, &$bestDistance) {
            foreach ($chunk as $record) {
                $distance = $record->distanceTo($candidate);
                if ($distance < $bestDistance) {
                    $bestDistance = $distance;
                    $bestMatch = $record;
                }
            }
        });

        if (! $bestMatch || $bestDistance > self::MATCH_THRESHOLD) {
            return response()->json([
                'message' => 'Face not recognized. Please log in with your email and password, or try again with better lighting.',
            ], 401);
        }

        $user = $bestMatch->user;

        if (! $user) {
            return response()->json(['message' => 'Face not recognized.'], 401);
        }

        RateLimiter::clear($key);
        Auth::login($user, remember: false);
        $request->session()->regenerate();

        return response()->json([
            'message' => 'Welcome back, ' . $user->name . '!',
            'redirect' => route('dashboard'), // adjust to your actual post-login route
        ]);
    }
}
