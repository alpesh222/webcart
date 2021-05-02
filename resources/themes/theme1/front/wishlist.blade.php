@extends('layouts.front')

@section('title')@lang('Wishlist') - {{config('app.name')}}@endsection

@section('styles')
<style>
    .cart-container {
        margin-bottom: 120px;
    }
    .custom_prod_rating{
        margin-top: 8px;
    }
</style>
@endsection

@section('content')
<br>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ul class="breadcrumb">
                <li><a href="{{url('/')}}">@lang('Home')</a></li>
                <li>@lang('Wishlist')</li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 cart-container page_wishlist">
            @if($products->count())
            <div class="row">
                <div class="col-md-12">
                    <div class="cart-message">
                        @include('partials.front.cart-message')
                    </div>
                </div>
            </div>
            <div class="col-md-12">
				<h2 class="circle-icon-header"><span> <i class="fa fa-gift"></i>  @lang('Wishlist') </span></h2>
                <div class="panel-body">
                    <div class="products">
                        <div class="row" id="products-list">
                            <ul class="rig columns-3">
                            @foreach($products as $product)
                                <li class="product-box text-center">
                                    <h5 class="text-muted">@lang('Added') {{ $product->pivot->created_at->diffforHumans() }}</h5>
                                    <h6><a class="text-danger" href="#" onclick="event.preventDefault(); document.getElementById('product-favourite-destroy-{{ $product->id }}').submit();">
                                                    @lang('Remove from Wishlist')
                                                </a></h6>
                                    <form action="{{ route('front.product.favourite.destroy', $product) }}"
                                        method="POST" 
                                        id="product-favourite-destroy-{{ $product->id }}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                    </form>
                                    <div class="thumbnail product-box">
                                        <a href="{{route('front.product.show', [$product->slug])}}">
                                        @if($product->photo)
                                            @php
                                                $image_url = \App\Helpers\Helper::check_image_avatar($product->photo->name, 150);
                                            @endphp
                                            <img src="{{$image_url}}" alt="{{$product->name}}"  />
                                        @else
                                            <img src="https://via.placeholder.com/150x150?text=No+Image" alt="{{$product->name}}" />
                                        @endif
                                        </a>
                                        <div class="caption custom_related_title">
										 <div class="title-caption">
                                            <span class="product-name"><a href="{{route('front.product.show', [$product->slug])}}">{{$product->name}} </a></span>
                                            <p>@lang('Price:') 
                                                @if($product->price_with_discount() < $product->price)
                                                <strong>{{currency_format($product->price_with_discount())}}</strong>
                                                <div class="old_price">
                                                    <del class="text-muted">{{currency_format($product->price)}}</del>
                                                    <span class="text-success">{{round($product->discount_percentage())}}@lang('% off')</span>
                                                </div>
                                                @else
                                                <strong>{{currency_format($product->price)}}</strong>
                                                @endif
                                            </p>
											</div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <ul class="pagination">
                    {{$products->links('vendor.pagination.custom')}}
                </ul>
            </div>
            @else
				<br>
                <div class="jumbotron">
                    <h2 class="text-center text-muted">@lang('The wishlist is empty.')
                        <a href="{{url('/')}}" class="btn btn-primary">@lang('Go to Shop')</a>
                    </h2>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @include('includes.cart-submit-script')
@endsection