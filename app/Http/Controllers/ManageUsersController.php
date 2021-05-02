<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersCreateRequest;
use App\Http\Requests\UsersUpdateRequest;
use App\Location;
use App\Photo;
use App\Role;
use App\User;
use App\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\Auth\UserActivationEmail;

class ManageUsersController extends Controller
{
    public function index()
    {
        if(Auth::user()->can('read', User::class)) {
            $users = User::where('location_id', Auth::user()->location_id)->get();
            $default_photo = Photo::getDefaultUserPhoto();
            return view('manage.users.index', compact('users', 'default_photo'));
        } else {
            return view('errors.403');
        }
    }

    public function create()
    {
        if(Auth::user()->can('create', User::class)) {
            $roles = Role::whereNotIn('id', [1])->pluck('name','id')->toArray();
            return view('manage.users.create', compact('roles'));
        } else {
            return view('errors.403');
        }
    }

    public function store(UsersCreateRequest $request)
    {
        if(Auth::user()->can('create', User::class)) {
            $userInput = $request->all();
            $input["name"] = $userInput["name"];
            $input["username"] = $userInput["username"];
            $input["email"] = $userInput["email"];

            $roles = Role::pluck('name','id')->except(1)->toArray();

            if(array_key_exists($request->role, $roles)) {
                $input['role_id'] = $request->role;
            } else {
                $input['role_id'] = 0;
            }

            $location_id = Auth::user()->location_id;
            $input['location_id'] = $location_id;

            if($request->status == 1) {
                $input['is_active'] = $request->status;
            } else {
                $input['is_active'] = 0;
            }

            $input['activation_token'] = str_random(191);
            $input['verified'] = false;

            $input['password'] = bcrypt($request->password);
    
            if($photo = $request->file('photo')) {
                $name = time().$photo->getClientOriginalName();
                $photo->move(Photo::getPhotoDirectoryName(), $name);
                $photo = Photo::create(['name'=>$name]);
                $input['photo_id'] = $photo->id;
            }

            $user = User::create($input);

            event(new UserActivationEmail($user));

            session()->flash('user_created', __("New user has been added."));
    
            return redirect(route('manage.users.index'));
        } else {
            return view('errors.403');
        }
    }

    public function edit($id)
    {
        if(Auth::user()->can('update', User::class)) {
            if($id == 1 && Auth::user()->id != 1) {
                return view('errors.404');
            }
            $user = User::where('location_id', Auth::user()->location_id)->findOrFail($id);
            $roles = Role::whereNotIn('id', [1])->pluck('name','id')->toArray();
            $locations = Location::pluck('name', 'id')->toArray();
            return view('manage.users.edit', compact('user', 'roles', 'locations'));
        } else {
            return view('errors.403');
        }
    }

    public function getUserData($user_name)
    {
        if(Auth::user()->can('read', User::class)) {
            if(Auth::user()->id != 1) {
                return 0;
            }
            $user = User::where('username',$user_name)->first();
            if ($user){
                $already_vendor = Vendor::where('user_id',$user->id)->first();
                if ($already_vendor){
                    return 0;
                }
            }
            return json_encode($user);
        } else {
            return 0;
        }
    }

    public function update(UsersUpdateRequest $request, $id)
    {
        if(Auth::user()->can('update', User::class)) {
            if($id == 1 && Auth::user()->id != 1) {
                return view('errors.404');
            }
            $user = User::where('location_id', Auth::user()->location_id)->findOrFail($id);

            $this->validate($request, [
                'email' => 'unique:users,email,'.$user->id,
                'username' => 'unique:users,username,'.$user->id
            ]);

            if(trim($request->password) == "") {
                $userInput = $request->except('password');
            } else {
                $userInput = $request->all();
                $input['password'] = bcrypt($request->password);
            }

            $input["name"] = $userInput["name"];
            $input["username"] = $userInput["username"];
            $input["email"] = $userInput["email"];

            if($id != 1) {
                $input['is_active'] = $request->status;

                $roles = Role::pluck('name','id')->except(1)->toArray();

                if(array_key_exists($request->role, $roles)) {
                    $input['role_id'] = $request->role;
                } else {
                    $input['role_id'] = 0;
                }

                $input['verified'] = $request->verified;
                if($input['verified'] == 1) {
                    $input['activation_token'] = NULL;
                }
            }

            if(Auth::user()->can('update', Location::class)) {
                $locations = Location::pluck('name','id')->all();                    
                if(array_key_exists($request->location, $locations)) {
                    $input['location_id'] = $request->location;
                } else {
                    $input['location_id'] = 1;
                }
            }

            if(!$request->file('photo') && $request->remove_photo) {
                if($user->photo) {
                    if(file_exists($user->photo->getPath())) {
                        unlink($user->photo->getPath());
                        $user->photo()->delete();
                    }
                }
            }

            if($photo = $request->file('photo')) {
                $name = time().$photo->getClientOriginalName();
                $photo->move(Photo::getPhotoDirectoryName(), $name);
                if($user->photo) {
                    if(file_exists($user->photo->getPath())) {
                        unlink($user->photo->getPath());
                        $user->photo()->delete();
                    }
                }
                $photo = Photo::create(['name'=>$name]);
                $input['photo_id'] = $photo->id;
            }

            $old_email = $user->email;

            if($old_email != $request->email) {
                if($user->id != 1){
                    $input['verified'] = false;
                }
                $input['activation_token'] = str_random(191);
            }

            if($request->has('remove_staff') && !$user->role) {
                $input['location_id'] = null;
                $input['role_id'] = 0;
            }

            $old_location_id = $user->location_id;

            $user->update($input);

            if($request->email != $old_email) {
                event(new UserActivationEmail($user));
            }

            session()->flash('user_updated', __("The user has been updated."));

            if($old_location_id != $user->location_id) {
                return redirect(route('manage.users.index'));
            }

            return redirect(route('manage.users.edit', $user->id));
        } else {
            return view('errors.403');
        }
    }
}
