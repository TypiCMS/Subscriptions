<?php

namespace TypiCMS\Modules\Subscriptions\Console\Commands;

use Illuminate\Console\Command;
use TypiCMS\Modules\Subscriptions\Jobs\NotifyMembersThatSubscriptionWillBeRenewed;

class SubscriptionsRenewalNotification extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'subscriptions:renewal-notification';

    /**
     * The console command description.
     */
    protected $description = 'Send a notification to users that have a soon to be renewed subscription.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        NotifyMembersThatSubscriptionWillBeRenewed::dispatch();
    }
}
