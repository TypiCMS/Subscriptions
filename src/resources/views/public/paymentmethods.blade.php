@extends('pages::public.master')

@section('bodyClass', 'body-subscriptions body-subscriptions-index body-page body-page-'.$page->id)

@section('title', __('Payment Method'))

@section('content')

    @include('subscriptions::public.tabs')
    @include('subscriptions::public.alerts')

    <div class="rich-content">{!! $page->present()->body !!}</div>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Type</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($activeMandates as $mandate)
            <tr>
                <th scope="row">{{ $mandate->id }}</th>
                <td>{{ $mandate->method }}</td>
                <td><a href="{{ route(app()->getLocale() .'::subscriptions-paymentmethod-revoke', $mandate->id) }}" class="btn btn-sm btn-outline-danger">Remove</a></td>
            </tr>
        @endforeach
        @if($activeMandates->count() == 0)
            <tr>
                <td colspan="4" class="text-center text-muted">@lang('There is no payment method available.')</td>
            </tr>
        @endif
        </tbody>
    </table>

    @include('files::public._documents', ['model' => $page])
    @include('files::public._images', ['model' => $page])

    @include('subscriptions::public._itemlist-json-ld', ['items' => $models])

    @includeWhen($models->count() > 0, 'subscriptions::public._list', ['items' => $models])

@endsection
