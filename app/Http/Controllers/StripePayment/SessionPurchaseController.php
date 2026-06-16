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
    private const SESSION_PACKAGES = [
        'INDIVIDUAL' => [
            4 => 11,
            8 => 13,
            12 => 15,
        ],
        'COUPLES' => [
            4 => 18,
            8 => 20,
            12 => 22,
        ],
    ];

    public function __construct(StripeService $stripe)
    {
        $this->stripe = $stripe;
    }

    /**
     * Show the purchase options page (4 / 8 / 12).
     */  

    public function showPurchaseOptions()
    {
        $options = $this->buildSessionOptions();

        return view('modules.mod-10.01-counselling.patients.sessions-purchase', compact('options'));
    }

    /**
     * Start Checkout: create a checkout session for selected package.
     * Expects: credits (int), amount (decimal), optional therapist_id (int).
     */
    public function startCheckout(Request $request)
    {
        $request->validate([
            'credits' => 'required|integer|in:4,8,12',
            'session_type' => 'required|in:INDIVIDUAL,COUPLES',
            'therapist_id' => 'nullable|integer',
        ]);

        $user = Auth::user();
        $sessionType = $request->input('session_type');
        $credits = (int) $request->input('credits');
        $feeId = self::SESSION_PACKAGES[$sessionType][$credits] ?? null;
        $fee = SysFinanceServiceFeeDetail::where('ID', $feeId)
            ->where('UserType', $user->UserType)
            ->first();

        if (!$fee) {
            abort(404, 'Session purchase fee is not configured.');
        }

        $data = [
            'credits' => $credits,
            'amount'  => (float) $fee->CurrencyGBP,
            'session_type' => $sessionType,
            'fee_id' => (int) $fee->ID,
            // optional context the UI may send
            //'allocated_therapist' => $request->input('therapist_id') ? (int)$request->input('therapist_id') : null,
        ];

        // create checkout session using your StripeService
        $session = $this->stripe->createCheckoutSession($user, 'session_purchase', $data);

        // redirect to Stripe-hosted checkout
        return redirect($session->url);
    }

    private function buildSessionOptions(): array
    {
        $userType = auth()->user()->UserType;
        $feeIds = collect(self::SESSION_PACKAGES)
            ->flatMap(fn($packages) => array_values($packages))
            ->all();

        $fees = SysFinanceServiceFeeDetail::where('UserType', $userType)
            ->whereIn('ID', $feeIds)
            ->get()
            ->keyBy('ID');

        return collect(self::SESSION_PACKAGES)
            ->map(function ($packages, $sessionType) use ($fees) {
                return collect($packages)
                    ->map(function ($feeId, $credits) use ($fees, $sessionType) {
                        $fee = $fees->get($feeId);

                        if (!$fee) {
                            return null;
                        }

                        return [
                            'credits' => (int) $credits,
                            'amount' => $fee->CurrencyGBP,
                            'session_type' => $sessionType,
                            'fee_id' => (int) $fee->ID,
                        ];
                    })
                    ->filter()
                    ->sortBy('credits')
                    ->values()
                    ->all();
            })
            ->all();
    }
}
