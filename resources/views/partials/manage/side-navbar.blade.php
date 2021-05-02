<nav class="navbar-default navbar-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="main-menu">
            <li class="text-center">
                <img height="128" width="128" src="{{Auth::user()->photo ? Auth::user()->photo->name : $default_photo}}" class="user-image img-responsive"/>
            </li>
            @if (Auth::user()->can('view-dashboard', App\Other::class))
                <li>
                    <a class="{{Html::isActive([route('manage.index')])}}" href="{{route('manage.index')}}"><i class="fa fa-dashboard fa-2x"></i> Dashboard</a>
                </li>
            @endif
            @if ((Auth::user()->can('read', App\Vendor::class)) && ((Auth::user()->can('delete', App\Vendor::class)) || (Auth::user()->can('update', App\Vendor::class)) || (Auth::user()->can('create', App\Vendor::class))))
                <li>
                    <a class="{{Html::isActive([route('manage.vendors.index'), route('manage.vendors.create'), route('manage.vendor.vendor_requests')])}}" href="{{route('manage.vendors.index')}}"><i class="fa fa-users fa-2x"></i> Vendors<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        @if (Auth::user()->can('read', App\Vendor::class))
                            <li>
                                <a href="{{route('manage.vendors.index')}}"><i class="fa fa-users"></i>View Vendors</a>
                            </li>
                        @endif
                        @if (Auth::user()->can('create', App\Vendor::class))
                            <li>
                                <a href="{{route('manage.vendors.create')}}"><i class="fa fa-users"></i>Add Vendor</a>
                            </li>
                        @endif
                        @if (Auth::user()->can('read', App\Vendor::class))
                            <li>
                                <a href="{{route('manage.vendor.vendor_requests')}}"><i class="fa fa-users"></i>Vendor Requests</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (($vendor = Auth::user()->isApprovedVendor()) || (Auth::user()->can('read', App\Product::class)) || (Auth::user()->can('delete', App\Product::class)) || (Auth::user()->can('update', App\Product::class)) || (Auth::user()->can('create', App\Product::class)) || (Auth::user()->can('read', App\Brand::class)) || (Auth::user()->can('delete', App\Brand::class)) || (Auth::user()->can('update', App\Brand::class)) || (Auth::user()->can('create', App\Brand::class)) || (Auth::user()->can('read', App\Category::class)) || (Auth::user()->can('delete', App\Category::class)) || (Auth::user()->can('update', App\Category::class)) || (Auth::user()->can('create', App\Category::class)) || Auth::user()->can('read-discount', App\Voucher::class) || Auth::user()->can('create-discount', App\Voucher::class) || Auth::user()->can('update-discount', App\Voucher::class) || Auth::user()->can('delete-discount', App\Voucher::class))
                @if (isset( $vendor ) && $vendor)
                <li>
                    <a class="{{Html::isActive([route('manage.vendor.dashboard')])}}" href="{{route('manage.vendor.dashboard')}}"><i class="fa fa-dashboard fa-2x"></i> Vendor Dashboard</a>
                </li>
                <li>
                    <a class="{{Html::isActive([route('manage.vendor.payments')])}}" href="{{route('manage.vendor.payments')}}"><i class="fa fa-credit-card fa-2x"></i> Payments</a>
                </li>
                @endif
                <li>
                    <a class="{{Html::isActive([route('manage.products.index'), route('manage.products.create'), route('manage.specification-types.index'), route('manage.brands.index'), route('manage.categories.index'), route('manage.product-discounts.index')])}}" href="{{route('manage.products.index')}}"><i class="fa fa-sitemap fa-2x"></i> Products<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        @if ((isset( $vendor ) && $vendor) || Auth::user()->can('read', App\Product::class))
                            <li>
                                <a href="{{route('manage.products.index')}}"><i class="fa fa-sitemap"></i>View Products</a>
                            </li>
                        @endif
                        @if ((isset( $vendor ) && $vendor) || Auth::user()->can('create', App\Product::class))
                            <li>
                                <a href="{{route('manage.products.create')}}"><i class="fa fa-sitemap"></i>Add Product</a>
                            </li>
                            @if(Auth::user()->can('create', App\Product::class))
                            <li>
                                <a href="{{route('manage.specification-types.index')}}"><i class="fa fa-list-alt"></i>Add Specifications</a>
                            </li>
                            @endif
                            @if(Auth::user()->can('create', App\ComparisionGroup::class))
                                <li>
                                    <a href="{{route('manage.comparision-group.index')}}"><i class="fa fa-arrows-h"></i>Add Comparision Group</a>
                                </li>
                            @endif
                        @endif
                        @if ((Auth::user()->can('read', App\Brand::class)) || (Auth::user()->can('delete', App\Brand::class)) || (Auth::user()->can('update', App\Brand::class)) || (Auth::user()->can('create', App\Brand::class)))
                            <li>
                                <a href="{{route('manage.brands.index')}}"><i class="fa fa-star"></i>Brands</a>
                            </li>
                        @endif
                        @if ((Auth::user()->can('read', App\Category::class)) || (Auth::user()->can('delete', App\Category::class)) || (Auth::user()->can('update', App\Category::class)) || (Auth::user()->can('create', App\Category::class)))
                            <li>
                                <a href="{{route('manage.categories.index')}}"><i class="fa fa-tags"></i>Categories</a>
                            </li>
                        @endif
                        @if (Auth::user()->can('read-discount', App\Voucher::class) || Auth::user()->can('create-discount', App\Voucher::class) || Auth::user()->can('update-discount', App\Voucher::class) || Auth::user()->can('delete-discount', App\Voucher::class))
                            <li>
                                <a href="{{route('manage.product-discounts.index')}}"><i class="fa fa-money"></i>Discounts</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if ((Auth::user()->can('read', App\Order::class)) || (Auth::user()->can('delete', App\Order::class)) || (Auth::user()->can('update', App\Order::class)) || (Auth::user()->can('create', App\Order::class)) || Auth::user()->can('read-coupon', App\Voucher::class) || Auth::user()->can('create-coupon', App\Voucher::class) || Auth::user()->can('update-coupon', App\Voucher::class) || Auth::user()->can('delete-coupon', App\Voucher::class) || (Auth::user()->can('manage-shipment-orders', App\Other::class)))
                <li>
                    <a class="{{Html::isActive([route('manage.orders.index'), route('manage.orders.pending'), route('manage.orders.invoices'), route('manage.coupons.index'), route('manage.coupons.create')])}}" href="{{route('manage.orders.index')}}"><i class="fa fa-shopping-cart fa-2x"></i> Orders<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        @if ((Auth::user()->can('read', App\Order::class)) || (Auth::user()->can('manage-shipment-orders', App\Other::class)))
                            @if (Auth::user()->can('manage-shipment-orders', App\Other::class))
                            <li>
                                <a href="{{route('manage.orders.index')}}"><i class="fa fa-shopping-cart"></i>View Orders</a>
                            </li>
                            @endif
                            @if (Auth::user()->can('read', App\Order::class))
                            <li>
                                <a href="{{route('manage.orders.pending')}}"><i class="fa fa-shopping-cart"></i>Pending Orders</a>
                            </li>
                            <li>
                                <a href="{{route('manage.orders.invoices')}}"><i class="fa fa-envelope"></i>Invoices</a>
                            </li>
                            @endif
                        @endif
                        @if (Auth::user()->can('read-coupon', App\Voucher::class) || Auth::user()->can('create-coupon', App\Voucher::class) || Auth::user()->can('update-coupon', App\Voucher::class) || Auth::user()->can('delete-coupon', App\Voucher::class))
                            <li>
                                <a class="{{Html::isActive([route('manage.coupons.index'), route('manage.coupons.create')])}}" href="{{route('manage.coupons.index')}}"><i class="fa fa-gift"></i> Coupons<span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    @if (Auth::user()->can('read-coupon', App\Voucher::class))
                                    <li>
                                        <a href="{{route('manage.coupons.index')}}"><i class="fa fa-gift"></i>View Coupons</a>
                                    </li>
                                    @endif
                                    @if (Auth::user()->can('create-coupon', App\Voucher::class))
                                    <li>
                                        <a href="{{route('manage.coupons.create')}}"><i class="fa fa-gift"></i>Add Coupon</a>
                                    </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (Auth::user()->can('view-customers', App\Other::class) || (Auth::user()->can('update-review', App\Review::class)) || (Auth::user()->can('delete-review', App\Review::class)))
                <li>
                    <a class="{{Html::isActive([route('manage.customers.index'), route('manage.reviews.index')])}}" href="{{route('manage.customers.index')}}"><i class="fa fa-users fa-2x"></i> Customers<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        @if (Auth::user()->can('view-customers', App\Other::class))
                            <li>
                                <a href="{{route('manage.customers.index')}}"><i class="fa fa-users"></i>View Customers</a>
                            </li>
                        @endif
                        @if ((Auth::user()->can('update-review', App\Review::class)) || (Auth::user()->can('delete-review', App\Review::class)))
                            <li>
                                <a href="{{route('manage.reviews.index')}}"><i class="fa fa-star"></i> Reviews</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if ((Auth::user()->can('read', App\Shipment::class)) && ((Auth::user()->can('delete', App\Shipment::class)) || (Auth::user()->can('update', App\Shipment::class)) || (Auth::user()->can('create', App\Shipment::class))))
                <li>
                    <a class="{{Html::isActive([route('manage.shipments.index'), route('manage.shipments.create')])}}" href="{{route('manage.shipments.index')}}"><i class="fa fa-truck fa-2x"></i> Shipments<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        @if (Auth::user()->can('read', App\Shipment::class))
                            <li>
                                <a href="{{route('manage.shipments.index')}}"><i class="fa fa-map-marker"></i>View Shipments</a>
                            </li>
                        @endif
                        @if (Auth::user()->can('create', App\Shipment::class))
                            <li>
                                <a href="{{route('manage.shipments.create')}}"><i class="fa fa-map-marker"></i>Add Shipment</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if ((Auth::user()->can('view', App\DeliveryLocation::class)) && ((Auth::user()->can('delete', App\DeliveryLocation::class)) || (Auth::user()->can('update', App\DeliveryLocation::class)) || (Auth::user()->can('create', App\DeliveryLocation::class))))
                <li>
                    <a class="{{Html::isActive([route('manage.delivery-location.index'), route('manage.delivery-location.create')])}}" href="{{route('manage.delivery-location.index')}}"><i class="fa fa-location-arrow fa-2x"></i> Delivery Location<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        @if (Auth::user()->can('view', App\DeliveryLocation::class))
                            <li>
                                <a href="{{route('manage.delivery-location.index')}}"><i class="fa fa-map-marker"></i>View Delivery Locations</a>
                            </li>
                        @endif
                        @if (Auth::user()->can('create', App\DeliveryLocation::class))
                            <li>
                                <a href="{{route('manage.delivery-location.create')}}"><i class="fa fa-map-marker"></i>Add Delivery Location</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            @if (Auth::user()->can('view-sales', App\Other::class) || Auth::user()->can('view-reports', App\Other::class))
                <li>
                    <a class="{{Html::isActive([route('manage.products.sales'), route('manage.reports.product_sales')])}}" href="{{route('manage.products.sales')}}"><i class="fa fa-bar-chart fa-2x"></i> Report<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        @if (Auth::user()->can('view-reports', App\Other::class))
                            <li>
                                <a href="{{route('manage.reports.product_sales')}}"><i class="fa fa-bar-chart"></i>Product Sales Reports</a>
                            </li>
                        @endif
                        @if (Auth::user()->can('view-sales', App\Other::class))
                            <li>
                                <a href="{{route('manage.products.sales')}}"><i class="fa fa-arrow-up"></i>View Sales</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if ((Auth::user()->can('read', App\User::class)) || (Auth::user()->can('update', App\User::class)) || (Auth::user()->can('create', App\User::class)) || (Auth::user()->can('read', App\Role::class)) || (Auth::user()->can('delete', App\Role::class)) || (Auth::user()->can('update', App\Role::class)) || (Auth::user()->can('create', App\Role::class)))
                <li>
                    <a class="{{Html::isActive([route('manage.users.index'), route('manage.users.create'), route('manage.roles.index'), route('manage.roles.create')])}}" href="{{route('manage.users.index')}}"><i class="fa fa-users fa-2x"></i> Staff<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        @if (Auth::user()->can('read', App\User::class)) 
                            <li>
                                <a href="{{route('manage.users.index')}}"><i class="fa fa-users"></i>View Staff</a>
                            </li>
                        @endif
                        @if (Auth::user()->can('create', App\User::class))
                            <li>
                                <a href="{{route('manage.users.create')}}"><i class="fa fa-users"></i>Add Staff</a>
                            </li>
                        @endif
                        @if ((Auth::user()->can('read', App\Role::class)) || (Auth::user()->can('delete', App\Role::class)) || (Auth::user()->can('update', App\Role::class)) || (Auth::user()->can('create', App\Role::class)))
                            <li>
                                <a class="{{Html::isActive([route('manage.roles.index'), route('manage.roles.create')])}}" href="{{route('manage.roles.index')}}"><i class="fa fa-shield"></i> Roles<span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    @if (Auth::user()->can('read', App\Role::class))
                                        <li>
                                            <a href="{{route('manage.roles.index')}}"><i class="fa fa-shield"></i>View Roles</a>
                                        </li>
                                    @endif
                                    @if (Auth::user()->can('create', App\Role::class))
                                        <li>
                                            <a href="{{route('manage.roles.create')}}"><i class="fa fa-shield"></i>Add Role</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if ((Auth::user()->can('read', App\Banner::class)) || (Auth::user()->can('delete', App\Banner::class)) || (Auth::user()->can('update', App\Banner::class)) || (Auth::user()->can('create', App\Banner::class)) || (Auth::user()->can('read', App\Deal::class)) || (Auth::user()->can('create', App\Deal::class)))
                <li>
                    <a class="{{Html::isActive([route('manage.deals.index'), route('manage.deals.create'), route('manage.banners.index')])}}" href="{{route('manage.deals.index')}}"><i class="fa fa-picture-o fa-2x"></i> Deals<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        @if (Auth::user()->can('read', App\Deal::class))
                            <li>
                                <a href="{{route('manage.deals.index')}}"><i class="fa fa-tags"></i>View Deals</a>
                            </li>
                        @endif
                        @if (Auth::user()->can('create', App\Deal::class))
                            <li>
                                <a href="{{route('manage.deals.create')}}"><i class="fa fa-tags"></i>Add Deal</a>
                            </li>
                        @endif
                        @if ((Auth::user()->can('read', App\Banner::class)) || (Auth::user()->can('delete', App\Banner::class)) || (Auth::user()->can('update', App\Banner::class)) || (Auth::user()->can('create', App\Banner::class)))
                            <li>
                                <a href="{{route('manage.banners.index')}}"><i class="fa fa-picture-o"></i>Banners</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if ((Auth::user()->can('read', App\Page::class)) || (Auth::user()->can('delete', App\Page::class)) || (Auth::user()->can('update', App\Page::class)) || (Auth::user()->can('create', App\Page::class)) || (Auth::user()->can('read', App\Section::class)) || (Auth::user()->can('delete', App\Section::class)) || (Auth::user()->can('update', App\Section::class)) || (Auth::user()->can('create', App\Section::class)))
                <li>
                    <a class="{{Html::isActive([route('manage.pages.index'), route('manage.pages.create'), route('manage.sections.index')])}}" href="{{route('manage.pages.index')}}"><i class="fa fa-newspaper-o fa-2x"></i> Pages<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        @if (Auth::user()->can('read', App\Page::class))
                            <li>
                                <a href="{{route('manage.pages.index')}}"><i class="fa fa-newspaper-o"></i>View Pages</a>
                            </li>
                        @endif
                        @if (Auth::user()->can('create', App\Page::class))
                            <li>
                                <a href="{{route('manage.pages.create')}}"><i class="fa fa-newspaper-o"></i>Add Page</a>
                            </li>
                        @endif
                        @if ((Auth::user()->can('read', App\Section::class)) || (Auth::user()->can('delete', App\Section::class)) || (Auth::user()->can('update', App\Section::class)) || (Auth::user()->can('create', App\Section::class)))
                            <li>
                                <a href="{{route('manage.sections.index')}}"><i class="fa fa-picture-o"></i>Sections</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if ((Auth::user()->can('read', App\Testimonial::class)) && ((Auth::user()->can('delete', App\Testimonial::class)) || (Auth::user()->can('update', App\Testimonial::class)) || (Auth::user()->can('create', App\Testimonial::class))))
                <li>
                    <a class="{{Html::isActive([route('manage.testimonials.index'), route('manage.testimonials.create')])}}" href="{{route('manage.testimonials.index')}}"><i class="fa fa-quote-left fa-2x"></i> Testimonials<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        @if (Auth::user()->can('read', App\Testimonial::class))
                            <li>
                                <a href="{{route('manage.testimonials.index')}}"><i class="fa fa-quote-left"></i>View Testimonials</a>
                            </li>
                        @endif
                        @if (Auth::user()->can('create', App\Testimonial::class))
                            <li>
                                <a href="{{route('manage.testimonials.create')}}"><i class="fa fa-quote-left"></i>Add Testimonial</a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif
            @if (Auth::user()->can('view-subscribers', App\Other::class) || Auth::user()->can('update-subscribers-settings', App\Other::class))
                <li>
                    <a class="{{Html::isActive([route('manage.subscribers'), route('manage.settings.subscribers')])}}" href="{{route('manage.subscribers')}}"><i class="fa fa-users fa-2x"></i> Subscribers<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                    @if (Auth::user()->can('view-subscribers', App\Other::class))
                        <li>
                            <a href="{{route('manage.subscribers')}}"><i class="fa fa-users"></i>View Subscribers</a>
                        </li>
                    @endif
                    @if (Auth::user()->can('update-subscribers-settings', App\Other::class))
                        <li>
                            <a href="{{route('manage.settings.subscribers')}}"><i class="fa fa-wrench"></i>Settings</a>
                        </li>
                    @endif
                    </ul>
                </li>
            @endif
            <li>
                <a class="{{Html::isActive([route('manage.settings.index'), route('manage.settings.profile'), route('manage.settings.payment'), route('manage.settings.business'), route('manage.settings.email'), route('manage.settings.css')])}}" href="{{route('manage.settings.index')}}"><i class="fa fa-wrench fa-2x"></i> Settings<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    @if (Auth::user()->can('update-settings', App\Other::class))
                        <li>
                            <a href="{{route('manage.settings.index')}}"><i class="fa fa-list-alt"></i>Overview</a>
                        </li>
                    @endif
                    <li>
                        <a href="{{route('manage.settings.profile')}}"><i class="fa fa-user"></i>Profile</a>
                    </li>
                    @if (Auth::user()->can('update-payment-settings', App\Other::class))
                    <li>
                        <a href="{{route('manage.settings.payment')}}"><i class="fa fa-credit-card"></i>Payment</a>
                    </li>
                    @endif
                    @if (Auth::user()->can('update-delivery-settings', App\Other::class))
                    <li>
                        <a href="{{route('manage.settings.delivery')}}"><i class="fa fa-map-marker"></i>Delivery</a>
                    </li>
                    @endif
                    @if (Auth::user()->can('update-business-settings', App\Other::class))
                    <li>
                        <a href="{{route('manage.settings.business')}}"><i class="fa fa-briefcase"></i>Business</a>
                    </li>
                    @endif
                    @if (Auth::user()->can('update-email-settings', App\Other::class))
                    <li>
                        <a href="{{route('manage.settings.email')}}"><i class="fa fa-envelope"></i>Email</a>
                    </li>
                    @endif
                    @if (Auth::user()->can('update-sms-settings', App\Other::class))
                    <li>
                        <a href="{{route('manage.settings.sms')}}"><i class="glyphicon glyphicon-envelope"></i>SMS</a>
                    </li>
                    @endif
                    @if (Auth::user()->can('update-css-settings', App\Other::class))
                    <li>
                        <a href="{{route('manage.settings.css')}}"><i class="fa fa-code"></i>Custom CSS</a>
                    </li>
                    @endif
                    @if (Auth::user()->can('update-template-settings', App\Other::class))
                        <li>
                            <a href="{{route('manage.settings.template')}}"><i class="fa fa-newspaper-o"></i>Import Demo</a>
                        </li>
                    @endif
                </ul>
            </li>
        </ul>
    </div>
</nav>
