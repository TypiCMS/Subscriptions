<?php

namespace TypiCMS\Modules\Subscriptions\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use TypiCMS\Modules\Core\Facades\TypiCMS;

class YourCancelledSubscription extends Notification
{
    use Queueable;

    private $subscription;
    private $user;

    /**
     * Create a new notification instance.
     *
     * @param mixed $subscription
     * @param mixed $user
     */
    public function __construct($subscription, $user)
    {
        $this->subscription = $subscription;
        $this->user = $user;
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
            ->subject('[' . TypiCMS::title() . '] ' . __('Goodbye'))
            ->markdown('subscriptions::mail.your-cancelled-subscription', ['user' => $this->user, 'subscription' => $this->subscription]);
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
