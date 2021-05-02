    @if(Auth::check() && ( $vendor = Auth::user()->vendor ) && ! $vendor->profile_completed)
    	<br>
        <a href="{{route('front.vendor.profile')}}">
            <div class="alert alert-dissmisable alert-warning text-center">
                @lang('Please complete your Vendor Profile. Click Here')
            </div>
        </a>
    @endif