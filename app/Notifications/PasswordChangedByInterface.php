<?php

namespace App\Notifications;

use App\Models\Auth\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class PasswordChangedByInterface extends Notification implements ShouldQueue
{
    use Queueable;

    private string $ipAddress;

    /**
     * The notification construct.
     *
     * @param string $ipAddress
     */
    public function __construct(string $ipAddress)
    {
        $this->ipAddress = $ipAddress;
    }

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
    public function toMail(): MailMessage
    {
        $mailMessage = new MailMessage();

        $mailMessage->subject(trans('mail.password_changed_by_interface.subject'));

        $mailMessage->line(trans('mail.password_changed_by_interface.line1'));

        $line2HtmlString = new HtmlString(trans('mail.password_changed_by_interface.line2', [
            'ip_address' => $this->ipAddress,
            'time' => now()->format('Y-m-d H:i:s')
        ]));

        $mailMessage->line($line2HtmlString);

        $mailMessage->line(trans('mail.password_changed_by_interface.line3'));

        $mailMessage->line(trans('mail.password_changed_by_interface.line4'));

        $mailMessage->action(trans('mail.password_changed_by_interface.button'), route('password.request'));

        return $mailMessage;
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
