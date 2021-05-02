<div class="panel panel-default">
    <div class="panel-heading">
        @lang('View Comparision Groups')
    </div>
    <div class="panel-body">
        <form id="delete-form" action="delete/comparision-group" method="post" class="form-inline">
            <div class="row">
                @can('delete', App\ComparisionGroup::class)
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
                                       if(confirm('@lang('Are you sure you want to delete selected comparision group ?')')) {
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
                <div class="advanced-search col-md-{{Auth::user()->can('delete', App\ComparisionGroup::class) ? '12' : '8 col-md-offset-4'}}">
                    <div class="text-muted">
                        <label for="checkboxArray">@lang('Advanced Search') <i class="fa fa-search" aria-hidden="true"></i></label>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <select class="form-control" id="select-column">
                                <option value=2>@lang('Name')</option>
                                <option value=3>@lang('Created')</option>
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
                <table class="display table table-striped table-bordered table-hover" id="comparision_groups-table">
                    <thead>
                    <tr>
                        @can('delete', App\ComparisionGroup::class)
                        <th><input type="checkbox" id="options"></th>
                        @endcan
                        <th>@lang('ID')</th>
                        <th>@lang('Name')</th>
                        <th>@lang('Created')</th>
                        @if((Auth::user()->can('update', App\ComparisionGroup::class)) || (Auth::user()->can('delete', App\ComparisionGroup::class)))
                        <th>@lang('Action')</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @if($comparision_groups)
                        @foreach($comparision_groups as $comparision_group)
                            <tr>
                                @can('delete', App\ComparisionGroup::class)
                                <td><input class="checkboxes" type="checkbox" name="checkboxArray[]" value="{{$comparision_group->cg_id}}"></td>
                                @endcan
                                <td>{{$comparision_group->cg_id}}</td>
                                <td>{{$comparision_group->title}}</td>
                                <td>{{$comparision_group->created_at}}</td>
                                @if((Auth::user()->can('update', App\ComparisionGroup::class)) || (Auth::user()->can('delete', App\ComparisionGroup::class)))
                                <td>
                                @can('update', App\ComparisionGroup::class)
                                    <a href="{{route('manage.comparision-group.edit', $comparision_group->cg_id)}}">
                                        <span class="glyphicon glyphicon-edit"></span>
                                    </a>
                                @endcan
                                &nbsp;
                                @can('delete', App\ComparisionGroup::class)
                                    <input type="hidden" id="delete_single" name="">
                                    <a href=""
                                       onclick="
                                               if(confirm('@lang('Are you sure you want to delete this?')')) {
                                                   $('#delete_single').attr('name', 'delete_single').val({{$comparision_group->cg_id}});
                                                   event.preventDefault();
                                                   $('#delete-form').submit();
                                               } else {
                                                    event.preventDefault();
                                               }
                                               "
                                    ><span class="glyphicon glyphicon-trash text-danger"></span></a>
                                @endcan
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>