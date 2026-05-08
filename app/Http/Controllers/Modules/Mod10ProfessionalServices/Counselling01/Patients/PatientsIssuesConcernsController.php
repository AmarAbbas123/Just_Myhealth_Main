<?php

namespace App\Http\Controllers\Modules\Mod10ProfessionalServices\Counselling01\Patients;

use App\Http\Controllers\Controller;
use App\Models\SysUserIssuesOption;
use App\Models\SysUserIssuesRaised;
use App\Models\SysUserMessageHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class PatientsIssuesConcernsController extends Controller
{
    public function index()
    {
        $userType = (int) auth()->user()->UserType;

        $categories = SysUserIssuesOption::query()
            ->visibleForUserType($userType)
            ->where('ParentID', 0)
            ->orderBy('DisplayName')
            ->get();

        $subCategories = SysUserIssuesOption::query()
            ->visibleForUserType($userType)
            ->where('ParentID', '>', 0)
            ->orderBy('DisplayName')
            ->get()
            ->groupBy('ParentID')
            ->map(fn ($items) => $items->values());

        return view(
            'modules.mod-10.01-counselling.patients.patients-issues-concerns',
            compact('categories', 'subCategories')
        );
    }

    public function showDetails(Request $request)
    {
        $user = auth()->user();
        $userType = (int) $user->UserType;

        $validated = $request->validate([
            'primary_group_ref' => ['required', 'integer'],
            'secondary_group_ref' => ['required', 'integer'],
            'issue_details' => ['required', 'string', 'max:2048'],
        ]);

        $category = SysUserIssuesOption::query()
            ->visibleForUserType($userType)
            ->where('ParentID', 0)
            ->where('ID', $validated['primary_group_ref'])
            ->first();

        $subCategory = SysUserIssuesOption::query()
            ->visibleForUserType($userType)
            ->where('ParentID', $validated['primary_group_ref'])
            ->where('ID', $validated['secondary_group_ref'])
            ->first();

        if (!$category || !$subCategory) {
            throw ValidationException::withMessages([
                'secondary_group_ref' => 'Please choose a valid concern area and sub-category.',
            ]);
        }

        $recipient = $this->resolveMessageRecipient($subCategory->SendMessageToUser ?: $category->SendMessageToUser);
        $emailAddress = $subCategory->SendEmailAddress ?: $category->SendEmailAddress;
        $messageContent = $this->buildIssueMessage($user, $category, $subCategory, $validated['issue_details']);

        DB::transaction(function () use ($user, $userType, $category, $subCategory, $validated, $recipient, $messageContent) {
            SysUserIssuesRaised::create([
                'PatientUserID' => $user->ID,
                'DateRaised' => now()->toDateString(),
                'TimeRaised' => now()->toTimeString(),
                'UserType' => $userType,
                'PrimaryGroupRef' => $category->ID,
                'SecondaryGroupRef' => $subCategory->ID,
                'IssueConcernEnteredText' => $validated['issue_details'],
                'IssueStatus' => 'New',
            ]);

            if ($recipient) {
                SysUserMessageHistory::create([
                    'FromUserID' => $user->ID,
                    'FromUserType' => $userType,
                    'ToUserID' => $recipient->ID,
                    'ToUserType' => (int) $recipient->UserType,
                    'MessageDateTime' => now(),
                    'MessageContent' => $messageContent,
                ]);
            }
        });

        if ($emailAddress) {
            $this->sendIssueEmail($emailAddress, $messageContent);
        }

        return redirect()
            ->route('usr-raise-issue')
            ->with('success', 'Your issue or concern has been submitted. The support team will review it and respond as soon as possible.');
    }

    protected function resolveMessageRecipient(?string $sendMessageToUser): ?User
    {
        $sendMessageToUser = trim((string) $sendMessageToUser);

        if ($sendMessageToUser === '') {
            return null;
        }

        return User::query()
            ->when(
                is_numeric($sendMessageToUser),
                fn ($query) => $query->where('ID', (int) $sendMessageToUser),
                fn ($query) => $query->where('UserName', $sendMessageToUser)
            )
            ->first();
    }

    protected function buildIssueMessage(User $user, SysUserIssuesOption $category, SysUserIssuesOption $subCategory, string $details): string
    {
        $lines = [
            'A user has raised a new issue or concern.',
            '',
            'User ID: ' . $user->ID,
            'Username: ' . ($user->UserName ?: 'Not provided'),
            'Email: ' . ($user->Email ?: 'Not provided'),
            'General Concern Area: ' . $category->DisplayName,
            'Specific Sub-Category: ' . $subCategory->DisplayName,
            '',
            'Details:',
            $details,
        ];

        return implode("\n", $lines);
    }

    protected function sendIssueEmail(string $emailAddress, string $messageContent): void
    {
        try {
            Mail::raw($messageContent, function ($message) use ($emailAddress) {
                $message->to($emailAddress)
                    ->subject('New user issue or concern raised');
            });
        } catch (\Throwable $e) {
            Log::error('Failed to send issue/concern email.', [
                'email' => $emailAddress,
                'error' => $e->getMessage(),
            ]);
        }
    }

}
