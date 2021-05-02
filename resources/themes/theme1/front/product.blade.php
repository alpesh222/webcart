@extends('layouts.front')

@section('title')
    {{$product->meta_title ? $product->meta_title : $product->name." - ".config('app.name')}}
@endsection

@section('meta-tags')
    <meta name="description" content="{{$product->meta_desc ? $product->meta_desc : StringHelper::truncate(trim(strip_tags($product->description)), 160)}}">
    @if($product->meta_keywords)
        <meta name="keywords" content="{{$product->meta_keywords}}">
    @endif
@endsection

@section('meta-tags-og')
    <meta property="og:url" content="{{url()->current()}}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{$product->meta_title ? $product->meta_title : $product->name.' - '.config('app.name')}}" />
    <meta property="og:description" content="{{$product->meta_desc ? $product->meta_desc : StringHelper::truncate(trim(strip_tags($product->description)), 160)}}" />
    @if($product->photo)
        <meta property="og:image" content="{{$product->photo->name}}" />
    @endif
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('css/xZoom/xzoom.css')}}?v=1.0">
    <link rel="stylesheet" href="{{asset('css/xZoom/magnific-popup.css')}}">
    <link href="{{asset('css/bootstrap-social.css')}}" rel="stylesheet">
    @if( !empty( $comparision_group_types ) && count( $comparision_products ) > 1)
        <link rel="stylesheet" href="{{asset('css/comparision-group/css/style.css')}}">
    @endif
    <style>
        body {
            background-color: #f1f3f6;
        }
        .spec-type {
            margin-bottom: 1rem;
            margin-top: 1rem;
        }
        .spec-radio {
            margin-right: 1.4rem;
        }
        .spec-radio input[type="radio"] {
            position: absolute;
            opacity: 0;
        }
        .spec-radio input[type="radio"] + .spec-radio-label:before {
            content: '';
            background: #f4f4f4;
            border-radius: 100%;
            border: 1px solid #b4b4b4;
            display: inline-block;
            width: 1.2em;
            height: 1.2em;
            position: relative;
            top: .2rem;
            margin-right: .75rem;
            vertical-align: top;
            cursor: pointer;
            text-align: center;
            transition: all 250ms ease;
        }
        .spec-radio input[type="radio"]:checked + .spec-radio-label:before {
            background-color: var(--main-color);
            box-shadow: inset 0 0 0 4px #f4f4f4;
        }
        .spec-radio input[type="radio"]:focus + .spec-radio-label:before {
            outline: none;
            border-color: #3197EE;
        }
        .spec-radio input[type="radio"]:disabled + .spec-radio-label:before {
            box-shadow: inset 0 0 0 4px #f4f4f4;
            border-color: #b4b4b4;
            background: #b4b4b4;
        }
        .spec-radio input[type="radio"] + .spec-radio-label:empty:before {
            margin-right: 0;
        }
    </style>
@endsection

@section('above_container')@endsection

