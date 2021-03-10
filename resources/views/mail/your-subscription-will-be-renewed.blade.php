@component('mail::message')
# @lang('Hello!')

@lang('We inform you that your membership as a :plan will be renewed automatically as of :date.', ['plan' => __($subscription->plan), 'date' => $subscription->cycle_ends_at->format('d.m.Y')])

@component('mail::button', ['url' => url('/')])
@lang('Visit our website')
@endcomponent

@lang('Regards'),<br>
{{ TypiCMS::title() }}

@endcomponent
