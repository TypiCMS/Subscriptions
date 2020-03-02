# Subscriptions

This module is part of [TypiCMS](https://github.com/TypiCMS/Base), a multilingual CMS based on the [Laravel framework](https://github.com/laravel/framework).

It allows you to setup a subscriptions management system based on [Laravel Cashier for Mollie](https://github.com/laravel/cashier-mollie).

## Installation

### Prerequisites

- You must have a working installation of TypiCMS
- Make sure your `APP_URL` in `.env` is correctly set.

### Install the package

```bash
composer require typicms/subscriptions
```

Add the service provider:

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

Add the cashier model and the mollie key in your environment file:

```php
// .env

CASHIER_MODEL=TypiCMS\Modules\Subscriptions\Models\BillableUser
MOLLIE_KEY="test_12345678912345678912345678912345"
```

Change the model class of the authentication configuration:
```php
// config/auth.php

'users' => [
     'driver' => 'eloquent',
     'model' => TypiCMS\Modules\Subscriptions\Models\BillableUser::class,
 ],
```

### Run the installation script

Install Cashier and migrate the database.

```bash
php artisan subscriptions:install
```

### Configure Cashier

Configure your subscription plans in `config/cashier_plans.php`.

Manage any coupons in `config/cashier_coupons.php`. By default an example coupon is enabled, consider disabling it before deploying to production.

Configure the redirect URL of the first payment:
```php
// config/cashier.php

'redirect_url' => config('app.url').'/webhooks/cashier/check-payment',
```

## Additional information
[Read the cashier-mollie documentation](https://github.com/laravel/cashier-mollie)
