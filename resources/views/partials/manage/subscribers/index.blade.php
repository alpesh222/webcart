<div class="panel panel-default">
    <div class="panel-heading">
        @lang('View Subscribers')
    </div>
    <div class="panel-body">
        <form id="delete-form" action="delete/subscribers" method="post" class="form-inline">
            <div class="row">
                @can('import-delete-subscribers', App\Other::class)
                {{csrf_field()}}
                <div class="col-md-4">
                    <div class="text-muted">
                        <label for="checkboxArray">@lang('Bulk Options') <i class="fa fa-cog" aria-hidden="true"></i></label>
                    </div>
                    <input type="hidden" name="_method" value="DELETE">

                    <div class="form-group">
                        <select name="checkboxArray" class="form-control">
                            <option value="">@lang('Delete')</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <input id="delete_all" name="" class="btn fa btn-warning" value="&#xf1d8;"
                               onclick="
                                   if(confirm('@lang('Are you sure you want to delete selected subscribers?')')) {
                                       $('#delete_all').attr('name', 'delete_all');
                                       event.preventDefault();
                                        $('#delete-form').submit();
                                   } else {
                                        event.preventDefault();
                                   }
                                   "
                        >
                    </div>
                </div>
                @endcan
                <div class="advanced-search col-md-{{Auth::user()->can('import-delete-subscribers', App\Other::class) ? '8' : '8 col-md-offset-4'}}">
                    <div class="text-muted">
                        <label for="checkboxArray">@lang('Advanced Search') <i class="fa fa-search" aria-hidden="true"></i></label>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <select class="form-control" id="select-column">
                                <option value={{Auth::user()->can('import-delete-subscribers', App\Other::class) ? 2 : 1}}>@lang('Email')</option>
                                <option value={{Auth::user()->can('import-delete-subscribers', App\Other::class) ? 3 : 2}}>@lang('Status')</option>
                                <option value={{Auth::user()->can('import-delete-subscribers', App\Other::class) ? 4 : 3}}>@lang('Date')</option>
                                <option value={{Auth::user()->can('import-delete-subscribers', App\Other::class) ? 1 : 0}}>@lang('ID')</option>
                            </select>
                        </div>
                        <div class="col-md-7">
                            <input class="form-control" type="text" id="search-by-column" placeholder="@lang('Search by Column')">
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <div class="col-md-12 text-right">
                    <span class="advanced-search-toggle">@lang('Advanced Search')</span>
                </div>
                <table class="display table table-striped table-bordered table-hover" id="subscribers-table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="options"></th>
                            <th>@lang('ID')</th>
                            <th>@lang('Email')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Date')</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if($subscribers)
                        @foreach($subscribers as $subscriber)
                            <tr>
                                <td><input class="checkboxes" type="checkbox" name="checkboxArray[]" value="{{$subscriber->id}}"></td>
                                <td>{{$subscriber->id}}</td>
                                <td>{{$subscriber->email}}</td>
                                <td>
                                    <strong>
                                    @if($subscriber->active)
                                        <span class="text-primary">@lang('Confirmed')</span>
                                    @else
                                        <span class="text-danger">@lang('Pending')</span>
                                    @endif
                                    </strong>
                                </td>
                                <td>{{$subscriber->created_at->toFormattedDateString()}}</td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{session('success')}}</strong>
            </div>
        @endif
        @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <span class="glyphicon glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <strong>{{session('error')}}</strong>
            </div>
        @endif
    </div>
    
    @if(session()->has('error_rows') && $errorsArray = session('error_rows'))
    <div class="col-md-9">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                @foreach(reset($errorsArray) as $key => $value)
                    <th>{{ucfirst($key)}}</th>
                @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($errorsArray as $key => $value)
                    <tr>
                        @foreach($value as $data)
                        <td>{{$data}}</td>
                        @endforeach
                    </tr>
                @endforeach
          </tbody>
        </table>
    </div>
    @endif
    @can('import-delete-subscribers', App\Other::class)
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
        @include('includes.form_errors')

        {!! Form::open(['method'=>'post', 'action'=>'ManageSubscribersController@importSubscribers', 'files'=>true, 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

            <h4 class="text-center">@lang('Import Subscribers From CSV File')</h4>

            <div class="form-group">
                {!! Form::label('file', __('Choose CSV File'), ['class'=>'btn btn-default btn-file']) !!}
                {!! Form::file('file',['class'=>'form-control', 'style'=>'display: none;','onchange'=>'$("#upload-file-name").html(files[0].name)']) !!}
                <span class='label label-info' id="upload-file-name">@lang('No file chosen')</span>
            </div>

            <div class="form-group">
                {!! Form::submit(__('Import Subscribers'), ['class'=>'btn btn-primary btn-block', 'name'=>'submit_button']) !!}
            </div>
        {!! Form::close() !!}
    </div>
    @endcan
</div>