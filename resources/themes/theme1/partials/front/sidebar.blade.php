	<div class="leftSidebar col-md-3">
		<nav class="navbar-default" role="navigation">
			<div class="sidebar-collapse">
				<ul class="nav nav-pills" id="main-menu" >
					<li>
						<a class="{{Html::isActive([route('front.account')])}}" href="{{route('front.account')}}"><i class="fa fa-dashboard fa-2x"></i>@lang('Dashboard')</a>
					</li>
					<li>
						<a class="{{Html::isActive([route('front.settings.profile')])}}" href="{{route('front.settings.profile')}}"><i class="fa fa-wrench fa-2x"></i> @lang('Profile Settings')<span class="fa arrow"></span></a>
					</li>
		            @if ( Auth::user()->vendor )
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
					<li>
						<a class="{{Html::isActive([route('manage.settings.profile')])}}" href="{{route('manage.settings.profile')}}"><i class="fa fa-user fa-2x"></i> <em>{{'@'.Auth::user()->username}}</em><span class="fa arrow"></span></a>
						<ul class="nav nav-second-level">
							<li>
								<a onclick="logout();" href="#">@lang('Logout') <i class="fa fa-sign-out"></i></a>
							</li>
						
							<form id="logout-form" action="{{ route('logout') }}" method="POST">
								{{ csrf_field() }}
							</form>

							<script>
								function logout() {
									var logoutForm = $('#logout-form');
									if (!logoutForm.hasClass('form-submitted')) {
										logoutForm.addClass('form-submitted');
										logoutForm.submit();
									}
								}
							</script>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
	</div>
