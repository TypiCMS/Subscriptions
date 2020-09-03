@extends('core::public.master')

@section('bodyClass', 'body-subscriptions body-subscriptions-index body-page body-page-'.$page->id)

@section('title', $page->title)

@section('content')

<div class="account-content">

    <header class="account-header">
        <div class="account-header-container">
            <h1 class="text-center account-header-title">@lang('Your subscription')</h1>
        </div>
    </header>

    <div class="mt-5 mb-5 mx-auto text-center">
        <p>@lang('Please choose the affiliation that best suits you.')</p>
    </div>

    <div class="plan-list-container">
        <div class="plan-list-list">
            @foreach ($plans as $name => $plan)
            <div class="plan-list-item">
                <div class="plan-list-item-card">
                    <div class="plan-list-item-header">
                        <h2 class="plan-list-item-title">{{ ucfirst(__($name)) }}</h2>
                    </div>
                    <div class="plan-list-item-body">
                        <p class="plan-list-item-price">{{ Subscriber::planPriceFormat($plan['amount']['value'], auth()->user()->taxPercentage(), $plan['amount']['currency'], auth()->user()->getLocale()) }} <small class="plan-list-item-duration">@lang('/ '.$plan['interval'])</small></p>
                        <p class="plan-list-item-description">@lang($plan['description'])</p>
                        @if($user->subscribed('main', $name))
                            <button class="plan-list-item-button" type="button" disabled>@lang('Current subscription')</button>
                        @else
                            @if($user->subscribed('main'))
                                {!! BootForm::open()->action(route($lang.'::subscriptions-upgrade')) !!}
                                {!! BootForm::hidden('plan')->value($name) !!}
                                <button class="plan-list-item-button" type="submit">@lang('Switch to this plan')</button>
                                {!! BootForm::close() !!}
                            @else
                                {!! BootForm::open()->action(route($lang.'::subscriptions-subscribe')) !!}
                                {!! BootForm::hidden('plan')->value($name) !!}
                                <button class="plan-list-item-button" type="submit">@lang('I subscribe')</button>
                                {!! BootForm::close() !!}
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <p class="text-center mb-5">
            <a class="btn btn-light" href="{{ route($lang.'::subscriptions-profile') }}">
                @if($user->subscribed('main'))
                    @lang('Cancel')
                @else
                    @lang('I will subscribe later')
                @endif
            </a>
        </p>

    </div>

</div>

@endsection
