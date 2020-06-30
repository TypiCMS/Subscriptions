<?php

namespace TypiCMS\Modules\Subscriptions\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use TypiCMS\Modules\Core\Facades\TypiCMS;

class YourSubscriptionWillBeRenewed extends Notification
{
    use Queueable;

    private $subscription;

    /**
     * Create a new notification instance.
     *
     * @param mixed $subscription
     * @param mixed $user
     */
    public function __construct($subscription)
    {
        $this->subscription = $subscription;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject('['.TypiCMS::title().'] '.__('Your subscription'))
            ->greeting(__('Hello!'))
            ->line(__('We inform you that your membership as a :plan will be renewed automatically as of :date.', ['plan' => __($this->subscription->plan), 'date' => $this->subscription->cycle_ends_at->format('d.m.Y')]));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
        ];
    }
}
