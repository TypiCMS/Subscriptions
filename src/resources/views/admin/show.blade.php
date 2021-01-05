@extends('core::admin.master')

@section('title', $model->present()->title)

@section('content')

    <div class="header">
        @include('core::admin._button-back', ['module' => 'subscriptions'])
        <h1 class="header-title @if (!$model->present()->title)text-muted @endif">
            {{ $model->present()->title ?: __('Untitled') }}
        </h1>
    </div>

    <div class="btn-toolbar mb-4">
        @if($model->status === 'active')
            {!! BootForm::open()->action(route('admin::cancel-subscription', $model)) !!}
                <button class="btn btn-sm btn-danger me-2" type="submit">@lang('Cancel the subscription')</button>
            {!! BootForm::close() !!}
        @else
            {!! BootForm::open()->action(route('admin::resume-subscription', $model)) !!}
                <button class="btn btn-sm btn-success me-2" type="submit">@lang('Resume the subscription')</button>
            {!! BootForm::close() !!}
        @endif
    </div>

    {!! BootForm::hidden('id') !!}

    <table class="table table-sm table-striped">
        <tr><th>@lang('Plan')</th> <td>@lang($model->plan)</td></tr>
        <tr><th>@lang('Member')</th> <td>{{ $model->owner->first_name }} {{ $model->owner->last_name }}</td></tr>
        <tr><th>@lang('Next plan')</th> <td>{{ $model->next_plan }}</td></tr>
        {{-- <tr><th>@lang('Quantity')</th> <td>{{ $model->quantity }}</td></tr> --}}
        <tr><th>@lang('Tax percentage')</th> <td>{{ $model->tax_percentage }}</td></tr>
        <tr><th>@lang('Ends at')</th> <td>{{ $model->ends_at !== null ? Carbon\Carbon::create($model->ends_at)->format('d.m.Y H:i:s') : __('Never') }}</td></tr>
        <tr><th>@lang('Trial ends at')</th> <td>{{ $model->trial_ends_at !== null ? Carbon\Carbon::create($model->trial_ends_at)->format('d.m.Y H:i:s') : '' }}</td></tr>
        <tr><th>@lang('Start of the cycle')</th> <td>{{ $model->cycle_started_at !== null ? Carbon\Carbon::create($model->cycle_started_at)->format('d.m.Y H:i:s') : '' }}</td></tr>
        <tr><th>@lang('End of the cycle')</th> <td>{{ $model->cycle_ends_at !== null ? Carbon\Carbon::create($model->cycle_ends_at)->format('d.m.Y H:i:s') : '' }}</td></tr>
        {{-- <tr><th>@lang('Scheduled order item id')</th> <td>{{ $model->scheduled_order_item_id }}</td></tr> --}}
        <tr><th>@lang('Status')</th> <td>{{ $model->status }}</td></tr>
    </table>

@endsection
