@extends('layouts.front')

@section('title')
    @lang('User Referrals') - {{config('app.name')}}
@endsection

@section('meta-tags')
    <meta name="description" content="@lang('User Referrals')">
@endsection

@section('meta-tags-og')
    <meta property="og:url" content="{{url()->current()}}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@lang('User Referrals') - {{config('app.name')}}" />
    <meta property="og:description" content="@lang('User Referrals')" />
    <meta property="og:image" content="{{url('/img/'.config('settings.site_logo'))}}" />
@endsection

@section('styles')
    <style>
        .ur {border: none;background-color: #e6e2e2;border-bottom-left-radius: 4px;border-top-left-radius: 4px;padding-left: 1em;height: 40px;}
        .cpy {border: none;background-color: #e6e2e2;border-bottom-right-radius: 4px;border-top-right-radius: 4px;cursor: pointer}
        button.focus, button:focus {outline: 0;box-shadow: none !important}
        .ur.focus, .ur:focus {outline: 0;box-shadow: none !important}
        .refer-content-footer{display: inline-flex;}
        .refer-content-footer label{font-weight: 600;margin: auto;font-size: 14px;margin-right: 1em;}
        .refer_message {font-size: 11px;position: absolute;color: green;right: 20%;bottom: 35px;}
        .btn-success{background-color: green!important;}
        @media screen and (max-width: 1024px) {
            .refer_message {right: 14%}
        }
        @media screen and (max-width: 425px) {
            .cpy {height: 40px;}
            .refer-content-footer {display: block;}
            .refer-content-footer label{margin-bottom: 10px}
        }
    </style>
@endsection

@section('sidebar')
    @include('includes.user-account-sidebar')
@endsection

@section('above_content')
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{url('/')}}">@lang('Home')</a></li>
                    <li class="active">@lang('User Referrals')</li>
                </ul>
            </div>
            <!-- /.breadcrumb-inner -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.breadcrumb -->
@endsection

@section('content')
    <div class="col-md-9 user_account">
        <div class="shopping-cart">
            <div class="page-title">
                <h2>@lang('User Referrals')</h2>
            </div>
            <div class="content-panel">
                <div class="row text-center">
                    <div class="empty-bag">
                        <div class="empty-bag-icon">
                            <img src="{{asset('/img/icons/referral.png')}}" class="img-responsive m-a" alt="@lang('No Wallet History')" width="400">
                        </div>
                        <h3 class="text-center">
                            {{ __('Give :refer_by_amt, Get :refer_to_amt Reward', [ 'refer_by_amt' => currency_format(config('referral.referral_by_amt')), 'refer_to_amt' => currency_format(config('referral.referral_to_amt')) ]) }}
                        </h3>
                        <h5 class="text-center text-muted">
                            {{ __('Register your friend to :app_name and get :refer_to_amt in your wallet for your next purchase.', [ 'app_name' => config('app.name'), 'refer_to_amt' => currency_format(config('referral.referral_to_amt')) ]) }}
                        </h5>
                        <div class="refer-content-footer">
                            @if( !empty( $user_referral_code->self_referral_code ) )
                                <label>Share your referral Code : </label><br/>
                                <input class="col-10 ur" type="url" placeholder="{{ $user_referral_code->self_referral_code }}" id="referral_code"
                                       aria-describedby="inputGroup-sizing-default" value="{{ $user_referral_code->self_referral_code }}" readonly>
                                <button title="@lang('Copy Referral Code')" class="cpy" onclick="copyReferralCode()"><i class="fa fa-clone"></i></button>
                                <span class="refer_message device-none"></span>
                            @else
                                <a href="{{ route('front.referrals.generateUserReferralCode') }}" class="btn btn-success bg-color-green" title="@lang('Generate your Referral Code')" >
                                    @lang('Generate Referral Code')
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function copyReferralCode(){
            let refer_message = $(".refer_message");
            refer_message.text('');
            var copyText = document.getElementById("referral_code");
            copyText.select();
            copyText.setSelectionRange(0, 99999); /*For mobile devices*/
            document.execCommand("copy");
            refer_message.text("@lang('Code Copied')");
        }
    </script>
@endsection
