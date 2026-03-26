<?php

namespace App\Console\Commands;

use App\Models\CommonCalendar;
use App\Models\SysSentAutoEmail;
use App\Notifications\TherapistSessionReminder;
use App\Notifications\UserSessionReminder;
use Illuminate\Console\Command;

class SendTherapistSessionReminderEmails extends Command
{
    protected $signature = 'sessions:send-therapist-reminders';

    protected $description = 'Send therapist email reminders 30 minutes before scheduled sessions';

    public function handle(): int
    {
        $windowStart = now('UTC')->addMinutes(29)->startOfMinute();
        $windowEnd = now('UTC')->addMinutes(30)->endOfMinute();

        $sessions = CommonCalendar::with([
            'therapist.userAttributes',
            'patient.userAttributes',
        ])
            ->where('CalendarEntryType', 'Busy')
            ->whereNotNull('PatientUserID')
            ->whereBetween('SessionDateTimeFrom', [$windowStart, $windowEnd])
            ->get();

        $sentCount = 0;

        foreach ($sessions as $session) {
            $therapist = $session->therapist;
            $patient = $session->patient;

            if (!$therapist || !$patient) {
                continue;
            }

            $patientDisplayName = trim(
                collect([
                    $patient->userAttributes->FirstName ?? null,
                    $patient->userAttributes->LastName ?? null,
                ])->filter()->implode(' ')
            );

            if ($patientDisplayName === '') {
                $patientDisplayName = $patient->UserName ?: 'Patient';
            }

            $therapistUserName = $therapist->UserName ?: 'Therapist';

            if (!empty($therapist->Email) && !$this->alreadySent($therapist->ID, '001', $session->ID)) {
                $therapist->notify(new TherapistSessionReminder($session, $patientDisplayName));
                $sentCount++;
            }

            if (!empty($patient->Email) && !$this->alreadySent($patient->ID, '002', $session->ID)) {
                $patient->notify(new UserSessionReminder($session, $therapistUserName));
                $sentCount++;
            }
        }

        $this->info("Sent {$sentCount} 30-minute session reminder email(s).");

        return self::SUCCESS;
    }

    protected function alreadySent(int $userId, string $emailSubRef, int $sessionId): bool
    {
        return SysSentAutoEmail::query()
            ->where('UserID', $userId)
            ->where('ModuleRef', 10)
            ->where('ModuleSubRef', 1)
            ->where('ModuleFull', '1001')
            ->where('EmailSubRef', $emailSubRef)
            ->where('EventNotes', 'like', '%session #' . $sessionId . '%')
            ->exists();
    }
}