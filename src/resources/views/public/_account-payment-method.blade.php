<div class="account-payment-methods">
    <div class="account-payment-methods-header">
        <h2 class="account-payment-methods-title">@lang('Your payment method')</h2>
    </div>
    <div class="account-payment-methods-body">
        @if ($activeMandates->count() > 0)
            @foreach ($activeMandates as $mandate)
            <tr>
                <th scope="row">{{ $mandate->id }}</th>
                <td>{{ $mandate->method }}</td>
                <td><a href="{{ route(app()->getLocale().'::subscriptions-paymentmethod-revoke', $mandate->id) }}" class="btn btn-sm btn-outline-danger">@lang('Remove')</a></td>
            </tr>
            @endforeach
        @else
            <p class="account-payment-methods-notice">@lang('There is no payment method available.')</p>
        @endif
    </div>
</div>
