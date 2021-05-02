<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title')</title>
    {{-- LIBS STYLES BUNDLE --}}
    <link href="{{asset('css/libs.css')}}?v=1.1" rel="stylesheet">
    @include('includes.default-manage-color-settings')
    <link href="{{asset('css/custom/manage-panel.css')}}" rel="stylesheet">
    @if(config('settings.loading_animation_enable'))
    <style>
        #loader {
            border-top: 16px solid #C90000;
            border-bottom: 16px solid #C90000;
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        @-webkit-keyframes spin {
            0% { -webkit-transform: rotate(0deg); }
            100% { -webkit-transform: rotate(360deg); }
        }
        #page-inner {
            opacity: 0;
        }
    </style>
    @endif
    <style>
        .nav-tabs > li > a {
            background-color: #158cba;
            border-color: #127ba3;
            color: #fff;
            transition: 0.3s all;
        }
        .nav-tabs > li > a:hover {
            color: #158cba;
            font-weight: bold;
            border-color: #127ba3;
        }
        .nav-tabs > li.active > a {
            color: #158cba !important;
            font-weight: bold !important;
            border-color: #127ba3 !important;
            border-bottom: none !important;
        }
        .alert-success > a {
            color: #fff;
            font-weight: bold;
        }
        #page-inner {
            min-height: 1500px
        }
    </style>
    @yield('styles')
    @if(config('customcss.css_manage') != "")
    @include('partials.manage.custom-css')
    @endif
    @include('includes.app_url_script')
</head>
@if(config('settings.loading_animation_enable'))
<body onload="myFunction()">
@else
<body>
@endif
<div id="wrapper">
    @include('partials.manage.top-navbar')
    @include('partials.manage.side-navbar')
    <div id="page-wrapper">
        @if(config('settings.loading_animation_enable'))
        <div id="loader"></div>
        @endif
        <div id="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <h2>@yield('page-header-title')</h2>
                    <h5>@yield('page-header-description')</h5>
                </div>
            </div>
            <hr/>

            @yield('content')
        </div>
    </div>
    <div class="custom_manage_footer text-danger">{{date('Y-m-d H-i-s')}}</div>
</div>
@if(config('settings.loading_animation_enable'))
    <script>
        var myVar;
        function myFunction() {
            myVar = setTimeout(showPage, 0);
        }
        function showPage() {
            document.getElementById("loader").style.display = "none";
            document.getElementById("page-inner").style.opacity = 1;
        }
    </script>
@endif
{{-- LIBS SCRIPTS BUNDLE --}}
<script src="{{asset('js/libs.js')}}"></script>
@yield('scripts')
@yield('colorPickerJs')
</body>
</html>
