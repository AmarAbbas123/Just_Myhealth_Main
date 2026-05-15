<?php

namespace App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SysUserType30SessionHistory;

class SessionHistoryByClientsController extends Controller
{
    public function sessionHistoryclients(Request $request)
    {
        $sessions = SysUserType30SessionHistory::where('AllocatedTherapistUserID', auth()->id())
            ->whereNotNull('PatientUserID')
            ->with('patient.userAttributes')
            ->orderByDesc('SessionStartedDate')
            ->orderByDesc('SessionStartedTime')
            ->orderByDesc('SessionBookedDate')
            ->get();

        $clients = $sessions
            ->unique('PatientUserID')
            ->values();

        return view(
            'modules.mod-10.01-counselling.therapists.history.session_history_clients',
            compact('clients')
        );
    }

    public function sessionHistoryClientDates(Request $request)
    {
        $clientId = $request->integer('client_id');
        $client = $this->clientForTherapist($clientId);

        $sessions = $this->sessionsForClient($clientId)->get();

        return view(
            'modules.mod-10.01-counselling.therapists.history.session_history_user_dates',
            compact('client', 'sessions')
        );
    }

    public function sessionHistoryClientNotes(Request $request)
    {
        $clientId = $request->integer('client_id');
        $client = $this->clientForTherapist($clientId);

        $sessions = $this->sessionsForClient($clientId)
            ->get()
            ->map(function (SysUserType30SessionHistory $session) {
                $session->session_resource_links = $this->sessionResourceLinks($session);

                return $session;
            });

        return view(
            'modules.mod-10.01-counselling.therapists.history.session_history_user_notes',
            compact('client', 'sessions')
        );
    }

    protected function clientForTherapist(int $clientId)
    {
        abort_if($clientId <= 0, 404);

        $session = SysUserType30SessionHistory::where('AllocatedTherapistUserID', auth()->id())
            ->where('PatientUserID', $clientId)
            ->with('patient.userAttributes')
            ->firstOrFail();

        return $session->patient;
    }

    protected function sessionsForClient(int $clientId)
    {
        abort_if($clientId <= 0, 404);

        return SysUserType30SessionHistory::where('AllocatedTherapistUserID', auth()->id())
            ->where('PatientUserID', $clientId)
            ->orderByDesc('SessionStartedDate')
            ->orderByDesc('SessionStartedTime')
            ->orderByDesc('SessionBookedDate');
    }

    protected function sessionResourceLinks(SysUserType30SessionHistory $session): array
    {
        $columns = [
            $session->SessionNotesResources1 ?? $session->SessionNotesResource1,
            $session->SessionNotesResources2 ?? $session->SessionNotesResource2,
            $session->SessionNotesResources3 ?? $session->SessionNotesResource3,
            $session->SessionNotesResources4 ?? $session->SessionNotesResource4,
            $session->SessionNotesResource5,
            $session->SessionNotesResource6,
            $session->SessionNotesResource7,
            $session->SessionNotesResource8,
        ];

        return collect($columns)
            ->values()
            ->map(function ($value, $index) use ($session) {
                if (!$value) {
                    return null;
                }

                $path = $this->normalizeSessionResourcePath((string) $value);

                return [
                    'url' => route('therap.session.history.resource.download', [
                        'history_id' => $session->ID,
                        'index' => $index + 1,
                    ]),
                    'name' => $path ? basename($path) : 'Resource ' . ($index + 1),
                ];
            })
            ->filter()
            ->values()
            ->all();
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
            ->map(fn ($segment) => rawurldecode($segment))
            ->implode('/');
    }

}
