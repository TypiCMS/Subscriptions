@extends('core::admin.master')

@section('title', __('Subscriptions'))

@section('content')

<item-list
    url-base="/api/subscriptions"
    locale="{{ config('typicms.content_locale') }}"
    fields="*"
    table="subscriptions"
    title="subscriptions"
    include="owner"
    :searchable="['plan', 'status']"
    :sorting="['plan']">

{{--    <template slot="add-button">--}}
{{--        @include('core::admin._button-create', ['module' => 'subscriptions'])--}}
{{--    </template>--}}

    <template slot="columns" slot-scope="{ sortArray }">
{{--        <item-list-column-header name="checkbox"></item-list-column-header>--}}
        <item-list-column-header name="name" sortable :sort-array="sortArray" :label="$t('Subscription')"></item-list-column-header>
        <item-list-column-header name="plan" sortable :sort-array="sortArray" :label="$t('Plan')"></item-list-column-header>
        <item-list-column-header name="owner.first_name" :label="$t('First Name')"></item-list-column-header>
        <item-list-column-header name="owner.last_name" :label="$t('Last Name')"></item-list-column-header>
        <item-list-column-header name="status" :label="$t('Status')"></item-list-column-header>
    </template>

    <template slot="table-row" slot-scope="{ model, checkedModels, loading }">
{{--        <td class="checkbox"><item-list-checkbox :model="model" :checked-models-prop="checkedModels" :loading="loading"></item-list-checkbox></td>--}}
{{--        <td>@include('core::admin._button-edit', ['module' => 'subscriptions'])</td>--}}
        <td>@{{ model.name }}</td>
        <td>@{{ model.plan }}</td>
        <td>@{{ model.owner.first_name}}</td>
        <td>@{{ model.owner.last_name}}</td>
        <td>@{{ model.status}}</td>
    </template>

</item-list>

@endsection
