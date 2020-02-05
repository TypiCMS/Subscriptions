<?php

namespace TypiCMS\Modules\Subscriptions\Models;

use TypiCMS\Modules\Users\Models\User;
use Laravel\Cashier\Billable;

class BillableUser extends User
{
    use Billable;

    protected $table = 'users';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'activated',
        'superuser',
        'api_token',
        'email_verified_at',
        'street',
        'number',
        'zip',
        'city',
        'country',
    ];

}
