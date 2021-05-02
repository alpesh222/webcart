<nav class="navbar navbar-default" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-nav-navbar-collapse-1">
            <span class="sr-only">@lang('Toggle navigation')</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand pull-left" href="{{url('/')}}" data-toggle="tooltip" title="{{session('location')}}">
            @if(config('settings.site_logo_enable'))
            <img class="pull-left img-responsive" id="site-logo" alt="{{config('settings.site_logo_name') . ' Logo'}}" src="{{route('imagecache', ['small-size', config('settings.site_logo')])}}">
            &nbsp;
            @endif
            <strong>{{config('settings.site_logo_name')}}</strong>
        </a>
    </div>

    <div class="collapse navbar-collapse" id="main-nav-navbar-collapse-1">
        <ul class="nav navbar-nav">
            <li><a href="{{url('/')}}">@lang('Home') <i class="fa fa-home"></i></a></li>
        </ul>
        <ul class="nav navbar-nav">
            <li class="dropdown">
            <a href="{{url('/cart')}}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">@lang('Cart') <i class="fa fa-shopping-cart"></i><span class="badge cart-count">{{Cart::content()->count()}}</span>&nbsp;<span class="caret"></span></a>
                <ul class="dropdown-menu dropdown-cart" role="menu">
                    @if(Cart::count() > 0)
                        @foreach(Cart::content() as $cartItem)
                            <li>
                                <a target="_blank" href="{{route('front.product.show', [$cartItem->options->slug])}}">
                                    <span class="item">
                                        <span class="item-left">
                                            @if($cartItem->options->has('photo'))
                                                @if($cartItem->options->photo)
                                                    <div class="cart-image">
                                                        <img class="img-responsive" src="{{$cartItem->options->photo}}" alt="{{$cartItem->name}}" />
                                                    </div>
                                                @endif
                                            @endif
                                            <span class="item-info">
                                                <span><strong>{{$cartItem->name}}</strong></span>
                                                <span class="text-muted">{{currency_format($cartItem->options->unit_price)}}</span>
                                            </span>
                                        </span>
                                        <span class="item-right">
                                            {!! Form::open(['method'=>'delete', 'route'=>['front.cart.destroy', $cartItem->rowId], 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "X"; return true;']) !!}
                                                {!! Form::submit('X', ['class'=>'btn btn-square btn-xs btn-danger', 'name'=>'submit_button']) !!}
                                            {!! Form::close() !!}
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="divider"></li>
                        @endforeach
                        <li><a class="text-center" href="{{url('/cart')}}">@lang('View Cart')</a></li>
                    @else
                        <li><a class="text-center" href="{{url('/cart')}}">@lang('The cart is empty.')</a></li>
                    @endif
                </ul>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            @if(Auth::check())
            <li><a href="{{url('/products/wishlist')}}">@lang('Wishlist') <i class="fa fa-gift"></i><span class="badge cart-count">{{Auth::user()->favouriteProducts()->count()}}</span></a></li>
            <li class="dropdown">
                <a href="{{route('front.account')}}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{Auth::user()->name}} <i class="fa fa-user"></i><span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{route('front.account')}}">@lang('Account Overview') <i class="fa fa-user"></i></a></li>
                    <li><a href="{{route('front.orders.index')}}">@lang('Orders') <i class="fa fa-shopping-cart"></i></a></li>
                    <li><a href="{{route('front.addresses.index')}}">@lang('Addresses') <i class="fa fa-truck"></i></a></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="{{route('front.settings.profile')}}">@lang('Edit Profile') <i class="fa fa-wrench"></i></a></li>
                    @if(Auth::user()->vendor)
                    <li><a href="{{route('front.vendor.profile')}}">@lang('Vendor Profile') <i class="fa fa-vendor"></i></a></li>
                    @endif
                    @if(Auth::user()->role)
                    <li role="separator" class="divider"></li>
                    <li><a href="{{url('/manage')}}">@lang('Manage') <i class="fa fa-wrench"></i></a></li>
                    @endif
                    <li role="separator" class="divider"></li>
                    <li><a onclick="logout();" href="#">@lang('Logout') <i class="fa fa-sign-out"></i></a></li>
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
                </ul>
            </li>
            @else
            <li><a href="{{url('/login')}}">@lang('Login') <i class="fa fa-sign-in"></i></a></li>
            <li><a href="{{url('/register')}}">@lang('Signup') <i class="fa fa-user"></i></a></li>
            @endif
        </ul>
        {!! Form::open(['method'=>'get', 'action'=>['FrontController@search'], 'role'=>'search', 'class'=>'navbar-form', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}
            <div class="input-group search-form">
                {!! Form::text('keyword', null, ['id'=>'search-keyword' ,'class'=>'form-control', 'placeholder'=>__('Enter Keyword Here...'), 'required']) !!}
                <span class="input-group-btn">
                    {!! Form::submit('Search', ['class'=>'btn btn-primary search-btn', 'name'=>'submit_button']) !!}
                </span>
            </div>
            &nbsp; 
        {!! Form::close() !!}
    </div>
</nav>