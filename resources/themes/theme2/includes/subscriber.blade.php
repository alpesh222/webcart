<!-- ============================================== NEWSLETTER ============================================== -->
<div class="sidebar-widget newsletter wow fadeInUp outer-bottom-small">
    <h3 class="section-title"> @lang('Newsletters') </h3>
    <div class="sidebar-widget-body outer-top-xs">
        <p class="p-0 custom_subs_p">{{config('settings.subscribers_title')}}</p>
        <small>{{config('settings.subscribers_description')}}.</small>
        {!! Form::open(['method'=>'post', 'action'=>'NewsletterController@addEmailToList', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}
            <div class="form-group">
                <label class="sr-only" for="exampleInputEmail1">@lang('Email address')</label>
                {!! Form::email('email', null, ['id'=>'exampleInputEmail1', 'class'=>'form-control', 'placeholder'=>config('settings.subscribers_placeholder_text'), 'required', 'email'])!!}
            </div>
            <button class="btn btn-primary" name="submit_button" type="submit">{{config('settings.subscribers_btn_text')}}</button>
        {!! Form::close() !!}
    </div>
    <!-- /.sidebar-widget-body -->
</div>
<!-- /.sidebar-widget -->
<!-- ============================================== NEWSLETTER: END ============================================== -->