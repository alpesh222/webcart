@extends('layouts.front')

@section('title')
    @lang('Products'){{' - ' .config('app.name')}}
@endsection

@section('meta-tags')
    <meta name="description" content="@lang('Showing all Products')">
@endsection

@section('meta-tags-og')
    <meta property="og:url" content="{{url()->current()}}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@lang('Products') - {{config('app.name')}}" />
    <meta property="og:description" content="@lang('Showing all Products')" />
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
                    <li class="active">@lang('Showing All Products')</li>
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
        {{--  Products View  --}}
        @include('includes.products_pagination')
    </div>
@endsection

@section('scripts')
    @include('includes.products-pagination-script')
    @include('includes.cart-submit-script')
@endsection