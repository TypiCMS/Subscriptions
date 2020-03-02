<?php

namespace TypiCMS\Modules\Subscriptions\Console\Commands;

use Illuminate\Console\Command;

class MollieCashierInstall extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'subscriptions:install';

    /**
     * The console command description.
     */
    protected $description = 'Install the Subscriptions module and the Laravel Cashier for Mollie package.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('cashier:install', ['--template' => true]);
        $this->call('translations:add', ['path' => 'vendor/typicms/subscriptions/src/resources/lang']);
        $this->call('migrate');
    }
}
