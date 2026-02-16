<?php

namespace App\Http\Controllers\StripePayment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentSuccessController extends Controller
{
    public function handle(Request $request)
    {
        $sessionId = $request->session_id;

        if (!$sessionId) {
            return "Invalid payment success callback — no session ID.";
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::retrieve($sessionId);

        $userId = $session->metadata->user_id ?? null;
        $userType = (int) ($session->metadata->user_type ?? 0);

        if (!$userId) {
            return "Could not detect user ID.";
        }

        Auth::loginUsingId($userId);

        $user = Auth::user();

        /*
    |--------------------------------------------------------------------------
    | USER TYPE GROUPS
    |--------------------------------------------------------------------------
    */

        $therapistUserTypes = [30, 31, 32];   // therapists / professionals
        $businessUserTypes  = [10];           // business users
        $patientUserTypes   = [1, 2, 3];      // patients / normal users

        /*
    |--------------------------------------------------------------------------
    | THERAPIST FLOW — SEND VERIFICATION EMAIL HERE
    |--------------------------------------------------------------------------
    */

        if (in_array($userType, $therapistUserTypes, true) || in_array($userType, $businessUserTypes, true)) {

            if (
                $user instanceof MustVerifyEmail &&
                !$user->hasVerifiedEmail()
            ) {
                $user->sendEmailVerificationNotification();
            }

            return redirect()->route('verification.notice');
        }

        /*
    |--------------------------------------------------------------------------
    | PATIENT FLOW
    |--------------------------------------------------------------------------
    */

        if (in_array($userType, $patientUserTypes, true)) {
            return redirect()->route('onboarding.start');
        }

        /*
    |--------------------------------------------------------------------------
    | FALLBACK — UNKNOWN / FUTURE USER TYPES
    |--------------------------------------------------------------------------
    */

        return response(
            '<h1 style="color: green; font-weight: bold;">
            Payment completed successfully. Your account will be processed shortly.
         </h1>',
            200
        )->header('Content-Type', 'text/html');
    }
}
