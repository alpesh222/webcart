@extends('layouts.front')

@section('title'){{$keyword}} - {{config('app.name')}}@endsection
@section('meta-tags')<meta name="description" content="@lang('Showing Search Results for'): {{$keyword}}">
@endsection
@section('meta-tags-og')<meta property="og:url" content="{{url()->current()}}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{$keyword}} - {{config('app.name')}}" />
    <meta property="og:description" content="@lang('Showing Search Results for'): {{$keyword}}" />
@endsection

@section('scripts')
    @include('includes.products-pagination-script')
    @include('includes.cart-submit-script')
@endsection

@section('content')
<div class="wrapper2">
    <div class="row">
        <div class="col-md-12">
            <h3 class="text-muted">@lang('Showing Search Results for') "{{$keyword}}"</h3>
            <hr>
        </div>
    </div>
    @include('partials.front.products')
</div>
@endsection
