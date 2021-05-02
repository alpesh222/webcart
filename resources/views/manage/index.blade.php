@extends('layouts.manage')

@section('title')
    @lang('Dashboard')
@endsection

@section('page-header-title')
    @lang('Dashboard')
@endsection

@section('styles')
    <style>
	.huge {
		font-size: 40px;
	}
    </style>
    @include('partials.manage.categories-tree-style')
	<style>
		.tree ul li:last-child:before {
        	background:#f3f3f3;
    	}
		.edit-counter a {
			color: #656565;
			text-decoration: none;
		}
		#page-inner {
			width: 100%;
			margin: 10px 20px 10px 0px;
			background-color: #f3f3f3!important;
		}
		.edit-counter .noti-box {
			min-height: 100px;
			padding: 4px;
		}
		.edit-counter .panel-back>a {
			display: inline-block;
			padding: 7px;
			text-decoration: none;
		}
		.edit-counter p.text-muted {
			display: inline;
		}
		.edit-counter .noti-box .icon-box {
			display: block;
			line-height: 43px;
			border-radius: 0px;
			box-shadow: 0px 0px 14px 0px #d8d8d8;
			margin-top: -22px;
			margin-left: 6px;
		}
		.edit-counter .panel-back {
			background-color: #fff;
			border-radius: 0px;
			box-shadow: 0px 0px 20px 0px #d8d8d8;
		}
		.edit-counter .text-box {
			text-align: right;
			padding-right: 10px;
		}
		.sub-counter .noti-box {
			width: 100%;
			position: relative;
		}
		.sub-counter .panel {
			border-radius: 0;
			box-shadow: 0px 0px 20px 0px #d8d8d8;
		}
		.edit-counter .sub-counter .text-muted {
			color: #fff;
		}
		.huge {
			font-size: 36px;
		}
		.fa-5x {
			font-size: 4em;
		}

		@media only screen and (min-width:768px) and (max-width: 1023px) {}

		@media (max-width: 1023px) {
			.edit-counter .panel-back {
				background-color: #fff;
				border-radius: 0px;
				margin-top: 20px;
				box-shadow: 0px 0px 20px 0px #d8d8d8;
			}
		}
		.chartjs-top-selling-products {
			width: 100%;
		}
		#orders-list {
			max-height: 350px;
		    overflow-y: scroll;
		}
		.vendor-requests-payout {
			margin-bottom: 0;
			background-color: #fff;
		}
	</style>
@endsection

@section('scripts')
    @include('partials.manage.categories-tree-script')
    <script src="{{asset('js/Chart.bundle.min.js')}}"></script>
@endsection

