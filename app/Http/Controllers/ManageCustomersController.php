<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersUpdateRequest;
use App\Customer;
use App\Other;
use App\Order;
use App\Photo;
use App\Mobile;
use App\Role;
use App\User;
use App\Vendor;
use DB;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\Auth\UserActivationEmail;

class ManageCustomersController extends Controller
{
    public function index()
    {
        if(Auth::user()->can('view-customers', Other::class)) {
            $users = User::query();
            $customers = Customer::query();

            /* Search */
            if(!empty(request()->s)) {
                $search = request()->s;
                $users = $users->where('username', 'LIKE', "%$search%")
                ->orWhere('name', 'LIKE', "%$search%")
                ->orWhere('phone', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%");
            }
            if(!empty(request()->s_c)) {
                $search_c = request()->s_c;
                $customers = $customers->orWhere('phone', 'LIKE', "%$search_c%")
                ->orWhere('last_name', 'LIKE', "%$search_c%")
                ->orWhere('first_name', 'LIKE', "%$search_c%")
                ->orWhere('email', 'LIKE', "%$search_c%")
                ->orWhere('address', 'LIKE', "%$search_c%")
                ->orWhere('city', 'LIKE', "%$search_c%")
                ->orWhere('state', 'LIKE', "%$search_c%")
                ->orWhere('zip', 'LIKE', "%$search_c%")
                ->orWhereHas('user', function($query) use ($search_c) {
                    $query->where('username', 'LIKE', "%$search_c%");
                });
            }

            /* Ordering */
            $users = $users->orderBy('id', 'asc');
            $customers = $customers->orderBy('id', 'asc');

            /* Pagination */
            if(empty(request()->all)) {
                if(!empty(request()->per_page)) {
                    $per_page = intval(request()->per_page);
                } else {
                    $per_page = 15;
                }
            } else {
                $per_page = $users->count();
            }
            $users = $users->paginate($per_page);

            if(empty(request()->all_c)) {
                if(!empty(request()->per_page_c)) {
                    $per_page_c = intval(request()->per_page_c);
                } else {
                    $per_page_c = 15;
                }
            } else {
                $per_page_c = $customers->count();
            }
            $customers = $customers->paginate($per_page_c, ['*'], 'page_c');

            $default_photo = Photo::getDefaultUserPhoto();

            $phone_verification = config('settings.phone_otp_verification');

            return view('manage.customers.index', compact('customers', 'users', 'default_photo', 'phone_verification'));
        } else {
            return view('errors.403');
        }
    }

    public function edit($id)
    {
        if(Auth::user()->can('update-customers', Other::class)) {
            if($id == 1 && Auth::user()->id != 1) {
                return view('errors.404');
            }
            $user = User::findOrFail($id);
            $roles = Role::whereNotIn('id', [1])->pluck('name','id')->toArray();
            $customers = Customer::where('user_id', $id)->orderBy('id', 'desc')->get();
            return view('manage.customers.edit', compact('user', 'customers', 'roles'));
        } else {
            return view('errors.403');
        }
    }



    public function promoteCustomer($id)
    {
        if(Auth::user()->can('update-customers', Other::class) && Auth::user()->can('create', Vendor::class) ) {
            if($id == 1 && Auth::user()->id != 1) {
                return view('errors.404');
            }
            $user       = User::findOrFail($id);
            $vendorInput = array();
            $vendorInput["shop_name"] = 'N/a';
            $vendorInput["name"] = $user->name;
            $vendorInput["phone"] = $user->phone;
            $vendorInput["amount_percentage"] = 0;
            $vendorInput['profile_completed'] = 0;
            $vendorInput['approved'] = 0;
            try {
                DB::beginTransaction();
                $vendor = $user->vendor()->create($vendorInput);
                DB::commit();
                session()->flash('vendor_created', __("Customer has been Promoted to vendor successfully!"));
                return redirect(route('manage.vendors.edit', $vendor->id));
            } catch (\Exception $exception) {
                DB::rollBack();
                dd($exception->getMessage());
                session()->flash('vendor_not_created', __("Unexpected error occured. Please try again after some time."));
                return redirect()->back();
            }
        } else {
            return view('errors.403');
        }
    }

    public function update(UsersUpdateRequest $request, $id)
    {
        if(Auth::user()->can('update-customers', Other::class)) {
            if($id == 1 && Auth::user()->id != 1) {
                return view('errors.404');
            }
            $user = User::findOrFail($id);

            $rules = [
                'email' => 'unique:users,email,'.$user->id,
                'username' => 'unique:users,username,'.$user->id
            ];

            $phone_verification = config('settings.phone_otp_verification');

            if($phone_verification) {
                if(is_null($request['phone-number'])) {
                    $request->merge(['phone' => NULL]);
                }
            }

            $this->validate($request, $rules);

            if(trim($request->password) == "") {
                $userInput = $request->except('password');
            } else {
                $userInput = $request->all();
                $input['password'] = bcrypt($request->password);
            }

            $input["name"] = $userInput["name"];
            $input["username"] = $userInput["username"];
            $input["email"] = $userInput["email"];

            if($phone_verification) {
                if($request->remove_phone) {
                    $user->mobile()->delete();
                    $user->phone = NULL;
                    $user->save();
                } else {
                    if($request['phone-number']) {

                        $input["phone"] = $userInput["phone"];

                        $mobile = Mobile::where('user_id', '!=', $id)->where('number', $input['phone'])->where('verified', true)->first();

                        if($mobile) {
                            $validator = Validator::make([], []);
                            $validator->errors()->add('phone', __('This phone number is already registered.'));
                            throw new \Illuminate\Validation\ValidationException($validator);
                        }

                        $verified = false;
                        if($request->phone_verified) {
                            $verified = true;
                        }
                        if($user->mobile) {
                            $old_mobile = $user->mobile->number;
                            if($old_mobile != $request->phone) {
                                $user->mobile()->update(['verified' => $verified, 'number' => $request->phone]);
                            } else {
                                $user->mobile()->update(['verified' => $verified]);
                            }
                        } else {
                            $mobile = new Mobile(['verified' => $verified, 'number' => $request->phone]);
                            $user->mobile()->save($mobile);
                        }
                    } else {
                        $user->mobile()->delete();
                    }
                }
            }

            if(Auth::user()->can('update', User::class) && $request->has('role') && $id != 1) {
                $roles = Role::pluck('name','id')->except(1)->toArray();
                if(array_key_exists($request->role, $roles)) {
                    $input['role_id'] = $request->role;
                    if(!$user->location) {
                        $input['location_id'] = Auth::user()->location_id;
                    }
                } else {
                    $input['role_id'] = 0;
                }
            }

            if($id != 1) {
                $input['verified'] = $request->verified;
                $input['is_active'] = $request->status;
                if($input['verified'] == 1) {
                    $input['activation_token'] = NULL;
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

            $user->update($input);

            if($request->email != $old_email) {
                event(new UserActivationEmail($user));
            }

            session()->flash('user_updated', __("The user has been updated."));
    
            return redirect(route('manage.customers.edit', $user->id));
        } else {
            return view('errors.403');
        }
    }

    public function viewUserOrders($id) {
        if(Auth::user()->can('read', Order::class)) {
            $orders = Order::where('location_id', Auth::user()->location_id)->where('user_id', $id);

            if(!empty(request()->s)) {

                $search = request()->s;
                $search_trimmed = trim(strtolower($search));
                $skip_search = false;
                switch ($search_trimmed) {
                    case 'delivered':
                        $orders = $orders->where('is_processed', 1);
                        $skip_search = true;
                        break;
                    case 'cancelled':
                        $orders = $orders->where('stock_regained', 1);
                        $skip_search = true;
                        break;
                    case 'failed':
                        $orders = $orders->where('payment_method', '!=', 'Cash on Delivery')->where('payment_method', '!=', 'Bank Transfer')->where('paid', 0);
                        $skip_search = true;
                        break;
                    case 'pending':
                        $orders = $orders->where('stock_regained', '!=', 1)
                        ->where('is_processed', '!=', 1);
                        break;
                    default:
                        $orders = $orders->where('status', 'LIKE', $search);
                        break;
                }

                if(!$skip_search) {
                    $orders = $orders->orWhere('id', (int)$search - 10000)
                    ->orWhere('status', 'LIKE', "%$search%")
                    ->orWhereHas('address', function($query) use ($search) {
                        $query->where('first_name', 'LIKE', "%$search%")
                        ->where('last_name', 'LIKE', "%$search%")
                        ->orWhere('email', 'LIKE', "%$search%")
                        ->orWhere('phone', 'LIKE', "%$search%");
                    })
                    ->orWhereHas('user', function($query) use ($search) {
                        $query->where('name', 'LIKE', "%$search%")
                        ->orWhere('username', 'LIKE', "%$search%")
                        ->orWhere('email', 'LIKE', "%$search%");
                    });
                }
            }

            if(Auth::user()->can('manage-shipment-orders', Other::class) && Auth::user()->cannot('update', Order::class)) {
                $orders = $orders->get();
                $orders = $orders->filter(function($order) {
                    return (count($order->shipments) > 0) && in_array($order->shipments()->orderBy('id', 'desc')->first()->id, Auth::user()->shipments->pluck('id')->toArray());
                });
                $sort = true;
            }

            if(isset($sort)) {
                /* Ordering */
                $orders = $orders->sortByDesc(function($order) {
                    return $order->id;
                });
            } else {
                $orders = $orders->orderby('id', 'desc');
            }

            /* Pagination */
            if(empty(request()->all)) {
                if(!empty(request()->per_page)) {
                    $per_page = intval(request()->per_page);
                } else {
                    $per_page = 15;
                }
            } else {
                $per_page = $orders->count();
            }
            $orders = $orders->paginate($per_page);

            return view('manage.orders.index', compact('orders', 'id'));
        } else {
            return view('errors.403');
        }
    }

    public function destroy($id)
    {
        if(Auth::user()->can('update-customers', Other::class)) {
            if($id != 1) {
                $user = User::findOrFail($id);
                try {
                    DB::beginTransaction();
                    $user->mobile()->delete();
                    $user->shipments()->sync([]);
                    $user->vouchers()->sync([]);
                    foreach($user->orders as $order) {
                        $order->products()->detach();
                        $order->delete();
                    }
                    $user->favouriteProducts()->delete();
                    $user->customers()->delete();
                    $user->addresses()->delete();
                    $user->reviews()->delete();
                    if($user->products()->count() > 0) {
                        $user->products()->update([
                            'user_id' => 0
                        ]);
                    }
                    if($user->photo) {
                        if(file_exists($user->photo->getPath())) {
                            unlink($user->photo->getPath());
                            $user->photo()->delete();
                        }
                    }

                    $user->delete();
                    session()->flash('user_deleted', "The user has been deleted.");
                    DB::commit();
                } catch (\Exception $exception) {
                    DB::rollBack();
                    session()->flash('user_not_deleted', "Unexpected error occured. Please try again after some time.");
                    return redirect()->back();
                }
                return redirect()->back();
            }
            return view('errors.404');
        } else {
            return view('errors.403');
        }
    }

    public function deleteCustomers(Request $request)
    {
        if(Auth::user()->can('update-customers', Other::class)) {
            if(isset($request->delete_single)) {
                if($request->delete_single != 1) {
                    $user = User::findOrFail($request->delete_single);
                    try {
                        DB::beginTransaction();
                        $user->mobile()->delete();
                        $user->shipments()->sync([]);
                        $user->vouchers()->sync([]);
                        foreach($user->orders as $order) {
                            $order->products()->detach();
                            $order->delete();
                        }
                        $user->favouriteProducts()->delete();
                        $user->customers()->delete();
                        $user->addresses()->delete();
                        $user->reviews()->delete();
                        if($user->products()->count() > 0) {
                            $user->products()->update([
                                'user_id' => 0
                            ]);
                        }
                        if($user->photo) {
                            if(file_exists($user->photo->getPath())) {
                                unlink($user->photo->getPath());
                                $user->photo()->delete();
                            }
                        }

                        $user->delete();
                        session()->flash('user_deleted', "The user has been deleted.");
                        DB::commit();
                    } catch (\Exception $exception) {
                        DB::rollBack();
                        session()->flash('user_not_deleted', "Unexpected error occured. Please try again after some time.");
                        return redirect()->back();
                    }
                } else {
                    return view('errors.404');
                }
            } else {
                if(isset($request->delete_all) && !empty($request->checkboxArray)) {
                    $users = User::findOrFail($request->checkboxArray);
                    try {
                        DB::beginTransaction();
                        foreach($users as $user) {
                            if($user->id != 1) {
                                $user->mobile()->delete();
                                $user->shipments()->sync([]);
                                $user->vouchers()->sync([]);
                                foreach($user->orders as $order) {
                                    $order->products()->detach();
                                    $order->delete();
                                }
                                $user->favouriteProducts()->delete();
                                $user->customers()->delete();
                                $user->addresses()->delete();
                                $user->reviews()->delete();
                                if($user->products()->count() > 0) {
                                    $user->products()->update([
                                        'user_id' => 0
                                    ]);
                                }
                                if($user->photo) {
                                    if(file_exists($user->photo->getPath())) {
                                        unlink($user->photo->getPath());
                                        $user->photo()->delete();
                                    }
                                }

                                $user->delete();
                            }
                        }
                        DB::commit();
                    } catch (\Exception $exception) {
                        DB::rollBack();
                        session()->flash('user_not_deleted', "Unexpected error occured. Please try again after some time.");
                        return redirect()->back();
                    }
                    session()->flash('user_deleted', "The selected users have been deleted.");
                } else {
                    session()->flash('user_not_deleted', "Please select users to be deleted.");
                }
            }
            return redirect()->back();
        } else {
            return view('errors.403');
        }
    }
}
