<?php

namespace App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Patients;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use App\Models\CommonCalendar;
use App\Models\SysUserMessageHistory;
use App\Models\SysUserType30SessionHistory;
use App\Notifications\TherapistPatientEnteredWaitingRoomNotification;
use App\Services\UserTimeZoneService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class PatientsCalendarController extends Controller
{
    private const PATIENT_SESSION_DISPLAY_MINUTES = 50;
    private const WAITING_ROOM_LEAD_MINUTES = 15;

    public function index()
    {
        return view('modules.mod-10.01-counselling.patients.patients-session-calendar');
    }

    public function pollSessions()
    {
        $patientId = auth()->id();
        $patientTimeZone = app(UserTimeZoneService::class)->getUserHomeTimezoneName(auth()->user());
        $startOfTodayUtc = Carbon::now($patientTimeZone)->startOfDay()->setTimezone('UTC');

        $sessions = CommonCalendar::where('PatientUserID', $patientId)
            ->where('SessionDateTimeFrom', '>=', $startOfTodayUtc)
            //->whereNotNull('SessionZegoCloudConnectID')
            ->with(['therapist.userAttributes', 'therapist.type30'])
            ->orderBy('SessionDateTimeFrom')
            ->get();

        $sessions = $sessions->map(function ($session) use ($patientId, $patientTimeZone) {
            $sessionStartLocal = Carbon::parse($session->SessionDateTimeFrom, 'UTC')->setTimezone($patientTimeZone);
            $sessionEndLocal = Carbon::parse($session->SessionDateTimeTo, 'UTC')->setTimezone($patientTimeZone);

            $history = SysUserType30SessionHistory::where('SessionCalendarID', $session->ID)
                ->where('AllocatedTherapistUserID', $session->TherapistUserID)
                ->first();

            $sessionStarted = (bool) ($history?->SessionStartedTime);

            if (!$sessionStarted) {
                $sessionStarted = SysUserType30SessionHistory::where('SessionCalendarID', $session->ID)
                    ->whereNotNull('SessionStartedTime')
                    ->exists();
            }

            $joinUrl = null;

            if ($sessionStarted && $history?->SessionZegoCloudConnectID) {
                $joinUrl = route('patient.audiovideo.join', [
                    'room' => $history->SessionZegoCloudConnectID,
                    'session' => $session->ID,
                ]);
            }

            if (!$joinUrl) {
                $message = SysUserMessageHistory::where('ToUserID', $patientId)
                    ->where('MessageContent', 'LIKE', '%/patient/join%')
                    ->orderByDesc('MessageDateTime')
                    ->first();

                if ($message && preg_match('/href="([^"]+)"/', $message->MessageContent, $m)) {
                    $joinUrl = $m[1];
                }
            }

            // THERAPY ARRAY
            $therapies = [];
            for ($i = 1; $i <= 5; $i++) {
                $type  = optional($session->therapist->type30)->{"TherapyType{$i}"};
                $years = optional($session->therapist->type30)->{"TherapyYearsExperience{$i}"};

                if ($type) {
                    $therapies[] = [
                        'name'  => $type,
                        'years' => $years,
                        'url'   => url('/therapy/' . str_replace(' ', '', $type)),
                    ];
                }
            }

            // QUALIFICATIONS ARRAY
            $qualifications = [];
            for ($i = 1; $i <= 4; $i++) {
                $title = optional($session->therapist->type30)->{"QualificationTitle{$i}"};

                if ($title) {
                    $qualifications[] = [
                        'title' => $title,
                        'from'  => optional($session->therapist->type30)->{"QualificationFrom{$i}"},
                        'level' => optional($session->therapist->type30)->{"QualificationLevel{$i}"},
                    ];
                }
            }



            return [
                'id'       => $session->ID,

                // SESSION
                'media'     => $session->SessionType,
                'date'      => $sessionStartLocal->format('Y-m-d'),
                'start'     => $sessionStartLocal->format('H:i'),
                'end'       => $sessionEndLocal->format('H:i'),
                'duration'  => self::PATIENT_SESSION_DISPLAY_MINUTES,

                // THERAPIST
                'therapist_name' =>
                trim(optional($session->therapist->userAttributes)->FirstName . ' ' .
                    optional($session->therapist->userAttributes)->LastName),

                'city'      => optional($session->therapist->userAttributes)->BaseCity,
                'country'   => optional($session->therapist->userAttributes)->BaseCountry,
                'salutation' => optional($session->therapist->userAttributes)->PreferredSalutation,
                'languageprimary'  => optional($session->therapist->userAttributes)->LanguagePrimary,
                'languagesecondary'  => optional($session->therapist->userAttributes)->LanguageSecondary,

                'bio_photo' => optional($session->therapist->type30)->BioPhotoPath,

                // ARRAYS
                'therapies'      => $therapies,
                'qualifications' => $qualifications,

                // FLAGS
                'session_started' => $sessionStarted,

                // JOIN
                'join_url' => $joinUrl,
                'waiting_room_url' => route('patient.calendar.waitingRoom', ['session' => $session->ID]),
                'enter_waiting_room_url' => route('patient.calendar.enterWaitingRoom', ['calendar' => $session->ID]),
                'can_enter_waiting_room' => now($patientTimeZone)->gte(
                    $sessionStartLocal->copy()->subMinutes(self::WAITING_ROOM_LEAD_MINUTES)
                ),
                'waiting_room_entered' => (bool) ($history?->PatientEnteredWaitingRoomDate && $history?->PatientEnteredWaitingRoomTime),

                // 👇 NEW (required for countdown)
                'session_start_at' => $sessionStartLocal->toIso8601String(),
            ];
        });

        return response()->json($sessions);
    }

    public function enterWaitingRoom(Request $request, CommonCalendar $calendar)
    {
        abort_if((int) $calendar->PatientUserID !== (int) auth()->id(), 403);

        $patientTimeZone = app(UserTimeZoneService::class)->getUserHomeTimezoneName(auth()->user());
        $sessionStartLocal = Carbon::parse($calendar->SessionDateTimeFrom, 'UTC')->setTimezone($patientTimeZone);

        if (now($patientTimeZone)->lt($sessionStartLocal->copy()->subMinutes(self::WAITING_ROOM_LEAD_MINUTES))) {
            return back()->withErrors([
                'waiting_room' => 'The waiting room opens 15 minutes before your scheduled session.',
            ]);
        }

        $history = SysUserType30SessionHistory::firstOrNew([
            'SessionCalendarID' => $calendar->ID,
        ]);

        $enteredAlready = $history->PatientEnteredWaitingRoomDate && $history->PatientEnteredWaitingRoomTime;

        $history->fill([
            'PatientUserID' => auth()->id(),
            'AllocatedTherapistUserID' => $calendar->TherapistUserID,
            'SessionBookedDate' => optional($calendar->updated_at)->toDateString() ?? now()->toDateString(),
            'SessionMediaType' => $calendar->SessionType,
            'SessionZegoCloudConnectID' => $history->SessionZegoCloudConnectID ?: $calendar->SessionZegoCloudConnectID,
        ]);

        if (!$enteredAlready) {
            $history->PatientEnteredWaitingRoomDate = now()->toDateString();
            $history->PatientEnteredWaitingRoomTime = now()->toTimeString();
        }

        $history->save();

        if (!$enteredAlready) {
            $this->notifyTherapistPatientEnteredWaitingRoom($calendar);
        }

        return redirect()->route('patient.calendar.waitingRoom', ['session' => $calendar->ID]);
    }

    public function waitingRoom(Request $request)
    {
        $calendarId = (int) $request->query('session');
        $patientId = auth()->id();
        $patientTimeZone = app(UserTimeZoneService::class)->getUserHomeTimezoneName(auth()->user());

        $calendarQuery = CommonCalendar::where('PatientUserID', $patientId)
            ->where('SessionDateTimeFrom', '>=', Carbon::now($patientTimeZone)->startOfDay()->setTimezone('UTC'))
            ->with(['therapist.userAttributes', 'therapist.type30'])
            ->orderBy('SessionDateTimeFrom');

        if ($calendarId > 0) {
            $calendarQuery->where('ID', $calendarId);
        }

        $calendar = $calendarQuery->firstOrFail();

        $history = SysUserType30SessionHistory::where('SessionCalendarID', $calendar->ID)->first();
        $sessionStartLocal = Carbon::parse($calendar->SessionDateTimeFrom, 'UTC')->setTimezone($patientTimeZone);
        $sessionEndLocal = Carbon::parse($calendar->SessionDateTimeTo, 'UTC')->setTimezone($patientTimeZone);

        $therapistName = trim(collect([
            optional($calendar->therapist->userAttributes)->FirstName,
            optional($calendar->therapist->userAttributes)->LastName,
        ])->filter()->implode(' ')) ?: ($calendar->therapist->UserName ?? 'Therapist');

        $session = [
            'id' => $calendar->ID,
            'media' => $calendar->SessionType,
            'date' => $sessionStartLocal->format('Y-m-d'),
            'start' => $sessionStartLocal->format('H:i'),
            'end' => $sessionEndLocal->format('H:i'),
            'duration' => self::PATIENT_SESSION_DISPLAY_MINUTES,
            'therapist_name' => $therapistName,
            'city' => optional($calendar->therapist->userAttributes)->BaseCity,
            'country' => optional($calendar->therapist->userAttributes)->BaseCountry,
            'bio_photo' => optional($calendar->therapist->type30)->BioPhotoPath,
            'therapist_user_attributes' => $calendar->therapist->userAttributes,
            'therapist_type30' => $calendar->therapist->type30,
            'session_started' => (bool) ($history?->SessionStartedTime),
            'join_url' => $history?->SessionStartedTime && $history?->SessionZegoCloudConnectID
                ? route('patient.audiovideo.join', [
                    'room' => $history->SessionZegoCloudConnectID,
                    'session' => $calendar->ID,
                ])
                : null,
        ];

        return view('modules.mod-10.01-counselling.patients.patients-session-waiting-room', compact('session'));
    }

    // Edit button, Message to Audio or Video etc
    public function updateSessionType(Request $request, CommonCalendar $calendar)
    {
        abort_if($calendar->PatientUserID !== auth()->id(), 403);

        $request->validate([
            'SessionType' => 'required|in:Video,Audio,Message'
        ]);

        $calendar->update([
            'SessionType' => $request->SessionType
        ]);

        // ✅ RETURN JSON (not redirect)
        return response()->json([
            'success' => true,
            'message' => 'Session type updated.',
        ]);
    }

    // delete button , Busy to Available
    public function cancelSession(CommonCalendar $calendar)
    {
        abort_if($calendar->PatientUserID !== auth()->id(), 403);

        $calendar->update([
            'CalendarEntryType' => 'Available'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Session cancelled.',
        ]);
    }

    protected function notifyTherapistPatientEnteredWaitingRoom(CommonCalendar $calendar): void
    {
        $calendar->loadMissing(['patient.userAttributes', 'therapist']);

        $patient = $calendar->patient;
        $therapist = $calendar->therapist;

        if (!$patient || !$therapist) {
            return;
        }

        $patientDisplayName = trim(collect([
            optional($patient->userAttributes)->FirstName,
            optional($patient->userAttributes)->LastName,
        ])->filter()->implode(' ')) ?: ($patient->UserName ?: 'Patient');

        SysUserMessageHistory::create([
            'FromUserID' => $patient->ID,
            'FromUserType' => (int) $patient->UserType,
            'ToUserID' => $therapist->ID,
            'ToUserType' => 30,
            'MessageDateTime' => now(),
            'MessageContent' => $patientDisplayName . ' has entered the session waiting room for session #' . $calendar->ID . '.',
        ]);

        if (empty($therapist->routeNotificationForMail())) {
            return;
        }

        try {
            $therapist->notify(new TherapistPatientEnteredWaitingRoomNotification($calendar, $patientDisplayName));
        } catch (Throwable $e) {
            Log::error('Failed to notify therapist that patient entered waiting room', [
                'session_id' => $calendar->ID,
                'therapist_id' => $therapist->ID,
                'patient_id' => $patient->ID,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
