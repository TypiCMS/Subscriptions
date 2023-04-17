<?php

namespace TypiCMS\Modules\Subscriptions\Http\Controllers;

use Dompdf\Options;
use Exception;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Laravel\Cashier\Order\Order;
use Laravel\Cashier\SubscriptionBuilder\RedirectToCheckoutResponse;
use Mollie\Api\Exceptions\ApiException;
use Mollie\Api\Types\PaymentStatus;
use Mollie\Laravel\Facades\Mollie;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Subscriptions\Http\Requests\SubscriptionsPlan;
use TypiCMS\Modules\Subscriptions\Http\Requests\SubscriptionsProfileUpdate;

class PublicController extends BasePublicController
{
    public function profileIndex(Request $request): View
    {
        $user = $request->user();

        $plans = collect(config('cashier_plans.plans'));

        $customer = null;
        $activeMandates = collect();

        try {
            $customer = $user->asMollieCustomer();
        } catch (ApiException $exception) {
            report($exception);
        }

        if ($customer === null) {
            $customer = $user->createAsMollieCustomer();
        }

        foreach ($customer->mandates() as $mandate) {
            if ($mandate->status === 'valid') {
                $activeMandates->push($mandate);
            }
        }

        $invoices = $user->orders->invoices();

        return view('subscriptions::public.index')
            ->with(compact('user', 'plans', 'activeMandates', 'invoices'));
    }

    public function profileEdit(Request $request): View
    {
        $user = $request->user();

        return view('subscriptions::public.edit')->with(compact('user'));
    }

    public function profileUpdate(SubscriptionsProfileUpdate $request)
    {
        $request->user()->update($request->validated());

        return redirect()
            ->route(app()->getLocale() . '::subscriptions-profile')
            ->with('success', __('Your profile has been successfully updated.'));
    }

    public function paymentMethodRevoke(Request $request, $id)
    {
        if ($request->user()->hasRunningSubscription()) {
            return redirect()
                ->route(app()->getLocale() . '::subscriptions-profile')
                ->with('error', __('Your payment method could not be revoked as you have a running subscription.'));
        }

        try {
            $request->user()->mollieMandate()->revoke();

            return redirect()
                ->route(app()->getLocale() . '::subscriptions-profile')
                ->with('success', __('Your payment method was sucesfully revoked.'));
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->route(app()->getLocale() . '::subscriptions-profile')
                ->with('error', __('Your payment method could not be revoked.'));
        }
    }

    public function paymentMethodUpdate()
    {
        // Not now.
        return redirect()->route(app()->getLocale() . '::subscriptions-profile');
    }

    public function subscribe(SubscriptionsPlan $request)
    {
        $plan = $request->input('plan');

        $user = $request->user();
        $name = 'main';

        if ($user->subscribed($name, $plan)) {
            return back()->with('error', __('You are already on the :plan plan', ['plan' => $plan]));
        }

        try {
            $result = $user->newSubscription(
                $name,
                $plan,
                ['redirectUrl' => config('app.url') . '/' . app()->getLocale() . '/webhooks/cashier/check-payment/{payment_id}']
            )->create();

            if (is_a($result, RedirectToCheckoutResponse::class)) {
                return $result; // Redirect to Mollie checkout
            }

            return back()->with('success', __('You are now successfully subscribed.'));
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->route(app()->getLocale() . '::subscriptions-profile')
                ->with('error', __('Your subscription could not be performed.'));
        }
    }

    public function cancel(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user->subscription('main')->cancelled() && !$user->subscription('main')->onGracePeriod()) {
                $user->subscription('main')->cancel();

                return redirect()
                    ->route(app()->getLocale() . '::subscriptions-profile')
                    ->with('success', __('Your subscription was sucessfully cancelled.'));
            }

            return redirect()
                ->route(app()->getLocale() . '::subscriptions-profile')
                ->with('error', __('Your subscription could not be cancelled.'));
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->route(app()->getLocale() . '::subscriptions-profile')
                ->with('error', __('Your subscription could not be cancelled.'));
        }
    }

    public function resume(Request $request)
    {
        try {
            $request->user()
                ->subscription('main')
                ->resume();

            return redirect()
                ->route(app()->getLocale() . '::subscriptions-profile')
                ->with('success', __('Your subscription was sucessfully resumed.'));
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->route(app()->getLocale() . '::subscriptions-profile')
                ->with('error', __('Your subscription could not be resumed.'));
        }
    }

    public function upgrade(SubscriptionsPlan $request)
    {
        try {
            $request->user()
                ->subscription('main')
                ->swap($request->input('plan'));
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->route(app()->getLocale() . '::subscriptions-profile')
                ->with('error', __('Your subscription could not be upgraded.'));
        }

        return redirect()
            ->route(app()->getLocale() . '::subscriptions-profile')
            ->with('success', __('Your subscription was sucessfully upgraded.'));
    }

    public function invoice(Request $request, $number)
    {
        $order = Order::where('number', $number)
            ->where('owner_id', $request->user()->id)
            ->firstOrFail();

        return $order->invoice()->view();
    }

    public function downloadInvoice(Request $request, $number)
    {
        $order = Order::where('number', $number)
            ->where('owner_id', $request->user()->id)
            ->firstOrFail();

        $pdfOptions = new Options();
        $pdfOptions->set('defaultPaperSize', 'A4');

        return $order->invoice()->download([], 'cashier::receipt', $pdfOptions);
    }

    public function checkPayment(Request $request, $payment_id)
    {
        try {
            $payment = Mollie::api()
                ->payments()
                ->get($payment_id);

            if ($payment->status == PaymentStatus::STATUS_PAID) {
                return redirect()
                    ->route(app()->getLocale() . '::subscriptions-profile')
                    ->with('success', __('You are now successfully subscribed.'));
            }

            return redirect()
                ->route(app()->getLocale() . '::subscriptions-profile')
                ->with('error', __('Your subscription could not be perfomed. Please retry.'));
        } catch (Exception $e) {
            report($e);

            return redirect()
                ->route(app()->getLocale() . '::subscriptions-profile')
                ->with('error', __('Your subscription could not be perfomed. Please retry.'));
        }
    }

    public function plans(Request $request)
    {
        $user = $request->user();

        $plans = collect(config('cashier_plans.plans'));

        return view('subscriptions::public.plans')
            ->with(compact('user', 'plans'));
    }
}
