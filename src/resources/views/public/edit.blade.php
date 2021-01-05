@extends('core::public.master')

@section('bodyClass', 'body-subscriptions body-subscriptions-index body-page body-page-'.$page->id)

@section('title', __('Edit your profile'))

@section('content')

<div class="account-content">

    <header class="account-header">
        <div class="account-header-container">
            <h1 class="account-header-title">@lang('Edit your profile')</h1>
        </div>
    </header>

    <div class="account">

        @include('subscriptions::public._alerts')

        {!! BootForm::open() !!}
        {!! BootForm::bind(auth()->user()) !!}
        <div class="card bg-light">
            <div class="card-body">
                <div class="row gx-3">
                    <div class="col">
                        {!! BootForm::text(__('First name'), 'first_name')->required() !!}
                    </div>
                    <div class="col">
                        {!! BootForm::text(__('Last name'), 'last_name')->required() !!}
                    </div>
                </div>
                <div class="row gx-3">
                    <div class="col">
                        {!! BootForm::text(__('Street'), 'street')->required() !!}
                    </div>
                    <div class="col-md-2">
                        {!! BootForm::text(__('Number'), 'number')->required() !!}
                    </div>
                    <div class="col-md-2">
                        {!! BootForm::text(__('Box'), 'box') !!}
                    </div>
                </div>
                {!! BootForm::text(__('City'), 'city')->required() !!}
                <div class="row gx-3">
                    <div class="col">
                        {!! BootForm::text(__('Zip'), 'zip')->required() !!}
                    </div>
                    <div class="col">
                        {!! BootForm::text(__('Country'), 'country')->required() !!}
                    </div>
                </div>
                {!! BootForm::submit(__('Save')) !!}
                <a class="btn btn-link text-secondary" href="{{ route($lang.'::subscriptions-profile') }}">@lang('Cancel')</a>
                {!! BootForm::close() !!}
            </div>
        </div>

    </div>

</div>

@endsection
