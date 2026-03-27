<?php

namespace App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists\StoreChatMessageController;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Services\TherapistSessionStartNotificationToPatients;
use App\Models\CommonCalendar;
use App\Models\SysSentAutoEmail;
use App\Models\SysUserType30SessionHistory;
use App\Models\User;
use App\Models\SysUserType30OnboardQuestions;
use App\Models\SysUserType30OnboardQuestionsAnswers;
use App\Notifications\UserSessionStartedNotification;

class WaitingRoomController extends Controller
{
    // Waiting Room Display
    public function waitingRoom()
    {
        $start = Carbon::today();
        $end   = Carbon::today()->addDays(14)->endOfDay();

        $sessions = CommonCalendar::where('TherapistUserID', auth()->id())
            ->where('CalendarEntryType', 'Busy')
            ->whereIn('SessionType', ['Video', 'Audio'])
            ->whereNotNull('SessionZegoCloudConnectID')
            ->whereBetween('SessionDateTimeFrom', [$start, $end])
            ->with(['patient.userAttributes', 'therapist.userAttributes'])
            ->orderBy('SessionDateTimeFrom')
            ->get();

        $roomID = $sessions->first()?->SessionZegoCloudConnectID;

        return view(
            'modules.mod-10.01-counselling.therapists.waiting-room',
            compact('sessions', 'roomID')
        );
    }

    public function therapistEnteredWaitingRoom(Request $request)
    {
        $request->validate([
            'calendar_id' => 'required|integer',
        ]);

        $calendar = CommonCalendar::findOrFail($request->calendar_id);

        SysUserType30SessionHistory::updateOrCreate(
            ['SessionCalendarID' => $calendar->ID],
            [
                'AllocatedTherapistUserID' => auth()->id(),
                'TherapistEnteredWaitingRoomDate' => now()->toDateString(),
                'TherapistEnteredWaitingRoomTime' => now()->toTimeString(),
                'SessionBookedDate' => $calendar->updated_at->toDateString(),
            ]
        );

        return response()->json(['success' => true]);
    }

    // Video/Audio Session Started
    public function start(Request $request)
    {
        $request->validate([
            'calendar_id' => 'required|integer',
        ]);

        $calendar = CommonCalendar::with(['patient', 'therapist'])->findOrFail($request->calendar_id);

        SysUserType30SessionHistory::updateOrCreate(
            ['SessionCalendarID' => $calendar->ID],
            [
                'AllocatedTherapistUserID' => auth()->id(),
                'PatientUserID' => $calendar->PatientUserID,
                'SessionStartedDate' => now()->toDateString(),
                'SessionStartedTime' => now()->toTimeString(),
                'SessionMediaType' => $calendar->SessionType,
                'SessionZegoCloudConnectID' => $calendar->SessionZegoCloudConnectID . '-' . $calendar->ID,
            ]
        );

        $joinLink = url('/patient/join') . '?' . http_build_query([
            'room'    => $calendar->SessionZegoCloudConnectID . '-' . $calendar->ID,
            'session' => $calendar->ID,
        ]);

        $this->sendSystemMessage(
            $calendar->PatientUserID,
            'Your ' . $calendar->SessionType . ' session has started. Please join now: 
             <a href="' . $joinLink . '" target="_blank" class="text-blue-600 underline">
                Join Session
             </a>'
        );

        $patient = $calendar->patient;
        $therapist = $calendar->therapist;  

        if ($patient && $therapist && !empty($patient->Email) && !$this->sessionStartEmailAlreadySent($patient->ID, $calendar->ID)) {
            $patient->notify(new UserSessionStartedNotification($calendar, $therapist->UserName ?: 'Therapist'));
        }

        return response()->json([
            'success' => true,
            'roomID' => $calendar->SessionZegoCloudConnectID . '-' . $calendar->ID,
            'sessionType' => $calendar->SessionType,
        ]);
    }

