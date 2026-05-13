<?php

namespace App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Services\TherapistSessionStartNotificationToPatients;
use App\Services\UserMessageService;
use App\Models\CommonCalendar;
use App\Models\SysSentAutoEmail;
use App\Models\SysUserType30SessionHistory;
use App\Models\User;
use App\Models\SysUserType30OnboardQuestions;
use App\Models\SysUserType30OnboardQuestionsAnswers;
use App\Notifications\UserSessionStartedNotification;
use App\Services\UserTimeZoneService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class WaitingRoomController extends Controller
{
    // Waiting Room Display
    public function waitingRoom()
    {
        $therapistTimeZone = app(UserTimeZoneService::class)->getUserHomeTimezoneName(auth()->user());
        $start = Carbon::now($therapistTimeZone)->startOfDay()->setTimezone('UTC');
        $end = Carbon::now($therapistTimeZone)->addDays(14)->endOfDay()->setTimezone('UTC');

        $sessions = CommonCalendar::where('TherapistUserID', auth()->id())
            ->where('CalendarEntryType', 'Busy')
            ->whereIn('SessionType', ['Video', 'Audio'])
            ->whereNotNull('SessionZegoCloudConnectID')
            ->whereBetween('SessionDateTimeFrom', [$start, $end])
            ->with(['patient.userAttributes', 'therapist.userAttributes'])
            ->orderBy('SessionDateTimeFrom')
            ->get();

        $sessions->each(function ($session) use ($therapistTimeZone) {
            $session->DisplaySessionDateTimeFrom = Carbon::parse($session->SessionDateTimeFrom, 'UTC')
                ->setTimezone($therapistTimeZone);
        });

        $roomID = $sessions->first()?->SessionZegoCloudConnectID;
        $sessionNoteResources = $this->therapistDocumentsForNotes();

        return view(
            'modules.mod-10.01-counselling.therapists.waiting-room',
            compact('sessions', 'roomID', 'therapistTimeZone', 'sessionNoteResources')
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
        'calendar_id'          => 'required|integer',
        'screen_width'         => 'required|integer',
        'physical_screen_width'=> 'required|integer',
        'is_phone_device'      => 'required|boolean',
        'device_platform'      => 'nullable|string|max:100',
    ]);

        
        $minimumScreenWidth = 768;

    // Block if UA says phone OR physical screen is too small
    // physical_screen_width cannot be faked by "Desktop View" mode
    if (
        $request->boolean('is_phone_device') ||
        (int) $request->physical_screen_width < $minimumScreenWidth
    ) {
        return response()->json([
            'success' => false,
            'message' => 'Therapists can only start sessions from a tablet, laptop, or desktop. Phone devices are not permitted.',
        ], 403);
    }

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
            'calendar_id' => (int) $request->calendar_id,
            'therapist_notes' => $history->TherapistNotes,
            'selected_resources' => $this->existingSessionNoteResources($history),
            'notes_url' => route('therapist.session.notes.edit', ['calendar_id' => $request->calendar_id]),
            // Do not pass saved=1 here: the embedded view posts session-notes-saved on load when
            // saved=1 is present, which would immediately close the parent waiting-room modal.
            'embedded_notes_url' => route('therapist.session.notes.edit', [
                'calendar_id' => $request->calendar_id,
                'embedded' => 1,
            ]),
        ]);
    }

    public function editSessionNotes(Request $request, int $calendar_id)
    {
        // Keep flash for one request when returning from save (?saved=1) so embedded notes can
        // show the banner and notify the parent; clear stale success on normal opens.
        if (! $request->boolean('saved')) {
            session()->forget('session_notes_success');
        }

        $history = SysUserType30SessionHistory::where('SessionCalendarID', $calendar_id)
            ->where('AllocatedTherapistUserID', auth()->id())
            ->firstOrFail();

        $sessionNoteResources = $this->therapistDocumentsForNotes();
        $selectedResources = $this->existingSessionNoteResources($history);
        $embedded = $request->boolean('embedded');

        return view(
            $embedded
                ? 'modules.mod-10.01-counselling.therapists.partials.post-session-notes-embedded'
                : 'modules.mod-10.01-counselling.therapists.partials.post-session-notes',
            compact('history', 'calendar_id', 'sessionNoteResources', 'selectedResources', 'embedded')
        );
    }

    /**
     * Save post-session therapist notes (max 2048 chars)
     */
    public function saveSessionNotes(Request $request)
    {
        Log::info('saveSessionNotes', [
            'auth_id' => auth()->id(),
            'request_data' => $request->all(),
        ]);

        $request->validate([
            'calendar_id' => 'required|integer',
            'therapist_notes' => 'nullable|string|max:2048',
            'selected_resources' => 'nullable|array|max:4',
            'selected_resources.*' => 'string|max:512',
        ]);

        Log::info('saveSessionNotes:request', [
            'auth_id' => auth()->id(),
            'calendar_id' => $request->input('calendar_id'),
            'notes_length' => strlen((string) $request->input('therapist_notes', '')),
            'selected_resources_in' => $request->input('selected_resources', []),
        ]);

        $history = SysUserType30SessionHistory::where('SessionCalendarID', $request->calendar_id)->first();

        if (!$history) {
            Log::warning('saveSessionNotes:not_found', [
                'auth_id' => auth()->id(),
                'calendar_id' => $request->input('calendar_id'),
            ]);
            $payload = [
                'success' => false,
                'message' => 'Session history not found',
            ];

            if ($request->expectsJson()) {
                return response()->json($payload, 404);
            }

            return redirect()
                ->to($this->sessionNotesRedirectTarget($request))
                ->with('session_notes_error', $payload['message']);
        }

        if (!empty($history->AllocatedTherapistUserID) && (int) $history->AllocatedTherapistUserID !== (int) auth()->id()) {
            Log::warning('saveSessionNotes:unauthorized', [
                'auth_id' => auth()->id(),
                'history_id' => $history->ID,
                'history_therapist_id' => $history->AllocatedTherapistUserID,
            ]);
            $payload = [
                'success' => false,
                'message' => 'Unauthorized session history access',
            ];

            if ($request->expectsJson()) {
                return response()->json($payload, 403);
            }

            return redirect()
                ->to($this->sessionNotesRedirectTarget($request))
                ->with('session_notes_error', $payload['message']);
        }

        if (empty($history->AllocatedTherapistUserID)) {
            $history->AllocatedTherapistUserID = auth()->id();
        }

        if (empty($history->PatientUserID)) {
            $history->PatientUserID = CommonCalendar::whereKey($history->SessionCalendarID)->value('PatientUserID');
        }

        $allowedResourcesByPath = collect($this->therapistDocumentsForNotes())->keyBy('path');

        $selectedResources = collect($request->input('selected_resources', []))
            ->map(fn($value) => is_string($value) ? $this->normalizeSessionResourcePath($value) : null)
            ->filter(fn($path) => is_string($path) && isset($allowedResourcesByPath[$path]))
            ->unique()
            ->values()
            ->take(4)
            ->map(fn($path) => $allowedResourcesByPath[$path]['url'])
            ->all();

        $history->TherapistNotes = $request->input('therapist_notes');

        foreach ($this->sessionNoteResourceColumns() as $index => $column) {
            $history->{$column} = $selectedResources[$index] ?? null;
        }

        $history->save();

        $notesMessage = $this->buildSessionNotesMessage(
            $history->TherapistNotes,
            $this->existingSessionNoteResources($history),
            (int) $history->ID
        );

        if (!empty($history->PatientUserID) && trim(strip_tags($notesMessage)) !== '') {
            app(UserMessageService::class)->send(
                auth()->user(),
                (int) $history->PatientUserID,
                1,
                $notesMessage
            );
        }

        Log::info('saveSessionNotes:saved', [
            'auth_id' => auth()->id(),
            'history_id' => $history->ID,
            'calendar_id' => $history->SessionCalendarID,
            'saved_note' => $history->TherapistNotes,
            'saved_resources' => $this->existingSessionNoteResources($history),
        ]);

        $payload = [
            'success' => true,
            'history_id' => $history->ID,
            'selected_resources' => $selectedResources,
        ];

        if ($request->expectsJson()) {
            return response()->json($payload);
        }

        return redirect()
            ->to($this->sessionNotesRedirectTarget($request))
            ->with('session_notes_success', 'Session notes saved.')
            ->with('session_notes_history_id', $history->ID);
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

        // Some older uploads are nested as common/{id}/{folder}/file; hide the numeric id.
        if (count($segments) > 1 && ctype_digit($segments[0])) {
            array_shift($segments);
        }

        return count($segments) ? implode(' / ', $segments) : 'Root';
    }

    protected function existingSessionNoteResources(SysUserType30SessionHistory $history): array
    {
        return collect($this->sessionNoteResourceColumns())
            ->map(fn($column) => $history->{$column})
            ->filter()
            ->values()
            ->all();
    }

    protected function buildSessionNotesMessage(?string $notes, array $resources, int $historyId): string
    {
        $parts = [
            'Post session notes are available.',
        ];

        $notes = trim((string) $notes);
        if ($notes !== '') {
            $parts[] = "Session Notes:\n" . $notes;
        }

        if (!empty($resources)) {
            $links = collect($resources)
                ->filter(fn($url) => is_string($url) && trim($url) !== '')
                ->map(function ($url, $index) use ($historyId) {
                    $label = $this->sessionResourceFileName($url) ?: 'Resource ' . ($index + 1);
                    $downloadUrl = route('usr.therapy.history.resource.download', [
                        'history_id' => $historyId,
                        'index' => $index + 1,
                    ]);

                    return '- [' . $label . '](' . $downloadUrl . ')';
                })
                ->implode("\n");

            if ($links !== '') {
                $parts[] = "Support Resources:\n" . $links;
            }
        }

        return implode("\n\n", $parts);
    }

    protected function sessionResourceFileName(string $url): string
    {
        $path = parse_url($url, PHP_URL_PATH);
        $fileName = basename((string) ($path ?: $url));

        return rawurldecode($fileName);
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

    protected function sessionNoteResourceColumns(): array
    {
        $table = 'sys_user_type_30_session_history';

        if (Schema::hasColumn($table, 'SessionNotesResources1')) {
            return [
                'SessionNotesResources1',
                'SessionNotesResources2',
                'SessionNotesResources3',
                'SessionNotesResources4',
            ];
        }

        return [
            'SessionNotesResource1',
            'SessionNotesResource2',
            'SessionNotesResource3',
            'SessionNotesResource4',
        ];
    }

    protected function sessionNotesRedirectTarget(Request $request): string
    {
        $returnTo = $request->input('return_to');

        if (is_string($returnTo) && str_starts_with($returnTo, url('/'))) {
            return $returnTo;
        }

        if ($request->filled('calendar_id')) {
            return route('therapist.session.notes.edit', ['calendar_id' => $request->input('calendar_id')]);
        }

        return route('therap.waiting.room');
    }
}
