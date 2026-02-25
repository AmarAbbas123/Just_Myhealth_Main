<?php

namespace App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists;

use App\Http\Controllers\Controller;
use App\Models\SysFinanceUserType30ServiceDebits;
use App\Models\SysUserType30SessionHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class FinancialManagementController extends Controller
{

    public function financialManagement(Request $request)
    {
        $therapistId = auth()->id();

        /* Sessions */
        $sessionTransactions = SysUserType30SessionHistory::where('AllocatedTherapistUserID', $therapistId)
            ->whereNotNull('SessionEndedDate')
            ->with(['patient.userAttributes'])  // from indirect relations with SysUserAttribute Model via Users Model
            ->orderByDesc('SessionEndedDate')
            ->get()
            ->map(fn($s) => [
                'id' => $s->ID,
                'date' => $s->SessionEndedDate,
                'screen_name' => $s->patient?->UserName ?? 'Unknown',
                'real_name' => trim(
                    ($s->patient?->userAttributes?->FirstName ?? '') . ' ' .
                        ($s->patient?->userAttributes?->LastName ?? '')
                ),
                'amount' => number_format($s->TherapistPaymentValue ?? 0, 2),
                'payment_status' => $s->TherapistPaymentCompleted === 'Y'
                    ? 'PAID'
                    : 'OWED',
            ]);

        /* Payouts */
        $payoutTransactions = SysFinanceUserType30ServiceDebits::where('AllocatedTherapistUserID', $therapistId)
            ->orderByDesc('DebitDate')
            ->orderByDesc('DebitTime')
            ->get()
            ->map(fn($d) => [
                'id' => $d->ID,
                'date' => $d->DebitDate,
                'amount' => number_format($d->DebitValue ?? 0, 2),
            ]);

        return view('modules.mod-10.01-counselling.therapists.financial-management', [

            'netRevenue' => round(SysUserType30SessionHistory::where('AllocatedTherapistUserID', $therapistId)
                ->whereNotNull('SessionEndedDate')
                ->sum('TherapistPaymentValue'), 2),

            'paymentsMade' => round(SysFinanceUserType30ServiceDebits::where('AllocatedTherapistUserID', $therapistId)
                ->whereYear('DebitDate', Carbon::now()->year)
                ->sum('DebitValue'), 2),

            'paymentsOwed' => round(SysUserType30SessionHistory::where('AllocatedTherapistUserID', $therapistId)
                ->where('TherapistPaymentCompleted', 'N')
                ->whereNotNull('SessionEndedDate')
                ->sum('TherapistPaymentValue'), 2),

            'unscheduledValue' => round(SysUserType30SessionHistory::where('AllocatedTherapistUserID', $therapistId)
                ->whereNull('SessionStartedDate')
                ->sum(DB::raw('NumberOfPurchasedSessions * RevenueForSession')), 2),

            'sessionTransactions' => $sessionTransactions,
            'payoutTransactions' => $payoutTransactions,
        ]);
    }
}