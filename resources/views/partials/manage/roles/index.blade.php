<div class="panel panel-default">
    <div class="panel-heading">
        @lang('View Roles')
    </div>
    <div class="panel-body">
        <form id="delete-form" action="delete/roles" method="post" class="form-inline">
            <div class="row">
                @can('delete', App\Role::class)
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
                                       if(confirm('@lang('Are you sure you want to delete selected roles?')')) {
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
                <div class="advanced-search col-md-{{Auth::user()->can('delete', App\Role::class) ? '8' : '8 col-md-offset-4'}}">
                    <div class="text-muted">
                        <label for="checkboxArray">@lang('Advanced Search') <i class="fa fa-search" aria-hidden="true"></i></label>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <select class="form-control" id="select-column">
                                <option value={{Auth::user()->can('delete', App\Role::class) ? 2 : 1}}>@lang('Role')</option>
                                <option value={{Auth::user()->can('delete', App\Role::class) ? 3 : 2}}>@lang('Created')</option>
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
                <table class="display table table-striped table-bordered table-hover" id="roles-table">
                    <thead>
                    <tr>
                        @can('delete', App\Role::class)
                        <th><input type="checkbox" id="options"></th>
                        @endcan
                        <th>@lang('ID')</th>
                        <th>@lang('Role')</th>
                        <th>@lang('Created')</th>
                        @if((Auth::user()->can('update', App\Role::class)) || (Auth::user()->can('delete', App\Role::class)))
                        <th>@lang('Action')</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @if($roles)
                        @foreach($roles as $role)
                            <tr>
                                @can('delete', App\Role::class)
                                <td>
                                    @if($role->id !== 1)
                                        <input class="checkboxes" type="checkbox" name="checkboxArray[]" value="{{$role->id}}"></td>
                                    @else
                                        -
                                    @endif
                                @endcan
                                <td>{{$role->id}}</td>
                                <td>
                                    @if($role->id === 1)
                                        <strong><span class="text-danger">{{$role->name}}</span></strong>
                                    @else
                                        {{$role->name}}
                                    @endif
                                </td>
                                <td>{{$role->created_at ? $role->created_at : '-'}}</td>
                                @if((Auth::user()->can('update', App\Role::class)) || (Auth::user()->can('delete', App\Role::class)))
                                <td>
                                @can('update', App\Role::class)
                                    @if($role->id !== 1)
                                        <a href="{{route('manage.roles.edit', $role->id)}}">
                                            <span class="glyphicon glyphicon-edit"></span>
                                        </a>
                                    @else
                                        -
                                    @endif
                                @endcan
                                &nbsp;
                                @can('delete', App\Role::class)
                                    @if($role->id !== 1)
                                        <input type="hidden" id="delete_single" name="">
                                        <a href=""
                                        onclick="
                                                if(confirm('@lang('Are you sure you want to delete this?')')) {
                                                    $('#delete_single').attr('name', 'delete_single').val({{$role->id}});
                                                    event.preventDefault();
                                                    $('#delete-form').submit();
                                                } else {
                                                        event.preventDefault();
                                                }
                                                "
                                        ><span class="glyphicon glyphicon-trash text-danger"></span></a>
                                    @else
                                        -
                                    @endif
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

<div class="panel panel-default">
    <div class="panel-heading">
        @lang('View Roles and Permissions')
    </div>
    <div class="panel-body">
        <div class="row advanced-search">
            <div class="col-md-5">
                <select class="form-control" id="select-column2">
                    <option value=1>@lang('Role')</option>
                    <option value=2>@lang('Permissions')</option>
                </select>
            </div>
            <div class="col-md-7">
                <input class="form-control" type="text" id="search-by-column2" placeholder="@lang('Search by Column')">
            </div>
        </div>
        <div class="table-responsive">
            <div class="col-md-12 text-right">
                <span class="advanced-search-toggle">@lang('Advanced Search')</span>
            </div>
            <table class="display table table-striped table-bordered table-hover" id="roles-permissions-table">
                <thead>
                <tr>
                    <th>@lang('ID')</th>
                    <th>@lang('Role')</th>
                    <th>@lang('Permissions')</th>
                    @can('update', App\Role::class)
                    <th>@lang('Edit')</th>
                    @endcan
                </tr>
                </thead>
                <tbody>
                @if($roles)
                    @foreach($roles as $role)
                        <tr>
                            <td>{{$role->id}}</td>
                            <td>
                                @if($role->id == 1)
                                    <strong><span class="text-danger">{{$role->name}}</span></strong>
                                @else
                                    {{$role->name}}
                                @endif
                            </td>
                            <td>
                                @if($role->id == 1)
                                    <strong><span class="text-danger">@lang('All')</span></strong>
                                @else
                                    @foreach($role->permissions as $permissions)
                                        {{$permissions->name}} - {{$permissions->for}} <br>
                                    @endforeach
                                @endif
                            </td>
                            @can('update', App\Role::class)
                            <td>
                                @if($role->id !== 1)
                                    <a href="{{route('manage.roles.edit', $role->id)}}">
                                        <span class="glyphicon glyphicon-edit"></span>
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            @endcan
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>