@section('content')
    <div class="container">
        @if($product->category)
            <ul class="breadcrumb">
                <li><a href="{{url('/')}}">@lang('Home')</a></li>
                @if($product->category->category)
                    @include('partials.front.parent-category-product', ['category'=>$product->category->category])
                @endif
                <li><a href="{{route('front.category.show', [$product->category->slug])}}">{{$product->category->name}}</a></li>
                <li class="active">{{$product->name}}</li>
            </ul>
        @endif
    </div>

    <div class="container product-container">
        @if($product)
            <div class="cart-message">
            </div>

            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="xzoom-container col-md-12">
                        <div class="col-md-6 image-box">
                            <br>
                            @if($product->photo)
                                @php
                                    $image_url = \App\Helpers\Helper::check_image_avatar($product->photo->name, 500);
                                @endphp
                                <img src="{{$image_url}}" class="img-responsive xzoom" id="xzoom-magnific" xoriginal="{{$image_url}}" alt="{{$product->name}}" />
                            @else
                                <img src="https://via.placeholder.com/500x500?text=No+Image" class="img-responsive xzoom" id="xzoom-magnific" alt="{{$product->name}}" xoriginal="https://via.placeholder.com/500x500?text=No+Image" />
                            @endif
                            <div class="xzoom-thumbs text-center">
                                @if($product->photo)
                                    @php
                                        $image_url = \App\Helpers\Helper::check_image_avatar($product->photo->name, 500);
                                    @endphp
                                    <a href="{{$image_url}}">
                                        <img src="{{$image_url}}" class="xzoom-gallery" width="80" alt="{{$product->name}}" xpreview="{{$image_url}}" />
                                    </a>
                                @else
                                    <a href="https://via.placeholder.com/80x80?text=No+Image">
                                        <img src="https://via.placeholder.com/80x80?text=No+Image" class="xzoom-gallery" width="80" alt="{{$product->name}}" xpreview="https://via.placeholder.com/500x500?text=No+Image" />
                                    </a>
                                @endif
                                @if(count($product->photos) > 0)
                                    @foreach($product->photos as $key=>$photo)
                                        @if($photo)
                                            @php
                                                $image_url = \App\Helpers\Helper::check_image_avatar($photo->name, 500);
                                            @endphp
                                            <a href="{{$image_url}}">
                                                <img src="{{$image_url}}" class="xzoom-gallery" width="80" alt="{{$product->name}}" xpreview="{{$image_url}}" />
                                            </a>
                                        @else
                                            <a href="https://via.placeholder.com/80x80?text=No+Image">
                                                <img src="https://via.placeholder.com/80x80?text=No+Image" class="xzoom-gallery" width="80" alt="{{$product->name}}" xpreview="https://via.placeholder.com/500x500?text=No+Image" />
                                            </a>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 product-details-content">
                            <h1>{{$product->name}}</h1>
                            @if($product->virtual && $product->downloadable && $product->file)
                                <small class="text-muted">@lang('Download access will be given after payment is done.')</small>
                            @endif
                            <div class="row">
                                <div class="col-xs-8">
                                    @if($product->brand)
                                        <a href="{{route('front.brand.show', [$product->brand->slug])}}"><span class="label label-success">{{$product->brand->name}}</span></a>
                                    @endif
                                    @if($product->category)
                                        <a href="{{route('front.category.show', [$product->category->slug])}}"><span class="label label-primary">{{$product->category->name}}</span></a>
                                    @endif
                                    @if(count($product->reviews->where('approved', 1)) > 0)
                                        <p><span class="label label-primary label-sm">{{$product->reviews->where('approved', 1)->where('rating', '!=', null)->avg('rating')}} <span class="glyphicon glyphicon-star" aria-hidden="true"></span></span>
                                            &nbsp;<a href="#reviews">{{count($product->reviews->where('approved', 1)->where('rating', '!=', null))}} @lang('Ratings &') {{count($product->reviews->where('approved', 1)->where('comment', '!=', null))}} @lang('Reviews')</a>
                                        </p>
                                    @endif
                                    @if($product->model)
                                        <h4 class="text-muted monospaced"><br>{{$product->virtual ? __("Version:") : __("Model No.")}} {{$product->model}}</h4>
                                    @endif
                                </div>
                                @if(config('settings.social_share_enable'))
                                    <div class="col-xs-4">
                                        <div class="panel-group social-icons" id="accordion">
                                            <a href="#collapse12" data-parent="#accordion" class="btn dropdown-toggle" type="button" data-toggle="collapse"> <i class="fa fa-share"></i> @lang('Share')</a>
                                            <div id="collapse12" class="panel-collapse social-icons-inner collapse">
                                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::fullUrl()) }}" target="_blank" class="btn btn-sm btn-social-icon btn-facebook social-share">
                                                    <span class="fa fa-facebook"></span>
                                                </a>
                                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(Request::fullUrl()) }}" target="_blank" class="btn btn-sm btn-social-icon btn-twitter social-share">
                                                    <span class="fa fa-twitter"></span>
                                                </a>
                                                <a href="https://plus.google.com/share?url={{ urlencode(Request::fullUrl()) }}" target="_blank" class="btn btn-sm btn-social-icon btn-google social-share">
                                                    <span class="fa fa-google"></span>
                                                </a>
                                                <a href="mailto:?subject={{$product->name}}&amp;body={{ Request::fullUrl() }}" class="btn btn-sm btn-social-icon btn-primary">
                                                    <span class="fa fa-envelope"></span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="product-price-box">
                                @php
                                    $var_amount = $hide = 0;
                                @endphp
                                @if(is_array($variants) && count($variants))
                                    @php $hide = 1; @endphp
                                    @foreach($variants as $key => $variant)
                                        @foreach($variant['v'] as $variant_key => $value)
                                            @php
                                                $var_amount += $value['p'];
                                                break
                                            @endphp
                                        @endforeach
                                    @endforeach
                                @endif
                                @if($product->price_with_discount() < $product->price)
                                    <span class="product-price">{{currency_format($product->price_with_discount() + $var_amount)}}</span>
                                    <del class="product-price-discount text-muted">{{currency_format($product->price)}}</del>
                                    <span class="product-price-discount text-success">{{round($product->discount_percentage())}}@lang('% off')</span>
                                @else
                                    @if($product->old_price && ($product->price < $product->old_price))
                                        <span class="product-price">{{currency_format($product->price + $var_amount)}}</span>
                                        @if($hide == 0)
                                            <div>
                                                <del class="product-price-discount text-muted">{{currency_format($product->old_price)}}</del>
                                                <span class="product-price-discount text-success">{{round(100 * ($product->old_price - $product->price) / $product->old_price)}}@lang('% off')</span>
                                            </div>
                                        @endif
                                    @else
                                        <span class="product-price">{{currency_format($product->price + $var_amount)}}</span>
                                    @endif
                                @endif
                            </div>
                            @if($product->in_stock < 1)
                                <h3 class='text-danger'>@lang('Out of Stock!')</h3>
                            @elseif($product->in_stock < 4)
                                <h4 class='text-danger'>@lang('Only') {{$product->in_stock}} @lang('left in Stock!')</h4>
                            @else
                                <h4 class='text-muted'>@lang('In Stock')</h4>
                            @endif

                            @if($product->in_stock > 0)
                                <div class="row">
                                    <div class="col-md-12">
                                        {!! Form::open(['method'=>'patch', 'route'=>['front.cart.add', $product->id], 'id'=>'cart-form']) !!}

                                        @if($product->virtual && $product->downloadable && $product->file)
                                            {!! Form::hidden('quantity', 1, ['class'=>'form-control','step'=>'1', 'min'=>'1', 'max'=>$product->qty_per_order]) !!}
                                            {{--                                {!! Form::label('quantity', 1,['class'=>'form-control']) !!}--}}
                                        @else
                                            {!! Form::label('quantity', __('Quantity:')) !!}
                                            {!! Form::number('quantity', 1, ['class'=>'form-control', 'step'=>'1', 'min'=>'1', 'max'=>$product->qty_per_order]) !!}
                                        @endif

                                        @if(is_array($variants) && count($variants))
                                            @foreach($variants as $key => $variant)
                                                @php $i = 0 @endphp
                                                <div class="spec-type">
                                                    <strong class="spec-title">{{$variant['n']}}</strong>:<br>
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
                                        @if(config('settings.enable_zip_code'))
                                            <div class="row custom_check_shipping_div">
                                                <div class="col-md-12">
                                                    {!! Form::label('shipping_pincode', __('Check Shipping Availability:')) !!}
                                                </div>
                                                <div class="col-xs-8 shipping_pincode">
                                                    {!! Form::number('shipping_pincode',!empty(session('shipping_availability_value')) ? session('shipping_availability_value') : '' ,['class'=>'form-control','placeholder'=>'Enter Shipping Pincode']) !!}
                                                </div>
                                                <div class="col-xs-4" id="custom_check_shipping_btn">
                                                    <button class="btn btn-primary" type="button" onclick="checkShippingAvailability()">Check</button>
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="text-success" id="shipping_success" style="display: none;">*Shipping Available To Entered PinCode</label>
                                                    <label class="text-danger" id="shipping_error" style="display: none;">*No Shipping Available To Entered PinCode</label>
                                                </div>
                                            </div>
                                        @endif
                                        {{--                            <div class="col-md-12 add_cart_div"><button class="btn btn-success" id="add_cart" name="submit_button" type="submit">@lang('Add To Cart')</button></div>--}}
                                        @php
                                            if(session('shipping_availability') && config('settings.enable_zip_code')):
                                                echo '<div class="col-md-12 add_cart_div"><button class="btn btn-success" id="add_cart" name="submit_button" type="submit">'. __('Add To Cart').'</button></div>';
                                            elseif(!session('shipping_availability') && config('settings.enable_zip_code')):
                                                echo '<div class="col-md-12 add_cart_div"><button class="btn btn-danger" id="add_cart" name="submit_button" disabled>'. __('Add To Cart').'</button></div>';
                                            else:
                                                echo '<div class="col-md-12 add_cart_div"><button class="btn btn-success" id="add_cart" name="submit_button" type="submit">'. __('Add To Cart').'</button></div>';
                                            endif;
                                        @endphp

                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            @endif
                            @if(Auth::check())
                                @if(!$product->favouritedBy(Auth::user()))
                                    <div class="row">
                                        <div class="col-md-12 wishlist-produst text-right">
                                            <a href="#" onclick="event.preventDefault(); document.getElementById('product-favourite-form').submit();">
                                                <i class="fa fa-heart"></i>
                                            </a>
                                            <form id="product-favourite-form" class="hidden"
                                                  action="{{ route('front.product.favourite.store', $product) }}" method="POST">
                                                {{ csrf_field() }}
                                            </form>
                                        </div>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-md-12">
                            <span class="text-primary">
                                @lang('This item is in your')
                            </span>
                                            <a href="{{url('/products/wishlist')}}">
                                                <strong>@lang('Wishlist')</strong>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            @endif
                            @if($product->vendor)
                                <br>
                                <div class="row">
                                    <div class="col-md-12 well">
                                        @lang('Sold By:') <a class="text-primary" href="{{url('/shop')}}/{{$product->vendor->slug}}"><strong>{{$product->vendor->shop_name}}</strong></a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- <div class="row">
                        <div class="col-md-12">
                            {!! DNS1D::getBarcodeHTML($product->barcode, "C128A") !!}
                        </div>
                    </div> --}}

                    @include('partials.front.description-reviews')

                    @include('partials.front.related-products')

                    @include('partials.front.comparision-groups')

                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        async function checkShippingAvailability() {
            this.disabled = true;
            this.innerText ='Please Wait...';
            $('#shipping_success').css('display','none');
            $('#shipping_error').css('display','none');
            var shipping_pincode = $('#shipping_pincode').val();
            if(shipping_pincode != ''){
                let response = await fetch("{{url('/ajax/checkShippingAvailability')}}/"+ shipping_pincode);
                let output  = await response.json();
                    @if(config('settings.enable_zip_code')){
                    if(output === 1){
                        $('#add_cart').removeClass('btn-danger');
                        $('#add_cart').addClass('btn-success');
                        $('#add_cart').removeAttr('disabled');
                        $('#shipping_success').css('display','block');
                    }else{
                        $('#add_cart').removeClass('btn-success');
                        $('#add_cart').addClass('btn-danger');
                        $('#add_cart').attr('disabled','true');
                        $('#shipping_error').css('display','block');
                    }
                }
                @else
                $('#add_cart').addClass('btn-success');
                $('#add_cart').removeAttr('disabled');
                if(output === 1){
                    $('#shipping_success').css('display','block');
                }else{
                    $('#shipping_error').css('display','block');
                }
                @endif
            }else{
                $('#add_cart').removeClass('btn-success');
                $('#add_cart').addClass('btn-danger');
                $('#add_cart').attr('disabled','true');
                $('#shipping_error').css('display','block');
            }

        }
    </script>

    <script src="{{asset('js/xZoom/xzoom.min.js')}}"></script>
    <script src="{{asset('js/xZoom/jquery.hammer.min.js')}}"></script>
    <script src="{{asset('js/xZoom/magnific-popup.js')}}"></script>
    <script>
        (function ($) {
            $(document).ready(function() {
                var variant_elem = $(document).find('.variant_input[type="radio"]');
                // var variant_hidden = $(document).find('.variant_input[type="hidden"]');

                if(variant_elem.length !== 0){
                    {{--updateProductAmount("{{$product->id}}");--}}
                }
                $('.xzoom, .xzoom-gallery').xzoom({zoomWidth: 500, title: false, tint: '#333', Xoffset: 28});

                //Integration with hammer.js
                var isTouchSupported = 'ontouchstart' in window;

                if (isTouchSupported) {
                    $('.xzoom').each(function() {
                        var xzoom = $(this).data('xzoom');
                        $(this).hammer().on("tap", function(event) {
                            event.pageX = event.gesture.center.pageX;
                            event.pageY = event.gesture.center.pageY;
                            var s = 1, ls;

                            xzoom.eventmove = function(element) {
                                element.hammer().on('drag', function(event) {
                                    event.pageX = event.gesture.center.pageX;
                                    event.pageY = event.gesture.center.pageY;
                                    xzoom.movezoom(event);
                                    event.gesture.preventDefault();
                                });
                            }

                            var counter = 0;
                            xzoom.eventclick = function(element) {
                                element.hammer().on('tap', function() {
                                    counter++;
                                    if (counter == 1) setTimeout(openmagnific,300);
                                    event.gesture.preventDefault();
                                });
                            }

                            function openmagnific() {
                                if (counter == 2) {
                                    xzoom.closezoom();
                                    var gallery = xzoom.gallery().cgallery;
                                    var i, images = new Array();
                                    for (i in gallery) {
                                        images[i] = {src: gallery[i]};
                                    }
                                    $.magnificPopup.open({items: images, type:'image', gallery: {enabled: true}});
                                } else {
                                    xzoom.closezoom();
                                }
                                counter = 0;
                            }
                            xzoom.openzoom(event);
                        });
                    });
                } else {
                    //If not touch device
                    //Integration with magnific popup plugin
                    $('#xzoom-magnific').bind('click', function(event) {
                        var xzoom = $(this).data('xzoom');
                        xzoom.closezoom();
                        var gallery = xzoom.gallery().cgallery;
                        var i, images = new Array();
                        for (i in gallery) {
                            images[i] = {src: gallery[i]};
                        }
                        $.magnificPopup.open({items: images, type:'image', gallery: {enabled: true}});
                        event.preventDefault();
                    });
                }

                $(document).on('change', '.variant_input', function() {
                    var product = $(this).data('product');
                    updateProductAmount(product);

                });
            });
        })(jQuery);

        function updateProductAmount(product) {

            var variants = [];
            var values = [];
            $('.variant_input').each(function(input) {
                if($(this).is(':checked')) {
                    var variant = $(this).data('variant');
                    var value = $(this).val();
                    variants.push(variant);
                    values.push(value);
                }
            });

            $.ajax({
                method: 'get',
                url: APP_URL + '/ajax/product/get-variant/' + product + '/' + variants.join(',') + '/' + values.join(','),
                success: function(response) {
                    if(response.success) {
                        $('.product-price-box').html('<span class="product-price">' + response.data + '</span>');
                    }
                }
            });
        }

        $(function(){
            // Product Details Product Color Active Js Code
            $(document).on('click', '.color-variation-list .box', function () {
                colors = $(this).data('color');
                var parent = $(this).parent();
                $('.color-variation-list li').removeClass('active');
                parent.addClass('active');

                var color_var_inp = parent.parent().find('.variant_input[type="radio"]');

                color_var_inp.each(function(input) {
                    this.removeAttribute('checked');
                    // this.setAttribute('value','0');
                });
                // console.log($(this).parent().find('.variant_input[type="hidden"]'));
                var checked_inp = parent.find('.variant_input[type="radio"]');
                checked_inp.attr('checked','true');
                var product = checked_inp.data('product');
                updateProductAmount(product);
                // checked_inp.attr('value','1');
            });
        });

    </script>

    @include('includes.reviews-submit-script')
    @include('includes.reviews-pagination-script')
    @include('includes.cart-submit-script')
    @if( !empty( $comparision_group_types ) && count( $comparision_products ) > 1)
        <script src="{{asset('css/comparision-group/js/modernizer.js')}}"></script>
        <script src="{{asset('css/comparision-group/js/main.js')}}"></script>
    @endif
@endsection