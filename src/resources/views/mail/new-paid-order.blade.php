@component('mail::message')
# @lang('Hello!')

@lang('The subscription of :name was renewed automatically.', ['name' => "{$user->first_name} {$user->last_name}"])

@component('mail::button', ['url' => route('admin::show-user', $user)])
@lang('See online')
@endcomponent

@lang('Regards'),<br>
{{ TypiCMS::title() }}

@endcomponent
