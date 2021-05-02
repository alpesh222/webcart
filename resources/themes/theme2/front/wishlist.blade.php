@extends('layouts.front')

@section('meta-tags')
    <meta name="description" content="@lang('User Wishlist Products')">
@endsection

@section('meta-tags-og')
    <meta property="og:url" content="{{url()->current()}}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@lang('User Wishlist') - {{config('app.name')}}" />
    <meta property="og:description" content="@lang('User Wishlist Products')" />
    <meta property="og:image" content="{{url('/img/'.config('settings.site_logo'))}}" />
@endsection

@section('title')
    @lang('Wishlist') - {{config('app.name')}}
@endsection

@section('styles')
@endsection

@section('above_content')
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{url('/')}}">@lang('Home')</a></li>
                    <li class="active">@lang('Wishlist')</li>
                </ul>
            </div>
            <!-- /.breadcrumb-inner -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.breadcrumb -->
@endsection

@section('content')
    <div class="my-wishlist-page">
        <div class="col-md-12 my-wishlist">
            <h4 class="heading-title">
                @lang('My Wishlist')
            </h4>
            @if($products->count())
                <div class="search-result-container ">
                    <div id="myTabContent" class="tab-content category-list">
                    @include('includes.products.products-grid-view',['page'=>'wishlist'])
                    <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                    <div class="clearfix filters-container">
                        <div class="text-right">
                            <div class="pagination-container">
                            {{$products->links('vendor.pagination.custom-ui')}}
                            <!-- /.list-inline -->
                            </div>
                            <!-- /.pagination-container --> </div>
                        <!-- /.text-right -->
                    </div>
                    <!-- /.filters-container -->
                </div>
                <!-- /.search-result-container -->
            @else
                <div class="row text-center">
                    <div class="empty-bag">
                        <div class="empty-bag-icon">
                            <img src="{{asset('/img/icons/empty_wishlist-ZGX5hA.png')}}" class="img-responsive m-a" alt="@lang('Empty Wishlist')" width="150">
                        </div>
                        <h3 class="text-center text-muted">@lang('NO ITEM IN YOUR WISHLIST')</h3>
                        <a href="{{url('/')}}" class="btn btn-primary">
                            <div class="continue-shopping-btn">@lang('Continue Shopping')</div>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    @include('includes.cart-submit-script')
@endsection