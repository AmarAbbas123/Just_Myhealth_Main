<?php

namespace App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Patients;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use App\Models\CommonCalendar;
use App\Models\SysUserType30SessionHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UsrTherapyHistoryController extends Controller
{

    public function index()
    {
        $sessions = SysUserType30SessionHistory::where('PatientUserID', auth()->id())
            ->whereNotNull('SessionEndedTime')
            ->with(['therapist.userAttributes'])  // from indirect relations with SysUserAttribute Model via Users Model
            ->orderByDesc('SessionStartedDate')
            ->orderByDesc('SessionStartedTime')
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

                return route('usr.therapy.history.resource.download', [
                    'history_id' => $history->ID,
                    'index' => $index + 1,
                ]);
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
                'therapist_notes'  => $history?->TherapistNotes,
                'session_note_resources' => $sessionResourceLinks,
            ]
        ]);
    }

    public function downloadSessionResource(int $history_id, int $index)
    {
        $history = SysUserType30SessionHistory::where('ID', $history_id)
            ->where('PatientUserID', auth()->id())
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
}
