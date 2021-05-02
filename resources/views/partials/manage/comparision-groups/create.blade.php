
<div class="col-md-8">
    @if(session()->has('comparision_group_created'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>{{session('comparision_group_created')}}</strong>
        </div>
    @endif

    @include('includes.form_errors')

    {!! Form::open(['method'=>'post', 'action'=>'ManageComparisionGroupsController@store', 'files'=>true, 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
            {!! Form::label('title', __('Title:')) !!}
            {!! Form::text('title', null, ['class'=>'form-control', 'placeholder'=>__('Example: RAM, Memory, Weight'), 'required']) !!}
        </div>

        <div class="comparision_groups_box">
            <table id="comparision_groups_box" class="table table-responsive table-bordered">
                <thead>
                <tr>
                    <th>@lang('Comparision Type')</th>
                    <th>@lang('Icon')</th>
                    <th></th>
                </tr>
                </thead>
                <tbody class="specification_types_rows">
                <tr>
                    <td>
                        {!! Form::select('comparision_type[]', $specification_types->pluck('name','id'), null, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default', 'required'=>'true' ]) !!}
                    </td>
                    <td>
                        {!! Form::file('comparision_type_icon[]', null, ['class'=>'form-control', 'required'=>'true'])!!}
                    </td>
                    <td>
                        <button class="remove_row btn btn-danger btn-xs" type="button">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="text-right">
                <button type="button" id="add-more-specification" class="btn btn-success btn-sm">@lang('Add More')</button>
            </div>
        </div>
        <br>

        <div class="form-group col-md-4">
            {!! Form::submit(__('Add Comparision Group'), ['class'=>'btn btn-primary btn-block', 'name'=>'submit_button']) !!}
        </div>

    {!! Form::close() !!}

</div>