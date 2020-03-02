<?php

namespace TypiCMS\Modules\Subscriptions\Http\Controllers;

use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;

class AdminController extends BaseAdminController
{
    public function index(): View
    {
        return view('subscriptions::admin.index');
    }
}
