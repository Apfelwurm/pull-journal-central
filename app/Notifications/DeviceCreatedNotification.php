<?php

namespace App\Notifications;

use App\Enums\LogEntryClassEnum;
use App\Models\Device;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Wijourdil\NtfyNotificationChannel\Channels\NtfyChannel;
use Ntfy\Message;

class DeviceCreatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Device $device,)
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
        if ($notifiable->notificationSetting->enable_notifications &&
            $notifiable->notificationSetting->enable_provider_ntfy &&
            $notifiable->notificationSetting->enable_device_created_notification)
        {
            array_push($array, NtfyChannel::class);
        }

        if ($notifiable->notificationSetting->enable_notifications &&
            $notifiable->notificationSetting->enable_provider_mail &&
            $notifiable->notificationSetting->enable_device_created_notification)
        {
            array_push($array ,'mail');
        }

        return $array;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $title = "Hello " . $notifiable->name  .", a new Device with the name " . $this->device->name ." has registered";
        return (new MailMessage)
                    ->line($title)
                    ->action('View devices', config('app.url') . "/devices/");
    }

    public function toNtfy(mixed $notifiable): Message
    {
        $title = "New device registered with the name " . $this->device->name;
        $body = "Hello " . $notifiable->name  .", a new Device with the name " . $this->device->name ." has registered. To verify the device, see". config('app.url') . "/devices/";
        $message = new Message();
        $message->topic($notifiable->notificationSetting->ntfy_channel_id);
        $message->title($title);
        $message->body($body);

        $message->tags(['computer']);

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
