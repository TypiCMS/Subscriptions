# Subscriptions

This module is part of [TypiCMS](https://github.com/TypiCMS/Base), a multilingual CMS based on the [Laravel framework](https://github.com/laravel/framework).


## Installation

You must have a working installation of TypiCMS, make sure your `APP_URL` in `.env` is correctly set.

1. Install the package by running `composer require typicms/subscriptions` and add `TypiCMS\Modules\Subscriptions\Providers\ModuleProvider::class,` in `config/app.php`
2. Add `CASHIER_MODEL=TypiCMS\Modules\Subscriptions\Models\BillableUser` to your `.env` file.
3. Add your Mollie key such as `MOLLIE_KEY="test_12345678912345678912345678912345"` to your `.env` file.
4. Edit `config/auth.php` and change the 'model' value to
```php
'users' => [
     'driver' => 'eloquent',
     'model' => TypiCMS\Modules\Subscriptions\Models\BillableUser::class,
 ],
```
5. Run `php artisan subscriptions:install`
6. Configure at least one subscription plan in config/cashier_plans.php.
7. In config/cashier_coupons.php you can manage any coupons. By default an example coupon is enabled. Consider disabling it before deploying to production.
8. Change the `first_payment` value in `config/cashier.php` to `'redirect_url' => config('app.url') . '/webhooks/cashier/check-payment',`

## Additional information
[Read the cashier-mollie documentation](https://github.com/laravel/cashier-mollie)
