<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@lang('Unauthorized')</title>
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
        <h1><i class="fa fa-exclamation-circle"></i> @lang('Error 403')</h1>
        <p>@lang('You are not authorized.')</p>
        <p><a href="javascript:window.history.back();">@lang('Go back to previous page')</a></p>
    </div>
</body>
</html>
