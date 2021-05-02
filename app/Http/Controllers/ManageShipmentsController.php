<?php

namespace App\Http\Controllers;

use App\Country;
use App\User;
use App\Shipment;
use Illuminate\Http\Request;
use App\Http\Requests\ShipmentsCreateRequest;
use Illuminate\Support\Facades\Auth;

class ManageShipmentsController extends Controller
{
    public function index()
    {
        if(Auth::user()->can('read', Shipment::class)) {
            $shipments = Shipment::all();
            return view('manage.shipments.index', compact('shipments'));
        } else {
            return view('errors.403');
        }
    }

    public function create()
    {
        if(Auth::user()->can('create', Shipment::class)) {
            $users = User::where('role_id', '!=', 0)->select('id', 'name', 'username')->get();
            $countries = Country::getAllActiveCountries();
            return view('manage.shipments.create', compact('users','countries'));
        } else {
            return view('errors.403');
        }
    }

    public function store(ShipmentsCreateRequest $request)
    {
        if(Auth::user()->can('create', Shipment::class)) {
            $input["name"] = $request->name ? $request->name : '';
            $input["address"] = $request->address ? $request->address : '';
            $input["city"] = $request->city ? $request->city : '';
            $input["state"] = $request->state ? $request->state : '';
            $input["zip"] = $request->zip ? $request->zip : '';
            $input["country"] = $request->country;

            $shipment = Shipment::create($input);

            if($request->has('user')) {
                $shipment->users()->sync($request->user);
            }

            session()->flash('shipment_created', __("New shipment has been added."));
            return redirect(route('manage.shipments.index'));
        } else {
            return view('errors.403');
        }
    }

    public function edit($id)
    {
        if(Auth::user()->can('update', Shipment::class)) {
            $shipment = Shipment::where('id', $id)->firstOrFail();
            $users = User::where('role_id', '!=', 0)->select('id', 'name', 'username')->get();
            $countries = Country::getAllActiveCountries();
            return view('manage.shipments.edit', compact('shipment', 'users','countries'));
        } else {
            return view('errors.403');
        }
    }

    public function update(ShipmentsCreateRequest $request, $id)
    {
        if(Auth::user()->can('update', Shipment::class)) {
            $shipment = Shipment::findOrFail($id);
    
            $input["name"] = $request->name ? $request->name : '';
            $input["address"] = $request->address ? $request->address : '';
            $input["city"] = $request->city ? $request->city : '';
            $input["state"] = $request->state ? $request->state : '';
            $input["zip"] = $request->zip ? $request->zip : '';
            $input["country"] = $request->country;

            if($request->has('user')) {
                $shipment->users()->sync($request->user);
            } else {
                $shipment->users()->sync([]);
            }

            $shipment->update($input);

            session()->flash('shipment_updated', __("The shipment has been updated."));
            return redirect(route('manage.shipments.edit', $shipment->id));
        } else {
            return view('errors.403');
        }
    }

    public function destroy($id)
    {
        if(Auth::user()->can('delete', Shipment::class)) {
            $shipment = Shipment::findOrFail($id);
            $shipment->users()->detach();
            $shipment->orders()->detach();
            $shipment->delete();
            session()->flash('shipment_deleted', __("The shipment has been deleted."));
            return redirect(route('manage.shipments.index'));
        } else {
            return view('errors.403');
        }
    }

    public function deleteShipments(Request $request)
    {
        if(Auth::user()->can('delete', Shipment::class)) {
            if(isset($request->delete_single)) {
                $shipment = Shipment::findOrFail($request->delete_single);
                $shipment->users()->detach();
                $shipment->orders()->detach();
                $shipment->delete();
                session()->flash('shipment_deleted', __("The shipment has been deleted."));
            } else {
                if(isset($request->delete_all) && !empty($request->checkboxArray)) {
                    $shipments = Shipment::findOrFail($request->checkboxArray);
                    foreach($shipments as $shipment) {
                        $shipment->users()->detach();
                        $shipment->orders()->detach();
                        $shipment->delete();
                    }
                    session()->flash('shipment_deleted', __("The selected shipments have been deleted."));
                } else {
                    session()->flash('shipment_not_deleted', __("Please select shipments to be deleted."));
                }
            }
            return redirect(route('manage.shipments.index'));
        } else {
            return view('errors.403');
        }
    }
}
