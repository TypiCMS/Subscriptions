@component('mail::message')
# @lang('Welcome') {{ $user->first_name }} {{ $user->last_name }}

@lang('Thank you for supporting us, you now have access to all our resources.')

@component('mail::button', ['url' => url('/')])
@lang('Visit our website')
@endcomponent

@lang('Regards'),<br>
{{ TypiCMS::title() }}

@endcomponent
