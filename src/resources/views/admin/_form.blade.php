<div class="btn-toolbar mb-4">
    {{-- <button class="btn btn-sm btn-primary mr-2" value="true" id="exit" name="exit" type="submit">{{ __('Save and exit') }}</button>
    <button class="btn btn-sm btn-light mr-2" type="submit">{{ __('Save') }}</button> --}}
</div>

{!! BootForm::hidden('id') !!}

<table class="table table-sm table-striped">
    <tr><th>@lang('Plan')</th> <td>{{ $model->plan }}</td></tr>
    <tr><th>@lang('Member')</th> <td>{{ $model->owner->first_name }} {{ $model->owner->last_name }}</td></tr>
    {{-- <tr><th>@lang('Next plan')</th> <td>{{ $model->next_plan }}</td></tr> --}}
    {{-- <tr><th>@lang('Quantity')</th> <td>{{ $model->quantity }}</td></tr> --}}
    {{-- <tr><th>@lang('Tax percentage')</th> <td>{{ $model->tax_percentage }}</td></tr> --}}
    <tr><th>@lang('Ends at')</th> <td>{{ $model->ends_at !== null ? Carbon\Carbon::create($model->ends_at)->format('d.m.Y H:i:s') : __('Never') }}</td></tr>
    {{-- <tr><th>@lang('Trial ends at')</th> <td>{{ $model->trial_ends_at !== null ? Carbon\Carbon::create($model->trial_ends_at)->format('d.m.Y H:i:s') : '' }}</td></tr> --}}
    <tr><th>@lang('Start of the cycle')</th> <td>{{ $model->cycle_started_at !== null ? Carbon\Carbon::create($model->cycle_started_at)->format('d.m.Y H:i:s') : '' }}</td></tr>
    <tr><th>@lang('End of the cycle')</th> <td>{{ $model->cycle_ends_at !== null ? Carbon\Carbon::create($model->cycle_ends_at)->format('d.m.Y H:i:s') : '' }}</td></tr>
    {{-- <tr><th>@lang('Scheduled order item id')</th> <td>{{ $model->scheduled_order_item_id }}</td></tr> --}}
    <tr><th>@lang('Status')</th> <td>{{ $model->status }}</td></tr>
</table>
