<?php

namespace App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Therapists;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\CommonCalendar;
use App\Models\SysUserType30OnboardQuestionsAnswers;
use App\Models\SysUserMessageHistory;
use Illuminate\Support\Str;

class TherapistsMessagesController extends Controller
{
    public function messages()
    {
        $therapist = auth()->user();

        // ✅ Therapist-only access
        if ((int) $therapist->UserType !== 30) {
            abort(403);
        }

        // ✅ All incoming senders (patients, admins, system users) for this therapist
        $incomingIds = SysUserMessageHistory::query()
            ->withoutGlobalScopes()
            ->where('ToUserID', $therapist->ID)
            ->pluck('FromUserID')
            ->filter(fn ($id) => (int) $id > 0)
            ->unique()
            ->values();

        // ✅ All outgoing recipients for this therapist (to show chats even if no reply yet)
        $outgoingIds = SysUserMessageHistory::query()
            ->withoutGlobalScopes()
            ->where('FromUserID', $therapist->ID)
            ->pluck('ToUserID')
            ->filter(fn ($id) => (int) $id > 0)
            ->unique()
            ->values();

        // ✅ Keep existing booked-patient visibility as well
        $bookedPatientIds = CommonCalendar::where('TherapistUserID', $therapist->ID)
            ->where('CalendarEntryType', 'Busy')
            ->pluck('PatientUserID')
            ->unique()
            ->values();

        // ✅ Optional: require Q&A completion for booked patients only
        $completedPatientIds = SysUserType30OnboardQuestionsAnswers::where('QuestionCompletionStatus', 1)
            ->pluck('PatientUserID');

        $finalBookedPatientIds = $bookedPatientIds->intersect($completedPatientIds)->values();

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
}
