@extends('layouts.front')

@section('title')
    @lang('Resend Activation Email') - {{config('app.name')}}
@endsection

@section('styles')
    <style>
        #myFooter {
            bottom: -100px;
            position: relative
        }
    </style>
@endsection

@section('content')
    <div class="text-center">
        <div class="col-md-12">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <br/><br/>
            <h2> {{config('app.name')}} : @lang('Resend Activation Email')</h2>
            <h5>( @lang('Resend Activation Email') )</h5>
            <br/>
        </div>
    </div>
    <div>
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>@lang('Enter your email to resend activation email')</strong>
                </div>
                <div class="panel-body">
                    <form onsubmit="login();" method="POST" action="{{ route('auth.activate.resend') }}">
                        {{ csrf_field() }}
                        <br/>
                        <div class="form-group input-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                            <input required type="email" name="email" class="form-control" placeholder="@lang('Enter your email')"/>
                        </div>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong class="text-danger">
                                    {{ $errors->first('email') }}
                                </strong>
                            </span>
                        @endif
                        <button id="resend-button" type="submit" class="btn btn-primary btn-block">@lang('Resend')</button>
                        <hr />
                        @lang('Not Register ?') <a href="{{url('/register')}}" >@lang('Click here') </a>
                    </form>
                    <script>
                        function login() {
                            $('#resend-button')
                                .text('{{__('Please Wait...')}}')
                                .prop('disabled', true);
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
@endsection
