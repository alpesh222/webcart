<div class="row">
    @if($product->brand)
        <div class="col-sm-2">
            <div class="stock-box">
                <span class="label"><strong>@lang('Brand') </strong>:</span>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="stock-box">
                <span class="value">
                    <a href="{{route('front.brand.show', [$product->brand->slug])}}">{{$product->brand->name}}</a>
                </span>
            </div>
        </div>
    @endif
    @if($product->category)
        <div class="col-sm-2">
            <div class="stock-box">
                <span class="label"><strong>@lang('Category')</strong> :</span>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="stock-box">
                <span class="value">
                    <a href="{{route('front.category.show', [$product->category->slug])}}">{{$product->category->name}}</a>
                </span>
            </div>
        </div>
    @endif
    @if($product->model)
        <div class="col-sm-2">
            <div class="stock-box">
                <span class="label"><strong> {{$product->virtual ? __("Version") : __("Model No.")}} </strong> :</span>
            </div>
        </div>
        <div class="col-sm-9">
            <div>
                <span class="value">
                   {{$product->model}}
                </span>
            </div>
        </div>
    @endif
    @if($product->vendor)
        <div class="col-sm-2">
            <div class="stock-box">
                <span class="label"><strong> @lang('Sold By') </strong> :</span>
            </div>
        </div>
        <div class="col-sm-9">
            <div>
                <span class="value">
                   <a href="{{url('/shop')}}/{{$product->vendor->slug}}">{{$product->vendor->shop_name}}</a>
                </span>
            </div>
        </div>
    @endif

    <div class="col-sm-2">
        <div class="stock-box">
            <span class="label"><strong>@lang('Availability')</strong> : </span>
        </div>
    </div>
    <div class="col-sm-9">
        <div class="stock-box">
            <span class="value ml-5">
               @if($product->in_stock < 1)
                    @lang('Out of Stock!')
                @elseif($product->in_stock < 4)
                    @lang('Only') {{$product->in_stock}} @lang('left in Stock!')
                @else
                    <span class='text-success'> @lang('In Stock')</span>
                @endif
            </span>
        </div>
    </div>
</div><!-- /.row -->