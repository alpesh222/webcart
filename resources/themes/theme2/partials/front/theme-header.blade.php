<!-- ============================================== TOP MENU ============================================== -->
<div class="top-bar animate-dropdown">
    <div class="container">
        <div class="header-top-inner">
            <div class="cnt-account">
                <ul class="list-unstyled">
                    @if(Auth::check())
                        <li><a href="{{route('front.account')}}"><i class="icon fa fa-user"></i>@lang('My Account')</a></li>
                        <li><a href="{{url('/products/wishlist')}}"><i class="icon fa fa-heart"></i>@lang('Wishlist')</a></li>
                    @endif
                        <li><a href="{{url('/checkout/shipping-details')}}"><i class="icon fa fa-check"></i> @lang('Checkout')</a></li>
                        <li><a href="{{url('/cart')}}"><i class="icon fa fa-shopping-cart"></i>@lang('My Cart')</a></li>
                    @if(Auth::check())
                        <li class="dropdown dropdown-small user_account_dropdown">
                            <a href="#" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown">
                                <i class="icon fa fa-user"></i>
                                <span class="value">{{Auth::user()->name}}</span>
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="{{route('front.account')}}"><i class="icon fa fa-user"></i>@lang('Account Overview')</a></li>
                                <li><a href="{{route('front.orders.index')}}"><i class="icon fa fa-shopping-cart"></i>@lang('Orders')</a></li>
                                <li><a href="{{route('front.addresses.index')}}"><i class="icon fa fa-truck"></i>@lang('Addresses')</a></li>
                                <li><a href="{{route('front.settings.profile')}}"><i class="icon fa fa-cog"></i>@lang('Edit Profile')</a></li>
                                @if(Auth::user()->vendor)
                                    <li><a href="{{route('front.vendor.profile')}}"><i class="icon fa fa-user"></i>@lang('Vendor Profile')</a></li>
                                @endif
                                @if(Auth::user()->role)
                                    @if(Auth::user()->vendor && isset(Auth::user()->vendor->approved) && Auth::user()->isApprovedVendor())
                                        <li><a href="{{url('/manage/vendor/dashboard')}}"><i class="icon fa fa-wrench mr-5"></i>@lang('Manage')</a></li>
                                    @elseif(Auth::user()->isSuperAdmin() || Auth::user()->can('view-dashboard', \App\Other::class) )
                                        <li><a href="{{url('/manage')}}"><i class="fa fa-wrench mr-5"></i>@lang('Manage')</a></li>
                                    @endif
                                @elseif(Auth::user()->vendor && isset(Auth::user()->vendor->approved) && Auth::user()->isApprovedVendor())
                                    <li>
                                        <a href="{{url('/manage/vendor/dashboard')}}" class="userAccount-item">
                                            <i class="icon fa fa-wrench mr-5"></i>@lang('Manage')
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                        <li><a href="Javascript:void(0)" onclick="logout();"><i class="icon fa fa-sign-out"></i> @lang('Logout')</a></li>
                        <form id="logout_form" action="{{ route('logout') }}" method="POST">
                            {{ csrf_field() }}
                        </form>
                        <script>
                            function logout() {
                                var logoutForm = $('#logout_form');
                                if (!logoutForm.hasClass('form-submitted')) {
                                    logoutForm.addClass('form-submitted');
                                    logoutForm.submit();
                                }
                            }
                        </script>
                    @else
                        <li><a href="{{url('/login')}}"><i class="icon fa fa-lock"></i>@lang('Login')</a></li>
                        <li><a href="{{url('/register')}}"><i class="icon fa fa-sign-in"></i>@lang('Sign up')</a></li>
                   @endif
                </ul>
            </div>
            <!-- /.cnt-account -->

            <div class="cnt-block">
                <ul class="list-unstyled list-inline">
                    <li class="dropdown dropdown-small">
                        <a href="Javascript:void(0)" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown">
                            <i class="fa fa-money"></i>
                            <span class="value"> {{ config('currency.default') }} </span>
                        </a>
                    </li>
                    @if(config('settings.allow_multi_language'))
                        @if(count(\App\Helpers\Helper::supportedLanguages()) > 1)
                            <li class="dropdown dropdown-small">
                                <a href="#" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown">
                                    <i class="fa fa-language"></i>
                                    <span class="value">
                                        @if(isset(\App\Helpers\Helper::supportedLanguages()[session('language')]))
                                            {{\App\Helpers\Helper::supportedLanguages()[session('language')]}}
                                        @else
                                            {{\App\Helpers\Helper::supportedLanguages()[\App::getLocale()]}}
                                        @endif
                                    </span>
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    @foreach(\App\Helpers\Helper::supportedLanguages() as $key => $value)
                                        <li>
                                            <a href="{{route('front.index', [$key])}}">{{$value}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                        @else
                        <li class="dropdown dropdown-small">
                            <a href="Javascript:void(0)" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown">
                                <i class="fa fa-language"></i>
                                <span class="value">
                                    @if(isset(\App\Helpers\Helper::supportedLanguages()[session('language')]))
                                        {{\App\Helpers\Helper::supportedLanguages()[session('language')]}}
                                    @else
                                        {{\App\Helpers\Helper::supportedLanguages()[\App::getLocale()]}}
                                    @endif
                                </span>
                            </a>
                        </li>
                    @endif
                </ul>
                <!-- /.list-unstyled -->
            </div>
            <!-- /.cnt-cart -->
            <div class="clearfix"></div>
        </div>
        <!-- /.header-top-inner -->
    </div>
    <!-- /.container -->
</div>
<!-- /.header-top -->
<!-- ============================================== TOP MENU : END ============================================== -->
<div class="main-header">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-3 logo-holder">
                <!-- ============================================================= LOGO ============================================================= -->
                <div class="logo">
                    <a href="{{url('/')}}" title="{{session('location')}}">
                        @if(config('settings.site_logo_enable'))
                            <img class=" img-responsive" id="site-logo" alt="{{config('settings.site_logo_name') . ' Logo'}}" src="{{route('imagecache', ['large', config('settings.site_logo')])}}">&nbsp;
                        @endif
                    </a>
                </div>
                <!-- /.logo -->
                <!-- ============================================================= LOGO : END ============================================================= --> </div>
            <!-- /.logo-holder -->
            <div class="col-xs-12 col-sm-12 col-md-7 top-search-holder">
                <!-- /.contact-row -->
                <!-- ============================================================= SEARCH AREA ============================================================= -->
                <div class="search-area">
                    {!! Form::open(['method'=>'get', 'action'=>['FrontController@search'], 'role'=>'search', 'class'=>'navbar-form p-0 m-a', 'autocomplete'=>'off' ,'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}
                        <div class="control-group">
                            @if(count($root_categories) > 0)
                                <ul class="categories-filter animate-dropdown">
                                    <li class="dropdown"> <a class="dropdown-toggle"  data-toggle="dropdown" href="category.html"> @lang('Categories') <b class="caret"></b></a>
                                        <ul class="dropdown-menu" role="menu" >
                                            @foreach($root_categories as $category)
                                                @if($category->is_active)
                                                    <li><a href="{{route('front.category.show', [$category->slug])}}">{{$category->name}}</a></li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                </ul>
                            @endif
                                {!! Form::text('keyword', null, ['id'=>'search-keyword' ,'class'=>'search-field', 'placeholder'=>__('Search here...'), 'required', 'autofocus']) !!}
                                {!! Form::button(null, ['type' => 'submit', 'class'=>'search-button', 'name'=>'submit_button']) !!}

                        </div>
                    {!! Form::close() !!}
                </div>
                <!-- /.search-area -->
                <!-- ============================================================= SEARCH AREA : END ============================================================= --> </div>
            <!-- /.top-search-holder -->

            <div class="col-xs-12 col-sm-12 col-md-2 animate-dropdown top-cart-row">
                <!-- ============================================================= SHOPPING CART DROPDOWN ============================================================= -->
                <div class="dropdown dropdown-cart">
                    <a href="#" class="dropdown-toggle lnk-cart dropdown-cart-anchor" data-toggle="dropdown">
                        <div class="items-cart-inner">
                            <div class="basket"> <i class="glyphicon glyphicon-shopping-cart"></i> </div>
                            <div class="basket-item-count"><span class="count">{{Cart::content()->count()}}</span></div>
                            <div class="total-price-basket">
                                <span class="lbl">@lang('cart') -</span>
                                <span class="total-price">
                                    <span class="value">{{currency_format(Cart::total())}}</span>
                                </span>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu custom_cart_dropdown">

                    </ul>
                    <!-- /.dropdown-menu-->
                </div>
                <!-- /.dropdown-cart -->
                <!-- ============================================================= SHOPPING CART DROPDOWN : END============================================================= --> </div>
            <!-- /.top-cart-row -->
            </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->

</div>
<!-- /.main-header -->

    