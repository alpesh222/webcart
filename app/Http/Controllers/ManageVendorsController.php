<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Vendor;
use App\VendorAmount;
use App\VendorPayment;
use App\VendorRequest;
use App\VendorSetting;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\VendorsCreateRequest;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;

class ManageVendorsController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        if($vendor = $user->isApprovedVendor()) {
            $vendor_amounts = $vendor->vendor_amounts()->orderBy('id', 'desc')->paginate(10);

            $outstanding_amount = $vendor->vendor_amounts()->where('status', 'outstanding')->sum('vendor_amount');
            $amount_earned = $vendor->vendor_amounts()->where('status', 'earned')->sum('vendor_amount');
            $amount_paid = $vendor->vendor_amounts()->where('status', 'paid')->sum('vendor_amount');

            $minimum_amount_for_request = config('vendor.minimum_amount_for_request');

            $pending_request = $vendor->vendor_requests()->where('is_processed', 0)->orderBy('id', 'desc')->first();

            $has_pending_request = (bool) $pending_request;
            if($has_pending_request) {
                $payout_request_date_time = $pending_request->created_at->format('d-m-Y h:i A');
            } else {
                $payout_request_date_time = null;
            }

            $allow_payout_request = ($amount_earned >= config('vendor.minimum_amount_for_request') );

