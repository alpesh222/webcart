<footer id="myFooter">
	@if(config('settings.footer_enable'))
    <div class="container">
        <div class="row">
        	<div class="col-md-12 footer-menu">
	            <div class="col-centered">
	                <h5>@lang('Get started')</h5>
	                <ul>
	                    <li><a href="{{url('/')}}">@lang('Home')</a></li>
						@if(Auth::check())
	                    <li><a href="{{url(route('front.account'))}}">@lang('Account')</a></li>
	                    <li><a href="{{url(route('front.orders.index'))}}">@lang('Orders')</a></li>
						@endif
	                    <li><a href="{{url(route('front.products'))}}">@lang('Products')</a></li>
	                    <li><a href="{{url(route('front.contact'))}}">@lang('Contact Us')</a></li>
	                </ul>
	            </div>
	            @if(count($pages_footer) > 0)
	            <div class="col-centered">
	                <h5>@lang('Pages')</h5>
	                <ul>
	                @foreach($pages_footer as $page)
	                    <li><a href="{{route('front.page.show', [$page->slug])}}">{{$page->title}}</a></li>
	                @endforeach
	                </ul>
	            </div>
	            @endif
	            @if(count($root_categories_footer) > 0)
	            <div class="col-centered">
	                <h5>@lang('Categories')</h5>
	                <ul>
	                @foreach($root_categories_footer as $category)
	                	<li><a href="{{route('front.category.show', [$category->slug])}}">{{$category->name}}</a></li>
	                @endforeach
	                </ul>
	            </div>
	            @endif
	            @if(count($brands_footer) > 0)
	            <div class="col-centered">
	                <h5>@lang('Brands')</h5>
	                <ul>
	                @foreach($brands_footer as $brand)
	                    <li><a href="{{route('front.brand.show', [$brand->slug])}}">{{$brand->name}}</a></li>
	                @endforeach
	                </ul>
	            </div>
	            @endif
	            @if(count($deals_footer) > 0)
	            <div class="col-centered">
	                <h5>@lang('Deals')</h5>
	                <ul>
	                @foreach($deals_footer as $deal)
	                	<li><a href="{{route('front.deal.show', [$deal->slug])}}">{{$deal->name}}</a></li>
	                @endforeach
	                </ul>
	            </div>
	            @endif
	            <div class="col-centered">
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
					@if(config('settings.social_share_enable'))
					<hr>
					<div class="text-center">
						<a class="twitter-share-button"
						href="{{url()->current()}}">
						@lang('Tweet')</a>&nbsp;&nbsp;
						@if(config('settings.facebook_app_id') != "")
						<button class="ui btn-xs facebook-share button"><i class="fa fa-facebook"></i> @lang('Share')</button>
						@else
						<a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::fullUrl()) }}" target="_blank" class="ui btn-xs facebook-share button btn-facebook social-share">
							<i class="fa fa-facebook"></i> @lang('Share')
						</a>
						@endif
					</div>
					@endif
	            </div>
            </div>
        </div>
        <div class="row">
        	<div class="col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3 col-xs-10 col-xs-offset-1">
				<div class="subscription-newsletter">
					{!! Form::open(['method'=>'post', 'action'=>'NewsletterController@addEmailToList', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}
						<div class="form-group">
							{!! Form::email('email', null, ['class'=>'form-control', 'placeholder'=>__('Enter Your Email'), 'required', 'email'])!!}
						</div>
						<div class="form-group">
							{!! Form::submit('Subscribe', ['class'=>'btn', 'name'=>'submit_button']) !!}
						</div>
					{!! Form::close() !!}
				</div>
        	</div>
        </div>
    </div>
	@endif
    <div class="footer-copyright">
        <p>@if(config('settings.contact_email')) &nbsp; <i class="fa fa-envelope"></i> {{config('settings.contact_email')}} @endif @if(config('settings.contact_number')) &nbsp; <i class="fa fa-phone"></i> {{config('settings.contact_number')}} @endif
			<br>Developed By <a id="webcart-link" href="https://web-cart.com" target="_blank">Web-Cart</a>&nbsp;&copy; {{date("Y")}}&nbsp; All Rights Reserved
        </p>
    </div>
</footer>