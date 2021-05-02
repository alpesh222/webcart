{{--<h2 class="circle-icon-header"><span> <i class="fa fa-shopping-cart"></i> @lang('Shopping Cart') </span></h2>--}}

<div class="panel panel-primary">
    <table>
        <thead>
        <tr>
            <th scope="col">@lang('Product')</th>
            <th scope="col">@lang('Unit Price')</th>
            <th scope="col">@lang('Quantity')</th>
            <th scope="col">@lang('Unit Tax (%)')</th>
            <th scope="col">@lang('Total')</th>
        </tr>
        </thead>
        <tbody>
        @foreach($cartItems as $cartItem)
            <tr>
                <td>
                    <a target="_blank" href="{{route('front.product.show', [$cartItem->options->slug])}}" class="thumbnail text-center">
                        @if($cartItem->options->has('photo'))
                            @if($cartItem->options->photo)
                                @php
                                    $image_url = \App\Helpers\Helper::check_image_avatar($cartItem->options->photo, 150);
                                @endphp
                                <div class="img-box">
                                    <img class="product-image" width="150"  src="{{$image_url}}" alt="{{$cartItem->name}}"  />
                                </div>
                            @else
                                <div class="img-box">
                                    <img src="https://via.placeholder.com/150x150?text=No+Image" class="product-image" width="150"  alt="{{$cartItem->name}}" />
                                </div>
                            @endif
                        @endif
                            <h5 class="custom_cart_h5"><strong>{{$cartItem->name}}</strong>
                            @if(is_array($cartItem->options->spec) && count($cartItem->options->spec))
                                <br>
                                @foreach($cartItem->options->spec as $key => $spec)
                                    <b>{{$spec['name']}}:</b> {{$spec['value']}}@if(!$loop->last)<br> @endif
                                @endforeach
                            @endif
                        </h5>
                    </a>
                </td>
                <td data-label="@lang('Unit Price')">{{currency_format($cartItem->options->unit_price)}}</td>
                <td data-label="@lang('Quantity')">
                    {{$cartItem->qty}}
                </td>
                <td data-label="@lang('Unit Tax (%)')">{{$cartItem->options->unit_tax}}</td>
                <td data-label="Total">{{currency_format($cartItem->total)}}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th></th>
            <th class="ftr-cart-row" colspan="2"><span> @lang('Products') </span></th>
            <th class="ftr-cart-row" colspan="2"><span> {{Cart::count()}} </span></th>
        </tr>
        <tr>
            <th></th>
            <th class="ftr-cart-row" colspan="2"><span> @lang('Sub Total') </span></th>
            <th class="ftr-cart-row" colspan="2"><span> {{currency_format(Cart::total())}} </span></th>
        </tr>
        <tr>
            <th></th>
            <th class="ftr-cart-row" colspan="2"><span> @lang('Tax') </span></th>
            <th class="ftr-cart-row" colspan="2"><span> + {{config('settings.tax_rate')}} % </span></th>
        </tr>
        <tr>
            <th></th>
            <th class="ftr-cart-row" colspan="2"><span> @lang('Shipping Cost') </span></th>
            @if(config('settings.shipping_cost_valid_below') > Cart::total())
                <th class="ftr-cart-row" colspan="2"><span>{{currency_format(config('settings.shipping_cost'))}} </span></th>
            @else
                <th class="ftr-cart-row" colspan="2"><span> {{currency_format(0)}} </span></th>
            @endif
        </tr>
        @php $cal_wallet_amount = 0; @endphp
        @if(config('wallet.enable'))
        <tr>
            <th></th>
            @php
                $available_wallet_bal   = Auth::user()->walletBalance();
                $cal_wallet_amount  = $using_wallet_amount    = (Cart::total() * (int)(config('wallet.percent')))/100;
            @endphp
            @if($available_wallet_bal >= $cal_wallet_amount)
                @if(session()->has('wallet_used') && session()->get('wallet_used') == 1)
                    @php
                        $left_wallet_bal        = $available_wallet_bal - $cal_wallet_amount;
                        $wallet_text            = 'Left Wallet balance :';
                        $checked                = 'checked';
                    @endphp
                @else
                    @php
                        $cal_wallet_amount      = 0;
                        $left_wallet_bal        = $available_wallet_bal;
                        $wallet_text            = 'Wallet balance :';
                        $checked                = '';
                    @endphp
                @endif
                @php $checkbox                  = '<input type="checkbox" id="wallet_use" data-id="'.$using_wallet_amount.'" onchange="updateWalletUse()" '.$checked.'/> '; @endphp
            @elseif($available_wallet_bal < $cal_wallet_amount)
                @php
                    $cal_wallet_amount      = 0;
                    $left_wallet_bal        = $available_wallet_bal;
                    $wallet_text            = 'Insufficient balance :';
                    $checked                = '';
                    $checkbox               = '<input type="checkbox" disabled'.$checked.'/> ';
                @endphp
            @endif


            <th class="ftr-cart-row" colspan="2"><span>
                    <?= $checkbox ?>@lang('Wallet Used')<br>
                    <small> ( @lang($wallet_text)  {{currency_format($left_wallet_bal,config('currency.default'))}} )</small></span>
            </th>
            <th class="ftr-cart-row" colspan="2"> <span> - {{ currency_format($cal_wallet_amount,config('currency.default'))}} </span></th>
        </tr>
        @endif
        @if(session()->has('coupon_amount') && session()->has('coupon_valid_above_amount') && session('coupon_valid_above_amount') < Cart::total())
            <tr>
                <th></th>
                <th class="ftr-cart-row" colspan="2"><span> @lang('Coupon Amount') </span></th>
                <th class="ftr-cart-row" colspan="2"><span> - {{currency_format(session('coupon_amount'))}} </span>
                </th>
            </tr>
        @endif
        <tr>
            <th></th>
            <th class="ftr-cart-row" colspan="2"><span> @lang('Total') </span></th>
            @if(config('settings.shipping_cost_valid_below') > Cart::total() && session()->has('coupon_amount') && session()->has('coupon_valid_above_amount') && session('coupon_valid_above_amount') < Cart::total())
                <th class="ftr-cart-row" colspan="2"><span> {{currency_format( config('settings.shipping_cost') - $cal_wallet_amount + Cart::total() - session('coupon_amount') + (Cart::total() * config('settings.tax_rate')) / 100)}} </span></th>
            @elseif(session()->has('coupon_amount') && session()->has('coupon_valid_above_amount') && session('coupon_valid_above_amount') < Cart::total())
                <th class="ftr-cart-row" colspan="2"><span> {{currency_format( Cart::total() - session('coupon_amount')  - $cal_wallet_amount + (Cart::total() * config('settings.tax_rate')) / 100)}} </span></th>
            @elseif(config('settings.shipping_cost_valid_below') > Cart::total())
                <th class="ftr-cart-row" colspan="2"><span> {{currency_format(config('settings.shipping_cost') + Cart::total() - $cal_wallet_amount + (Cart::total() * config('settings.tax_rate')) / 100)}} </span></th>
            @else
                <th class="ftr-cart-row" colspan="2"><span> {{currency_format(Cart::total() - $cal_wallet_amount + (Cart::total() * config('settings.tax_rate')) / 100)}} </span></th>
            @endif
        </tr>
        </tfoot>
    </table>
</div>
