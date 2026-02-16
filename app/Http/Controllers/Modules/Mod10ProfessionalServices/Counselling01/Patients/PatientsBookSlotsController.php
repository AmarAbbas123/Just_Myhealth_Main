<?php

namespace App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Patients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SysUserType30OnboardQuestionsAnswers;
use App\Models\CommonCalendar;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PatientsBookSlotsController extends Controller
{

    // Show HTML page (GET /therapists/{id}/calendar)
    public function show(Request $request, $therapistId)
    {
        // Load all relations
        $therapist = User::with(['userAttributes', 'type30'])->findOrFail($therapistId);

        // Default date
        $selectedDate = $request->query('date');
        if (! $selectedDate) {
            $tz = $therapist->type30->BaseTimeZone ?? '+00:00';
            $selectedDate = Carbon::now($tz)->toDateString();
        }

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
                $slots = $this->getSlotsForMonth($therapistId, $selectedDate);
                break;

            case 'day':
                $slots = $this->getSlotsForRange(
                    $therapistId,
                    Carbon::parse($selectedDate)->startOfDay(),
                    Carbon::parse($selectedDate)->endOfDay()
                );
                break;

            default: // week
                $slots = $this->getSlotsForWeek($therapistId, $selectedDate);
        }

        return view('modules.mod-10.01-counselling.patients.patients-book-slots', [
            'therapistCard' => $therapistCard,
            'therapistId' => $therapistId,
            'selectedDate' => $selectedDate,
            'viewMode' => $viewMode,
            'slots' => $slots,
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
                $list[] = "{$t} – {$y} Years";
            }
        }

        return $list;
    }


    // API: returns JSON slots for one date (GET /therapists/{id}/calendar/slots?date=YYYY-MM-DD)
    public function slots(Request $request, $therapistId)
    {
        $date = $request->query('date') ?? date('Y-m-d');
        $slots = $this->getSlotsForWeek($therapistId, $date);

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

        $request->validate([
            'date' => 'required|date_format:Y-m-d',
            'time_from' => 'required|date_format:H:i',
            'time_to' => 'required|date_format:H:i|after:time_from',
            'session_type' => 'required|in:Video,Audio,Message',
        ]);

        $date = $request->input('date');
        $timeFrom = $request->input('time_from');
        $timeTo = $request->input('time_to');
        $sessionType = $request->input('session_type');

        // Wrap in transaction to avoid race condition
        DB::beginTransaction();
        try {
            // Find any overlapping Busy entry for this therapist and datetime
            // Compare by date + time columns (assuming DateFrom/TimeFrom and DateTo/TimeTo define occupied ranges)
            $overlap = CommonCalendar::where('TherapistUserID', $therapistId)
                ->where('CalendarEntryType', 'Busy')
                ->whereRaw(
                    "TIMESTAMP(DateFrom, TimeFrom) < TIMESTAMP(?, ?)",
                    [$date, $timeTo]
                )
                ->whereRaw(
                    "TIMESTAMP(DateTo, TimeTo) > TIMESTAMP(?, ?)",
                    [$date, $timeFrom]
                )
                ->lockForUpdate()
                ->exists();

            if ($overlap) {
                DB::rollBack();
                return back()->withErrors(['slot' => 'Selected time is no longer available. Please pick another slot.']);
            }

            // Create Busy booking row
            // Determine therapist timezone. Prefer TherapistTimeZone on therapist profile, fallback to provided column or +00:00
            $therapist = User::findOrFail($therapistId);
            $therapistTZ = $therapist->timezone ?? '+00:00';
            // Build UTC session datetimes for SessionDateTimeFrom/To fields
            $startInTherapistTZ = Carbon::createFromFormat('Y-m-d H:i', "$date $timeFrom", $therapistTZ);
            $endInTherapistTZ   = Carbon::createFromFormat('Y-m-d H:i', "$date $timeTo", $therapistTZ);

            // Convert to UTC (or store as therapist timezone - keep consistent)
            $startUtc = $startInTherapistTZ->copy()->setTimezone('UTC');
            $endUtc   = $endInTherapistTZ->copy()->setTimezone('UTC');

            // 1. Find the existing AVAILABLE slot
            $slot = CommonCalendar::where('TherapistUserID', $therapistId)
                ->where('DateFrom', $date)
                ->where('TimeFrom', $timeFrom . ':00')
                ->where('CalendarEntryType', 'Available')
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

            // 2. Update that row into Busy (instead of creating new)
            $slot->update([
                'CalendarEntryType' => 'Busy',
                'PatientUserID' => $userId,
                'SessionType' => $request->session_type,
                'SessionDateTimeFrom' => $startUtc,
                'SessionDateTimeTo' => $endUtc,
                'SessionZegoCloudConnectID' => $zegoSessionId,
            ]);

            DB::commit();

            return redirect()->route('therapist.calendar.show', ['id' => $therapistId, 'date' => $date])
                ->with('reload', true);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Booking failed: ' . $e->getMessage()]);
        }
    }

    public function getSlotsForWeek($therapistId, $date)
    {
        // Ensure $date is a Y-m-d string
        $base = Carbon::parse($date)->startOfWeek(); // Monday
        $startOfWeek = $base->copy();
        $endOfWeek   = $base->copy()->endOfWeek();

        // Query any entries that touch the week (DateFrom..DateTo)
        $entries = CommonCalendar::where('TherapistUserID', $therapistId)
            ->where(function ($q) use ($startOfWeek, $endOfWeek) {
                $q->whereBetween('DateFrom', [$startOfWeek->toDateString(), $endOfWeek->toDateString()])
                    ->orWhereBetween('DateTo', [$startOfWeek->toDateString(), $endOfWeek->toDateString()]);
            })
            ->orderBy('DateFrom')
            ->orderBy('TimeFrom')
            ->get();

        // Prepare week map with keys for every date (Y-m-d)
        $week = [];
        for ($d = $startOfWeek->copy(); $d->lte($endOfWeek); $d->addDay()) {
            $week[$d->toDateString()] = [];
        }

        foreach ($entries as $e) {
            // Normalize date string (DateFrom may be Carbon or string)
            $day = $e->DateFrom instanceof \Carbon\Carbon ? $e->DateFrom->toDateString() : (string) $e->DateFrom;

            // Normalize time strings (some DB fields include seconds)
            $timeFrom = substr($e->TimeFrom, 0, 8);
            $timeTo = substr($e->TimeTo, 0, 8);

            // Therapist timezone if present
            $tz  = $e->TherapistTimeZone ?: '+00:00';

            // Build proper Carbon start/end using the normalized date + time
            try {
                $start = Carbon::createFromFormat('Y-m-d H:i:s', $day . ' ' . $timeFrom, $tz);
            } catch (\Exception $ex) {
                // fallback if seconds not present
                $start = Carbon::createFromFormat('Y-m-d H:i', $day . ' ' . substr($timeFrom, 0, 5), $tz);
            }

            try {
                $end = Carbon::createFromFormat('Y-m-d H:i:s', $day . ' ' . $timeTo, $tz);
            } catch (\Exception $ex) {
                $end = Carbon::createFromFormat('Y-m-d H:i', $day . ' ' . substr($timeTo, 0, 5), $tz);
            }

            // Ensure the key exists (if DateFrom outside week but DateTo intersects, push to the intersecting days)
            $slot = [
                'id' => $e->ID,
                'type' => $e->CalendarEntryType, // Available / Busy / Blocked / Emergency
                'time_from' => $start->format('H:i'),
                'time_to' => $end->format('H:i'),
                'session_type' => $e->SessionType,
                'patient_user_id' => $e->PatientUserID,
                // include original date for reference
                'date' => $day,
            ];

            // If entry spans multiple days, split per day (rare for your use-case but robust)
            $cursor = $start->copy();
            while ($cursor->toDateString() <= $end->toDateString()) {
                $dstr = $cursor->toDateString();

                // compute slice start/end for that day
                $sliceStart = $cursor->toDateString() === $start->toDateString() ? $start->format('H:i') : '00:00';
                $sliceEnd = $cursor->toDateString() === $end->toDateString() ? $end->format('H:i') : '23:59';

                $week[$dstr][] = array_merge($slot, [
                    'time_from' => $sliceStart,
                    'time_to' => $sliceEnd,
                    'date' => $dstr,
                ]);

                $cursor->addDay()->startOfDay();
            }
        }

        return $week;
    }

    public function getSlotsForMonth($therapistId, $date)
    {
        $base = Carbon::parse($date)->firstOfMonth();
        $start = $base->copy()->startOfWeek();     // start Monday before month
        $end   = $base->copy()->endOfMonth()->endOfWeek(); // end Sunday after month

        return $this->getSlotsForRange($therapistId, $start, $end);
    }

    public function getSlotsForRange($therapistId, $start, $end)
    {
        $entries = CommonCalendar::where('TherapistUserID', $therapistId)
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('DateFrom', [$start->toDateString(), $end->toDateString()])
                    ->orWhereBetween('DateTo', [$start->toDateString(), $end->toDateString()]);
            })
            ->orderBy('DateFrom')
            ->orderBy('TimeFrom')
            ->get();

        $days = [];
        for ($d = $start->copy(); $d->lte($end); $d->addDay()) {
            $days[$d->toDateString()] = [];
        }

        foreach ($entries as $e) {
            $day = $e->DateFrom instanceof \Carbon\Carbon ? $e->DateFrom->toDateString() : (string)$e->DateFrom;
            $timeFrom = substr($e->TimeFrom, 0, 8);
            $timeTo   = substr($e->TimeTo, 0, 8);
            $tz = $e->TherapistTimeZone ?? '+00:00';

            $startSlot = Carbon::parse("$day $timeFrom", $tz);
            $endSlot   = Carbon::parse("$day $timeTo", $tz);

            $cursor = $startSlot->copy();
            while ($cursor->lte($endSlot)) {
                $dstr = $cursor->toDateString();
                if (isset($days[$dstr])) {
                    $days[$dstr][] = [
                        'id' => $e->ID,
                        'type' => $e->CalendarEntryType,
                        'time_from' => $startSlot->format('H:i'),
                        'time_to' => $endSlot->format('H:i'),
                        'session_type' => $e->SessionType,
                        'patient_user_id' => $e->PatientUserID,
                        'date' => $dstr,
                    ];
                }
                $cursor->addDay()->startOfDay();
            }
        }

        return $days;
    }
}
