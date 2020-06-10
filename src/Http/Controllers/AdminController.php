<?php

namespace TypiCMS\Modules\Subscriptions\Http\Controllers;

use Exception;
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

    public function show(Subscription $subscription): View
    {
        return view('subscriptions::admin.show')
            ->with(['model' => $subscription]);
    }

    public function cancel(Subscription $subscription, FormRequest $request): RedirectResponse
    {
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
                ->with('error', __($e->getMessage()));
        }
    }
}
