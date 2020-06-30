<?php

namespace TypiCMS\Modules\Subscriptions\Listeners;

use Illuminate\Support\Facades\Notification;
use TypiCMS\Modules\Subscriptions\Notifications\NewPaidOrder;
use TypiCMS\Modules\Subscriptions\Notifications\YourPaidOrder;
use TypiCMS\Modules\Subscriptions\Notifications\YourSubscriptionIsCancelled;
use TypiCMS\Modules\Users\Models\User;

class NotificationSubscriber
{
    public function onPaymentPaid($event)
    {
        $order = $event->order;
        $user = User::find($order->owner_id);
        $user->notify(new YourPaidOrder($order, $user));

        // Notify the webmaster
        Notification::route('mail', config('typicms.developer_email'))
            ->notify(new NewPaidOrder($order, $user));
    }

    public function onPaymentFailed($event)
    {
        $order = $event->order;
        $user = User::find($order->owner_id);
        $user->notify(new YourFailedOrder($order, $user));
    }

    public function onSubscriptionCancelled($event)
    {
        $subscription = $event->subscription;
        $user = User::find($subscription->owner_id);
        $user->notify(new YourSubscriptionIsCancelled($subscription, $user));
    }

    public function subscribe($events)
    {
        // Payment paid
        $events->listen(
            [
                'Laravel\Cashier\Events\FirstPaymentPaid',
                'Laravel\Cashier\Events\OrderPaymentPaid',
            ],
            'TypiCMS\Modules\Subscriptions\Listeners\NotificationSubscriber@onPaymentPaid'
        );

        // Payment failed
        $events->listen(
            [
                'Laravel\Cashier\Events\FirstPaymentFailed',
                'Laravel\Cashier\Events\OrderPaymentFailed',
            ],
            'TypiCMS\Modules\Subscriptions\Listeners\NotificationSubscriber@onPaymentFailed'
        );

        // Subscription cancelled
        $events->listen(
            'Laravel\Cashier\Events\SubscriptionCancelled',
            'TypiCMS\Modules\Subscriptions\Listeners\NotificationSubscriber@onSubscriptionCancelled'
        );
    }
}
