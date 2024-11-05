<?php

namespace App\Notifications\TravelPlans;

use App\Models\TravelPlans\TravelPlan;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TravelPlanProcessed extends Notification
{
    use Queueable;

    private TravelPlan $travelPlan;

    /**
     * Create a new notification instance.
     */
    public function __construct(TravelPlan $travelPlan)
    {
        $this->travelPlan = $travelPlan;
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
        $mailMessage = new MailMessage;

        $mailMessage->subject(trans('mail.travel_plan_processed.subject'));

        $mailMessage->line(trans('mail.travel_plan_processed.line1'));

        $mailMessage->line(trans('mail.travel_plan_processed.line2'));

        $travelPlanUrl = route('travel-plans.show', ['id' => encrypt($this->travelPlan->id)]);

        $mailMessage->action(trans('mail.travel_plan_processed.button'), $travelPlanUrl);

        return $mailMessage;
    }
}
