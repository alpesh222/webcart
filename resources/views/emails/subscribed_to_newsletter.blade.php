@component('mail::message')
# {{ config('app.name') }}: {{ config('subscribers.mail_message_title_subscribed') }}

{{ config('subscribers.mail_message_subscribed') }}

@lang('Thanks,')<br>
{{ config('app.name') }}
@endcomponent
