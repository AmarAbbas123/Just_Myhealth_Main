<?php

namespace App\Http\Controllers\StripePayment;

use App\Http\Controllers\Controller;
use App\Models\SysFinanceServiceFeeDetail;
use App\Models\User;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Auth;

class TherapistsRegistrationController extends Controller
{
    protected $stripe;

    public function __construct(StripeService $stripe)
    {
        $this->stripe = $stripe;
    }

    public function therapistCheckout()
    {
        $user = auth()->user();
        $userType = $user->UserType;

        if ($user->UserType !== 30) {
            abort(403, 'Unauthorized access.');
        }

        // TEMP: Therapist registration fee is waived during initial onboarding.
        // To re-enable the fee, set $therapistFeeWaived = false.
        $therapistFeeWaived = true;
        if ($therapistFeeWaived) {
            return redirect()->route('verification.notice');
        }

        // Fetch Account Creation fee from DB (dynamic)  NOw only for UserType = 30 Therapists 
        $fee = SysFinanceServiceFeeDetail::where('UserType', 30)
            ->where('FeeType', 'Account Creation')
            ->first();

        if (!$fee) {
            abort(404, 'Account Creation fee not configured.');
        }

        // Build data EXACTLY the same way SessionPurchaseController does
        $data = [
            'credits' => null,                 // not used but consistent
            'amount'  => (float) $fee->CurrencyGBP,  // dynamic amount
        ];

        // Call StripeService EXACTLY the same way:
        $session = $this->stripe->createCheckoutSession(
            $user,
            'therapist_registration',
            $data
        );

        return redirect($session->url);
    }
}
