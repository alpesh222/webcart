<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class FrontCategoryController extends Controller
{
    public function show($slug) {
        $category = Category::where('slug', $slug)->where('is_active', 1)->firstOrFail();
        $location_id = session('location_id');
        $pagination_count = config('settings.pagination_count') ? config('settings.pagination_count') : 9;
        $products = $category->all_products()->where('location_id', $location_id)->where('is_active', 1);
        $product_max_price = $products->max('price');
        $products = $products->paginate($pagination_count);

        $banners = $category->banners()->orderBy('priority', 'asc')->where('is_active', 1)->get();
        $sections = $category->sections()->orderBy('priority', 'asc')->where('is_active', 1)->get();

        $banners_main_slider = $banners->filter(function($banner) {
            return $banner->position_category == 'Main Slider';
        });
        $banners_below_filters = $banners->filter(function($banner) {
            return $banner->position_category == 'Below Filters';
        });
        $banners_below_main_slider = $banners->filter(function($banner) {
            return $banner->position_category == 'Below Main Slider';
        });
        $banners_below_main_slider_2_images_layout = $banners->filter(function($banner) {
            return $banner->position_category == 'Below Main Slider - Two Images per row';
        });
        $banners_below_main_slider_3_images_layout = $banners->filter(function($banner) {
            return $banner->position_category == 'Below Main Slider - Three Images Layout';
        });

        $sections_above_main_slider = $sections->filter(function($section) {
            return $section->position_category == 'Above Main Slider';
        });
        $sections_below_main_slider = $sections->filter(function($section) {
            return $section->position_category == 'Below Main Slider';
        });
        $sections_above_side_banners = $sections->filter(function($section) {
            return $section->position_category == 'Above Side Banners';
        });
        $sections_below_side_banners = $sections->filter(function($section) {
            return $section->position_category == 'Below Side Banners';
        });
        $sections_above_footer = $sections->filter(function($section) {
            return $section->position_category == 'Above Footer';
        });

        return view('front.category', compact('products', 'category', 'product_max_price', 'banners_main_slider', 'banners_below_filters', 'banners_below_main_slider', 'banners_below_main_slider_2_images_layout', 'banners_below_main_slider_3_images_layout', 'sections_above_main_slider', 'sections_below_main_slider', 'sections_above_side_banners', 'sections_below_side_banners', 'sections_above_footer'));
    }
}