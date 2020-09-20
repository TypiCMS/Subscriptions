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
    :selector="false"
    :actions="false"
    :multilingual="false"
    :searchable="['plan']"
    :sorting="['plan']">

    <template slot="columns" slot-scope="{ sortArray }">
        <item-list-column-header name="edit" v-if="$can('read subscriptions')"></item-list-column-header>
        <item-list-column-header name="created_at" sortable :sort-array="sortArray" :label="$t('Date')"></item-list-column-header>
        <item-list-column-header name="owner.first_name" :label="$t('First name')"></item-list-column-header>
        <item-list-column-header name="owner.last_name" :label="$t('Last name')"></item-list-column-header>
        <item-list-column-header name="plan" sortable :sort-array="sortArray" :label="$t('Plan')"></item-list-column-header>
        <item-list-column-header name="status" :label="$t('Status')"></item-list-column-header>
    </template>

    <template slot="table-row" slot-scope="{ model, checkedModels, loading }">
        <td v-if="$can('read subscriptions')">@include('core::admin._button-show', ['module' => 'subscriptions'])</td>
        <td>@{{ model.created_at | date }}</td>
        <td>@{{ model.owner.first_name}}</td>
        <td>@{{ model.owner.last_name}}</td>
        <td>@{{ model.plan }}</td>
        <td>
            <span v-if="model.status === 'active'" class="badge badge-success">@{{ model.status}}</span>
            <span v-else class="badge badge-light">@{{ model.status}}</span>
        </td>
    </template>

</item-list>

@endsection
