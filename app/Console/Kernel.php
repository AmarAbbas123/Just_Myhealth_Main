<?php

namespace App\Console;

use App\Console\Commands\SendTherapistSessionReminderEmails;
use App\Console\Commands\SendUserTestEmail;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by the application.
     *
     * @var array<int, class-string>
     */
    protected $commands = [
        SendTherapistSessionReminderEmails::class,
        SendUserTestEmail::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('sessions:send-therapist-reminders')->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}