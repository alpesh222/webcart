<?php

namespace App\Http\Controllers;

use App\ComparisionGroup;
use App\Photo;
use App\Product;
use App\SpecificationType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManageComparisionGroupsController extends Controller
{
    public function index()
    {
        if(Auth::user()->can('read', ComparisionGroup::class)) {
            $comparision_groups = ComparisionGroup::all();
            $specification_types = SpecificationType::where('location_id', Auth::user()->location_id)->get();
            return view('manage.comparision-groups.index', compact('comparision_groups', 'specification_types') );
        } else {
            return view('errors.403');
        }
    }

    public function store(Request $request)
    {
        if(Auth::user()->can('create', ComparisionGroup::class)) {
            $this->validate($request, [
                'title' => 'required|unique:comparision_groups,title'
            ]);
            $input = array();

            if($photo = $request->file('comparision_type_icon')) {
                for ( $i = 0; $i < count($photo); $i++ ){
                    $name = time().$photo[$i]->getClientOriginalName();
                    $photo[$i]->move(Photo::getPhotoDirectoryName(), $name);
                    $icon = Photo::create(['name'=>$name]);
                    $submit['photo_id'][$i] = $icon->id;
                }
            }else{
                session()->flash('comparision_group_not_created', __("Please fill Out Some Comparision Group."));
                return redirect()->back()->withInput();
            }
            $comparision_types = $request->comparision_type;

            $comparision_groups = array();
            for ( $i = 0; $i < count($comparision_types); $i++ ){
                $image_id = !empty($submit['photo_id'][$i]) ? $submit['photo_id'][$i] : '';
                $comparision_groups[] = array(
                    'comp_type' => $comparision_types[$i],
                    'photo_id'  => $image_id
                );
            }
            $userInput = $request->all();
            $input["title"] = $userInput["title"];
            $input['comparision_groups'] = serialize($comparision_groups);

            ComparisionGroup::create($input);
    
            session()->flash('comparision_group_created', __("New Comparision Group has been added successfully."));
            return redirect(route('manage.comparision-group.index'));
        } else {
            return view('errors.403');
        }
    }

    public function edit($id)
    {
        if(Auth::user()->can('update', ComparisionGroup::class)) {
            $comparision_group = ComparisionGroup::where('cg_id',$id)->first();
            if (!empty($comparision_group)){
                $specification_types = SpecificationType::where('location_id', Auth::user()->location_id)->get();
                return view('manage.comparision-groups.edit', compact('specification_types', 'comparision_group'));
            }else{
                session()->flash('comparision_group_not_created', __("No Such Data Found!"));
                return redirect(route('manage.comparision-group.index'));
            }
        } else {
            return view('errors.403');
        }
    }

    public function update(Request $request, $id)
    {
        if(Auth::user()->can('update', ComparisionGroup::class)) {
            $this->validate($request, [
                'title' => 'required'
            ]);
            $comparision_group = ComparisionGroup::where('cg_id',$id)->first();
            if (empty($comparision_group)){
                session()->flash('comparision_group_not_updated', __("No Such Comparision Group Found."));
                return redirect(route('manage.comparision-group.index'));
            }
            $userInput = $request->all();
            $input["title"] = $userInput["title"];

            $comparision_items = !empty($comparision_group->comparision_groups) ? unserialize($comparision_group->comparision_groups) : array();
            if($photo = $request->file('comparision_type_icon')) {
                for ( $i = 0; $i <= count($comparision_items); $i++ ){
                    if (!empty($photo['comp_icon_'.$i])){
                        $name = time().$photo['comp_icon_'.$i]->getClientOriginalName();
                        $photo['comp_icon_'.$i]->move(Photo::getPhotoDirectoryName(), $name);
                        $icon = Photo::create(['name'=>$name]);
                        $submit['photo_id'][$i] = $icon->id;
                    }else{
                        $submit['photo_id'][$i] = !empty($comparision_items[$i]['photo_id']) ? $comparision_items[$i]['photo_id'] : '' ;
                    }
                }
            }else{
                foreach ($comparision_items as $item){
                    $submit['photo_id'][] = $item['photo_id'];
                }
            }
            $comparision_types = $request->comparision_type;
            $comparision_groups = array();
            for ( $i = 0; $i < count($comparision_types); $i++ ){
                $image_id = !empty($submit['photo_id'][$i]) ? $submit['photo_id'][$i] : '';
                $comparision_groups[] = array(
                    'comp_type' => $comparision_types[$i],
                    'photo_id'  => $image_id
                );
            }
            $input['comparision_groups'] = serialize($comparision_groups);

            DB::table('comparision_groups')->where('cg_id', $id)->update($input);

            session()->flash('comparision_group_updated', __("The Comparision Group has been updated successfully."));
            return redirect(route('manage.comparision-group.edit', $comparision_group->cg_id));
        } else {
            return view('errors.403');
        }
    }

    public function destroy($id)
    {
        if(Auth::user()->can('delete', ComparisionGroup::class)) {
            $comparision_group = ComparisionGroup::where('cg_id',$id)->first();
            if (empty($comparision_group)){
                session()->flash('comparision_group_not_deleted', __("No Such Comparision Group Found."));
                return redirect(route('manage.comparision-group.index' ));
            }
            DB::table('comparision_groups')->where('cg_id', $id)->delete();
            session()->flash('comparision_group_deleted', __("The comparision group has been deleted."));
            return redirect(route('manage.comparision-group.index'));
        } else {
            return view('errors.403');
        }
    }

    public function deleteComparisionGroups(Request $request)
    {
        if(Auth::user()->can('delete', ComparisionGroup::class)) {
            if(isset($request->delete_single)) {
                $comparision_group = ComparisionGroup::where('cg_id',$request->delete_single)->first();
                if (empty($comparision_group)){
                    session()->flash('comparision_group_not_deleted', __("No Such Comparision Group Found."));
                    return redirect(route('manage.comparision-group.index' ));
                }
                DB::table('comparision_groups')->where('cg_id', $request->delete_single)->delete();
                session()->flash('comparision_group_deleted', __("The comparision group has been deleted."));
            } else {
                if(isset($request->delete_all) && !empty($request->checkboxArray)) {
                    $comparision_groups = SpecificationType::whereIn('cg_id',$request->checkboxArray)->get();
                    foreach($comparision_groups as $comparision_group) {
                        DB::table('comparision_groups')->where('cg_id', $comparision_group->cg_id)->delete();
                    }
                    session()->flash('comparision_group_deleted', __("The selected comparision groups have been deleted."));
                } else {
                    session()->flash('comparision_group_not_deleted', __("Please select comparision group to be deleted."));
                }
            }
            return redirect(route('manage.comparision-group.index'));
        } else {
            return view('errors.403');
        }
    }
}
