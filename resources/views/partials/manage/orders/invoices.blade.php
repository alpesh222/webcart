<div class="panel panel-default">
    <div class="panel-heading">
        @if(!empty($search = request()->s))
        @lang('Showing :total_orders invoices with :per_page invoices per page for keyword: <strong>:keyword</strong>', ['total_orders'=>$orders->total(), 'per_page'=>$orders->perPage(), 'keyword'=>$search])&nbsp;&nbsp;<a class="text-primary" href="{{url('manage/invoices')}}">@lang('Show all')</a>
        @else
        @lang('Showing :total_orders invoices with :per_page invoices per page', ['total_orders'=>$orders->total(), 'per_page'=>$orders->perPage()])
        @endif
        @if(empty(request()->all))
        <br>
        <a href="{{url('manage/invoices')}}?all=1">@lang('Show invoices in a single page')</a>
        @else
        <br>
        <a href="{{url('manage/invoices')}}">@lang('Show invoices with pagination')</a>
        @endif
    </div>
    <div class="panel-body">
        {{--
        <div class="row advanced-search">
            <div class="col-md-5">
                <select class="form-control" id="select-column">
                    <option value=0>@lang('Order No')</option>
                    <option value=1>@lang('Order Date')</option>
                    <option value=2>@lang('Added By')</option>
                    <option value=3>@lang('Processed')</option>
                </select>
            </div>
            <div class="col-md-7">
                <input class="form-control" type="text" id="search-by-column" placeholder="@lang('Search by Column')">
            </div>
        </div>
        --}}
        <div class="row">
            <div class="search-box form-inline text-right col-md-{{Auth::user()->can('delete', App\Other::class) ? '8' : '8 col-md-offset-4'}}">
                @lang('Enter order id, first name, last name, phone or email')<br>
                <div class="form-group search-field-box">
                    <input type="text" class="form-control" name="search" id="keyword" placeholder="" value="{{request()->s}}">
                </div>
                <button data-url="{{url('manage/invoices')}}" type="button" class="btn btn-primary" id="search-btn">Search</button>
            </div>
        </div>
        <div class="table-responsive">
            {{--
            <div class="col-md-12 text-right">
                <span class="advanced-search-toggle">@lang('Advanced Search')</span>
            </div>
            --}}
            <table class="display table table-striped table-bordered table-hover" id="invoices-table">
                <thead>
                    <tr>
                        <th>@lang('Order No')</th>
                        <th>@lang('Order Date')</th>
                        <th>@lang('Added By')</th>
                        <th>@lang('Processed')</th>
                        <th>@lang('Invoice')</th>
                    </tr>
                    </thead>
                <tbody>
                    @if($orders)
                        @foreach($orders as $order)
                            <tr>
                                <td>{{$order->getOrderId()}}</td>
                                <td>{{$order->created_at}}</td>
                                <td>{{$order->user ? $order->user->name .' @'.$order->user->username : '-'}}</td>
                                <td>{{$order->processed_date? $order->processed_date : '-'}}</td>
                                <td><a target="_blank" href="{{route('manage.orders.show', ['id'=>$order->id])}}">@lang('View')</a></td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
            @if(!request()->all)
            <div class="text-right">
                {{$orders->appends($_GET)->links()}}
            </div>
            @endif
        </div>
    </div>
</div>
