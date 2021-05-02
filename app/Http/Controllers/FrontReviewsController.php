<?php

namespace App\Http\Controllers;

use App\Product;
use App\Review;
use Illuminate\Http\Request;
use App\Http\Requests\ReviewsCreateRequest;
use Illuminate\Support\Facades\Auth;

class FrontReviewsController extends Controller
{
    public function store(ReviewsCreateRequest $request)
    {
        if(\Illuminate\Support\Facades\Request::ajax()) {
            $user = Auth::user();
            $input['user_id'] = $user->id;
            $input['product_id'] = $request->product;
            $input['comment'] = $request->review;
            $input['rating'] = $request->stars;

            $review = new Review($input);
            $review->save();
            $product = Product::findOrFail($request->product);
            return response()->view('includes.reviews', compact('product'), 200);
        }
    }

    public function edit($id)
    {
        if(\Illuminate\Support\Facades\Request::ajax()) {
            $review = Review::findOrFail($id);
            return response()->view('includes.review-edit', compact('review'), 200);
        }
    }

    public function update(ReviewsCreateRequest $request, $id)
    {
        if(\Illuminate\Support\Facades\Request::ajax()) {
            $review = Review::findOrFail($id);
            if(Auth::user()->id == $review->user_id) {
                $input['comment'] = $request->review;
                $input['rating'] = $request->stars;
                $review->fill($input)->save($input);
                $product = Product::findOrFail($review->product_id);
                return response()->view('includes.reviews', compact('product'), 200);
            } else {
                return view('errors.403');
            }
        }
    }

    public function reviews(Request $request, $product_id)
    {
        if ($request->ajax()) {
            $reviews = Review::where('product_id', $product_id)->where('approved', 1)->orderBy('id', 'desc')->paginate(5);
            $view = view('includes.approved_reviews', compact('reviews'))->render();
            return response()->json(['html'=>$view]);
        }
    }
}
