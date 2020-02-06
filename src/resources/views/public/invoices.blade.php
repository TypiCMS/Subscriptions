@extends('pages::public.master')

@section('bodyClass', 'body-subscriptions body-subscriptions-index body-page body-page-'.$page->id)

@section('title', __('Invoices'))

@section('content')

    @include('subscriptions::public._partials.tabs')
    @include('subscriptions::public._partials.alerts')

    <div class="rich-content">{!! $page->present()->body !!}</div>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Date</th>
            <th scope="col">Amount</th>
            <th scope="col">View</th>
        </tr>
        </thead>
        <tbody>
        @foreach($invoices as $invoice)
            <tr>
                <th scope="row">{{ $invoice->id() }}</th>
                <td>{{ $invoice->date() }}</td>
                <td>{{ $invoice->total() }}</td>
                <td><a href="{{ route(app()->getLocale() .'::subscriptions-invoice', $invoice->id()) }}" target="_blank" class="btn btn-sm btn-outline-primary">View</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @include('files::public._documents', ['model' => $page])
    @include('files::public._images', ['model' => $page])

    @include('subscriptions::public._itemlist-json-ld', ['items' => $models])

    @includeWhen($models->count() > 0, 'subscriptions::public._list', ['items' => $models])

@endsection
