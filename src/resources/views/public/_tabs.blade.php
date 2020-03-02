<ul class="nav nav-tabs my-3">
    <li class="nav-item">
        <a class="nav-link {{ (Route::currentRouteName() == app()->getLocale() .'::subscriptions-profile' || Route::currentRouteName() == app()->getLocale() .'::subscriptions-profile-edit') ? 'active': '' }}" href="{{ route(app()->getLocale() .'::subscriptions-profile') }}">@lang('Profile')</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ (Route::currentRouteName() == app()->getLocale() .'::subscriptions-paymentmethod') ? 'active': '' }}" href="{{ route(app()->getLocale() .'::subscriptions-paymentmethod') }}">@lang('Payment Method')</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ (Route::currentRouteName() == app()->getLocale() .'::subscriptions-plans') ? 'active': '' }}" href="{{ route(app()->getLocale() .'::subscriptions-plans') }}">@lang('Plans')</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ (Route::currentRouteName() == app()->getLocale() .'::subscriptions-invoices') ? 'active': '' }}" href="{{ route(app()->getLocale() .'::subscriptions-invoices') }}">@lang('Invoices')</a>
    </li>
</ul>
