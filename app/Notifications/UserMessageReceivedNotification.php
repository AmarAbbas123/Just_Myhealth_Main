<?php

namespace App\Notifications;

use App\Models\SysUserMessageHistory;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class UserMessageReceivedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public SysUserMessageHistory $message,
        public string $therapistUserName
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $mail = (new MailMessage)
            ->subject('New In-System Message Received')
            ->greeting('Dear ' . ($notifiable->UserName ?? 'User'))
            ->line('You have received an in-system message from ' . $this->therapistUserName . '.');

        foreach ($this->messageLinesForEmail() as $line) {
            $mail->line($line);
        }

        return $mail
            ->line('Please login to view the full message.')
            ->line('Regards,')
            ->line('JustMy.Health System Automation');
    }

    public function auditSummary(object $notifiable): string
    {
        $userName = $notifiable->UserName ?? 'User';
        $messageId = $this->message->ID ?? 'N/A';

        return "User message notification sent for message #{$messageId} to {$userName} from {$this->therapistUserName}";
    }

    protected function messageLinesForEmail(): array
    {
        $content = $this->normalizedMessageContent();

        return collect(preg_split("/\R/", $content) ?: [])
            ->map(fn($line) => trim($line))
            ->filter(fn($line) => $line !== '')
            ->map(fn($line) => $this->emailLineWithLinks($line))
            ->values()
            ->all();
    }

    protected function normalizedMessageContent(): string
    {
        $content = (string) ($this->message->MessageContent ?? '');

        $content = preg_replace_callback(
            '/<a\s+[^>]*href=(["\'])(.*?)\1[^>]*>([\s\S]*?)<\/a>/i',
            function ($matches) {
                $label = trim(strip_tags($matches[3]));
                if ($label === '' || preg_match('/^Resource\s+\d+$/i', $label)) {
                    $label = $this->fileNameFromUrl($matches[2]);
                }

                return '[' . $label . '](' . $matches[2] . ')';
            },
            $content
        );
        $content = preg_replace('/<br\s*\/?>/i', "\n", $content);
        $content = preg_replace('/<\/(p|div)>/i', "\n", $content);
        $content = html_entity_decode(strip_tags($content), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $content = preg_replace("/[ \t]+\n/", "\n", $content);
        $content = preg_replace("/\n{3,}/", "\n\n", $content);

        return trim($content);
    }

    protected function emailLineWithLinks(string $line): string|HtmlString
    {
        $pattern = '/\[([^\]]+)\]\(((?:https?:\/\/|\/)[^)]+)\)/';

        if (!preg_match($pattern, $line)) {
            return $line;
        }

        $html = preg_replace_callback($pattern, function ($matches) {
            $label = trim($matches[1]) ?: $this->fileNameFromUrl($matches[2]);
            $url = str_starts_with($matches[2], '/') ? url($matches[2]) : $matches[2];

            return '<a href="' . e($url) . '">' . e($label) . '</a>';
        }, e($line));

        return new HtmlString($html);
    }

    protected function fileNameFromUrl(string $url): string
    {
        $path = parse_url($url, PHP_URL_PATH);

        return rawurldecode(basename((string) ($path ?: $url)));
    }
}
