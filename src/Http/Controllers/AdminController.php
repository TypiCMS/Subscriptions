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

    public function create(): View
    {
        $model = new Subscription();

        return view('subscriptions::admin.create')
            ->with(compact('model'));
    }

    public function edit(Subscription $subscription): View
    {
        return view('subscriptions::admin.edit')
            ->with(['model' => $subscription]);
    }

    public function store(FormRequest $request): RedirectResponse
    {
        $subscription = Subscription::create($request->all());

        return $this->redirect($request, $subscription);
    }

    public function update(Subscription $subscription, FormRequest $request): RedirectResponse
    {
        $subscription->update($request->all());

        return $this->redirect($request, $subscription);
    }
}
