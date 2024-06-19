<?php

namespace App\Notifications\User;

use App\Models\Auth\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeUser extends Notification
{
    use Queueable;

    /**
     * The user to be welcome.
     *
     * @var User $user
     */
    private User $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(): MailMessage
    {
        $mail = new MailMessage();

        $mail->subject(trans('mail.welcome.subject'));

        $mail->line(trans('mail.welcome.line1', [
            'name' => $this->user->name,
        ]));

        $mail->line(trans('mail.welcome.line2'));

        $mail->action(trans('mail.welcome.button'), route('login'));

        return $mail;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            //
        ];
    }
}
