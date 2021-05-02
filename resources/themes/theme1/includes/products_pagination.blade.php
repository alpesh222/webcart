<div class="col-md-9">
    <div class="col-md-12 firstitem-bar">
        <div class="pull-left">
            <div class="text-muted showing-products-number pull-left text-left">

                @lang('Showing') {{ $products->firstItem() }} - {{ $products->lastItem() }} @lang('products of') {{ $products->total() }} @lang('products')
            </div>
            <div class="cart-message">
                @include('partials.front.cart-message')
            </div>
        </div>

        <div class="btn-group form-inline pull-right">
            <div class="form-group">
                <label for="sort_products">@lang('Sort Products:')</label>
                <select class="form-control" id="sort_products">
                    <option value="0">@lang('Select Option')</option>
                    <option value="1">@lang('By Price Low to High')</option>
                    <option value="2">@lang('By Price High to Low')</option>
                    <option value="3">@lang('By Popularity')</option>
                    <option value="4">@lang('By Avg. Ratings')</option>
                    <option value="5">@lang('By Highest Reviews')</option>
                </select>
            </div>
        </div>
    </div>

    @include('includes.products')
</div>
