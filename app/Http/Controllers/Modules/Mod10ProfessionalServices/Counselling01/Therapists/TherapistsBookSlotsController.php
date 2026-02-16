<?php

namespace App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CommonCalendar;
use App\Models\User;
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
        $therapist = User::find($therapistId);

        $selectedDate = $request->query('date') ?? Carbon::now($therapist?->timezone ?? 'UTC')->toDateString();
        $viewMode = $request->query('view') ?? 'week';

        // Initial slots for the requested view (week)
        $weeklySlots = $this->getSlotsForWeek($therapistId, $selectedDate);

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
            $current->addHour();
        }

        list($weeklySlots, $weekDates) = $this->getSlotsForWeek($therapistId, $selectedDate);

        return view('modules.mod-10.01-counselling.therapists.therapists-book-slots', [
            'therapistCard' => $therapistCard,
            'selectedDate' => $selectedDate,
            'viewMode' => $viewMode,
            'timeRows' => $timeRows,
            'weeklySlots' => $weeklySlots,
            'weekDates' => $weekDates,
            'sessionTypes' => $sessionTypes,
        ]);
    }

    // JSON: slots for week (same structure as Patients controller expects)
    public function slots(Request $request)
    {
        $therapistId = Auth::id();
        $date = $request->query('date') ?? date('Y-m-d');
        $slots = $this->getSlotsForWeek($therapistId, $date);

        return response()->json(['date' => $date, 'slots' => $slots]);
    }

    // Create new slot (Available)
    public function store(Request $request)
    {
        $therapistId = Auth::id();

        $validated = $request->validate([
            'date' => 'required|date_format:Y-m-d',
            'time_from' => 'required|date_format:H:i',
            'time_to' => 'required|date_format:H:i|after:time_from',
            // 'session_type' => 'nullable|string|max:191',
        ]);

        $date = $validated['date'];
        $timeFrom = $validated['time_from'];
        $timeTo = $validated['time_to'];
        // $sessionType = $validated['session_type'] ?? null;

        DB::beginTransaction();
        try {
            // Lock any rows for this therapist that could overlap
            $overlap = CommonCalendar::where('TherapistUserID', $therapistId)
                ->whereRaw("TIMESTAMP(DateFrom, TimeFrom) < TIMESTAMP(?, ?)", [$date, $timeTo])
                ->whereRaw("TIMESTAMP(DateTo, TimeTo) > TIMESTAMP(?, ?)", [$date, $timeFrom])
                ->lockForUpdate()
                ->exists();

            if ($overlap) {
                DB::rollBack();
                return response()->json(['error' => 'The requested time overlaps an existing calendar entry.'], 422);
            }

            $startDT = Carbon::createFromFormat(
                'Y-m-d H:i',
                $date . ' ' . $timeFrom,
                auth()->user()?->timezone ?? 'UTC'
            );

            $endDT = Carbon::createFromFormat(
                'Y-m-d H:i',
                $date . ' ' . $timeTo,
                auth()->user()?->timezone ?? 'UTC'
            );

            $row = CommonCalendar::create([
                'TherapistUserID' => $therapistId,

                'CalendarEntryType' => 'Available',   // REQUIRED

                // 'SessionType' => in_array($sessionType, ['Video', 'Audio', 'Message']) ? $sessionType : null,

                'DateFrom' => $date,
                'TimeFrom' => $timeFrom . ':00',
                'DateTo'   => $date,
                'TimeTo'   => $timeTo . ':00',

                'SessionDateTimeFrom' => $startDT,
                'SessionDateTimeTo'   => $endDT,

                'TherapistTimeZone' => auth()->user()?->timezone ?? '+00:00',
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
            'time_to' => 'required|date_format:H:i|after:time_from',
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
            $timeTo = $validated['time_to'];

            $overlap = CommonCalendar::where('TherapistUserID', $therapistId)
                ->where('ID', '!=', $slot->ID)
                ->whereRaw("TIMESTAMP(DateFrom, TimeFrom) < TIMESTAMP(?, ?)", [$date, $timeTo])
                ->whereRaw("TIMESTAMP(DateTo, TimeTo) > TIMESTAMP(?, ?)", [$date, $timeFrom])
                ->lockForUpdate()
                ->exists();

            if ($overlap) {
                DB::rollBack();
                return response()->json(['error' => 'Updated times overlap an existing entry.'], 422);
            }

            $slot->update([
                'DateFrom' => $date,
                'TimeFrom' => $timeFrom . ':00',
                'DateTo' => $date,
                'TimeTo' => $timeTo . ':00',
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
    private function getSlotsForWeek($therapistId, $selectedDate)
    {
        $tz = auth()->user()?->timezone ?? 'UTC';
        $date = Carbon::parse($selectedDate, $tz);

        // Start of the week (Monday)
        $monday = $date->copy()->startOfWeek(Carbon::MONDAY);

        $weeklySlots = [];
        $weekDates = [];

        // Prepare the 7 days of the week
        for ($i = 0; $i < 7; $i++) {
            $d = $monday->copy()->addDays($i)->format('Y-m-d');
            $weeklySlots[$d] = [];
            $weekDates[] = $d;
        }

        // Fetch DB rows within the week
        $rows = CommonCalendar::where('TherapistUserID', $therapistId)
            ->whereBetween('DateFrom', [$weekDates[0], $weekDates[6]])
            ->orderBy('DateFrom')
            ->orderBy('TimeFrom')
            ->get();

        foreach ($rows as $row) {
            // Normalize DB date strings
            $dateFrom = substr(trim($row->DateFrom), 0, 10);
            $dateTo   = substr(trim($row->DateTo), 0, 10);

            // Normalize time strings to H:i
            $timeFrom = Carbon::parse($row->TimeFrom)->format('H:i');
            $timeTo   = Carbon::parse($row->TimeTo)->format('H:i');

            // Combine into full Carbon objects safely
            $start = Carbon::createFromFormat('Y-m-d H:i', "$dateFrom $timeFrom", $tz);
            $end   = Carbon::createFromFormat('Y-m-d H:i', "$dateTo $timeTo", $tz);

            $weeklySlots[$dateFrom][$timeFrom] = (object)[
                'id'              => $row->ID,
                'type'            => $row->CalendarEntryType,
                'start'           => $start->format('Y-m-d H:i:s'),
                'end'             => $end->format('Y-m-d H:i:s'),
                'date'            => $dateFrom,
                'time_from'       => $timeFrom,
                'time_to'         => $timeTo,
                // 'session_type'    => $row->SessionType,
                'patient_user_id' => $row->PatientUserID,
            ];
        }

        return [$weeklySlots, $weekDates];
    }
}
