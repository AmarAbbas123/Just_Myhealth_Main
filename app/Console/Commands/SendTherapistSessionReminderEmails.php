<?php

namespace App\Console\Commands;

use App\Models\CommonCalendar;
use App\Models\SysSentAutoEmail;
use App\Notifications\TherapistSessionReminder;
use App\Notifications\UserSessionReminder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class SendTherapistSessionReminderEmails extends Command
{
    protected $signature = 'sessions:send-therapist-reminders {--minutes=30 : Send reminder this many minutes before session start} {--grace=2 : Catch-up window in minutes to avoid missing late scheduler runs}';

    protected $description = 'Send therapist email reminders 30 minutes before scheduled sessions';

    public function handle(): int
    {
        $leadMinutes = max((int) $this->option('minutes'), 1);
        $graceMinutes = max((int) $this->option('grace'), 0);
        $nowUtc = now('UTC');
        $targetMinuteUtc = $nowUtc->copy()->addMinutes($leadMinutes);
        $windowStart = $targetMinuteUtc->copy()->subMinutes($graceMinutes)->startOfMinute();
        $windowEnd = $targetMinuteUtc->copy()->endOfMinute();

        $sessions = CommonCalendar::with([
            'therapist.userAttributes',
            'patient.userAttributes',
        ])
            ->where('CalendarEntryType', 'Busy')
            ->whereNotNull('PatientUserID')
            ->whereBetween('SessionDateTimeFrom', [$windowStart, $windowEnd])
            ->get();

        $matchedSessionIds = $sessions->pluck('ID')->values()->all();

        $this->line('Reminder scan:');
        $this->line(' - now UTC: ' . $nowUtc->toDateTimeString());
        $this->line(' - now PKT: ' . $nowUtc->copy()->setTimezone('Asia/Karachi')->toDateTimeString());
        $this->line(' - window UTC: ' . $windowStart->toDateTimeString() . ' -> ' . $windowEnd->toDateTimeString());
        $this->line(' - matched sessions: ' . (empty($matchedSessionIds) ? 'none' : implode(', ', $matchedSessionIds)));

        Log::info('Therapist reminder scan started', [
            'now_utc' => $nowUtc->toDateTimeString(),
            'now_pkt' => $nowUtc->copy()->setTimezone('Asia/Karachi')->toDateTimeString(),
            'lead_minutes' => $leadMinutes,
            'grace_minutes' => $graceMinutes,
            'window_start_utc' => $windowStart->toDateTimeString(),
            'window_end_utc' => $windowEnd->toDateTimeString(),
            'matched_sessions' => $matchedSessionIds,
        ]);

        $sentCount = 0;
        $failedCount = 0;

        foreach ($sessions as $session) {
            $therapist = $session->therapist;
            $patient = $session->patient;
            $sessionStartUtc = $session->SessionDateTimeFrom
                ? $session->SessionDateTimeFrom->copy()->setTimezone('UTC')->format('Y-m-d H:i:s')
                : 'N/A';

            if (!$therapist || !$patient) {
                Log::warning('Therapist reminder skipped: missing therapist or patient relation', [
                    'session_id' => $session->ID,
                    'session_start_utc' => $sessionStartUtc,
                    'has_therapist' => (bool) $therapist,
                    'has_patient' => (bool) $patient,
                ]);
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
            $therapistEmail = $therapist->routeNotificationForMail();
            $patientEmail = $patient->routeNotificationForMail();

            $therapistAlreadySent = $this->alreadySent($therapist->ID, '001', $session->ID, $sessionStartUtc);
            $patientAlreadySent = $this->alreadySent($patient->ID, '002', $session->ID, $sessionStartUtc);

            if (!empty($therapistEmail) && !$therapistAlreadySent) {
                try {
                    $therapist->notify(new TherapistSessionReminder($session, $patientDisplayName));
                    $sentCount++;

                    Log::info('Therapist reminder sent to therapist', [
                        'session_id' => $session->ID,
                        'user_id' => $therapist->ID,
                        'email' => $therapistEmail,
                        'session_start_utc' => $sessionStartUtc,
                    ]);
                } catch (Throwable $e) {
                    $failedCount++;
                    Log::error('Therapist reminder failed for therapist', [
                        'session_id' => $session->ID,
                        'user_id' => $therapist->ID,
                        'email' => $therapistEmail,
                        'session_start_utc' => $sessionStartUtc,
                        'error' => $e->getMessage(),
                    ]);
                }
            } else {
                Log::info('Therapist reminder skipped for therapist', [
                    'session_id' => $session->ID,
                    'user_id' => $therapist->ID,
                    'email' => $therapistEmail,
                    'session_start_utc' => $sessionStartUtc,
                    'reason' => empty($therapistEmail) ? 'empty_email' : 'already_sent',
                ]);
            }

            if (!empty($patientEmail) && !$patientAlreadySent) {
                try {
                    $patient->notify(new UserSessionReminder($session, $therapistUserName));
                    $sentCount++;

                    Log::info('Therapist reminder sent to patient', [
                        'session_id' => $session->ID,
                        'user_id' => $patient->ID,
                        'email' => $patientEmail,
                        'session_start_utc' => $sessionStartUtc,
                    ]);
                } catch (Throwable $e) {
                    $failedCount++;
                    Log::error('Therapist reminder failed for patient', [
                        'session_id' => $session->ID,
                        'user_id' => $patient->ID,
                        'email' => $patientEmail,
                        'session_start_utc' => $sessionStartUtc,
                        'error' => $e->getMessage(),
                    ]);
                }
            } else {
                Log::info('Therapist reminder skipped for patient', [
                    'session_id' => $session->ID,
                    'user_id' => $patient->ID,
                    'email' => $patientEmail,
                    'session_start_utc' => $sessionStartUtc,
                    'reason' => empty($patientEmail) ? 'empty_email' : 'already_sent',
                ]);
            }
        }

        Log::info('Therapist reminder scan completed', [
            'lead_minutes' => $leadMinutes,
            'grace_minutes' => $graceMinutes,
            'sent_count' => $sentCount,
            'failed_count' => $failedCount,
        ]);

        $this->info("Sent {$sentCount} {$leadMinutes}-minute session reminder email(s); failed {$failedCount}.");

        return self::SUCCESS;
    }

    protected function alreadySent(int $userId, string $emailSubRef, int $sessionId, string $sessionStartUtc): bool
    {
        return SysSentAutoEmail::query()
            ->where('UserID', $userId)
            ->where('ModuleRef', 10)
            ->where('ModuleSubRef', 1)
            ->where('ModuleFull', '1001')
            ->where('EmailSubRef', $emailSubRef)
            ->where('EventNotes', 'like', '%session #' . $sessionId . ' at ' . $sessionStartUtc . '%')
            ->exists();
    }
}
