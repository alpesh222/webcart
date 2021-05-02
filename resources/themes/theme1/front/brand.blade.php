@extends('layouts.front')

@section('title'){{$brand->meta_title ? $brand->meta_title : $brand->name." - ".config('app.name')}}@endsection
@section('meta-tags')<meta name="description" content="{{$brand->meta_desc ? $brand->meta_desc : __('Showing Products for Brand:') .$brand->name}}">
@if($brand->meta_keywords)<meta name="keywords" content="{{$brand->meta_keywords}}">@endif
@endsection
@section('meta-tags-og')<meta property="og:url" content="{{url()->current()}}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{$brand->meta_title ? $brand->meta_title : $brand->name.' - '.config('app.name')}}" />
    <meta property="og:description" content="{{$brand->meta_desc ? $brand->meta_desc : __('Showing Products for Brand:') .$brand->name}}" />
    @if($brand->photo)<meta property="og:image" content="{{$brand->photo->name}}" />@endif
@endsection

@section('scripts')
    @include('includes.products-pagination-script')
    @include('includes.cart-submit-script')
@endsection

@section('above_container')
    @include('partials.front.sections.brand-category.above-main-slider')
    <div class="main-banner-box">
        @include('partials.front.full-width-slider')
    </div>
    @include('partials.front.sections.brand-category.below-main-slider')
@endsection

@section('content')
<div class="wrapper2">
    @if(count($banners_below_main_slider) > 0)
        @include('partials.front.banners-below-main-slider', ['banners' => $banners_below_main_slider])
    @endif
    @if(count($banners_below_main_slider_3_images_layout) > 0)
        @include('partials.front.banners-below-main-slider-3-img-layout', ['secondary_banners' => $banners_below_main_slider_3_images_layout->slice(1)->take(2), 'main_banner'=>$banners_below_main_slider_3_images_layout->first()])
    @endif
    @if(count($banners_below_main_slider_2_images_layout) > 0)
        @include('partials.front.banners-below-main-slider-2-img-layout', ['banners' => $banners_below_main_slider_2_images_layout])
    @endif

    @include('partials.front.products')
</div>
@include('partials.front.sections.brand-category.above-footer')
@endsection