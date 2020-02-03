<?php

namespace TypiCMS\Modules\Subscriptions\Models;

use TypiCMS\Modules\Users\Models\User;
use Laravel\Cashier\Billable;

class BillableUser extends User
{
    use Billable;

    protected $table = 'users';
}
