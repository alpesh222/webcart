<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Http\Requests\BrandsCreateRequest;
use App\Http\Requests\BrandsUpdateRequest;
use App\Location;
use App\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageBrandsController extends Controller
{
    public function index()
    {
        if(Auth::user()->can('read', Brand::class)) {
            if(request()->has('status') && request()->status == 'active') {
                $brands = Brand::where('location_id', Auth::user()->location_id)->where('is_active', 1)->get();
            } else {
                $brands = Brand::where('location_id', Auth::user()->location_id)->get();
            }
            return view('manage.brands.index', compact('brands'));
        } else {
            return view('errors.403');
        }
    }

    public function store(BrandsCreateRequest $request)
    {
        $request->merge(['location' => Auth::user()->location_id]);
        if(Auth::user()->can('create', Brand::class)) {
            $this->validate($request, [
                'name' => 'unique_with:brands,location=location_id'
            ]);

            $userInput = $request->all();
            $input["name"] = $userInput["name"];
            $input["priority"] = $userInput["priority"];
            $input["show_in_menu"] = $request->show_in_menu ? true : false;
            $input["show_in_footer"] = $request->show_in_footer ? true : false;
            $input["show_in_slider"] = $request->show_in_slider ? true : false;
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
    
            if($photo = $request->file('photo')) {
                $name = time().$photo->getClientOriginalName();
                $photo->move(Photo::getPhotoDirectoryName(), $name);
                $photo = Photo::create(['name'=>$name]);
                $input['photo_id'] = $photo->id;
            }

            Brand::create($input);
    
            session()->flash('brand_created', __("New brand has been added."));
    
            return redirect(route('manage.brands.index'));
        } else {
            return view('errors.403');
        }
    }

    public function edit($id)
    {
        if(Auth::user()->can('update', Brand::class)) {
            $brand = Brand::where('location_id', Auth::user()->location_id)->where('id', $id)->firstOrFail();
            return view('manage.brands.edit', compact('brand'));
        } else {
            return view('errors.403');
        }
    }

    public function update(BrandsUpdateRequest $request, $id)
    {
        $request->merge(['location' => Auth::user()->location_id]);
        if(Auth::user()->can('update', Brand::class)) {
            $brand = Brand::findOrFail($id);

            $this->validate($request, [
                'name' => 'unique_with:brands,location=location_id,'.$brand->id
            ]);

            $userInput = $request->all();
            $input["name"] = $userInput["name"];
            $input["priority"] = $userInput["priority"];
            $input["show_in_menu"] = $request->show_in_menu ? true : false;
            $input["show_in_footer"] = $request->show_in_footer ? true : false;
            $input["show_in_slider"] = $request->show_in_slider ? true : false;
            $input["meta_title"] = $userInput["meta_title"];
            $input["meta_desc"] = $userInput["meta_desc"];
            $input["meta_keywords"] = $userInput["meta_keywords"];

            if($request->status == 1) {
                $input['is_active'] = $request->status;
            } else {
                $input['is_active'] = 0;
            }

            if(!$request->file('photo') && $request->remove_photo) {
                if($brand->photo) {
                    if(file_exists($brand->photo->getPath())) {
                        unlink($brand->photo->getPath());
                        $brand->photo()->delete();
                    }
                }
            }

            if($photo = $request->file('photo')) {
                $name = time().$photo->getClientOriginalName();
                $photo->move(Photo::getPhotoDirectoryName(), $name);
                if($brand->photo) {
                    if(file_exists($brand->photo->getPath())) {
                        unlink($brand->photo->getPath());
                        $brand->photo()->delete();
                    }
                }
                $photo = Photo::create(['name'=>$name]);
                $input['photo_id'] = $photo->id;
            }
    
            $brand->update($input);
    
            session()->flash('brand_updated', __("The brand has been updated."));
            return redirect(route('manage.brands.edit', $brand->id));
        } else {
            return view('errors.403');
        }
    }

    public function destroy($id)
    {
        if(Auth::user()->can('delete', Brand::class)) {
            $brand = Brand::findOrFail($id);
            if($brand->photo) {
                if(file_exists($brand->photo->getPath())) {
                    unlink($brand->photo->getPath());
                    $brand->photo()->delete();
                }
            }
            $brand->delete();
            session()->flash('brand_deleted', __("The brand has been deleted."));
            return redirect(route('manage.brands.index'));
        } else {
            return view('errors.403');
        }
    }

    public function deleteBrands(Request $request)
    {
        if(Auth::user()->can('delete', Brand::class)) {
            if(isset($request->delete_single)) {
                $brand = Brand::findOrFail($request->delete_single);
                if($brand->photo) {
                    if(file_exists($brand->photo->getPath())) {
                        unlink($brand->photo->getPath());
                        $brand->photo()->delete();
                    }
                }
                $brand->delete();
                session()->flash('brand_deleted', __("The brand has been deleted."));
            } else {
                if(isset($request->delete_all) && !empty($request->checkboxArray)) {
                    $brands = Brand::findOrFail($request->checkboxArray);
                    foreach($brands as $brand) {
                        if($brand->photo) {
                            if(file_exists($brand->photo->getPath())) {
                                unlink($brand->photo->getPath());
                                $brand->photo()->delete();
                            }
                        }
                        $brand->delete();
                    }
                    session()->flash('brand_deleted', __("The selected brands have been deleted."));
                } else {
                    session()->flash('brand_not_deleted', __("Please select brands to be deleted."));
                }
            }
            return redirect(route('manage.brands.index'));
        } else {
            return view('errors.403');
        }
    }
}
