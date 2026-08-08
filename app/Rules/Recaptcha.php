<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Recaptcha implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (empty($value)) {
            $fail('Please confirm you are not a robot.');
            return;
        }

        $secret = config('services.recaptcha.secret_key');

        if (empty($secret)) {
            // Fail safe: if the secret key isn't configured, don't silently
            // let every registration through — log it loudly so it gets fixed.
            Log::error('reCAPTCHA secret key is not configured — registrations are unprotected.');
            $fail('Registration verification is temporarily unavailable. Please try again shortly.');
            return;
        }

        try {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secret,
                'response' => $value,
                'remoteip' => request()->ip(),
            ]);

            $result = $response->json();

            if (! ($result['success'] ?? false)) {
                $fail('The CAPTCHA verification failed. Please try again.');
            }
        } catch (\Throwable $e) {
            Log::error('reCAPTCHA verification request failed: ' . $e->getMessage());
            $fail('Could not verify CAPTCHA right now. Please try again.');
        }
    }
}
