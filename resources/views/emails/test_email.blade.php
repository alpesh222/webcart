@component('mail::message')
# @lang('Test Email')

{{$message}}

@component('mail::button', ['url' => url('/')])
@lang('Return to') {{config('app.name')}}
@endcomponent

@endcomponent
