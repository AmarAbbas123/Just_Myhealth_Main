<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Checkout\Session;

class StripeService
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Create Stripe Checkout Session for any user type
     *
     * @param  object $user
     * @param  string $type   ['therapist_registration','session_purchase', etc]
     * @param  array  $data   Additional data: amount, credits, fee type, etc
     * @return Session
     */
    public function createCheckoutSession($user, $type, $data = [])
    {
        $lineItem = [];

        if ($type === 'therapist_registration') {
            $lineItem = [
                'price_data' => [
                    'currency' => config('services.stripe.currency', 'gbp'),
                    'product_data' => [
                        'name' => 'Therapist Annual Registration Fee',
                    ],
                    'unit_amount' => $data['amount'] * 100,  // dynamic from DB
                ],
                'quantity' => 1,
            ];
        }

        if ($type === 'business_registration') {
            $lineItem = [
                'price_data' => [
                    'currency' => config('services.stripe.currency', 'gbp'),
                    'product_data' => [
                        'name' => 'Business Registration Fee',
                    ],
                    'unit_amount' => $data['amount'] * 100,
                ],
                'quantity' => 1,
            ];
        }

        if ($type === 'session_purchase') {
            $sessionType = $data['session_type'] ?? 'INDIVIDUAL';
            $sessionTypeLabel = ucfirst(strtolower($sessionType));

            $lineItem = [
                'price_data' => [
                    'currency' => config('services.stripe.currency', 'gbp'),
                    'product_data' => [
                        'name' => "{$sessionTypeLabel} Session Credit Pack ({$data['credits']} sessions)",
                    ],
                    'unit_amount' => (int) round($data['amount'] * 100),
                ],
                'quantity' => 1,
            ];
        }

        return Session::create([
            'mode' => 'payment',
            'customer_email' => $user->Email,
            'line_items' => [$lineItem],
            'metadata' => [
                'user_id' => $user->ID,
                'user_type' => $user->UserType,
                'payment_type' => $type,
                'extra' => json_encode($data),
            ],
            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.cancel'),
        ]);
    }
}
