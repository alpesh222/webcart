@extends('layouts.manage')

@section('title')
    @lang('Add Vendor')
@endsection

@section('page-header-title')
    @lang('Add Vendor') <a class="btn btn-info btn-sm" href="{{route('manage.vendors.index')}}">@lang('View Vendors')</a>
@endsection

@section('page-header-description')
    @lang('Add New Vendor') <a href="{{url()->previous()}}">@lang('Go Back')</a>
@endsection

@section('styles')
    @include('partials.phone_style')
@endsection

@section('scripts')
    @include('includes.tinymce')
    @include('partials.phone_script')
    <script>

        $('#existing_user').change(function(){
            if (this.checked == true){
                $('#existing_form').css( 'display', 'none' );
            } else {
                $('#existing_form').css('display', 'block' );
            }
        });
        $('#username').on('blur',function(){
            $('#no_username').css('display','none');
            var existingUser = document.getElementById('existing_user');
            if (existingUser.checked === true){
               getUserData(this.value);
            }
        });
        function getUserData(user_name) {
            $.ajax({
                method: 'get',
                url: APP_URL + '/manage/ajax/user/get-user-data/' + user_name,
                success: function(response) {
                    var response = JSON.parse(response);
                    if(response) {
                        if (response !== 0 || response !== '' ){
                            $('#name').val(response.name);
                            $('#username').val(response.username);
                            $('#email').val(response.email);
                            $('#phone-number').val(response.phone);
                            $('#password').val(response.email);
                            $('#password_confirmation').val(response.email);
                        }else{
                            $('#no_username').css('display','block');
                            $('#username').val('');
                        }
                    }else{
                        $('#no_username').css('display','block');
                        $('#username').val('');
                    }
                },
                error : function (response) {
                    $('#no_username').css('display','block');
                    $('#username').val('');
                }
            });
        }
    </script>
    @if(config('settings.toast_notifications_enable'))
        <script>
            toastr.options.closeButton = true;
            @if(session()->has('vendor_created'))
            toastr.success("{{session('vendor_created')}}");
            @endif
            @if(session()->has('vendor_not_created'))
            toastr.error("{{session('vendor_not_created')}}");
            @endif
        </script>
    @endif
@endsection

@section('content')
    @include('partials.manage.vendors.create')
@endsection