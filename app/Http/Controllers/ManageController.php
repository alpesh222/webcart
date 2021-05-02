<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Banner;
use App\Category;
use App\Other;
use App\Page;
use App\Product;
use App\User;
use App\Deal;
use App\Customer;
use App\Subscriber;
use App\Voucher;
use App\Sale;
use App\Location;
use App\Order;
use App\Review;
use App\Vendor;
use App\VendorRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ManageController extends Controller
{
    public function index(Request $request) {

        if($request->location && Auth::user()->can('update', Location::class)) {
            $locations = Location::pluck('name','id')->all();                    
            if(array_key_exists($request->location, $locations)) {
                $user = User::findOrFail(Auth::user()->id);
                $user->location_id = $request->location;
                $user->save();
                return back();
            }
        }

        $location_id = Auth::user()->location_id;

        if(Auth::user()->can('view-dashboard', Other::class)) {
            $vendor_requests_pending = VendorRequest::where('is_processed', 0)->count();
            $total_active_pages = Page::where('is_active', 1)->count();
            $total_shipments = Page::count();

            $products_count = Product::where('location_id', $location_id)->count();
            $categories_count = Category::where('location_id', $location_id)->count();
            $brands_count = Brand::where('location_id', $location_id)->count();
            $orders_count = Order::where('location_id', $location_id)->count();
            $customer_addresses_count = Customer::count();
            $approved_vendors_count = Vendor::where('approved', 1)->count();
            $customers_count = User::count();
			$staff_count = User::where('location_id', $location_id)->count();
            $reviews_count = Review::get()->filter(function($review) use ($location_id) {
                if($review->product){
                    return $review->product->location_id == $location_id;
                }
            })->count();
            $invoices_count = Order::where('location_id', $location_id)->where('is_processed', true)->count();
            $deals_count = Deal::where('location_id', $location_id)->count();
            $coupons_count = Voucher::where('type', 1)->where('location_id', $location_id)->count();

            $active_products_count = Product::where('location_id', $location_id)->where('is_active', 1)->count();
            $active_categories_count = Category::where('location_id', $location_id)->where('is_active', 1)->count();
            $active_brands_count = Brand::where('location_id', $location_id)->where('is_active', 1)->count();
			$active_staff_count = User::where('location_id', $location_id)->where('is_active', 1)->count();
			$active_banners_count = Banner::where('location_id', $location_id)->where('is_active', 1)->count();
            $pending_reviews_count = Review::where('approved', 0)->get()->filter(function($review) use ($location_id) {
                if($review->product){
                    return $review->product->location_id == $location_id;
                }
            })->count();
            $active_deals_count = Deal::where('location_id', $location_id)->where('is_active', 1)->count();
            $active_coupons_count = Voucher::where('type', 1)->where('location_id', $location_id)->get()->filter(function($coupon) {
                return Carbon::now()->gte(Carbon::parse($coupon->starts_at)) && Carbon::now()->lte(Carbon::parse($coupon->expires_at));
            })->count();
            $active_product_discounts_count = Voucher::where('type', 2)->where('location_id', $location_id)->get()->filter(function($discount) {
                return Carbon::now()->gte(Carbon::parse($discount->starts_at)) && Carbon::now()->lte(Carbon::parse($discount->expires_at));
            })->count();
            $verified_subscribers_count = Subscriber::where('active', 1)->count();

            $low_stock_products_count = Product::where('location_id', $location_id)->where('in_stock', '<=', 10)->where('in_stock', '>=', 1)->count();
            $out_of_stock_products_count = Product::where('location_id', $location_id)->where('in_stock', '<', 1)->count();

            $pending_orders_count = Order::where('location_id', $location_id)->where('is_processed', 0)->where('stock_regained', '!=', 1)->where(function($query) {
            return $query->where('payment_method', '!=', 'Cash on Delivery')->where('paid', '!=', 0)
                        ->orWhere('payment_method', 'Cash on Delivery');
            })->count();

            $root_categories_count = Category::where('location_id', $location_id)->where('category_id', 0)->count();

            $root_categories = Category::where('location_id', $location_id)->where('category_id', 0)->get();

            $total_sales = Product::where('location_id', $location_id)->sum('sales');

			$locations = Location::pluck('name', 'id')->toArray();

            // Charts
            $top_selling_products = Product::where('location_id', $location_id)->orderBy('sales', 'desc')->limit(5)->get();
            $top_selling_products_name = $top_selling_products->pluck('name')->all();
            $top_selling_products_sales = $top_selling_products->pluck('sales')->all();
            $chartjs_top_selling_products = app()->chartjs
                                        ->name('topSellingProducts')
                                        ->type('bar')
                                        ->size(['width' => 400, 'height' => 200])
                                        ->labels($top_selling_products_name)
                                        ->datasets([
                                            [
                                                "label" => "Sales",
                                                'backgroundColor' => [
                                                    'rgba(255, 99, 132, 0.2)',
                                                    'rgba(54, 162, 235, 0.2)',
                                                    'rgba(255, 206, 86, 0.2)',
                                                    'rgba(75, 192, 192, 0.2)',
                                                    'rgba(153, 102, 255, 0.2)',
                                                    'rgba(255, 159, 64, 0.2)',
                                                    'rgba(255, 99, 132, 0.2)',
                                                    'rgba(54, 162, 235, 0.2)',
                                                    'rgba(255, 206, 86, 0.2)',
                                                    'rgba(75, 192, 192, 0.2)'
                                                ],
                                                'data' => $top_selling_products_sales,
                                                'borderColor' => [
                                                    'rgba(255,99,132,1)',
                                                    'rgba(54, 162, 235, 1)',
                                                    'rgba(255, 206, 86, 1)',
                                                    'rgba(75, 192, 192, 1)',
                                                    'rgba(153, 102, 255, 1)',
                                                    'rgba(255, 159, 64, 1)',
                                                    'rgba(255,99,132,1)',
                                                    'rgba(54, 162, 235, 1)',
                                                    'rgba(255, 206, 86, 1)',
                                                    'rgba(75, 192, 192, 1)'
                                                ],
                                                'borderWidth' => 1
                                            ]
                                        ])
                                        ->options([]);

            $charts_count_data = app()->chartjs
                    ->name('countData')
                    ->type('pie')
                    ->size(['width' => 400, 'height' => 200])
                    ->labels([__('Active Categories'), __('Approved Vendors'), __('Active Products'), __('Active Staff'), __('Active Brands'), __('Active Banners'), __('Active Deals')])
                    ->datasets([
                        [
                            'backgroundColor' => ['#00CED1', '#C10101', '#006400', '#00008B', '#FF8C00', '#FFD700', '#158CB5'],
                            'hoverBackgroundColor' => ['#40E0D0', '#E50202', '#228B22', '#0000CD', '#FFA500', '#FFFF00', '#1E90FF'],
                            'data' => [$active_categories_count, $approved_vendors_count, $active_products_count, $active_staff_count, $active_brands_count, $active_banners_count, $active_deals_count]
                        ]
                    ])
                    ->options([]);

            return view('manage.index', compact(
                'vendor_requests_pending',
                'products_count',
                'categories_count',
                'brands_count',
                'orders_count',
                'reviews_count',
                'customers_count',
                'customer_addresses_count',
                'approved_vendors_count',
                'invoices_count',
                'deals_count',
                'coupons_count',
                'active_products_count',
                'active_categories_count',
                'active_brands_count',
                'pending_reviews_count',
                'active_deals_count',
                'active_coupons_count',
                'active_banners_count',
                'active_product_discounts_count',
                'verified_subscribers_count',
				'staff_count',
				'customers_count',
                'low_stock_products_count',
                'out_of_stock_products_count',
                'pending_orders_count',
                'root_categories_count',
                'root_categories',
				'locations',
                'total_sales',
                'chartjs_top_selling_products',
                'charts_count_data',
                'total_active_pages',
                'total_shipments'
            ));
        } else {
            return view('errors.403');
        }
    }
}
