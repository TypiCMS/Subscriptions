@extends('pages::public.master')

@section('bodyClass', 'body-subscriptions body-subscriptions-index body-page body-page-'.$page->id)

@section('title', __('Plans'))

@section('content')

    @include('subscriptions::public.tabs')
    @include('subscriptions::public.alerts')

    <div class="rich-content">{!! $page->present()->body !!}</div>

    <h1>@lang('Plans')</h1>

    @if(auth()->user()->subscribed('main'))
        @if(auth()->user()->subscription('main')->onGracePeriod())
            <p>@lang('Your subscription to the :name plan was cancelled. You still have access to it until :ends_at.', ['name' => auth()->user()->subscription('main')->plan, 'ends_at' => auth()->user()->subscription('main')->ends_at])</p>
            <p><a href="{{ route(app()->getLocale() .'::subscriptions-resume') }}">@lang('Resume your subscription to the :name plan.', ['name' => auth()->user()->subscription('main')->plan])</a></p>
        @elseif(auth()->user()->subscription('main')->cancelled())
            <p>@lang('Your subscription to the :name plan was cancelled.', ['name' => auth()->user()->subscription('main')->plan])</p>
        @else
            <p>@lang('You are subscribed to the :name plan.', ['name' => auth()->user()->subscription('main')->plan])</p>
            <p><a href="{{ route(app()->getLocale() .'::subscriptions-upgrade') }}">@lang('Upgrade your subscription to another plan.')</a></p>
            <p><a href="{{ route(app()->getLocale() .'::subscriptions-cancel') }}">@lang('Cancel your subscription to the :name plan.', ['name' => auth()->user()->subscription('main')->plan])</a></p>
        @endif
    @else
        {!! BootForm::open() !!}
        <ul>
            @foreach($plans as $name => $plan)
                {!! BootForm::radio(ucfirst($name) . ' '. $plan['description'] .' <span class="text-muted small">'. $plan['amount']['value'] . ' ' . $plan['amount']['currency'] .' '. __('each') . ' ' . $plan['interval'] . '</span>', 'plan', $name) !!}
            @endforeach
        </ul>
        {!! BootForm::submit(__('Subscribe')) !!}
        {!! BootForm::close() !!}
    @endif

    @include('files::public._documents', ['model' => $page])
    @include('files::public._images', ['model' => $page])

    @include('subscriptions::public._itemlist-json-ld', ['items' => $models])

    @includeWhen($models->count() > 0, 'subscriptions::public._list', ['items' => $models])

@endsection
