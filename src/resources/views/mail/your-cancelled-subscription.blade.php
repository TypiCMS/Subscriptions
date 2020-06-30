@component('mail::message')
# @lang('Goodbye') {{ $user->first_name }} {{ $user->last_name }}

@lang('We’re sorry to see you go.')

@component('mail::button', ['url' => url('/')])
@lang('Visit our website')
@endcomponent

@lang('Regards'),<br>
{{ TypiCMS::title() }}

@endcomponent
