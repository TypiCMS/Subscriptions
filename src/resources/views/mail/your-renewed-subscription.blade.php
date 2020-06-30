@component('mail::message')
# @lang('Hello!')

@lang('Thank you for supporting us, your subscription has been successfully renewed.')

@component('mail::button', ['url' => url('/')])
@lang('Visit our website')
@endcomponent

@lang('Regards'),<br>
{{ TypiCMS::title() }}

@endcomponent
