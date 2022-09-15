@extends('core::public.master')

@section('bodyClass', 'body-subscriptions body-subscriptions-index body-page body-page-'.$page->id)

@section('title', $page->title)

@section('content')

<div class="account-content">

    <header class="account-header">
        <div class="account-header-container">
            <h1 class="account-header-title">{{ $page->title }}</h1>
        </div>
    </header>

    <div class="account">

        <div class="rich-content">{!! $page->present()->body !!}</div>
        @include('files::public._document-list', ['model' => $page])
        @include('files::public._image-list', ['model' => $page])

        @include('subscriptions::public._alerts')

        @if (!auth()->user()->hasVerifiedEmail())
            @if (session('resent'))
                <div class="alert alert-success" role="alert">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @else
                <div class="account-verification">
                    <div class="account-verification-header bg-danger">
                        <h2 class="account-verification-title">@lang('Verify Your Email Address')</h2>
                    </div>
                    <div class="account-verification-body">
                        {{ __('Before proceeding, please check your email for a verification link.') }}
                        {{ __('If you did not receive the email') }}, <a href="{{ route(app()->getLocale().'::verification.resend') }}">{{ __('click here to request another') }}</a>.
                    </div>
                </div>
            @endif
        @endif

        <div class="row">
            <div class="col-md-8">
                @include('subscriptions::public._account-subscription')
                @include('subscriptions::public._account-invoices')
            </div>
            <div class="col-md-4">
                @include('subscriptions::public._account-profile')
            </div>
        </div>

    </div>

</div>

@endsection
