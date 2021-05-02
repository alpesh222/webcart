<?php

namespace App\Http\Controllers;

use App\Country;
use App\Customer;
use App\DeliveryLocation;
use App\Http\Requests\CustomersCreateRequest;
use App\User;
use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use mysql_xdevapi\Exception;
use phpDocumentor\Reflection\Types\Null_;

class FrontCustomersController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $customers = Customer::where('user_id', $user_id)->orderBy('id', 'desc')->get();
        return view('front.customers.index', compact('customers'));
    }

    public function store(CustomersCreateRequest $request)
    {
        $input = $request->all();
        try{
            $country = Country::where('country_name',$input['country'])->first();
            if ($country == null){
                throw new \Exception('No Such Country Available In Records!');
            }
        }catch (\Exception $e){
            session()->flash('payment_fail', __($e->getMessage()));
            return redirect(route('checkout.shipping'))->withInput();
        }
        if(config('settings.enable_zip_code')){
            $delivery_available = DeliveryLocation::where([
                ['pincode','=',$input['zip']],
                ['status','=',1],
                ['deleted_at','=',Null],
            ])->first();
            if($delivery_available){
                $customer       = new Customer();
                $customer_data  = $customer->addCustomerShippingAddress($input);
                session(['customer_id' => $customer_data->id]);
                return redirect()->route('checkout.payment');
            }else{
                session()->flash('payment_fail', __("Shipping Not Available To Entered Pincode"));
                return redirect(route('checkout.shipping'))->withInput();
            }
        }else{
            $customer       = new Customer();
            $customer_data  = $customer->addCustomerShippingAddress($input);
            session(['customer_id' => $customer_data->id]);
            return redirect()->route('checkout.payment');
        }

    }

    public function startPaymentSession(Request $request)
    {
        $this->validate($request, [
            'address_option' => 'required|integer'
        ]);

        $customer = Customer::findOrFail($request->address_option);
        if(config('settings.enable_zip_code')){
            $delivery_available = DeliveryLocation::where([
                ['pincode','=',$customer->zip],
                ['status','=',1],
                ['deleted_at','=',Null],
            ])->first();
            if($delivery_available){
                session(['customer_id' => $customer->id]);
                return redirect(route('checkout.shipping'));
            }else{
                session()->flash('payment_fail', __("Shipping Not Available To Selected Pincode"));
                return redirect(route('checkout.shipping'));
            }
        }
        session(['customer_id' => $customer->id]);
        return redirect()->route('checkout.payment');
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        $countries = Country::getAllActiveCountries();
        if(Auth::user()->can('update', $customer)) {
            return view('front.customers.edit', compact('customer','countries'));
        } else {
            return view('errors.403');
        }        
    }

    public function update(CustomersCreateRequest $request, $id)
    {
        $customer = Customer::findOrFail($id);

        if(Auth::user()->can('update', $customer)) {
            $input = $request->all();

            $customer->fill([
                "first_name" => $input["first_name"],
                "last_name" => $input["last_name"],
                "address" => $input["address"],
                "city" => $input["city"],
                "state" => $input["state"],
                "zip" => $input["zip"],
                "country" => $input["country"],
                "phone" => $input["phone"],
                "email" => $input["email"]
            ])->save();

            session()->flash('address_updated', __("The address has been updated."));
            return redirect(route('front.addresses.edit', $customer->id));
        } else {
            return view('errors.403');
        }
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        if(Auth::user()->can('delete', $customer)) {
            $customer->delete();
            session()->flash('address_deleted', __("The address has been removed."));
            return redirect(route('front.addresses.index'));
        } else {
            return view('errors.403');
        }        
    }

    public function walletHistory()
    {
        $user_id = Auth::user()->id;
        $user_wallet_bal        = User::select('wallet_balance')->where('id', $user_id)->first();
        $user_wallet_history    = Wallet::where('user_id', $user_id)->orderby('wallet_id','desc')->paginate(10);
        return view('front.wallet-history.index', compact('user_wallet_bal','user_wallet_history'));
    }

    public function userReferrals()
    {
        if ( !config('referral.enable') ){
            abort('404');
        }
        $user_id = Auth::user()->id;
        $user_referral_code = User::select('self_referral_code')->where('id', $user_id)->first();
        return view('front.referrals.index', compact('user_referral_code'));
    }
    public function generateUserReferralCode()
    {
        if ( !config('referral.enable') || !empty( Auth::user()->self_referral_code ) ){
            abort('404');
        }
        $user = Auth::user();
        $user->self_referral_code = User::generateUniqueReferralCode(6);
        $user->save();
        return redirect( route('front.referrals.index') );
    }

}
