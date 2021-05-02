<div class="panel panel-default">
    <div class="panel-heading">
        @lang('View Testimonials')
    </div>
    <div class="panel-body">
        <form id="delete-form" action="delete/testimonials" method="post" class="form-inline">

            <div class="row">
                @can('delete', App\Testimonial::class)
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
                                       if(confirm('@lang('Are you sure you want to delete selected testimonials?')')) {
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
                <div class="advanced-search col-md-{{Auth::user()->can('delete', App\Testimonial::class) ? '8' : '8 col-md-offset-4'}}">
                    <div class="text-muted">
                        <label for="checkboxArray">@lang('Advanced Search') <i class="fa fa-search" aria-hidden="true"></i></label>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <select class="form-control" id="select-column">
                                <option value={{Auth::user()->can('delete', App\Testimonial::class) ? 3 : 2}}>@lang('Author')</option>
                                <option value={{Auth::user()->can('delete', App\Testimonial::class) ? 4 : 3}}>@lang('Designation')</option>
                                <option value={{Auth::user()->can('delete', App\Testimonial::class) ? 5 : 4}}>@lang('Review')</option>
                                <option value={{Auth::user()->can('delete', App\Testimonial::class) ? 6 : 5}}>@lang('Priority')</option>
                                <option value={{Auth::user()->can('delete', App\Testimonial::class) ? 7 : 6}}>@lang('Status')</option>
                                <option value={{Auth::user()->can('delete', App\Testimonial::class) ? 8 : 7}}>@lang('Created')</option>
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
                <table class="display table table-striped table-bordered table-hover" id="testimonials-table">
                    <thead>
                    <tr>
                        @can('delete', App\Testimonial::class)
                        <th><input type="checkbox" id="options"></th>
                        @endcan
                        <th>@lang('ID')</th>
                        <th>@lang('Photo')</th>
                        <th>@lang('Author')</th>
                        <th>@lang('Designation')</th>
                        <th>@lang('Review')</th>
                        <th>@lang('Priority')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Created')</th>
                        <th>@lang('Action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($testimonials)
                        @foreach($testimonials as $testimonial)
                            <tr>
                                @can('delete', App\Testimonial::class)
                                <td><input class="checkboxes" type="checkbox" name="checkboxArray[]" value="{{$testimonial->id}}"></td>
                                @endcan
                                <td>{{$testimonial->id}}</td>
                                <td>
                                    @if($testimonial->photo)
                                        @php
                                            $image_url = \App\Helpers\Helper::check_image_avatar($testimonial->photo->name, 50);
                                        @endphp
                                        <img src="{{$image_url}}" height="50px" alt="{{$testimonial->author}}"  />
                                    @else
                                        <img src="https://via.placeholder.com/50x50?text=No+Image" height="50px" alt="{{$testimonial->author}}" />
                                    @endif
                                </td>
                                <td>{{$testimonial->author}}</td>
                                <td>{{$testimonial->designation ? $testimonial->designation : '-'}}</td>
                                <td>{{$testimonial->review}}</td>
                                <td>{{$testimonial->priority}}</td>
                                <td>{{$testimonial->is_active ? 'Active' : 'Inactive'}}</td>
                                <td>{{$testimonial->created_at}}</td>
                                <td>
                                    @if((Auth::user()->can('update', App\Testimonial::class)) || (Auth::user()->can('delete', App\Testimonial::class)))
                                        @can('update', App\Testimonial::class)
                                            <a href="{{route('manage.testimonials.edit', $testimonial->id)}}">
                                                <span class="glyphicon glyphicon-edit"></span>
                                            </a>
                                        @endcan
                                        &nbsp;
                                        @can('delete', App\Testimonial::class)
                                            <input type="hidden" id="delete_single" name="">
                                            <a href=""
                                               onclick="
                                                       if(confirm('@lang('Are you sure you want to delete this?')')) {
                                                           $('#delete_single').attr('name', 'delete_single').val({{$testimonial->id}});
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