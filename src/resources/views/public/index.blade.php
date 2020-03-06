@extends('subscriptions::public.master')

@section('bodyClass', 'body-subscriptions body-subscriptions-index body-page body-page-'.$page->id)

@section('title', __('Your account'))

@section('master')

    <h1>@lang('Your account')</h1>

    <div class="rich-content">{!! $page->present()->body !!}</div>
    @include('files::public._documents', ['model' => $page])
    @include('files::public._images', ['model' => $page])

    @include('subscriptions::public._alerts')

    <div class="account">

        <div class="account-row">
            <div class="account-column">
                @include('subscriptions::public._account-profile')
            </div>
            <div class="account-column">
                @include('subscriptions::public._account-subscription')
            </div>
            <div class="account-column">
                @include('subscriptions::public._account-payment-method')
            </div>
            <div class="account-column">
                @include('subscriptions::public._account-invoices')
            </div>
        </div>

    </div>

@endsection
