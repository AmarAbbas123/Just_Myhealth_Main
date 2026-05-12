<?php

namespace App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
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

        $sessionNoteResources = $this->therapistDocumentsForNotes();

        return view(
            'modules.mod-10.01-counselling.therapists.session-history',
            compact('sessions', 'sessionNoteResources')
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

        if ($history) {
            $this->nullifyMissingResources($history);
        }    

        $sessionResourceColumns = [
            $history?->SessionNotesResources1 ?? $history?->SessionNotesResource1,
            $history?->SessionNotesResources2 ?? $history?->SessionNotesResource2,
            $history?->SessionNotesResources3 ?? $history?->SessionNotesResource3,
            $history?->SessionNotesResources4 ?? $history?->SessionNotesResource4,
            $history?->SessionNotesResource5 ?? $history?->SessionNotesResource5,
            $history?->SessionNotesResource6 ?? $history?->SessionNotesResource6,
            $history?->SessionNotesResource7 ?? $history?->SessionNotesResource7,
            $history?->SessionNotesResource8 ?? $history?->SessionNotesResource8,
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
                    'name' => basename($name),
                    'index' => $index + 1,
                    'path' => $path,
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
        5 => $history->SessionNotesResources5 ?? $history->SessionNotesResource5,
        6 => $history->SessionNotesResources6 ?? $history->SessionNotesResource6,
        7 => $history->SessionNotesResources7 ?? $history->SessionNotesResource7,
        8 => $history->SessionNotesResources8 ?? $history->SessionNotesResource8,
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


    public function updateSessionNotes(Request $request)
{
    $request->validate([
        'history_id'           => 'required|integer',
        'therapist_notes'      => 'nullable|string',
        'selected_resources'   => 'nullable|array|max:8',
        'selected_resources.*' => 'string|max:512',
    ]);

    $history = SysUserType30SessionHistory::where('ID', $request->history_id)
        ->where('AllocatedTherapistUserID', auth()->id())
        ->firstOrFail();

    $history->TherapistNotes = $request->therapist_notes;

    $allowedResourcesByPath = collect($this->therapistDocumentsForNotes())->keyBy('path');

    $selectedResources = collect($request->input('selected_resources', []))
        ->map(fn($value) => is_string($value) ? $this->normalizeSessionResourcePath($value) : null)
        ->filter(fn($path) => is_string($path) && isset($allowedResourcesByPath[$path]))
        ->unique()
        ->values()
        ->take(8)
        ->map(fn($path) => $allowedResourcesByPath[$path]['url'])
        ->all();

    foreach ($this->sessionNoteResourceColumns() as $index => $column) {
        $history->{$column} = $selectedResources[$index] ?? null;
    }

    $history->save();

    return response()->json(['success' => true]);
}

public function removeSessionResource(Request $request)
{
    $request->validate([
        'history_id' => 'required|integer',
        'index'      => 'required|integer|between:1,8',
    ]);

    $history = SysUserType30SessionHistory::where('ID', $request->history_id)
        ->where('AllocatedTherapistUserID', auth()->id())
        ->firstOrFail();

    $colMap = $this->sessionNoteResourceColumns();

    $col   = $colMap[$request->index - 1];
    $value = $history->$col;

    if (empty($value)) {
        return response()->json(['success' => false, 'message' => 'Resource not found'], 404);
    }

    $history->$col = null;
    $history->save();

    return response()->json(['success' => true]);
}

protected function therapistDocumentsForNotes(): array
{
    $disk = Storage::disk('therapy_docs');
    $files = [];

    foreach ($disk->allFiles('common') as $path) {
        $folder = $this->therapyDocumentFolderLabel($path, 'common');
        $files[] = [
            'name' => $this->therapyDocumentDisplayName($path, 'common'),
            'path' => $path,
            'type' => 'common',
            'folder' => $folder,
            'folder_key' => 'common::' . $folder,
            'url' => $this->therapyDocumentPublicUrl($path),
        ];
    }

    foreach ($disk->allFiles('private/' . auth()->id()) as $path) {
        $folder = $this->therapyDocumentFolderLabel($path, 'private/' . auth()->id());
        $files[] = [
            'name' => $this->therapyDocumentDisplayName($path, 'private/' . auth()->id()),
            'path' => $path,
            'type' => 'private',
            'folder' => $folder,
            'folder_key' => 'private::' . $folder,
            'url' => $this->therapyDocumentPublicUrl($path),
        ];
    }

    usort($files, function ($a, $b) {
        return [$a['type'], $a['folder'], $a['name']] <=> [$b['type'], $b['folder'], $b['name']];
    });

    return $files;
}

protected function therapyDocumentPublicUrl(string $path): string
{
    $encoded = collect(explode('/', trim($path, '/')))
        ->map(fn($segment) => rawurlencode($segment))
        ->implode('/');

    return asset('storage/therapy-documents/' . $encoded);
}

protected function therapyDocumentDisplayName(string $path, string $prefix): string
{
    $prefix = trim($prefix, '/');
    $path = trim($path, '/');

    if (str_starts_with($path, $prefix . '/')) {
        return substr($path, strlen($prefix) + 1);
    }

    return basename($path);
}

protected function therapyDocumentFolderLabel(string $path, string $prefix): string
{
    $prefix = trim($prefix, '/');
    $path = trim($path, '/');

    if (!str_starts_with($path, $prefix . '/')) {
        return 'Root';
    }

    $relativePath = substr($path, strlen($prefix) + 1);
    $folderPath = trim(dirname($relativePath), '/.');

    if ($folderPath === '') {
        return 'Root';
    }

    $segments = array_values(array_filter(explode('/', $folderPath), fn($segment) => $segment !== ''));

    if (count($segments) > 1 && ctype_digit($segments[0])) {
        array_shift($segments);
    }

    return count($segments) ? implode(' / ', $segments) : 'Root';
}

protected function sessionNoteResourceColumns(): array
{
    $table = 'sys_user_type_30_session_history';

    if (Schema::hasColumn($table, 'SessionNotesResources1')) {
        return [
            'SessionNotesResources1',
            'SessionNotesResources2',
            'SessionNotesResources3',
            'SessionNotesResources4',
            'SessionNotesResources5',
            'SessionNotesResources6',
            'SessionNotesResources7',
            'SessionNotesResources8',
        ];
    }

    return [
        'SessionNotesResource1',
        'SessionNotesResource2',
        'SessionNotesResource3',
        'SessionNotesResource4',
        'SessionNotesResource5',
        'SessionNotesResource6',
        'SessionNotesResource7',
        'SessionNotesResource8',
    ];
}

//make sure the the files exists for the non null columns values
protected function nullifyMissingResources(SysUserType30SessionHistory $history): void
{
    $columns = [
        'SessionNotesResource1',
        'SessionNotesResource2',
        'SessionNotesResource3',
        'SessionNotesResource4',
        'SessionNotesResource5',
        'SessionNotesResource6',
        'SessionNotesResource7',
        'SessionNotesResource8',
    ];

    $changed = false;

    foreach ($columns as $col) {
        if (empty($history->$col)) {
            continue;
        }

        $path = $this->normalizeSessionResourcePath((string) $history->$col);

        if (!$path || !Storage::disk('therapy_docs')->exists($path)) {
            $history->$col = null;
            $changed = true;
        }
    }

    if ($changed) {
        $history->save();
    }
}


}
