@extends('subscriptions::public.master')

@section('bodyClass', 'body-subscriptions body-subscriptions-index body-page body-page-'.$page->id)

@section('title', __('Your profile'))

@section('master')

    <div class="rich-content">{!! $page->present()->body !!}</div>
    @include('files::public._documents', ['model' => $page])
    @include('files::public._images', ['model' => $page])

    @include('subscriptions::public._tabs')
    @include('subscriptions::public._alerts')

    <p class="profile-name">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</p>

    <p class="profile-email">{{ auth()->user()->email }}</p>

    <p class="profile-address">
        {{ auth()->user()->street }} {{ auth()->user()->number }}<br/>
        {{ auth()->user()->zip }} {{ auth()->user()->city }}<br/>
        {{ auth()->user()->country }}
    </p>

    <a class="profile-submit-button btn btn-primary" href="{{ route(app()->getLocale() .'::subscriptions-profile-edit') }}">@lang('Edit my profile')</a>

@endsection
