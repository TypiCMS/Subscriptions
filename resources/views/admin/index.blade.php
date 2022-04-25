@extends('core::admin.master')

@section('title', __('Subscriptions'))

@section('content')

<item-list
    url-base="/api/subscriptions"
    fields="*"
    table="subscriptions"
    title="subscriptions"
    include="owner"
    :selector="false"
    :actions="false"
    :translatable="false"
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
        <td v-if="$can('read subscriptions')"><item-list-show-button :url="'/admin/subscriptions/'+model.id"></item-list-show-button></td>
        <td>@{{ model.created_at | date }}</td>
        <td>@{{ model.owner.first_name}}</td>
        <td>@{{ model.owner.last_name}}</td>
        <td>@{{ model.plan }}</td>
        <td>
            <span v-if="model.status === 'active'" class="badge bg-success">@{{ model.status}}</span>
            <span v-else class="badge bg-light">@{{ model.status}}</span>
        </td>
    </template>

</item-list>

@endsection
