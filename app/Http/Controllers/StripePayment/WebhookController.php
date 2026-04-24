<?php

namespace App\Http\Controllers\StripePayment;

use App\Http\Controllers\Controller;
use App\Notifications\UserSessionPurchaseConfirmationNotification;
use Illuminate\Http\Request;
use Stripe\Webhook;
use Stripe\Event;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

        Log::debug('Stripe webhook hit', [ 'has_signature' => !empty($sig_header), 'payload_len' => strlen($payload), ]);

        try {
            $event = Webhook::constructEvent($payload, $sig_header, $secret);
        } catch (\Exception $e) {
            Log::error('Stripe webhook signature failed', [ 'error' => $e->getMessage(), ]);
            return response('Invalid signature', 400);
        }

        Log::debug('Stripe webhook event', [ 'type' => $event->type ?? null, 'id' => $event->id ?? null, ]);

        if ($event->type === 'checkout.session.completed') {

            $session = $event->data->object;
            $metadata = $session->metadata;

            $user_id = (int) ($metadata->user_id ?? 0);
            $user_type = (int) ($metadata->user_type ?? 0);
            $payment_type = (string) ($metadata->payment_type ?? '');
            $extra = json_decode($metadata->extra, true);

            Log::debug('Stripe session metadata', [ 'user_id' => $user_id, 'user_type' => $user_type, 'payment_type' => $payment_type, ]);

            $transaction_id = $session->payment_intent;
            $amount = $session->amount_total / 100;
            $currency = $session->currency;

            $now = Carbon::now();

            if ($payment_type === 'therapist_registration' && $user_type == 30) {
                try {
                    // Insert into sys_finance_user_type_30_fees
                    DB::table('sys_finance_user_type_30_fees')->insert([
                        'TherapistUserID' => $user_id,
                        'FeeType' => 'Registration Fee',
                        'CreditDate' => $now->format('Y-m-d'),
                        'CreditTime' => $now->format('H:i:s'),
                        'CreditValue' => $amount,
                        'CreditCurrency' => strtoupper($currency),
                        'TransactionID' => $transaction_id,
                        'TransactionResult' => 'success',
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                } catch (\Throwable $e) {
                    Log::error('Therapist registration insert failed', [ 'user_id' => $user_id, 'error' => $e->getMessage(), ]);
                }
            }

            if ($payment_type === 'business_registration' && $user_type == 10) {
                try {
                    // Insert into sys_finance_user_type_10_fees
                    DB::table('sys_finance_user_type_10_fees')->insert([
                        'BusinessLocalUserID' => $user_id,
                        'FeeType' => 'Registration Fee',
                        'CreditDate' => $now->format('Y-m-d'),
                        'CreditTime' => $now->format('H:i:s'),
                        'CreditValue' => $amount,
                        'CreditCurrency' => strtoupper($currency),
                        'TransactionID' => $transaction_id,
                        'TransactionResult' => 'success',
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                    Log::debug('Business registration fee recorded', [ 'user_id' => $user_id, 'amount' => $amount, 'currency' => $currency, ]);
                } catch (\Throwable $e) {
                    Log::error('Business registration insert failed', [ 'user_id' => $user_id, 'error' => $e->getMessage(), ]);
                }
            }                      

            if (($payment_type === 'session_purchase' || empty($payment_type)) && in_array($user_type, [1, 2, 3], true)) {

                if (($session->payment_status ?? null) !== 'paid') {
                    Log::warning('Webhook skipped: payment not paid', [
                        'session_id' => $session->id
                    ]);
                    return response('not paid', 200);
                }
            
                $transaction_id = $session->payment_intent;
                $amount = $session->amount_total / 100;
                $currency = strtoupper($session->currency);
            
                $extra = json_decode($metadata->extra ?? '{}', true) ?: [];
                $credits = $extra['credits'] ?? ($session->metadata->credits ?? null);
            
                if (!$credits || !$transaction_id) {
                    Log::error('Session purchase webhook missing data', [
                        'user_id' => $user_id,
                        'transaction_id' => $transaction_id
                    ]);
                    return response('invalid data', 400);
                }
            
                try {
                    DB::transaction(function () use (
                        $user_id,
                        $credits,
                        $transaction_id,
                        $amount,
                        $currency
                    ) {
            
                        // 🔒 STRONG IDEMPOTENCY (WITH LOCK)
                        $exists = DB::table('sys_finance_user_type_30_service_credits')
                            ->where('TransactionID', $transaction_id)
                            ->lockForUpdate()
                            ->exists();
            
                        if ($exists) {
                            Log::info('Duplicate webhook ignored', [
                                'transaction_id' => $transaction_id
                            ]);
                            return;
                        }
            
                        $now = Carbon::now();
            
                        DB::table('sys_finance_user_type_30_service_credits')->insert([
                            'PatientUserID' => $user_id,
                            'NumberSessionsPurchased' => $credits,
                            'CreditDate' => $now->format('Y-m-d'),
                            'CreditTime' => $now->format('H:i:s'),
                            'CreditValue' => $amount,
                            'CreditCurrency' => $currency,
                            'TransactionID' => $transaction_id,
                            'TransactionResult' => 'success',
                            'created_at' => $now,
                            'updated_at' => $now,
                        ]);
            
                        $user = User::find($user_id);
                        if ($user) {
                            $user->notify(new UserSessionPurchaseConfirmationNotification());
                        }
                    });
            
                } catch (\Throwable $e) {
                    Log::error('Webhook transaction failed', [
                        'error' => $e->getMessage(),
                        'transaction_id' => $transaction_id
                    ]);
            
                    return response('failed', 500);
                }
            
                return response('ok', 200);
            }


        }

        return response('ok', 200);
    }
}
