@extends('pages::public.master')

@section('bodyClass', 'body-subscriptions body-subscriptions-index body-page body-page-'.$page->id)

@section('content')

    <div class="rich-content">{!! $page->present()->body !!}</div>

    @include('files::public._documents', ['model' => $page])
    @include('files::public._images', ['model' => $page])

    @include('subscriptions::public._itemlist-json-ld', ['items' => $models])

    @includeWhen($models->count() > 0, 'subscriptions::public._list', ['items' => $models])

@endsection
