<?php

namespace TypiCMS\Modules\Subscriptions\Http\Controllers;

use Illuminate\View\View;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Subscriptions\Models\Subscription;

class PublicController extends BasePublicController
{
    public function profileIndex(): View
    {
//        $models = Subscription::published()->order()->with('image')->get();
        $models = collect([]);

        return view('subscriptions::public.index')
            ->with(compact('models'));
    }

    public function profileUpdate()
    {
        //
    }


    public function paymentMethod()
    {
        //
    }

    public function paymentMethodUpdate()
    {
        //
    }

    public function plan()
    {
        //
    }

    public function subscribe(Request $request)
    {
        $plan = $request->input('plan');

        $user = Auth::user();
        $name = ucfirst($plan) . ' membership';

        if (! $user->subscribed($name, $plan)) {

            $result = $user->newSubscription($name, $plan)->create();

            if (is_a($result, RedirectToCheckoutResponse::class)) {
                return $result; // Redirect to Mollie checkout
            }

            return back()->with('status', 'Welcome to the ' . $plan . ' plan');
        }

        return back()->with('status', 'You are already on the ' . $plan . ' plan');
    }

    public function invoices()
    {
        //
    }
}
