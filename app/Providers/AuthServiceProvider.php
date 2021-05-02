<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\Product' => 'App\Policies\ProductPolicy',
        'App\Brand' => 'App\Policies\BrandPolicy',
        'App\Banner' => 'App\Policies\BannerPolicy',
        'App\Section' => 'App\Policies\SectionPolicy',
        'App\Page' => 'App\Policies\PagePolicy',
        'App\Category' => 'App\Policies\CategoryPolicy',
        'App\Deal' => 'App\Policies\DealPolicy',
        'App\Role' => 'App\Policies\RolePolicy',
        'App\User' => 'App\Policies\UserPolicy',
        'App\Order' => 'App\Policies\OrderPolicy',
        'App\Other' => 'App\Policies\OtherPolicy',
        'App\Customer' => 'App\Policies\AddressPolicy',
		'App\Location' => 'App\Policies\LocationPolicy',
        'App\Voucher' => 'App\Policies\VoucherPolicy',
        'App\Review' => 'App\Policies\ReviewPolicy',
        'App\Shipment' => 'App\Policies\ShipmentPolicy',
        'App\Testimonial' => 'App\Policies\TestimonialPolicy',
        'App\Vendor' => 'App\Policies\VendorPolicy',
        'App\DeliveryLocation'  => 'App\Policies\DeliveryLocationPolicy',
        'App\ComparisionGroup'  => 'App\Policies\ComparisionGroupPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::resource('products', 'App\Policies\ProductPolicy');
        Gate::resource('brands', 'App\Policies\BrandPolicy');
        Gate::resource('pages', 'App\Policies\PagePolicy');
        Gate::resource('testimonials', 'App\Policies\TestimonialPolicy');
        Gate::resource('banners', 'App\Policies\BannerPolicy');
        Gate::resource('sections', 'App\Policies\SectionPolicy');
        Gate::resource('categories', 'App\Policies\CategoryPolicy');
        Gate::resource('deals', 'App\Policies\DealPolicy');
        Gate::resource('roles', 'App\Policies\RolePolicy');
        Gate::resource('users', 'App\Policies\UserPolicy');
        Gate::resource('orders', 'App\Policies\OrderPolicy');
        Gate::resource('addresses', 'App\Policies\AddressPolicy');
        Gate::resource('locations', 'App\Policies\LocationPolicy');
        Gate::resource('shipments', 'App\Policies\ShipmentPolicy');
		Gate::resource('vendors', 'App\Policies\VendorPolicy');
		Gate::resource('comparision_group', 'App\Policies\ComparisionGroupPolicy');
        Gate::resource('delivery-location', 'App\Policies\DeliveryLocationPolicy');
        Gate::define('create-discount', 'App\Policies\VoucherPolicy@createDiscount');
        Gate::define('read-discount', 'App\Policies\VoucherPolicy@readDiscount');
        Gate::define('update-discount', 'App\Policies\VoucherPolicy@updateDiscount');
        Gate::define('delete-discount', 'App\Policies\VoucherPolicy@deleteDiscount');
        Gate::define('create-coupon', 'App\Policies\VoucherPolicy@createCoupon');
        Gate::define('read-coupon', 'App\Policies\VoucherPolicy@readCoupon');
        Gate::define('update-coupon', 'App\Policies\VoucherPolicy@updateCoupon');
        Gate::define('delete-coupon', 'App\Policies\VoucherPolicy@deleteCoupon');
        Gate::define('view-dashboard', 'App\Policies\OtherPolicy@viewDashboard');
        Gate::define('update-settings', 'App\Policies\OtherPolicy@updateSettings');
        Gate::define('update-template-settings', 'App\Policies\OtherPolicy@updateTemplateSettings');
        Gate::define('view-customers', 'App\Policies\OtherPolicy@viewCustomers');
        Gate::define('update-customers', 'App\Policies\OtherPolicy@updateCustomers');
        Gate::define('view-sales', 'App\Policies\OtherPolicy@viewSales');
        Gate::define('view-reports', 'App\Policies\OtherPolicy@viewReports');
        Gate::define('view-subscribers', 'App\Policies\OtherPolicy@viewSubscribers');
        Gate::define('update-payment-settings', 'App\Policies\OtherPolicy@updatePaymentSettings');
        Gate::define('update-business-settings', 'App\Policies\OtherPolicy@updateBusinessSettings');
        Gate::define('update-email-settings', 'App\Policies\OtherPolicy@updateEmailSettings');
        Gate::define('update-sms-settings', 'App\Policies\OtherPolicy@updateSMSSettings');
        Gate::define('update-css-settings', 'App\Policies\OtherPolicy@updateCSSSettings');
        Gate::define('update-subscribers-settings', 'App\Policies\OtherPolicy@updateSubscribersSettings');
        Gate::define('update-delivery-settings', 'App\Policies\OtherPolicy@updateDeliverySettings');
        Gate::define('import-delete-subscribers', 'App\Policies\OtherPolicy@importDeleteSubscribers');
        Gate::define('manage-shipment-orders', 'App\Policies\OtherPolicy@manageShipmentOrders');
        Gate::define('update-review', 'App\Policies\ReviewPolicy@updateReview');
        Gate::define('delete-review', 'App\Policies\ReviewPolicy@deleteReview');
    }

}
