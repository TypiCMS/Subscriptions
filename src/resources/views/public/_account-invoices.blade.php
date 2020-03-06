<div class="account-invoices">
    <div class="account-invoices-header">
        <h2 class="account-invoices-title">@lang('Your invoices')</h2>
    </div>
    @if ($invoices->count() > 0)
    <table class="account-invoices-table">
        <thead>
        <tr>
            <th scope="col">@lang('Number')</th>
            <th scope="col">@lang('Date')</th>
            <th scope="col">@lang('Amount')</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($invoices as $invoice)
            <tr>
                <th scope="row">
                    <small class="text-muted fw-normal">{{ $invoice->id() }}</small>
                </th>
                <td><small>{{ $invoice->date()->format('d.m.Y') }}</small></td>
                <td>{{ $invoice->total() }}</td>
                <td><a href="{{ route(app()->getLocale().'::subscriptions-invoice', $invoice->id()) }}" target="_blank" class="btn btn-sm btn-outline-primary">@lang('View invoice')</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @else
    <p class="account-invoices-notice">@lang('You don’t have any invoices.')</p>
    @endif
</div>
