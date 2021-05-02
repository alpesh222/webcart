<?php

namespace App\Http\Controllers;

use App\Deal;
use Illuminate\Http\Request;

class FrontDealController extends Controller
{
    public function show($slug) {
        $deal = Deal::where('slug', $slug)->where('is_active', 1)->firstOrFail();
        $location_id = session('location_id');
        $pagination_count = config('settings.pagination_count') ? config('settings.pagination_count') : 9;
        $products = $deal->products()->where('location_id', $location_id)->where('is_active', 1)->orderBy('id', 'desc');
        $product_max_price = $products->max('price');
        $products = $products->paginate($pagination_count);
        return view('front.deal', compact('products','product_max_price', 'deal'));
    }
}
