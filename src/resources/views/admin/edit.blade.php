@extends('core::admin.master')

@section('title', $model->present()->title)

@section('content')

    <div class="header">
        @include('core::admin._button-back', ['module' => 'subscriptions'])
        <h1 class="header-title @if (!$model->present()->title)text-muted @endif">
            {{ $model->present()->title ?: __('Untitled') }}
        </h1>
    </div>

    @include('subscriptions::public._alerts')

    {!! BootForm::open()->put()->action(route('admin::cancel-subscription', $model->id))->role('form') !!}
    {!! BootForm::bind($model) !!}
        @include('subscriptions::admin._form')
    {!! BootForm::close() !!}

@endsection
