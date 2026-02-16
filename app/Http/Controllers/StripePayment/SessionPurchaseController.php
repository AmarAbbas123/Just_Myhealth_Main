<?php

namespace App\Http\Controllers\StripePayment;

use App\Http\Controllers\Controller;
use App\Models\SysFinanceServiceFeeDetail;
use Illuminate\Http\Request;
use App\Services\StripeService;
use Illuminate\Support\Facades\Auth;

class SessionPurchaseController extends Controller
{
    protected $stripe;

    public function __construct(StripeService $stripe)
    {
        $this->stripe = $stripe;
    }

    /**
     * Show the purchase options page (4 / 8 / 12).
     */  

       public function showPurchaseOptions()
     {
         $userType = auth()->user()->UserType; 
     
         // Fetch all counselling fee rows for this user type
         $fees = SysFinanceServiceFeeDetail::where('UserType', $userType)
             ->whereIn('FeeType', [
                 'Counselling - Four Sessions',
                 'Counselling - Eight Sessions',
                 'Counselling - Twelve Sessions',
             ])
             ->get();
     
         // Map FeeType words to number of sessions dynamically
         $mapCredits = [
             'Counselling - Four Sessions'   => 4,
             'Counselling - Eight Sessions'  => 8,
             'Counselling - Twelve Sessions' => 12,
         ];
     
         // Build options dynamically
         $options = $fees->map(function($fee) use ($mapCredits) {
             return [
                 'credits' => $mapCredits[$fee->FeeType] ?? 0,
                 'amount'  => $fee->CurrencyGBP,
             ];
         })->sortBy('credits')->values()->toArray();
     
         return view('modules.mod-10.01-counselling.patients.sessions-purchase', compact('options'));
     }    

    /**
     * Start Checkout: create a checkout session for selected package.
     * Expects: credits (int), amount (decimal), optional therapist_id (int).
     */
    public function startCheckout(Request $request)
    {
        $request->validate([
            'credits' => 'required|integer',
            'amount'  => 'required|numeric',
            'therapist_id' => 'nullable|integer',
        ]);

        $user = Auth::user();

        $data = [
            'credits' => (int) $request->credits,
            'amount'  => (float) $request->amount,
            // optional context the UI may send
            //'allocated_therapist' => $request->input('therapist_id') ? (int)$request->input('therapist_id') : null,
        ];

        // create checkout session using your StripeService
        $session = $this->stripe->createCheckoutSession($user, 'session_purchase', $data);

        // redirect to Stripe-hosted checkout
        return redirect($session->url);
    }
}
