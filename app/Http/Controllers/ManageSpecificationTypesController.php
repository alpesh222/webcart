<?php

namespace App\Http\Controllers;

use App\Product;
use App\Location;
use App\SpecificationType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ManageSpecificationTypesController extends Controller
{
    public function index()
    {
        if(Auth::user()->can('read', Product::class)) {
            $specification_types = SpecificationType::where('location_id', Auth::user()->location_id)->get();
            return view('manage.specification-types.index', compact('specification_types'));
        } else {
            return view('errors.403');
        }
    }

    public function store(Request $request)
    {
        if(Auth::user()->can('create', Product::class)) {

            $userInput = $request->all();
            $input["name"] = $userInput["name"];

            $location_id = Auth::user()->location_id;
            $input['location_id'] = $location_id;

            SpecificationType::create($input);
    
            session()->flash('specification_type_created', __("New specification type has been added."));
    
            return redirect(route('manage.specification-types.index'));
        } else {
            return view('errors.403');
        }
    }

    public function edit($id)
    {
        if(Auth::user()->can('update', Product::class)) {
            $specification_type = SpecificationType::where('location_id', Auth::user()->location_id)->where('id', $id)->firstOrFail();

            return view('manage.specification-types.edit', compact('specification_type'));
        } else {
            return view('errors.403');
        }
    }

    public function update(Request $request, $id)
    {
        if(Auth::user()->can('update', Product::class)) {
            $specification_type = SpecificationType::findOrFail($id);
            $userInput = $request->all();
            $input["name"] = $userInput["name"];
            $specification_type->update($input);

            session()->flash('specification_type_updated', __("The specification type has been updated."));
            return redirect(route('manage.specification-types.edit', $specification_type->id));
        } else {
            return view('errors.403');
        }
    }

    public function destroy($id)
    {
        if(Auth::user()->can('delete', Product::class)) {
            $specification_type = SpecificationType::findOrFail($id);
            $specification_type->delete();
            session()->flash('specification_type_deleted', __("The specification type has been deleted."));
            return redirect(route('manage.specification-types.index'));
        } else {
            return view('errors.403');
        }
    }

    public function deleteSpecificationTypes(Request $request)
    {
        if(Auth::user()->can('delete', Product::class)) {
            if(isset($request->delete_single)) {
                $specification_type = SpecificationType::findOrFail($request->delete_single);
                $specification_type->delete();
                session()->flash('specification_type_deleted', __("The specification type has been deleted."));
            } else {
                if(isset($request->delete_all) && !empty($request->checkboxArray)) {
                    $specification_types = SpecificationType::findOrFail($request->checkboxArray);
                    foreach($specification_types as $specification_type) {
                        $specification_type->delete();
                    }
                    session()->flash('specification_type_deleted', __("The selected specification types have been deleted."));
                } else {
                    session()->flash('specification_type_not_deleted', __("Please select specification_type to be deleted."));
                }
            }
            return redirect(route('manage.specification-types.index'));
        } else {
            return view('errors.403');
        }
    }
}
