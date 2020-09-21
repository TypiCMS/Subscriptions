<?php

namespace TypiCMS\Modules\Subscriptions\Http\Controllers;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Subscriptions\Exports\SubscriptionsExport;
use TypiCMS\Modules\Subscriptions\Http\Requests\FormRequest;
use TypiCMS\Modules\Subscriptions\Models\Subscription;

class AdminController extends BaseAdminController
{
    public function index(): View
    {
        return view('subscriptions::admin.index');
    }

    public function export(Request $request)
    {
        $filename = date('Y-m-d').' '.config('app.name').' subscriptions.xlsx';

        return Excel::download(new SubscriptionsExport($request), $filename);
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

            $user->subscription('main')->cancel();

            return redirect()
                ->back()
                ->with('message', __('The subscription was sucessfully cancelled.'));
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', __($e->getMessage()));
        }
    }

    public function resume(Subscription $subscription, FormRequest $request): RedirectResponse
    {
        try {
            $user = $subscription->owner;

            $user->subscription('main')->resume();

            return redirect()
                ->back()
                ->with('message', __('The subscription was sucessfully resumed.'));
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->back()
                ->with('error', __($e->getMessage()));
        }
    }
}
