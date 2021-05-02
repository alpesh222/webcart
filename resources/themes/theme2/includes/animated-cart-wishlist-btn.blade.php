@if(isset($wishlist_page) && $wishlist_page)
    @php $wishlist_page = true; @endphp
    <style>
        .product .cart.animate-effect{
            left: 0;
            margin-left: 5%;
        }
    </style>
@else
    @php $wishlist_page = false; @endphp
@endif
<div class="cart clearfix animate-effect" {{!Auth::check() ? ' style=margin-left:-25px' : ''}}>
    <div class="action">
        <ul class="list-unstyled">
            @if($wishlist_page)
                <li class="remove-wishlist-product btn-group">
                    <button data-toggle="tooltip" onclick="event.preventDefault(); document.getElementById('product-favourite-destroy-{{ $product->id }}').submit();"
                            class="btn btn-danger icon" type="button" title="@lang('Remove From Wishlist')">
                        <i class="fa fa-trash"> </i> @lang('Remove From Wishlist')
                    </button>
                    <form action="{{ route('front.product.favourite.destroy', $product) }}"
                          method="POST"
                          id="product-favourite-destroy-{{ $product->id }}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                    </form>
                </li>
            @else
                <li class="add-cart-button btn-group">
                    <button data-toggle="tooltip" onclick="window.location.href='{{route('front.product.show', [$product->slug])}}'"
                            class="btn btn-primary icon" type="button" title="@lang('View Details')">
                        <i class="fa fa-eye"></i>
                    </button>
                    <button class="btn btn-primary cart-btn" type="button">@lang('View Details')</button>
                </li>
                @if(Auth::check())
                @if(!$product->favouritedBy(Auth::user()))
                    <li class="lnk wishlist">
                        <a data-toggle="tooltip" class="add-to-cart"
                           href="#" onclick="event.preventDefault(); document.getElementById('product-favourite-form-{{$product->id}}').submit();" title="@lang('Wishlist')">
                            <i class="icon fa fa-heart"></i>
                        </a>
                        <form id="product-favourite-form-{{$product->id}}" class="hidden"
                              action="{{ route('front.product.favourite.store', $product) }}" method="POST">
                            {{ csrf_field() }}
                        </form>
                    </li>
                @else
                    <li class="lnk wishlist bg-danger">
                        <a data-toggle="tooltip" class="add-to-cart" href="{{url('/products/wishlist')}}" title="Wishlist">
                            <i class="icon fa fa-heart"></i>
                        </a>
                    </li>
                @endif
            @endif
            @endif
        </ul>
    </div>
    <!-- /.action -->
</div>