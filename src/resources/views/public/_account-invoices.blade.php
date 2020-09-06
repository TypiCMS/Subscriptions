<div class="account-invoices">
    <div class="account-invoices-header">
        <h2 class="account-invoices-title">@lang('Your invoices')</h2>
    </div>
    @if ($invoices->count() > 0)
    <table class="account-invoices-table">
        <thead>
        <tr>
            <th scope="col">@lang('Date')</th>
            <th scope="col">@lang('Number')</th>
            <th scope="col">@lang('Amount')</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($invoices as $invoice)
            <tr>
                <td scope="row">{{ $invoice->date()->format('d.m.Y') }}</td>
                <th>
                    <small class="text-muted fw-normal">{{ $invoice->id() }}</small>
                </th>
                <td>{{ $invoice->total() }}</td>
                <td class="text-right">
                    <a class="btn btn-sm btn-light" href="{{ route($lang.'::subscriptions-invoice', $invoice->id()) }}" target="_blank">@lang('View')</a>
                    <a class="btn btn-sm btn-secondary" href="{{ route($lang.'::subscriptions-download-invoice', $invoice->id()) }}"><span class="fa fa-fw fa-download"></span> @lang('Download')</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @else
    <div class="account-invoices-body">
        <p class="account-invoices-notice">@lang('You don’t have any invoices.')</p>
    </div>
    @endif
</div>
