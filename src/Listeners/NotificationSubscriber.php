<?php

namespace TypiCMS\Modules\Subscriptions\Listeners;

use Illuminate\Support\Facades\Notification;
use TypiCMS\Modules\Subscriptions\Notifications\NewFailedOrder;
use TypiCMS\Modules\Subscriptions\Notifications\NewFirstPaidOrder;
use TypiCMS\Modules\Subscriptions\Notifications\NewPaidOrder;
use TypiCMS\Modules\Subscriptions\Notifications\YourCancelledSubscription;
use TypiCMS\Modules\Subscriptions\Notifications\YourFailedOrder;
use TypiCMS\Modules\Subscriptions\Notifications\YourNewSubscription;
use TypiCMS\Modules\Subscriptions\Notifications\YourRenewedSubscription;
use TypiCMS\Modules\Users\Models\User;

class NotificationSubscriber
{
    public function onFirstPaymentPaid($event)
    {
        $order = $event->order;
        $user = User::find($order->owner_id);
        $user->notify(new YourNewSubscription($order, $user));

        // Notify the webmaster
        Notification::route('mail', config('typicms.webmaster_email'))
            ->notify(new NewFirstPaidOrder($order, $user));
    }

    public function onPaymentPaid($event)
    {
        $order = $event->order;
        $user = User::find($order->owner_id);
        $user->notify(new YourRenewedSubscription($order, $user));

        // Notify the webmaster
        Notification::route('mail', config('typicms.webmaster_email'))
            ->notify(new NewPaidOrder($order, $user));
    }

    public function onPaymentFailed($event)
    {
        $order = $event->order;
        $user = User::find($order->owner_id);
        $user->notify(new YourFailedOrder($order, $user));

        // Notify the webmaster
        Notification::route('mail', config('typicms.webmaster_email'))
            ->notify(new NewFailedOrder($order, $user));
    }

    public function onSubscriptionCancelled($event)
    {
        $subscription = $event->subscription;
        $user = User::find($subscription->owner_id);
        $user->notify(new YourCancelledSubscription($subscription, $user));
    }

    public function subscribe($events)
    {
        // First payment paid
        $events->listen(
            'Laravel\Cashier\Events\FirstPaymentPaid',
            'TypiCMS\Modules\Subscriptions\Listeners\NotificationSubscriber@onFirstPaymentPaid'
        );

        // Payment paid
        $events->listen(
            'Laravel\Cashier\Events\OrderPaymentPaid',
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
