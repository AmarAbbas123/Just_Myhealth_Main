<?php

namespace App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists;

use App\Http\Controllers\Controller;
use App\Models\CommonCalendar;
use App\Models\SysUserMessageHistory;
use App\Models\SysUserType30OnboardQuestionsAnswers;
use App\Models\User;
use Illuminate\Support\Str;

class MessagesController extends Controller
{
    public function messages()
    {
        $user = auth()->user();

        // Patient view (default)
        if (in_array((int) $user->UserType, [1,2], true)) {        
            // Get booked therapists for this patient
            $bookedTherapistIds = CommonCalendar::where('PatientUserID', $user->ID)
                ->where('CalendarEntryType', 'Busy')
                ->pluck('TherapistUserID')
                ->unique()
                ->values();

            // Also include any therapists that already have message history
            $incomingIds = SysUserMessageHistory::query()
                ->withoutGlobalScopes()
                ->where('ToUserID', $user->ID)
                ->pluck('FromUserID')
                ->filter(fn($id) => (int) $id > 0)
                ->unique();

            $outgoingIds = SysUserMessageHistory::query()
                ->withoutGlobalScopes()
                ->where('FromUserID', $user->ID)
                ->pluck('ToUserID')
                ->filter(fn($id) => (int) $id > 0)
                ->unique();

            $contactIds = $incomingIds
                ->merge($outgoingIds)
                ->unique()
                ->values();

            $finalTherapistIds = $bookedTherapistIds
                ->merge($contactIds)
                ->unique()
                ->values();

            $latestMessages = collect();
            if ($finalTherapistIds->isNotEmpty()) {
                $latestMessages = SysUserMessageHistory::query()
                    ->withoutGlobalScopes()
                    ->where(function ($q) use ($user, $finalTherapistIds) {
                        $q->where('FromUserID', $user->ID)
                            ->whereIn('ToUserID', $finalTherapistIds);
                    })->orWhere(function ($q) use ($user, $finalTherapistIds) {
                        $q->where('ToUserID', $user->ID)
                            ->whereIn('FromUserID', $finalTherapistIds);
                    })
                    ->orderByDesc('MessageDateTime')
                    ->get()
                    ->groupBy(function ($m) use ($user) {
                        return (string) ($m->FromUserID == $user->ID ? $m->ToUserID : $m->FromUserID);
                    })
                    ->map->first();
            }

            // Load only booked therapists
            $therapists = User::with('userAttributes')
                ->where('UserType', 30)
                ->whereIn('ID', $finalTherapistIds)
                ->get()
                ->map(function ($user) use ($latestMessages) {
                    $latest = $latestMessages->get((string) $user->ID);
                    return [
                        'id' => (string) $user->ID,
                        'name' => trim(
                            ($user->userAttributes->FirstName ?? '') . ' ' .
                                ($user->userAttributes->LastName ?? '')
                        ),
                        'userType' => 30,
                        'avatar' => asset('images/avatar1.jfif'),
                        'lastMessage' => $latest ? Str::limit($latest->MessageContent, 20) : 'Start a new conversation',
                        'lastMessageId' => $latest ? $latest->ID : null,
                        'time' => $latest ? $latest->MessageDateTime->format('H:i') : null,
                        'dateTime' => $latest ? $latest->MessageDateTime->format('d M Y') : null,
                        'lastTimestamp' => $latest ? $latest->MessageDateTime->toIso8601String() : null,
                        'messages' => [],
                        'unread' => 0,
                    ];
                })
                ->values();

            $patientData = [
                'id' => (string) $user->ID,
                'name' => trim(
                    ($user->userAttributes->FirstName ?? '') . ' ' .
                        ($user->userAttributes->LastName ?? '')
                ),
            ];

            return view('modules.mod-03.usr-my-messages', compact('therapists', 'patientData'));
        }

        // Admin view (UserType 90/91/99)
        if (in_array((int) $user->UserType, [90, 91, 99], true)) {
            $incomingIds = SysUserMessageHistory::query()
                ->withoutGlobalScopes()
                ->where('ToUserID', $user->ID)
                ->pluck('FromUserID')
                ->filter(fn($id) => (int) $id > 0)
                ->unique();

            $outgoingIds = SysUserMessageHistory::query()
                ->withoutGlobalScopes()
                ->where('FromUserID', $user->ID)
                ->pluck('ToUserID')
                ->filter(fn($id) => (int) $id > 0)
                ->unique();

            $contactIds = $incomingIds
                ->merge($outgoingIds)
                ->unique()
                ->values();

            $latestMessages = collect();
            if ($contactIds->isNotEmpty()) {
                $latestMessages = SysUserMessageHistory::query()
                    ->withoutGlobalScopes()
                    ->where(function ($q) use ($user, $contactIds) {
                        $q->where('FromUserID', $user->ID)
                            ->whereIn('ToUserID', $contactIds);
                    })->orWhere(function ($q) use ($user, $contactIds) {
                        $q->where('ToUserID', $user->ID)
                            ->whereIn('FromUserID', $contactIds);
                    })
                    ->orderByDesc('MessageDateTime')
                    ->get()
                    ->groupBy(function ($m) use ($user) {
                        return (string) ($m->FromUserID == $user->ID ? $m->ToUserID : $m->FromUserID);
                    })
                    ->map->first();
            }

            $therapists = User::with('userAttributes')
                ->whereIn('ID', $contactIds)
                ->select('ID', 'UserName', 'Email', 'UserType')
                ->get()
                ->map(function ($user) use ($latestMessages) {
                    $latest = $latestMessages->get((string) $user->ID);
                    $first = $user->userAttributes->FirstName ?? '';
                    $last = $user->userAttributes->LastName ?? '';
                    $name = trim($first . ' ' . $last);
                    if ($name === '') {
                        $name = $user->UserName ?? $user->Email ?? 'User';
                    }

                    return [
                        'id' => (string) $user->ID,
                        'name' => $name,
                        'userType' => (int) $user->UserType,
                        'avatar' => asset('images/avatar1.jfif'),
                        'lastMessage' => $latest ? Str::limit($latest->MessageContent, 20) : 'Start a new conversation',
                        'lastMessageId' => $latest ? $latest->ID : null,
                        'time' => $latest ? $latest->MessageDateTime->format('H:i') : null,
                        'dateTime' => $latest ? $latest->MessageDateTime->format('d M Y') : null,
                        'lastTimestamp' => $latest ? $latest->MessageDateTime->toIso8601String() : null,
                        'messages' => [],
                        'unread' => 0,
                    ];
                })
                ->values();

            $patientData = [
                'id' => (string) $user->ID,
                'name' => $user->UserName ?? $user->Email ?? 'Admin',
            ];

            return view('modules.mod-03.usr-my-messages', compact('therapists', 'patientData'));
        }

        // Therapist view (UserType 30)
        if ((int) $user->UserType === 30) {
            $therapist = $user;

            $incomingIds = SysUserMessageHistory::query()
                ->withoutGlobalScopes()
                ->where('ToUserID', $therapist->ID)
                ->pluck('FromUserID')
                ->filter(fn($id) => (int) $id > 0)
                ->unique()
                ->values();

            $outgoingIds = SysUserMessageHistory::query()
                ->withoutGlobalScopes()
                ->where('FromUserID', $therapist->ID)
                ->pluck('ToUserID')
                ->filter(fn($id) => (int) $id > 0)
                ->unique()
                ->values();

            $bookedPatientIds = CommonCalendar::where('TherapistUserID', $therapist->ID)
                ->where('CalendarEntryType', 'Busy')
                ->pluck('PatientUserID')
                ->unique()
                ->values();

            $completedPatientIds = SysUserType30OnboardQuestionsAnswers::where('QuestionCompletionStatus', 1)
                ->pluck('PatientUserID');

            $finalBookedPatientIds = $bookedPatientIds
                ->intersect($completedPatientIds)
                ->values();

            $contactIds = $incomingIds
                ->merge($outgoingIds)
                ->unique()
                ->values();

            $finalUserIds = $contactIds
                ->merge($finalBookedPatientIds)
                ->unique()
                ->values();

            $latestMessages = collect();
            if ($finalUserIds->isNotEmpty()) {
                $latestMessages = SysUserMessageHistory::query()
                    ->withoutGlobalScopes()
                    ->where(function ($q) use ($therapist, $finalUserIds) {
                        $q->where('FromUserID', $therapist->ID)
                            ->whereIn('ToUserID', $finalUserIds);
                    })->orWhere(function ($q) use ($therapist, $finalUserIds) {
                        $q->where('ToUserID', $therapist->ID)
                            ->whereIn('FromUserID', $finalUserIds);
                    })
                    ->orderByDesc('MessageDateTime')
                    ->get()
                    ->groupBy(function ($m) use ($therapist) {
                        return (string) ($m->FromUserID == $therapist->ID ? $m->ToUserID : $m->FromUserID);
                    })
                    ->map->first();
            }

            $patients = User::with('userAttributes')
                ->whereIn('ID', $finalUserIds)
                ->select('ID', 'UserName', 'Email', 'UserType')
                ->get()
                ->map(function ($user) use ($latestMessages) {
                    $firstName = $user->userAttributes->FirstName ?? '';
                    $lastName = $user->userAttributes->LastName ?? '';
                    $name = trim($firstName . ' ' . $lastName);
                    if ($name === '') {
                        $name = $user->UserName ?? $user->Email ?? 'User';
                    }

                    $latest = $latestMessages->get((string) $user->ID);

                    return [
                        'id' => (string) $user->ID,
                        'name' => $name,
                        'userType' => (int) $user->UserType,
                        'avatar' => asset('images/avatar1.jfif'),
                        'lastMessage' => $latest ? Str::limit($latest->MessageContent, 20) : 'Start a new conversation',
                        'lastMessageId' => $latest ? $latest->ID : null,
                        'time' => $latest ? $latest->MessageDateTime->format('H:i') : null,
                        'dateTime' => $latest ? $latest->MessageDateTime->format('d M Y') : null,
                        'lastTimestamp' => $latest ? $latest->MessageDateTime->toIso8601String() : null,
                        'messages' => [],
                        'unread' => 0,
                    ];
                })
                ->values();

            return view(
                'modules.mod-10.01-counselling.therapists.t-messages',
                compact('patients')
            );
        }

        abort(403);
    }
}
