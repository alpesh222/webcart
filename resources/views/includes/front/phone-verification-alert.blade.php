@if(Auth::check() && config('settings.phone_otp_verification'))
    @if(!auth()->user()->mobile)
        <a href="{{route('front.settings.profile')}}">
            <div class="text-center alert alert-info" role="alert">
                <span class="glyphicon glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                @lang('Please add and verify your phone number')
            </div>
        </a>
    @elseif(!auth()->user()->mobile->verified)
        <a href="{{route('front.settings.profile')}}">
            <div class="text-center alert alert-info" role="alert">
                <span class="glyphicon glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                @lang('Please verify your phone number')
            </div>
        </a>
    @endif
@endif