            return view('manage.vendors.dashboard', compact('user', 'vendor', 'vendor_amounts', 'outstanding_amount', 'amount_earned', 'amount_paid', 'minimum_amount_for_request', 'has_pending_request', 'payout_request_date_time', 'allow_payout_request'));
        } else {
            return view('errors.403');
        }
    }

    public function payments()
    {
        $user = Auth::user();
        if($vendor = $user->isApprovedVendor()) {
            $vendor_payments = $vendor->vendor_payments()->orderBy('id', 'desc')->paginate(10, ['*'], 'tx_page');

            $payment_paypal = $vendor->vendor_settings()->where('key', 'payment_paypal')->first();
            $payment_bank_transfer = $vendor->vendor_settings()->where('key', 'payment_bank_transfer')->first();

            if($payment_paypal) {
                $payment_paypal = unserialize($payment_paypal->value);
            } else {
                $payment_paypal = array();
            }

            if($payment_bank_transfer) {
                $payment_bank_transfer = unserialize($payment_bank_transfer->value);
            } else {
                $payment_bank_transfer = array();
            }

            return view('manage.vendors.payments', compact('user', 'vendor', 'vendor_payments', 'payment_paypal', 'payment_bank_transfer'));
        } else {
            return view('errors.403');
        }
    }

    public function index()
    {
        if(Auth::user()->can('read', Vendor::class)) {
            $vendors = Vendor::all();
            return view('manage.vendors.index', compact('vendors'));
        } else {
            return view('errors.403');
        }
    }


     public function vendorRequest(){
//        print_r('in');exit;
            if(Auth::user()->can('read', Vendor::class)) {
                $vendor_all_requests = VendorRequest::with('vendor:name,phone,shop_name,id')->whereRaw('is_processed IN (0)')->orderBy('id', 'desc')->paginate(10, ['*'], 'vr_page');
//                $vendors = Vendor::all();
                return view('manage.vendors.vendors_request', compact('vendor_all_requests'));
            } else {
                return view('errors.403');
            }
        }

    public function show($id)
    {
        $month_filter = false;
        $date_filter = null;
        if($month_year = request()->month) {
            $month_year = explode('-', $month_year);
            $month = $month_year[0];
            $year  = $month_year[1];
            $month_filter = true;
            $date_filter = Carbon::createFromDate($year, $month, 1);
        }

        if(Auth::user()->can('read', Vendor::class)) {
            $vendor = Vendor::where('id', $id)->firstOrFail();

            if($month_filter) {

                $vendor_amounts = $vendor->vendor_amounts()->orderBy('id', 'desc')->get()->filter(function($record) use ($month, $year) {
                    if($record->status == 'outstanding') {
                        $outstanding_date = $record->outstanding_date;
                        $year_exists = $year == Carbon::parse($outstanding_date)->format('Y');
                        $month_exists = $month == Carbon::parse($outstanding_date)->format('m');
                        return $year_exists && $month_exists;
                    } elseif($record->status == 'earned') {
                        $earned_date = $record->earned_date;
                        $year_exists = $year == Carbon::parse($earned_date)->format('Y');
                        $month_exists = $month == Carbon::parse($earned_date)->format('m');
                        return $year_exists && $month_exists;
                    } elseif($record->status == 'cancelled') {
                        $cancel_date = $record->cancel_date;
                        $year_exists = $year == Carbon::parse($cancel_date)->format('Y');
                        $month_exists = $month == Carbon::parse($cancel_date)->format('m');
                        return $year_exists && $month_exists;
                    } elseif($record->status == 'paid') {
                        $payment_date = $record->payment_date;
                        $year_exists = $year == Carbon::parse($payment_date)->format('Y');
                        $month_exists = $month == Carbon::parse($payment_date)->format('m');
                        return $year_exists && $month_exists;
                    }
                })->paginate(10);
                $vendor_payments = $vendor->vendor_payments()->whereYear('created_at', $year)->whereMonth('created_at', $month)->orderBy('id', 'desc')->paginate(10, ['*'], 'tx_page');

                $outstanding_amount = $vendor->vendor_amounts()->where('status', 'outstanding')->whereYear('outstanding_date', $year)->whereMonth('outstanding_date', $month)->sum('vendor_amount');
                $amount_earned = $vendor->vendor_amounts()->where('status', 'earned')->whereYear('earned_date', $year)->whereMonth('earned_date', $month)->sum('vendor_amount');
                $amount_earned_ids = array();
                if($amount_earned > 0) {
                    $amount_earned_ids = $vendor->vendor_amounts()->select('id')->where('status', 'earned')->whereYear('earned_date', $year)->whereMonth('earned_date', $month)->pluck('id')->toArray();
                }
                $amount_earned_ids_string = serialize($amount_earned_ids);
                $amount_paid = $vendor->vendor_amounts()->where('status', 'paid')->whereYear('payment_date', $year)->whereMonth('payment_date', $month)->sum('vendor_amount');

            } else {

                $vendor_amounts = $vendor->vendor_amounts()->orderBy('id', 'desc')->paginate(10);
                $vendor_payments = $vendor->vendor_payments()->orderBy('id', 'desc')->paginate(10, ['*'], 'tx_page');

                $outstanding_amount = $vendor->vendor_amounts()->where('status', 'outstanding')->sum('vendor_amount');
                $amount_earned = $vendor->vendor_amounts()->where('status', 'earned')->sum('vendor_amount');
                $amount_earned_ids = array();
                if($amount_earned > 0) {
                    $amount_earned_ids = $vendor->vendor_amounts()->select('id')->where('status', 'earned')->pluck('id')->toArray();
                }
                $amount_earned_ids_string = serialize($amount_earned_ids);
                $amount_paid = $vendor->vendor_amounts()->where('status', 'paid')->sum('vendor_amount');
            }

            $payment_paypal = $vendor->vendor_settings()->where('key', 'payment_paypal')->first();
            $payment_bank_transfer = $vendor->vendor_settings()->where('key', 'payment_bank_transfer')->first();

            if($payment_paypal) {
                $payment_paypal = unserialize($payment_paypal->value);
            } else {
                $payment_paypal = array();
            }

            if($payment_bank_transfer) {
                $payment_bank_transfer = unserialize($payment_bank_transfer->value);
            } else {
                $payment_bank_transfer = array();
            }

            $vendor_request = $vendor->vendor_requests()->with('vendor')->where('is_processed', 0)->orderBy('id', 'desc')->first();

            return view('manage.vendors.show', compact('vendor', 'vendor_amounts', 'outstanding_amount', 'amount_earned', 'amount_paid', 'amount_earned_ids', 'amount_earned_ids_string', 'vendor_payments', 'payment_paypal', 'payment_bank_transfer', 'date_filter', 'vendor_request'));
        } else {
            return view('errors.403');
        }
    }

    public function create()
    {
        if(Auth::user()->can('create', Vendor::class)) {
            return view('manage.vendors.create');
        } else {
            return view('errors.403');
        }
    }

    public function store(VendorsCreateRequest $request)
    {
        if(Auth::user()->can('create', Vendor::class)) {
            $this->validate($request, [
                'email'=>'required|min:5|max:80|email',
                'username'=>'required|min:4|max:50',
                'password'=>'confirmed|required|min:6|max:80',
                'shop_name'=>'required'
            ]);
            if ( empty( $request->existing_user ) || $request->existing_user != 'on' ){
                $this->validate($request, ['username'=>'unique:users']);
            }else{
                $user_exists = User::where('username', $request->username)->first();

                if( !$user_exists  ) {
                    return redirect()->back()->withErrors(__('User with this username does not exists.'))->withInput($request->input());
                }
            }

            $vendorInput = array();
            $vendorInput["shop_name"] = $request->shop_name;
            $vendorInput["name"] = $request->company_name;
            $vendorInput["phone"] = $request->phone;
            $vendorInput["address"] = $request->address;
            $vendorInput["city"] = $request->city;
            $vendorInput["state"] = $request->state;
            $vendorInput["description"] = $request->description;
            $vendorInput["amount_percentage"] = $request->amount_percentage_per_sale;

            $userInput = array();
            $userInput["name"] = $request->name;
            $userInput["email"] = $request->email;
            $userInput["username"] = $request->username;
            $userInput['password'] = bcrypt($request->password);
            $userInput['location_id'] = Auth::user()->location_id;
            $userInput['verified'] = 1;

            if($request->profile_status == 1) {
                $vendorInput['profile_completed'] = $request->profile_status;
            } else {
                $vendorInput['profile_completed'] = 0;
            }

            if($request->account_status == 1) {
                $vendorInput['approved'] = $request->account_status;
            } else {
                $vendorInput['approved'] = 0;
            }

            if($request->status == 1) {
                $userInput['is_active'] = $request->status;
            } else {
                $userInput['is_active'] = 0;
            }

            try {
                DB::beginTransaction();

                if ( !empty( $request->existing_user ) && $request->existing_user == 'on' ){
                   $user = User::where('username',$request->username)->first();
               }else{
                   $user_exists = User::where('email', $userInput["email"])->first();
                   if($user_exists) {
                       return redirect()->back()->withErrors(__('User with this email already exists.'))->withInput($request->input());
                   }
                   $user = User::create($userInput);
               }
                $vendor = $user->vendor()->create($vendorInput);

                DB::commit();
                session()->flash('vendor_created', __("New vendor has been added."));
                return redirect(route('manage.vendors.index'));
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

    public function edit($id)
    {
        if(Auth::user()->can('update', Vendor::class)) {
            $vendor = Vendor::where('id', $id)->firstOrFail();
            return view('manage.vendors.edit', compact('vendor'));
        } else {
            return view('errors.403');
        }
    }

    public function update(VendorsCreateRequest $request, $id)
    {
        if(Auth::user()->can('update', Vendor::class)) {
            $vendor = Vendor::findOrFail($id);
            $user = $vendor->user;

            $this->validate($request, [
                'email'=>'required|min:5|max:80|email|unique:users,email,'.$user->id,
                'username'=>'required|min:4|max:50|unique:users,username,'.$user->id,
                'password'=>'confirmed|nullable|min:6|max:80',
                'shop_name'=>'required',
                'shop_slug'=>'required|unique:vendors,slug,'.$vendor->id,
            ]);

            $vendorInput = array();
            $vendorInput["name"] = $request->company_name;
            $vendorInput["shop_name"] = $request->shop_name;
            $vendorInput["slug"] = $request->shop_slug;
            $vendorInput["phone"] = $request->phone;
            $vendorInput["address"] = $request->address;
            $vendorInput["city"] = $request->city;
            $vendorInput["state"] = $request->state;
            $vendorInput["description"] = $request->description;
            $vendorInput["amount_percentage"] = $request->amount_percentage_per_sale;

            $userInput = array();
            $userInput["name"] = $request->name;
            $userInput["email"] = $request->email;
            $userInput["username"] = $request->username;
            if($request->password) {
                $userInput['password'] = bcrypt($request->password);
            }
            $userInput['location_id'] = Auth::user()->location_id;
            $userInput['verified'] = $request->verified ? 1 : 0;

            if($request->profile_status == 1) {
                $vendorInput['profile_completed'] = $request->profile_status;
            } else {
                $vendorInput['profile_completed'] = 0;
            }

            if($request->account_status == 1) {
                $vendorInput['approved'] = $request->account_status;
            } else {
                $vendorInput['approved'] = 0;
            }

            if($request->status == 1) {
                $userInput['is_active'] = $request->status;
            } else {
                $userInput['is_active'] = 0;
            }

            try {
                DB::beginTransaction();

                $user_exists = User::where('email', $userInput["email"])->where('id', '!=', $user->id)->first();
                if($user_exists) {
                    return redirect()->back()->withErrors(__('User with this email already exists.'))->withInput($request->input());
                }

                $user->update($userInput);
                $vendor->update($vendorInput);

                if(!$user->is_active) {
                    $vendor->products()->update([
                        'is_active' => 0
                    ]);
                } else {
                    $vendor->products()->update([
                        'is_active' => 1
                    ]);
                }

                DB::commit();
                session()->flash('vendor_updated', __("The vendor has been updated."));
                return redirect(route('manage.vendors.edit', $vendor->id));
            } catch (\Exception $exception) {
                DB::rollBack();
                session()->flash('vendor_not_updated', __("Unexpected error occured. Please try again after some time."));
                return redirect()->back();
            }

        } else {
            return view('errors.403');
        }
    }

    public function destroy($id)
    {
        if(Auth::user()->can('delete', Vendor::class)) {
            $vendor = Vendor::findOrFail($id);
            $vendor->products()->update([
                'is_active' => 0
            ]);
            $vendor->delete();
            session()->flash('vendor_deleted', __("The vendor has been deleted."));
            return redirect(route('manage.vendors.index'));
        } else {
            return view('errors.403');
        }
    }

    public function deleteVendors(Request $request)
    {
        if(Auth::user()->can('delete', Vendor::class)) {
            if(isset($request->delete_single)) {
                $vendor = Vendor::findOrFail($request->delete_single);
                $vendor->products()->update([
                    'is_active' => 0
                ]);
                $vendor->delete();
                session()->flash('vendor_deleted', __("The vendor has been deleted."));
            } else {
                if(isset($request->delete_all) && !empty($request->checkboxArray)) {
                    $vendors = Vendor::findOrFail($request->checkboxArray);
                    foreach($vendors as $vendor) {
                        $vendor->products()->update([
                            'is_active' => 0
                        ]);
                        $vendor->delete();
                    }
                    session()->flash('vendor_deleted', __("The selected vendors have been deleted."));
                } else {
                    session()->flash('vendor_not_deleted', __("Please select vendors to be deleted."));
                }
            }
            return redirect(route('manage.vendors.index'));
        } else {
            return view('errors.403');
        }
    }

    public function vendorPayment(Request $request)
    {
        $vendor = Vendor::where('id', $request->vendor)->firstOrFail();
        $vendor_payment_ids = unserialize($request->payment_ids);
        $payment_method = $request->payment_method;

        $month_filter = false;
        $date_filter = null;
        if($month_year = request()->month) {
            $month_year = explode('-', $month_year);
            $month = $month_year[0];
            $year  = $month_year[1];
            $month_filter = true;
            $date_filter = Carbon::createFromDate($year, $month, 1);
        }

        if($date_filter) {
            $amount_earned = $vendor->vendor_amounts()->where('status', 'earned')->whereYear('earned_date', $year)->whereMonth('earned_date', $month)->sum('vendor_amount');
            $amount_earned_ids = array();
            if($amount_earned > 0) {
                $amount_earned_ids = $vendor->vendor_amounts()->select('id')->where('status', 'earned')->whereYear('earned_date', $year)->whereMonth('earned_date', $month)->pluck('id')->toArray();
            }
        } else {
            $amount_earned = $vendor->vendor_amounts()->where('status', 'earned')->sum('vendor_amount');
            $amount_earned_ids = array();
            if($amount_earned > 0) {
                $amount_earned_ids = $vendor->vendor_amounts()->select('id')->where('status', 'earned')->pluck('id')->toArray();
            }
        }

        if(array_intersect($vendor_payment_ids, $amount_earned_ids) == $vendor_payment_ids) {
            if($payment_method == 'paypal') {
                if(config('currency.default') == 'USD') {
                    $amount_earned = round($amount_earned, 2);
                } else {
                    $amount_earned = round($this->convertCurrency($amount_earned, config('currency.default'), "USD"), 2);
                }
                $payment_paypal = $vendor->vendor_settings()->where('key', 'payment_paypal')->first();

                if($payment_paypal) {
                    $payment_paypal = unserialize($payment_paypal->value);
                } else {
                    $payment_paypal = array();
                }
                return view('manage.vendors.payments.paypal', compact('vendor', 'vendor_payment_ids', 'amount_earned', 'payment_paypal'));
            }
        } else {
            session()->flash('payment_error', __("The payment was invalid."));
            return redirect()->back();
        }
        session()->flash('payment_error', __("The payment was invalid."));
        return redirect()->back();
    }

    public function updatePaymentStatus(Request $request) {
        if(Auth::user()->can('update', Vendor::class)) {
            $this->validate($request, [
                'amount'=>'required',
                'payment_ids'=>'required',
                'payment_method'=>'required|in:Paypal,"Bank Transfer"',
                'transaction_id'=>'required'
            ]);

            $vendor = Vendor::where('id', $request->vendor)->firstOrFail();

            $vendor_payment_ids = unserialize($request->payment_ids);
            $amount_earned = $vendor->vendor_amounts()->where('status', 'earned')->sum('vendor_amount');
            $amount_earned_ids = array();
            if($amount_earned > 0) {
                $amount_earned_ids = $vendor->vendor_amounts()->select('id')->where('status', 'earned')->pluck('id')->toArray();
            }

            $amount_earned_total = $vendor->vendor_amounts()->whereIn('id', $vendor_payment_ids)->where('status', 'earned')->sum('vendor_amount');
            if($request->amount != $amount_earned_total) {
                return redirect()->back()->withErrors(__('Amount mismatched. Please try again.'))->withInput($request->input());
            }

            if(array_intersect($vendor_payment_ids, $amount_earned_ids) == $vendor_payment_ids) {
                try {
                    DB::beginTransaction();

                    $vendor_payment = $vendor->vendor_payments()->where('payment_method', $request->payment_method)->where('payment_id', $request->transaction_id)->first();

                    if($vendor_payment) {
                        throw new \Exception(__('Transaction ID already exists.'));
                    }

                    $vendor_payment = $vendor->vendor_payments()->create([
                        'payment_method' => $request->payment_method,
                        'payment_id' => $request->transaction_id,
                        'payment_status' => 'paid',
                        'currency' => config('currency.default'),
                        'amount' => $request->amount
                    ]);

                    if($vendor_payment) {
                        VendorAmount::whereIn('id', $vendor_payment_ids)->where('status', 'earned')
                                    ->update(array(
                                        'status' => 'paid',
                                        'processed' => 1,
                                        'vendor_payment_id' => $vendor_payment->id,
                                        'payment_date' => Carbon::now()
                                    ));
                    } else {
                        throw new \Exception(__('Unable to update payment status.'));
                    }

                    $vendor->vendor_requests()->where('is_processed', 0)->update([
                        'is_processed' => 1,
                        'processed_date' => Carbon::now()
                    ]);

                    DB::commit();
                    session()->flash('payment_success', __("Payment status updated successfully."));
                    return redirect()->back();

                } catch (\Exception $exception) {
                    DB::rollBack();
                    return redirect()->back()->withErrors($exception->getMessage())->withInput($request->input());
                }
            } else {
                return redirect()->back()->withErrors(__('The payment was invalid.'))->withInput($request->input());
            }
        } else {
            return view('errors.403');
        }
    }

    public function vendorPaymentPaypalReturn(Request $request)
    {
        $vendor = Vendor::findOrFail($request->id);
        session()->flash('payment_success', __('Please update the payment status with transaction ID generated in your Paypal account.'));
        return redirect()->route('manage.vendors.show', ['id' => $vendor->id]);
    }

    public function vendorPaymentPaypalCancel(Request $request)
    {
        session()->flash('payment_error', __('Payment has been cancelled.'));
        return redirect()->back();
    }

    public function submitPayoutRequest(Request $request)
    {
        $user = Auth::user();
        if($vendor = $user->isApprovedVendor()) {

            $amount_earned = $vendor->vendor_amounts()->where('status', 'earned')->sum('vendor_amount');

            $minimum_amount_for_request = config('vendor.minimum_amount_for_request');

            $allow_payout_request = ($amount_earned >= config('vendor.minimum_amount_for_request') );

            $has_pending_request = $vendor->vendor_requests()->where('is_processed', 0)->count();

            if($has_pending_request) {
                return redirect()->back()->withErrors(['error' => __('You already submitted a payout request.')]);
            }

            if(!$allow_payout_request) {
                return redirect()->back()->withErrors(['error' => 'Minimum amount :amount is required before you can request for payout.']);
            }

            $vendor->vendor_requests()->create([
              'message' => $request->message
            ]);

            session()->flash('success', __('Your request for payout has been submitted.'));

            return redirect()->back();
        } else {
            return view('errors.403');
        }
    }

    public function updatePaymentSettings(Request $request)
    {
        $user = Auth::user();
        if($vendor = $user->isApprovedVendor()) {

            $this->validate($request, [
                'paypal_email'=>'required_with:paypal|email|max:191',
                'ifsc_code'=>'required_with:bank_transfer|max:191',
                'account_number'=>'required_with:bank_transfer|max:191',
                'name'=>'required_with:bank_transfer|max:191'
            ]);

            if($request->payment_method == 'paypal') {
                $payment_paypal = $vendor->vendor_settings()->where('key', 'payment_paypal')->first();
                $paypal_data = serialize(
                    array(
                        'enable' => $request->paypal ? true : false,
                        'email' => $request->paypal_email
                    )
                );

                if($payment_paypal) {
                    $payment_paypal->value = $paypal_data;
                    $payment_paypal->save();
                } else {
                    $payment_paypal = $vendor->vendor_settings()->create([
                        'key' => 'payment_paypal',
                        'value' => $paypal_data
                    ]);
                }
            } elseif($request->payment_method == 'bank_transfer') {
                $payment_bank_transfer = $vendor->vendor_settings()->where('key', 'payment_bank_transfer')->first();
                $bank_transfer_data = serialize(
                    array(
                        'enable' => $request->bank_transfer ? true : false,
                        'ifsc_code' => $request->ifsc_code,
                        'account_number' => $request->account_number,
                        'name' => $request->name
                    )
                );

                if($payment_bank_transfer) {
                    $payment_bank_transfer->value = $bank_transfer_data;
                    $payment_bank_transfer->save();
                } else {
                    $payment_bank_transfer = $vendor->vendor_settings()->create([
                        'key' => 'payment_bank_transfer',
                        'value' => $bank_transfer_data
                    ]);
                }
            }

            session()->flash('payments_updated', __('Payment methods updated successfully.'));
            return redirect()->back();
        } else {
            return view('errors.403');
        }
    }
}
