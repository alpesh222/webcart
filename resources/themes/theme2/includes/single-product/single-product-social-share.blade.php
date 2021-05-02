<div class="favorite-button m-t-10">
    @if(Auth::check())
        @if(!$product->favouritedBy(Auth::user()))
            <a class="btn btn-primary" onclick="event.preventDefault(); document.getElementById('product-favourite-form').submit();"
               data-toggle="tooltip" data-placement="right" title="@lang('Wishlist')" href="#">
                <i class="fa fa-heart"></i>
                <form id="product-favourite-form" class="hidden"
                      action="{{ route('front.product.favourite.store', $product) }}" method="POST">
                    {{ csrf_field() }}
                </form>
            </a>
        @else
            <a class="btn btn-danger" data-toggle="tooltip" data-placement="right" title="@lang('Wishlist')"
               href="{{url('/products/wishlist')}}">
                <i class="fa fa-heart"></i>
            </a>
        @endif
    @endif

    @if(config('settings.social_share_enable'))
        <a class="btn btn-primary" data-toggle="tooltip" target="_blank" data-placement="right" title="@lang('Facebook')"
           href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::fullUrl()) }}">
            <i class="fa fa-facebook"></i>
        </a>
        <a class="btn btn-primary" data-toggle="tooltip" target="_blank" data-placement="right" title="@lang('Twitter')"
           href="https://twitter.com/intent/tweet?url={{ urlencode(Request::fullUrl()) }}">
            <i class="fa fa-twitter"></i>
        </a>
        <a class="btn btn-primary" data-toggle="tooltip" target="_blank" data-placement="right" title="@lang('Google')"
           href="https://plus.google.com/share?url={{ urlencode(Request::fullUrl()) }}">
            <i class="fa fa-google"></i>
        </a>
        <a class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="@lang('E-mail')"
           href="mailto:?subject={{$product->name}}&amp;body={{ Request::fullUrl() }}">
            <i class="fa fa-envelope"></i>
        </a>
    @endif
</div>