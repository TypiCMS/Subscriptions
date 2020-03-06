@extends('subscriptions::public.master')

@section('bodyClass', 'body-subscriptions body-subscriptions-index body-page body-page-'.$page->id)

@section('title', __('Edit your profile'))


@section('master')

    @include('subscriptions::public._alerts')

    <h1>@lang('Edit your profile')</h1>

    {!! BootForm::open() !!}
    {!! BootForm::bind(auth()->user()) !!}
    <div class="card bg-light">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    {!! BootForm::text(__('First name'), 'first_name')->required() !!}
                </div>
                <div class="col">
                    {!! BootForm::text(__('Last name'), 'last_name')->required() !!}
                </div>
            </div>
            <div class="row">
                <div class="col">
                    {!! BootForm::text(__('Street'), 'street')->required() !!}
                </div>
                <div class="col-md-3">
                    {!! BootForm::text(__('Number'), 'number')->required() !!}
                </div>
            </div>
            {!! BootForm::text(__('City'), 'city')->required() !!}
            <div class="row">
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

@endsection
