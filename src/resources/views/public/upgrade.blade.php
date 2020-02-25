@extends('pages::public.master')

@section('bodyClass', 'body-subscriptions body-subscriptions-index body-page body-page-'.$page->id)

@section('title', __('Plans'))

@section('content')

    @include('subscriptions::public._partials.tabs')
    @include('subscriptions::public._partials.alerts')

    <div class="rich-content">{!! $page->present()->body !!}</div>

    <h1>{{ __('Available plans') }}</h1>
    <p>{{ __('Please choose the plan you want to upgrade to.') }}</p>

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

    @include('subscriptions::public._itemlist-json-ld', ['items' => $models])

    @includeWhen($models->count() > 0, 'subscriptions::public._list', ['items' => $models])

@endsection
