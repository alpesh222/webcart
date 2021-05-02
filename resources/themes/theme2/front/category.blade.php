@extends('layouts.front')

@section('title'){{$category->meta_title ? $category->meta_title : $category->name." - ".config('app.name')}}@endsection

@section('meta-tags')
    <meta name="description" content="{{$category->meta_desc ? $category->meta_desc : __('Showing Products for Category:') .$category->name}}">
    @if($category->meta_keywords)<meta name="keywords" content="{{$category->meta_keywords}}">@endif
@endsection

@section('meta-tags-og')
    <meta property="og:url" content="{{url()->current()}}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{$category->meta_title ? $category->meta_title : $category->name.' - '.config('app.name')}}" />
    <meta property="og:description" content="{{$category->meta_desc ? $category->meta_desc : __('Showing Products for Category:') .$category->name}}" />
    @if($category->photo)<meta property="og:image" content="{{$category->photo->name}}" />@endif
@endsection

@section('sidebar')
    <div class="col-xs-12 col-sm-12 col-md-3 sidebar">
        {{-- Sidebar Categories --}}
        @include('includes.categories-sidebar')

        {{-- Sidebar Categories --}}
        @include('partials.front.sidebar.filter-sidebar')

        @if(isset($banners_below_filters) || isset($sections_above_side_banners) || isset($sections_below_side_banners))
            @if(isset($sections_above_side_banners))
                @include('partials.front.sections.brand-category.above-side-banners')
            @endif
            @if(isset($banners_below_filters))
                @include('partials.front.sidebar.side-banners', ['banners' => $banners_below_filters])
            @endif
            @if(isset($sections_below_side_banners))
                @include('partials.front.sections.brand-category.below-side-banners')
            @endif
        @endif

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


@section('above_content')
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{url('/')}}">@lang('Home')</a></li>
                    @if($category->category)
                        @include('partials.front.parent-category', ['category'=>$category->category])
                    @endif
                    <li class="active">{{$category->name}}</li>
                </ul>
            </div>
            <!-- /.breadcrumb-inner -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.breadcrumb -->
@endsection

@section('content')
    <div class="col-xs-12 col-sm-12 col-md-9 homebanner-holder">
        @include('partials.front.sections.brand-category.above-main-slider')
        @if(config('settings.main_slider_enable'))
            {{--  Main Banner  --}}
            @include('includes.image-layouts.main-banner')
            @if(count($banners_main_slider) > 0)
                {{--  Below Main Banner   --}}
                @include('includes.info-tiles')
            @endif
        @endif
        @include('partials.front.sections.brand-category.below-main-slider')

        {{--  Single Image Per Row Banner  --}}
        @if(count($banners_below_main_slider) > 0)
            @include('includes.image-layouts.single-img-layout-banner', ['banners' => $banners_below_main_slider])
        @endif

        {{--  Two Image Layout Banner  --}}
        @if(count($banners_below_main_slider_2_images_layout) > 0)
            @include('includes.image-layouts.two-img-layout-banner', ['banners' => $banners_below_main_slider_2_images_layout])
        @endif

        {{--  Products View  --}}
        @include('includes.products_pagination')
    </div>
@endsection

@section('footer')
    @include('partials.front.sections.brand-category.above-footer')
@endsection

@section('scripts')
    @include('includes.products-pagination-script')
    @include('includes.cart-submit-script')
@endsection