<div class="row">

    <div class="col-xs-12 col-sm-8">

        @include('includes.form_errors')

        {!! Form::open(['method'=>'post', 'action'=>'ManageDealsController@store', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', __('Deal Name:')) !!}
            {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>__('Enter deal name'), 'required'])!!}
        </div>

        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
            {!! Form::label('description', __('Description:')) !!}
            {!! Form::textarea('description', null, ['class'=>'form-control', 'placeholder'=>__('Enter description')]) !!}
        </div>

        <div class="form-group">
            <div class="product_box">
                <label for="product[]">@lang('Select Products:')</label>
                <select style="display:none" name="product[]" id="product[]" multiple>
                    @foreach($products as $product)
                        <option value="{{$product->id}}">{{$product->name}} {{'(' . __('ID:') . ' '.$product->id. ')'}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }}">
            {!! Form::label('priority', __('Priority:')) !!}
            {!! Form::number('priority', 1, ['class'=>'form-control', 'placeholder'=>__('Enter priority'), 'min'=>'1']) !!}
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="show_in_menu"> <strong>@lang('Show in Main Menu')</strong>
            </label>
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="show_in_footer"> <strong>@lang('Show in Footer Menu')</strong>
            </label>
        </div>

        <div class="form-group">
            {!! Form::label('status', __('Status:')) !!}
            {!! Form::select('status', [0=>__('inactive'), 1=>__('active')], 1, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
        </div>

        @include('partials.manage.meta-fields')

        <div class="form-group">
            {!! Form::submit(__('Add Deal'), ['class'=>'btn btn-primary btn-block', 'name'=>'submit_button']) !!}
        </div>

        {!! Form::close() !!}

    </div>
</div>