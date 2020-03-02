<?php

namespace TypiCMS\Modules\Subscriptions\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Subscriptions\Http\Requests\FormRequest;
use TypiCMS\Modules\Subscriptions\Models\Subscription;

class AdminController extends BaseAdminController
{
    public function index(): View
    {
        return view('subscriptions::admin.index');
    }
}
