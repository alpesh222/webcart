<!-- ============================================================= FOOTER ============================================================= -->
<footer id="footer" class="footer color-bg">
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="module-heading">
                        <img class=" img-responsive" id="footer-site-logo" alt="{{config('settings.site_logo_name') . ' Logo'}}"
                             src="{{route('imagecache', ['large', config('settings.site_logo')])}}">
                        <h4 class="module-title about_us_title">{{config('settings.about_us_title')}}</h4>
                    </div>
                    <!-- /.module-heading -->
                </div>
                <!-- /.col -->

                <div class="col-xs-12 col-sm-6 col-md-2">
                    <div class="module-heading">
                        <h4 class="module-title">@lang('Get started')</h4>
                    </div>
                    <!-- /.module-heading -->

                    <div class="module-body">
                        <ul class='list-unstyled'>
                            <li class="first"><a href="{{url('/')}}" title="@lang('Home')">@lang('Home')</a></li>
                            @if(Auth::check())
                                <li><a href="{{url(route('front.account'))}}" title="Account">@lang('Account')</a></li>
                                <li><a href="{{url(route('front.orders.index'))}}" title="Orders">@lang('Orders')</a></li>
                            @endif
                            <li><a href="{{url(route('front.products'))}}" title="Products">@lang('Products')</a></li>
                            <li><a href="{{url(route('front.contact'))}}" title="Contact Us">@lang('Contact Us')</a></li>
                        </ul>
                    </div>
                    <!-- /.module-body -->
                </div>
                <!-- /.col -->

                @if(count($pages_footer) > 0)
                    <div class="col-xs-12 col-sm-6 col-md-2">
                        <ul>
                            <li><h5>@lang('Pages')</h5></li>
                            @foreach($pages_footer as $page)
                                <li> <i class="fa fa-chevron-circle-right" aria-hidden="true"></i>
                                    <a href="{{route('front.page.show', [$page->slug])}}">{{$page->title}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- /.col -->

                @if(count($root_categories_footer) > 0)
                    <div class="col-xs-12 col-sm-6 col-md-2">
                    <div class="module-heading">
                        <h4 class="module-title">@lang('Categories')</h4>
                    </div>
                    <!-- /.module-heading -->

                    <div class="module-body">
                        <ul class='list-unstyled'>
                            @foreach($root_categories_footer as $category)
                                <li class="{{$category->name}}">
                                    <a title="{{$category->name}}" href="{{route('front.category.show', [$category->slug])}}">{{$category->name}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- /.module-body -->
                </div>
                @endif
                <!-- /.col -->

                @if(count($brands_footer) > 0)
                    <div class="col-xs-12 col-sm-6 col-md-2">
                    <div class="module-heading">
                        <h4 class="module-title">@lang('Brands')</h4>
                    </div>
                    <!-- /.module-heading -->

                    <div class="module-body">
                        <ul class='list-unstyled'>
                            @foreach($brands_footer as $brand)
                                <li class="{{$brand->name}}">
                                    <a title="{{$brand->name}}" href="{{route('front.brand.show', [$brand->slug])}}">{{$brand->name}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- /.module-body -->
                </div>
                @endif
                <!-- /.col -->

                @if(count($deals_footer) > 0)
                    <div class="col-xs-12 col-sm-6 col-md-2">
                    <div class="module-heading">
                        <h4 class="module-title">@lang('Deals')</h4>
                    </div>
                    <!-- /.module-heading -->

                    <div class="module-body">
                        <ul class='list-unstyled'>
                            @foreach($deals_footer as $deal)
                                <li class="{{$deal->name}}">
                                    <a title="{{$deal->name}}" href="{{route('front.deal.show', [$deal->slug])}}">{{$deal->name}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- /.module-body -->
                </div>
                @endif
                <!-- /.col -->

                <!-- Copyright Text -->
                <div class="col-xs-12">
                    <p class="custom_copyright_footer">
                        {!!config('settings.copyright_text')!!}
                        <span class="private-policy">
                            <a href="{{config('settings.terms_of_service_url')}}">@lang('Terms & Condition')</a> |
                            <a href="{{config('settings.privacy_policy_url')}}">@lang('Privacy Policy')</a>
                            @if(config('site_map.site_map_url'))
                                | <a href="{{config('site_map.site_map_url')}}">@lang('Site Map')</a>
                            @endif
                        </span>

                    </p>


                </div>
                <!-- /.module-body -->
            </div>
        </div>
    </div>
    <div class="copyright-bar">
        <div class="container">
            <div class="col-xs-12 col-sm-6 no-padding social">
                <ul class="link">
                    @if(config('settings.social_link_twitter_enable'))
                        <li class="tw pull-left"><a target="_blank" rel="nofollow" href="{{config('settings.social_link_twitter')}}" title="Twitter"></a></li>
                    @endif
                    @if(config('settings.social_link_facebook_enable'))
                        <li class="fb pull-left"><a target="_blank" rel="nofollow" href="{{config('settings.social_link_facebook')}}" title="Facebook"></a></li>
                    @endif
                    @if(config('settings.social_link_instagram_enable'))
                        <li class="fb pull-left"><a target="_blank" rel="nofollow" href="{{config('settings.social_link_instagram')}}" title="Instagram"></a></li>
                    @endif
                    @if(config('settings.social_link_youtube_enable'))
                        <li class="youtube pull-left"><a target="_blank" rel="nofollow" href="{{config('settings.social_link_youtube')}}" title="Youtube"></a></li>
                    @endif
                    @if(config('settings.social_link_google_plus_enable'))
                        <li class="googleplus pull-left"><a target="_blank" rel="nofollow" href="{{config('settings.social_link_google_plus')}}" title="GooglePlus"></a></li>
                    @endif
                    @if(config('settings.social_link_linkedin_enable'))
                        <li class="linkedin pull-left"><a target="_blank" rel="nofollow" href="{{config('settings.social_link_linkedin')}}" title="Linkedin"></a></li>
                    @endif
                </ul>
            </div>
            <div class="col-xs-12 col-sm-6 no-padding">
                <div class="clearfix payment-methods">
                    <ul>
                        @if(config('paypal.enable'))
                            <li><img class="payment-logo" src="{{route('imagecache', ['original', 'paypal.png'])}}" alt="@lang('Paypal')"  /></li>
                        @endif
                        @if(config('stripe.enable'))
                            <li><img class="payment-logo" src="{{route('imagecache', ['original', 'stripe.png'])}}" alt="@lang('Stripe')"  /></li>
                        @endif
                        @if(config('razorpay.enable'))
                            <li><img class="payment-logo" src="{{route('imagecache', ['original', 'razorpay.png'])}}" alt="@lang('Razorpay')"  /></li>
                        @endif
                        @if(config('instamojo.enable'))
                            <li><img class="payment-logo" src="{{route('imagecache', ['original', 'instamojo.png'])}}" alt="@lang('Instamojo')"  /></li>
                        @endif
                        @if(config('paytm.enable'))
                            <li><img class="payment-logo" src="{{route('imagecache', ['original', 'paytm.png'])}}" alt="@lang('Paytm')"  /></li>
                        @endif
                        @if(config('payu.enable'))
                            @if(config('payu.default') == 'payumoney')
                                <li><img class="payment-logo" src="{{route('imagecache', ['original', 'payumoney.png'])}}" alt="@lang('PayUmoney')"  /></li>
                            @elseif(config('payu.default') == 'payubiz')
                                <li><img class="payment-logo" src="{{route('imagecache', ['original', 'payubiz.png'])}}" alt="@lang('PayUbiz')"  /></li>
                            @endif
                            @if(config('paystack.enable'))
                                <li><img class="payment-logo" src="{{route('imagecache', ['original', 'paystack.png'])}}" alt="@lang('Paystack')"  /></li>
                            @endif
                        @endif
                    </ul>
                </div>
                <!-- /.payment-methods -->
            </div>
        </div>
    </div>
</footer>
<!-- ============================================================= FOOTER : END============================================================= -->