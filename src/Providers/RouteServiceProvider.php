<?php

namespace TypiCMS\Modules\Subscriptions\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use TypiCMS\Modules\Core\Facades\TypiCMS;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'TypiCMS\Modules\Subscriptions\Http\Controllers';

    /**
     * Define the routes for the application.
     */
    public function map()
    {
        Route::namespace($this->namespace)->group(function (Router $router) {
            foreach (locales() as $lang) {
                $router->middleware('web')->get($lang.'/webhooks/cashier/check-payment/{payment_id}', ['uses' => 'PublicController@checkPayment']);
            }

            /*
             * Front office routes
             */
            if ($page = TypiCMS::getPageLinkedToModule('subscriptions')) {
                $router->middleware('public')->group(function (Router $router) use ($page) {
                    $options = ['middleware' => 'auth'];
                    foreach (locales() as $lang) {
                        if ($page->translate('status', $lang) && $uri = $page->uri($lang)) {
                            $router->get($uri, $options + ['uses' => 'PublicController@profileIndex'])->name($lang.'::subscriptions-profile');
                            $router->get($uri.'/edit', $options + ['uses' => 'PublicController@profileEdit'])->name($lang.'::subscriptions-profile-edit');
                            $router->post($uri.'/edit', $options + ['uses' => 'PublicController@profileUpdate'])->name($lang.'::subscriptions-profile-update');
                            $router->get($uri.'/payment-method/{id}', $options + ['uses' => 'PublicController@paymentMethodRevoke'])->name($lang.'::subscriptions-paymentmethod-revoke');
                            $router->post($uri.'/payment-method', $options + ['uses' => 'PublicController@paymentMethodUpdate'])->name($lang.'::subscriptions-paymentmethod-update');
                            $router->post($uri.'/plans', $options + ['uses' => 'PublicController@subscribe'])->name($lang.'::subscriptions-subscribe');
                            $router->get($uri.'/plans/upgrade', $options + ['uses' => 'PublicController@upgrade'])->name($lang.'::subscriptions-upgrade');
                            $router->post($uri.'/plans/upgrade', $options + ['uses' => 'PublicController@upgradePost'])->name($lang.'::subscriptions-upgradePost');
                            $router->get($uri.'/plans/cancel', $options + ['uses' => 'PublicController@cancel'])->name($lang.'::subscriptions-cancel');
                            $router->get($uri.'/plans/resume', $options + ['uses' => 'PublicController@resume'])->name($lang.'::subscriptions-resume');
                            $router->get($uri.'/invoice/{id}', $options + ['uses' => 'PublicController@invoice'])->name($lang.'::subscriptions-invoice');
                            $router->get($uri.'/invoice/{id}/download', $options + ['uses' => 'PublicController@downloadInvoice'])->name($lang.'::subscriptions-download-invoice');
                        }
                    }
                });
            }

            /*
             * Admin routes
             */
            $router->middleware('admin')->prefix('admin')->group(function (Router $router) {
                $router->get('subscriptions', 'AdminController@index')->name('admin::index-subscriptions')->middleware('can:see-all-subscriptions');
                $router->get('subscriptions/{subscription}/edit', 'AdminController@edit')->name('admin::edit-subscription')->middleware('can:update-subscription');
                $router->put('subscriptions/{subscription}', 'AdminController@update')->name('admin::update-subscription')->middleware('can:update-subscription');
                $router->put('subscriptions/{subscription}', 'AdminController@cancel')->name('admin::cancel-subscription')->middleware('can:update-subscription');
            });

            /*
             * API routes
             */
            $router->middleware('api')->prefix('api')->group(function (Router $router) {
                $router->middleware('auth:api')->group(function (Router $router) {
                    $router->get('subscriptions', 'ApiController@index')->middleware('can:see-all-subscriptions');
                });
            });
        });
    }
}
