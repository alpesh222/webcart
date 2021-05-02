
<div class="cart-message">
    @include('partials.front.cart-message')
</div>
<div class="clearfix filters-container m-t-10">
    <div class="row">
        <!-- /.col -->
        <div class="col col-sm-9 col-md-8">
            <div class="col col-sm-6 col-md-6 no-padding pl-15">
                <div class="lbl-cnt">
                        <span class="lbl">@lang('Showing')
                            {{ $products->firstItem() }} - {{ $products->lastItem() }} @lang('products of') {{ $products->total() }} @lang('products')
                        </span>
                    <!-- /.fld -->
                </div>
                <!-- /.lbl-cnt -->
            </div>
            <!-- /.col -->

            <div class="col col-sm-6 col-md-6 no-padding p-0">
                <div class="lbl-cnt">
                    <span class="lbl ">@lang('Sort Products:')</span>
                    <div class="fld inline">
                        <div class="dropdown dropdown-small dropdown-med dropdown-white inline">
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
                    <!-- /.fld -->
                </div>
                <!-- /.lbl-cnt -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.col -->
        <div class="col col-sm-3 col-md-4 text-right">
            <div class="pagination-container">
            {{$products->links('vendor.pagination.custom-ui')}}
            <!-- /.list-inline -->
            </div>
            <!-- /.pagination-container -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div>

<div class="search-result-container ">
    <div id="myTabContent" class="tab-content category-list">
    @include('includes.products.products-grid-view')
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