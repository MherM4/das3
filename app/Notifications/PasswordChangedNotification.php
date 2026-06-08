<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordChangedNotification extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
    return (new \Illuminate\Notifications\Messages\MailMessage)
        ->subject(__('messages.pwd_change_subject'))
        ->line(__('messages.pwd_change_line1'))
        ->line(__('messages.pwd_change_line2'))
        ->action(__('messages.pwd_change_action'), url('/profile'))
        ->line(__('messages.pwd_change_thanks'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
