<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class FrontCartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::content();
        return view('front.cart', compact('cartItems'));
    }

    public function ajaxCartData(){
        $cartItems = Cart::content();
        return view('includes.ajax-pages.cart_modal',compact('cartItems'));
//        return response()->json($cartItems);
    }

    public function refreshCartPage(){
        $cartItems = Cart::content();
        return view('partials.front.includes.cart',compact('cartItems'));
    }

    public function add($id, Request $request)
    {
        if(\Illuminate\Support\Facades\Request::ajax()) {
            if(!$request->quantity) {
                $request->quantity = 1;
            }
            $this->validate($request, [
                'quantity' => 'integer|min:1'
            ]);

            $product = Product::findOrFail($id);

            if($product->in_stock < 1) {
                session()->flash('product_not_added', __('This product is out of stock.'));
                session()->forget('product_added');
                return response()->view('partials.front.cart-message', ['cart_count'=>Cart::content()->count()], 200);
            }

            $old_location_id = session('location_id');
            session(['location'=>$product->location->name, 'location_id'=>$product->location_id]);
            if($old_location_id != $product->location_id) {
                Cart::destroy();
            }

            $cartItems = Cart::content();
            $productsInCart = $cartItems->filter(function($cartItem) use($id) {
                return $cartItem->id == $id;
            });
            if($productsInCart->isNotEmpty()) {
                $productInCart = $productsInCart->first();
                if($productInCart->qty >= $productInCart->options->qty_per_order) {
                    session()->flash('product_not_added', __('Maximum quantity allowed for this product exceeded.'));
                    session()->forget('product_added');
                    return response()->view('partials.front.cart-message', ['cart_count'=>Cart::content()->count()], 200);
                }
    			if($request->quantity > 1) {
    				if($request->quantity + $productInCart->qty > $productInCart->options->qty_per_order) {
    					session()->flash('product_not_added', __('Maximum quantity allowed for this product exceeded.'));
                        session()->forget('product_added');
    					return response()->view('partials.front.cart-message', ['cart_count'=>Cart::content()->count()], 200);
    				}
    			}
            } else {
    			if($request->quantity > 1) {
    				if($request->quantity > $product->qty_per_order) {
    					session()->flash('product_not_added', __('Maximum quantity allowed for this product exceeded.'));
                        session()->forget('product_added');
    					return response()->view('partials.front.cart-message', ['cart_count'=>Cart::content()->count()], 200);
    				}
    			}
    		}

            $variants = unserialize($product->variants);
            $price_with_tax_and_discount = $product->price_with_tax_and_discount();
            $price_with_discount = $product->price_with_discount();

            $specArray = [];

            if(is_array($variants) && count($variants)) {

                if(is_array($request->variants) && count($request->variants)) {

                    $price_to_add_array = [];

                    foreach($request->variants as $key => $value) {
                        if(isset($variants[$key]) && isset($variants[$key]['v'][$value])) {
                            $price_to_add = $variants[$key]['v'][$value]['p'];
                            $variant_name_value = [
                                'name' => $variants[$key]['n'],
                                'value' => $variants[$key]['v'][$value]['n'],
                            ];
                            array_push($price_to_add_array, $price_to_add);
                            array_push($specArray, $variant_name_value);
                        }
                    }

                    if(count($price_to_add_array)) {
                        $price_with_tax_and_discount = $product->price_with_tax_and_discount(array_sum($price_to_add_array));
                        $price_with_discount = $product->price_with_discount(array_sum($price_to_add_array));
                    }
                }
            }

            Cart::add($product->id, $product->name, $request->quantity, $price_with_tax_and_discount, ['photo' => $product->photo ? route('imagecache', ['medium', $product->photo->getOriginal('name')]) : '', 'unit_price' => $price_with_discount, 'unit_tax' => $product->tax_rate, 'qty_per_order' => ($product->qty_per_order > $product->in_stock) ? $product->in_stock : $product->qty_per_order, 'slug' => $product->slug, 'spec' => $specArray]);

            session()->flash('product_added', __(':product_name has been added to cart.', ['product_name'=>$product->name]));
            session()->forget('product_not_added');
            $this->clearCoupon();
            return response()->view('partials.front.cart-message', ['cart_count'=>Cart::content()->count(), 'product_added'=>true], 200);
        }
    }

    public function update(Request $request, $id, $quantity)
    {
        $cart = Cart::get($id);
        if($request->submit == 'increase') {
            if($cart->qty >= $cart->options->qty_per_order) {
                session()->flash('product_not_added', __('Maximum quantity allowed for this product exceeded.'));
                return back();
            }            
            Cart::update($id, ++$quantity);
        } elseif($request->submit == 'decrease') {
            Cart::update($id, --$quantity);
        }
        $this->clearCoupon();
        return back();
    }

    public function updateAjax(Request $request, $id, $quantity)
        {
    //        print_r($quantity);exit;
            $cart = Cart::get($id);
            if($request->submit == 'increase') {
                if($cart->qty >= $cart->options->qty_per_order) {
                    session()->flash('product_not_added', __('Maximum quantity allowed for this product exceeded.'));
                    return back();
                }
                Cart::update($id, $cart->qty + $quantity);
            } elseif($request->submit == 'decrease') {
                Cart::update($id, $cart->qty - $quantity);
            }
            $this->clearCoupon();
            return back();
        }

    public function destroy($id)
    {
        $this->clearCoupon();
        Cart::remove($id);
        return back();
    }

    public function emptyCart()
    {
        $this->clearCoupon();
        Cart::destroy();
        return back();
    }

    public function cartCount(){
        $cart_data = array(
            'cart_item_count'  =>  Cart::content()->count(),
            'cart_item_total'  =>  currency_format(Cart::total())
        );
        return json_encode($cart_data);
    }

    private function clearCoupon()
    {
        session()->forget('coupon_amount');
        session()->forget('coupon_valid_above_amount');
        session()->forget('coupon_code');
    }
}
