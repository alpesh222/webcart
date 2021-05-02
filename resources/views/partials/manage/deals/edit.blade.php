<div class="row">

    <div class="col-xs-12 col-sm-8">

        @if(session()->has('deal_updated'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{session('deal_updated')}}</strong> <a target="_blank" href="{{route('front.deal.show', $deal->slug)}}">@lang('View')</a>
            </div>
        @endif

        @include('includes.form_errors')

        @can('read', App\Location::class)
        <div class="row">
            <div class="col-md-6 col-sm-8 col-xs-12">
                @lang('Location:') 
                <strong>
                    @if($deal->location)
                        {{$deal->location->name}}
                    @else
                        @lang('None')
                    @endif
                </strong>
            <br><br>
            </div>
        </div>
        @endcan

        {!! Form::model($deal, ['method'=>'patch', 'action'=>['ManageDealsController@update', $deal->id], 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

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
                        @if($deal->products->contains($product->id))
                            <option selected value="{{$product->id}}">{{$product->name}} {{'(' . __('ID:') . ' '.$product->id. ')'}}</option>
                        @else                        
                            <option value="{{$product->id}}">{{$product->name}} {{'(' . __('ID:') . ' '.$product->id. ')'}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group{{ $errors->has('priority') ? ' has-error' : '' }}">
            {!! Form::label('priority', __('Priority:')) !!}
            {!! Form::number('priority', null, ['class'=>'form-control', 'placeholder'=>__('Enter priority'), 'min'=>'1']) !!}
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="show_in_menu" @if($deal->show_in_menu) checked @endif> <strong>@lang('Show in Main Menu')</strong>
            </label>
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="show_in_footer" @if($deal->show_in_footer) checked @endif> <strong>@lang('Show in Footer Menu')</strong>
            </label>
        </div>

        <div class="form-group">
            {!! Form::label('status', __('Status:')) !!}
            {!! Form::select('status', [0=>__('inactive'), 1=>__('active')], $deal->is_active, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
        </div>

        @include('partials.manage.meta-fields')

        <div class="form-group">
            {!! Form::submit(__('Update Deal'), ['class'=>'btn btn-primary btn-block', 'name'=>'submit_button']) !!}
        </div>

        {!! Form::close() !!}

    </div>
</div>