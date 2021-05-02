@extends('layouts.front')

@section('title'){{$product->meta_title ? $product->meta_title : $product->name." - ".config('app.name')}}@endsection
@section('meta-tags')<meta name="description" content="{{$product->meta_desc ? $product->meta_desc : StringHelper::truncate(trim(strip_tags($product->description)), 160)}}">
@if($product->meta_keywords)<meta name="keywords" content="{{$product->meta_keywords}}">@endif
@endsection
@section('meta-tags-og')<meta property="og:url" content="{{url()->current()}}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{$product->meta_title ? $product->meta_title : $product->name.' - '.config('app.name')}}" />
    <meta property="og:description" content="{{$product->meta_desc ? $product->meta_desc : StringHelper::truncate(trim(strip_tags($product->description)), 160)}}" />
    @if($product->photo)<meta property="og:image" content="{{$product->photo->name}}" />@endif
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('css/xZoom/xzoom.css')}}">
    <link rel="stylesheet" href="{{asset('css/xZoom/magnific-popup.css')}}">
    <link href="{{asset('css/bootstrap-social.css')}}" rel="stylesheet">
    <style>
        body {
            background-color: #f1f3f6;
        }
    </style>
@endsection

@section('content')
<br>
<div class="container product-container">
    @if($product)
    <div class="cart-message">
        @include('partials.front.cart-message')
    </div>
    <div class="row">
        <div class="col-md-12">
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
            <div class="xzoom-container col-md-12">
                <div class="col-md-6 image-box">
                    <br>
                    @if($product->photo)
                    <img class="img-responsive xzoom" id="xzoom-magnific" src="{{route('imagecache', ['extra-large', $product->photo->getOriginal('name')])}}" xoriginal="{{route('imagecache', ['original', $product->photo->getOriginal('name')])}}" />
                    @else
                    <img class="img-responsive xzoom" id="xzoom-magnific" src="https://via.placeholder.com/1200x900?text=No+Image" xoriginal="https://via.placeholder.com/1200x900?text=No+Image" />
                    @endif
                    <div class="xzoom-thumbs text-center">
                        @if($product->photo)
                            <a href="{{route('imagecache', ['original', $product->photo->getOriginal('name')])}}"><img class="xzoom-gallery" width="80" src="{{route('imagecache', ['tiny', $product->photo->getOriginal('name')])}}" xpreview="{{route('imagecache', ['extra-large', $product->photo->getOriginal('name')])}}"></a>
                        @endif
                        @if(count($product->photos) > 0)
                            @foreach($product->photos as $key=>$photo)
                                <a href="{{route('imagecache', ['original', $photo->getOriginal('name')])}}"><img class="xzoom-gallery" width="80" src="{{route('imagecache', ['tiny', $photo->getOriginal('name')])}}" xpreview="{{route('imagecache', ['extra-large', $photo->getOriginal('name')])}}"></a>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
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
                                <h4 class="text-muted monospaced">{{$product->virtual ? __("Version:") : __("Model No.")}} {{$product->model}}</h4>
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
                        @if($product->price_with_discount() < $product->price)
                        <span class="product-price">{{currency_format($product->price_with_discount())}}</span>
                        <div>
                            <del class="product-price-discount text-muted">{{currency_format($product->price)}}</del>
                            <span class="product-price-discount text-success">{{round($product->discount_percentage())}}% @lang('off')</span>
                        </div>
                        @else
                        @if($product->old_price && ($product->price < $product->old_price))
                        <span class="product-price">{{currency_format($product->price)}}</span>
                        <div>
                            <del class="product-price-discount text-muted">{{currency_format($product->old_price)}}</del>
                            <span class="product-price-discount text-success">{{round(100 * ($product->old_price - $product->price) / $product->old_price)}}% @lang('off')</span>
                        </div>
                        @else
                        <span class="product-price">{{currency_format($product->price)}}</span>
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
                            <div class="form-group">
                                <div class="row text-center">
                                    <div class="col-xs-4 col-sm-2">
                                        {!! Form::label('quantity', __('Quantity:') ) !!}
                                        {!! Form::number('quantity', 1, ['class'=>'form-control', 'step'=>'1', 'min'=>'1', 'max'=>$product->qty_per_order]) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        {!! Form::submit(__('Add To Cart'), ['class'=>'btn btn-success', 'name'=>'submit_button']) !!}
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    @endif
                    @if(Auth::check())
                    @if(!$product->favouritedBy(Auth::user()))
                    <div class="row">
                        <div class="col-md-12">
                            <a href="#" onclick="event.preventDefault(); document.getElementById('product-favourite-form').submit();">
                                @lang('Add to Wishlist')
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

        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
    <script src="{{asset('js/xZoom/xzoom.min.js')}}"></script>
    <script src="{{asset('js/xZoom/jquery.hammer.min.js')}}"></script>
    <script src="{{asset('js/xZoom/magnific-popup.js')}}"></script>
    <script>
        (function ($) {
            $(document).ready(function() {
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
            });
        })(jQuery);
    </script>
    @include('includes.reviews-submit-script')
    @include('includes.reviews-pagination-script')
    @include('includes.cart-submit-script')
@endsection