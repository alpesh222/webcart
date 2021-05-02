<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Location;
use App\Photo;
use App\Category;
use App\Brand;
use Illuminate\Http\Request;
use App\Http\Requests\BannersCreateRequest;
use Illuminate\Support\Facades\Auth;

class ManageBannersController extends Controller
{
    public function index()
    {
        if(Auth::user()->can('read', Banner::class)) {
            $location_id = Auth::user()->location_id;
            if(request()->has('status') && request()->status == 'active') {
                $banners = Banner::where('location_id', $location_id)->where('is_active', 1)->get();
            } else {
                $banners = Banner::where('location_id', $location_id)->get();
            }
            $brands = Brand::where('location_id', $location_id)->pluck('name', 'id')->toArray();
            $root_categories = Category::where('location_id', $location_id)->where('category_id', 0)->get();
            return view('manage.banners.index', compact('banners', 'brands', 'root_categories'));
        } else {
            return view('errors.403');
        }
    }

    public function store(BannersCreateRequest $request)
    {
        if(Auth::user()->can('create', Banner::class)) {

            if(!$request->brand && !$request->category && !$request->position) {
                return redirect()->back()->withErrors(__('Please select at least one location to display banner.'))->withInput($request->input());
            }

            $userInput = $request->all();
            $input["title"] = $userInput["title"];
            $input["link"] = $userInput["link"];
            $input["priority"] = $userInput["priority"];
            $input["description"] = $userInput["description"];
            $input["position"] = $userInput["position"];
            $input["position_brand"] = $userInput["position_brand"];
            $input["position_category"] = $userInput["position_category"];

            $location_id = Auth::user()->location_id;
            $brands = Brand::where('location_id', $location_id)->pluck('name','id')->all();
            $categories = Category::where('location_id', $location_id)->pluck('name','id')->all();

            if($request->status == 1) {
                $input['is_active'] = $request->status;
            } else {
                $input['is_active'] = 0;
            }

            if(array_key_exists($request->brand, $brands)) {
                $input['brand_id'] = $request->brand;
            } else {
                $input['brand_id'] = NULL;
            }

            if(array_key_exists($request->category, $categories)) {
                $input['category_id'] = $request->category;
            } else {
                $input['category_id'] = NULL;
            }

            $location_id = Auth::user()->location_id;
            $input['location_id'] = $location_id;

            if($photo = $request->file('photo')) {
                $name = time().$photo->getClientOriginalName();
                $photo->move(Photo::getPhotoDirectoryName(), $name);
                $photo = Photo::create(['name'=>$name]);
                $input['photo_id'] = $photo->id;
            }

            Banner::create($input);
    
            session()->flash('banner_created', __("New banner has been added."));
    
            return redirect(route('manage.banners.index'));
        } else {
            return view('errors.403');
        }
    }

    public function edit($id)
    {
        if(Auth::user()->can('update', Banner::class)) {
            $location_id = Auth::user()->location_id;
            $banner = Banner::where('location_id', $location_id)->where('id', $id)->firstOrFail();
            $root_categories = Category::where('location_id', $location_id)->where('category_id', 0)->get();
            $categories = Category::where('location_id', $location_id)->where('category_id', 0)->get();
            $brands = Brand::where('location_id', $location_id)->pluck('name', 'id')->toArray();
            return view('manage.banners.edit', compact('banner', 'root_categories', 'categories', 'brands'));
        } else {
            return view('errors.403');
        }
    }

