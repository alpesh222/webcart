@extends('layouts.front')

@section('title')@lang('Shipping Addresses') - {{config('app.name')}}@endsection

@section('sidebar')
    <div>
        @include('partials.front.sidebar')
    </div>
@endsection

@section('styles')
    <style>
        table a:not(.btn), .table a:not(.btn) {
            text-decoration: none;
        }
        .cart-header {
            font-size: 1.1em;
        }
        .btn-square {
            width: 24px;
            height: 24px;
        }
		.shipin-addres h4 {
			border-bottom: 1px solid #ccc;
			padding-bottom: 10px;
		}
		.shipin-addres strong {
            padding: 10px 0px;
            line-height: 30px;
            font-size: 15px;
		}
		.shipping-address {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 30px;
		}
		.btn-area {
			border-top: 1px solid #ccc;
			padding-top: 15px;
			margin-top: 14px;
		}
		.btn-area .btn{
			padding: 4px 10px;
		}
        #page-inner {
            background-color: #f5f5f5 !important;
        }
    </style>
    <link href="{{asset('css/front-sidebar-content.css')}}" rel="stylesheet">
@endsection

@section('content')
<div id="page-wrapper">
    <div id="page-inner">
        <div class="page-title">
            <h2>@lang('Your Addresses')</h2>
            <hr>

            @if(session()->has('address_deleted'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{session('address_deleted')}}
                </div>
            @endif
            @foreach($customers as $key => $customer)
                <div class="col-md-6">
                    <div class="shipping-address">
                        <h4>{{$key+1}}. @lang('Shipping Address')</h4>
                        <strong>{{$customer->first_name . ' ' . $customer->last_name}}</strong>,<br>
                        {{$customer->address}}<br>
                        {{$customer->city . ', ' . $customer->state . ' - ' . $customer->zip}}<br>
                        {{$customer->country}}.<br>
                        <strong>@lang('Phone:')</strong> {{$customer->phone}}<br>
                        <strong>@lang('Email:')</strong> {{$customer->email}}<br>
                        <div class="btn-area">
                            <a class="btn btn-primary btn-xs pull-left" href="{{route('front.addresses.edit', $customer->id)}}">@lang('Edit')</a>
                            {!! Form::model($customer, ['method'=>'delete', 'action'=>['FrontCustomersController@destroy', $customer->id], 'id'=> 'delete-form-'.$customer->id, 'style'=>'display: none;']) !!}
                            {!! Form::close() !!}
                            <a href="" class='btn btn-xs btn-danger pull-right'
                                onclick="
                                        if(confirm('@lang('Are you sure you want to delete this?')')) {
                                        event.preventDefault();
                                        $('#delete-form-{{$customer->id}}').submit();
                                        } else {
                                        event.preventDefault();
                                        }
                                        "
                                >@lang('Remove')</a>
                            
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
