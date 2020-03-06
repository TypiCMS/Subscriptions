@extends('subscriptions::public.master')

@section('bodyClass', 'body-subscriptions body-subscriptions-index body-page body-page-'.$page->id)

@section('title', __('Your profile'))

@section('master')

    <div class="rich-content">{!! $page->present()->body !!}</div>
    @include('files::public._documents', ['model' => $page])
    @include('files::public._images', ['model' => $page])

    @include('subscriptions::public._alerts')

    <div class="profile">
        <h2>@lang('Profile')</h2>

        <p class="profile-name">{{ $user->first_name }} {{ $user->last_name }}</p>

        <p class="profile-email">{{ $user->email }}</p>

        <p class="profile-address">
            {{ $user->street }} {{ $user->number }}<br/>
            {{ $user->zip }} {{ $user->city }}<br/>
            {{ $user->country }}
        </p>

        <a class="profile-submit-button btn btn-primary" href="{{ route(app()->getLocale() .'::subscriptions-profile-edit') }}">@lang('Edit my profile')</a>

    </div>

    <div class="plan">
        <h2>@lang('Subscription')</h2>
        @if($user->subscribed('main'))
            @if($user->subscription('main')->onGracePeriod())
                <p>@lang('Your subscription to the :name plan was cancelled. You still have access to it until :ends_at.', ['name' => $user->subscription('main')->plan, 'ends_at' => strtolower($user->subscription('main')->ends_at->formatLocalized('%A %d %B %Y'))])</p>
                <p><a class="btn btn-primary" href="{{ route(app()->getLocale() .'::subscriptions-resume') }}">@lang('Resume your subscription to the :name plan.', ['name' => $user->subscription('main')->plan])</a></p>
            @elseif($user->subscription('main')->cancelled())
                <p>@lang('Your subscription to the :name plan was cancelled.', ['name' => $user->subscription('main')->plan])</p>
            @else
                <p>@lang('You are subscribed to the :name plan.', ['name' => $user->subscription('main')->plan])</p>
                <p><a class="btn btn-light" href="{{ route(app()->getLocale() .'::subscriptions-upgrade') }}">@lang('Upgrade your subscription to another plan.')</a></p>
                <p><a class="btn btn-link" href="{{ route(app()->getLocale() .'::subscriptions-cancel') }}">@lang('Cancel your subscription to the :name plan.', ['name' => $user->subscription('main')->plan])</a></p>
            @endif
        @else
            {!! BootForm::open() !!}
            <ul>
                @foreach($plans as $name => $plan)
                    {!! BootForm::radio(ucfirst($name) . ' '. $plan['description'] .' <span class="text-muted small">'. $plan['amount']['value'] . ' ' . $plan['amount']['currency'] .' '. __('each') . ' ' . $plan['interval'] . '</span>', 'plan', $name) !!}
                @endforeach
            </ul>
            {!! BootForm::submit(__('Subscribe')) !!}
            {!! BootForm::close() !!}
        @endif
    </div>

    <div class="mandates">
        <h2>@lang('Payment methods')</h2>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">@lang('Type')</th>
                <th scope="col">@lang('Action')</th>
            </tr>
            </thead>
            <tbody>
            @foreach($activeMandates as $mandate)
                <tr>
                    <th scope="row">{{ $mandate->id }}</th>
                    <td>{{ $mandate->method }}</td>
                    <td><a href="{{ route(app()->getLocale() .'::subscriptions-paymentmethod-revoke', $mandate->id) }}" class="btn btn-sm btn-outline-danger">@lang('Remove')</a></td>
                </tr>
            @endforeach
            @if($activeMandates->count() == 0)
                <tr>
                    <td colspan="4" class="text-center text-muted">@lang('There is no payment method available.')</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>

    <div class="invoices">
        <h2>@lang('Invoices')</h2>
        @if ($invoices->count() > 0)
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">@lang('Date')</th>
                <th scope="col">@lang('Amount')</th>
                <th scope="col">@lang('Action')</th>
            </tr>
            </thead>
            <tbody>
            @foreach($invoices as $invoice)
                <tr>
                    <th scope="row">{{ $invoice->id() }}</th>
                    <td>{{ $invoice->date() }}</td>
                    <td>{{ $invoice->total() }}</td>
                    <td><a href="{{ route(app()->getLocale() .'::subscriptions-invoice', $invoice->id()) }}" target="_blank" class="btn btn-sm btn-outline-primary">@lang('View invoice')</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @else
        <p>@lang('You don’t have any invoices.')</p>
        @endif
    </div>

@endsection