    public function update(BannersCreateRequest $request, $id)
    {
        if(Auth::user()->can('update', Banner::class)) {

            $banner = Banner::findOrFail($id);

            $home_position_selected = $request->position;
            $brand_position_selected = $request->brand && $request->position_brand;
            $category_position_selected = ($request->category && $request->position_category) ||
                                    (!$request->remove_category && $banner->category_id && $request->position_category);
            $no_location_selected = !$home_position_selected && !$brand_position_selected && !$category_position_selected;

            if($no_location_selected) {
                return redirect()->back()->withErrors(__('Please select at least one location to display banner.'))->withInput($request->input());
            }

            $userInput = $request->all();
            $input["title"] = $userInput["title"];
            $input["link"] = $userInput["link"];
            $input["priority"] = $userInput["priority"];
            $input["description"] = $userInput["description"];
            $input["position"] = $userInput["position"];
            $input["position_brand"] = $userInput["position_brand"];
            $input["position_category"] = $userInput["position_category"];

            $location_id = Auth::user()->location_id;
            $brands = Brand::where('location_id', $location_id)->pluck('name','id')->all();
            $categories = Category::where('location_id', $location_id)->pluck('name','id')->all();

            if($request->status == 1) {
                $input['is_active'] = $request->status;
            } else {
                $input['is_active'] = 0;
            }

            if(array_key_exists($request->brand, $brands)) {
                $input['brand_id'] = $request->brand;
            } else {
                $input['brand_id'] = NULL;
            }

            if($request->remove_category) {
                $input['category_id'] = NULL;
            } else {
                if(array_key_exists($request->category, $categories)) {
                    $input['category_id'] = $request->category;
                } else {
                    $input['category_id'] = $banner->category_id;
                }
            }

            if(!$request->file('photo') && $request->remove_photo) {
                if($banner->photo) {
                    if(file_exists($banner->photo->getPath())) {
                        unlink($banner->photo->getPath());
                        $banner->photo()->delete();
                    }
                }
            }
    
            if($photo = $request->file('photo')) {
                $name = time().$photo->getClientOriginalName();
                $photo->move(Photo::getPhotoDirectoryName(), $name);
                if($banner->photo) {
                    if(file_exists($banner->photo->getPath())) {
                        unlink($banner->photo->getPath());
                        $banner->photo()->delete();
                    }
                }
                $photo = Photo::create(['name'=>$name]);
                $input['photo_id'] = $photo->id;
            }
    
            $banner->update($input);
    
            session()->flash('banner_updated', __("The banner has been updated."));
            return redirect(route('manage.banners.edit', $banner->id));
        } else {
            return view('errors.403');
        }
    }

    public function destroy($id)
    {
        if(Auth::user()->can('delete', Banner::class)) {
            $banner = Banner::findOrFail($id);
            if($banner->photo) {
                if(file_exists($banner->photo->getPath())) {
                    unlink($banner->photo->getPath());
                    $banner->photo()->delete();
                }
            }
            $banner->delete();
            session()->flash('banner_deleted', __("The banner has been deleted."));
            return redirect(route('manage.banners.index'));
        } else {
            return view('errors.403');
        }
    }

    public function deleteBanners(Request $request)
    {
        if(Auth::user()->can('delete', Banner::class)) {
            if(isset($request->delete_single)) {
                $banner = Banner::findOrFail($request->delete_single);
                if($banner->photo) {
                    if(file_exists($banner->photo->getPath())) {
                        unlink($banner->photo->getPath());
                        $banner->photo()->delete();
                    }
                }
                $banner->delete();
                session()->flash('banner_deleted', __("The banner has been deleted."));
            } else {
                if(isset($request->delete_all) && !empty($request->checkboxArray)) {
                    $banners = Banner::findOrFail($request->checkboxArray);
                    foreach($banners as $banner) {
                        if($banner->photo) {
                            if(file_exists($banner->photo->getPath())) {
                                unlink($banner->photo->getPath());
                                $banner->photo()->delete();
                            }
                        }
                        $banner->delete();
                    }
                    session()->flash('banner_deleted', __("The selected banners have been deleted."));
                } else {
                    session()->flash('banner_not_deleted', __("Please select banners to be deleted."));
                }
            }
            return redirect(route('manage.banners.index'));
        } else {
            return view('errors.403');
        }
    }
}
