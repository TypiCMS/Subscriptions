<div class="account-payment-methods">
    <div class="account-payment-methods-header">
        <h2 class="account-payment-methods-title">@lang('Your payment method')</h2>
    </div>
    @if ($activeMandates->count() > 0)
        @foreach ($activeMandates as $mandate)
        <ul class="account-payment-methods-list">
            @if ($mandate->details->consumerName !== null)
            <li class="account-payment-methods-item">
                <span class="account-payment-methods-item-label">@lang('Name')</span>
                <span class="account-payment-methods-item-value">{{ $mandate->details->consumerName }}</span>
            </li>
            @endif
            <li class="account-payment-methods-item">
                <span class="account-payment-methods-item-label">@lang('Account')</span>
                <span class="account-payment-methods-item-value">{{ $mandate->details->consumerAccount }}</span>
            </li>
            <li class="account-payment-methods-item">
                <span class="account-payment-methods-item-label">@lang('Method')</span>
                <span class="account-payment-methods-item-value">{{ $mandate->method }}</span>
            </li>
            <li class="account-payment-methods-item">
                <span class="account-payment-methods-item-label">@lang('Status')</span>
                <span class="account-payment-methods-item-value">{{ $mandate->status }}</span>
            </li>
        </ul>
        {{-- <a href="{{ route(app()->getLocale().'::subscriptions-paymentmethod-revoke', $mandate->id) }}" class="btn btn-sm btn-outline-danger">@lang('Remove')</a> --}}
        @endforeach
    @else
        <p class="account-payment-methods-notice">@lang('There is no payment method available.')</p>
    @endif
</div>
