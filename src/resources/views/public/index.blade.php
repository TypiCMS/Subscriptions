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
        @include('files::public._documents', ['model' => $page])
        @include('files::public._images', ['model' => $page])

        @include('subscriptions::public._alerts')

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
