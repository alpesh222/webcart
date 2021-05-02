@extends('layouts.manage')

@section('title')
    @lang('Edit Category')
@endsection

@section('page-header-title')
    @lang('Edit Category') <a class="btn btn-sm btn-info" href="{{route('manage.categories.index')}}">@lang('View Categories')</a>
@endsection

@section('page-header-description')
    @lang('Edit Category') <a href="{{route('manage.categories.index')}}">@lang('Go Back')</a>
@endsection

@section('styles')
    <style>
        .bolden {
            font-family: "Arial Black";
        }
    </style>
    <link href="{{asset('css/jquery.dropdown.min.css')}}" rel="stylesheet">        
@endsection

@section('scripts')
    <script src="{{asset('js/jquery.dropdown.min.js')}}"></script>
    <script>
        $('.category_box').dropdown({
                // options here
        });
        $('.specification_type_box').dropdown({
                // options here
        });
    </script>
    @if(config('settings.toast_notifications_enable'))
    <script>
        toastr.options.closeButton = true;
        @if(session()->has('category_updated'))
            toastr.success("{{session('category_updated')}}");
        @endif
    </script>
    @endif
@endsection

@section('content')
    @include('partials.manage.categories.edit')
@endsection