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

        $history = SysUserType30SessionHistory::where('ID', $request->calendar_id)
            ->where('AllocatedTherapistUserID', auth()->id())
            ->first();

        $sessionResourceColumns = [
            $history?->SessionNotesResources1 ?? $history?->SessionNotesResource1,
            $history?->SessionNotesResources2 ?? $history?->SessionNotesResource2,
            $history?->SessionNotesResources3 ?? $history?->SessionNotesResource3,
            $history?->SessionNotesResources4 ?? $history?->SessionNotesResource4,
        ];

        $sessionResourceLinks = collect($sessionResourceColumns)
            ->values()
            ->map(function ($value, $index) use ($history) {
                if (!$value || !$history) {
                    return null;
                }

                $path = $this->normalizeSessionResourcePath((string) $value);
                $name = $path ? basename($path) : ('Resource ' . ($index + 1));

                return [
                    'url' => route('therap.session.history.resource.download', [
                        'history_id' => $history->ID,
                        'index' => $index + 1,
                    ]),
                    'name' => $name,
                ];
            })
            ->filter()
            ->values()
            ->all();

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
                'session_note_resources' => $sessionResourceLinks,
            ]
        ]);
    }


    public function downloadSessionResource(int $history_id, int $index)
{
    $history = SysUserType30SessionHistory::where('ID', $history_id)
        ->where('AllocatedTherapistUserID', auth()->id())
        ->firstOrFail();

    $resourceMap = [
        1 => $history->SessionNotesResources1 ?? $history->SessionNotesResource1,
        2 => $history->SessionNotesResources2 ?? $history->SessionNotesResource2,
        3 => $history->SessionNotesResources3 ?? $history->SessionNotesResource3,
        4 => $history->SessionNotesResources4 ?? $history->SessionNotesResource4,
    ];

    if (!isset($resourceMap[$index]) || empty($resourceMap[$index])) {
        abort(404);
    }

    $path = $this->normalizeSessionResourcePath((string) $resourceMap[$index]);

    if (!$path || !Storage::disk('therapy_docs')->exists($path)) {
        abort(404);
    }

    return Storage::disk('therapy_docs')->download($path, basename($path));
}

    protected function normalizeSessionResourcePath(string $value): ?string
{
    $value = trim($value);
    if ($value === '') {
        return null;
    }

    $parsedPath = parse_url($value, PHP_URL_PATH);
    $pathValue = is_string($parsedPath) && $parsedPath !== '' ? $parsedPath : $value;

    $prefix = '/storage/therapy-documents/';
    if (str_starts_with($pathValue, $prefix)) {
        $pathValue = substr($pathValue, strlen($prefix));
    }

    $pathValue = ltrim($pathValue, '/');
    if ($pathValue === '') {
        return null;
    }

    return collect(explode('/', $pathValue))
        ->map(fn($segment) => rawurldecode($segment))
        ->implode('/');
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
