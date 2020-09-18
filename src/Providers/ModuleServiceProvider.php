<?php

namespace TypiCMS\Modules\Subscriptions\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Subscriptions\Composers\SidebarViewComposer;
use TypiCMS\Modules\Subscriptions\Console\Commands\Install;
use TypiCMS\Modules\Subscriptions\Console\Commands\SubscriptionsRenewalNotification;
use TypiCMS\Modules\Subscriptions\Facades\SubscriberFacade;
use TypiCMS\Modules\Subscriptions\Listeners\NotificationSubscriber;
use TypiCMS\Modules\Subscriptions\Subscriber;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'typicms.subscriptions');
        $this->mergeConfigFrom(__DIR__.'/../config/permissions.php', 'typicms.permissions');

        $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('typicms.modules', array_merge(['subscriptions' => ['linkable_to_page']], $modules));

        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'subscriptions');

        $this->publishes([
            __DIR__.'/../database/migrations/add_columns_to_users_table.php.stub' => getMigrationFileName('add_columns_to_users_table'),
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/subscriptions'),
        ], 'views');

        $this->publishes([
            __DIR__.'/../resources/scss' => resource_path('scss'),
        ], 'resources');

        /*
         * Sidebar view composer
         */
        $this->app->view->composer('core::admin._sidebar', SidebarViewComposer::class);

        /*
         * Add the page in the view.
         */
        $this->app->view->composer('subscriptions::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('subscriptions');
        });

        /*
         * Register the Subscriber Facade
         */
        $this->app->bind('Subscriber', Subscriber::class);
        AliasLoader::getInstance()->alias('Subscriber', SubscriberFacade::class);

        /*
         * Listen to Cashier events
         */
        Event::subscribe(NotificationSubscriber::class);

        /*
         * Schedule a periodic job to execute Cashier::run().
         */
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('cashier:run')
                ->everyFiveMinutes()
                ->withoutOverlapping();

            $schedule->command('subscriptions:renewal-notification')
                ->dailyAt('10:00');
        });
    }

    public function register()
    {
        $app = $this->app;

        $this->commands([
            Install::class,
            SubscriptionsRenewalNotification::class,
        ]);

        /*
         * Register route service provider
         */
        $app->register(RouteServiceProvider::class);
    }
}
