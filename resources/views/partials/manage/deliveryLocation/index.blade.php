<div class="panel panel-default">
    <div class="panel-heading">
        @lang('View Delivery Locations')
    </div>
    <div class="panel-body">
        <form id="delete-form" action="delete/delivery-locations" method="post" class="form-inline">
            <div class="row">
                @can('delete', App\DeliveryLocation::class)
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
                               onclick="if(confirm('@lang('Are you sure you want to delete selected delivery locations?')')) {
                                           $('#delete_all').attr('name', 'delete_all');
                                           event.preventDefault();
                                            $('#delete-form').submit();
                                       } else {
                                            event.preventDefault();
                                       }"
                        >
                    </div>
                </div>
                @endcan
                <div class="advanced-search col-md-{{Auth::user()->can('delete', App\DeliveryLocation::class) ? '8' : '8 col-md-offset-4'}}">
                    <div class="text-muted">
                        <label for="checkboxArray">@lang('Advanced Search') <i class="fa fa-search" aria-hidden="true"></i></label>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <select class="form-control" id="select-column">
                                <option value={{Auth::user()->can('delete', App\DeliveryLocation::class) ? 2 : 1}}>@lang('Country')</option>
                                <option value={{Auth::user()->can('delete', App\DeliveryLocation::class) ? 3 : 2}}>@lang('State')</option>
                                <option value={{Auth::user()->can('delete', App\DeliveryLocation::class) ? 4 : 3}}>@lang('City')</option>
                                <option value={{Auth::user()->can('delete', App\DeliveryLocation::class) ? 5 : 4}}>@lang('Zip Code')</option>
                                <option value={{Auth::user()->can('delete', App\DeliveryLocation::class) ? 6 : 5}}>@lang('Status')</option>
                                <option value={{Auth::user()->can('delete', App\DeliveryLocation::class) ? 7 : 6}}>@lang('Date Created')</option>
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
                <table class="display table table-striped table-bordered table-hover" id="delivery-location-table">
                    <thead>
                    <tr>
                        @can('delete', App\DeliveryLocation::class)
                        <th><input type="checkbox" id="options"></th>
                        @endcan
                            <th>@lang('ID')</th>
                            <th>@lang('Country')</th>
                            <th>@lang('State')</th>
                            <th>@lang('City')</th>
                            <th>@lang('Zip Code')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Created Date')</th>
                        @if((Auth::user()->can('update', App\DeliveryLocation::class)) || (Auth::user()->can('delete', App\DeliveryLocation::class)))
                        <th>@lang('Action')</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($deliveryLocations) > 0)
                        @foreach($deliveryLocations as $location)
                            <tr>
                                @can('delete', App\DeliveryLocation::class)
                                <td><input class="checkboxes" type="checkbox" name="checkboxArray[]" value="{{$location->id}}"></td>
                                @endcan
                                    @php
                                    $status = 'Inactive';
                                    if ($location->status == 1){
                                        $status = 'active';
                                    }
                                    @endphp
                                    <td>{{$location->id}}</td>
                                    <td>{{$location->country}}</td>
                                    <td>{{$location->state}}</td>
                                    <td>{{$location->city}}</td>
                                    <td>{{$location->pincode}}</td>
                                    <td>{{$status}}</td>
                                    <td>{{$location->created_at}}</td>
                                @if((Auth::user()->can('update', App\DeliveryLocation::class)) || (Auth::user()->can('delete', App\DeliveryLocation::class)))
                                <td>
                                @can('update', App\DeliveryLocation::class)
                                    <a href="{{route('manage.delivery-location.edit', $location->id)}}">
                                        <span class="glyphicon glyphicon-edit"></span>
                                    </a>
                                @endcan
                                &nbsp;
                                @can('delete', App\DeliveryLocation::class)
                                    <input type="hidden" id="delete_single" name="delete_single">
                                    <a href=""
                                       onclick="
                                               if(confirm('@lang('Are you sure you want to delete this?')')) {
                                                   $('#delete_single').attr('name', 'delete_single').val({{$location->id}});
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