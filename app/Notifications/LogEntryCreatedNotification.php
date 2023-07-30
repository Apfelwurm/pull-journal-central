<?php

namespace App\Notifications;

use App\Enums\LogEntryClassEnum;
use App\Models\LogEntry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Wijourdil\NtfyNotificationChannel\Channels\NtfyChannel;
use Ntfy\Message;

class LogEntryCreatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public LogEntry $logEntry,)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        $array = [];
        if (
            $notifiable->notificationSetting->enable_notifications &&
            $notifiable->notificationSetting->enable_provider_ntfy &&
            $notifiable->notificationSetting->enable_log_entry_created_notification
        ) {
            array_push($array, NtfyChannel::class);
        }

        if (
            $notifiable->notificationSetting->enable_notifications &&
            $notifiable->notificationSetting->enable_provider_mail &&
            $notifiable->notificationSetting->enable_log_entry_created_notification
        ) {
            array_push($array, 'mail');
        }

        return $array;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $title = "Hello "
            . $notifiable->name
            . ", There is a new "
            . $this->logEntry->class->value
            . " Log from "
            . $this->logEntry->device->name
            . " with source "
            . $this->logEntry->source;

        return (new MailMessage)
            ->line($title)
            ->action('View full Log', config('app.url') . "/logEntries/" . $this->logEntry->id);
    }

    public function toNtfy(mixed $notifiable): Message
    {
        $title = "New "
            . $this->logEntry->class->value
            .  " Log from "
            . $this->logEntry->device->name
            . " with source "
            . $this->logEntry->source;

        $body = "Hello "
            . $notifiable->name
            . " .The full Log is viewable under "
            . config('app.url')
            . "/logEntries/"
            . $this->logEntry->id;

        $message = new Message();
        $message->topic($notifiable->notificationSetting->ntfy_channel_id);
        $message->title($title);
        $message->body($body);

        if ($this->logEntry->class === LogEntryClassEnum::SUCCESS) {
            $message->tags(['white_check_mark']);
        }
        if ($this->logEntry->class === LogEntryClassEnum::ERROR) {
            $message->tags(['x']);
        }
        if ($this->logEntry->class === LogEntryClassEnum::INFO) {
            $message->tags(['information_source']);
        }

        if ($this->logEntry->class === LogEntryClassEnum::WARNING) {
            $message->tags(['warning']);
        }


        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
