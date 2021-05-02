<div class="price-box">
    @php $var_amount = $hide = 0; @endphp
    @if(is_array($variants) && count($variants))
        @php $hide = 1; @endphp
        @foreach($variants as $key => $variant)
            @foreach($variant['v'] as $variant_key => $value)
                @php
                    $var_amount += $value['p'];
                    break;
                @endphp
            @endforeach
        @endforeach
    @endif
    @if($product->price_with_discount() < $product->price)
        <span class="price" id="single_prod_price">{{currency_format($product->price_with_discount() + $var_amount)}}</span>
        <span class="price-strike">{{currency_format($product->price)}}</span>

    @else
        @if($product->old_price && ($product->price < $product->old_price))
            <span class="price" id="single_prod_price">{{currency_format($product->price + $var_amount)}}</span>
            @if($hide == 0)
                <span class="price-strike">{{currency_format($product->old_price)}}</span>
            @endif
        @else
            <span class="price" id="single_prod_price">{{currency_format($product->price + $var_amount)}}</span>
        @endif
    @endif
</div>