@extends('core::admin.master')

@section('title', __('New subscription'))

@section('content')

    <div class="header">
        @include('core::admin._button-back', ['module' => 'subscriptions'])
        <h1 class="header-title">@lang('New subscription')</h1>
    </div>

    {!! BootForm::open()->action(route('admin::index-subscriptions'))->multipart()->role('form') !!}
        @include('subscriptions::admin._form')
    {!! BootForm::close() !!}

@endsection
