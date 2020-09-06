<div class="account-profile">
    <div class="account-profile-header">
        <h2 class="account-profile-title">@lang('Your contact details')</h2>
    </div>
    <div class="account-profile-body">
        <p class="account-profile-item">
            <span class="account-profile-item-label">@lang('Name')</span><br>
            <span class="account-profile-item-value">{{ $user->first_name }} {{ $user->last_name }}</span>
        </p>
        <p class="account-profile-item">
            <span class="account-profile-item-label">@lang('Email')</span><br>
            <span class="account-profile-item-value">{{ $user->email }}</span>
        </p>
        <p class="account-profile-item">
            <span class="account-profile-item-label">@lang('Address')</span><br>
            <span class="account-profile-item-value">
                {{ $user->street }} {{ $user->number }} {{ $user->box }}<br/>
                {{ $user->zip }} {{ $user->city }}<br/>
                {{ $user->country }}
            </span>
        </p>
        <a class="account-profile-button btn btn-sm btn-secondary" href="{{ route(app()->getLocale().'::subscriptions-profile-edit') }}"><span class="fa fa-fw fa-pencil"></span> @lang('Edit')</a>
    </div>
</div>
