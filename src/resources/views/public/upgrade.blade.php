@extends('subscriptions::public.master')

@section('bodyClass', 'body-subscriptions body-subscriptions-index body-page body-page-'.$page->id)

@section('title', __('Upgrade your subscription to another plan.'))

@section('master')

    <div class="rich-content">{!! $page->present()->body !!}</div>
    @include('files::public._documents', ['model' => $page])
    @include('files::public._images', ['model' => $page])

    @include('subscriptions::public._alerts')

    <h1>@lang('Available plans')</h1>
    <p>@lang('Please choose the plan you want to upgrade to.')</p>

    {!! BootForm::open()->action(route(app()->getLocale() .'::subscriptions-upgradePost')) !!}
    <ul>
        @foreach($plans as $name => $plan)
            {!! BootForm::radio(ucfirst($name) . ' '. $plan['description'] .' <span class="text-muted small">'. $plan['amount']['value'] . ' ' . $plan['amount']['currency'] .' '. __('each') . ' ' . $plan['interval'] . '</span>', 'plan', $name) !!}
        @endforeach
    </ul>
    {!! BootForm::submit(__('Upgrade to this plan')) !!}
    <a class="btn btn-link text-secondary" href="{{ route($lang.'::subscriptions-profile') }}">@lang('Cancel')</a>
    {!! BootForm::close() !!}

@endsection
