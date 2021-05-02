<?php

namespace App\Http\Controllers;

use App\Review;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageReviewsController extends Controller
{
    public function index()
    {
        if(Auth::user()->can('update-review', Review::class) || Auth::user()->can('delete-review', Review::class)) {
            $reviews = Review::orderBy('id', 'desc');
            if( !empty( request()->s ) ) {
                $search = request()->s;
                $search_trimmed = trim(strtolower($search));
                $skip_search = false;
                switch ($search_trimmed) {
                    case 'approved':
                        $orders = $reviews->where('approved', 1);
                        $skip_search = true;
                        break;
                    case 'pending':
                        $orders = $reviews->where('approved', '!=', 1);
                        break;
                    default:
                        $orders = $reviews->where('approved', 'LIKE', $search);
                        break;
                }

                if(!$skip_search) {
                    $orders = $reviews->orWhere('id', (int)$search)
                        ->orWhere('rating', (int)$search)
                        ->orWhereHas('product', function($query) use ($search) {
                            $query->where('name', 'LIKE', "%$search%")
                                ->orWhere('model', 'LIKE', "%$search%");
                        })
                        ->orWhereHas('user', function($query) use ($search) {
                            $query->where('name', 'LIKE', "%$search%")
                                ->orWhere('username', 'LIKE', "%$search%");
                        });
                }
            }
            if(request()->has('status') && request()->status == 'pending') {
                $reviews = Review::where('approved', 0)->get()->filter(function($review) {
                    return $review->product->location_id == Auth::user()->location_id;
                });
            } else {
                $reviews = $reviews->get()->filter(function($review) {
                    return $review->product->location_id == Auth::user()->location_id;
                });
            }
            /* Pagination */
            if(empty(request()->all)) {
                if(!empty(request()->per_page)) {
                    $per_page = intval(request()->per_page);
                } else {
                    $per_page = 15;
                }
            } else {
                $per_page = $reviews->count();
            }
            $reviews = $reviews->paginate($per_page);

            return view('manage.reviews.index', compact('reviews'));
        } else {
            return view('errors.403');
        }
    }

    public function edit($id)
    {
        if(Auth::user()->can('update-review', Review::class)) {
            $review = Review::where('id', $id)->firstOrFail();
            return view('manage.reviews.edit', compact('review'));
        } else {
            return view('errors.403');
        }
    }

    public function destroy($id)
    {
        if(Auth::user()->can('delete-review', Review::class)) {
            $review = Review::findOrFail($id);
            $review->delete();
            session()->flash('review_deleted', __("The review has been deleted."));
            return redirect(route('manage.reviews.index'));
        } else {
            return view('errors.403');
        }
    }

    public function setReviewsStatus(Request $request)
    {
        if(isset($request->delete_single)) {
            if(Auth::user()->can('delete-review', Review::class)) {
                $review = Review::findOrFail($request->delete_single);
                $review->delete();
                session()->flash('review_deleted', __("The review has been deleted."));
            } else {
                return view('errors.403');
            }
        } else {
            if(!empty($request->checkboxArray) && is_array($request->checkboxArray)) {

                if(isset($request->delete_all)) {
                    if(Auth::user()->can('delete-review', Review::class)) {
                        $reviews = Review::findOrFail($request->checkboxArray);
                        foreach($reviews as $review) {
                            $review->delete();
                        }
                        session()->flash('review_selected', __("The selected reviews have been deleted."));
                    } else {
                        return view('errors.403');
                    }
                }

                elseif(isset($request->approve_all) && !empty($request->checkboxArray)) {
                    if(Auth::user()->can('update-review', Review::class)) {
                        $reviews = Review::findOrFail($request->checkboxArray);
                        foreach($reviews as $review) {
                            $review->update(['approved'=>1]);
                        }
                        session()->flash('review_selected', __("The selected reviews have been approved."));
                    } else {
                        return view('errors.403');
                    }
                }

                elseif(isset($request->disapprove_all) && !empty($request->checkboxArray)) {
                    if(Auth::user()->can('update-review', Review::class)) {
                        $reviews = Review::findOrFail($request->checkboxArray);
                        foreach($reviews as $review) {
                            $review->update(['approved'=>0]);
                        }
                        session()->flash('review_selected', __("The selected reviews have been marked as pending."));
                    } else {
                        return view('errors.403');
                    }
                }
            } else {
                session()->flash('review_not_selected', __("Please select reviews."));
            }
        }
        return redirect(route('manage.reviews.index'));
    }
}
