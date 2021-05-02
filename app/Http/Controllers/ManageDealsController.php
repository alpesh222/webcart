<?php

namespace App\Http\Controllers;

use App\Deal;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Requests\DealsCreateRequest;
use Illuminate\Support\Facades\Auth;

class ManageDealsController extends Controller
{
    public function index()
    {
        if(Auth::user()->can('read', Deal::class)) {
            if(request()->has('status') && request()->status == 'active') {
                $deals = Deal::where('location_id', Auth::user()->location_id)->where('is_active', 1)->get();
            } else {
                $deals = Deal::where('location_id', Auth::user()->location_id)->get();
            }
            return view('manage.deals.index', compact('deals'));
        } else {
            return view('errors.403');
        }
    }

    public function create()
    {
        if(Auth::user()->can('create', Deal::class)) {
            $location_id = Auth::user()->location_id;
            $products = Product::select('id', 'name')->where('location_id', $location_id)->get();

            return view('manage.deals.create', compact('products'));
        } else {
            return view('errors.403');
        }
    }

    public function store(DealsCreateRequest $request)
    {
        if(Auth::user()->can('create', Deal::class)) {
            $userInput = $request->all();
            $input["name"] = $userInput["name"];
            $input["description"] = $userInput["description"];
            $input["priority"] = $userInput["priority"];
            $input["show_in_menu"] = $request->show_in_menu ? true : false;
            $input["show_in_footer"] = $request->show_in_footer ? true : false;
            $input["meta_title"] = $userInput["meta_title"];
            $input["meta_desc"] = $userInput["meta_desc"];
            $input["meta_keywords"] = $userInput["meta_keywords"];

            if($request->status == 1) {
                $input['is_active'] = $request->status;
            } else {
                $input['is_active'] = 0;
            }

            $location_id = Auth::user()->location_id;
            $input['location_id'] = $location_id;

            $deal = Deal::create($input);

            if(array_key_exists('product', $userInput)) {
                $deal->products()->sync($userInput['product']);
            }

            session()->flash('deal_created', __("New deal has been added."));
            return redirect(route('manage.deals.index'));
        } else {
            return view('errors.403');
        }
    }

    public function edit($id)
    {
        if(Auth::user()->can('update', Deal::class)) {
            $location_id = Auth::user()->location_id;
            $deal = Deal::where('location_id', $location_id)->where('id', $id)->firstOrFail();
            $products = Product::select('id', 'name')->where('location_id', $location_id)->get();
            return view('manage.deals.edit', compact('deal', 'products'));
        } else {
            return view('errors.403');
        }
    }

    public function update(DealsCreateRequest $request, $id)
    {
        if(Auth::user()->can('update', Deal::class)) {
            $deal = Deal::findOrFail($id);
    
            $userInput = $request->all();
            $input["name"] = $userInput["name"];
            $input["description"] = $userInput["description"];
            $input["priority"] = $userInput["priority"];
            $input["show_in_menu"] = $request->show_in_menu ? true : false;
            $input["show_in_footer"] = $request->show_in_footer ? true : false;
            $input["meta_title"] = $userInput["meta_title"];
            $input["meta_desc"] = $userInput["meta_desc"];
            $input["meta_keywords"] = $userInput["meta_keywords"];

            if(array_key_exists('product', $userInput)) {
                $deal->products()->sync($userInput['product']);
            } else {
                $deal->products()->sync([]);
            }

            if($request->status == 1) {
                $input['is_active'] = $request->status;
            } else {
                $input['is_active'] = 0;
            }

            $deal->update($input);

            session()->flash('deal_updated', __("The deal has been updated."));
            return redirect(route('manage.deals.edit', $deal->id));
        } else {
            return view('errors.403');
        }
    }

    public function destroy($id)
    {
        if(Auth::user()->can('delete', Deal::class)) {
            $deal = Deal::findOrFail($id);
            $deal->products()->detach();
            $deal->delete();
            session()->flash('deal_deleted', __("The deal has been deleted."));
            return redirect(route('manage.deals.index'));
        } else {
            return view('errors.403');
        }
    }

    public function deleteDeals(Request $request)
    {
        if(Auth::user()->can('delete', Deal::class)) {
            if(isset($request->delete_single)) {
                $deal = Deal::findOrFail($request->delete_single);
                $deal->products()->detach();
                $deal->delete();
                session()->flash('deal_deleted', __("The deal has been deleted."));
            } else {
                if(isset($request->delete_all) && !empty($request->checkboxArray)) {
                    $deals = Deal::findOrFail($request->checkboxArray);
                    foreach($deals as $deal) {
                        $deal->products()->detach();
                        $deal->delete();
                    }
                    session()->flash('deal_deleted', __("The selected deals have been deleted."));
                } else {
                    session()->flash('deal_not_deleted', __("Please select deals to be deleted."));
                }
            }
            return redirect(route('manage.deals.index'));
        } else {
            return view('errors.403');
        }
    }
}
