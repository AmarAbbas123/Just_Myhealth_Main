<?php

namespace App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Patients;

use App\Http\Controllers\Controller;
use App\Models\SysUserType30OnboardQuestionsAnswers;
use App\Models\CommonCalendar;
use App\Models\User;
use App\Services\UserTimeZoneService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class PatientsBookSlotsController extends Controller
{
    private const PATIENT_SESSION_DISPLAY_MINUTES = 50;

     // For TimeZone Display
    private function formatTimezoneOffset(string $tz): string
{
    try {
        $now = \Carbon\Carbon::now($tz);
        $offset = $now->format('P'); // +01:00
        return "{$tz} (GMT{$offset})";
    } catch (\Exception $e) {
        return $tz;
    }
}


    // Show HTML page (GET /therapists/{id}/calendar)
    public function show(Request $request, $therapistId)
    {
        $userId = (int) Auth::id();
        if ($redirect = $this->redirectIfNoSessionCredits($userId)) {
            return $redirect;
        }

        $viewerTimeZone = $this->resolveUserTimeZoneName(Auth::user());

        // Load all relations
        $therapist = User::with(['userAttributes', 'type30'])->findOrFail($therapistId);

        // Default date in viewer local timezone
        $selectedDate = $request->query('date');
        if (! $selectedDate) {
            $selectedDate = Carbon::now($viewerTimeZone)->toDateString();
        }

        // Therapist card info for Blade timezone
        $viewerTimeZone = $this->resolveUserTimeZoneName(Auth::user());
        $timezoneDisplay = $this->formatTimezoneOffset($viewerTimeZone);

        // Therapist card info for Blade
        $therapistCard = [
            'id'    => $therapist->ID,
            'name'  => trim(($therapist->userAttributes->FirstName ?? '') . ' ' . ($therapist->userAttributes->LastName ?? '')),
            'avatar' => $therapist->type30?->BioPhotoPath
                ? asset('storage/' . $therapist->type30->BioPhotoPath)
                : asset('images/default-user.png'),
            'therapy_types' => $this->extractTherapies($therapist),
        ];

        $viewMode = $request->query('view') ?? 'week'; // week | month | day

        switch ($viewMode) {
            case 'month':
                $slots = $this->getSlotsForMonth($therapistId, $selectedDate, $viewerTimeZone);
                break;

            case 'day':
                $dayStart = Carbon::parse($selectedDate, $viewerTimeZone)->startOfDay();
                $dayEnd = Carbon::parse($selectedDate, $viewerTimeZone)->endOfDay();
                $slots = $this->getSlotsForRange($therapistId, $dayStart, $dayEnd, $viewerTimeZone);
                break;

            default: // week
                $slots = $this->getSlotsForWeek($therapistId, $selectedDate, $viewerTimeZone);
        }

        return view('modules.mod-10.01-counselling.patients.patients-book-slots', [
            'therapistCard' => $therapistCard,
            'therapistId' => $therapistId,
            'selectedDate' => $selectedDate,
            'viewMode' => $viewMode,
            'slots' => $slots,
            'displayTimeZone' => $timezoneDisplay,
            'userTimeZone' => $viewerTimeZone,
        ]);
    }

    private function extractTherapies($therapist)
    {
        $type = $therapist->type30;

        if (! $type) {
            return [];
        }

        $list = [];

        for ($i = 1; $i <= 5; $i++) {
            $t = $type->{"TherapyType{$i}"};
            $y = $type->{"TherapyYearsExperience{$i}"};

            if ($t && $y) {
                $list[] = "{$t} - {$y} Years";
            }
        }

        return $list;
    }

    // API: returns JSON slots for one date (GET /therapists/{id}/calendar/slots?date=YYYY-MM-DD)
    public function slots(Request $request, $therapistId)
    {
        $userId = (int) Auth::id();
        if ($this->getRemainingSessionCreditsForUser($userId) <= 0) {
            return response()->json([
                'message' => 'Please purchase additional sessions before booking.',
                'redirect' => route('pay.sessions.options'),
            ], 403);
        }

        $viewerTimeZone = $this->resolveUserTimeZoneName(Auth::user());
        $date = $request->query('date') ?? Carbon::now($viewerTimeZone)->toDateString();
        $slots = $this->getSlotsForWeek($therapistId, $date, $viewerTimeZone);

        return response()->json([
            'date' => $date,
            'slots' => $slots,
        ]);
    }

    // Book a slot (POST /therapists/{id}/book)
    public function book(Request $request, $therapistId)
    {
        $userId = Auth::id();
        if (! $userId) {
            return redirect()->route('login');
        }
        if ($redirect = $this->redirectIfNoSessionCredits((int) $userId)) {
            return $redirect;
        }

        $request->validate([
            'date' => 'required|date_format:Y-m-d',
            'time_from' => 'required|date_format:H:i',
            'time_to' => 'required|date_format:H:i',
            'session_type' => 'required|in:Video,Audio,Message',
        ]);

        $viewerTimeZone = $this->resolveUserTimeZoneName(Auth::user());
        $date = $request->input('date');
        $timeFrom = $request->input('time_from');
        $timeTo = $request->input('time_to');

        // Wrap in transaction to avoid race condition
        DB::beginTransaction();
        try {
            $startLocal = Carbon::createFromFormat('Y-m-d H:i', "{$date} {$timeFrom}", $viewerTimeZone);
            $endLocal = Carbon::createFromFormat('Y-m-d H:i', "{$date} {$timeTo}", $viewerTimeZone);
            if (! $this->isFutureDateTime($startLocal, $viewerTimeZone)) {
                DB::rollBack();
                return back()->withErrors([
                    'slot' => 'You can only book future time slots.',
                ]);
            }
            if ($endLocal->lte($startLocal)) {
                $endLocal->addDay();
            }
            if (! $this->isExactSixtyMinuteWindow($startLocal, $endLocal)) {
                DB::rollBack();
                return back()->withErrors([
                    'slot' => 'Session duration must be exactly 60 minutes.',
                ]);
            }
            $startUtc = $startLocal->copy()->setTimezone('UTC');
            $endUtc = $endLocal->copy()->setTimezone('UTC');

            // Find any overlapping Busy entry for this therapist (UTC)
            $overlap = CommonCalendar::where('TherapistUserID', $therapistId)
                ->where('CalendarEntryType', 'Busy')
                ->where('SessionDateTimeFrom', '<', $endUtc)
                ->where('SessionDateTimeTo', '>', $startUtc)
                ->lockForUpdate()
                ->exists();

            if ($overlap) {
                DB::rollBack();
                return back()->withErrors(['slot' => 'Selected time is no longer available. Please pick another slot.']);
            }

            // 1. Find the existing AVAILABLE slot by UTC datetime
            $slot = CommonCalendar::where('TherapistUserID', $therapistId)
                ->where('CalendarEntryType', 'Available')
                ->where('SessionDateTimeFrom', $startUtc->format('Y-m-d H:i:s'))
                ->where('SessionDateTimeTo', $endUtc->format('Y-m-d H:i:s'))
                ->lockForUpdate()
                ->first();

            if (! $slot) {
                DB::rollBack();
                return back()->withErrors([
                    'slot' => 'Slot not found or already booked.',
                ]);
            }

            // Fetch patient's Zego session ID from onboarding answers
            $zegoSessionId = SysUserType30OnboardQuestionsAnswers::where('PatientUserID', $userId)
                ->where('QuestionCompletionStatus', 1)
                ->value('SessionZegoCloudConnectID');

            if (! $zegoSessionId) {
                DB::rollBack();
                return back()->withErrors([
                    'error' => 'Onboarding not completed. Cannot book session.'
                ]);
            }

            $patientOffset = app(UserTimeZoneService::class)->getUtcOffsetForTimezone($viewerTimeZone, $startUtc);

            // 2. Update that row into Busy (instead of creating new)
            $slot->update([
                'CalendarEntryType' => 'Busy',
                'PatientUserID' => $userId,
                'SessionType' => $request->session_type,
                'SessionDateTimeFrom' => $startUtc,
                'SessionDateTimeTo' => $endUtc,
                'SessionZegoCloudConnectID' => $zegoSessionId,
                'PatientTimeZone' => $patientOffset,
            ]);

            DB::commit();

            $remainingCredits = $this->getRemainingSessionCreditsForUser((int) $userId);
            if ($remainingCredits <= 0) {
                return redirect('/mod-10/01/usr-therapy-calendar')
                    ->with('success', 'Session booked successfully.');
            }

            return redirect()->route('session.book', ['id' => $therapistId, 'date' => $date])
                ->with('success', 'Session booked successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Booking failed: ' . $e->getMessage()]);
        }
    }

    public function getSlotsForWeek($therapistId, $date, string $displayTimeZone)
    {
        // Ensure $date is interpreted in the display timezone
        $base = Carbon::parse($date, $displayTimeZone)->startOfWeek(Carbon::MONDAY);
        $startOfWeekLocal = $base->copy()->startOfDay();
        $endOfWeekLocal = $base->copy()->endOfWeek(Carbon::SUNDAY)->endOfDay();

        $startOfWeekUtc = $startOfWeekLocal->copy()->setTimezone('UTC');
        $endOfWeekUtc = $endOfWeekLocal->copy()->setTimezone('UTC');

        $entries = CommonCalendar::where('TherapistUserID', $therapistId)
            ->whereBetween('SessionDateTimeFrom', [$startOfWeekUtc, $endOfWeekUtc])
            ->orderBy('SessionDateTimeFrom')
            ->get();

        // Prepare week map with keys for every date (Y-m-d) in local timezone
        $week = [];
        for ($d = $startOfWeekLocal->copy(); $d->lte($endOfWeekLocal); $d->addDay()) {
            $week[$d->toDateString()] = [];
        }

        foreach ($entries as $e) {
            
            if ($e->CalendarEntryType === 'Busy') {
                continue; // ✅ hide busy slots
            }

            $startUtc = $e->SessionDateTimeFrom
                ? Carbon::parse($e->SessionDateTimeFrom, 'UTC')
                : Carbon::parse(trim($e->DateFrom) . ' ' . trim($e->TimeFrom), 'UTC');
            $endUtc = $e->SessionDateTimeTo
                ? Carbon::parse($e->SessionDateTimeTo, 'UTC')
                : Carbon::parse(trim($e->DateTo) . ' ' . trim($e->TimeTo), 'UTC');

            $startLocal = $startUtc->copy()->setTimezone($displayTimeZone);
            $endLocal = $endUtc->copy()->setTimezone($displayTimeZone);
            $displayEndLocal = $startLocal->copy()->addMinutes(self::PATIENT_SESSION_DISPLAY_MINUTES);
            $day = $startLocal->toDateString();

            if (!array_key_exists($day, $week)) {
                continue;
            }

            $week[$day][] = [
                'id' => $e->ID,
                'type' => $e->CalendarEntryType, // Available / Busy / Blocked / Emergency
                'time_from' => $startLocal->format('H:i'),
                'time_to' => $endLocal->format('H:i'),
                'display_time_to' => $displayEndLocal->format('H:i'),
                'display_duration_minutes' => self::PATIENT_SESSION_DISPLAY_MINUTES,
                'session_type' => $e->SessionType,
                'patient_user_id' => $e->PatientUserID,
                'date' => $day,
            ];
        }

        return $week;
    }

    public function getSlotsForMonth($therapistId, $date, string $displayTimeZone)
    {
        $base = Carbon::parse($date, $displayTimeZone)->firstOfMonth();
        $start = $base->copy()->startOfWeek(Carbon::MONDAY)->startOfDay();
        $end = $base->copy()->endOfMonth()->endOfWeek(Carbon::SUNDAY)->endOfDay();

        return $this->getSlotsForRange($therapistId, $start, $end, $displayTimeZone);
    }

    public function getSlotsForRange($therapistId, $start, $end, string $displayTimeZone)
    {
        $startLocal = $start->copy()->setTimezone($displayTimeZone)->startOfDay();
        $endLocal = $end->copy()->setTimezone($displayTimeZone)->endOfDay();
        $startUtc = $startLocal->copy()->setTimezone('UTC');
        $endUtc = $endLocal->copy()->setTimezone('UTC');

        $entries = CommonCalendar::where('TherapistUserID', $therapistId)
            ->whereBetween('SessionDateTimeFrom', [$startUtc, $endUtc])
            ->orderBy('SessionDateTimeFrom')
            ->get();

        $days = [];
        for ($d = $startLocal->copy(); $d->lte($endLocal); $d->addDay()) {
            $days[$d->toDateString()] = [];
        }

        foreach ($entries as $e) {

            if ($e->CalendarEntryType === 'Busy') {
                continue; // ✅ hide busy slots
            }

            $startUtc = $e->SessionDateTimeFrom
                ? Carbon::parse($e->SessionDateTimeFrom, 'UTC')
                : Carbon::parse(trim($e->DateFrom) . ' ' . trim($e->TimeFrom), 'UTC');
            $endUtc = $e->SessionDateTimeTo
                ? Carbon::parse($e->SessionDateTimeTo, 'UTC')
                : Carbon::parse(trim($e->DateTo) . ' ' . trim($e->TimeTo), 'UTC');

            $startSlotLocal = $startUtc->copy()->setTimezone($displayTimeZone);
            $endSlotLocal = $endUtc->copy()->setTimezone($displayTimeZone);
            $displayEndSlotLocal = $startSlotLocal->copy()->addMinutes(self::PATIENT_SESSION_DISPLAY_MINUTES);
            $day = $startSlotLocal->toDateString();

            if (!array_key_exists($day, $days)) {
                continue;
            }

            $days[$day][] = [
                'id' => $e->ID,
                'type' => $e->CalendarEntryType,
                'time_from' => $startSlotLocal->format('H:i'),
                'time_to' => $endSlotLocal->format('H:i'),
                'display_time_to' => $displayEndSlotLocal->format('H:i'),
                'display_duration_minutes' => self::PATIENT_SESSION_DISPLAY_MINUTES,
                'session_type' => $e->SessionType,
                'patient_user_id' => $e->PatientUserID,
                'date' => $day,
            ];
        }

        return $days;
    }

    private function resolveUserTimeZoneName(?User $user): string
    {
        return app(UserTimeZoneService::class)->getUserHomeTimezoneName($user);
    }

    private function isFutureDateTime(Carbon $dateTime, string $timeZone): bool
    {
        return $dateTime->greaterThan(Carbon::now($timeZone));
    }

    private function redirectIfNoSessionCredits(int $userId)
    {
        if ($this->getRemainingSessionCreditsForUser($userId) > 0) {
            return null;
        }

        return redirect()
            ->route('pay.sessions.options')
            ->with('session_credit_required', true)
            ->with('session_credit_message', 'You need to purchase additional sessions before booking.');
    }

    private function getRemainingSessionCreditsForUser(int $userId): int
    {
        $table = 'sys_finance_user_type_30_open_session_balance';

        if (! Schema::hasTable($table) || ! Schema::hasColumn($table, 'RemainingSessionCredits')) {
            return 0;
        }

        $lookupColumn = collect(['PatientUserID', 'UserID', 'ID'])
            ->first(fn($column) => Schema::hasColumn($table, $column));

        if (! $lookupColumn) {
            return 0;
        }

        $credits = DB::table($table)
            ->where($lookupColumn, $userId)
            ->value('RemainingSessionCredits');

        return max(0, (int) $credits);
    }

    private function isExactSixtyMinuteWindow(Carbon $start, Carbon $end): bool
    {
        return $start->diffInMinutes($end) === 60;
    }
}
