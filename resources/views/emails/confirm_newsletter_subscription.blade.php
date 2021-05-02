@component('mail::message')
# @lang('Please Confirm Subscription')

@component('mail::button', ['url' => route('subscribe.confirm', [
                                        'token' => $subscriber->activation_token,
                                        'email' => $subscriber->email
                                    ])
])
@lang('Subscribe to Newsletter')
@endcomponent

@lang('Thanks,')<br>
{{ config('app.name') }}
@endcomponent
