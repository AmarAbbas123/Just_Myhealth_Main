<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\UserTestEmail;
use Illuminate\Console\Command;

class SendUserTestEmail extends Command
{
    protected $signature = 'mail:send-user-test {userId : The target user ID} {--message= : Optional custom message body}';

    protected $description = 'Send a temporary test email to a user';

    public function handle(): int
    {
        $user = User::find($this->argument('userId'));

        if (!$user) {
            $this->error('User not found.');
            return self::FAILURE;
        }

        if (empty($user->Email)) {
            $this->error('User does not have an email address.');
            return self::FAILURE;
        }

        $user->notify(new UserTestEmail($this->option('message')));

        $this->info("Sent test email to {$user->UserName} <{$user->Email}>.");

        return self::SUCCESS;
    }
}