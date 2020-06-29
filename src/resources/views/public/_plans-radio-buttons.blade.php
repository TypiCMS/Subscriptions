<ul class="account-subscription-list">
    @foreach ($plans as $name => $plan)
    <li class="account-subscription-item">
        <div class="form-check">
            {!! Form::radio('plan', $name)->id('plan-'.$name)->addClass('form-check-input') !!}
            <label class="form-check-label" for="{{ 'plan-'.$name }}">
                <span class="account-subscription-item-name">@lang($name)</span>
                <span class="account-subscription-item-description">@lang($plan['description'])</span>
                <span class="account-subscription-item-amount">
                    {{ Subscriber::planPriceFormat($plan['amount']['value'], auth()->user()->taxPercentage(), $plan['amount']['currency'], auth()->user()->getLocale()) }} <small class="text-muted">@lang('/ '.$plan['interval'])</small>
                </span>
            </label>
        </div>
    </li>
    @endforeach
</ul>
