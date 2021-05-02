@extends('layouts.front')

@section('title')
    @lang('User Wallet History') - {{config('app.name')}}
@endsection

@section('meta-tags')
    <meta name="description" content="@lang('User Wallet History')">
@endsection

@section('meta-tags-og')
    <meta property="og:url" content="{{url()->current()}}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@lang('User Wallet History') - {{config('app.name')}}" />
    <meta property="og:description" content="@lang('User Wallet History')" />
    <meta property="og:image" content="{{url('/img/'.config('settings.site_logo'))}}" />
@endsection

@section('styles')
    @include('includes.order_tracker_style')
    <style>
        .orders-details-inner > h3 {
            padding: 6px !important;
            margin: 0px !important;
            font-size: 18px;
            border-bottom: 1px solid #eee;
        }

        .orders-details-inner > ul > li {
            float: left;
            list-style: none;
            margin-bottom: 20px;
            padding: 10px !important;
            border-right: 1px solid #eee;
        }

        .orders-details-inner ul li a {
            color: #333;
            font-size: 16px;
        }

        .orders-details {
            background-color: #f9f9f9;
            padding: 15px;
            margin-top: 15px;
        }

        .bar1, .bar2, .bar3 {
            width: 22px;
            height: 3px;
            background-color: #333;
            margin: 4px 0;
            transition: 0.4s;
        }

        .change .bar1 {
            -webkit-transform: rotate(-45deg) translate(-7px, 3px);
            transform: rotate(-45deg) translate(-7px, 3px);
        }

        .change .bar2 {
            opacity: 0;
        }

        .change .bar3 {
            -webkit-transform: rotate(45deg) translate(-7px, -3px);
            transform: rotate(45deg) translate(-7px, -3px);
        }

        .btn-toggle-close a {
            margin-top: 20px !important;
            display: block;
        }

        .orders-details-inner-sub-2 {
            margin-top: 15px;
        }

        .orders-details-inner-sub-2 img {
            width: 60px;
            float: left;
            margin-right: 15px;
        }

        .orders-details-inner-sub-2 h4 a {
            color: #888;
        }

        .orders-details-inner-sub-2 p {
            padding-top: 0px;
            font-size: 14px;
            color: #333;
        }

        @media (max-width: 767px) {
            .orders-details-inner-sub-2 {
                height: 100%;
                display: block;
                margin: 40px auto;
            }
        }

        .panel-body-row {
            text-align: left;
        }

        .img-box {
            text-align: center;
        }

        .img-box .product-img {
            height: 80px;
            width: auto !important;
        }

        .product-img {
            width: 100% !important;
        }

        .grand-total p {
            text-align: left;
            padding: 0px;
        }

        .panel-heading, .panel-body {
            border: 1px solid #e5e5e5;
        }

        .panel-heading {
            border-bottom: none;
        }

        .orders-details {
            border: 1px solid #158cba;
            border-radius: 5px;
        }

        .media-body {
            text-align: center;
        }

        .order_detail_item_name {
            color: #444;
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
                    <li class="active">@lang('Wallet History')</li>
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
                <h2>@lang('Wallet History')
                    <button type="button" class="btn btn-primary pull-right device-none mt-minus-3">
                        Current Balance : {{ currency_format($user_wallet_bal->wallet_balance, config('currency.default') )}}
                    </button></h2>

            </div>
            <div class="content-panel">
                <div class="col-md-12 panel-heading">
                    <div class="col-md-1 device-none">
                        <h4></h4>
                    </div>
                    <div class="col-md-2 col-xs-4">
                        <h4> @lang('Txn Id') </h4>
                    </div>
                    <div class="col-md-2 col-xs-6">
                        <h4> @lang('Txn Amount') </h4>
                    </div>
                    <div class="col-md-4 col-xs-6 device-none">
                        <h4> @lang('Description') </h4>
                    </div>
                    <div class="col-md-2 device-none">
                        <h4>@lang('Txn Date') </h4>
                    </div>
                    <div class="col-md-1 col-xs-2 ">
                    </div>
                </div>
                @if(count($user_wallet_history) > 0)
                    @foreach($user_wallet_history as $key => $wallet)
                    <div class="col-md-12 panel-body">
                        <div class="panel-body-row">
                            <div class="col-md-1 device-none">
                                <h4> {{$key+1}} </h4>
                            </div>
                            <div class="col-md-2 col-xs-4">
                                <h4>
                                    <a class="" onclick="myFunction(this)" class="btn-toggle-close"
                                       data-toggle="collapse" href="#multiCollapseExample{{$key+1}}"
                                       aria-expanded="false" aria-controls="multiCollapseExample{{$key+1}}">
                                        #TXN-{{ StringHelper::preZero($wallet->wallet_id)}}
                                    </a>
                                </h4>
                            </div>
                            <div class="col-md-2 col-xs-6 device-none text-center">
                                <h4>
                                    @if(!empty($wallet->credit_amt) && $wallet->debit_amt == 0)
                                        <span class="text-success">{{currency_format($wallet->transaction_amt,$wallet->transaction_currency)}}</span>
                                    @else
                                        <span class="text-danger">{{currency_format($wallet->transaction_amt,$wallet->transaction_currency)}}</span>
                                    @endif
                                </h4>
                            </div>
                            <div class="col-md-4 col-xs-6">
                                <strong>{{$wallet->transaction_description}}</strong>
                            </div>


                            <div class="col-md-2 device-none">
                                <h4> {{$wallet->created_at->toFormattedDateString()}} </h4>
                            </div>

                            <div class="col-md-1 col-xs-2 btn-toggle-close">
                                <a class="" onclick="myFunction(this)" class="btn-toggle-close" data-toggle="collapse"
                                   href="#multiCollapseExample{{$key+1}}" aria-expanded="false"
                                   aria-controls="multiCollapseExample{{$key+1}}">
                                    <div class="bar1"></div>
                                    <div class="bar2"></div>
                                    <div class="bar3"></div>
                                </a>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-12 multi-collapse collapse" id="multiCollapseExample{{$key+1}}"
                             aria-expanded="false" style="height: 0px;">
                            <div class="orders-details">
                                <div class="orders-details-inner">
                                    <h3><strong> @lang('Txn Id') : #TXN-{{StringHelper::preZero($wallet->wallet_id)}} </strong></h3>
                                </div>
                                <div class="clearfix"></div>

                                <div class="col-md-6 grand-total">
                                    <p><strong>@lang('Transaction Action:')</strong>
                                        @if(!empty($wallet->credit_amt) && $wallet->debit_amt == 0)
                                            <strong class="text-success">@lang('Credit')</strong>
                                        @else
                                            <strong class="text-danger">@lang('Debit')</strong>
                                        @endif
                                    </p>
                                    <hr>
                                    <p><strong>@lang('Currency :')</strong> {{$wallet->transaction_currency}} </p>
                                    <hr>
                                    <p><strong>@lang('Transaction Date :')</strong> {{ $wallet->created_at }} </p>
                                    <hr>
                                </div>
                                <div class="col-md-4 grand-total">
                                    <div class="pull-right">
                                        <p><strong>@lang('Transaction Amount :')</strong> {{currency_format($wallet->transaction_amt, $wallet->transaction_currency)}}
                                        </p>
                                        <p><strong>@lang('Transaction Description :')</strong> {{$wallet->transaction_description}} </p>
                                        <p><strong>@lang('Wallet Balance :')</strong> {{currency_format($wallet->wallet_balance, $wallet->transaction_currency)}} </p>
                                        <hr>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>

                    </div>
                @endforeach
                 @else
                    <div class="row text-center">
                        <div class="empty-bag">
                            <div class="empty-bag-icon">
                                <img src="{{asset('/img/icons/wallet-512.png')}}" class="img-responsive m-a" alt="@lang('No Wallet History')" width="100">
                            </div>
                            <h3 class="text-center text-muted">@lang('NO WALLET HISTORY FOUND')</h3>
                        </div>
                    </div>
                @endif
                    @if(count($user_wallet_history))
                    <div class="text-right">
                        {{$user_wallet_history->links()}}
                    </div>
                    @endif

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function myFunction(x) {
            x.classList.toggle("change");
        }
    </script>
@endsection
