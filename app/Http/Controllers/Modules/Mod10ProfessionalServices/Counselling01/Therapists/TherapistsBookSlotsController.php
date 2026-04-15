<?php

namespace App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CommonCalendar;
use App\Models\User;
use App\Services\UserTimeZoneService;
use Carbon\Carbon;

class TherapistsBookSlotsController extends Controller
{

    public function __construct()
    {
        request()->headers->set('Accept', 'application/json');
    }
    
    // Show main page (week view default). Therapist sees their own calendar.
    public function index(Request $request)
    {
        $therapistId = Auth::id();
        $therapist = User::with(['userAttributes', 'type30'])->find($therapistId);
        $therapistTimeZone = $this->resolveUserTimeZoneName($therapist);

        $selectedDate = $request->query('date') ?? Carbon::now($therapistTimeZone)->toDateString();
        $viewMode = $request->query('view') ?? 'week';

        $sessionTypes = $therapist && $therapist->type30
            ? array_filter([
                $therapist->type30->TherapyType1,
                $therapist->type30->TherapyType2,
                $therapist->type30->TherapyType3,
                $therapist->type30->TherapyType4,
                $therapist->type30->TherapyType5,
            ])
            : [];

        $therapistCard = [
            'id' => $therapistId,
            'name' => trim(($therapist?->userAttributes?->FirstName ?? '') . ' ' . ($therapist?->userAttributes?->LastName ?? '')),
            'avatar' => $therapist?->type30?->BioPhotoPath ? asset('storage/' . $therapist->type30->BioPhotoPath) : asset('images/default-user.png'),
            'therapy_types' => $sessionTypes,
        ];

        $timeRows = [];

        $startTime = Carbon::createFromTime(0, 0);   // 00:00
        $endTime   = Carbon::createFromTime(24, 0);  // 24:00
        
        $current = $startTime->copy();

        while ($current < $endTime) {
            $timeRows[] = $current->format('H:i');
            $current->addMinutes(30);
        }

        [$weeklySlots, $weekDates] = $this->getSlotsForWeek($therapistId, $selectedDate, $therapistTimeZone);

        return view('modules.mod-10.01-counselling.therapists.therapists-book-slots', [
            'therapistCard' => $therapistCard,
            'selectedDate' => $selectedDate,
            'viewMode' => $viewMode,
            'timeRows' => $timeRows,
            'weeklySlots' => $weeklySlots,
            'weekDates' => $weekDates,
            'sessionTypes' => $sessionTypes,
            'displayTimeZone' => $therapistTimeZone,
        ]);
    }

    // JSON: slots for week (same structure as Patients controller expects)
    public function slots(Request $request)
    {
        $therapistId = Auth::id();
        $date = $request->query('date') ?? date('Y-m-d');
        $therapistTimeZone = $this->resolveUserTimeZoneName(Auth::user());
        [$slots, $weekDates] = $this->getSlotsForWeek($therapistId, $date, $therapistTimeZone);

        return response()->json(['date' => $date, 'slots' => $slots, 'weekDates' => $weekDates]);
    }

