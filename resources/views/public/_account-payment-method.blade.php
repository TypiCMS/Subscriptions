<div class="account-payment-methods">
    <div class="account-payment-methods-header">
        <h2 class="account-payment-methods-title">@lang('Your payment method')</h2>
    </div>
    @if ($activeMandates->count() > 0)
        @foreach ($activeMandates as $mandate)
        <ul class="account-payment-methods-list">
            @isset($mandate->details->consumerName)
            <li class="account-payment-methods-item">
                <span class="account-payment-methods-item-label">@lang('Name')</span>
                <span class="account-payment-methods-item-value">{{ $mandate->details->consumerName }}</span>
            </li>
            @endisset
            @isset($mandate->details->consumerAccount)
            <li class="account-payment-methods-item">
                <span class="account-payment-methods-item-label">@lang('Account')</span>
                <span class="account-payment-methods-item-value">{{ $mandate->details->consumerAccount }}</span>
            </li>
            @endisset
            <li class="account-payment-methods-item">
                <span class="account-payment-methods-item-label">@lang('Method')</span>
                <span class="account-payment-methods-item-value">{{ $mandate->method }}</span>
            </li>
            <li class="account-payment-methods-item">
                <span class="account-payment-methods-item-label">@lang('Status')</span>
                <span class="account-payment-methods-item-value">{{ $mandate->status }}</span>
            </li>
        </ul>
        <div class="account-payment-methods-body">
            @if (! request()->user()->hasRunningSubscription())
            <a class="account-payment-methods-button btn btn-sm btn-secondary" href="{{ route(app()->getLocale().'::subscriptions-paymentmethod-revoke', $mandate->id) }}">@lang('Remove')</a>
            @endif
        </div>
        @endforeach
    @else
    <div class="account-payment-methods-body">
        <p class="account-payment-methods-notice">@lang('There is no payment method available.')</p>
    </div>
    @endif
</div>
