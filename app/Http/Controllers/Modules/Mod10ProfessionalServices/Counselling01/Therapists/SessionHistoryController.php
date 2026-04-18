<?php

namespace App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\CommonCalendar;
use App\Models\SysUserType30SessionHistory;
use App\Models\User;

class SessionHistoryController extends Controller
{
    // Session History Display
    public function sessionHistory()
    {
        $sessions = SysUserType30SessionHistory::where('AllocatedTherapistUserID', auth()->id())
            ->whereNotNull('SessionEndedTime')
            ->with(['patient.userAttributes', 'therapist.userAttributes'])  // from indirect relations with SysUserAttribute Model via Users Model
            ->orderByDesc('SessionStartedDate')
            ->orderByDesc('SessionStartedTime')
            ->get();

        return view(
            'modules.mod-10.01-counselling.therapists.session-history',
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
                'id'        => $history?->ID,
                'therapist_notes'  => $history?->TherapistNotes,
                'session_note_resources' => collect([
                   $history?->SessionNotesResource1,
                   $history?->SessionNotesResource2,
                   $history?->SessionNotesResource3,
                   $history?->SessionNotesResource4,
                ])->filter()->values()->all(),
            ]
        ]);
    }


    public function getRecording($sessionId)
    {
        $session = SysUserType30SessionHistory::findOrFail($sessionId);

        if (!$session->LinkToSessionRecording) {
            abort(404);
        }

        $path = basename($session->LinkToSessionRecording);
        /** @var \Illuminate\Filesystem\AwsS3V3Adapter $disk */
        $disk = Storage::disk('s3');

        $client = $disk->getClient();

        $command = $client->getCommand('GetObject', [
            'Bucket' => config('filesystems.disks.s3.bucket'),
            'Key'    => $path,
            'ResponseContentType'        => 'video/mp4',
            'ResponseContentDisposition' => 'inline',
        ]);

        $request = $client->createPresignedRequest(
            $command,
            '+10 minutes'
        );

        return redirect((string) $request->getUri());
    }
}
