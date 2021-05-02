<?php

namespace App\Http\Controllers;

use App\ComparisionGroup;
use App\Product;
use App\Section;
use Illuminate\Http\Request;

class FrontProductController extends Controller
{
    public function show($slug) {
        $product = Product::where('slug', $slug)->where('is_active', 1)->firstOrFail();

        $variants = unserialize($product->variants);
        if(!is_array($variants)) {
            $variants = [];
        }

		if(!(($product->related_products()->where('is_active', 1)->count()) > 0)) {
			$related_products_category = Product::whereHas('category', function($query) use($product) {
				$query->where('id', $product->category_id);
			})->whereNotIn('id', [$product->id])->where('is_active', 1)->limit(3)->get();

			$related_products_brand = Product::whereHas('brand', function($query) use($product) {
				$query->where('id', $product->brand_id);
			})->whereNotIn('id', [$product->id])->where('is_active', 1)->limit(3)->get();

			$related_products_category_brand = $related_products_category->merge($related_products_brand);
		} else {
			$related_products_category_brand = NULL;
		}
        $comparision_products = $comparision_group_types = '';
		if ( $product->comp_group_id ){
            $comparision_products_count = $product->where('comp_group_id', $product->comp_group_id)->count();
		    if ( $comparision_products_count > 1 ){
                $comparision_products = $product->where('comp_group_id', $product->comp_group_id)->limit(3)->get();
                $comparision_group_types = ComparisionGroup::where('cg_id',$product->comp_group_id)->first();
            }
        }

        $location_id = 1;
        $sections = Section::orderBy('priority', 'asc')->where('is_active', 1)->where('location_id', $location_id)->get();
        $sections_above_deal_slider = $sections->filter(function($section) {
            return $section->position == 'Above Deal Slider';
        });
        $sections_below_deal_slider = $sections->filter(function($section) {
            return $section->position == 'Below Deal Slider';
        });
        $sections_above_footer = $sections->filter(function($section) {
            return $section->position == 'Above Footer';
        });

		return view('front.product', compact('product', 'variants', 'related_products_category_brand', 'comparision_products', 'comparision_group_types', 'sections_above_deal_slider', 'sections_below_deal_slider', 'sections_above_footer'));
	}

	public function store(Request $request, Product $product) {
		if(!$product->is_active) {
			return view('errors.404');
		}
		$request->user()->favouriteProducts()->syncWithoutDetaching([$product->id]);
		return back();
	}

	public function wishlist(Request $request) {
		$products = $request->user()->favouriteProducts()->paginate(9);
		return view('front.wishlist', compact('products'));
	}

	public function destroy(Request $request, Product $product) {
		$request->user()->favouriteProducts()->detach($product);
		return back();
	}

	public function getVariantData(Request $request, $product_id, $variant_keys, $value_keys) {
		if($product_id) {
			$product = Product::select('id', 'old_price', 'price', 'variants')->findOrFail($product_id);

			if($product->price_with_discount() < $product->price) {
				$product_price = $product->price_with_discount();
			} else {
				if($product->old_price && ($product->price < $product->old_price)) {
					$product_price = $product->price_with_discount();
				} else {
					$product_price = $product->price;
				}
			}

		 	$variants = unserialize($product->variants);

			if(is_array($variants) && count($variants)) {

				$variant_keys = explode(',', $variant_keys);
				$value_keys = explode(',', $value_keys);

				if(is_array($variant_keys) && is_array($value_keys) && count($variant_keys) == count($value_keys)) {

					$price_to_add_array = [];

					foreach($variant_keys as $key => $variant_key) {
						if(isset($variants[$variant_key]) && isset($variants[$variant_key]['v'][$value_keys[$key]])) {
							$price_to_add = $variants[$variant_key]['v'][$value_keys[$key]]['p'];
							array_push($price_to_add_array, $price_to_add);
						}
					}

					if(count($price_to_add_array)) {
						foreach($price_to_add_array as $price_to_add) {
							$product_price += $price_to_add;
						}

						return array('success' => true, 'data' => currency_format($product_price)); 
					}

				}
			}
		}

		return array('success' => false);
	}
}
