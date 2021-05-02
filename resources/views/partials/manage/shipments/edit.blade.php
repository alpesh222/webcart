<div class="row">

    <div class="col-xs-12 col-sm-8">

        @if(session()->has('shipment_updated'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{session('shipment_updated')}}</strong>
            </div>
        @endif

        @include('includes.form_errors')

        {!! Form::model($shipment, ['method'=>'patch', 'action'=>['ManageShipmentsController@update', $shipment->id], 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', __('Shipment Location Name:')) !!}
            {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>__('Enter shipment location name'), 'required'])!!}
        </div>

        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
            {!! Form::label('address',__('Shipment Address:')) !!}
            {!! Form::textarea('address', null, ['class'=>'form-control', 'placeholder'=>__('Enter shipment address'), 'rows'=>'6']) !!}
        </div>

        <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
            {!! Form::label('city', __('City:')) !!}
            {!! Form::text('city', null, ['class'=>'form-control', 'placeholder'=>__('Enter shipment city')])!!}
        </div>

        <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
            {!! Form::label('state', __('State:')) !!}
            {!! Form::text('state', null, ['class'=>'form-control', 'placeholder'=>__('Enter shipment state')])!!}
        </div>

        <div class="form-group{{ $errors->has('zip') ? ' has-error' : '' }}">
            {!! Form::label('zip', __('Zip:')) !!}
            {!! Form::text('zip', null, ['class'=>'form-control', 'placeholder'=>__('Enter shipment zip code')])!!}
        </div>

        @include('partials.countries_field')

        <div class="form-group">
            <div class="user_box">
                <label for="user[]">@lang('Select Users or Shippers:')</label>
                <select style="display:none" name="user[]" id="user[]" multiple>
                    @foreach($users as $user)
                        @if($shipment->users->contains($user->id))
                            <option selected value="{{$user->id}}">{{$user->name}} {{'@'.$user->username}}</option>
                        @else
                            <option value="{{$user->id}}">{{$user->name}} {{'@'.$user->username}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            {!! Form::submit(__('Update Shipment'), ['class'=>'btn btn-primary btn-block', 'name'=>'submit_button']) !!}
        </div>

        {!! Form::close() !!}

    </div>
</div>