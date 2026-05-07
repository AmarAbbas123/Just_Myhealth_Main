<?php

namespace App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Patients;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use App\Models\CommonCalendar;
use App\Models\SysUserMessageHistory;
use App\Models\SysUserType30SessionHistory;
use App\Services\UserTimeZoneService;
use Illuminate\Http\Request;

class PatientsCalendarController extends Controller
{
    private const PATIENT_SESSION_DISPLAY_MINUTES = 45;

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

            // JOIN URL
            $sessionStarted = SysUserType30SessionHistory::where('SessionCalendarID', $session->ID)
                ->where('AllocatedTherapistUserID', $session->TherapistUserID)
                ->whereNotNull('SessionStartedTime')
                ->exists();


            // JOIN URL
            $message = SysUserMessageHistory::where('ToUserID', $patientId)
                ->where('MessageContent', 'LIKE', '%/patient/join%')
                ->orderByDesc('MessageDateTime')
                ->first();

            $joinUrl = null;
            if ($message && preg_match('/href="([^"]+)"/', $message->MessageContent, $m)) {
                $joinUrl = $m[1];
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

                // 👇 NEW (required for countdown)
                'session_start_at' => $sessionStartLocal->toIso8601String(),
            ];
        });

        return response()->json($sessions);
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
}