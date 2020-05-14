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

    public function edit(int $subscriptionId): View
    {
        $subscription = Subscription::disableCache()->findOrFail($subscriptionId);

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

    public function cancel(int $subscriptionId, FormRequest $request): RedirectResponse
    {
        $subscription = Subscription::disableCache()->findOrFail($subscriptionId);

        try {
            $user = $subscription->owner;

            if (!$user->subscription('main')->cancelled() && !$user->subscription('main')->onGracePeriod()) {
                $user->subscription('main')->cancel();

                return redirect()
                    ->route('admin::edit-subscription', $subscription)
                    ->with('success', __('The subscription was sucessfully cancelled.'));
            }

            $user->subscription('main')->resume();

            return redirect()
                ->route('admin::edit-subscription', $subscription)
                ->with('success', __('The subscription was sucessfully resumed.'));
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->route('admin::edit-subscription', $subscription)
                ->with('error', __('An error occured while canceling the subscription.'));
        }
    }
}
