<div class="panel panel-default">
    <div class="panel-heading">
        @lang('View Staff')
    </div>
    <div class="panel-body">
        <div class="row advanced-search">
            <div class="col-md-5">
                <select class="form-control" id="select-column">
                    <option value=2>@lang('Name')</option>
                    <option value=3>@lang('Username')</option>
                    <option value=4>@lang('Email')</option>
                    <option value=5>@lang('Role')</option>
                    <option value=6>@lang('Status')</option>
                    <option value=7>@lang('Created')</option>
                </select>
            </div>
            <div class="col-md-7">
                <input class="form-control" type="text" id="search-by-column" placeholder="@lang('Search by Column')">
            </div>
        </div>
        <div class="table-responsive">
            <div class="col-md-12 text-right">
                <span class="advanced-search-toggle">@lang('Advanced Search')</span>
            </div>
            <table class="display table table-striped table-bordered table-hover" id="users-table">
                <thead>
                    <tr>
                        <th>@lang('ID')</th>
                        <th>@lang('Photo')</th>
                        <th>@lang('Name')</th>
                        <th>@lang('Username')</th>
                        <th>@lang('Email')</th>
                        <th>@lang('Role')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Created')</th>
                        @can('update', App\User::class)
                        <th>@lang('Edit')</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                @if($users)
                    @foreach($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>
                            @if($user->photo)
                                <img height="50px" src="{{route('imagecache', ['tiny', $user->photo->getOriginal('name')])}}" alt="Photo">
                            @else
                                <img height="50px" src="{{$default_photo}}" alt="Photo">
                            @endif
                            </td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->username}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                @if($user->role)
                                    @if($user->role->id == 1)
                                        <strong><span class="text-danger">{{$user->role->name}}</span></strong>
                                    @else
                                        {{$user->role->name}}
                                    @endif
                                @else
                                    @lang('None')
                                @endif
                            </td>
                            <td>{{$user->is_active ? __('Active') : __('Inactive')}}</td>
                            <td>{{$user->created_at ? $user->created_at : '-'}}</td>
                            @can('update', App\User::class)
                            <td>
                                @if($user->id== 1 && Auth::user()->id != 1)
                                    -
                                @else
                                    <a href="{{route('manage.users.edit', $user->id)}}">
                                        <span class="glyphicon glyphicon-edit"></span>
                                    </a>
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