<div class="panel panel-default">
    <div class="panel-heading">
        @if(!empty($search = request()->s))
            @lang('Showing :total_reviews reviews with :per_page reviews per page for keyword: <strong>:keyword</strong>', ['total_reviews'=>$reviews->total(), 'per_page'=>$reviews->perPage(), 'keyword'=>$search])&nbsp;&nbsp;<a class="text-primary" href="{{url('manage/reviews')}}">@lang('Show all')</a>
        @else
            @lang('Showing :total_reviews orders with :per_page reviews per page', ['total_reviews'=>$reviews->total(), 'per_page'=>$reviews->perPage()])
        @endif
        @if(empty(request()->all))
            <br>
            <a href="{{url('manage/reviews')}}?all=1">@lang('Show reviews in a single page')</a>
        @else
            <br>
            <a href="{{url('manage/reviews')}}">@lang('Show reviews with pagination')</a>
        @endif
    </div>
    <div class="panel-body">
        <form id="action-form" action="set-status/reviews" method="post" class="form-inline">
            <div class="row">
                @if(Auth::user()->can('update-review', App\Review::class) || Auth::user()->can('delete-review', App\Review::class))
                    {{csrf_field()}}
                    <div class="col-md-4">
                        <div class="text-muted">
                            <label for="checkboxArray">@lang('Bulk Options') <i class="fa fa-cog" aria-hidden="true"></i></label>
                        </div>
                        <div class="form-group">
                            <select name="checkboxArray" class="select_action form-control">
                                @can('update-review', App\Review::class)
                                    <option value="approve">@lang('Approve')</option>
                                    <option value="disapprove">@lang('Mark as Pending')</option>
                                @endcan
                                @can('delete-review', App\Review::class)
                                    <option value="delete">@lang('Delete')</option>
                                @endcan
                            </select>
                        </div>

                        <div class="form-group">
                            <input id="action_button" name="" class="btn fa btn-warning" value="&#xf1d8;"
                                   onclick="
                                       if(confirm('Are you sure?')) {
                                           var selectedValue = $('.select_action').val();
                                           if(selectedValue == 'delete') {
                                                $('#action_button').attr('name', 'delete_all');
                                           } else if(selectedValue == 'approve') {
                                                $('#action_button').attr('name', 'approve_all');
                                           } else if(selectedValue == 'disapprove') {
                                                $('#action_button').attr('name', 'disapprove_all');
                                           }

                                           event.preventDefault();
                                            $('#action-form').submit();
                                       } else {
                                            event.preventDefault();
                                       }
                                       "
                            >
                        </div>
                    </div>
                @endif
                <div class="search-box form-inline text-right col-md-{{Auth::user()->can('delete', App\Review::class) ? '8' : '8 col-md-offset-4'}}">
                    @lang('Enter Author name, Product name, Rating or Review Id')<br>
                    <div class="form-group search-field-box">
                        <input type="text" class="form-control" name="search" id="keyword" placeholder="" value="{{request()->s}}">
                    </div>
                    <button data-url="{{url('manage/reviews')}}" type="button" class="btn btn-primary" id="search-btn">@lang('Search')</button>
                </div>
            </div>
            <div class="table-responsive">
                <table id="reviews-table" class="display table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        @if(Auth::user()->can('update-review', App\Review::class) || Auth::user()->can('delete-review', App\Review::class))
                            <th><input type="checkbox" id="options"></th>
                        @endif
                        <th>@lang('ID')</th>
                        <th>@lang('Author')</th>
                        <th>@lang('Product')</th>
                        <th>@lang('Rating')</th>
                        <th>@lang('Comment')</th>
                        <th>@lang('Created')</th>
                        <th>@lang('Status')</th>
                        @can('delete-review', App\Review::class)
                            <th>@lang('Delete')</th>
                        @endcan
                    </tr>
                    </thead>
                    <tbody>
                    @if($reviews)
                        @foreach($reviews as $review)
                            <tr>
                                @if(Auth::user()->can('update-review', App\Review::class) || Auth::user()->can('delete-review', App\Review::class))
                                    <td><input class="checkboxes" type="checkbox" name="checkboxArray[]" value="{{$review->id}}"></td>
                                @endif
                                <td>{{$review->id}}</td>
                                <td>{{$review->user ? $review->user->name .' @'.$review->user->username : '-'}}</td>
                                @if($review->product)
                                    <td><a target="_blank" href="{{route('front.product.show', [$review->product->slug])}}">{{$review->product->name}}</a></td>
                                @else
                                    <td>-</td>
                                @endif
                                <td>{{$review->rating}}</td>
                                <td>{{$review->comment}}</td>
                                <td>{{$review->created_at->toFormattedDateString()}}</td>
                                @if($review->approved == 1)
                                    <td><strong><span class="text-primary">@lang('Approved')</span></strong></td>
                                @else
                                    <td><strong><span class="text-danger">@lang('Pending')</span></strong></td>
                                @endif
                                @can('delete-review', App\Review::class)
                                    <td>
                                        <input type="hidden" id="delete_single" name="">
                                        <a href=""
                                           onclick="
                                                   if(confirm('@lang('Are you sure you want to delete this?')')) {
                                                   $('#delete_single').attr('name', 'delete_single').val({{$review->id}});
                                                   event.preventDefault();
                                                   $('#action-form').submit();
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
        @if(!request()->all)
            <div class="text-right">
                {{$reviews->appends($_GET)->links()}}
            </div>
        @endif
    </div>
</div>