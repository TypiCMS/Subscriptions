<div class="account-profile">
    <div class="account-profile-header">
        <h2 class="account-profile-title">@lang('Your contact details')</h2>
    </div>
    <ul class="account-profile-list">
        <li class="account-profile-item">
            <span class="account-profile-item-label">@lang('Name')</span>
            <span class="account-profile-item-value">{{ $user->first_name }} {{ $user->last_name }}</span>
        </li>
        <li class="account-profile-item">
            <span class="account-profile-item-label">@lang('Email')</span>
            <span class="account-profile-item-value">{{ $user->email }}</span>
        </li>
        <li class="account-profile-item">
            <span class="account-profile-item-label">@lang('Address')</span>
            <address class="account-profile-item-value">
                {{ $user->street }} {{ $user->number }} {{ $user->box }}<br/>
                {{ $user->zip }} {{ $user->city }}<br/>
                {{ $user->country }}
            </address>
        </li>
    </ul>
    <div class="account-profile-footer">
        <a class="account-profile-edit-button" href="{{ route(app()->getLocale().'::subscriptions-profile-edit') }}">@lang('Edit')</a>
    </div>
</div>
