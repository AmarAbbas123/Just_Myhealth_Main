<?php

namespace App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists\StoreChatMessageController;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Services\TherapistSessionStartNotificationToPatients;
use App\Models\CommonCalendar;
use App\Models\SysUserType30SessionHistory;
use App\Models\User;

class WaitingRoomController extends Controller
{
    // Waiting Room Display
    public function waitingRoom()
    {
        $start = Carbon::today();                // today 00:00:00
        $end   = Carbon::today()->addDays(14)->endOfDay(); // day 14 at 23:59:59

        $sessions = CommonCalendar::where('TherapistUserID', auth()->id())
            ->where('CalendarEntryType', 'Busy')
            ->whereIn('SessionType', ['Video', 'Audio'])
            ->whereNotNull('SessionZegoCloudConnectID')
            ->whereBetween('SessionDateTimeFrom', [$start, $end])
            ->with(['patient.userAttributes', 'therapist.userAttributes'])  // from indirect relations with SysUserAttribute Model via Users Model
            ->orderBy('SessionDateTimeFrom')
            ->get();

        // ✅ Safely extract ONE room ID from the collection
        $roomID = $sessions->first()?->SessionZegoCloudConnectID;

        return view(
            'modules.mod-10.01-counselling.therapists.waiting-room',
            compact('sessions', 'roomID')
        );
    }

    // When Therapists Entered Room / presence / waiting / Press Start etc
    public function therapistEnteredWaitingRoom(Request $request)
    {
        $request->validate([
            'calendar_id' => 'required|integer',
        ]);

        // ✅ Fetch calendar to read updated_at
        $calendar = CommonCalendar::findOrFail($request->calendar_id);        

        SysUserType30SessionHistory::updateOrCreate(
            ['SessionCalendarID' => $calendar->ID],
            [
                'AllocatedTherapistUserID' => auth()->id(),

                // Therapist entry time
                'TherapistEnteredWaitingRoomDate' => now()->toDateString(),
                'TherapistEnteredWaitingRoomTime' => now()->toTimeString(),

                // ✅ Copy EXACT booking timestamp
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

        $calendar = CommonCalendar::findOrFail($request->calendar_id);

        // 1️⃣ Create or update session history (START)
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


        // 2️⃣ Send system message WITH JOIN LINK
        $joinLink = url('/patient/join') . '?' . http_build_query([
            'room'    => $calendar->SessionZegoCloudConnectID . '-' . $calendar->ID,
            'session' => $calendar->ID, // SessionCalendarID
        ]);        

        $this->sendSystemMessage(
            $calendar->PatientUserID,
            'Your ' . $calendar->SessionType . ' session has started. Please join now: 
             <a href="' . $joinLink . '" target="_blank" class="text-blue-600 underline">
                Join Session
             </a>'
        );

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

        // ✅ Do not overwrite end time if already ended
        if (!$history->SessionEndedDate) {
            $history->update([
                'SessionEndedDate' => now()->toDateString(),
                'SessionEndedTime' => now()->toTimeString(),

                // Ensure these are always present
                'PatientUserID' => $history->PatientUserID,
                'AllocatedTherapistUserID' => auth()->id(),
            ]);
        }

        return response()->json(['success' => true]);
    }

    // Send Notificataion invitation link to Patients
    protected function sendSystemMessage($patientID, $message)
    {
        // Reuse your existing chat storage logic
        app(TherapistSessionStartNotificationToPatients::class)
            ->storeSystemMessage($patientID, $message);
    }
}
