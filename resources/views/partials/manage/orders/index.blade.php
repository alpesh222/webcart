<div class="panel panel-default">
    <div class="panel-heading">
            @if(!empty($search = request()->s))
            @lang('Showing :total_orders orders with :per_page orders per page for keyword: <strong>:keyword</strong>', ['total_orders'=>$orders->total(), 'per_page'=>$orders->perPage(), 'keyword'=>$search])&nbsp;&nbsp;<a class="text-primary" href="{{url('manage/orders')}}">@lang('Show all')</a>
            @else
            @lang('Showing :total_orders orders with :per_page orders per page', ['total_orders'=>$orders->total(), 'per_page'=>$orders->perPage()])
            @endif
            @if(empty(request()->all))
            <br>
            <a href="{{url('manage/orders')}}?all=1">@lang('Show orders in a single page')</a>
            @else
            <br>
            <a href="{{url('manage/orders')}}">@lang('Show orders with pagination')</a>
            @endif
    </div>
    <div class="panel-body">
        @can('delete', App\Order::class)
        <form id="delete-form" action="delete/orders" method="post" class="form-inline">
        @endcan

            <div class="row">
                @can('delete', App\Order::class)
                {{csrf_field()}}
                <div class="col-md-4">
                    <div class="text-muted">
                        <label for="checkboxArray">@lang('Bulk Options') <i class="fa fa-cog" aria-hidden="true"></i></label>
                    </div>
                    <input type="hidden" name="_method" value="DELETE">

                    <div class="form-group">
                        <select name="checkboxArray" class="form-control">
                            <option value="">@lang('Delete')</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <input id="delete_all" name="" class="btn fa btn-warning" value="&#xf1d8;"
                               onclick="
                                       if(confirm('@lang('Are you sure you want to delete selected orders?')')) {
                                           $('#delete_all').attr('name', 'delete_all');
                                           event.preventDefault();
                                            $('#delete-form').submit();
                                       } else {
                                            event.preventDefault();
                                       }
                                       "
                        > 
                    </div>
                </div>
                @endcan
                {{--
                <div class="advanced-search col-md-{{Auth::user()->can('delete', App\Order::class) ? '8' : '8 col-md-offset-4'}}">
                    <div class="text-muted">
                        <label for="checkboxArray">@lang('Advanced Search') <i class="fa fa-search" aria-hidden="true"></i></label>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <select class="form-control" id="select-column">
                                <option value={{Auth::user()->can('delete', App\Order::class) ? 1 : 0}}>@lang('Order No')</option>
                                <option value={{Auth::user()->can('delete', App\Order::class) ? 2 : 1}}>@lang('Products')</option>
                                <option value={{Auth::user()->can('delete', App\Order::class) ? 4 : 3}}>@lang('Payment Method')</option>
                                <option value={{Auth::user()->can('delete', App\Order::class) ? 5 : 4}}>@lang('Payment Status')</option>
                                <option value={{Auth::user()->can('delete', App\Order::class) ? 6 : 5}}>@lang('Current Status')</option>
                                <option value={{Auth::user()->can('delete', App\Order::class) ? 7 : 6}}>@lang('Status')</option>
                                <option value={{Auth::user()->can('delete', App\Order::class) ? 8 : 7}}>@lang('Order Date')</option>
                                <option value={{Auth::user()->can('delete', App\Order::class) ? 9 : 8}}>@lang('Added By')</option>
                                <option value={{Auth::user()->can('delete', App\Order::class) ? 10 : 9}}>@lang('Processed')</option>
                            </select>
                        </div>
                        <div class="col-md-7">
                            <input class="form-control" type="text" id="search-by-column" placeholder="@lang('Search by Column')">
                        </div>
                    </div>
                </div>
                --}}
                <div class="search-box form-inline text-right col-md-{{Auth::user()->can('delete', App\Other::class) ? '8' : '8 col-md-offset-4'}}">
                    @lang('Enter order id, first name, last name, phone or email')<br>
                    <div class="form-group search-field-box">
                        <input type="text" class="form-control" name="search" id="keyword" placeholder="" value="{{request()->s}}">
                    </div>
                    <button data-url="{{url('manage/orders')}}" type="button" class="btn btn-primary" id="search-btn">@lang('Search')</button>
                </div>
            </div>
            <div class="table-responsive">
                {{--
                <div class="col-md-12 text-right">
                    <span class="advanced-search-toggle">@lang('Advanced Search')</span>
                </div>
                --}}
                <table class="display table table-striped table-bordered table-hover" id="orders-table">
                    <thead>
                    <tr>
                        @can('delete', App\Order::class)
                        <th><input type="checkbox" id="options"></th>
                        @endcan
                        <th>@lang('Order No')</th>
                        <th>@lang('Products')</th>
                        <th>@lang('Total')</th>
                        <th>@lang('Payment Method')</th>
                        <th>@lang('Payment Status')</th>
                        <th>@lang('Current Status')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Order Date')</th>
                        <th>@lang('Added By')</th>
                        <th>@lang('Tracking ID')</th>
                        <th>@lang('Delivery Service')</th>
                        <th>@lang('Processed')</th>
                        @if((Auth::user()->can('update', App\Order::class)) || (Auth::user()->can('delete', App\Order::class)) || (Auth::user()->can('manage-shipment-orders', App\Other::class)))
                        <th>@lang('Action')</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @if($orders)
                        @foreach($orders as $order)
                            <tr>
                                @can('delete', App\Order::class)
                                <td><input class="checkboxes" type="checkbox" name="checkboxArray[]" value="{{$order->id}}"></td>
                                @endcan
                                <td>{{$order->getOrderId()}}</td>
                                <td>
                                    @if($order->products)
                                        <ul>
                                        @foreach($order->products as $product)
                                            <li>
                                                <a target="_blank" href="{{route('front.product.show', [$product->slug])}}">
                                                    {{$product->name}}
                                                </a> 
                                            </li>
                                        @endforeach
                                        <ul>
                                    @endif
                                </td>
                                <td>{{currency_format($order->shipping_cost + $order->total - $order->wallet_amount - $order->coupon_amount + ($order->total * $order->tax) / 100, $order->currency)}}</td>
                                <td>{{$order->payment_method}}</td>
                                <td>
                                @if($order->is_not_online_payment() && $order->paid == 0)
                                    <strong class="text-warning">@lang('Failed')</strong>
                                @else
                                    @if($order->paid)
                                    <strong class="text-success">@lang('Paid')</strong>
                                    @else
                                    <strong class="text-danger">@lang('Unpaid')</strong>
                                    @endif
                                @endif
                                </td>
                                <td>{{$order->is_processed || $order->stock_regained || ($order->is_not_online_payment() && $order->paid == 0) ? '-' : $order->status}}</td>
								<td>
                                @if($order->is_processed)
                                    <strong class="text-success">@lang('Delivered')</strong>
                                @else
                                    @if($order->stock_regained)
                                    <strong class="text-primary">@lang('Cancelled')</strong>
                                    @elseif($order->is_not_online_payment() && $order->paid == 0)
                                    <strong class="text-warning">@lang('Failed')</strong>
                                    @else
                                    <strong class="text-danger">@lang('Pending')</strong>
                                    @endif
                                @endif
                                </td>
                                <td>{{$order->created_at}}</td>
                                <td>{{$order->user ? $order->user->name .' @'.$order->user->username : '-'}}</td>
                                <td>{{$order->tracking_id ? $order->tracking_id : '-'}}</td>
                                <td>{{$order->delivery_service ? ucfirst($order->delivery_service) : '-'}}</td>
                                <td>{{$order->processed_date? $order->processed_date : '-'}}</td>
                                @if((Auth::user()->can('update', App\Order::class)) || (Auth::user()->can('delete', App\Order::class)) || (Auth::user()->can('manage-shipment-orders', App\Other::class)))
                                <td>
                                @if((Auth::user()->can('update', App\Order::class)) || (Auth::user()->can('manage-shipment-orders', App\Other::class)))
                                    @if(!$order->is_processed && (!$order->stock_regained) && !($order->is_not_online_payment() && $order->paid == 0))
                                    <a href="{{route('manage.orders.edit', $order->id)}}">
                                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                    </a>&nbsp;
                                    @endif
                                    <a target="_blank" href="{{route('manage.orders.show', $order->id)}}">
                                        <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                                    </a>
                                @endif
                                &nbsp;
                                @can('delete', App\Order::class)
                                    <input type="hidden" id="delete_single" name="">
                                    <a href=""
                                       onclick="
                                                @if($order->hide == true)
                                                    if(confirm('@lang('Are you sure you want to delete this?')')) {
                                                @else
                                                    if(confirm('@lang('This is currently in customer orders list. Are you sure you want to delete this?')')) {
                                                @endif
                                                   $('#delete_single').attr('name', 'delete_single').val({{$order->id}});
                                                   event.preventDefault();
                                                   $('#delete-form').submit();
                                               } else {
                                                    event.preventDefault();
                                               }
                                               "
                                    ><span class="glyphicon glyphicon-trash text-danger" aria-hidden="true"></span></a>
                                @endcan
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        @can('delete', App\Order::class)
        </form>
        @endcan
        @if(!request()->all)
        <div class="text-right">
            {{$orders->appends($_GET)->links()}}
        </div>
        @endif
    </div>
</div>