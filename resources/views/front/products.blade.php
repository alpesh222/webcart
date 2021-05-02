@extends('layouts.front')

@section('title')@lang('Products') - {{config('app.name')}}@endsection
@section('meta-tags')<meta name="description" content="@lang('Showing all Products')">
@endsection
@section('meta-tags-og')<meta property="og:url" content="{{url()->current()}}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Products - {{config('app.name')}}" />
    <meta property="og:description" content="@lang('Showing all Products')" />
@endsection

@section('scripts')
    @include('includes.products-pagination-script')
    @include('includes.cart-submit-script')
@endsection

@section('content')
<div class="wrapper2">
    <div class="row">
        <div class="col-md-12">
            <div class="well well-sm text-center">
                <h4>@lang('Showing all Products')</h4>
            </div>
            <hr>
        </div>
    </div>
    @include('partials.front.products')
</div>
@endsection