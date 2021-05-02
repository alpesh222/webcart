@extends('layouts.front')

@section('title')@lang('Shopping Cart') - {{config('app.name')}}@endsection
@section('meta-tags')<meta name="description" content="@lang('View your Shopping Cart')">
@endsection
@section('meta-tags-og')<meta property="og:url" content="{{url()->current()}}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="@lang('Shopping Cart') - {{config('app.name')}}" />
    <meta property="og:description" content="@lang('View your Shopping Cart')" />
    <meta property="og:image" content="{{url('/img/'.config('settings.site_logo'))}}" />
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
        @media(max-width: 991px) {
            .big-col {
                min-width:250px
            }
        }
        .img-box img{
            height: 80px;
            width: auto!important;
        }
        .product-image{
            width:100%!important;
        }
    </style>
    <style>
        table {
          border: 1px solid #ccc;
          border-collapse: collapse;
          margin: 0;
          padding: 0;
          width: 100%;
          table-layout: fixed;
        }
        table caption {
          font-size: 1.5em;
          margin: .5em 0 .75em;
        }
        table tr {
          background: #fff;
          border: 1px solid #ddd;
          padding: .35em;
        }
        table th,
        table td {
          padding: .625em;
          text-align: center;
        }
        table th {
          font-size: .85em;
          letter-spacing: .1em;
          text-transform: uppercase;
        }
        @media screen and (max-width: 600px) {
          table {
            border: 0;
          }
          table caption {
            font-size: 1.3em;
          }
          table thead {
            border: none;
            clip: rect(0 0 0 0);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
          }
          table tr {
            border-bottom: 3px solid #ddd;
            display: block;
            margin-bottom: .625em;
          }
          table td {
            border-bottom: 1px solid #ddd;
            display: block;
            font-size: .8em;
            text-align: right;
          }
          table td:before {
            content: attr(data-label);
            float: left;
            font-weight: bold;
            text-transform: uppercase;
          }
          table td:last-child {
            border-bottom: 0;
          }
        }
		.input-group.pull-right.input-group-sm {
		    z-index: 0;
		}
        @media (max-width:768px) {
            .cart-container table tr {
               display: table-row-group;
            }
        }
    </style>
@endsection

@section('scripts')
    <script>
        toastr.options.closeButton = true;
        @if(session()->has('payment_fail'))
            toastr.error("{{session('payment_fail')}}");
        @endif
    </script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
        	<ul class="breadcrumb">
        		<li><a href="{{url('/')}}">@lang('Home')</a></li>
        		<li>@lang('Shopping Cart')</li>
        	</ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 cart-container">
            @include('partials.front.includes.cart')
        </div>
    </div>
</div>
@endsection
