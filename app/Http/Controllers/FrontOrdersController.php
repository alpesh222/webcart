<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontOrdersController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        $orders = Order::where('user_id', $user_id)->where('hide', false)->orderBy('id', 'desc')->paginate(15);
        return view('front.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::where('is_processed', 1)->where('hide', false)->findOrFail($id);

        if(Auth::user()->can('view', $order)) {
            return view('front.orders.invoice', compact('order'));
        } else {
            return view('errors.403');
        }
    }

    public function hide($id)
    {
        $user_id = Auth::user()->id;
        $order = Order::where('user_id', $user_id)->where('hide', false)->where(function($query) {
            return $query->where('payment_method', '!=', 'Cash on Delivery')->where('paid', '==', 0);
            })->findOrFail($id);
        $order->hide = true;
        $order->save();
        return redirect()->back();
    }

    public function download(Request $request)
    {
        $filename = $request->filename;
        $orderId = $request->order_id;

        $file = \App\File::where('filename', $filename)->first();

        $order = Order::where('id', $orderId)->where('user_id', Auth::user()->id)->where('paid', 1)->first();

        if(!$order) {
            return view('errors.403');
        }

        $product = $order->products()->where('file_id', $file->id)->first();

        if(!$product) {
            return view('errors.403');
        }

        try {
            $pathToFile = storage_path('app/' . $file->filename);
            $headers = array(
                'Content-Type' => 'application/pdf',
            );
            return response()->download($pathToFile, $file->original_filename, $headers);
        } catch (\Exception $e) {
            return view('errors.404');
        }
    }
}