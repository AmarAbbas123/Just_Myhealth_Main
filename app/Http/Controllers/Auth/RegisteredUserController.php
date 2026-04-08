<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SysUserAttribute;
use App\Models\SysFinanceServiceFeeDetail;
use App\Notifications\AdminNewUserRegisteredNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;
use App\Traits\DeviceLogger;
use App\Services\KeycloakService;
use App\Services\UserTimeZoneService;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request, UserTimeZoneService $timeZoneService)
    {
        // 1. Block already logged-in users
        if (Auth::check()) {
            return view('modules.dashboard');
        }

        // 2. Require type param
        if (!$request->has('type')) {
            return redirect()->route('regAccountType');
        }

        $type = $request->query('type');
        $countryOptions = $timeZoneService->getCountryOptions();
        if (empty($countryOptions)) {
            $countryOptions = config('user_options.Country', []);
        }

        return view('modules.mod-00.register', compact('type', 'countryOptions'));
    }

    public function registerAccountType()
    {
        // Fetch Account Creation fee for UserType 30 and 10 from DB (dynamic)
        $feeTherapist = SysFinanceServiceFeeDetail::where('UserType', '30')
            ->where('FeeType', 'Account Creation')
            ->first();

        $feeBusiness = SysFinanceServiceFeeDetail::where('UserType', '10')
            ->where('FeeType', 'Account Creation')
            ->first();

        // TEMP: Therapist registration fee is waived during initial onboarding.
        // To re-enable the fee, set $therapistFeeWaived = false.
        $therapistFeeWaived = true;

        if (!$feeBusiness) {
            abort(404, 'Account Creation fee not configured for business.');
        }

        // Check if both fees are available
        if (!$therapistFeeWaived && !$feeTherapist) {
            abort(404, 'Account Creation fee not configured for therapist.');
        }

        $therapistFeeAmount = $therapistFeeWaived ? 0 : (float) $feeTherapist->CurrencyGBP;

        return view('modules.mod-00.register-account-type', compact('feeBusiness', 'therapistFeeAmount', 'therapistFeeWaived'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, UserTimeZoneService $timeZoneService): RedirectResponse
    {
        $userType = $request->UserType;
        $countryOptions = $timeZoneService->getCountryOptions();
        if (empty($countryOptions)) {
            $countryOptions = config('user_options.Country', []);
        }

        // Load required dynamic profile fields from config
        $profileFields = config("user_fields.$userType", []);

        // Define validation rules
        $rules = [
            'UserType' => 'required|integer',
            'UserName' => 'required|string|min:4|regex:/^[A-Za-z0-9]+$/|unique:users,UserName',
            'Email' => 'required|email|max:255',
            'Password' => 'required|string|min:8|confirmed',
            'Terms' => 'accepted',
            'Privacy' => 'accepted',
            'GDPR' => 'nullable|accepted',
        ];

        // Add dynamic ProfileData validation rules
        foreach ($profileFields as $field) {
            if ($field === 'Address2') {
                $rules["ProfileData.$field"] = 'nullable|string|max:255';
            } elseif ($field === 'Country') {
                $rules["ProfileData.$field"] = ['required', 'string', 'max:255'];
                if (!empty($countryOptions)) {
                    $rules["ProfileData.$field"][] = Rule::in($countryOptions);
                }
            } else {
                $rules["ProfileData.$field"] = 'required|string|max:255';
            }
        }

        $validated = $request->validate($rules);

        // Create the user
        $user = User::create([
            'UserType' => $validated['UserType'],
            'UserName' => $validated['UserName'],
            'Email' => $validated['Email'],
            'Password' => Hash::make($validated['Password']),
            'AccountStatus' => 0,   // INACTIVE until verified / paid
            'AccountSetupComplete' => 0, // INACTIVE until Approved by Admin
            'UserCreatedDateTime' => now(),
            'NeedsEmailPrompt' => true,
        ]);

        $profileData = $validated['ProfileData'] ?? [];

        // Save personal attributes using the sys_user_attributes column names.
        $attributesData = [];
        foreach ($profileFields as $field) {
            $attributesData[$this->mapUserAttributeField($field)] = $profileData[$field] ?? null;
        }
        $attributesData['UserHomeTimeZoneName'] = $timeZoneService->resolveTimezoneNameByCountry($profileData['Country'] ?? null);

        SysUserAttribute::create(array_merge(
            ['UserID' => $user->ID],
            $attributesData
        ));

        // Create user in Keycloak   // this iscommented for PROD RIGHT NOW
        $keycloak = new KeycloakService();
        $firstName = $validated['ProfileData']['FirstName'] ?? '';
        $lastName  = $validated['ProfileData']['LastName'] ?? '';
        $keycloakUserId = $keycloak->createUser($user->UserName, $user->Email, $request->Password, $firstName, $lastName);

        // // // store keycloak id locally (recommended)
        if ($keycloakUserId) {
            $user->keycloak_id = $keycloakUserId;
            $user->save();
        }

        DeviceLogger::log($user->ID, $user->UserType, 'Registration');

        Notification::route('mail', config('mail.admin_notification_address'))
            ->notify(new AdminNewUserRegisteredNotification($user));

        // Log in the user so therapist checkout routes work.
        Auth::login($user);

        /** ------------------------------------
         *  CONDITIONAL REDIRECT
         * -----------------------------------*/

        // 🔐 Force Therapist/Business → must pay first
        // TEMP: Therapist registration fee is waived during initial onboarding.
        // To re-enable the fee, set $therapistFeeWaived = false.
        $therapistFeeWaived = true;
        if ($user->UserType === 30) {
            if ($therapistFeeWaived) {
                event(new Registered($user)); // email verification
                return redirect()->route('verification.notice');
            }
            return redirect()->route('therapist.checkout');
        }
        if ($user->UserType === 10) {
            return redirect()->route('business.checkout');
        }

        // 👤 Patient → normal registration
        event(new Registered($user)); // email verification

        // Normal Patients User should register without payment            
        return redirect()->route('verification.notice');
    }

    private function mapUserAttributeField(string $field): string
    {
        return match ($field) {
            'Country' => 'BaseCountry',
            'State' => 'BaseState',
            'City' => 'BaseCity',
            'ZIP' => 'BaseZip',
            'DoB' => 'DOB',
            default => $field,
        };
    }
}
