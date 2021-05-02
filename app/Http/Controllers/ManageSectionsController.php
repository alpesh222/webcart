<?php

namespace App\Http\Controllers;

use App\Section;
use App\Location;
use App\Category;
use App\Brand;
use Illuminate\Http\Request;
use App\Http\Requests\SectionsCreateRequest;
use Illuminate\Support\Facades\Auth;

class ManageSectionsController extends Controller
{
    public function index()
    {
        if(Auth::user()->can('read', Section::class)) {
            $location_id = Auth::user()->location_id;
            $sections = Section::where('location_id', $location_id)->get();
            $brands = Brand::where('location_id', $location_id)->pluck('name', 'id')->toArray();
            $root_categories = Category::where('location_id', $location_id)->where('category_id', 0)->get();
            return view('manage.sections.index', compact('sections', 'brands', 'root_categories'));
        } else {
            return view('errors.403');
        }
    }

    public function store(SectionsCreateRequest $request)
    {
        if(Auth::user()->can('create', Section::class)) {

            if(!$request->brand && !$request->category && !$request->position) {
                return redirect()->back()->withErrors(__('Please select at least one location to display section.'))->withInput($request->input());
            }

            $userInput = $request->all();
            $input["content"] = $userInput["content"];
            $input["position"] = $userInput["position"];
            $input["priority"] = $userInput["priority"];
            $input["full_width"] = array_key_exists("full_width", $userInput) ? $userInput["full_width"] == "on" : false;
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

            Section::create($input);
    
            session()->flash('section_created', __("New section has been added."));
    
            return redirect(route('manage.sections.index'));
        } else {
            return view('errors.403');
        }
    }

    public function edit($id)
    {
        if(Auth::user()->can('update', Section::class)) {
            $location_id = Auth::user()->location_id;
            $section = Section::where('location_id', $location_id)->where('id', $id)->firstOrFail();
            $root_categories = Category::where('location_id', $location_id)->where('category_id', 0)->get();
            $categories = Category::where('location_id', $location_id)->where('category_id', 0)->get();
            $brands = Brand::where('location_id', $location_id)->pluck('name', 'id')->toArray();
            return view('manage.sections.edit', compact('section', 'root_categories', 'categories', 'brands'));
        } else {
            return view('errors.403');
        }
    }

    public function update(SectionsCreateRequest $request, $id)
    {
        if(Auth::user()->can('update', Section::class)) {

            $section = Section::findOrFail($id);

            $home_position_selected = $request->position;
            $brand_position_selected = $request->brand && $request->position_brand;
            $category_position_selected = ($request->category && $request->position_category) ||
                                    (!$request->remove_category && $section->category_id && $request->position_category);
            $no_location_selected = !$home_position_selected && !$brand_position_selected && !$category_position_selected;

            if($no_location_selected) {
                return redirect()->back()->withErrors(__('Please select at least one location to display section.'))->withInput($request->input());
            }

            $userInput = $request->all();
            $input["content"] = $userInput["content"];
            $input["position"] = $userInput["position"];
            $input["priority"] = $userInput["priority"];
            $input["full_width"] = array_key_exists("full_width", $userInput) ? $userInput["full_width"] == "on" : false;
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
                    $input['category_id'] = $section->category_id;
                }
            }
    
            $section->update($input);
    
            session()->flash('section_updated', __("The section has been updated."));
            return redirect(route('manage.sections.edit', $section->id));
        } else {
            return view('errors.403');
        }
    }

    public function destroy($id)
    {
        if(Auth::user()->can('delete', Section::class)) {
            $section = Section::findOrFail($id);
            $section->delete();
            session()->flash('section_deleted', __("The section has been deleted."));
            return redirect(route('manage.sections.index'));
        } else {
            return view('errors.403');
        }
    }

    public function deleteSections(Request $request)
    {
        if(Auth::user()->can('delete', Section::class)) {
            if(isset($request->delete_single)) {
                $section = Section::findOrFail($request->delete_single);
                $section->delete();
                session()->flash('section_deleted', __("The section has been deleted."));
            } else {
                if(isset($request->delete_all) && !empty($request->checkboxArray)) {
                    $sections = Section::findOrFail($request->checkboxArray);
                    foreach($sections as $section) {
                        $section->delete();
                    }
                    session()->flash('section_deleted', __("The selected sections have been deleted."));
                } else {
                    session()->flash('section_not_deleted', __("Please select sections to be deleted."));
                }
            }
            return redirect(route('manage.sections.index'));
        } else {
            return view('errors.403');
        }
    }
}
