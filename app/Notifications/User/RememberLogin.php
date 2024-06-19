<?php

namespace App\Notifications\User;

use App\Models\Auth\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RememberLogin extends Notification
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(User $notifiable): MailMessage
    {
        $mail = new MailMessage();

        $mail->subject(trans('mail.remember_login.subject'));

        $mail->greeting(trans('mail.remember_login.greeting', ['name' => $notifiable->name]));

        $mail->line(trans('mail.remember_login.line1'));

        $mail->line(trans('mail.remember_login.line2'));

        $mail->action(trans('mail.remember_login.button'), route('login'));

        return $mail;
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