@section('content')
	
	@can('manage-shipment-orders', App\Other::class)
	@if(count(auth()->user()->shipments) > 0)
	<div class="row">
		<div class="col-md-12">
	        @if(session()->has('order_passed_to_shipment'))
	            <div class="alert alert-success alert-dismissible" role="alert">
	                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	                    <span aria-hidden="true">&times;</span>
	                </button>
	                <strong>{{session('order_passed_to_shipment')}}</strong>
	            </div>
	        @endif
			<blockquote>@lang('Orders received to your shipments')</blockquote>
			@foreach(auth()->user()->shipments()->orderBy('id', 'asc')->get() as $shipment)
			<div class="col-md-4 well">
				<h4><div class="label label-primary">{{$shipment->name.' (' . __('ID:') . ' '.$shipment->id.')'}}</div></h4>
				<ul class="list-group" id="orders-list">
					@foreach($shipment->orders()->where('location_id', Auth::user()->location_id)->where('is_processed', 0)->get() as $order)
						@if($order->shipments()->orderBy('id', 'desc')->first()->id == $shipment->id)
						<a href="{{route('manage.orders.edit', $order->id)}}"><li class="list-group-item">
							#{{$order->getOrderId()}}
						<span class="text-muted pull-right">{{$order->created_at->format('H:i M d, Y')}}</span></li></a>
						@endif
					@endforeach
				</ul>
			</div>
			@endforeach
		</div>
	</div>
	<hr>
	@endif
	@endcan



	<div class="row">
		<div class="col-md-12 edit-counter">

			<div class="row">

				@if(Auth::user()->can('read', App\User::class) || Auth::user()->can('view-customers', App\Other::class) || Auth::user()->can('read', App\Vendor::class))
				<div class="col-lg-4 col-xs-12">
					@can('read', App\User::class)
					<div class="panel panel-back panel-primary noti-box">
						<span class="icon-box panel-heading set-icon">
							<i class="fa fa-users"></i>
						</span>
						<div class="text-box">
							<p class="main-text">{{$staff_count}} @lang('Staff')</p>
							<p class="text-muted">@lang('Total Staff!')</p>
						</div>
						<a href="{{route('manage.users.index')}}"> @lang('More Details') </a>
					</div>
					@endcan
					@if(Auth::user()->can('view-customers', App\Other::class) || Auth::user()->can('read', App\Vendor::class))
					<div class="row sub-counter">
						@can('view-customers', App\Other::class)
						<div class="col-md-12">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-users fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge">{{$customers_count}}</div>
											<div>@lang('Total Customers!')</div>
										</div>
									</div>
								</div>
								<a href="{{route('manage.customers.index')}}">
									<div class="panel-footer">
										<span class="pull-left">@lang('View Details')</span>
										<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
										<div class="clearfix"></div>
									</div>
								</a>
							</div>
						</div>
						@endcan
						@can('read', App\Vendor::class)
						<div class="col-md-12">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-users fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge">{{$approved_vendors_count}}</div>
											<div>@lang('Vendors Approved!')</div>
										</div>
									</div>
								</div>
								<a href="{{route('manage.vendors.index')}}">
									<div class="panel-footer">
										<span class="pull-left">@lang('View Details')</span>
										<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
										<div class="clearfix"></div>
									</div>
								</a>
							</div>
						</div>
						@endcan
						@can('read', App\Vendor::class)
						<div class="col-md-12">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-users fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge">{{$vendor_requests_pending}}</div>
											<div>@lang('Vendor Pending Request')</div>
										</div>
									</div>
								</div>
								<a href="{{route('manage.vendor.vendor_requests')}}">
									<div class="panel-footer">
										<span class="pull-left">@lang('View Details')</span>
										<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
										<div class="clearfix"></div>
									</div>
								</a>
							</div>
						</div>
						@endcan
					</div>
					@endif
				</div>
				@endif

				@can('read', App\Product::class)
				<div class="col-lg-4 col-xs-12">
					<div class="panel panel-back panel-success noti-box">
						<span class="icon-box panel-heading set-icon">
							<i class="fa fa-sitemap"></i>
						</span>
						<div class="text-box">
							<p class="main-text">{{$products_count}} @lang('Products')</p>
							<p class="text-muted">@lang('Total Products!')</p>
						</div>
						<a href="{{route('manage.products.index')}}"> @lang('More Details') </a>
					</div>
					<div class="row sub-counter">
						<div class="col-md-12">
							<div class="panel panel-success">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-sitemap fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge">{{$low_stock_products_count}}</div>
											<div>@lang('Low Stock Products!')</div>
										</div>
									</div>
								</div>
								<a href="{{route('manage.products.index')}}?stock=low">
									<div class="panel-footer">
										<span class="pull-left">@lang('View Details')</span>
										<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
										<div class="clearfix"></div>
									</div>
								</a>
							</div>
						</div>
						<div class="col-md-12">
							<div class="panel panel-success">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-sitemap fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge">{{$out_of_stock_products_count}}</div>
											<div>@lang('Products Out of Stock!')</div>
										</div>
									</div>
								</div>
								<a href="{{route('manage.products.index')}}?stock=none">
									<div class="panel-footer">
										<span class="pull-left">@lang('View Details')</span>
										<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
										<div class="clearfix"></div>
									</div>
								</a>
							</div>
						</div>
						@can('read', App\Page::class)
							<div class="col-md-12">
								<div class="panel panel-success">
									<div class="panel-heading">
										<div class="row">
											<div class="col-xs-3">
												<i class="fa fa-sitemap fa-5x"></i>
											</div>
											<div class="col-xs-9 text-right">
												<div class="huge">{{$total_active_pages}}</div>
												<div>@lang('Total Active Pages')</div>
											</div>
										</div>
									</div>
									<a href="{{route('manage.pages.index')}}">
										<div class="panel-footer">
											<span class="pull-left">@lang('View Details')</span>
											<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
											<div class="clearfix"></div>
										</div>
									</a>
								</div>
							</div>
						@endcan
					</div>
				</div>
				@endcan

				@can('read', App\Category::class)
				<div class="col-lg-4 col-xs-12">
					<div class="panel panel-back panel-info noti-box">
						<span class="icon-box panel-heading set-icon">
							<i class="fa fa-tags"></i>
						</span>
						<div class="text-box">
							<p class="main-text">{{$categories_count}} @lang('Categories')</p>
							<p class="text-muted">@lang('Total Categories!')</p>
						</div>
						<a href="{{route('manage.categories.index')}}#categories-table"> @lang('More Details') </a>
					</div>
					<div class="row sub-counter">
						<div class="col-md-12">
							<div class="panel panel-info">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-tags fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge">{{$root_categories_count}}</div>
											<div>@lang('Root Categories!')</div>
										</div>
									</div>
								</div>
								<a href="{{route('manage.categories.index')}}?level=root#categories-table">
									<div class="panel-footer">
										<span class="pull-left">@lang('View Details')</span>
										<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
										<div class="clearfix"></div>
									</div>
								</a>
							</div>
						</div>
						<div class="col-md-12">
							<div class="panel panel-info">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-tags fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge">{{$active_categories_count}}</div>
											<div>@lang('Active Categories!')</div>
										</div>
									</div>
								</div>
								<a href="{{route('manage.categories.index')}}?status=active#categories-table">
									<div class="panel-footer">
										<span class="pull-left">@lang('View Details')</span>
										<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
										<div class="clearfix"></div>
									</div>
								</a>
							</div>
						</div>
						@can('read', App\Shipment::class)
							<div class="col-md-12">
								<div class="panel panel-info">
									<div class="panel-heading">
										<div class="row">
											<div class="col-xs-3">
												<i class="fa fa-tags fa-5x"></i>
											</div>
											<div class="col-xs-9 text-right">
												<div class="huge">{{$total_shipments}}</div>
												<div>@lang('Total Shipments')</div>
											</div>
										</div>
									</div>
									<a href="{{route('manage.shipments.index')}}">
										<div class="panel-footer">
											<span class="pull-left">@lang('View Details')</span>
											<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
											<div class="clearfix"></div>
										</div>
									</a>
								</div>
							</div>
						@endcan
					</div>
				</div>
				@endcan

			</div>

			@if(Auth::user()->can('read', App\User::class) || Auth::user()->can('read', App\Product::class) || Auth::user()->can('read', App\Category::class))
			<br><br>
			@endif
			<div class="row">

				@can('read', App\Order::class)
				<div class="col-lg-4 col-xs-12">
					<div class="panel panel-back panel-danger noti-box">
						<span class="icon-box panel-heading set-icon">
							<i class="fa fa-shopping-cart"></i>
						</span>

						<div class="text-box">
							<p class="main-text">{{$orders_count}} @lang('Orders')</p>
							<p class="text-muted">@lang('Total Orders!')</p>
						</div>
						<a href="{{route('manage.orders.index')}}"> @lang('More Details') </a>
					</div>

					<div class="row sub-counter">

						<div class="col-md-12">
							<div class="panel panel-danger">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-shopping-cart fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge">{{$pending_orders_count}}</div>
											<div>@lang('Pending Orders!')</div>
										</div>
									</div>
								</div>
								<a href="{{route('manage.orders.pending')}}">
									<div class="panel-footer">
										<span class="pull-left">@lang('View Details')</span>
										<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
										<div class="clearfix"></div>
									</div>
								</a>
							</div>
						</div>

					</div>
				</div>
				@endcan

				@can('read', App\Brand::class)
				<div class="col-lg-4 col-xs-12">
					<div class="panel panel-back panel-warning noti-box">
						<span class="icon-box panel-heading set-icon">
							<i class="fa fa-star"></i>
						</span>

						<div class="text-box">
							<p class="main-text">{{$brands_count}} @lang('Brands')</p>
							<p class="text-muted">@lang('Total Brands!')</p>
						</div>
						<a href="{{route('manage.brands.index')}}"> @lang('More Details') </a>
					</div>
					<div class="row sub-counter">
						<div class="col-md-12">
							<div class="panel panel-warning">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-tags fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge">{{$active_brands_count}}</div>
											<div>@lang('Active Brands!')</div>
										</div>
									</div>
								</div>
								<a href="{{route('manage.brands.index')}}?status=active">
									<div class="panel-footer">
										<span class="pull-left">@lang('View Details')</span>
										<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
										<div class="clearfix"></div>
									</div>
								</a>
							</div>
						</div>
					</div>
				</div>
				@endcan

				@can('view-sales', App\Other::class)
				<div class="col-lg-4 col-xs-12">
					<div class="panel panel-back panel-success noti-box">
						<span class="icon-box panel-heading set-icon">
							<i class="fa fa-arrow-up"></i>
						</span>

						<div class="text-box">
							<p class="main-text">{{$total_sales}} @lang('Sales')</p>
							<p class="text-muted">@lang('Total Sales!')</p>
						</div>
						<a href="{{route('manage.products.sales')}}"> @lang('More Details') </a>
					</div>
					<br>
					<div class="panel panel-back panel-success noti-box">
						<span class="icon-box panel-heading set-icon">
							<i class="fa fa-envelope"></i>
						</span>

						<div class="text-box">
							<p class="main-text">{{$invoices_count}} @lang('Invoices')</p>
							<p class="text-muted">@lang('Total Invoices!')</p>
						</div>
						<a href="{{route('manage.orders.invoices')}}"> @lang('More Details') </a>
					</div>
				</div>
				@endcan

			</div>

			@if(Auth::user()->can('read', App\Order::class) || Auth::user()->can('read', App\Brand::class) || Auth::user()->can('view-sales', App\Sales::class))
			<br><br>
			@endif
			<div class="row">
				
				@can('update-review', App\Review::class)
				<div class="col-lg-4 col-xs-12">
					<div class="panel panel-back panel-info noti-box">
						<span class="icon-box panel-heading set-icon">
							<i class="fa fa-star"></i>
						</span>

						<div class="text-box">
							<p class="main-text">{{$reviews_count}} @lang('Reviews')</p>
							<p class="text-muted">@lang('Total Reviews!')</p>
						</div>
						<a href="{{route('manage.reviews.index')}}"> @lang('More Details') </a>
					</div>
					<div class="row sub-counter">
						<div class="col-md-12">
							<div class="panel panel-info">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-star fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge">{{$pending_reviews_count}}</div>
											<div>@lang('Pending Reviews!')</div>
										</div>
									</div>
								</div>
								<a href="{{route('manage.reviews.index')}}?status=pending">
									<div class="panel-footer">
										<span class="pull-left">@lang('View Details')</span>
										<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
										<div class="clearfix"></div>
									</div>
								</a>
							</div>
						</div>
					</div>
				</div>
				@endcan

				@can('read', App\Deal::class)
				<div class="col-lg-4 col-xs-12">
					<div class="panel panel-back panel-danger noti-box">
						<span class="icon-box panel-heading set-icon">
							<i class="fa fa-tags"></i>
						</span>

						<div class="text-box">
							<p class="main-text">{{$deals_count}} @lang('Deals')</p>
							<p class="text-muted">@lang('Total Deals!')</p>
						</div>
						<a href="{{route('manage.deals.index')}}"> @lang('More Details') </a>
					</div>
					<div class="row sub-counter">
						<div class="col-md-12">
							<div class="panel panel-danger">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-tags fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge">{{$active_deals_count}}</div>
											<div>@lang('Active Deals!')</div>
										</div>
									</div>
								</div>
								<a href="{{route('manage.deals.index')}}?status=active">
									<div class="panel-footer">
										<span class="pull-left">@lang('View Details')</span>
										<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
										<div class="clearfix"></div>
									</div>
								</a>
							</div>
						</div>
					</div>
				</div>
				@endcan

				@can('read-coupon', App\Voucher::class)
				<div class="col-lg-4 col-xs-12">
					<div class="panel panel-back panel-primary noti-box">
						<span class="icon-box panel-heading set-icon">
							<i class="fa fa-gift"></i>
						</span>

						<div class="text-box">
							<p class="main-text">{{$coupons_count}} @lang('Coupons')</p>
							<p class="text-muted">@lang('Total Coupons!')</p>
						</div>
						<a href="{{route('manage.coupons.index')}}"> @lang('More Details') </a>
					</div>
					<div class="row sub-counter">
						<div class="col-md-12">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<div class="row">
										<div class="col-xs-3">
											<i class="fa fa-gift fa-5x"></i>
										</div>
										<div class="col-xs-9 text-right">
											<div class="huge">{{$active_coupons_count}}</div>
											<div>@lang('Active Coupons!')</div>
										</div>
									</div>
								</div>
								<a href="{{route('manage.coupons.index')}}?status=active">
									<div class="panel-footer">
										<span class="pull-left">@lang('View Details')</span>
										<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
										<div class="clearfix"></div>
									</div>
								</a>
							</div>
						</div>
					</div>
				</div>
				@endcan

			</div>

			@if(Auth::user()->can('update-review', App\Review::class) || Auth::user()->can('read', App\Deal::class) || Auth::user()->can('read-coupon', App\Voucher::class))
			<br><br>
			@endif
			<div class="row">

				@can('read', App\Banner::class)
				<div class="col-lg-4 col-xs-12">
					<div class="panel panel-back panel-primary noti-box">
						<span class="icon-box panel-heading set-icon">
							<i class="fa fa-picture-o"></i>
						</span>

						<div class="text-box">
							<p class="main-text">{{$active_banners_count}} @lang('Banners')</p>
							<p class="text-muted">@lang('Active Banners!')</p>
						</div>
						<a href="{{route('manage.banners.index')}}?status=active#banners-table"> @lang('More Details') </a>
					</div>
				</div>
				@endcan

				@can('view-subscribers', App\Other::class)
				<div class="col-lg-4 col-xs-12">
					<div class="panel panel-back panel-danger noti-box">
						<span class="icon-box panel-heading set-icon">
							<i class="fa fa-users"></i>
						</span>

						<div class="text-box">
							<p class="main-text">{{$verified_subscribers_count}} @lang('Subscribers')</p>
							<p class="text-muted">@lang('Verified Subscribers!')</p>
						</div>
						<a href="{{route('manage.subscribers')}}?status=verified"> @lang('More Details') </a>
					</div>
				</div>
				@endcan

				@can('read-discount', App\Voucher::class)				
				<div class="col-lg-4 col-xs-12">
					<div class="panel panel-back panel-info noti-box">
						<span class="icon-box panel-heading set-icon">
							<i class="fa fa-money"></i>
						</span>

						<div class="text-box">
							<p class="main-text">{{$active_product_discounts_count}} @lang('Discounts')</p>
							<p class="text-muted">@lang('Active Discounts!')</p>
						</div>
						<a href="{{route('manage.product-discounts.index')}}?status=active"> @lang('More Details') </a>
					</div>
				</div>
				@endcan

			</div>

		</div>
	</div>

	@if(Auth::user()->can('read', App\Banner::class) || Auth::user()->can('view-subscribers', App\Other::class) || Auth::user()->can('read-discount', App\Voucher::class))
	<br><br>
	@endif

	@can('view-sales', App\Other::class)
	<div class="row">
		<div class="col-lg-10 col-lg-offset-1 col-md-12">
			<div class="chartjs-top-selling-products">
				<div class="panel panel-primary">
					<div class="panel-heading"><strong>@lang('Top Selling Products')</strong></div>
						{!! $chartjs_top_selling_products->render() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
	@endcan
	
	@can('view-sales', App\Other::class)
	<br><br>
	@endcan

	@if(Auth::user()->can('read', App\Category::class) && Auth::user()->can('read', App\Brand::class) && Auth::user()->can('read', App\Product::class) && Auth::user()->can('read', App\User::class) && Auth::user()->can('read', App\Banner::class))
	<div class="row">
		<div class="col-lg-10 col-lg-offset-1 col-md-12">
			<div class="chartjs-count-data">
				{!! $charts_count_data->render() !!}
			</div>
		</div>
	</div>
	@endcan

	@can('read', App\Category::class)
	@if(count($root_categories) > 0)
	<div class="row">
		<div class="col-md-12">
			<h4 class="text-info">@lang('Categories Tree:')</h4>
			<ul id="tree1">
				@foreach($root_categories as $category)
					<li>
						{{ $category->name . ' (' . __('ID:') . ' '.$category->id.')' }}
						@if(count($category->categories))
							@include('partials.manage.subcategories', ['childs' => $category->categories])
						@endif
					</li>
				@endforeach
			</ul>
		</div>
	</div>
	@endif
	@endcan

@endsection