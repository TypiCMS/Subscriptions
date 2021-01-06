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
                {{ $user->postal_code }} {{ $user->city }}<br/>
                {{ $user->country }}
            </span>
        </p>
        <a class="account-profile-button btn btn-sm btn-secondary" href="{{ route(app()->getLocale().'::subscriptions-profile-edit') }}">
            <svg class="mr-1" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
            </svg> @lang('Edit')
        </a>
    </div>
</div>
