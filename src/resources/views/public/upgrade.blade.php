@extends('pages::public.master')

@section('bodyClass', 'body-subscriptions body-subscriptions-index body-page body-page-'.$page->id)

@section('title', __('Plans'))

@section('content')

    @include('subscriptions::public.tabs')
    @include('subscriptions::public.alerts')

    <div class="rich-content">{!! $page->present()->body !!}</div>

    <h1>@lang('Available plans')</h1>
    <p>@lang('Please choose the plan you want to upgrade to.')</p>

    {!! BootForm::open()->action(route(app()->getLocale() .'::subscriptions-upgradePost')) !!}
    <ul>
        @foreach($plans as $name => $plan)
            {!! BootForm::radio(ucfirst($name) . ' '. $plan['description'] .' <span class="text-muted small">'. $plan['amount']['value'] . ' ' . $plan['amount']['currency'] .' '. __('each') . ' ' . $plan['interval'] . '</span>', 'plan', $name) !!}
        @endforeach
    </ul>
    {!! BootForm::submit(__('Upgrade to this plan')) !!}
    {!! BootForm::close() !!}


    @include('files::public._documents', ['model' => $page])
    @include('files::public._images', ['model' => $page])

@endsection
