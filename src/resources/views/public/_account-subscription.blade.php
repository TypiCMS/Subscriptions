<div class="account-subscription">
    <div class="account-subscription-header">
        <h2 class="account-subscription-title">@lang('Subscription')</h2>
    </div>
    @if ($user->subscribed('main'))

        @if ($user->subscription('main')->onGracePeriod())
            <div class="account-subscription-body">
                <p>@lang('Your subscription to the :name plan was cancelled. You still have access to it until :ends_at.', ['name' => $user->subscription('main')->plan, 'ends_at' => strtolower($user->subscription('main')->ends_at->formatLocalized('%A %d %B %Y'))])</p>
            </div>
            <div class="account-subscription-footer">
                <a class="btn btn-sm btn-success" href="{{ route(app()->getLocale().'::subscriptions-resume') }}">@lang('Resume your subscription to the :name plan.', ['name' => $user->subscription('main')->plan])</a>
            </div>
        @elseif ($user->subscription('main')->cancelled())
            <div class="account-subscription-body">
                <p>@lang('Your subscription to the :name plan was cancelled.', ['name' => $user->subscription('main')->plan])</p>
            </div>
        @else
            <div class="account-subscription-body">
                <p>@lang('You are subscribed to the :name plan.', ['name' => $user->subscription('main')->plan])</p>
                <p><a class="small text-danger" onclick="return confirm('@lang('Are you sure you want to cancel your subscription to :name?', ['name' => $user->subscription('main')->plan])')" href="{{ route(app()->getLocale().'::subscriptions-cancel') }}">@lang('Cancel your subscription.')</a></p>
            </div>
            <div class="account-subscription-footer">
                <a class="account-subscription-edit-button" href="{{ route(app()->getLocale().'::subscriptions-upgrade') }}">@lang('Upgrade your subscription to another plan.')</a>
            </div>
        @endif
    @else
        @if ($plans->count() > 0)
        {!! BootForm::open() !!}
        <ul class="account-subscription-list">
            @foreach ($plans as $name => $plan)
            <li class="account-subscription-item">
                <div class="form-check">
                    {!! Form::radio('plan', $name)->id('plan-'.$name)->addClass('form-check-input') !!}
                    <label class="form-check-label" for="{{ 'plan-'.$name }}">
                        <span>{{ $plan['description'] }}</span><br>
                        <span class="text-muted small">{{ $plan['amount']['value'].' '.$plan['amount']['currency'].' '.__('each').' '.$plan['interval'] }}</span>
                    </label>
                </div>
            </li>
            @endforeach
        </ul>
        <div class="account-subscription-footer">
            {!! BootForm::submit(__('Subscribe'))->addClass('btn-sm btn-success') !!}
        </div>
        {!! BootForm::close() !!}
        @endif
    @endif
</div>
