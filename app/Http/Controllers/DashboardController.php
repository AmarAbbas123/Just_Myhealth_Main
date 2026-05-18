<?php

namespace App\Http\Controllers;

use App\Models\CommonCalendar;
use App\Models\SysUserMessageHistory;
use App\Models\SysUserType30OnboardQuestionsAnswers;
use App\Models\User;
use App\Services\UserTimeZoneService;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $user->loadMissing(['userAttributes', 'type30']);

        $viewData = [
            'therapistWaitingSessions' => collect(),
            'therapistChats' => collect(),
            'patientUpcomingSessions' => collect(),
            'patientChats' => collect(),
        ];

        if ((int) $user->UserType === 30) {
            $viewData['therapistWaitingSessions'] = $this->getTherapistWaitingSessions($user);
            $viewData['therapistChats'] = $this->getTherapistChats($user);
        }

        if ((int) $user->UserType === 1) {
            $viewData['patientUpcomingSessions'] = $this->getPatientUpcomingSessions($user);
            $viewData['patientChats'] = $this->getPatientChats($user);
            $viewData['showPatientOnboardingJourney'] = $this->shouldShowPatientOnboardingJourney($user);
        }

        return view('modules.dashboard', $viewData);
    }

    private function getTherapistWaitingSessions(User $therapist): Collection
    {
        $start = Carbon::today();
        $end = Carbon::today()->addDays(14)->endOfDay();

        return CommonCalendar::query()
            ->where('TherapistUserID', $therapist->ID)
            ->where('CalendarEntryType', 'Busy')
            ->whereIn('SessionType', ['Video', 'Audio'])
            ->whereNotNull('SessionZegoCloudConnectID')
            ->whereBetween('SessionDateTimeFrom', [$start, $end])
            ->with(['patient.userAttributes', 'patient.type30'])
            ->orderBy('SessionDateTimeFrom')
            ->limit(3)
            ->get()
            ->map(function (CommonCalendar $session) {
                $patient = $session->patient;

                return [
                    'id' => $session->ID,
                    'title' => $patient?->UserName ?: 'Patient',
                    'subtitle' => trim(($session->SessionType ?: 'Session') . ' - ' . optional($session->SessionDateTimeFrom)->format('H:i')),
                    'person_name' => $this->displayName($patient, 'Patient'),
                    'date_time' => optional($session->SessionDateTimeFrom)->format('Y-m-d H:i'),
                    'avatar' => $this->avatarFor($patient),
                ];
            });
    }

    private function getPatientUpcomingSessions(User $patient): Collection
    {
        $patientTimeZone = app(UserTimeZoneService::class)->getUserHomeTimezoneName($patient);
        $startOfTodayUtc = Carbon::now($patientTimeZone)->startOfDay()->setTimezone('UTC');

        return CommonCalendar::query()
            ->where('PatientUserID', $patient->ID)
            ->where('SessionDateTimeFrom', '>=', $startOfTodayUtc)
            ->with(['therapist.userAttributes', 'therapist.type30'])
            ->orderBy('SessionDateTimeFrom')
            ->limit(3)
            ->get()
            ->map(function (CommonCalendar $session) use ($patientTimeZone) {
                $therapist = $session->therapist;
                $sessionStartLocal = Carbon::parse($session->SessionDateTimeFrom, 'UTC')->setTimezone($patientTimeZone);

                return [
                    'id' => $session->ID,
                    'title' => trim(($session->SessionType ?: 'Session') . ' Session'),
                    'subtitle' => trim(($therapist?->UserName ?: 'Therapist') . ' - ' . $sessionStartLocal->format('H:i')),
                    'person_name' => $this->displayName($therapist, 'Therapist'),
                    'date_time' => $sessionStartLocal->format('Y-m-d H:i'),
                    'avatar' => $this->avatarFor($therapist),
                ];
            });
    }

    private function getTherapistChats(User $therapist): Collection
    {
        $bookedPatientIds = CommonCalendar::query()
            ->where('TherapistUserID', $therapist->ID)
            ->where('CalendarEntryType', 'Busy')
            ->pluck('PatientUserID')
            ->filter()
            ->unique()
            ->values();

        $completedPatientIds = SysUserType30OnboardQuestionsAnswers::query()
            ->where('QuestionCompletionStatus', 1)
            ->pluck('PatientUserID');

        $patientIds = $bookedPatientIds->intersect($completedPatientIds)->values();

        if ($patientIds->isEmpty()) {
            return collect();
        }

        $patients = User::query()
            ->with(['userAttributes', 'type30'])
            ->where('UserType', 1)
            ->whereIn('ID', $patientIds)
            ->get();

        return $this->buildChatList($therapist, $patients, 1);
    }

    private function getPatientChats(User $patient): Collection
    {
        $bookedTherapistIds = CommonCalendar::query()
            ->where('PatientUserID', $patient->ID)
            ->where('CalendarEntryType', 'Busy')
            ->pluck('TherapistUserID')
            ->filter()
            ->unique()
            ->values();

        if ($bookedTherapistIds->isEmpty()) {
            return collect();
        }

        $therapists = User::query()
            ->with(['userAttributes', 'type30'])
            ->where('UserType', 30)
            ->whereIn('ID', $bookedTherapistIds)
            ->get();

        return $this->buildChatList($patient, $therapists, 30);
    }

    private function shouldShowPatientOnboardingJourney(User $patient): bool
    {
        if ((int) $patient->UserType !== 1) {
            return false;
        }

        return ! SysUserType30OnboardQuestionsAnswers::query()
            ->where('PatientUserID', $patient->ID)
            ->where('QuestionCompletionStatus', 1)
            ->exists();
    }

    private function buildChatList(User $currentUser, Collection $peers, int $peerType): Collection
    {
        $peerIds = $peers->pluck('ID')->map(fn ($id) => (int) $id)->values();

        $messages = SysUserMessageHistory::query()
            ->where(function ($query) use ($currentUser, $peerIds) {
                $query->where('FromUserID', $currentUser->ID)
                    ->whereIn('ToUserID', $peerIds);
            })
            ->orWhere(function ($query) use ($currentUser, $peerIds) {
                $query->whereIn('FromUserID', $peerIds)
                    ->where('ToUserID', $currentUser->ID);
            })
            ->orderBy('MessageDateTime')
            ->get();

        $messagesByPeer = $messages->groupBy(function (SysUserMessageHistory $message) use ($currentUser) {
            return $message->FromUserID === $currentUser->ID
                ? (int) $message->ToUserID
                : (int) $message->FromUserID;
        });

        return $peers
            ->map(function (User $peer) use ($messagesByPeer, $peerType, $currentUser) {
                $peerMessages = $messagesByPeer->get((int) $peer->ID, collect())
                    ->map(function (SysUserMessageHistory $message) use ($currentUser) {
                        return [
                            'id' => $message->ID,
                            'sender' => $message->FromUserID == $currentUser->ID
                                ? ((int) $currentUser->UserType === 1 ? 'patient' : 'therapist')
                                : ((int) $currentUser->UserType === 1 ? 'therapist' : 'patient'),
                            'text' => $message->MessageContent,
                            'time' => $message->MessageDateTime?->format('H:i') ?? '',
                        ];
                    })
                    ->values();

                $latestMessage = $messagesByPeer->get((int) $peer->ID)?->last();

                return [
                    'id' => (string) $peer->ID,
                    'name' => $this->displayName($peer, $peerType === 30 ? 'Therapist' : 'Patient'),
                    'avatar' => asset('images/avatar1.jfif'),
                    'lastMessage' => $latestMessage?->MessageContent ?: 'Start a new conversation',
                    'time' => $latestMessage?->MessageDateTime?->format('H:i') ?: '',
                    'dateTime' => $latestMessage?->MessageDateTime?->format('d M Y') ?: '',
                    'messages' => $peerMessages,
                    'toUserType' => $peerType,
                    'sort_at' => $latestMessage?->MessageDateTime?->timestamp ?: 0,
                ];
            })
            ->sortByDesc('sort_at')
            ->values()
            ->map(function (array $chat) {
                unset($chat['sort_at']);

                return $chat;
            });
    }

    private function displayName(?User $user, string $fallback): string
    {
        if (! $user) {
            return $fallback;
        }

        $fullName = trim(collect([
            $user->userAttributes->FirstName ?? null,
            $user->userAttributes->LastName ?? null,
        ])->filter()->implode(' '));

        return $fullName !== '' ? $fullName : ($user->UserName ?: $fallback);
    }

    private function avatarFor(?User $user): string
    {
        if (! $user) {
            return asset('images/avatar1.jfif');
        }

        if ((int) $user->UserType === 30 && ! empty($user->type30?->BioPhotoPath)) {
            return asset('storage/' . $user->type30->BioPhotoPath);
        }

        if (! empty($user->ProfilePhotoPath)) {
            return asset('storage/' . $user->ProfilePhotoPath);
        }

        return asset('images/avatar1.jfif');
    }
}
