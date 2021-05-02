<div class="panel panel-default">
    <div class="panel-heading">
        @lang('View Coupons')
    </div>
    <div class="panel-body">
        <form id="delete-form" action="delete/coupons" method="post" class="form-inline">
            <div class="row">
                @can('delete-coupon', App\Voucher::class)
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
                                       if(confirm('@lang('Are you sure you want to delete selected coupons?')')) {
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
                <div class="advanced-search col-md-{{Auth::user()->can('delete-coupon', App\Voucher::class) ? '8' : '8 col-md-offset-4'}}">
                    <div class="text-muted">
                        <label for="checkboxArray">@lang('Advanced Search') <i class="fa fa-search" aria-hidden="true"></i></label>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <select class="form-control" id="select-column">
                                <option value={{Auth::user()->can('delete-coupon', App\Voucher::class) ? 2 : 1}}>@lang('Name')</option>
                                <option value={{Auth::user()->can('delete-coupon', App\Voucher::class) ? 3 : 2}}>@lang('Code')</option>
                                <option value={{Auth::user()->can('delete-coupon', App\Voucher::class) ? 4 : 3}}>@lang('Discount Amount')</option>
                                <option value={{Auth::user()->can('delete-coupon', App\Voucher::class) ? 5 : 4}}>@lang('Starts At')</option>
                                <option value={{Auth::user()->can('delete-coupon', App\Voucher::class) ? 6 : 5}}>@lang('Expires At')</option>
                                <option value={{Auth::user()->can('delete-coupon', App\Voucher::class) ? 7 : 6}}>@lang('Valid Above Amount')</option>
                                <option value={{Auth::user()->can('delete-coupon', App\Voucher::class) ? 8 : 7}}>@lang('Created')</option>
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
                <table class="display table table-striped table-bordered table-hover" id="coupons-table">
                    <thead>
                    <tr>
                        @can('delete-coupon', App\Voucher::class)
                        <th><input type="checkbox" id="options"></th>
                        @endcan
                        <th>@lang('ID')</th>
                        <th>@lang('Name')</th>
                        <th>@lang('Code')</th>
                        <th>@lang('Amount')</th>
                        <th>@lang('Starts At')</th>
                        <th>@lang('Expires At')</th>
                        <th>@lang('Valid Above Amount')</th>
                        <th>@lang('Created')</th>
                        @can('update-coupon', App\Voucher::class)
                        <th>@lang('Edit')</th>
                        @endcan
                        @can('delete-coupon', App\Voucher::class)
                        <th>@lang('Delete')</th>
                        @endcan
                    </tr>
                    </thead>
                    <tbody>
                    @if($coupons)
                        @foreach($coupons as $coupon)
                            <tr>
                                @can('delete-coupon', App\Voucher::class)
                                <td><input class="checkboxes" type="checkbox" name="checkboxArray[]" value="{{$coupon->id}}"></td>
                                @endcan
                                <td>{{$coupon->id}}</td>
                                <td>{{$coupon->name}}</td>
                                <td>{{$coupon->code}}</td>
                                <td>{{$coupon->discount_amount}}</td>
                                <td>{{$coupon->starts_at}}</td>
                                <td>{{$coupon->expires_at}}</td>
                                <td>{{$coupon->valid_above_amount ? $coupon->valid_above_amount : '-'}}</td>
                                <td>{{$coupon->created_at}}</td>
                                @can('update-coupon', App\Voucher::class)
                                <td>
                                    <a href="{{route('manage.coupons.edit', $coupon->id)}}">
                                        <span class="glyphicon glyphicon-edit"></span>
                                    </a>
                                </td>
                                @endcan
                                @can('delete-coupon', App\Voucher::class)
                                <td>
                                    <input type="hidden" id="delete_single" name="">
                                    <a href=""
                                       onclick="
                                               if(confirm('@lang('Are you sure you want to delete this?')')) {
                                                   $('#delete_single').attr('name', 'delete_single').val({{$coupon->id}});
                                                   event.preventDefault();
                                                   $('#delete-form').submit();
                                               } else {
                                                    event.preventDefault();
                                               }
                                               "
                                    ><span class="glyphicon glyphicon-trash text-danger"></span></a>
                                </td>
                                @endcan
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>