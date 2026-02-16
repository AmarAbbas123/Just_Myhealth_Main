<?php

namespace App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Patients;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use App\Models\CommonCalendar;
use App\Models\SysUserType30SessionHistory;
use Illuminate\Http\Request;

class UsrTherapyHistoryController extends Controller
{

    public function index()
    {
        $sessions = SysUserType30SessionHistory::where('PatientUserID', auth()->id())
            ->whereNotNull('SessionEndedTime')
            ->with(['therapist.userAttributes'])  // from indirect relations with SysUserAttribute Model via Users Model
            ->orderBy('SessionStartedDate')
            ->get();

        return view(
            'modules.mod-10.01-counselling.patients.usr-therapy-history',
            compact('sessions')
        );
    }

    // View Sesssion Details in POPUP
    public function showDetails(Request $request)
    {
        $request->validate([
            'calendar_id' => 'required|integer',
        ]);

        $history = SysUserType30SessionHistory::where(
            'ID',
            $request->calendar_id
        )->first();

        return response()->json([
            'success' => true,
            'data' => [

                'media_type' => $history?->SessionMediaType,

                // Date of Session
                'session_started_date' => $history?->SessionStartedDate ? Carbon::parse($history->SessionStartedDate)->format('Y-m-d') : null,

                // Session lifecycle  Duration               
                'session_started_time' => $history?->SessionStartedTime,
                'session_ended_time'   => $history?->SessionEndedTime,

                // Meta                
                'recording'  => $history?->LinkToSessionRecording,
                'therapist_notes'  => $history?->TherapistNotes,
            ]
        ]);
    }
}