    // Video/Audio Session Ended
    public function end(Request $request)
    {
        $request->validate([
            'calendar_id' => 'required|integer',
        ]);

        $history = SysUserType30SessionHistory::where(
            'SessionCalendarID',
            $request->calendar_id
        )->first();

        if (!$history) {
            return response()->json([
                'success' => false,
                'message' => 'Session history not found'
            ], 404);
        }

        if (!$history->SessionEndedDate) {
            $history->update([
                'SessionEndedDate' => now()->toDateString(),
                'SessionEndedTime' => now()->toTimeString(),
                'PatientUserID' => $history->PatientUserID,
                'AllocatedTherapistUserID' => auth()->id(),
            ]);
        }

        return response()->json([
            'success' => true,
            'history_id' => $history->ID,
            'therapist_notes' => $history->TherapistNotes,
        ]);
    }

    /**
     * Save post-session therapist notes (max 2048 chars)
     */
    public function saveSessionNotes(Request $request)
    {
        $request->validate([
            'calendar_id' => 'required|integer',
            'therapist_notes' => 'nullable|string|max:2048',
        ]);

        $history = SysUserType30SessionHistory::where('SessionCalendarID', $request->calendar_id)
            ->where('AllocatedTherapistUserID', auth()->id())
            ->first();

        if (!$history) {
            return response()->json([
                'success' => false,
                'message' => 'Session history not found',
            ], 404);
        }

        $history->TherapistNotes = $request->input('therapist_notes');
        $history->save();

        return response()->json([
            'success' => true,
            'history_id' => $history->ID,
        ]);
    }

    /**
     * Fetch onboarding Q&A for a patient (Questions 1-39).
     */
    public function onboardingQa(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|integer',
        ]);

        $patientId = (int) $request->patient_id;

        $allowed = CommonCalendar::where('TherapistUserID', auth()->id())
            ->where('PatientUserID', $patientId)
            ->where('CalendarEntryType', 'Busy')
            ->whereIn('SessionType', ['Video', 'Audio'])
            ->whereNotNull('SessionZegoCloudConnectID')
            ->exists();

        if (! $allowed) {
            abort(403, 'Unauthorized access');
        }

        $answers = SysUserType30OnboardQuestionsAnswers::where('PatientUserID', $patientId)->first();

        $questions = SysUserType30OnboardQuestions::query()
            ->whereBetween('ID', [1, 39])
            ->orderBy('ID')
            ->get(['ID', 'QuestionHeading']);

        $qa = $questions->map(function ($q) use ($answers) {
            $col = "Id{$q->ID}_Answer_text";
            return [
                'id' => (int) $q->ID,
                'question' => $q->QuestionHeading,
                'answer' => $answers?->$col,
            ];
        })->values();

        return response()->json([
            'success' => true,
            'data' => $qa,
        ]);
    }

    /**
     * Fetch the patient "Summary of Issue" (Question 40).
     */
    public function onboardingIssueSummary(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|integer',
        ]);

        $patientId = (int) $request->patient_id;

        $allowed = CommonCalendar::where('TherapistUserID', auth()->id())
            ->where('PatientUserID', $patientId)
            ->where('CalendarEntryType', 'Busy')
            ->whereIn('SessionType', ['Video', 'Audio'])
            ->whereNotNull('SessionZegoCloudConnectID')
            ->exists();

        if (! $allowed) {
            abort(403, 'Unauthorized access');
        }

        $answers = SysUserType30OnboardQuestionsAnswers::where('PatientUserID', $patientId)->first();

        return response()->json([
            'success' => true,
            'data' => [
                'issue_summary' => $answers?->Id40_Answer_text,
            ],
        ]);
    }

    protected function sendSystemMessage($patientID, $message)
    {
        app(TherapistSessionStartNotificationToPatients::class)
            ->storeSystemMessage($patientID, $message);
    }

    protected function sessionStartEmailAlreadySent(int $userId, int $sessionId): bool
    {
        return SysSentAutoEmail::query()
            ->where('UserID', $userId)
            ->where('ModuleRef', 10)
            ->where('ModuleSubRef', 1)
            ->where('ModuleFull', '1001')
            ->where('EmailSubRef', '003')
            ->where('EventNotes', 'like', '%session #' . $sessionId . '%')
            ->exists();
    }
}