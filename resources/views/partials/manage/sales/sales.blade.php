<div class="panel panel-default">
    <div class="panel-heading">
        @lang('View Sales')
    </div>
    <div class="panel-body">
        <div class="row advanced-search">
            <div class="col-md-5">
                <select class="form-control" id="select-column">
                    <option value=2>@lang('Product Name')</option>
                    <option value=3>@lang('Product Price')</option>
                    <option value=4>@lang('Total Sales')</option>
                </select>
            </div>
            <div class="col-md-7">
                <input class="form-control" type="text" id="search-by-column" placeholder="@lang('Search by Column')">
            </div>
        </div>
        <div class="table-responsive">
            <div class="col-md-12 text-right">
                <span class="advanced-search-toggle">@lang('Advanced Search')</span>
            </div>
            <table class="display table table-striped table-bordered table-hover" id="sales-table">
                <thead>
                <tr>
                    <th>@lang('Product ID')</th>
                    <th>@lang('Photo')</th>
                    <th>@lang('Product Name')</th>
                    <th>@lang('Product Price')</th>
                    <th>@lang('Total Sales')</th>
                </tr>
                </thead>
                <tbody>
                @if($sales)
                    @foreach($sales as $sale)
                        <tr>
                            <td>{{$sale->id}}</td>
                            <td>
                                @if($sale->photo)
                                    @php
                                        $image_url = \App\Helpers\Helper::check_image_avatar($sale->photo->name, 50);
                                    @endphp
                                    <img src="{{$image_url}}" alt="{{$sale->name}}" height="50px" />
                                @else
                                    <img src="https://via.placeholder.com/50x50?text=No+Image" alt="{{$sale->name}}" height="50px" />
                                @endif
                            </td>
                            <td>{{$sale->name}}</td>
                            <td>{{currency_format($sale->price)}}</td>
                            <td>{{$sale->sales}}</td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>