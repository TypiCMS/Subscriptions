@extends('pages::public.master')

@section('bodyClass', 'body-subscriptions body-subscriptions-index body-page body-page-'.$page->id)

@section('title', __('Your profile'))

@section('content')

    @include('subscriptions::public.tabs')
    @include('subscriptions::public.alerts')

    <div class="rich-content">{!! $page->present()->body !!}</div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title text-capitalize">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h5>

            <p class="card-subtitle text-muted mb-3">{{ auth()->user()->email }}</p>

            <p class="card-text">
                {{ auth()->user()->street }} {{ auth()->user()->number }}<br/>
                {{ auth()->user()->zip }} {{ auth()->user()->city }}<br/>
                {{ auth()->user()->country }}
            </p>

            <a class="card-link" href="{{ route(app()->getLocale() .'::subscriptions-profile-edit') }}">@lang('Edit my profile')</a>
        </div>
    </div>

    @include('files::public._documents', ['model' => $page])
    @include('files::public._images', ['model' => $page])

    @include('subscriptions::public._itemlist-json-ld', ['items' => $models])

    @includeWhen($models->count() > 0, 'subscriptions::public._list', ['items' => $models])

@endsection
