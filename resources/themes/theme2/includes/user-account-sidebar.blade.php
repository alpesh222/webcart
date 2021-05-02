<!-- ============================================== USER ACCOUNTS SIDEBAR ============================================== -->
<div class="col-md-3">
    <div class="checkout-progress-sidebar user_account_sidebar">
        <div class="panel-group">
            <div class="panel panel-default">
                <nav class="woocommerce-MyAccount-navigation p-10">
                    <ul class="nav nav-checkout-progress list-unstyled">
                        <li>
                            <a class="{{Html::isActive([route('front.account')])}}" href="{{route('front.account')}}"><i class="fa fa-dashboard fa-2x"></i>@lang('Dashboard')</a>
                        </li>
                        <li>
                            <a class="{{Html::isActive([route('front.settings.profile')])}}" href="{{route('front.settings.profile')}}"><i class="fa fa-wrench fa-2x"></i> @lang('Profile Settings')<span class="fa arrow"></span></a>
                        </li>
                        @if( Auth::user()->vendor )
                            <li>
                                <a class="{{Html::isActive([route('front.vendor.profile')])}}" href="{{route('front.vendor.profile')}}"><i class="fa fa-user fa-2x"></i> @lang('Vendor Profile')<span class="fa arrow"></span></a>
                            </li>
                        @endif
                        <li>
                            <a class="{{Html::isActive([route('front.orders.index')])}}" href="{{route('front.orders.index')}}"><i class="fa fa-shopping-cart fa-2x"></i> @lang('Orders')<span class="fa arrow"></span></a>
                        </li>
                        <li>
                            <a class="{{Html::isActive([route('front.wallet-history.index')])}}" href="{{route('front.wallet-history.index')}}"><i class="fa fa-google-wallet fa-2x"></i> @lang('Wallet History')<span class="fa arrow"></span></a>
                        </li>
                        <li>
                            <a class="{{Html::isActive([route('front.addresses.index')])}}" href="{{route('front.addresses.index')}}"><i class="fa fa-truck fa-2x"></i> @lang('Addresses')<span class="fa arrow"></span></a>
                        </li>
                        @if( config('referral.enable') && auth()->user()->verified && auth()->user()->is_active )
                            <li>
                                <a class="{{Html::isActive([route('front.referrals.index')])}}" href="{{route('front.referrals.index')}}"><i class="fa fa-user-plus fa-2x"></i> @lang('User Referrals')<span class="fa arrow"></span></a>
                            </li>
                        @endif

                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ============================================== USER ACCOUNTS SIDEBAR : END ============================================== -->