<?php

namespace App\Http\Controllers;

use App\Http\Requests\RolesCreateRequest;
use App\Http\Requests\RolesUpdateRequest;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageRolesController extends Controller
{
    public function index()
    {
        if(Auth::user()->can('read', Role::class)) {
            $roles = Role::all();
            return view('manage.roles.index', compact('roles'));
        } else {
            return view('errors.403');
        }
    }

    public function create()
    {
        if(Auth::user()->can('create', Role::class)) {
            $permissions = Permission::all();
            return view('manage.roles.create', compact('permissions'));
        } else {
            return view('errors.403');
        }
    }

    public function store(RolesCreateRequest $request)
    {
        if(Auth::user()->can('create', Role::class)) {
            $userInput = $request->all();
            $input["name"] = $userInput["name"];
            $input["permission"] = $userInput["permission"];

            $role = Role::create($input);

            if(array_key_exists('permission', $input)) {
                $role->permissions()->sync($input['permission']);
            }

            session()->flash('role_created', __("New role has been added."));
            return redirect(route('manage.roles.index'));
        } else {
            return view('errors.403');
        }
    }

    public function edit($id)
    {
        if(Auth::user()->can('update', Role::class)) {
            if($id != 1) {
                $role = Role::findOrFail($id);
                $permissions = Permission::all();
                return view('manage.roles.edit', compact('role', 'permissions'));
            } else {
                return redirect(route('manage.roles.index'));
            }
        } else {
            return view('errors.403');
        }
    }

    public function update(RolesUpdateRequest $request, $id)
    {
        if(Auth::user()->can('update', Role::class)) {
            if($id != 1) {
                $role = Role::findOrFail($id);
        
                $this->validate($request, [
                    'name' => 'unique:roles,name,'.$role->id
                ]);

                $userInput = $request->all();
                $input["name"] = $userInput["name"];
                $input["permission"] = $userInput["permission"];

                if(array_key_exists('permission', $input)) {
                    $role->permissions()->sync($input['permission']);
                } else {
                    $role->permissions()->sync([]);
                }

                $role->update($input);

                session()->flash('role_updated', __("The role has been updated."));
                return redirect(route('manage.roles.edit', $role->id));
            } else {
                return redirect()->back();
            }
        } else {
            return view('errors.403');
        }
    }

    public function destroy($id)
    {
        if(Auth::user()->can('delete', Role::class)) {
            if($id != 1) {
                $role = Role::findOrFail($id);
                $role->permissions()->detach();
                $role->delete();
                session()->flash('role_deleted', __("The role has been deleted."));
                return redirect(route('manage.roles.index'));
            } else {
                return redirect()->back();
            }
        } else {
            return view('errors.403');
        }
    }

    public function deleteRoles(Request $request)
    {
        if(Auth::user()->can('delete', Role::class)) {
            if(isset($request->delete_single)) {
                if($request->delete_single != 1) {
                    $role = Role::findOrFail($request->delete_single);
                    $role->permissions()->detach();
                    $role->delete();
                    session()->flash('role_deleted', __("The role has been deleted."));
                } else {
                    return redirect()->back();
                }
            } else {
                if(isset($request->delete_all) && !empty($request->checkboxArray)) {
                    $roles = Role::findOrFail($request->checkboxArray);
                    foreach($roles as $role) {
                        if($role->id != 1) {
                            $role->permissions()->detach();
                            $role->delete();
                        }
                    }
                    session()->flash('role_deleted', __("The selected roles have been deleted."));
                } else {
                    session()->flash('role_not_deleted', __("Please select roles to be deleted."));
                }
            }
            return redirect(route('manage.roles.index'));
        } else {
            return view('errors.403');
        }
    }
}
