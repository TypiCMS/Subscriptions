<?php

namespace TypiCMS\Modules\Subscriptions\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MollieCashierInstall extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'subscriptions:install';

    /**
     * The console command description.
     */
    protected $description = 'Install the subscriptions module and Mollie-Cashier package';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Artisan::call('cashier:install --template --no-interaction --quiet');
        Artisan::call('migrate');
    }
}
