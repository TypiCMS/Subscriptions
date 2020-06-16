# Subscriptions

This module is part of [TypiCMS](https://github.com/TypiCMS/Base), a multilingual CMS based on the [Laravel framework](https://github.com/laravel/framework).

It allows you to setup a subscriptions management system based on [Laravel Cashier for Mollie](https://github.com/laravel/cashier-mollie).

## Installation

### Prerequisites

-   You must have a working installation of TypiCMS
-   Make sure your `APP_URL` in `.env` is correctly set.

### Install the package

```bash
composer require typicms/subscriptions
```

### Add the service provider:

```php
// config/app.php

/*
 * TypiCMS Modules Service Providers.
 * Here is the place for your modules,
 * they should be set before Core Service provider.
 */
…
TypiCMS\Modules\Subscriptions\Providers\ModuleProvider::class,
…
```

### Configure your app

Add the cashier model and the mollie key in your `.env` environment file:

```php
CASHIER_MODEL=TypiCMS\Modules\Users\Models\User
MOLLIE_KEY="test_12345678912345678912345678912345"
```

### Publish the Users module.
If not already done.
```php
php artisan typicms:publish Users
```
 [More information can be found here](https://github.com/TypiCMS/Base#publish-a-module)

### Mass-assignement
If needed, allow the following fields to be fillable.
```php
protected $fillable = [
     'street',
     'number',
     'zip',
     'city',
     'country',
     'box',
     'tax_percentage',
     'mollie_customer_id',
     'mollie_mandate_id',
     'tax_percentage',
     'trial_ends_at',
     'extra_billing_information'
 ];
```

### Run the installation script

Install Cashier and migrate the database.

```bash
php artisan subscriptions:install
```

### Configure Cashier

Configure your subscription plans in `config/cashier_plans.php`.

Manage any coupons in `config/cashier_coupons.php`. By default an example coupon is enabled, consider disabling it before deploying to production.

### Setup your app

Create a page linked to the Subscriptions module and navigate to it.

### Pre-build Plans Template 
Quickly build an effective pricing table for your potential customers with the template created under `/plans` and linked to the `PublicController@plans` controller.

### Customize Invoices

Copy the Cashier package views using the following command: 

```php
php artisan vendor:publish --provider="Laravel\Cashier\CashierServiceProvider" --tag="cashier-views"
```

You can customize the `/resources/views/vendor/cashier/` files as you like.

### Tax Management
To specify the tax percentage a user pays on a subscription, edit the `tax_percentage` column for the user in the database.

The displayed price on the subscription has built-in tax calculation.


## Additional information

[Read the cashier-mollie documentation](https://github.com/laravel/cashier-mollie)