    // Create new slot (Available)
    public function store(Request $request)
    {
        $therapistId = Auth::id();

        $validated = $request->validate([
            'date' => 'required|date_format:Y-m-d',
            'time_from' => 'required|date_format:H:i',
            // 'session_type' => 'nullable|string|max:191',
        ]);

        $date = $validated['date'];
        $timeFrom = $validated['time_from'];
        if (! $this->isHalfHourSlot($timeFrom)) {
            return response()->json(['error' => 'Start time must be on 00 or 30 minutes.'], 422);
        }
        // $sessionType = $validated['session_type'] ?? null;

        DB::beginTransaction();
        try {
            $therapist = Auth::user();
            $therapistTimeZone = $this->resolveUserTimeZoneName($therapist);
            $timeZoneService = app(UserTimeZoneService::class);

            $startLocal = Carbon::createFromFormat('Y-m-d H:i', $date . ' ' . $timeFrom, $therapistTimeZone);
            $endLocal = $startLocal->copy()->addHour();

            $startUtc = $startLocal->copy()->setTimezone('UTC');
            $endUtc = $endLocal->copy()->setTimezone('UTC');
            $bufferedEndUtc = $endUtc->copy()->addMinutes(30);

            // Lock any rows for this therapist that could overlap
            $overlap = CommonCalendar::where('TherapistUserID', $therapistId)
                ->where('SessionDateTimeFrom', '<', $bufferedEndUtc)
                ->whereRaw('DATE_ADD(SessionDateTimeTo, INTERVAL 30 MINUTE) > ?', [$startUtc->format('Y-m-d H:i:s')])
                ->lockForUpdate()
                ->exists();

            if ($overlap) {
                DB::rollBack();
                return response()->json(['error' => 'The requested time overlaps with an existing calendar entry. Please note that therapists require a 30-minute gap between sessions, so new slots cannot be created immediately after an existing session ends.'], 422);
            }

            $row = CommonCalendar::create([
                'TherapistUserID' => $therapistId,

                'CalendarEntryType' => 'Available',   // REQUIRED

                // 'SessionType' => in_array($sessionType, ['Video', 'Audio', 'Message']) ? $sessionType : null,

                'DateFrom' => $startUtc->toDateString(),
                'TimeFrom' => $startUtc->format('H:i:s'),
                'DateTo'   => $endUtc->toDateString(),
                'TimeTo'   => $endUtc->format('H:i:s'),

                'SessionDateTimeFrom' => $startUtc,
                'SessionDateTimeTo'   => $endUtc,

                'TherapistTimeZone' => $timeZoneService->getUtcOffsetForTimezone($therapistTimeZone, $startUtc),
                'PatientUserID' => null,
            ]);

            DB::commit();

            return response()->json(['success' => true, 'slot' => $row], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create slot: ' . $e->getMessage()], 500);
        }
    }

    // Update an existing slot (only therapist's own, and only if it's not Busy)
    public function update(Request $request, $id)
    {
        $therapistId = Auth::id();

        $validated = $request->validate([
            'date' => 'required|date_format:Y-m-d',
            'time_from' => 'required|date_format:H:i',
            'session_type' => 'nullable|string|max:191',
        ]);

        DB::beginTransaction();
        try {
            $slot = CommonCalendar::where('ID', $id)->where('TherapistUserID', $therapistId)->lockForUpdate()->firstOrFail();

            // Prevent editing if Busy (booked) or Emergency (choose policy)
            if (! in_array($slot->CalendarEntryType, ['Available', 'Blocked'])) {
                DB::rollBack();
                return response()->json(['error' => 'Cannot edit a slot in this state.'], 403);
            }

            // Check overlap excluding the slot being edited
            $date = $validated['date'];
            $timeFrom = $validated['time_from'];
            if (! $this->isHalfHourSlot($timeFrom)) {
                DB::rollBack();
                return response()->json(['error' => 'Start time must be on 00 or 30 minutes.'], 422);
            }

            $therapist = Auth::user();
            $therapistTimeZone = $this->resolveUserTimeZoneName($therapist);
            $timeZoneService = app(UserTimeZoneService::class);

            $startLocal = Carbon::createFromFormat('Y-m-d H:i', $date . ' ' . $timeFrom, $therapistTimeZone);
            $endLocal = $startLocal->copy()->addHour();
            $startUtc = $startLocal->copy()->setTimezone('UTC');
            $endUtc = $endLocal->copy()->setTimezone('UTC');
            $bufferedEndUtc = $endUtc->copy()->addMinutes(30);

            $overlap = CommonCalendar::where('TherapistUserID', $therapistId)
                ->where('ID', '!=', $slot->ID)
                ->where('SessionDateTimeFrom', '<', $bufferedEndUtc)
                ->whereRaw('DATE_ADD(SessionDateTimeTo, INTERVAL 30 MINUTE) > ?', [$startUtc->format('Y-m-d H:i:s')])
                ->lockForUpdate()
                ->exists();

            if ($overlap) {
                DB::rollBack();
                return response()->json(['error' => 'Updated times overlap an existing entry.'], 422);
            }

            $slot->update([
                'DateFrom' => $startUtc->toDateString(),
                'TimeFrom' => $startUtc->format('H:i:s'),
                'DateTo' => $endUtc->toDateString(),
                'TimeTo' => $endUtc->format('H:i:s'),
                'SessionDateTimeFrom' => $startUtc,
                'SessionDateTimeTo' => $endUtc,
                'TherapistTimeZone' => $timeZoneService->getUtcOffsetForTimezone($therapistTimeZone, $startUtc),
                // 'SessionType' => $validated['session_type'] ?? null,
            ]);

            DB::commit();
            return response()->json(['success' => true, 'slot' => $slot]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            DB::rollBack();
            return response()->json(['error' => 'Slot not found.'], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update slot: ' . $e->getMessage()], 500);
        }
    }

    // Delete slot (therapist's own). If Busy, you may block deletion depending on policy. Here: allow deletion only if Available or Blocked.
    public function destroy(Request $request, $id)
    {
        $therapistId = Auth::id();

        DB::beginTransaction();
        try {
            $slot = CommonCalendar::where('ID', $id)->where('TherapistUserID', $therapistId)->lockForUpdate()->firstOrFail();

            if (! in_array($slot->CalendarEntryType, ['Available', 'Blocked'])) {
                DB::rollBack();
                return response()->json(['error' => 'Cannot delete a booked slot.'], 403);
            }

            $slot->delete();
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex) {
            DB::rollBack();
            return response()->json(['error' => 'Slot not found.'], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to delete slot: ' . $e->getMessage()], 500);
        }
    }

    // --- Helper functions copied/adapted from your Patients controller ---
    private function getSlotsForWeek($therapistId, $selectedDate, $displayTimeZone)
    {
        $date = Carbon::parse($selectedDate, $displayTimeZone);

        // Start of the week (Monday)
        $monday = $date->copy()->startOfWeek(Carbon::MONDAY)->startOfDay();

        $weeklySlots = [];
        $weekDates = [];

        // Prepare the 7 days of the week
        for ($i = 0; $i < 7; $i++) {
            $d = $monday->copy()->addDays($i)->format('Y-m-d');
            $weeklySlots[$d] = [];
            $weekDates[] = $d;
        }

        $weekStartUtc = $monday->copy()->setTimezone('UTC');
        $weekEndUtc = $monday->copy()->addDays(6)->endOfDay()->setTimezone('UTC');

        // Fetch DB rows by UTC session datetime
        $rows = CommonCalendar::where('TherapistUserID', $therapistId)
            ->whereBetween('SessionDateTimeFrom', [$weekStartUtc, $weekEndUtc])
            ->orderBy('SessionDateTimeFrom')
            ->get();

        foreach ($rows as $row) {
            $startUtc = $row->SessionDateTimeFrom
                ? Carbon::parse($row->SessionDateTimeFrom, 'UTC')
                : Carbon::parse(trim($row->DateFrom) . ' ' . trim($row->TimeFrom), 'UTC');
            $endUtc = $row->SessionDateTimeTo
                ? Carbon::parse($row->SessionDateTimeTo, 'UTC')
                : Carbon::parse(trim($row->DateTo) . ' ' . trim($row->TimeTo), 'UTC');

            $start = $startUtc->copy()->setTimezone($displayTimeZone);
            $end = $endUtc->copy()->setTimezone($displayTimeZone);
            $dateFrom = $start->toDateString();
            $timeFrom = $start->format('H:i');

            if (!array_key_exists($dateFrom, $weeklySlots)) {
                continue;
            }

            $weeklySlots[$dateFrom][$timeFrom] = (object)[
                'id'              => $row->ID,
                'type'            => $row->CalendarEntryType,
                'start'           => $start->format('Y-m-d H:i:s'),
                'end'             => $end->format('Y-m-d H:i:s'),
                'date'            => $dateFrom,
                'time_from'       => $timeFrom,
                'time_to'         => $end->format('H:i'),
                // 'session_type'    => $row->SessionType,
                'patient_user_id' => $row->PatientUserID,
            ];
        }

        return [$weeklySlots, $weekDates];
    }

    private function resolveUserTimeZoneName(?User $user): string
    {
        return app(UserTimeZoneService::class)->getUserHomeTimezoneName($user);
    }

    private function isHalfHourSlot(string $time): bool
    {
        return preg_match('/^\d{2}:(00|30)$/', $time) === 1;
    }
}
