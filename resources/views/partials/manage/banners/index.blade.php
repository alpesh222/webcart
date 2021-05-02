<div class="panel panel-default">
    <div class="panel-heading">
        @lang('View Banners')
    </div>
    <div class="panel-body">
        <form id="delete-form" action="delete/banners" method="post" class="form-inline">
            <div class="row">
                @can('delete', App\Banner::class)
                {{csrf_field()}}
                <div class="col-md-4">
                    <div class="text-muted">
                        <label for="checkboxArray">@lang('Bulk Options') <i class="fa fa-cog" aria-hidden="true"></i></label>
                    </div>
                    <input type="hidden" name="_method" value="DELETE">

                    <div class="form-group">
                        <select id="checkboxArray" name="checkboxArray" class="form-control">
                            <option value="">@lang('Delete')</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <input id="delete_all" name="" class="btn fa btn-warning" value="&#xf1d8;"
                               onclick="
                                       if(confirm('{{__('Are you sure you want to delete selected banners?')}}')) {
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
                <div class="advanced-search col-md-{{Auth::user()->can('delete', App\Banner::class) ? '8' : '8 col-md-offset-4'}}">
                    <div class="text-muted">
                        <label for="checkboxArray">@lang('Advanced Search') <i class="fa fa-search" aria-hidden="true"></i></label>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <select class="form-control" id="select-column">
                                <option value={{Auth::user()->can('delete', App\Banner::class) ? 3 : 2}}>@lang('Title')</option>
                                <option value={{Auth::user()->can('delete', App\Banner::class) ? 4 : 3}}>@lang('Position in Home Page')</option>
                                <option value={{Auth::user()->can('delete', App\Banner::class) ? 5 : 4}}>@lang('Category')</option>
                                <option value={{Auth::user()->can('delete', App\Banner::class) ? 6 : 5}}>@lang('Position in Category Page')</option>
                                <option value={{Auth::user()->can('delete', App\Banner::class) ? 7 : 6}}>@lang('Brand')</option>
                                <option value={{Auth::user()->can('delete', App\Banner::class) ? 8 : 7}}>@lang('Position in Brand Page')</option>
                                <option value={{Auth::user()->can('delete', App\Banner::class) ? 9 : 8}}>@lang('Status')</option>
                                <option value={{Auth::user()->can('delete', App\Banner::class) ? 10 : 9}}>@lang('Created')</option>
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
                <table class="display table table-striped table-bordered table-hover" id="banners-table">
                    <thead>
                    <tr>
                        @can('delete', App\Banner::class)
                        <th><input type="checkbox" id="options"></th>
                        @endcan
                        <th>@lang('ID')</th>
                        <th>@lang('Image')</th>
                        <th>@lang('Title')</th>
                        <th>@lang('Position in Home Page')</th>
                        <th>@lang('Category')</th>
                        <th>@lang('Position in Category Page')</th>
                        <th>@lang('Brand')</th>
                        <th>@lang('Position in Brand Page')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Created')</th>
                        @if((Auth::user()->can('update', App\Banner::class)) || (Auth::user()->can('delete', App\Banner::class)))
                        <th>@lang('Action')</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @if($banners)
                        @foreach($banners as $banner)
                            <tr>
                                @can('delete', App\Banner::class)
                                <td><input class="checkboxes" type="checkbox" name="checkboxArray[]" value="{{$banner->id}}"></td>
                                @endcan
                                <td>{{$banner->id}}</td>
                                <td>
                                    @if($banner->photo)
                                        @php
                                            $image_url = \App\Helpers\Helper::check_image_avatar($banner->photo->name, 50);
                                        @endphp
                                        <img src="{{$image_url}}" height="50px" alt="{{$banner->title}}"  />
                                    @else
                                        <img src="https://via.placeholder.com/50x50?text=No+Image" height="50px" alt="{{$banner->title}}" />
                                    @endif
                                </td>
                                <td>{{$banner->title}}</td>
                                <td>{{$banner->position}}</td>
                                <td>{{$banner->category ? $banner->category->name . ' (' . __('ID:') . ' ' .$banner->category->id. ')' : '-'}}</td>
                                <td>{{$banner->category ? $banner->position_category : '-'}}</td>
                                <td>{{$banner->brand ? $banner->brand->name . ' (' . __('ID:') . ' ' .$banner->brand->id. ')' : '-'}}</td>
                                <td>{{$banner->brand ? $banner->position_brand : '-'}}</td>
                                <td>{{$banner->is_active ? __('Active') : __('Inactive')}}</td>
                                <td>{{$banner->created_at}}</td>
                                @if((Auth::user()->can('update', App\Banner::class)) || (Auth::user()->can('delete', App\Banner::class)))
                                <td>
                                @can('update', App\Banner::class)
                                    <a href="{{route('manage.banners.edit', $banner->id)}}">
                                        <span class="glyphicon glyphicon-edit"></span>
                                    </a>
                                @endcan
                                &nbsp;
                                @can('delete', App\Banner::class)
                                    <input type="hidden" id="delete_single" name="">
                                    <a href=""
                                       onclick="
                                               if(confirm('Are you sure you want to delete this?')) {
                                                   $('#delete_single').attr('name', 'delete_single').val({{$banner->id}});
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