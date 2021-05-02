<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@lang('Maintenance')</title>
    <link href="{{asset('css/libs.css')}}" rel="stylesheet">
    <style>
        body {
            background-color: #e5e5e5;
        }
        .page-error {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            min-height: 100vh;
        }

        .page-error h1 {
            margin: 10px;
            color: #F44336;
            font-size: 42px;
        }
    </style>
</head>
<body>
<div class="page-error">
    <h1><i class="fa fa-wrench"></i> @lang('Site is down for Maintenance')</h1>
    @if(Auth::check())
        <a onclick="logout();" href="#">@lang('Logout') <i class="fa fa-sign-out"></i></a>
        <form id="logout_form" action="{{ route('logout') }}" method="POST">
            {{ csrf_field() }}
        </form>
        <script>
            function logout() {
                var logoutForm = $('#logout_form');
                if (!logoutForm.hasClass('form-submitted')) {
                    logoutForm.addClass('form-submitted');
                    logoutForm.submit();
                }
            }
        </script>
    @endif
</div>
{{-- LIBS SCRIPTS BUNDLE --}}
<script src="{{asset('js/libs.js')}}"></script>
</body>
</html>
