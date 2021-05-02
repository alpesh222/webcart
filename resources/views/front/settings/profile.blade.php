@extends('layouts.front')

@section('title')@lang('Profile Settings') - {{config('app.name')}}@endsection

@section('page-header-title')
    @lang('Profile Settings')
@endsection

@section('page-header-description')
    @lang('View or Change Profile Settings')
@endsection

@section('sidebar')
    <div>
        @include('partials.front.sidebar')
    </div>
@endsection

@section('styles')
    <link href="{{asset('css/front-sidebar-content.css')}}" rel="stylesheet">
    <style>
        #page-inner {
            background-color: #f5f5f5 !important;
        }
    </style>
@endsection

@section('content')
<div id="page-wrapper">
    <div id="page-inner">
        <div class="page-title">
            <h2>@lang('Profile Settings')</h2>
            <hr>
            @if(session()->has('profile_updated'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{session('profile_updated')}}
                </div>
            @endif
            @include('includes.form_errors')

            <div class="col-lg-6 col-md-8 col-sm-12">
                {!! Form::model($user, ['method'=>'patch', 'action'=>['FrontSettingsController@updateProfile'], 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "'. __('Please Wait...') . '"; return true;', 'id'=>'update-profile-form']) !!}

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    {!! Form::label('name', __('Name:')) !!}
                    {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>__('Enter name'), 'required'])!!}
                </div>

                <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                    {!! Form::label('username', __('Username:')) !!}
                    {!! Form::text('username', null, ['class'=>'form-control', 'placeholder'=>__('Enter username'), 'required'])!!}
                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    {!! Form::label('email', __('Email:')) !!}
                    {!! Form::email('email', null, ['class'=>'form-control', 'placeholder'=>__('Enter email'), 'required']) !!}
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    {!! Form::label('password', __('Password:')) !!}
                    {!! Form::password('password', ['class'=>'form-control', 'placeholder'=>__('Enter password')]) !!}
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    {!! Form::label('password_confirmation', __('Confirm Password:')) !!}
                    {!! Form::password('password_confirmation', ['class'=>'form-control', 'placeholder'=>__('Enter password again')]) !!}
                </div>

                <div class="form-group">
                    {!! Form::submit(__('Update Profile'), ['class'=>'btn btn-primary btn-block', 'name'=>'submit_button', 'id'=>'update_btn']) !!}
                </div>

                {!! Form::close() !!}
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        var updateProfileForm = $('#update-profile-form');
        var oldEmail = updateProfileForm.find('input[name="email"]').val();
        $(document).on('click', '#update_btn', function(event) {
            event.preventDefault();
            var newEmail = updateProfileForm.find('input[name="email"]').val();
            if(oldEmail != newEmail) {
                if(confirm('@lang('You have requested to change your email. An activation link will be sent to') "' + newEmail + '". @lang('You are going to logout. Click Ok to confirm.')')) {
                    updateProfileForm.submit();
                }
            } else {
                updateProfileForm.submit();
            }
        });
    </script>
@endsection