<div class="col-md-12">
    {!! Form::open(['method'=>'patch', 'route'=>['front.cart.add', $product->id], 'id'=>'cart-form']) !!}

    @if(is_array($variants) && count($variants))
        @foreach($variants as $key => $variant)
            @php $i = 0 @endphp
            <div class="spec-type">
                <span class="label">{{ucfirst($variant['n'])}}</span> :
                @php $class = $opening = $closing = '';  @endphp
                @if(isset($variant['c']) && $variant['c'] == 1)
                    @php
                        $class      = 'color_variant_css';
                        $opening    = "<ul class='color-variation-list'>";
                        $closing    = "</ul>";
                    @endphp
                @endif
                {!! $opening !!}
                @foreach($variant['v'] as $variant_key => $value)
                    @php
                        $style = '';
                    @endphp
                    @if(!empty($class))
                        @php
                            $style = 'background-color : '. $value['n'].';';
                        @endphp
                    @endif
                    @if(isset($variant['c']) && $variant['c'] == 1)
                        <li class="{{$i == 0 ? 'active' : ''}}">
                            <span class="box" data-color="{{ $value['n'] }}" style="{{ $style }}"></span>
                            <input data-product="{{$product->id}}" data-variant="{{$key}}" class="variant_input"  {{$i == 0 ? 'checked' : ''}}
                            required id="variants-{{$key}}-{{$variant_key}}" name="variants[{{$key}}]" value="{{$variant_key}}" type="radio" style="opacity: 0;position: absolute">
                        </li>
                    @else
                        <span class="spec-radio">
                            <input data-product="{{$product->id}}" data-variant="{{$key}}" class="variant_input"   {{$i == 0 ? 'checked' : ''}}
                            required id="variants-{{$key}}-{{$variant_key}}" name="variants[{{$key}}]" value="{{$variant_key}}" type="radio">
                            <label for="variants-{{$key}}-{{$variant_key}}" class="spec-radio-label {{$class}} " style="{{$style}}">{{$value['n']}}</label>
                       </span>
                    @endif
                    @php $i++; @endphp
                @endforeach
                {!! $closing !!}
            </div>
        @endforeach
    @endif

    @if($product->virtual && $product->downloadable && $product->file)
        {!! Form::hidden('quantity', 1, ['class'=>'form-control','step'=>'1', 'min'=>'1', 'max'=>$product->qty_per_order]) !!}
        @php $class = 'pl-0 mt-10';  @endphp
    @else
        @php $class = '';  @endphp
        <div>
            <span class="label">@lang('Quantity') :</span>
        </div>
        <div class="col-sm-4">
            <div class="cart-quantity">
                <div class="quant-input">
                    {!! Form::number('quantity', 1, ['class'=>'form-control', 'step'=>'1', 'min'=>'1', 'max'=>$product->qty_per_order]) !!}
                </div>
            </div>
        </div>
    @endif
    @php
        if(session('shipping_availability') && config('settings.enable_zip_code')):
            echo '<div class="col-sm-6 add_cart_div '.$class.'"><button class="btn btn-success" id="add_cart" name="submit_button" type="submit"><i class="fa fa-shopping-cart mr-5"></i>'. __('ADD TO CART').'</button></div>';
        elseif(!session('shipping_availability') && config('settings.enable_zip_code')):
            echo '<div class="col-sm-6 add_cart_div '.$class.'"><button class="btn btn-danger" id="add_cart" name="submit_button" disabled><i class="fa fa-shopping-cart mr-5"></i>'. __('ADD TO CART').'</button></div>';
        else:
            echo '<div class="col-sm-6 add_cart_div '.$class.'"><button class="btn btn-success" id="add_cart" name="submit_button" type="submit"><i class="fa fa-shopping-cart mr-5"></i>'. __('ADD TO CART').'</button></div>';
        endif;
    @endphp

    {!! Form::close() !!}
</div>