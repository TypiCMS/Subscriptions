<?php

namespace TypiCMS\Modules\Subscriptions\Http\Controllers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Subscriptions\Models\Subscription;

class AdminController extends BaseAdminController
{
    public function index(): View
    {
        return view('subscriptions::admin.index');
    }

    public function edit(Subscription $subscription): View
    {
        return view('subscriptions::admin.edit')
            ->with(['model' => $subscription]);
    }

    public function store(FormRequest $request): RedirectResponse
    {
        $data = $request->all();
        $model = Subscription::create($data);

        return $this->redirect($request, $model);
    }

    public function update(Subscription $subscription, FormRequest $request): RedirectResponse
    {
        $data = $request->all();
        $subscription->update($data);

        return $this->redirect($request, $subscription);
    }
}
