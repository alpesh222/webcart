@extends('layouts.front')

@section('title'){{$deal->meta_title ? $deal->meta_title : $deal->name." - ".config('app.name')}}@endsection
@section('meta-tags')<meta name="description" content="{{$deal->meta_desc ? $deal->meta_desc : (StringHelper::truncate(trim(strip_tags($deal->description)), 160) ? StringHelper::truncate(trim(strip_tags($deal->description)), 160) : __('Showing Products for:') .$deal->name)}}">
@if($deal->meta_keywords)<meta name="keywords" content="{{$deal->meta_keywords}}">@endif
@endsection
@section('meta-tags-og')<meta property="og:url" content="{{url()->current()}}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{$deal->meta_title ? $deal->meta_title : $deal->name.' - '.config('app.name')}}" />
    <meta property="og:description" content="{{$deal->meta_desc ? $deal->meta_desc : (StringHelper::truncate(trim(strip_tags($deal->description)), 160) ? StringHelper::truncate(trim(strip_tags($deal->description)), 160) : __('Showing Products for:') .$deal->name)}}" />
@endsection

@section('scripts')
    @include('includes.products-pagination-script')
    @include('includes.cart-submit-script')
@endsection

@section('content')
<div class="wrapper2">
<div class="margin-60"> </div>
    @include('partials.front.products')
</div>
@endsection