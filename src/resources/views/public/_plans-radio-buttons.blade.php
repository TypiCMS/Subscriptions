<ul class="account-subscription-list">
    @foreach ($plans as $name => $plan)
    <li class="account-subscription-item">
        <div class="form-check">
            {!! Form::radio('plan', $name)->id('plan-'.$name)->addClass('form-check-input') !!}
            <label class="form-check-label" for="{{ 'plan-'.$name }}">
                <span>@lang($name)</span><br>
                <span class="text-muted small">
                    @lang(':amount / '.$plan['interval'], ['amount' => Subscriber::planPriceFormat($plan['amount']['value'], auth()->user()->taxPercentage(), $plan['amount']['currency'], auth()->user()->getLocale())])
            </label>
        </div>
    </li>
    @endforeach
</ul>
