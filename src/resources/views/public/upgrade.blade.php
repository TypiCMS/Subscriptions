@extends('subscriptions::public.master')

@section('bodyClass', 'body-subscriptions body-subscriptions-index body-page body-page-'.$page->id)

@section('title', __('Switch your subscription to another plan.'))

@section('master')

    <h1>@lang('Available plans')</h1>
    <p>@lang('Please choose the plan you want to switch to.')</p>

    @include('subscriptions::public._alerts')

    {!! BootForm::open()->action(route(app()->getLocale() .'::subscriptions-upgradePost')) !!}
    <ul>
        @foreach($plans as $name => $plan)
            {!! BootForm::radio(ucfirst($name) . ' '. $plan['description'] .' <span class="text-muted small">'. Subscriber::planPriceFormat($plan['amount']['value'], auth()->user()->taxPercentage(), $plan['amount']['currency']) .' '. __('each') . ' ' . $plan['interval'] . '</span>', 'plan', $name) !!}
        @endforeach
    </ul>
    {!! BootForm::submit(__('Switch to this plan')) !!}
    <a class="btn btn-link text-secondary" href="{{ route($lang.'::subscriptions-profile') }}">@lang('Cancel')</a>
    {!! BootForm::close() !!}

@endsection
