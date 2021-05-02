@extends('layouts.front')

@section('title'){{$page->meta_title ? $page->meta_title : $page->title." - ".config('app.name')}}@endsection
@section('meta-tags')<meta name="description" content="{{$page->meta_desc ? $page->meta_desc : StringHelper::truncate(trim(strip_tags($page->content)), 160)}}">
@if($page->meta_keywords)<meta name="keywords" content="{{$page->meta_keywords}}">@endif
@endsection
@section('meta-tags-og')<meta property="og:url" content="{{url()->current()}}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{$page->meta_title ? $page->meta_title : $page->title.' - '.config('app.name')}}" />
    <meta property="og:description" content="{{$page->meta_desc ? $page->meta_desc : StringHelper::truncate(trim(strip_tags($page->content)), 160)}}" />
@endsection

@section('styles')
	@if(strlen($page->content) < 100)
	<style>
		#myFooter {
		    bottom: -400px;
		    position: relative
		}
	</style>
	@endif
@endsection

@section('content')
<br>
<div class="container">
	<div class="row">
		<div class="col-md-12 about-us-page">
			<h1 class="about-title_h1"><span> {{ $page->title }} </span></h1>
			<div class="page-content">
				{!! $page->content !!}
			</div>
		</div>
	</div>
</div>
@endsection
