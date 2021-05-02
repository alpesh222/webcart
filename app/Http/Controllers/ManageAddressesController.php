<?php

namespace App\Http\Controllers;

use App\Country;
use App\Other;
use App\Customer;
use App\Http\Requests\CustomersCreateRequest;
use Illuminate\Support\Facades\Auth;

class ManageAddressesController extends Controller
{
    public function edit($id)
    {
        if(Auth::user()->can('update-customers', Other::class)) {
            $customer = Customer::findOrFail($id);
            $countries = Country::getAllActiveCountries();
            return view('manage.addresses.edit', compact('customer','countries'));
        } else {
            return view('errors.403');
        }
    }

    public function update(CustomersCreateRequest $request, $id)
    {
        if(Auth::user()->can('update-customers', Other::class)) {
            $customer = Customer::findOrFail($id);
            $input = $request->all();

            $customer->update([
                "first_name" => $input["first_name"],
                "last_name" => $input["last_name"],
                "address" => $input["address"],
                "city" => $input["city"],
                "state" => $input["state"],
                "zip" => $input["zip"],
                "country" => $input["country"],
                "phone" => $input["phone"],
                "email" => $input["email"]
            ]);

            session()->flash('address_updated', __("The address has been updated."));
            return redirect(route('manage.customer-address.edit', $customer->id));
        } else {
            return view('errors.403');
        }
    }

    public function destroy($id)
    {
        if(Auth::user()->can('update-customers', Other::class)) {
            $customer = Customer::findOrFail($id);
            $customer->delete();
            session()->flash('address_deleted', __("The address has been removed."));
            return redirect()->back();
        } else {
            return view('errors.403');
        }
    }
}
