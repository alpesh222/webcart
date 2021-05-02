@if(isset($payment_page) && $payment_page)
    @php $payment_page = true; @endphp
@else
    @php $payment_page = false; @endphp
@endif
<thead>
    <tr>
        <th class="cart-sub-total">
            @lang('Products')
        </th>
        <th class="cart-sub-total">
            <span class="inner-left-md">{{Cart::count()}}</span>
        </th>
    </tr>
    <tr>
        <th class="cart-sub-total">
            @lang('Sub Total')
        </th>
        <th class="cart-sub-total">
            <span class="inner-left-md">{{currency_format(Cart::total())}}</span>
        </th>
    </tr>
    <tr>
        <th class="cart-sub-total">
            @lang('Tax')
        </th>
        <th class="cart-sub-total">
            <span class="inner-left-md">+ {{config('settings.tax_rate')}} %</span>
        </th>
    </tr>
    <tr>
        <th class="cart-sub-total">
            @lang('Shipping Cost')
        </th>
        <th class="cart-sub-total">
            <span class="inner-left-md">
                @if(config('settings.shipping_cost_valid_below') > Cart::total())
                    {{currency_format(config('settings.shipping_cost'))}}
                @else
                    {{currency_format(0)}}
                @endif
            </span>
        </th>
    </tr>
    @if($payment_page)
        @php $cal_wallet_amount = 0; @endphp

        @if(config('wallet.enable'))
            <tr>
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


                <th class="cart-sub-total">
                    <?= $checkbox ?>@lang('Wallet Used')<br>
                    <small> ( @lang($wallet_text)  {{currency_format($left_wallet_bal,config('currency.default'))}} )</small>
                </th>
                <th class="cart-sub-total">
                    <span class="inner-left-md">
                        - {{ currency_format($cal_wallet_amount,config('currency.default'))}}
                    </span>
                </th>
            </tr>
        @endif

        @if(session()->has('coupon_amount') && session()->has('coupon_valid_above_amount') && session('coupon_valid_above_amount') < Cart::total())
            <tr>
                <th class="cart-sub-total">
                    @lang('Coupon Amount')
                </th>
                <th class="cart-sub-total">
                    <span class="inner-left-md">
                        - {{currency_format(session('coupon_amount'))}}
                    </span>
                </th>
            </tr>
        @endif

        <tr>
            <th class="cart-grand-total">
                @lang('Total')
            </th>
            <th class="cart-grand-total">
                <span class="inner-left-md">
                    @if(config('settings.shipping_cost_valid_below') > Cart::total() && session()->has('coupon_amount') && session()->has('coupon_valid_above_amount') && session('coupon_valid_above_amount') < Cart::total())
                        {{currency_format( config('settings.shipping_cost') - $cal_wallet_amount + Cart::total() - session('coupon_amount') + (Cart::total() * config('settings.tax_rate')) / 100)}}
                    @elseif(session()->has('coupon_amount') && session()->has('coupon_valid_above_amount') && session('coupon_valid_above_amount') < Cart::total())
                        {{currency_format( Cart::total() - session('coupon_amount')  - $cal_wallet_amount + (Cart::total() * config('settings.tax_rate')) / 100)}}
                    @elseif(config('settings.shipping_cost_valid_below') > Cart::total())
                        {{currency_format(config('settings.shipping_cost') + Cart::total() - $cal_wallet_amount + (Cart::total() * config('settings.tax_rate')) / 100)}}
                    @else
                        {{currency_format(Cart::total() - $cal_wallet_amount + (Cart::total() * config('settings.tax_rate')) / 100)}}
                    @endif
                </span>
            </th>
        </tr>
    @else
        <tr>
            <th class="cart-grand-total">
                @lang('Grand Total')
            </th>
            <th class="cart-grand-total">
                <span class="inner-left-md">
                    @if(config('settings.shipping_cost_valid_below') > Cart::total())
                        {{currency_format(config('settings.shipping_cost') + Cart::total() + (Cart::total() * config('settings.tax_rate')) / 100)}}
                    @else
                        {{currency_format(Cart::total() + (Cart::total() * config('settings.tax_rate')) / 100)}}
                    @endif
                </span>
            </th>
        </tr>
    @endif
</thead><!-- /thead -->