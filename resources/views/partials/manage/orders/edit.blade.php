<div class="row">
    <div class="col-xs-12 col-sm-8">

        @if(session()->has('order_updated'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{session('order_updated')}}</strong>
            </div>
        @endif

        @if(session()->has('order_not_updated'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <span class="glyphicon glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <strong>{{session('order_not_updated')}}</strong>
            </div>
        @endif

        @include('includes.form_errors')

        @can('read', App\Location::class)
        <div class="row">
            <div class="col-md-6 col-sm-8 col-xs-12">
                @lang('Location:') 
                <strong>
                    @if($order->location)
                        {{$order->location->name}}
                    @else
                        @lang('None')
                    @endif
                </strong>
            <br><br>
            </div>
        </div>
        @endcan

        <div id="invoice">
            <style>
                .invoice-title h2, .invoice-title h3 {
                    display: inline-block;
                }
                .table > tbody > tr > .no-line {
                    border-top: none;
                }
                .table > thead > tr > .no-line {
                    border-bottom: none;
                }
                .table > tbody > tr > .thick-line {
                    border-top: 2px solid;
                }
                #invoice-logo {
                    width: 70px;
                    height: auto;
                }
            </style>
            <div class="row">
                <div class="col-xs-12">
                    <div class="invoice-title">
                        <h2>@lang('Order Detail')</h2>
                        @if(!empty(config('settings.site_logo')))
                        &nbsp;<img class="img-responsive" id="invoice-logo" src="{{url('/img/'.config('settings.site_logo'))}}">
                        @endif
                        <h3 class="pull-right">@lang('Order') # {{$order->getOrderId()}}</h3>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-xs-6">
                            <address>
                            <strong>@lang('Billed To:')</strong><br>
                                {{$order->address->first_name}} {{$order->address->last_name}}<br>
                                <strong>@lang('Phone:')</strong> {{$order->address->phone}}<br>
                                <strong>@lang('Email:')</strong> {{$order->address->email}}
                            </address>
                        </div>
                        <div class="col-xs-6 text-right">
                            <address>
                            <strong>@lang('Shipping Address:')</strong><br>
                                {{$order->address->first_name}} {{$order->address->last_name}}<br>
                                {{$order->address->address}}<br>
                                {{$order->address->city}}, {{$order->address->state}} - {{$order->address->zip}}<br>
                                {{$order->address->country}}.
                            </address>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <address>
                                <strong>@lang('Payment Status:')</strong>
                                {{$order->paid ? __('Paid') : __('Unpaid')}}<br>
                                <strong>@lang('Payment Method:')</strong>
                                {{$order->payment_method}}<br>
                                <strong>@lang('Order Status:')</strong>
                                {{$order->is_processed ? __('Delivered') : __('Pending')}}<br>
                            </address>
                        </div>
                        <div class="col-xs-6 text-right">
                            <address>
                                <strong>@lang('Order Date:')</strong><br>
                                {{$order->created_at->toFormattedDateString()}}<br><br>
                            </address>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><strong>@lang('Order summary')</strong></h3>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-condensed table-bordered">
                                    <thead>
                                        <tr>
                                            <td><strong>@lang('Item')</strong></td>
                                            <td class="text-center"><strong>@lang('Price')</strong></td>
                                            <td class="text-center"><strong>@lang('Quantity')</strong></td>
                                            <td class="text-right"><strong>@lang('Total')</strong></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->products as $product)
                                            <tr>
                                                <td>{{$product->name}}
                                                    @if($product->pivot->spec && ($specs = unserialize($product->pivot->spec)))
                                                        <br>
                                                        @foreach($specs as $key => $spec)
                                                            <em>{{$spec['name']}}:</em> {{$spec['value']}}@if(!$loop->last), @endif
                                                        @endforeach
                                                    @endif
                                                    <br>@lang('SKU'):<strong>{{$product->sku}}</strong>
                                                </td>
                                                <td class="text-center">{{currency_format($product->pivot->unit_price, $order->currency)}}</td>
                                                <td class="text-center">{{$product->pivot->quantity}}</td>
                                                <td class="text-right">{{currency_format($product->pivot->total, $order->currency)}}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td class="thick-line"></td>
                                            <td class="thick-line"></td>
                                            <td class="thick-line text-center"><strong>@lang('Subtotal')</strong></td>
                                            <td class="thick-line text-right">{{currency_format($order->total, $order->currency)}}</td>
                                        </tr>
                                        <tr>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line text-center"><strong>@lang('Tax')</strong></td>
                                            <td class="no-line text-right">+ {{$order->tax}} %</td>
                                        </tr>
                                        <tr>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line text-center"><strong>@lang('Shipping Cost')</strong></td>
                                            <td class="no-line text-right">{{isset($order->shipping_cost) ? currency_format($order->shipping_cost, $order->currency) : currency_format(0, $order->currency)}}</td>
                                        </tr>
                                        @if($order->coupon_amount && $order->coupon_amount > 0)
                                        <tr>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line text-center"><strong>@lang('Coupon Discount')</strong></td>
                                            <td class="no-line text-right">{{ currency_format($order->coupon_amount, $order->currency) }} </td>
                                        </tr>
                                        @endif
                                        @if($order->wallet_amount && $order->wallet_amount > 0)
                                        <tr>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line text-center"><strong>@lang('Wallet Used')</strong></td>
                                            <td class="no-line text-right">{{ currency_format($order->wallet_amount, $order->currency) }} </td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td class="no-line"></td>
                                            <td class="no-line"></td>
                                            <td class="no-line text-center"><strong>@lang('Total')</strong></td>
                                            <td class="no-line text-right">{{currency_format($order->shipping_cost + $order->total - $order->wallet_amount - $order->coupon_amount + ($order->total * $order->tax) / 100, $order->currency)}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>

        {!! Form::model($order, ['method'=>'patch', 'action'=>['ManageOrdersController@update', $order->id], 'id'=>'update-form-'.$order->id]) !!}

        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            {!! Form::label('status', __('Current Status:')) !!}
            {!! Form::textarea('status', null, ['class'=>'form-control', 'placeholder'=>__('Enter current status')])!!}
        </div>

        @if(count($order->shipments) > 0)
        <div class="row bs-wizard" style="border-bottom:0;">
        @foreach($order->shipments as $shipment)
            @if($order->shipments->contains($shipment->id))
            <div class="col-xs-3 bs-wizard-step complete">
              <div class="text-center bs-wizard-stepnum">{{$shipment->name}}</div>
              <div class="progress"><div class="progress-bar"></div></div>
              <a href="#" class="bs-wizard-dot"></a>
              <div class="bs-wizard-info text-center">{{$shipment->address. ', ' .$shipment->city. ', ' .$shipment->state. ' - ' .$shipment->zip. ' ' .$shipment->country}}
              <br>
              {{$shipment->created_at->toCookieString()}}
              </div>
            </div>
            @endif
        @endforeach
        </div>
        <hr>
        @endif

        <div class="form-group" id="shipment_box">
            <div class="shipment_box">
                <label for="shipment">@lang('Pass to Shipment Location:')</label>
                <select style="display:none" name="shipment" id="shipment">
                    <option value="">------- @lang('Select Shipment') -------</option>
                    @foreach($shipments as $shipment)
                        @if(!$order->shipments->contains($shipment->id))
                            <option value="{{$shipment->id}}">{{$shipment->name}} {{'@ ' .$shipment->address. ', ' .$shipment->city. ', ' .$shipment->state. ' - ' .$shipment->zip. ' ' .$shipment->country .' ('. __('ID:') . ' '.$shipment->id.')'}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>

        <hr>

        @if($order->payment_method == 'Bank Transfer')
        <div class="row">
            <div class="col-md-12">
                <strong>@lang('Transaction Reference ID'):</strong>
                <br>
                {{$order->transaction_id}}
                @if(!$order->paid)
                <div class="checkbox" id="is-paid">
                    <label>{!! Form::checkbox('is_paid', 1 , false, ['id'=>'is_paid']); !!} <strong class="text-primary">@lang('Confirm Payment')</strong></label>
                </div>
                @else
                <div class="text-primary"><strong>@lang('Payment Confirmed')</strong></div>
                @endif
            </div>
        </div>
        <hr>
        @endif

        <div class="row">
            <div class="col-md-6">
                <div class="checkbox" id="delivered-box">
                    <label>{!! Form::checkbox('is_processed', 1 , false, ['id'=>'delivered']); !!} <strong class="text-success">@lang('Mark as Delivered?')</strong></label>
                </div>
            </div>
            @if(!$order->stock_regained)
            <div class="col-md-6">
                <div class="checkbox" id="not-delivered-box">
                    <label class="pull-right">{!! Form::checkbox('regain_stock', 1 , false, ['id'=>'not-delivered']); !!} <strong class="text-danger">@lang('Mark as Not Delivered? (Regain Stock)')</strong></label>
                </div>
            </div>
            @endif
        </div>
        <hr>

        <div id="receiver_detail_box">
            <div class="form-group{{ $errors->has('receiver_detail') ? ' has-error' : '' }}">
                {!! Form::label('receiver_detail', __('Receiver Detail:')) !!}
                {!! Form::textarea('receiver_detail', null, ['class'=>'form-control', 'placeholder'=>__('Enter receiver detail'), 'rows'=>4])!!}
            </div>
            <hr>
        </div>

        <a href="" class='btn btn-primary col-xs-6 col-sm-6 pull-left'
            onclick="
                    if(confirm('@lang('Are you sure you want to update this?')')) {
                    event.preventDefault();
                    $('#update-form-{{$order->id}}').submit();
                    } else {
                    event.preventDefault();
                    }
                    "
            >@lang('Update')</a>

        {!! Form::close() !!}

    </div>
</div>