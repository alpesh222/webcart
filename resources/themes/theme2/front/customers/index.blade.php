@extends('layouts.front')

@section('title')
    @lang('Shipping Addresses') - {{config('app.name')}}
@endsection

@section('meta-tags')
    <meta name="description" content="@lang('View And Update Shipping Addresses')">
@endsection

@section('meta-tags-og')
    <meta property="og:url" content="{{url()->current()}}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@lang('Shipping Addresses') - {{config('app.name')}}" />
    <meta property="og:description" content="@lang('View And Update Shipping Addresses')" />
    <meta property="og:image" content="{{url('/img/'.config('settings.site_logo'))}}" />
@endsection

@section('styles')
    <style>
        table a:not(.btn), .table a:not(.btn) {
            text-decoration: none;
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

        .btn-area .btn {
            padding: 4px 10px;
        }
    </style>
@endsection

@section('sidebar')
    @include('includes.user-account-sidebar')
@endsection

@section('above_content')
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{url('/')}}">@lang('Home')</a></li>
                    <li class="active">@lang('Shipping Addresses')</li>
                </ul>
            </div>
            <!-- /.breadcrumb-inner -->
        </div>
        <!-- /.container -->
    </div>
    <!-- /.breadcrumb -->
@endsection

@section('content')
    <div class="col-md-9 user_account">
        <div class="shopping-cart">
            <div class="page-title">
                <h2>@lang('Your Addresses')</h2>
            </div>
            @if(session()->has('address_deleted'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{session('address_deleted')}}
                </div>
            @endif
            @if(count($customers) > 0)
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
                            <a class="btn btn-primary btn-xs pull-left"
                               href="{{route('front.addresses.edit', $customer->id)}}">@lang('Edit')</a>
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
            @else
                <div class="row text-center">
                    <div class="empty-bag">
                        <div class="empty-bag-icon">
                            <img src="{{asset('/img/icons/address.png')}}" class="img-responsive m-a" alt="@lang('No Order History')" width="100">
                        </div>
                        <h3 class="text-center text-muted">@lang('NO ORDERS HISTORY FOUND')</h3>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
