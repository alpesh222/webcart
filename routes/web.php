<?php

Route::group(['middleware' => ['language']], function() {

Route::group(['middleware' => ['webcart']], function() {

// Authentication Routes
Route::auth();

// Manage Routes
Route::group(['middleware' => ['auth', 'manage'], 'as' => 'manage.', 'prefix' => 'manage'], function () {

    // Manage Index Route
    Route::get('/', 'ManageController@index')->name('index');
    Route::post('/', 'ManageController@index')->name('index');

    // Manage Users Routes
    Route::resource('/users', 'ManageUsersController', ['except' => [
        'show', 'destroy'
    ]]);

    // Manage Categories Routes
    Route::resource('/categories', 'ManageCategoriesController', ['except' => [
       'create', 'show'
    ]]);
    Route::delete('/delete/categories', 'ManageCategoriesController@deleteCategories');

    // Manage Brands Routes
    Route::resource('/brands', 'ManageBrandsController', ['except' => [
       'create', 'show'
    ]]);
    Route::delete('/delete/brands', 'ManageBrandsController@deleteBrands');

    // Manage Pages Routes
    Route::resource('/pages', 'ManagePagesController', ['except' => [
        'show'
    ]]);
    Route::delete('/delete/pages', 'ManagePagesController@deletePages');

    // Manage Testimonials Routes
    Route::resource('/testimonials', 'ManageTestimonialsController', ['except' => [
        'show'
    ]]);
    Route::delete('/delete/testimonials', 'ManageTestimonialsController@deleteTestimonials');

    // Manage Products Routes
    Route::resource('/products', 'ManageProductsController', ['except' => [
        'show'
    ]]);
    Route::delete('/delete/products', 'ManageProductsController@deleteProducts');
    Route::patch('/more-images/product/{id}', 'ManageProductsController@storeMoreImages');
    Route::get('/existing-product/{id}', 'ManageProductsController@getExistingProduct');

    // Manage Vendors Routes
    Route::get('/vendor/dashboard', 'ManageVendorsController@dashboard')->name('vendor.dashboard');
    Route::get('/vendor/payments', 'ManageVendorsController@payments')->name('vendor.payments');
    Route::resource('/vendors', 'ManageVendorsController');
    Route::get('/vendor/vendors_request', 'ManageVendorsController@vendorRequest')->name('vendor.vendor_requests');
    Route::delete('/delete/vendors', 'ManageVendorsController@deleteVendors');
    Route::post('/vendor/payment', 'ManageVendorsController@vendorPayment')->name('vendor.payment');
    Route::post('/vendor/payment/update-status', 'ManageVendorsController@updatePaymentStatus')->name('vendor.updatePaymentStatus');

    Route::get('/vendor/payment/paypal/return', 'ManageVendorsController@vendorPaymentPaypalReturn')->name('vendor.payment.paypal.return');
    Route::get('/vendor/payment/paypal/cancel', 'ManageVendorsController@vendorPaymentPaypalCancel')->name('vendor.payment.paypal.cancel');

    Route::post('/vendor/submit-payout-request', 'ManageVendorsController@submitPayoutRequest')->name('vendor.submit-payout-request');
    Route::post('/vendor/settings/payments', 'ManageVendorsController@updatePaymentSettings')->name('vendor.settings.payments');

    // Manage Specifications Routes
    Route::resource('/specification-types', 'ManageSpecificationTypesController', ['except' => [
       'create', 'show'
    ]]);
    Route::delete('/delete/specifications-types', 'ManageSpecificationTypesController@deleteSpecificationTypes');

    // Manage Comparision Group Route
    Route::resource('/comparision-group', 'ManageComparisionGroupsController');
    Route::delete('/delete/comparision-group', 'ManageComparisionGroupsController@deleteComparisionGroups');
    // Manage Sales Route
    Route::get('/sales', 'ManageProductsController@sales')->name('products.sales');

    // Manage Orders Routes
    Route::resource('/orders', 'ManageOrdersController', ['except' => [
       'create', 'store'
    ]]);
    Route::delete('/delete/orders', 'ManageOrdersController@deleteOrders');

    // Manage Invoices Route
    Route::get('/invoices', 'ManageOrdersController@invoices')->name('orders.invoices');

    // Manage Pending Orders Route
    Route::get('/pending-orders', 'ManageOrdersController@pending')->name('orders.pending');

    // Manage Roles Routes
    Route::resource('/roles', 'ManageRolesController', ['except' => [
        'show'
    ]]);
    Route::delete('/delete/roles', 'ManageRolesController@deleteRoles');

    // Manage Customers Routes
    Route::resource('/customers', 'ManageCustomersController', ['except' => [
       'create', 'store', 'show'
    ]]);
    Route::delete('/delete/customers', 'ManageCustomersController@deleteCustomers');

    Route::get('/customers/promote_vendor/{id}', 'ManageCustomersController@promoteCustomer')->name('customers.promote');

    // Manage Customers Addresses Routes
    Route::resource('/customer-address', 'ManageAddressesController', ['only' => [
        'edit', 'update', 'destroy'
     ]]);

    Route::get('/customer/{id}/orders', 'ManageCustomersController@viewUserOrders')->name('customer.orders');

    // Manage Coupons Routes
    Route::resource('/coupons', 'ManageCouponsController', ['except' => [
        'show'
    ]]);
    Route::delete('/delete/coupons', 'ManageCouponsController@deleteCoupons');

    // Manage Deals Routes
    Route::resource('/deals', 'ManageDealsController', ['except' => [
        'show'
    ]]);
    Route::delete('/delete/deals', 'ManageDealsController@deleteDeals');

    // Manage Banners Routes
    Route::resource('/banners', 'ManageBannersController', ['except' => [
        'show'
    ]]);
    Route::delete('/delete/banners', 'ManageBannersController@deleteBanners');

    // Manage Sections Routes
    Route::resource('/sections', 'ManageSectionsController', ['except' => [
        'show'
    ]]);
    Route::delete('/delete/sections', 'ManageSectionsController@deleteSections');

    // Manage Product Discounts Routes
    Route::resource('/product-discounts', 'ManageProductDiscountsController', ['except' => [
       'show'
    ]]);
    Route::delete('/delete/product-discounts', 'ManageProductDiscountsController@deleteProductDiscounts');

    // Manage Reviews Routes
    Route::resource('/reviews', 'ManageReviewsController', ['except' => [
       'create', 'store', 'update'
    ]]);
    Route::post('/set-status/reviews', 'ManageReviewsController@setReviewsStatus');

    // Manage Settings Routes
    Route::get('/settings', 'ManageSettingsController@index')->name('settings.index');
    Route::patch('/settings/update-store', 'ManageSettingsController@updateStore')->name('settings.updateStore');
    Route::patch('/settings/update-theme', 'ManageSettingsController@updateTheme')->name('settings.updateTheme');
    Route::patch('/settings/update-live-chat', 'ManageSettingsController@updateLiveChat')->name('settings.updateLiveChat');
    Route::patch('/settings/update-tax-shipping', 'ManageSettingsController@updateTaxShipping')->name('settings.updateTaxShipping');
    Route::patch('/settings/update-vendor', 'ManageSettingsController@updateVendor')->name('settings.updateVendor');
    Route::patch('/settings/update-admin-panel', 'ManageSettingsController@updateAdminPanel')->name('settings.updateAdminPanel');
    Route::patch('/settings/update-google-recaptcha', 'ManageSettingsController@updateRecaptcha')->name('settings.updateRecaptcha');
    Route::patch('/settings/update-google-map', 'ManageSettingsController@updateGoogleMap')->name('settings.updateGoogleMap');
    Route::patch('/settings/update-google-analytics', 'ManageSettingsController@updateGoogleAnalytics')->name('settings.updateGoogleAnalytics');
    Route::patch('/settings/update-site-map', 'ManageSettingsController@updateSiteMap')->name('settings.updateSiteMap');
    Route::patch('/settings/update-referral', 'ManageSettingsController@updateReferral')->name('settings.updateReferral');
    Route::get('/settings/profile', 'ManageSettingsController@profile')->name('settings.profile');
    Route::patch('/settings/update-profile', 'ManageSettingsController@updateProfile')->name('settings.updateProfile');

    // Manage Template Settings Routes
    Route::get('/settings/template', 'ManageAppSettingsController@template')->name('settings.template');
    Route::patch('/settings/update-template', 'ManageAppSettingsController@updateTemplate')->name('settings.updateTemplate');

    // Manage Payment Settings Routes
    Route::get('/settings/payment', 'ManageAppSettingsController@payment')->name('settings.payment');
    Route::patch('/settings/payment-cod', 'ManageAppSettingsController@updatePaymentCOD')->name('payment-settings.updatePaymentCOD');
    Route::patch('/settings/payment-paypal', 'ManageAppSettingsController@updatePaymentPaypal')->name('payment-settings.updatePaymentPaypal');
    Route::patch('/settings/payment-stripe', 'ManageAppSettingsController@updatePaymentStripe')->name('payment-settings.updatePaymentStripe');
    Route::patch('/settings/payment-razorpay', 'ManageAppSettingsController@updatePaymentRazorpay')->name('payment-settings.updatePaymentRazorpay');
    Route::patch('/settings/payment-instamojo', 'ManageAppSettingsController@updatePaymentInstamojo')->name('payment-settings.updatePaymentInstamojo');
    Route::patch('/settings/payment-payumoney', 'ManageAppSettingsController@updatePaymentPayUmoney')->name('payment-settings.updatePaymentPayUmoney');
    Route::patch('/settings/payment-payubiz', 'ManageAppSettingsController@updatePaymentPayUbiz')->name('payment-settings.updatePaymentPayUbiz');
    Route::patch('/settings/payment-banktransfer', 'ManageAppSettingsController@updatePaymentBankTransfer')->name('payment-settings.updatePaymentBankTransfer');
    Route::patch('/settings/wallet-use', 'ManageAppSettingsController@updatePaymentWallet')->name('payment-settings.updatePaymentWallet');
    Route::patch('/settings/cashback', 'ManageAppSettingsController@updatePaymentCashback')->name('payment-settings.updatePaymentCashback');

    // Manage Delivery Settings Routes
    Route::get('/settings/delivery', 'ManageAppSettingsController@delivery')->name('settings.delivery');
    Route::patch('/settings/delivery-template', 'ManageAppSettingsController@updateDeliveryTemplate')->name('settings.updateDeliveryTemplate');
    Route::patch('/settings/delivery-delhivery', 'ManageAppSettingsController@updateDeliveryDelhivery')->name('delivery-settings.updateDeliveryDelhivery');


    Route::patch('/settings/payment-paystack', 'ManageAppSettingsController@updatePaymentPaystack')->name('payment-settings.updatePaymentPaystack');
    Route::patch('/settings/payment-paytm', 'ManageAppSettingsController@updatePaymentPaytm')->name('payment-settings.updatePaymentPaytm');
    Route::patch('/settings/payment-pesapal', 'ManageAppSettingsController@updatePaymentPesapal')->name('payment-settings.updatePaymentPesapal');

    // Manage Business Settings Routes
    Route::get('/settings/business', 'ManageAppSettingsController@business')->name('settings.business');
    Route::patch('/settings/business', 'ManageAppSettingsController@updateBusiness')->name('settings.updateBusiness');

    // Manage Email Settings Routes
    Route::get('/settings/email', 'ManageAppSettingsController@email')->name('settings.email');
    Route::patch('/settings/email-template', 'ManageAppSettingsController@updateEmailTemplate')->name('settings.updateEmailTemplate');
    Route::patch('/settings/email-smtp', 'ManageAppSettingsController@updateEmailSmtp')->name('settings.updateEmailSmtp');
    Route::patch('/settings/email-mailgun', 'ManageAppSettingsController@updateEmailMailgun')->name('settings.updateEmailMailgun');
    Route::post('/test/email', 'ManageTestController@testEmail')->name('test.email');

    // Manage SMS Settings Routes
    Route::get('/settings/sms', 'ManageAppSettingsController@sms')->name('settings.sms');
    Route::patch('/settings/sms-template', 'ManageAppSettingsController@updateSMSTemplate')->name('settings.updateSMSTemplate');
    Route::patch('/settings/sms-otp', 'ManageAppSettingsController@updateSMSOtp')->name('settings.updateSMSOtp');
    Route::patch('/settings/sms-msgclub', 'ManageAppSettingsController@updateSMSMsgClub')->name('settings.updateSMSMsgClub');
    Route::patch('/settings/sms-pointsms', 'ManageAppSettingsController@updateSMSPointSMS')->name('settings.updateSMSPointSMS');
    Route::patch('/settings/sms-nexmo', 'ManageAppSettingsController@updateSMSNexmo')->name('settings.updateSMSNexmo');
    Route::patch('/settings/sms-textlocal', 'ManageAppSettingsController@updateSMSTextlocal')->name('settings.updateSMSTextlocal');
    Route::patch('/settings/sms-twilio', 'ManageAppSettingsController@updateSMSTwilio')->name('settings.updateSMSTwilio');
    Route::patch('/settings/sms-ebulk', 'ManageAppSettingsController@updateSMSeBulk')->name('settings.updateSMSeBulk');
    Route::post('/test/sms', 'ManageTestController@testSMS')->name('test.sms');

    // Manage CSS Editor Settings Routes
    Route::get('/settings/css-editor', 'ManageAppSettingsController@cssEditor')->name('settings.css');
    Route::patch('/settings/store-css', 'ManageAppSettingsController@updateStoreCSS')->name('settings.updateStoreCSS');
    Route::patch('/settings/admin-css', 'ManageAppSettingsController@updateAdminCSS')->name('settings.updateAdminCSS');
    Route::patch('/settings/panel-css', 'ManageAppSettingsController@updatePanelCSS')->name('settings.updatePanelCSS');

    // Manage Subscribers Settings Routes
    Route::get('/settings/subscribers', 'ManageAppSettingsController@subscribers')->name('settings.subscribers');
    Route::patch('/settings/subscribers', 'ManageAppSettingsController@updateSubscribers')->name('settings.updateSubscribers');
    Route::patch('/settings/mailchimp', 'ManageAppSettingsController@updateMailChimp')->name('settings.updateMailChimp');
    Route::patch('/settings/subscribersDetails', 'ManageAppSettingsController@updateSubsDetails')->name('settings.updateSubsDetails');

    // Manage Reports Routes
    Route::get('/reports/product-sales', 'ManageReportsController@product_sales')->name('reports.product_sales');
    Route::post('/reports/product-sales', 'ManageReportsController@product_sales');

    // Manage Subscribers Routes
    Route::get('/subscribers', 'ManageSubscribersController@index')->name('subscribers');
    Route::post('/subscribers/import', 'ManageSubscribersController@importSubscribers')->name('subscribers.import');
    Route::delete('/delete/subscribers', 'ManageSubscribersController@deleteSubscribers');

    // Manage Shipments Routes
    Route::resource('/shipments', 'ManageShipmentsController', ['except' => [
       'show'
    ]]);
    Route::delete('/delete/shipments', 'ManageShipmentsController@deleteShipments');

    Route::resource('/delivery-location', 'ManageDeliveryLocationController', ['except' => [
       'show'
    ]]);
    Route::delete('/delete/delivery-locations', 'ManageDeliveryLocationController@deleteDeliveryLocation');

    // File Download Route
    Route::get('/download/{filename}', 'ManageProductsController@download')->name('download');

    // Ajax Routes
    Route::get('/ajax/user/get-user-data/{user_name}', ['uses'=>'ManageUsersController@getUserData']);
    Route::get('/ajax/specifications/category/{category_id}', ['uses'=>'ManageCategoriesController@getSpecifications']);
    Route::get('/settings/enablePaymentMethod/{payment_method}', 'ManageAppSettingsController@enablePaymentMethod')->name('payment-settings.enablePaymentMethod');
    Route::get('/settings/enableDeliveryMethod/{delivery_method}', 'ManageAppSettingsController@enableDeliveryMethod')->name('delivery-settings.enableDeliveryMethod');

});

// Front Routes
Route::group(['as'=>'front.'], function () {

    // Front Index Route
    Route::get('/', 'FrontController@index')->name('index');
    Route::get('/lang/{language?}', 'FrontController@index')->name('index');

    // Front Products Route
    Route::get('/products', 'FrontController@products')->name('products');

    // Front Search Route
    Route::get('/search', 'FrontController@search')->name('search');
    Route::get('/search/autocomplete', 'FrontController@autocomplete');

    // Register Controller Route
    Route::get('/checkValidReferralCode', 'Auth\RegisterController@checkValidReferralCode')->name('register.checkValidReferralCode');

    // Front Page Route
    Route::get('/{slug}', 'FrontPageController@show')->where('slug', '(?>[\w-]+)(?<!cart|contact-us|account-overview|orders|addresses|wallet-history|referrals|laravel-filemanager)')->name('page.show');

    // Front Product Route
    Route::get('/product/{slug}', 'FrontProductController@show')->name('product.show');

    // Front Brand Route
    Route::get('/brand/{slug}', 'FrontBrandController@show')->name('brand.show');

    // Front Category Route
    Route::get('/category/{slug}', 'FrontCategoryController@show')->name('category.show');

    // Front Deal Route
    Route::get('/deal/{slug}', 'FrontDealController@show')->name('deal.show');

    // Front Vendor Route
    Route::get('/shop/{slug}', 'FrontVendorController@show')->name('vendor.show');

    // Front Cart Routes
    Route::resource('/cart', 'FrontCartController', ['except' => [
       'create', 'store', 'show', 'edit'
    ]]);
    Route::get('/cart/ajax','FrontCartController@ajaxCartData');
    Route::get('/cart/refreshCartPage','FrontCartController@refreshCartPage');
    Route::patch('/cart/add/{id}', 'FrontCartController@add')->name('cart.add');
    Route::patch('/cart/update/{id}/{quantity}', 'FrontCartController@update')->name('cart.update');
    Route::get('/cart/empty', 'FrontCartController@emptyCart')->name('cart.emptyCart');
    Route::get('/cart/cartCount', 'FrontCartController@cartCount')->name('cart.cartCount');

    // For Ajax Request
    Route::get('/cart/add/{id}', 'FrontCartController@add')->name('cart.add');
    Route::get('/cart/update/{id}/{quantity}', 'FrontCartController@updateAjax')->name('cart.updateAjax');

    // Front Contact Form Routes
    Route::get('/contact-us', 'FrontContactFormController@contactForm')->name('contact');
    Route::post('/contact-us', 'FrontContactFormController@sendEmail');
    Route::get('/ajax/checkShippingAvailability/{pincode}', ['uses'=>'ManageDeliveryLocationController@checkShippingAvailability']);

    Route::group(['middleware' => ['auth']], function() {

        // Front Settings Route
        Route::get('/settings/profile', 'FrontSettingsController@profile')->name('settings.profile');
        Route::patch('/settings/updateProfile', 'FrontSettingsController@updateProfile')->name('settings.updateProfile');

        // Front Wishlist Routes
        Route::post('/products/{product}/favourites', 'FrontProductController@store')->name('product.favourite.store');
        Route::get('products/wishlist', 'FrontProductController@wishlist')->name('product.favourite.index');
        Route::delete('/products/{product}/favourites', 'FrontProductController@destroy')->name('product.favourite.destroy');

        // Front Customers/Addresses Routes
        Route::resource('/customers', 'FrontCustomersController', ['except' => [
            'index', 'edit', 'create', 'show'
        ]]);
        Route::post('/addresses', 'FrontCustomersController@startPaymentSession')->name('addresses.session');
        Route::get('/addresses', 'FrontCustomersController@index')->name('addresses.index');
        Route::get('/addresses/edit/{id}', 'FrontCustomersController@edit')->name('addresses.edit');

        // Front Orders Routes
        Route::resource('/orders', 'FrontOrdersController', ['except' => [
            'create', 'store', 'edit', 'update', 'destroy'
        ]]);
        Route::get('/wallet-history','FrontCustomersController@walletHistory')->name('wallet-history.index');
        Route::patch('/orders/{id}', 'FrontOrdersController@hide');

        Route::get('/referrals','FrontCustomersController@userReferrals')->name('referrals.index');
        Route::get('/referrals/generate-referral-code','FrontCustomersController@generateUserReferralCode')->name('referrals.generateUserReferralCode');

        // Front Account Overview Route
        Route::get('account-overview', 'FrontController@account')->name('account');

        // Front Reviews Routes
        Route::resource('/reviews', 'FrontReviewsController', ['only' => ['store', 'edit', 'update']]);

        // Front Coupons Routes
        Route::post('/coupons', 'FrontCouponsController@checkCoupon');

        // File Download Route
        Route::post('/download', 'FrontOrdersController@download');

        // Front Vendor Profile Route
        Route::get('/vendor/profile', 'FrontVendorController@profile')->name('vendor.profile');
        Route::patch('/vendor/updateProfile', 'FrontVendorController@updateProfile')->name('settings.updateProfile');

        // Callback Url
        Route::post('/paytm/payment/status', 'PaytmController@paymentCallback');
        Route::get('/paystack/paystack-callback', 'PaystackController@paystackCallback');
    });

    // Ajax Routes
    Route::get('/ajax/{type}/{slug?}', ['uses'=>'FrontController@products']);
    Route::get('/ajax/product/get-variant/{product_id}/{variant_keys}/{value_keys}', ['uses'=>'FrontProductController@getVariantData']);
    Route::get('/ajax/reviews-approved/product/{product_id}', ['uses'=>'FrontReviewsController@reviews']);

});

// Checkout Routes
Route::group(['middleware' => ['auth'], 'as' => 'checkout.', 'prefix' => 'checkout'], function() {

    // Shipping Details Route
    Route::get('/shipping-details', 'CheckoutController@shipping')->name('shipping');

    // Payment Routes
    Route::get('/refreshCheckoutPage', 'CheckoutController@refreshCheckoutPage')->name('payment.refreshCheckoutPage');
    Route::get('/payment', 'CheckoutController@payment')->name('payment');
    Route::post('/process-payment', 'CheckoutController@processPayment')->name('payment.process');
    Route::get('/process-payment', 'CheckoutController@processPaymentGet');

    // Change Shipping Address Route
    Route::post('/change-shipping', 'CheckoutController@changeShippingAddress')->name('shipping.change');

});

// Payments Routes
Route::group(['middleware' => ['auth']], function() {

    // Paypal Routes
    Route::get('paypal/ec-checkout', 'PaypalController@getExpressCheckout');
    Route::get('paypal/ec-checkout-success', 'PaypalController@getExpressCheckoutSuccess');
    Route::get('paypal/ec-checkout-cancel', 'PaypalController@getExpressCheckoutCancel');

    // Razorpay Route
    Route::post('razorpay/payment', 'RazorpayController@payment')->name('razorpay.payment');

    // Stripe Route
    Route::post('stripe/payment', 'StripeController@payment')->name('stripe.payment');

    // Instamojo Routes
    Route::get('instamojo/payment/response', 'InstamojoController@response')->name('instamojo.payment.response');

    // PayU Routes
    Route::get('payu/payment', 'PayUController@payment')->name('payu.payment');
    Route::get('payu/payment/status', 'PayUController@status')->name('payu.status');
    // Payment gateways callback Url

    // Paystack
    Route::post('/paystack/paystack-handle-webhook', 'PaystackController@paystackWebhook')->name('paystack.paystackWebhook');
    Route::get('/paystack/paystack-callback', 'PaystackController@paystackCallback')->name('paystack.paystackCallback');

    // Pesapal
    Route::get('/pesapal/donePayment', 'PesapalController@paymentSuccess')->name('pesapal.paymentSuccess');
    Route::get('/pesapal/paymentConfirmation', 'PesapalController@paymentConfirmation')->name('pesapal.paymentConfirmation');
    
    // Paytm
    Route::post('/paytm/paytm-callback', 'PaytmController@paytmCallback')->name('paytm.paytmCallback');

    // SMS OTP Verification
    Route::post('auth/sms/sendOtp', 'SendVerificationSMS@sendOtp')->name('auth.sms.sendOtp');
    Route::get('auth/sms/verify-form', ['as' => 'auth.sms.verify.form', 'uses' => 'SendVerificationSMS@verifyForm']);
    Route::post('auth/sms/verifyOtp', 'SendVerificationSMS@verifyOtp')->name('auth.sms.verifyOtp');
});

// Newsletter Route
Route::post('subscribe', 'NewsletterController@addEmailToList');
Route::get('subscribe', 'NewsletterController@subscribe');
Route::get('subscribe/confirm', 'NewsletterController@confirm')->name('subscribe.confirm');

// Captcha Route
Route::get('/secure/captcha', 'CaptchaController@getCaptcha');

// Email Activation
Route::get('auth/activate', 'Auth\ActivationController@activate')->name('auth.activate');
Route::get('auth/activate/resend', 'Auth\ActivationResendController@showResendForm')->name('auth.activate.resend');
Route::post('auth/activate/resend', 'Auth\ActivationResendController@resend');

});
// Webcart Activate
    Route::get('webcart/activate', 'WebcartActivationController@activation')->name('webcart.activate');
    Route::post('webcart/activate', 'WebcartActivationController@activate');
    Route::post('webcart/activator', 'WebcartActivationController@activator');
    //Demo data route
    Route::get('webcart/import-demo-data', 'WebcartActivationController@demoData')->name('webcart.demo_data');
    Route::post('webcart/import-demo-data', 'WebcartActivationController@importDemoData');

});