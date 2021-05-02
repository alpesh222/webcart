<div class="panel panel-default">
    <div class="panel-heading">
        @lang('View Vendors')
    </div>
    <div class="panel-body">
        <form id="delete-form" action="delete/vendors" method="post" class="form-inline">

            <div class="row">
                @can('delete', App\Vendor::class)
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
                                       if(confirm('@lang('Are you sure you want to delete selected vendors?')')) {
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
                <div class="advanced-search col-md-{{Auth::user()->can('delete', App\Vendor::class) ? '8' : '8 col-md-offset-4'}}">
                    <div class="text-muted">
                        <label for="checkboxArray">@lang('Advanced Search') <i class="fa fa-search" aria-hidden="true"></i></label>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <select class="form-control" id="select-column">
                                <option value={{Auth::user()->can('delete', App\Vendor::class) ? 1 : 0}}>@lang('ID')</option>
                                <option selected value={{Auth::user()->can('delete', App\Vendor::class) ? 2 : 1}}>@lang('Name')</option>
                                <option value={{Auth::user()->can('delete', App\Vendor::class) ? 3 : 2}}>@lang('Username')</option>
                                <option selected value={{Auth::user()->can('delete', App\Vendor::class) ? 4 : 3}}>@lang('Company Name')</option>
                                <option value={{Auth::user()->can('delete', App\Vendor::class) ? 5 : 4}}>@lang('Phone')</option>
                                <option value={{Auth::user()->can('delete', App\Vendor::class) ? 6 : 5}}>@lang('Profile Status')</option>
                                <option value={{Auth::user()->can('delete', App\Vendor::class) ? 7 : 6}}>@lang('Account Status')</option>
                                <option value={{Auth::user()->can('delete', App\Vendor::class) ? 8 : 7}}>@lang('Products')</option>
                                <option value={{Auth::user()->can('delete', App\Vendor::class) ? 9 : 8}}>@lang('Amount Earned')</option>
                                <option value={{Auth::user()->can('delete', App\Vendor::class) ? 10 : 9}}>@lang('Amount Paid')</option>
                                <option value={{Auth::user()->can('delete', App\Vendor::class) ? 11 : 10}}>@lang('Payout Status')</option>
                                <option value={{Auth::user()->can('delete', App\Vendor::class) ? 12 : 11}}>@lang('Date')</option>
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
                <table class="display table table-striped table-bordered table-hover" id="vendors-table">
                    <thead>
                    <tr>
                        @can('delete', App\Vendor::class)
                        <th><input type="checkbox" id="options"></th>
                        @endcan
                        <th>@lang('ID')</th>
                        <th>@lang('Name')</th>
                        <th>@lang('Username')</th>
                        <th>@lang('Company Name')</th>
                        <th>@lang('Phone')</th>
                        <th>@lang('Profile Status')</th>
                        <th>@lang('Account Status')</th>
                        <th>@lang('Products')</th>
                        <th>@lang('Amount Earned')</th>
                        <th>@lang('Amount Paid')</th>
                        <th>@lang('Payout Status')</th>
                        <th>@lang('Date')</th>
                        <th>@lang('Action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($vendors)
                        @foreach($vendors as $vendor)
                            @php
                            $vendor_name = !empty($vendor->user->name) ? $vendor->user->name: 'N/a';
                            $vendor_username = !empty($vendor->user->username) ? $vendor->user->username: 'N/a';
                            @endphp
                            <tr>
                                @can('delete', App\Vendor::class)
                                <td><input class="checkboxes" type="checkbox" name="checkboxArray[]" value="{{$vendor->id}}"></td>
                                @endcan
                                <td>{{$vendor->id}}</td>
                                <td>{{$vendor_name}}</td>
                                <td>{{$vendor_username}}</td>
                                <td>{{$vendor->name ? $vendor->name : '-'}}</td>
                                <td>{{$vendor->phone ? $vendor->phone : '-'}}</td>
                                <td>
                                    @if($vendor->profile_completed)
                                    <strong class="text-primary">@lang('Completed')</strong>
                                    @else
                                    <strong class="text-warning">@lang('Incomplete')</strong>
                                    @endif
                                </td>
                                <td>
                                    @if($vendor->approved)
                                    <strong class="text-success">@lang('Approved')</strong>
                                    @else
                                    <strong class="text-danger">@lang('Pending')</strong>
                                    @endif
                                </td>
                                <td><a href="{{route('manage.products.index')}}?vendor={{$vendor->id}}">{{$vendor->products ? count($vendor->products) : 0}}</a></td>
                                <td>
                                {{currency_format($amount_earned = $vendor->vendor_amounts()->where('status', 'earned')->sum('vendor_amount'))}}
                                </td>
                                <td>
                                {{currency_format($amount_paid = $vendor->vendor_amounts()->where('status', 'paid')->sum('vendor_amount'))}}
                                </td>
                                <td>
                                    @if($amount_earned > 0)
                                    <strong>
                                        <span class="text-primary">@lang('Payable')</span>&nbsp;{{currency_format($amount_earned)}}
                                    </strong>
                                    @else
                                    -
                                    @endif
                                </td>
                                <td>{{$vendor->created_at->format('d-m-Y h:i A')}}</td>
                                <td>
                                    @if((Auth::user()->can('read', App\Vendor::class)) || (Auth::user()->can('update', App\Vendor::class)) || (Auth::user()->can('delete', App\Vendor::class)))
                                        @can('read', App\Vendor::class)
                                            <a href="{{route('manage.vendors.show', $vendor->id)}}">
                                                <span class="glyphicon glyphicon-search"></span>
                                            </a>
                                        @endcan
                                        &nbsp;
                                        @can('update', App\Vendor::class)
                                            <a href="{{route('manage.vendors.edit', $vendor->id)}}">
                                                <span class="glyphicon glyphicon-edit"></span>
                                            </a>
                                        @endcan
                                        &nbsp;
                                        @can('delete', App\Vendor::class)
                                            <input type="hidden" id="delete_single" name="">
                                            <a href=""
                                               onclick="
                                                       if(confirm('@lang('Are you sure you want to delete this?')')) {
                                                           $('#delete_single').attr('name', 'delete_single').val({{$vendor->id}});
                                                           event.preventDefault();
                                                           $('#delete-form').submit();
                                                       } else {
                                                            event.preventDefault();
                                                       }
                                                       "
                                            ><span class="glyphicon glyphicon-trash text-danger"></span></a>
                                        @endcan
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>