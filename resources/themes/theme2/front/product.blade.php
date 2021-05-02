@extends('layouts.front')

@section('title')
    {{$product->meta_title ? $product->meta_title : $product->name." - ".config('app.name')}}
@endsection

@section('meta-tags')
    <meta name="description" content="{{$product->meta_desc ? $product->meta_desc : StringHelper::truncate(trim(strip_tags($product->description)), 160)}}">
    @if($product->meta_keywords)<meta name="keywords" content="{{$product->meta_keywords}}">@endif
@endsection

@section('meta-tags-og')
    <meta property="og:url" content="{{url()->current()}}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{$product->meta_title ? $product->meta_title : $product->name.' - '.config('app.name')}}" />
    <meta property="og:description" content="{{$product->meta_desc ? $product->meta_desc : StringHelper::truncate(trim(strip_tags($product->description)), 160)}}" />
    @if($product->photo)<meta property="og:image" content="{{$product->photo->name}}" />@endif
@endsection

@section('styles')
    <link href="{{asset('css/custom/custom_ui.css')}}" rel="stylesheet">
@endsection

@section('above_content')
    <div class="breadcrumb">
        <div class="container">
            @if($product->category)
                <div class="breadcrumb-inner">
                    <ul class="list-inline list-unstyled">
                        <li><a href="{{url('/')}}">@lang('Home')</a></li>
                        @if($product->category->category)
                            @include('partials.front.parent-category-product', ['category'=>$product->category->category])
                        @endif
                        <li><a href="{{route('front.category.show', [$product->category->slug])}}">{{$product->category->name}}</a></li>
                        <li class="active">{{$product->name}}</li>
                    </ul>
                </div>
        @endif
        <!-- /.breadcrumb-inner -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.breadcrumb -->
@endsection


@section('sidebar')
    <div class="col-xs-12 col-sm-12 col-md-3 sidebar">
        {{-- Sidebar Categories --}}
        @include('includes.categories-sidebar')

        {{-- Sidebar Discount Offer Slider --}}
        @foreach($discount_products as $discounted_products)
            @include('partials.front.sliders.discount-offer-slider',['discounted_products', $discounted_products])
        @endforeach

        @include('partials.front.sections.above-deal-slider')

        {{-- Sidebar Deal Slider --}}
        @php $deals = $deals->take(2); @endphp
        @foreach($deals as $key => $deal)
            @include('partials.front.sliders.deal-slider', ['titleSlider' => $deal->name, 'products' => $deal->products->where('is_active', 1), 'index' => $key, 'dealSlug' => $deal->slug])
        @endforeach

        @include('partials.front.sections.below-deal-slider')

        {{-- Sidebar Newsletter Subscriber --}}
        @if(config('settings.enable_subscribers'))
            @include('includes.subscriber')
        @endif

    </div>
@endsection

@section('content')
    <div class="col-xs-12 col-sm-12 col-md-9 single-product">
        @if($product)
            <div class="cart-message"></div>
            <div class="detail-block">
                <div class="row  wow fadeInUp">
                    <div class="col-xs-12 col-sm-6 col-md-5 gallery-holder">
                        @include('includes.single-product.single-product-image-section')
                    </div><!-- /.gallery-holder -->

                    <div class='col-sm-6 col-md-7 product-info-block'>

                        <div class="product-info">
                            <h1 class="name">{{$product->name}}</h1>
                            @if($product->virtual && $product->downloadable && $product->file)
                                <small class="text-muted">@lang('Download access will be given after payment is done.')</small>
                            @endif

                            <div class="rating-reviews m-t-20">
                                @include('includes.products.product-rating-section')
                            </div><!-- /.rating-reviews -->

                            <div class="stock-container info-container m-t-10 lh-2">
                                @include('includes.single-product.single-product-details-section')
                            </div><!-- /.stock-container -->

                            <div class="description-container m-t-20">
                                <strong>@lang('Short Description')</strong> : {!! strlen( strip_tags( $product->description ) ) > 150 ? substr( strip_tags( $product->description ), 0, 150 ).'...'  : strip_tags( $product->description )  !!}
                            </div><!-- /.description-container -->

                            <div class="price-container info-container m-t-20">
                                <div class="row">
                                    <div class="col-sm-6">
                                        @include('includes.single-product.single-product-price-section')
                                    </div>

                                    <div class="col-sm-6">
                                        @include('includes.single-product.single-product-social-share')
                                    </div>

                                </div><!-- /.row -->
                            </div><!-- /.price-container -->

                            @if($product->in_stock > 0)
                                <div class="quantity-container info-container">
                                    <div class="row">
                                        @if(config('settings.enable_zip_code'))
                                            <div class="col-md-12">
                                                {!! Form::label('shipping_pincode', __('Check Shipping Availability:')) !!}
                                            </div>
                                            <div class="col-xs-8 shipping_pincode">
                                                {!! Form::number('shipping_pincode',!empty(session('shipping_availability_value')) ? session('shipping_availability_value') : '' ,['class'=>'form-control','placeholder'=>'Enter Shipping Pincode']) !!}
                                            </div>
                                            <div class="col-xs-4" id="custom_check_shipping_btn">
                                                <button class="btn btn-primary" type="button" onclick="checkShippingAvailability()">@lang('Check')</button>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="text-success" id="shipping_success" style="display: none;">*@lang('Shipping Available To Entered PinCode')</label>
                                                <label class="text-danger" id="shipping_error" style="display: none;">*@lang('No Shipping Available To Entered PinCode')</label>
                                            </div>
                                        @endif

                                        @include('includes.single-product.single-product-add-cart-section')
                                    </div><!-- /.row -->
                                </div><!-- /.quantity-container -->
                            @endif


                        </div><!-- /.product-info -->
                    </div><!-- /.col-sm-7 -->
                </div><!-- /.row -->
            </div>
            @include('partials.front.description-reviews')

            @include('partials.front.sliders.related-products-slider')
        @endif
    </div>
@endsection

@section('scripts')
    <script src="{{asset(theme_url('/js/rating.js'))}}"></script>
    @include('includes.scripts.deal-countdown-script')
    @include('includes.scripts.single-product-script')
    @include('includes.reviews-submit-script')
    @include('includes.reviews-pagination-script')
    @include('includes.cart-submit-script')
@endsection