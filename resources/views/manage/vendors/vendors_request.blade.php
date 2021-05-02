@extends('layouts.manage')

@section('title')
    @lang('View Vendors Request')
@endsection

@section('page-header-title')
    @lang('View Vendors Request')
@endsection

@section('page-header-description')
    @lang('View and Pay Vendors Request')
@endsection

@section('content')
@if(Auth::user()->can('read', App\Vendor::class) && Auth::user()->can('update', App\Vendor::class))
    <div class="row">
        <div class="col-md-12">
{{--            <h4>@lang('Recent Requests from Vendor for Payouts')</h4>--}}
            <div class="vendor-requests-payout table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>@lang('Request Date')</th>
                        <th>@lang('Shop Name')</th>
                        <th>@lang('Company Name')</th>
                        <th>@lang('Phone')</th>
                        <th>@lang('Action')</th>
                    </tr>
                    </thead>

                    <tbody>
                    @if(count($vendor_all_requests) > 0)
                        @foreach($vendor_all_requests as $vendor_request)
                            <tr>
                                <td>{{$vendor_request->created_at->format('d-m-Y h:i A')}}</td>
                                <td>{{$vendor_request->vendor->shop_name}}</td>
                                <td>{{$vendor_request->vendor->name}}</td>
                                <td>{{$vendor_request->vendor->phone ? $vendor_request->vendor->phone : '-'}}</td>
                                <td>
                                    <a href="{{route('manage.vendors.show', ['vendor' => $vendor_request->vendor->id])}}">
                                        @lang('Make Payment')
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="text-center">@lang('No payout request found.')</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="text-right">
                {{$vendor_all_requests->links()}}
            </div>
        </div>
    </div>
    <hr>
@endif
@endsection('content')