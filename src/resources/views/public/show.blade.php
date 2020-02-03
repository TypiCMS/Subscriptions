@extends('core::public.master')

@section('title', $model->title.' – '.__('Subscriptions').' – '.$websiteTitle)
@section('ogTitle', $model->title)
@section('description', $model->summary)
@section('image', $model->present()->image())
@section('bodyClass', 'body-subscriptions body-subscription-'.$model->id.' body-page body-page-'.$page->id)

@section('content')

    @include('core::public._btn-prev-next', ['module' => 'Subscriptions', 'model' => $model])

    @include('subscriptions::public._json-ld', ['subscription' => $model])

    <article class="subscription">
        <h1 class="subscription-title">{{ $model->title }}</h1>
        <img class="subscription-image" src="{!! $model->present()->image(null, 200) !!}" alt="">
        <p class="subscription-summary">{!! nl2br($model->summary) !!}</p>
        <div class="subscription-body">{!! $model->present()->body !!}</div>
        @include('files::public._documents')
        @include('files::public._images')
    </article>

@endsection
