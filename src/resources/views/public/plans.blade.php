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

    <div class="container">
        <div class="card-deck mb-3 text-center">
            @foreach ($plans as $name => $plan)
                <div class="card mb-4 shadow-sm">
                    <div class="card-header">
                        <h4 class="my-0 font-weight-normal">{{ ucfirst(__($name)) }}</h4>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h1 class="card-title pricing-card-title">{{ Subscriber::planPriceFormat($plan['amount']['value'], auth()->user()->taxPercentage(), $plan['amount']['currency'], auth()->user()->getLocale()) }} <small class="text-muted d-inline-block">@lang('/ '.$plan['interval'])</small></h1>
                        <p class="mt-3 mb-4 flex-grow-1">@lang($plan['description'])</p>
                        @if($user->subscribed('main', $name))
                            <button type="button" class="btn btn-lg btn-block btn-outline-primary disabled">@lang('Current subscription')</button>
                        @else
                            @if($user->subscribed('main'))
                                {!! BootForm::open()->action(route($lang.'::subscriptions-upgrade')) !!}
                                {!! BootForm::hidden('plan')->value($name) !!}
                                <button type="submit" class="btn btn-lg btn-block btn-primary">@lang('Switch to this plan')</button>
                                {!! BootForm::close() !!}
                            @else
                                {!! BootForm::open()->action(route($lang.'::subscriptions-subscribe')) !!}
                                {!! BootForm::hidden('plan')->value($name) !!}
                                <button type="submit" class="btn btn-lg btn-block btn-primary">@lang('I subscribe')</button>
                                {!! BootForm::close() !!}
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <p class="text-center mb-5"><a class="btn btn-light" href="{{ route($lang.'::subscriptions-profile') }}">@lang('I will subscribe later')</a></p>

    </div>

</div>

@endsection
