@component('mail::message')
# @lang('Activate your account')

@lang('Thanks for signing up, please activate your account.')

@component('mail::button', ['url' => route('auth.activate', [
	'token' => $user->activation_token,
	'email' => $user->email
])])
@lang('Activate')
@endcomponent

@lang('Thanks,')<br>
{{ config('app.name') }}
@endcomponent
