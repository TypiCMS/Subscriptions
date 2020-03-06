<?php

namespace TypiCMS\Modules\Subscriptions\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Subscriptions\Composers\SidebarViewComposer;
use TypiCMS\Modules\Subscriptions\Console\Commands\Install;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'typicms.subscriptions');
        $this->mergeConfigFrom(__DIR__.'/../config/permissions.php', 'typicms.permissions');

        $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('typicms.modules', array_merge(['subscriptions' => ['linkable_to_page']], $modules));

        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'subscriptions');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/subscriptions'),
        ], 'views');

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
         * Schedule a periodic job to execute Cashier::run().
         */
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('cashier:run')
                ->daily()
                ->withoutOverlapping();
        });
    }

    public function register()
    {
        $app = $this->app;

        $this->commands([
            Install::class,
        ]);

        /*
         * Register route service provider
         */
        $app->register(RouteServiceProvider::class);
    }
}
