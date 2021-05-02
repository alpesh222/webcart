@extends('layouts.front')

@section('title')
    {{config('custom.meta_title') ? config('custom.meta_title') : config('app.name')}}
@endsection

@section('meta-tags')
    <meta name="description" content="{{config('custom.meta_description')}}">
    @if(config('custom.meta_keywords'))
        <meta name="keywords" content="{{config('custom.meta_keywords')}}">
    @endif
@endsection

@section('meta-tags-og')
    <meta property="og:url" content="{{url()->current()}}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{config('custom.meta_title') ? config('custom.meta_title') : config('app.name')}}" />
    <meta property="og:description" content="{{config('custom.meta_description')}}" />
    <meta property="og:image" content="{{url('/img/'.config('settings.site_logo'))}}" />
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
        @php $deals = $deals->take(2) @endphp
        @foreach($deals as $key => $deal)
            @include('partials.front.sliders.deal-slider', ['titleSlider' => $deal->name, 'products' => $deal->products->where('is_active', 1), 'index' => $key, 'dealSlug' => $deal->slug])
        @endforeach

        @include('partials.front.sections.below-deal-slider')

        {{-- Sidebar Newsletter Subscriber --}}
        @if(config('settings.enable_subscribers'))
            @include('includes.subscriber')
        @endif

        {{-- Sidebar Testimonials --}}
        @if(count($testimonials) > 0)
            @include('partials.front.sidebar.testimonials')
        @endif
    </div>
@endsection


@section('content')
    <div class="col-xs-12 col-sm-12 col-md-9 homebanner-holder">
        <!-- ============================================== CONTENT ============================================== -->

        @include('partials.front.sections.above-main-slider')

        @if(config('settings.main_slider_enable'))
            {{--  Main Banner  --}}
            @include('includes.image-layouts.main-banner')
        @endif

        @include('partials.front.sections.below-main-slider')

        {{--  Product Slider   --}}
        @if(config('settings.products_slider_enable'))
            @include('partials.front.sliders.products-slider', ['titleSlider'=>__('New Products')])
        @endif

        {{--  Two Image Layout Banner  --}}
        @if(count($banners_below_main_slider_2_images_layout) > 0)
            @include('includes.image-layouts.two-img-layout-banner', ['banners' => $banners_below_main_slider_2_images_layout])
        @endif

        {{--  Featured Product Slider   --}}
        @include('partials.front.sliders.products-slider',['titleSlider'=>__('Featured Products'), 'products' => $featured_products])

        {{--  Single Image Per Row Banner  --}}
        @if(count($banners_below_main_slider) > 0)
            @include('includes.image-layouts.single-img-layout-banner', ['banners' => $banners_below_main_slider])
        @endif

        {{--  Best Selling Products Slider  --}}
        @include('partials.front.sliders.best-selling-products-slider', ['titleSlider'=>__('Best Selling Products')])

        {{--  Single Banner  --}}
{{--        @include('partials.front.sliders.blogs-slider')--}}

    <!-- ============================================== CONTENT : END ============================================== -->
    </div>
@endsection

@section('footer')
    @include('partials.front.sections.above-footer')
@endsection

@section('scripts')
    @include('includes.scripts.deal-countdown-script')
@endsection