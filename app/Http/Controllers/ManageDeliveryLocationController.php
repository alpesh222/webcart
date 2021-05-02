<?php

namespace App\Http\Controllers;

use App\Country;
use App\DeliveryLocation;
use App\Http\Requests\DeliveryLocationCreateRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ManageDeliveryLocationController extends Controller
{

    public function index()
    {
        if(Auth::user()->can('view', DeliveryLocation::class)) {
            $deliveryLocations = DeliveryLocation::getAllActiveDeliveryLocations();

            return view('manage.deliveryLocation.index', compact('deliveryLocations'));
        } else {
            return view('errors.403');
        }
    }

    public function create()
    {
        if(Auth::user()->can('create',DeliveryLocation::class)){
            $countries = Country::getAllActiveCountries();
            return view('manage.deliveryLocation.create', compact('countries'));
        }else {
            return view('errors.403');
        }
    }

    public function store(DeliveryLocationCreateRequest $request)
    {
        if(Auth::user()->can('create', DeliveryLocation::class)) {
            $input["country"]   = $request->country ? $request->country : '';
            $input["state"]     = $request->state ? $request->state : '';
            $input["city"]      = $request->city ? $request->city : '';
            $input["pincode"]  = $request->zip_code ? $request->zip_code : '';
            $input["status"]    = $request->enable_delivery_location ? '1' : '0';
            $delivery_location = DeliveryLocation::create($input);
            if($delivery_location){
                session()->flash('delivery_location_created', __("New Delivery Location has been added Successfully."));
            }else{
                session()->flash('delivery_location_not_created', __("Something Went Wrong Please Try Again!"));
            }
            return redirect(route('manage.delivery-location.index'));
        } else {
            return view('errors.403');
        }
    }


    public function edit(DeliveryLocation $deliveryLocation)
    {
        if(Auth::user()->can('update', DeliveryLocation::class)) {
            $delivery_location_data = DeliveryLocation::where('id', $deliveryLocation->id)->first();
            $countries              = Country::getAllActiveCountries();
            return view('manage.deliveryLocation.edit', compact('delivery_location_data','countries'));
        } else {
            return view('errors.403');
        }
    }

    public function update(DeliveryLocationCreateRequest $request, DeliveryLocation $deliveryLocation)
    {
        if(Auth::user()->can('update', DeliveryLocation::class)) {

            $delivery_location = DeliveryLocation::findOrFail($deliveryLocation->id);
            $input["country"]   = $request->country ? $request->country : '';
            $input["state"]     = $request->state ? $request->state : '';
            $input["city"]      = $request->city ? $request->city : '';
            $input["pincode"]  = $request->zip_code ? $request->zip_code : '';
            $input["status"]    = $request->enable_delivery_location ? '1' : '0';

            $delivery_location->update($input);

            session()->flash('delivery_location_updated', __("The Delivery location has been updated."));
            return redirect(route('manage.delivery-location.edit', $delivery_location->id));
        } else {
            return view('errors.403');
        }
    }

    public function destroy(DeliveryLocation $deliveryLocation)
    {
        if(Auth::user()->can('delete', DeliveryLocation::class)) {
            $deliveryLocation = DeliveryLocation::findOrFail($deliveryLocation->id);
            $deliveryLocation->delete();
            session()->flash('delivery_location_deleted', __("The Delivery Location has been deleted Successfully."));
            return redirect(route('manage.delivery-location.index'));
        } else {
            return view('errors.403');
        }
    }

    public function deleteDeliveryLocation(Request $request)
    {
        if(Auth::user()->can('delete', DeliveryLocation::class)) {
            if(isset($request->delete_single)) {
                $delivery_location = DeliveryLocation::findOrFail($request->delete_single);
                $delivery_location->delete();
                session()->flash('delivery_location_deleted', __("The Delivery Location has been deleted Successfully."));
            } else {
                if(isset($request->delete_all) && !empty($request->checkboxArray)) {
                    $delivery_location = DeliveryLocation::findOrFail($request->checkboxArray);
                    foreach($delivery_location as $location) {
                        $location->delete();
                    }
                    session()->flash('delivery_location_deleted', __("The Delivery Location have been deleted Successfully."));
                } else {
                    session()->flash('delivery_location_deleted', __("Please select Delivery Locations to be deleted."));
                }
            }
            return redirect(route('manage.delivery-location.index'));
        } else {
            return view('errors.403');
        }
    }

    public function checkShippingAvailability($locationPincode) {
        $checkExist = DeliveryLocation::where([
                ['pincode','=',$locationPincode],
                ['status','=',1],
                ['deleted_at','=',NULL],
                ])->first();
        if(!empty($checkExist)) {
            session()->put('shipping_availability',1);
            session()->put('shipping_availability_value',$locationPincode);
            return 1;
        }
        session()->put('shipping_availability',0);
        session()->put('shipping_availability_value',$locationPincode);
        return 0;
    }
}
