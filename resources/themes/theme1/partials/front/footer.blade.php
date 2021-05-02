<style>
	.row-footer.newsletter-area {
		background-image: linear-gradient(45deg, rgba(67, 59, 56, 0.67) 32%, rgba(0, 0, 0, 0.3) 30%), url('{{asset(theme_url('/img/subscribers-img.jpg'))}}');
	}
</style>
@if(config('settings.enable_subscribers'))
	<div class="row-footer newsletter-area">
		<div class="container newsletter-area-inner">
			<div class=" col-sm-6  newsletter-cont">
				<h3> {{config('settings.subscribers_title')}}</h3>
				<p>{{config('settings.subscribers_description')}}</p>
			</div>
			<div class="subscription-newsletter col-sm-6 col-md-6">
				{!! Form::open(['method'=>'post', 'action'=>'NewsletterController@addEmailToList', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}
				<div class="form-group col-sm-8 col-xs-12 col-md-6">
					{!! Form::email('email', null, ['class'=>'form-control', 'placeholder'=>config('settings.subscribers_placeholder_text'), 'required', 'email'])!!}
				</div>
				<div class="form-group col-sm-2 col-xs-12 col-md-6">
					<button class="btn btn-primary" name="submit_button" type="submit">{{config('settings.subscribers_btn_text')}}</button>
				</div>
				{!! Form::close() !!}
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
@endif
<footer id="myFooter">
	<div class="footer-above {{!config('customcss.front_footer_full_width') ? 'wrapper' : ''}}">
		@if(config('settings.footer_enable'))
			<div class="main-footer">
				<div class="cleafix">
					<div class="footer-menu">
						<div class="col social-col">
							<div class="footer-diss">
								<img class=" img-responsive" id="footer-site-logo" alt="{{config('settings.site_logo_name') . ' Logo'}}" src="{{route('imagecache', ['large', config('settings.site_logo')])}}">
								<div>{{config('settings.about_us_title')}}</div>
							</div>
							<div class="social-networks">
								@if(config('settings.social_link_twitter_enable'))
									<a target="_blank" href="{{config('settings.social_link_twitter')}}" class="twitter"><i class="fa fa-twitter"></i></a>
								@endif
								@if(config('settings.social_link_facebook_enable'))
									<a target="_blank" href="{{config('settings.social_link_facebook')}}" class="facebook"><i class="fa fa-facebook"></i></a>
								@endif
								@if(config('settings.social_link_youtube_enable'))
									<a target="_blank" href="{{config('settings.social_link_youtube')}}" class="youtube"><i class="fa fa-youtube"></i></a>
								@endif
								@if(config('settings.social_link_google_plus_enable'))
									<a target="_blank" href="{{config('settings.social_link_google_plus')}}" class="google-plus"><i class="fa fa-google-plus"></i></a>
								@endif
								@if(config('settings.social_link_linkedin_enable'))
									<a target="_blank" href="{{config('settings.social_link_linkedin')}}" class="linkedin"><i class="fa fa-linkedin"></i></a>
								@endif
							</div>
							{{--
                            @if(config('settings.social_share_enable'))
                            <hr>
                            <div class="text-center">
                                <a class="twitter-share-button"
                                href="{{url()->current()}}">
                                Tweet</a>&nbsp;&nbsp;
                                @if(config('settings.facebook_app_id') != "")
                                <button class="ui btn-xs facebook-share button"><i class="fa fa-facebook"></i> @lang('Share')</button>
                                @else
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::fullUrl()) }}" target="_blank" class="ui btn-xs facebook-share button btn-facebook social-share">
                                    <i class="fa fa-facebook"></i> @lang('Share')
                                </a>
                                @endif
                            </div>
                            @endif
                            --}}
						</div>
						<div class="col">
							<ul>
								<li><h5>@lang('Get started')</h5></li>
								<li> <i class="fa fa-chevron-circle-right" aria-hidden="true"></i> <a href="{{url('/')}}">@lang('Home')</a></li>
								@if(Auth::check())
									<li> <i class="fa fa-chevron-circle-right" aria-hidden="true"></i> <a href="{{url(route('front.account'))}}">@lang('Account')</a></li>
									<li><i class="fa fa-chevron-circle-right" aria-hidden="true"></i> <a href="{{url(route('front.orders.index'))}}">@lang('Orders')</a></li>
								@endif
								<li><i class="fa fa-chevron-circle-right" aria-hidden="true"></i> <a href="{{url(route('front.products'))}}">@lang('Products')</a></li>
								<li><i class="fa fa-chevron-circle-right" aria-hidden="true"></i> <a href="{{url(route('front.contact'))}}">@lang('Contact Us')</a></li>
							</ul>
						</div>
						@if(count($pages_footer) > 0)
							<div class="col">
								<ul>
									<li><h5>@lang('Pages')</h5></li>
									@foreach($pages_footer as $page)
										<li> <i class="fa fa-chevron-circle-right" aria-hidden="true"></i> <a href="{{route('front.page.show', [$page->slug])}}">{{$page->title}}</a></li>
									@endforeach
								</ul>
							</div>
						@endif
						@if(count($root_categories_footer) > 0)
							<div class="col">
								<ul>
									<li><h5>@lang('Categories')</h5></li>
									@foreach($root_categories_footer as $category)
										<li> <i class="fa fa-chevron-circle-right" aria-hidden="true"></i> <a href="{{route('front.category.show', [$category->slug])}}">{{$category->name}}</a></li>
									@endforeach
								</ul>
							</div>
						@endif
						@if(count($brands_footer) > 0)
							<div class="col">
								<ul>
									<li><h5>@lang('Brands')</h5></li>
									@foreach($brands_footer as $brand)
										<li> <i class="fa fa-chevron-circle-right" aria-hidden="true"></i> <a href="{{route('front.brand.show', [$brand->slug])}}">{{$brand->name}}</a></li>
									@endforeach
								</ul>
							</div>
						@endif
						@if(count($deals_footer) > 0)
							<div class="col">
								<ul>
									<li><h5>@lang('Deals')</h5></li>
									@foreach($deals_footer as $deal)
										<li><i class="fa fa-chevron-circle-right" aria-hidden="true"></i> <a href="{{route('front.deal.show', [$deal->slug])}}">{{$deal->name}}</a></li>
									@endforeach
								</ul>
							</div>
						@endif
					</div>
				</div>

			</div>
		@endif
	</div>
	<div class="footer-copyright clearfix col-md-12">
		@php
			$show_payments =  false;
                if( config('paypal.enable') || config('stripe.enable') || config('razorpay.enable') || config('instamojo.enable') || config('paytm.enable') ||
                          config('payu.enable') || config('paystack.enable') ){
                    $show_payments = true;
                }
		@endphp
		<div class="col-md-{{$show_payments ? '6' : '12'}} text-center">
			<p>
			{{--@if(config('settings.contact_email')) &nbsp; <i class="fa fa-envelope"></i> {{config('settings.contact_email')}} @endif @if(config('settings.contact_number')) &nbsp; <i class="fa fa-phone"></i> {{config('settings.contact_number')}} @endif --}}
			{!!config('settings.copyright_text')!!}

				<div class="private-policy">
					<a href="{{config('settings.terms_of_service_url')}}">@lang('Terms & Condition')</a>
					<a href="{{config('settings.privacy_policy_url')}}">@lang('Privacy Policy')</a>
					@if(config('site_map.site_map_url'))
						<a href="{{config('site_map.site_map_url')}}">@lang('Site Map')</a>
					@endif
				</div>
			</p>
		</div>
		@if($show_payments)
			<div class="col-md-6 text-center footer-payment">
				<div class="col-centered payment-methods">
					<ul class="text-center payment-method-list">
						@if(config('paypal.enable'))
							<li><img class="payment-logo" src="{{route('imagecache', ['original', 'paypal.png'])}}" alt="@lang('Paypal')" class="img-responsive" /></li>
						@endif
						@if(config('stripe.enable'))
							<li><img class="payment-logo" src="{{route('imagecache', ['original', 'stripe.png'])}}" alt="@lang('Stripe')" class="img-responsive" /></li>
						@endif
						@if(config('razorpay.enable'))
							<li><img class="payment-logo" src="{{route('imagecache', ['original', 'razorpay.png'])}}" alt="@lang('Razorpay')" class="img-responsive" /></li>
						@endif
						@if(config('instamojo.enable'))
							<li><img class="payment-logo" src="{{route('imagecache', ['original', 'instamojo.png'])}}" alt="@lang('Instamojo')" class="img-responsive" /></li>
						@endif
						@if(config('paytm.enable'))
							<li><img class="payment-logo" src="{{route('imagecache', ['original', 'paytm.png'])}}" alt="@lang('Paytm')" class="img-responsive" /></li>
						@endif
						@if(config('payu.enable'))
							@if(config('payu.default') == 'payumoney')
								<li><img class="payment-logo" src="{{route('imagecache', ['original', 'payumoney.png'])}}" alt="@lang('PayUmoney')" class="img-responsive" /></li>
							@elseif(config('payu.default') == 'payubiz')
								<li><img class="payment-logo" src="{{route('imagecache', ['original', 'payubiz.png'])}}" alt="@lang('PayUbiz')" class="img-responsive" /></li>
							@endif
							@if(config('paystack.enable'))
								<li><img class="payment-logo" src="{{route('imagecache', ['original', 'paystack.png'])}}" alt="@lang('Paystack')" class="img-responsive" /></li>
							@endif
						@endif
					</ul>
				</div>
			</div>
		@endif
	</div>
</footer>
