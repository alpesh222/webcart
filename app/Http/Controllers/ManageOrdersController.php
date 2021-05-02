<?php

namespace App\Http\Controllers;

use App\Mail\OrderProcessed;
use Illuminate\Support\Facades\Mail;
use App\Product;
use App\Order;
use App\Other;
use App\Shipment;
use App\VendorAmount;
use Illuminate\Http\Request;
use App\Http\Requests\OrdersCreateRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Events\Order\OrderProcessedEvent;

class ManageOrdersController extends Controller
{
    public function index()
    {
        if(Auth::user()->can('read', Order::class) || Auth::user()->cannot('update', Order::class)) {
            $vendor = Auth::user()->isApprovedVendor();
            if ($vendor){
                $vendor_id = $vendor->id;
                $orders = Order::where('location_id', Auth::user()->location_id);
                $orders->whereHas('products', function($query) use ($vendor_id) {
                    $query->where('vendor_id', $vendor_id);
                });
            }else{
                $orders = Order::where('location_id', Auth::user()->location_id);
            }

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

            return view('manage.orders.index', compact('orders'));
        } else {
            return view('errors.403');
        }
    }

    public function invoices()
    {
        if(Auth::user()->can('read', Order::class)) {
            $orders = Order::where('location_id', Auth::user()->location_id)->where('is_processed', true);

            if(!empty(request()->s)) {
                $search = request()->s;
                $orders = $orders->where('id', (int)$search - 10000)
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

            /* Ordering */
            $orders = $orders->orderBy('id', 'desc');

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

            return view('manage.orders.invoices', compact('orders'));
        } else {
            return view('errors.403');
        }
    }

    public function pending()
    {
        if(Auth::user()->can('read', Order::class)) {
            $orders = Order::where('location_id', Auth::user()->location_id)->where('is_processed', false)->where('stock_regained', '!=', 1)->where(function($query) {
                return $query->where('payment_method', '!=', 'Cash on Delivery')
                            ->where('payment_method', '!=', 'Bank Transfer')
                            ->where('paid', '!=', 0)
                            ->orWhere('payment_method', 'Cash on Delivery')
                            ->orWhere('payment_method', 'Bank Transfer');
            });
            $vendor = Auth::user()->isApprovedVendor();
            if ($vendor){
                $vendor_id = $vendor->id;
                $orders->whereHas('products', function($query) use ($vendor_id) {
                    $query->where('vendor_id', $vendor_id);
                });
            }
            if(!empty(request()->s)) {
                $search = request()->s;
                $orders = $orders->where('id', (int)$search - 10000)
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

            /* Ordering */
            $orders = $orders->orderBy('id', 'desc');

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

            return view('manage.orders.pending', compact('orders'));
        } else {
            return view('errors.403');
        }
    }

    public function show($id)
    {
        if(Auth::user()->can('read', Order::class) || Auth::user()->can('manage-shipment-orders', Other::class)) {
            $order = Order::where('location_id', Auth::user()->location_id)->where('id', $id)->firstOrFail();

            if(Auth::user()->can('manage-shipment-orders', Other::class) && Auth::user()->cannot('update', Order::class)) {
                if((count($order->shipments) < 1) || !in_array($order->shipments()->orderBy('id', 'desc')->first()->id, Auth::user()->shipments->pluck('id')->toArray())) {
                    // Redirect after passing shipment
                    return view('errors.404');
                }
            }

            return view('manage.orders.invoice', compact('order'));
        } else {
            return view('errors.403');
        }
    }

    public function edit($id)
    {
        if(Auth::user()->can('update', Order::class) || Auth::user()->can('manage-shipment-orders', Other::class)) {
            $order = Order::where('location_id', Auth::user()->location_id)->where('stock_regained', '!=', 1)->where(function($query) {
                        return $query->where('payment_method', '!=', 'Cash on Delivery')
                                     ->where('payment_method', '!=', 'Bank Transfer')
                                     ->where('paid', '!=', 0)
                                     ->orWhere('payment_method', 'Cash on Delivery')
                                     ->orWhere('payment_method', 'Bank Transfer');
                    })->where('id', $id)->firstOrFail();

            if(Auth::user()->can('manage-shipment-orders', Other::class) && Auth::user()->cannot('update', Order::class)) {
                if((count($order->shipments) < 1) || !in_array($order->shipments()->orderBy('id', 'desc')->first()->id, Auth::user()->shipments->pluck('id')->toArray())) {
                    // Redirect after passing shipment
                    return redirect(route('manage.index'));
                }
            }

            if($order->is_processed == 1) {
                return view('errors.404');
            }

            $shipments = Shipment::all();
            return view('manage.orders.edit', compact('order', 'shipments'));
        } else {
            return view('errors.403');
        }
    }

    public function update(OrdersCreateRequest $request, $id)
    {
        if(Auth::user()->can('update', Order::class) || Auth::user()->can('manage-shipment-orders', Other::class)) {
            $order = Order::where(function($query) {
                return $query->where('payment_method', '!=', 'Cash on Delivery')
                             ->where('payment_method', '!=', 'Bank Transfer')
                             ->where('paid', '!=', 0)
                             ->orWhere('payment_method', 'Cash on Delivery')
                             ->orWhere('payment_method', 'Bank Transfer');
            })->where('stock_regained', '!=', 1)->findOrFail($id);

            if($order->payment_method == 'Bank Transfer') {
                if($request->is_paid || $request->is_processed) {
                    if(!$order->paid) {
                        $order->paid = 1;
                        $order->payment_date = Carbon::now();
                        $order->save();
                        $order->createVendorPayments();
                    }
                }
            }

            if(count($order->shipments) > 0) {
                if((count(Auth::user()->shipments) < 1) || Auth::user()->can('update', Order::class) && !in_array($order->shipments()->orderBy('id', 'desc')->first()->id, Auth::user()->shipments->pluck('id')->toArray())) {
                    session()->flash('order_not_updated', __("You are not allowed to deliver or pass this order to next shipment."));
                    return redirect()->back();
                }
            }

            if(Auth::user()->can('manage-shipment-orders', Other::class) && Auth::user()->cannot('update', Order::class)) {
                if((count($order->shipments) < 1) || !in_array($order->shipments()->orderBy('id', 'desc')->first()->id, Auth::user()->shipments->pluck('id')->toArray())) {
                    // Redirect to 404 if no permission to update order or manage shipment orders
                    return view('errors.404');
                }
            }

            $input['is_processed'] = $request->is_processed ? 1 : 0;
            if($input['is_processed'] == 1) {
                if($order->is_processed != 1) {
                    $input['receiver_detail'] = $request->receiver_detail ? $request->receiver_detail : '';
                    $input['processed_date'] = Carbon::now();
                    if($order->payment_method == 'Cash on Delivery') {
                        $input['payment_date'] = $input['processed_date'];
                        $input['paid'] = 1;
                    }
                    if($order->stock_regained) {
                        $is_stock_available = Product::isStockAvailable($order->products);
                        if(!$is_stock_available) {
                            session()->flash('order_not_updated', __("Not enough stock to process this order."));
                            return redirect()->back();
                        }
                        foreach($order->products as $product) {
                            $product->decreaseStock($product->pivot->quantity, $order->id);
                        }
                    }
                }
            } elseif($request->regain_stock) {
                if($order->is_processed != 1) {
                    $input['stock_regained'] = 1;
                    foreach($order->products as $product) {
                        $product->increaseStock($product->pivot->quantity, $order->id);
                        if($product->vendor) {
                            $vendor_amount = VendorAmount::where('order_id', $order->id)->where('product_id', $product->id)->where('vendor_id', $product->vendor->id)->where('processed', 0)->first();
                            $vendor_amount->status = 'cancelled';
                            $vendor_amount->cancel_date = Carbon::now();
                            $vendor_amount->save();
                        }
                    }
                }
            }
            $input['status'] = $request->status;
            $order->update($input);

            if(!empty($order->processed_date) && !empty($order->payment_date) && $input['is_processed'] == 1) {
                foreach($order->products as $product) {
                    if($product->vendor) {
                        $vendor_amount = VendorAmount::where('order_id', $order->id)->where('product_id', $product->id)->where('vendor_id', $product->vendor->id)->where('processed', 0)->first();
                        $vendor_amount->status = 'earned';
                        $vendor_amount->earned_date = Carbon::now();
                        $vendor_amount->save();
                    }
                }
                // Send Email for Order Processed
                try {
                    Mail::to($order->user->email)->send(new OrderProcessed($order));
                } catch (\Exception $e) {}

                // Order Processed Event
                event(new OrderProcessedEvent($order));

                if($order->is_processed == 1) {
                    session()->flash('order_passed_to_shipment', __('The order #:order_id has been delivered.', ['order_id'=>$order->getOrderId()]));
                    return redirect(route('manage.orders.index'));
                }
            } elseif($order->stock_regained) {
                session()->flash('order_passed_to_shipment', __('The order #:order_id has been updated.', ['order_id'=>$order->getOrderId()]));
                return redirect(route('manage.orders.index'));
            }

            session()->flash('order_updated', __("The order has been updated."));
            if($input['is_processed'] != 1) {

                if($request->shipment) {
                    $shipments = Shipment::pluck('name','id')->toArray();
                    if(array_key_exists($request->shipment, $shipments)) {
                        if(!$order->shipments()->wherePivot('user_id', Auth::user()->id)->get()->contains($request->shipment)) {
                            $order->shipments()->attach($request->shipment, ['user_id' => Auth::user()->id]);
                            if(Auth::user()->can('manage-shipment-orders', Other::class) && Auth::user()->cannot('update', Order::class)) {
                                $shipment = Shipment::find($request->shipment);
                                session()->flash('order_passed_to_shipment', 'The order #' .$order->getOrderId(). ' has been passed to shipment location: ' .$shipment->name. ' @ ' .$shipment->address. ', ' .$shipment->city. ', ' .$shipment->state. ' - ' .$shipment->zip. ' ' .$shipment->country);
                                // Redirect after passing shipment
                                return redirect(route('manage.index'));
                            }
                        }
                    }
                }

                return redirect()->back();
            }
            return redirect(route('manage.orders.index'));
        } else {
            return view('errors.403');
        }
    }

    public function destroy($id)
    {
        if(Auth::user()->can('delete', Order::class)) {
            $order = Order::findOrFail($id);
            if($order->is_processed || !($order->stock_regained || ($order->payment_method != 'Cash on Delivery' && $order->paid == 0))) {
                foreach($order->products as $product) {
                    $product->sales = $product->sales - $product->pivot->quantity;
                    $product->save();
                }
            }
            $order->products()->detach();
            $order->shipments()->detach();
            $order->vendor_amounts()->where('processed', 0)->delete();
            $order->delete();
            session()->flash('order_deleted', "The order has been deleted.");
            return redirect(route('manage.orders.index'));
        } else {
            return view('errors.403');
        }
    }

    public function deleteOrders(Request $request)
    {
        if(Auth::user()->can('delete', Order::class)) {
            if(isset($request->delete_single)) {
                $order = Order::findOrFail($request->delete_single);
                if($order->is_processed || !($order->stock_regained || ($order->payment_method != 'Cash on Delivery' && $order->paid == 0))) {
                    foreach($order->products as $product) {
                        $product->sales = $product->sales - $product->pivot->quantity;
                        $product->save();
                    }
                }
                $order->products()->detach();
                $order->shipments()->detach();
                $order->vendor_amounts()->where('processed', 0)->delete();
                $order->delete();
                session()->flash('order_deleted', "The order has been deleted.");
            } else {
                if(isset($request->delete_all) && !empty($request->checkboxArray)) {
                    $orders = Order::findOrFail($request->checkboxArray);
                    foreach($orders as $order) {
                        if($order->is_processed || !($order->stock_regained || ($order->payment_method != 'Cash on Delivery' && $order->paid == 0))) {
                            foreach($order->products as $product) {
                                $product->sales = $product->sales - $product->pivot->quantity;
                                $product->save();
                            }
                        }
                        $order->products()->detach();
                        $order->shipments()->detach();
                        $order->vendor_amounts()->where('processed', 0)->delete();
                        $order->delete();
                    }
                    session()->flash('order_deleted', __("The selected orders have been deleted."));
                } else {
                    session()->flash('order_not_deleted', __("Please select orders to be deleted."));
                }
            }
            return redirect(route('manage.orders.index'));
        } else {
            return view('errors.403');
        }
    }
}
