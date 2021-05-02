<!DOCTYPE html>
<html lang="{{Config::get('app.locale')}}">
<head>
    @if(config('analytics.google_analytics_script') != "")
        @include('partials.front.google-analytics')
    @endif
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{csrf_token()}}">

    @yield('meta-tags')

    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico')}}" type="image/x-icon">
    @yield('meta-tags-og')

    <link href="{{asset('css/libs.css')}}" rel="stylesheet">
    <link href="{{asset('css/front.css')}}" rel="stylesheet">
    <link href="{{asset('css/jquery-ui.min.css')}}" rel="stylesheet">

    @include('includes.front.default-color-settings')
    <link rel="stylesheet" href="{{asset(theme_url('/css/animations.min.css'))}}">
    <link rel="stylesheet" href="{{asset(theme_url('/css/style.css'))}}?v=1.3">
    <link rel="stylesheet" href="{{asset(theme_url('/css/front-user-dashboard.css'))}}">

    @yield('styles')

    @if(config('settings.enable_google_translation'))
        <link href="{{asset('css/google-translate.css')}}?v=1.0" rel="stylesheet">
    @endif
        <style>
            .content-wrapper {
                margin: 0 auto;
                max-width: 1680px;
            }
            .wrapper {
                background-color: #fff;
            }
            .navbar-header {
                background: {{config('settings.site_logo_colour')}};
            }
            #site-logo {
                max-width: {{config('settings.site_logo_width')}};
                max-height: {{config('settings.site_logo_height')}};
            }
            @if(config('settings.hide_main_slider_in_devices'))
                @media(max-width: 768px) {
                .banner-main-image {
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    max-width: 100%;
                    max-height: 100%;
                    opacity: 0;
                    transform: translate(-50%,-50%);
                    transition: opacity .3s linear;
                }
            }
            @endif
        </style>

    <link href="{{asset('css/custom/front-custom-panel.css')}}" rel="stylesheet">

    @if(config('customcss.css_front') != "")
        @include('partials.front.custom-css')
    @endif
    @include('includes.app_url_script')
</head>
<body>
<div id="cover-spin"></div>

    @include('includes.theme-header')
    <div class="main-wrapper wrapper-cont">
        @yield('sidebar')

        @yield('above_container')

        @yield('content')
    </div>
    @include('partials.front.footer')
    @yield('footer')

<script src="{{asset('js/libs.js')}}"></script>
<script src="{{asset('js/front.js')}}"></script>

@include('includes.front.footer-toaster')

<script src="{{asset('js/jquery-ui.min.js')}}"></script>

@include('includes.front.live-chat-widget')

<script type="text/javascript" href="{{asset(theme_url('/js/animations.min.js'))}}"> </script>
<script src="{{asset(theme_url('/js/script.js'))}}?v=1.8"></script>

@yield('scripts')

</body>
</html>