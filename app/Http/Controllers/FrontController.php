<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Brand;
use App\Category;
use App\Deal;
use App\Location;
use App\Setting;
use App\Vendor;
use App\Testimonial;
use App\Product;
use App\Photo;
use App\Section;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class FrontController extends Controller
{
    public function index($language = null) {

        if($language) {
            if(in_array($language, array_keys(Helper::supportedLanguages()))) {
                session(['language'=>$language]);
                \App::setLocale($language);
            }
        }

        $location_id = 1;

        $products = Product::orderBy('id', 'desc')->where('is_active', 1)->where('location_id', $location_id)->get();
        $featured_products = $products->sortByDesc(function($product) {return $product->reviews->where('approved', 1)->where('rating', '!=', null)->avg('rating');})->take(10);
        $best_selling_products = $products->sortByDesc(function($product) {return $product->sales;})->take(10);
        $products = $products->take(20);
        $brands = Brand::where('is_active', 1)->where('location_id', $location_id)->where('show_in_slider', true)->orderby('priority', 'asc')->get();
        $deals = Deal::orderBy('priority', 'asc')->where('is_active', 1)->where('location_id', $location_id)->get();
        $categories = Category::where('is_active', 1)->where('location_id', $location_id)->where('show_in_slider', true)->orderby('priority', 'asc')->get();
        $banners = Banner::where('is_active', 1)->where('location_id', $location_id)->orderBy('priority', 'asc')->get();
        $sections = Section::orderBy('priority', 'asc')->where('is_active', 1)->where('location_id', $location_id)->get();

        $banners_main_slider = $banners->filter(function($banner) {
            return $banner->position == 'Main Slider';
        });
        $banners_right_side = $banners->filter(function($banner) {
            return $banner->position == 'Right Side';
        });
        $banners_below_main_slider = $banners->filter(function($banner) {
            return $banner->position == 'Below Main Slider';
        });
        $banners_below_main_slider_2_images_layout = $banners->filter(function($banner) {
            return $banner->position == 'Below Main Slider - Two Images per row';
        });
        $banners_below_main_slider_3_images_layout = $banners->filter(function($banner) {
            return $banner->position == 'Below Main Slider - Three Images Layout';
        });

        $sections_above_main_slider = $sections->filter(function($section) {
            return $section->position == 'Above Main Slider';
        });
        $sections_below_main_slider = $sections->filter(function($section) {
            return $section->position == 'Below Main Slider';
        });
        $sections_above_deal_slider = $sections->filter(function($section) {
            return $section->position == 'Above Deal Slider';
        });
        $sections_below_deal_slider = $sections->filter(function($section) {
            return $section->position == 'Below Deal Slider';
        });
        $sections_above_footer = $sections->filter(function($section) {
            return $section->position == 'Above Footer';
        });
        $sections_above_side_banners = $sections->filter(function($section) {
            return $section->position == 'Above Side Banners';
        });
        $sections_below_side_banners = $sections->filter(function($section) {
            return $section->position == 'Below Side Banners';
        });

        $testimonials = Testimonial::where('is_active', 1)->orderBy('priority', 'asc')->get();
        $default_photo = Photo::getDefaultUserPhoto();


        return view('front.index', compact('products', 'featured_products', 'best_selling_products', 'brands', 'categories', 'deals', 'banners_main_slider', 'banners_right_side', 'banners_below_main_slider', 'banners_below_main_slider_2_images_layout', 'banners_below_main_slider_3_images_layout', 'sections_above_main_slider', 'sections_below_main_slider', 'sections_above_deal_slider', 'sections_below_deal_slider', 'sections_above_footer', 'sections_above_side_banners', 'sections_below_side_banners', 'testimonials', 'default_photo'));
    }

    public function products(Request $request, $type = null, $slug = null) {
        $location_id = 1;

        if($type == 'products' || $type==null) {
            $products = Product::orderBy('id', 'desc')->where('is_active', 1)->where('location_id', $location_id);
            $product_max_price = $products->max('price');
        } elseif($type == 'category') {
            $category = Category::where('slug', $slug)->firstOrFail();
            $products = $category->all_products()->where('location_id', $location_id)->where('is_active', 1);
            $product_max_price = $products->max('price');
        } elseif($type == 'brand') {
            $brand = Brand::where('slug', $slug)->firstOrFail();
            $products = $brand->products()->where('location_id', $location_id)->where('is_active', 1)->orderBy('id', 'desc');
            $product_max_price = $products->max('price');
        } elseif($type == 'deal') {
            $deal = Deal::where('slug', $slug)->firstOrFail();
            $products = $deal->products()->where('location_id', $location_id)->where('is_active', 1)->orderBy('id', 'desc');
            $product_max_price = $products->max('price');
        } elseif($type == 'shop') {
            $shop = Vendor::where('slug', $slug)->firstOrFail();
            $products = $shop->products()->where('location_id', $location_id)->where('is_active', 1)->orderBy('id', 'desc');
            $product_max_price = $products->max('price');
        } elseif($type == 'search') {
            if(isset($request->keyword)) {
                $keyword = trim($request->keyword);
            } else {
                $keyword = '';
            }
            $products = Product::where('location_id', $location_id)->where('name', 'LIKE', '%'.$keyword.'%')->where('is_active', 1)->orderBy('id', 'desc');
            $product_max_price = $products->max('price');
        }

        // Filtering
        if(isset($request->discount) && $request->discount == true) {
            $products = $products->get()->filter(function($product) {
                return $product->price > $product->price_with_discount();
            });
        } else {
            if($type != 'category') {
                $products = $products->get();
            }
        }

        if(isset($request->filter_by) && isset($request->filter_value)) {
            $products = $products->filter(function($product) use ($request) {
                foreach($product->specificationTypes as $specificationType) {
                    if(in_array($specificationType->id, $request->filter_by)) {
                        if(in_array($specificationType->pivot->value, $request->filter_value) && in_array($specificationType->pivot->unit, $request->filter_unit)) {
                            return true;
                        }
                    }
                }
            });
        }

        if(isset($request->filter_by_brand)) {
            $products = $products->filter(function($product) use ($request) {
                if(in_array($product->brand_id, $request->filter_by_brand)) {
                    return true;
                }
            });
        }

        if(isset($request->filter_by_category)) {
            $products = $products->filter(function($product) use ($request) {
                if(in_array($product->category_id, $request->filter_by_category)) {
                    return true;
                }
            });
        }

        // Price Range Filtering
        if(isset($request->min_price) && isset($request->max_price)) {
            $products = $products->filter(function($product) use ($request) {
                return $product->price_with_discount() >= $request->min_price && $product->price_with_discount() <= $request->max_price;
            });
        }

        // Sorting
        if(isset($request->sort_by) && $request->sort_by != '') {
            $sort_by = $request->sort_by;

            if($sort_by == 1) { // By Price Low
                $products = $products->sortBy(function($product) {
                    return $product->price_with_discount();
                });
            } elseif($sort_by == 2) { // By Price High
                $products = $products->sortByDesc(function($product) {
                    return $product->price_with_discount();
                });
            } elseif($sort_by == 3) { // By Popularity
                $products = $products->sortByDesc(function($product) {
                    return $product->sales;
                });
            } elseif($sort_by == 4) { // By Ratings
                $products = $products->sortByDesc(function($product) {
                    return $product->reviews->where('approved', 1)->where('rating', '!=', null)->avg('rating');
                });
            } elseif($sort_by == 5) { // By Reviews
                $products = $products->sortByDesc(function($product) {
                    return count($product->reviews->where('approved', 1)->where('comment', '!=', null));
                });
            }
        }

        // Pagination
        $pagination_count = config('settings.pagination_count') ? config('settings.pagination_count') : 9;
        $products = $products->paginate($pagination_count);

        if(\Illuminate\Support\Facades\Request::ajax()) {
            return response()->view('includes.products_pagination', compact('products'), 200);
        }

        return view('front.products', compact('products','product_max_price'));
    }

    public function search(Request $request) {
        $keyword = $request->keyword;
        $location_id = session('location_id');
        $pagination_count = config('settings.pagination_count') ? config('settings.pagination_count') : 9;
        $products = Product::where('location_id', $location_id)->where('name', 'LIKE', '%'.$keyword.'%')->where('is_active', 1);
        $product_max_price = $products->max('price');
        $products = $products->paginate($pagination_count);
        return view('front.search', compact('products', 'product_max_price','keyword'));
    }

    public function autocomplete(){
        $keyword = request()->get('term');
        $results = array();
        $location_id = session('location_id');
        $queries = Product::where('location_id', $location_id)->where('name', 'LIKE', '%'.$keyword.'%')->where('is_active', 1)->take(5)->get();

        foreach ($queries as $query)
        {

            $product_id =  $query->id;
            $cartItems = Cart::content();

            $productsInCart = $cartItems->filter(function($cartItem) use($product_id) {
                return $cartItem->id == $product_id;
            });
            $cart_data      = $productsInCart->first();
            $variant = array();
            if(!empty($cart_data)){
//                print_r($cart_data);exit;
                $allow_cart_item_qty  = $cart_data->options->qty_per_order;
                $cart_item_qty  = $cart_data->qty;
                $row_id  = $cart_data->rowId;
                if(count($cart_data->options->spec) > 0 ){
                    for ($i = 0 ; $i <  count($cart_data->options->spec) ; $i++){
                        $variant['count']    = count($cart_data->options->spec);
                        $variant['name'][]   = $cart_data->options->spec[$i]['name'];
                        $variant['value'][]  = $cart_data->options->spec[$i]['value'];
                        $variant['amt'][]    = $cart_data->options->unit_price;
                    }
                }

            }else{
                $row_id = null;
                $cart_item_qty = 0;
                $allow_cart_item_qty = $query->qty_per_order;
                $variants = unserialize($query->variants);
                if(!is_array($variants)) {
                    $variants = [];
                }
                if(count($variants) > 0 ){
                    for ($i = 0 ; $i <  count($variants) ; $i++){
                        $variant['count']    = count($variants);
                        $variant['name'][]   = $variants[$i]['n'];
                        $variant['value'][]  = $variants[$i]['v'][0]['n'];
                        $variant['amt'][]    = $variants[$i]['v'][0]['p'];
                    }
                }
            }
            if($query->photo){
                $image_url = Helper::check_image_avatar($query->photo->name, 500);
            } else{
                $image_url = 'https://via.placeholder.com/80x80?text=No+Image';
            }

            $results[] = [
                'id'        => $query->id,
                'row_id'    => $row_id,
                'value'     => $query->name,
                'price'     => $query->price,
                'max_qty'   => $query->in_stock,
                'file_id'   => $query->file_id,
                'virtual'   => $query->virtual,
                'downloadable'          => $query->downloadable,
                'allow_cart_item_qty'   => $allow_cart_item_qty,
                'cart_item_qty'  => $cart_item_qty,
                'product_variants'  => $variant,
                'link'      => route('front.product.show', [$query->slug]),
                'imgsrc'    => $image_url ? $image_url : 'https://via.placeholder.com/80x80?text=No+Image'
            ];
        }
        return response()->json($results);
    }

    public function account() {
        return view('front.account');
    }
}
