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
     *
     * @return null
     */
    public function map()
    {
        Route::namespace($this->namespace)->group(function (Router $router) {

            /*
             * Front office routes
             */
            if ($page = TypiCMS::getPageLinkedToModule('subscriptions')) {
                $router->middleware('public')->group(function (Router $router) use ($page) {
                    $options = ['middleware' => 'auth'];
                    foreach (locales() as $lang) {
                        if ($page->translate('status', $lang) && $uri = $page->uri($lang)) {
                            $router->get($uri, $options + ['uses' => 'PublicController@profileIndex'])->name($lang . '::subscriptions-profile');
                            $router->get($uri . '/edit', $options + ['uses' => 'PublicController@profileEdit'])->name($lang . '::subscriptions-profile-edit');
                            $router->post($uri . '/edit', $options + ['uses' => 'PublicController@profileUpdate'])->name($lang . '::subscriptions-profile-update');
                            $router->get($uri . '/payment-method', $options + ['uses' => 'PublicController@paymentMethod'])->name($lang . '::subscriptions-paymentmethod');
                            $router->post($uri . '/payment-method', $options + ['uses' => 'PublicController@paymentMethodUpdate'])->name($lang . '::subscriptions-paymentmethod-update');
                            $router->get($uri . '/subscription', $options + ['uses' => 'PublicController@plans'])->name($lang . '::subscriptions-plans');
                            $router->post($uri . '/subscription', $options + ['uses' => 'PublicController@subscribe'])->name($lang . '::subscriptions-subscribe');
                            $router->get($uri . '/subscription', $options + ['uses' => 'PublicController@invoices'])->name($lang . '::subscriptions-invoices');
                        }
                    }
                });
            }

            /*
             * Admin routes
             */
            $router->middleware('admin')->prefix('admin')->group(function (Router $router) {
                $router->get('subscriptions', 'AdminController@index')->name('admin::index-subscriptions')->middleware('can:see-all-subscriptions');
                $router->get('subscriptions/create', 'AdminController@create')->name('admin::create-subscription')->middleware('can:create-subscription');
                $router->get('subscriptions/{subscription}/edit', 'AdminController@edit')->name('admin::edit-subscription')->middleware('can:update-subscription');
                $router->post('subscriptions', 'AdminController@store')->name('admin::store-subscription')->middleware('can:create-subscription');
                $router->put('subscriptions/{subscription}', 'AdminController@update')->name('admin::update-subscription')->middleware('can:update-subscription');
            });

            /*
             * API routes
             */
            $router->middleware('api')->prefix('api')->group(function (Router $router) {
                $router->middleware('auth:api')->group(function (Router $router) {
                    $router->get('subscriptions', 'ApiController@index')->middleware('can:see-all-subscriptions');
                    $router->patch('subscriptions/{subscription}', 'ApiController@updatePartial')->middleware('can:update-subscription');
                    $router->delete('subscriptions/{subscription}', 'ApiController@destroy')->middleware('can:delete-subscription');

                    $router->get('subscriptions/{subscription}/files', 'ApiController@files')->middleware('can:update-subscription');
                    $router->post('subscriptions/{subscription}/files', 'ApiController@attachFiles')->middleware('can:update-subscription');
                    $router->delete('subscriptions/{subscription}/files/{file}', 'ApiController@detachFile')->middleware('can:update-subscription');
                });
            });
        });
    }
}
