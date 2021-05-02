@extends('layouts.front')

@section('title'){{$category->meta_title ? $category->meta_title : $category->name." - ".config('app.name')}}@endsection
@section('meta-tags')<meta name="description" content="{{$category->meta_desc ? $category->meta_desc : __('Showing Products for Category:') .$category->name}}">
@if($category->meta_keywords)<meta name="keywords" content="{{$category->meta_keywords}}">@endif
@endsection
@section('meta-tags-og')<meta property="og:url" content="{{url()->current()}}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{$category->meta_title ? $category->meta_title : $category->name.' - '.config('app.name')}}" />
    <meta property="og:description" content="{{$category->meta_desc ? $category->meta_desc : __('Showing Products for Category:') .$category->name}}" />
    @if($category->photo)<meta property="og:image" content="{{$category->photo->name}}" />@endif
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
    <div class="row">
        <div class="col-md-12">
            <ul class="breadcrumb">
                <li><a href="{{url('/')}}">@lang('Home')</a></li>
                @if($category->category)
                    @include('partials.front.parent-category', ['category'=>$category->category])
                @endif
                <li class="active">{{$category->name}}</li>
            </ul>
        </div>
    </div>
    @include('partials.front.products')
</div>
@include('partials.front.sections.brand-category.above-footer')
@endsection