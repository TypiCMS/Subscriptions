@extends('pages::public.master')

@section('bodyClass', 'body-subscriptions body-subscriptions-index body-page body-page-'.$page->id)

@section('title', __('Edit your profile'))


@section('content')

    @include('subscriptions::public.tabs')
    @include('subscriptions::public.alerts')

    <div class="rich-content">{!! $page->present()->body !!}</div>

    {!! BootForm::open() !!}
    {!! BootForm::bind(auth()->user()) !!}
    <div class="row">
        <div class="col">
            {!! BootForm::text(__('First Name'), 'first_name')->required() !!}
        </div>
        <div class="col">
            {!! BootForm::text(__('Last Name'), 'last_name')->required() !!}
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
    {!! BootForm::close() !!}

    @include('files::public._documents', ['model' => $page])
    @include('files::public._images', ['model' => $page])

@endsection
