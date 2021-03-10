@component('mail::message')
# @lang('Hello!')

@lang('There was an error with your payment.')

@component('mail::button', ['url' => route(app()->getLocale().'::subscriptions-profile')])
@lang('Go to your profile')
@endcomponent

@lang('Regards'),<br>
{{ TypiCMS::title() }}

@endcomponent
