<?php

namespace TypiCMS\Modules\Subscriptions\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Laravel\Cashier\Subscription;
use TypiCMS\Modules\Subscriptions\Notifications\YourSubscriptionWillBeRenewed;

class NotifyMembersThatSubscriptionWillBeRenewed implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $subscriptions = Subscription::with('owner')
            ->whereBetween('cycle_ends_at', [
                Carbon::now()->addDays(6)->toDateTimeString(),
                Carbon::now()->addDays(7)->toDateTimeString(),
            ])
            ->get();
        info($subscriptions->count() . ' notification will be renewed in 7 days.');
        foreach ($subscriptions as $subscription) {
            $user = $subscription->owner;
            $subscription->owner->notify(new YourSubscriptionWillBeRenewed($subscription));
        }
    }
}
