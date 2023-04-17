<?php

namespace TypiCMS\Modules\Subscriptions\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use TypiCMS\Modules\Core\Facades\TypiCMS;

class NewPaidOrder extends Notification
{
    use Queueable;

    private $order;
    private $user;

    /**
     * Create a new notification instance.
     *
     * @param mixed $order
     * @param mixed $user
     */
    public function __construct($order, $user)
    {
        $this->order = $order;
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
            ->subject('[' . TypiCMS::title() . '] ' . __('A subscription was renewed automatically.'))
            ->markdown('subscriptions::mail.new-paid-order', ['user' => $this->user, 'order' => $this->order]);
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
