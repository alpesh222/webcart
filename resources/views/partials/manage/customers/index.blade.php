<div class="row">
    <div class="col-md-12">
        @if(session()->has('user_created'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{session('user_created')}}</strong>
            </div>
        @endif
        @if(session()->has('user_deleted'))
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{session('user_deleted')}}</strong>
            </div>
        @endif
        @if(session()->has('user_not_deleted'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{session('user_not_deleted')}}</strong>
            </div>
        @endif
        <div class="panel panel-default">
            <div class="panel-heading">
                @if(!empty($search = request()->s))
                @lang('Showing :total_customers customers with :per_page customers per page for keyword: <strong>:keyword</strong>', ['total_customers'=>$users->total(), 'per_page'=>$users->perPage(), 'keyword'=>$search])&nbsp;&nbsp;<a class="text-primary" href="{{url('manage/customers')}}">@lang('Show all')</a>
                @else
                @lang('Showing :total_users customers with :per_page customers per page', ['total_users'=>$users->total(), 'per_page'=>$users->perPage()])
                @endif
                @if(empty(request()->all))
                <br>
                <a href="{{url('manage/customers')}}?all=1">@lang('Show customers in a single page')</a>
                @else
                <br>
                <a href="{{url('manage/customers')}}">@lang('Show customers with pagination')</a>
                @endif
            </div>
            <div class="panel-body">
                <form id="delete-form" action="delete/customers" method="post" class="form-inline">
                    <div class="row">
                        @can('update-customers', App\Other::class)
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
                                               if(confirm('@lang('Are you sure you want to delete selected users? All data related to these users will also be deleted.')')) {
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

                        <div class="form-inline search-box pull-right text-right col-md-6">
                            @lang('Enter name, username or email')<br>
                            <div class="form-group search-field-box">
                                <input type="text" class="form-control" name="search" id="keyword" placeholder="" value="{{request()->s}}">
                            </div>
                            <button data-url="{{url('manage/customers')}}" type="button" class="btn btn-primary" id="search-btn">@lang('Search')</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="display table table-striped table-bordered table-hover" id="users-table">
                            <thead>
                                <tr>
                                    @can('update-customers', App\Other::class)
                                    <th><input type="checkbox" id="options"></th>
                                    @endcan
                                    <th>@lang('ID')</th>
                                    <th>@lang('Photo')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Username')</th>
                                    <th>@lang('Email')</th>
                                    @if($phone_verification)
                                    <th>@lang('Phone')</th>
                                    @endif
                                    <th>@lang('Role')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Created')</th>
                                    @can('read', App\Order::class)
                                    <th>@lang('Orders')</th>
                                    @endcan
                                    @can('update-customers', App\Other::class)
                                    <th>@lang('Edit')</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                            @if($users)
                                @foreach($users as $user)
                                    <tr>
                                        @can('update-customers', App\Other::class)
                                        <td>
                                        @if($user->id != 1)
                                            <input class="checkboxes" type="checkbox" name="checkboxArray[]" value="{{$user->id}}">
                                        @endif
                                        </td>
                                        @endcan
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
                                        @if($phone_verification)
                                        <td>
                                            @if($user->mobile)
                                                @if($user->mobile->verified)
                                                {{$user->mobile->number}} <strong class="text-success">(@lang('verified'))</strong>
                                                @else
                                                {{$user->mobile->number}} <strong class="text-danger">(@lang('unverified'))</strong>
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                        @endif
                                        <td>
                                            @php
                                                $user_role = \App\Helpers\Helper::get_user_role($user);
                                            @endphp
                                            @if($user_role['role_name'] == 'Super Admin')
                                                <strong><span class="text-danger">{{$user_role['role_name']}}</span></strong>
                                            @else
                                                {{$user_role['role_name']}}
                                            @endif
                                        </td>
                                        <td>{{$user->is_active ? __('Active') : __('Inactive')}}</td>
                                        <td>{{$user->created_at ? $user->created_at->diffForHumans() : '-'}}</td>
                                        @can('read', App\Order::class)
                                        <td>
                                            <a href="{{route('manage.customer.orders', $user->id)}}">
                                                {{count($user->orders->where('location_id', Auth::user()->location_id))}}
                                            </a>
                                        </td>
                                        @endcan
                                        @can('update-customers', App\Other::class)
                                        <td>
                                            @if($user->id== 1 && Auth::user()->id != 1)
                                                -
                                            @else
                                                <a href="{{route('manage.customers.edit', $user->id)}}">
                                                    <span class="glyphicon glyphicon-edit"></span>
                                                </a>
                                                @if($user->id != 1)
                                                &nbsp;
                                                <input type="hidden" id="delete_single" name="">
                                                <a href=""
                                                   onclick="
                                                           if(confirm('@lang('Are you sure you want to delete this user? All data related to this user will also be deleted.')')) {
                                                               $('#delete_single').attr('name', 'delete_single').val({{$user->id}});
                                                               event.preventDefault();
                                                               $('#delete-form').submit();
                                                           } else {
                                                                event.preventDefault();
                                                           }
                                                           "
                                                ><span class="glyphicon glyphicon-trash text-danger"></span></a>
                                                @endif
                                            @endif
                                        </td>
                                        @endcan
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                    @if(!request()->all)
                    <div class="text-right">
                        {{$users->appends($_GET)->links()}}
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default" id="addresses">
            <div class="panel-heading">
                @if(!empty($search_c = request()->s_c))
                @lang('Showing :total_customers addresses with :per_page addresses per page for keyword: <strong>:keyword</strong>', ['total_customers'=>$customers->total(), 'per_page'=>$customers->perPage(), 'keyword'=>$search_c])&nbsp;&nbsp;<a class="text-primary" href="{{url('manage/customers')}}">@lang('Show all')</a>
                @else
                @lang('Showing :total_customers addresses with :per_page addresses per page', ['total_customers'=>$customers->total(), 'per_page'=>$customers->perPage()])
                @endif
                @if(empty(request()->all_c))
                <br>
                <a href="{{url('manage/customers')}}?all_c=1">@lang('Show addresses in a single page')</a>
                @else
                <br>
                <a href="{{url('manage/customers')}}">@lang('Show addresses with pagination')</a>
                @endif
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="search-box text-right col-md-8 col-md-offset-4 form-inline">
                        @lang('Enter first name, last name, username, phone, email or address')<br>
                        <div class="form-group search-field-box">
                            <input type="text" class="form-control" name="search_c" id="keyword_c" placeholder="" value="{{request()->s_c}}">
                        </div>
                        <button data-url="{{url('manage/customers')}}" type="button" class="btn btn-primary" id="search-btn_c">@lang('Search')</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered table-hover" id="customers-table">
                        <thead>
                        <tr>
                            <th>@lang('ID')</th>
                            <th>@lang('Name')</th>
                            <th>@lang('Address')</th>
                            <th>@lang('Phone')</th>
                            <th>@lang('Email')</th>
                            <th>@lang('Username if Registered')</th>
                            <th>@lang('Created')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($customers)
                            @foreach($customers as $customer)
                                <tr>
                                    <td>{{$customer->id}}</td>
                                    <td><strong>{{$customer->first_name . ' ' . $customer->last_name}}</strong></td>
                                    <td>
                                        {{$customer->address}}<br>
                                        {{$customer->city . ', ' . $customer->state . ' - ' . $customer->zip}}<br>
                                        {{$customer->country}}.<br>
                                    </td>
                                    <td>{{$customer->phone}}</td>
                                    <td>{{$customer->email}}</td>
                                    <td>{{$customer->user ? $customer->user->name .' @'.$customer->user->username : '-'}}</td>
                                    <td>{{$customer->created_at->toFormattedDateString()}}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                @if(!request()->all_c)
                <div class="text-right">
                    {{$customers->appends($_GET)->links()}}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>