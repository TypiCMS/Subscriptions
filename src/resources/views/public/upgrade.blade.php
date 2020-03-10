@extends('subscriptions::public.master')

@section('bodyClass', 'body-subscriptions body-subscriptions-index body-page body-page-'.$page->id)

@section('title', __('Switch your subscription to another plan.'))

@section('master')

    <h1>@lang('Your account')</h1>

    @include('subscriptions::public._alerts')

    <div class="account-subscription">
        <div class="account-subscription-header">
            <h2 class="account-subscription-title">@lang('Available plans')</h2>
        </div>
        @if ($plans->count() > 0)
        <div class="account-subscription-body">
            <p>@lang('Please choose the plan you want to switch to.')</p>
        </div>
        {!! BootForm::open()->action(route($lang.'::subscriptions-upgradePost')) !!}
        @include('subscriptions::public._plans-radio-buttons')
        <div class="account-subscription-footer">
            {!! BootForm::submit(__('Switch to this plan'))->addClass('account-subscription-footer-button') !!}
            <a class="btn btn-sm btn-link text-secondary" href="{{ route($lang.'::subscriptions-profile') }}">@lang('Cancel')</a>
        </div>
        {!! BootForm::close() !!}
        @endif
    </div>
@endsection
