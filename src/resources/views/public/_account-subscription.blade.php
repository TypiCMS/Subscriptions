<div class="account-subscription">
    <div class="account-subscription-header">
        <h2 class="account-subscription-title">@lang('Your subscription')</h2>
    </div>
    @if ($user->subscribed('main'))

        @if ($user->subscription('main')->onGracePeriod())
            <div class="account-subscription-body">
                <p>@lang('Your subscription to the :name plan was cancelled. You still have access to it until :ends_at.', ['name' => __($user->subscription('main')->plan), 'ends_at' => strtolower($user->subscription('main')->ends_at->formatLocalized('%A %d %B %Y'))])</p>
            </div>
            <div class="account-subscription-footer">
                <a class="account-subscription-footer-button" href="{{ route($lang.'::subscriptions-resume') }}">@lang('Resume your subscription to the :name plan.', ['name' => __($user->subscription('main')->plan)])</a>
            </div>
        @elseif ($user->subscription('main')->cancelled())
            <div class="account-subscription-body">
                <p>@lang('Your subscription to the :name plan was cancelled.', ['name' => __($user->subscription('main')->plan)])</p>
            </div>
        @else
            <div class="account-subscription-body">
                <p>@lang('You are subscribed to the :name plan.', ['name' => __($user->subscription('main')->plan)])</p>
                <p><a class="small text-danger" onclick="return confirm('@lang('Are you sure you want to cancel your subscription to :name?', ['name' => __($user->subscription('main')->plan)])')" href="{{ route($lang.'::subscriptions-cancel') }}">@lang('Cancel my subscription.')</a></p>
            </div>
            <div class="account-subscription-footer">
                <a class="account-subscription-edit-button" href="{{ route($lang.'::subscriptions-plans') }}">@lang('Switch your subscription to another plan.')</a>
            </div>
        @endif
    @else
        @if ($plans->count() > 0)
        <div class="account-subscription-body">
            <p class="text-muted">@lang('You are not currently subscribed to any plan.')</p>
            <p><a class="btn btn-sm btn-primary" href="{{ route($lang.'::subscriptions-plans') }}">@lang('I subscribe')</a></p>
        </div>
        @endif
    @endif
</div>
