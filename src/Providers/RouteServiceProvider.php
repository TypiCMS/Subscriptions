<?php

namespace TypiCMS\Modules\Subscriptions\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Subscriptions\Http\Controllers\AdminController;
use TypiCMS\Modules\Subscriptions\Http\Controllers\ApiController;
use TypiCMS\Modules\Subscriptions\Http\Controllers\PublicController;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define the routes for the application.
     */
    public function map()
    {
        foreach (locales() as $lang) {
            Route::middleware('web')->get($lang.'/webhooks/cashier/check-payment/{payment_id}', [PublicController::class, 'checkPayment']);
        }

        /*
         * Front office routes
         */
        if ($page = TypiCMS::getPageLinkedToModule('subscriptions')) {
            $middleware = ['public', 'auth'];
            foreach (locales() as $lang) {
                if ($page->isPublished($lang) && $uri = $page->uri($lang)) {
                    Route::middleware($middleware)->prefix($uri)->name($lang.'::')->group(function (Router $router) {
                        $router->get('/', [PublicController::class, 'profileIndex'])->name('subscriptions-profile');
                        $router->get('edit', [PublicController::class, 'profileEdit'])->name('subscriptions-profile-edit');
                        $router->post('edit', [PublicController::class, 'profileUpdate'])->name('subscriptions-profile-update');
                        $router->get('payment-method/{id}', [PublicController::class, 'paymentMethodRevoke'])->name('subscriptions-paymentmethod-revoke');
                        $router->post('payment-method', [PublicController::class, 'paymentMethodUpdate'])->name('subscriptions-paymentmethod-update');
                        $router->get('plans', [PublicController::class, 'plans'])->name('subscriptions-plans');
                        $router->post('plans', [PublicController::class, 'subscribe'])->name('subscriptions-subscribe');
                        $router->post('plans/upgrade', [PublicController::class, 'upgrade'])->name('subscriptions-upgrade');
                        $router->get('plans/cancel', [PublicController::class, 'cancel'])->name('subscriptions-cancel');
                        $router->get('plans/resume', [PublicController::class, 'resume'])->name('subscriptions-resume');
                        $router->get('invoice/{number}', [PublicController::class, 'invoice'])->name('subscriptions-invoice');
                        $router->get('invoice/{number}/download', [PublicController::class, 'downloadInvoice'])->name('subscriptions-download-invoice');
                    });
                }
            }
        }

        /*
         * Admin routes
         */
        Route::middleware('admin')->prefix('admin')->name('admin::')->group(function (Router $router) {
            $router->get('subscriptions', [AdminController::class, 'index'])->name('index-subscriptions')->middleware('can:read subscriptions');
            $router->get('subscriptions/{subscription}', [AdminController::class, 'show'])->name('show-subscription')->middleware('can:update-subscription');
            $router->post('subscriptions/{subscription}/cancel', [AdminController::class, 'cancel'])->name('cancel-subscription')->middleware('can:update-subscription');
            $router->post('subscriptions/{subscription}/resume', [AdminController::class, 'resume'])->name('resume-subscription')->middleware('can:update-subscription');
        });

        /*
         * API routes
         */
        Route::middleware(['api', 'auth:api'])->prefix('api')->group(function (Router $router) {
            $router->get('subscriptions', [ApiController::class, 'index'])->middleware('can:read subscriptions');
        });
    }
}
