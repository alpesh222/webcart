{{--'Frontend Should die HERE'--}}
<!DOCTYPE html>
<html lang="{{config('app.locale')}}">
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

    <link rel="stylesheet" href="{{asset(theme_url('/css/main.css'))}}">
    <link rel="stylesheet" href="{{asset(theme_url('/css/blue.css'))}}">
    <link rel="stylesheet" href="{{asset(theme_url('/css/owl.carousel.css'))}}">
    <link rel="stylesheet" href="{{asset(theme_url('/css/owl.transitions.css'))}}">
    <link rel="stylesheet" href="{{asset(theme_url('/css/animate.min.css'))}}">
    <link rel="stylesheet" href="{{asset(theme_url('/css/rateit.css'))}}">
    <link rel="stylesheet" href="{{asset(theme_url('/css/bootstrap-select.min.css'))}}">
    <link rel="stylesheet" href="{{asset(theme_url('/css/lightbox.css'))}}">
    <link rel="stylesheet" href="{{asset(theme_url('/css/font-awesome.css'))}}">

    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600,600italic,700,700italic,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

    @yield('styles')

    @if(config('settings.enable_google_translation'))
        <link href="{{asset('css/google-translate.css')}}?v=1.0" rel="stylesheet">
    @endif

    <style>
        .navbar-header {
            {{--background: {{config('settings.site_logo_colour')}};--}}
            background: transparent;
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
<body class="cnt-home">
<div id="cover-spin"></div>

    <!-- ============================================== HEADER ============================================== -->
    <header class="header-style-1">
        @include('partials.front.theme-header')
        @include('partials.front.theme-navbar')
    </header>
    @yield('above_content')
    <div class="body-content outer-top-xs" id="top-banner-and-menu">
        <div class="container">
            <div class="row">
                @include('includes.front.header-alerts')

                @yield('sidebar')

                @yield('content')
            </div>
            {{--  Brands Slider  --}}
            @if(config('settings.brands_slider_enable'))
                @include('partials.front.sliders.brands-slider')
            @endif
        </div>
    </div>

    @yield('footer')
    @include('partials.front.footer')


<script src="{{asset('js/libs.js')}}"></script>
{{--<script src="{{asset('js/front.js')}}"></script>--}}

@include('includes.front.footer-toaster')

<script src="{{asset('js/jquery-ui.min.js')}}"></script>

@include('includes.front.live-chat-widget')

<script src="{{asset(theme_url('/js/bootstrap-hover-dropdown.min.js'))}}"> </script>
<script src="{{asset(theme_url('/js/owl.carousel.min.js'))}}"></script>
<script src="{{asset(theme_url('/js/echo.min.js'))}}"></script>
<script src="{{asset(theme_url('/js/jquery.easing-1.3.min.js'))}}"></script>
<script src="{{asset(theme_url('/js/bootstrap-slider.min.js'))}}"></script>
<script src="{{asset(theme_url('/js/jquery.rateit.min.js'))}}"></script>
<script src="{{asset(theme_url('/js/lightbox.min.js'))}}"></script>
<script src="{{asset(theme_url('/js/bootstrap-select.min.js'))}}"></script>
<script src="{{asset(theme_url('/js/wow.min.js'))}}"></script>
<script src="{{asset(theme_url('/js/scripts.js'))}}"></script>

@yield('scripts')

</body>
</html>