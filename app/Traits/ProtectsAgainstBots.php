<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

trait ProtectsAgainstBots
{
    /**
     * Reject the request if it looks like an automated bot submission:
     *   1. The honeypot field ("Website" below) was filled in — real users
     *      never see or fill this field (it's visually hidden), but bots
     *      that auto-fill every input on the page will fill it blindly.
     *   2. The form was submitted implausibly fast (under 2 seconds) —
     *      no human reads and fills a registration form that quickly.
     *
     * Call this at the top of store()/register() before running normal
     * validation, so bot submissions are rejected immediately without
     * even reaching the database checks.
     */
    protected function rejectIfBot(Request $request): void
    {
        // 1. Honeypot check
        if (filled($request->input('website'))) {
            throw ValidationException::withMessages([
                'UserName' => 'Something went wrong. Please try again.',
            ]);
        }

        // 2. Minimum time-on-page check
        $formLoadedAt = (int) $request->input('form_loaded_at', 0);
        $minSeconds = 2;

        if ($formLoadedAt > 0 && (time() - $formLoadedAt) < $minSeconds) {
            throw ValidationException::withMessages([
                'UserName' => 'Something went wrong. Please try again.',
            ]);
        }
    }
}
