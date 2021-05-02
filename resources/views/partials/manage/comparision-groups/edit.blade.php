<?php
$comparision_types = !empty($comparision_group->comparision_groups) ? unserialize($comparision_group->comparision_groups) : array();
?>
<div class="row">
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">

        @if(session()->has('comparision_group_updated'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{session('comparision_group_updated')}}</strong>
            </div>
        @endif

        @include('includes.form_errors')
        {!! Form::model($comparision_group, ['method'=>'patch', 'action'=>['ManageComparisionGroupsController@update', $comparision_group->cg_id], 'files'=>true, 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('title', __('Title:')) !!}
            {!! Form::text('title', $comparision_group->title, ['class'=>'form-control', 'placeholder'=>__('Enter Comparision Group Title'), 'required'])!!}
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
                    @php
                        $i = 0;
                    @endphp
                    @if(count($comparision_types) > 0)
                        @foreach($comparision_types as $comparision_groups_type)
                            @php
                                $comp_type_icon  = \App\ComparisionGroup::getPhotoNameById($comparision_groups_type['photo_id']);
                                $comp_type_icon = !empty($comp_type_icon) ? $comp_type_icon : __('No File Chosen');
                            @endphp
                            <tr>
                                <td>
                                    {!! Form::select('comparision_type[]', $specification_types->pluck('name','id'), $comparision_groups_type['comp_type'], ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
                                </td>
                                <td>
                                    {!! Form::label('comparision_type_icon[comp_icon_'.$i.']', __('Choose a Icon'), ['class'=>'btn btn-default btn-file']) !!}
                                    {!! Form::file('comparision_type_icon[comp_icon_'.$i.']',['class'=>'form-control', 'style'=>'display: none;','onchange'=>'$("#upload-file-name-'.$i.'").html(files[0].name)']) !!}
                                    <span class='label label-info' id="upload-file-name-<?=$i?>">{{$comp_type_icon}}</span>
                                </td>
                                <td>
                                    <button class="remove_row btn btn-danger btn-xs" type="button">
                                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                                    </button>
                                </td>
                            </tr>
                            @php
                                $i++;
                            @endphp
                        @endforeach
                    @else
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
                    @endif
                    </tbody>
                </table>
                <div class="text-right">
                    <button type="button" id="add-more-specification" class="btn btn-success btn-sm">@lang('Add More')</button>
                </div>
            </div>

        <div class="form-group">
            {!! Form::submit(__('Update'), ['class'=>'btn btn-primary col-xs-6 col-sm-6 pull-left', 'name'=>'submit_button']) !!}
        </div>

        {!! Form::close() !!}

    </div>
</div>