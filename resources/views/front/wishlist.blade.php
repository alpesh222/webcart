@extends('layouts.front')

@section('title')@lang('Wishlist') - {{config('app.name')}}@endsection

@section('styles')
<style>
    .cart-container {
        margin-bottom: 120px;
    }
</style>
@endsection

@section('content')
<br>
<div class="container">
    <div class="row">
        <div class="col-md-12 cart-container">
            @if($products->count())
            <div class="row">
                <div class="col-md-12">
                    <div class="cart-message">
                        @include('partials.front.cart-message')
                    </div>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading text-center">
                    <strong><span class="cart-header">@lang('Wishlist') <i class="fa fa-gift"></i></span></strong>
                </div>
                <div class="panel-body">
                    <div class="products">
                        <div class="row" id="products-list">
                            <ul class="rig columns-3">
                            @foreach($products as $product)
                                <li class="product-box text-center">
                                    <h5 class="text-muted">@lang('Added') {{ $product->pivot->created_at->diffforHumans() }}</h5>
                                    <h5><a href="#" onclick="event.preventDefault(); document.getElementById('product-favourite-destroy-{{ $product->id }}').submit();">
                                        @lang('Remove from Wishlist')
                                    </a></h5>
                                    <form action="{{ route('front.product.favourite.destroy', $product) }}" 
                                        method="POST" 
                                        id="product-favourite-destroy-{{ $product->id }}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                    </form>
                                    <div class="thumbnail product-box">
                                        <a href="{{route('front.product.show', [$product->slug])}}">
                                        @if($product->photo)
                                        <img src="{{route('imagecache', ['large', $product->photo->getOriginal('name')])}}" alt="{{$product->name}}" />
                                        @else
                                        <img src="https://via.placeholder.com/150x150?text=No+Image" alt="{{$product->name}}" />
                                        @endif
                                        </a>
                                        <div class="caption">
                                            <span class="product-name"><a href="{{route('front.product.show', [$product->slug])}}">{{$product->name}} </a></span>
                                            <p>@lang('Price:')
                                                @if($product->price_with_discount() < $product->price)
                                                <strong>{{currency_format($product->price_with_discount())}}</strong>
                                                <div class="old_price">
                                                    <del class="text-muted">{{currency_format($product->price)}}</del>
                                                    <span class="text-success">{{round($product->discount_percentage())}}% @lang('off')</span>
                                                </div>
                                                @else
                                                <strong>{{currency_format($product->price)}}</strong>
                                                @endif
                                            </p>

                                            @if($product->in_stock < 1)
                                            <p><span class='text-danger'>@lang('Out of Stock!')</span></p>
                                            @elseif($product->in_stock < 4)
                                            <p><span class='text-danger'>@lang('Only') {{$product->in_stock}} @lang('left in Stock!')</span></p>
                                            @endif

                                            @if(count($product->reviews->where('approved', 1)) > 0)
                                            <p><a target="_blank" href="{{route('front.product.show', [$product->slug])}}#reviews"><span class="label label-primary label-sm">{{$product->reviews->where('approved', 1)->where('rating', '!=', null)->avg('rating')}} <span class="glyphicon glyphicon-star" aria-hidden="true"></span></span><small>
                                                {{count($product->reviews->where('approved', 1)->where('rating', '!=', null))}} @lang('Ratings &') {{count($product->reviews->where('approved', 1)->where('comment', '!=', null))}} @lang('Reviews')</small></a>
                                            </p>
                                            @endif
                                            <div class="row">
                                                {!! Form::open(['method'=>'patch', 'route'=>['front.cart.add', $product->id], 'id'=>'cart-form']) !!}
                                                <div class="form-group">
                                                    <div class="col-xs-6 btn-padding-cv">
                                                        @if($product->in_stock > 0)
                                                        {!! Form::submit(__('Add To Cart'), ['class'=>'btn btn-xs btn-success', 'name'=>'submit_button']) !!}
                                                        @endif
                                                    </div>
                                                    <div class="col-xs-6 btn-padding-cv">
                                                        <a href="{{route('front.product.show', [$product->slug])}}" class="btn btn-xs btn-primary" role="button">@lang('View Details')</a>
                                                    </div>
                                                </div>
                                                {!! Form::close() !!}
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