@extends('core::public.master')

@section('bodyClass', 'body-subscriptions body-subscriptions-index body-page body-page-'.$page->id)

@section('title', $page->title)

@section('content')

    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
        <h1 class="display-4">@lang('Subscriptions')</h1>
        <p class="lead">@lang('Quickly build an effective pricing table for your potential customers with this template.')</p>
    </div>
    <div class="container">
        <div class="card-deck mb-3 text-center">
            @foreach ($plans as $name => $plan)
                <div class="card mb-4 shadow-sm">
                    <div class="card-header">
                        <h4 class="my-0 font-weight-normal">{{ ucfirst(__($name)) }}</h4>
                    </div>
                    <div class="card-body">
                        <h1 class="card-title pricing-card-title">{{ Subscriber::planPriceFormat($plan['amount']['value'], auth()->user()->taxPercentage(), $plan['amount']['currency'], auth()->user()->getLocale()) }} <small class="text-muted d-inline-block">/ {{ $plan['interval'] }}</small></h1>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li>@lang($plan['description'])</li>
                        </ul>
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
                                <button type="submit" class="btn btn-lg btn-block btn-primary">@lang('Subscribe')</button>
                                {!! BootForm::close() !!}
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
