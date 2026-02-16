<?php

namespace App\Http\Controllers\StripePayment;

use App\Http\Controllers\Controller;
use App\Models\SysFinanceServiceFeeDetail;
use App\Services\StripeService;

class BusinessRegistrationController extends Controller
{
    protected $stripe;

    public function __construct(StripeService $stripe)
    {
        $this->stripe = $stripe;
    }

    public function businessCheckout()
    {
        $user = auth()->user();

        if ($user->UserType !== 10) {
            abort(403, 'Unauthorized access.');
        }

        // Fetch Account Creation fee from DB (dynamic) for UserType = 10 Business
        $fee = SysFinanceServiceFeeDetail::where('UserType', 10)
            ->where('FeeType', 'Account Creation')
            ->first();

        if (!$fee) {
            abort(404, 'Account Creation fee not configured.');
        }

        $data = [
            'credits' => null,
            'amount'  => (float) $fee->CurrencyGBP,
        ];

        $session = $this->stripe->createCheckoutSession(
            $user,
            'business_registration',
            $data
        );

        return redirect($session->url);
    }
}
