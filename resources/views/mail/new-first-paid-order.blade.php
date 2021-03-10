@component('mail::message')
# @lang('Hello!')

@lang('You have a new paid member (:name).', ['name' => "{$user->first_name} {$user->last_name}"])

@component('mail::button', ['url' => route('admin::show-user', $user)])
@lang('See online')
@endcomponent

@lang('Regards'),<br>
{{ TypiCMS::title() }}

@endcomponent
