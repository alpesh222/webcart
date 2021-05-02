@extends('layouts.front')

@section('title')
    @lang('Account Overview') - {{config('app.name')}}
@endsection

@section('meta-tags')
    <meta name="description" content="@lang('User Account Overview')">
@endsection

@section('meta-tags-og')
    <meta property="og:url" content="{{url()->current()}}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@lang('User Account Overview') - {{config('app.name')}}" />
    <meta property="og:description" content="@lang('User Account Overview')" />
    <meta property="og:image" content="{{url('/img/'.config('settings.site_logo'))}}" />
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
                    <li class="active">@lang('My Account')</li>
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
            <div class="shopping-cart user_account_dashboard">
                <div class="page-title">
                    <h2>@lang('Account Overview')</h2>
                </div>
                <div class="content-panel">
                    <div class="col-md-4">
                        <div class="well">
                            <h4><i class="fa fa-file-text-o"> </i> @lang('Your Orders')</h4>
                            <hr>
                            <a href="{{route('front.orders.index')}}">@lang('View Orders') <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="well">
                            <h4><i class="fa fa-home"> </i> @lang('Your Addresses')</h4>
                            <hr>
                            <a href="{{route('front.addresses.index')}}">@lang('View Addresses') <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="well">
                            <h4><i class="fa fa-user"> </i> @lang('Your Profile')</h4>
                            <hr>
                            <a href="{{route('front.settings.profile')}}">@lang('View Profile') <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection