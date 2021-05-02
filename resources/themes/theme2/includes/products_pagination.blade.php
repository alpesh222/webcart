<div class="custom_product_data">
    @if(count($products) > 0)
        @include('partials.front.products')
    @else
        <div class="row text-center">
            <div class="jumbotron">
                <div class="empty-bag">
                    <div class="empty-bag-icon">
                        <img src="{{asset('/img/icons/no_search_result.png')}}" class="img-responsive m-a" alt="@lang('Empty Products')" width="400">
                    </div>
                    <h3 class="text-center text-muted">@lang('NO PRODUCT FOUND')</h3>
                    <a href="{{url('/')}}" class="btn btn-primary">
                        <div class="continue-shopping-btn">@lang('Continue Shopping')</div>
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>



