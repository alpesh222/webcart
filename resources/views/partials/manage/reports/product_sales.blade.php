<div class="row">
    <div class="col-md-12">
        <div class="row">

            <div class="col-xs-12 col-sm-8 col-md-6">

                @include('includes.form_errors')

                {!! Form::open(['method'=>'post', 'action'=>'ManageReportsController@product_sales', 'onsubmit'=>'submit_button.disabled = true; submit_button.value = "' . __('Please Wait...') . '"; return true;']) !!}

                <div class="form-group">
                    <div class="product_box">
                        <label for="product[]">@lang('Product:')</label>
                        <select class="form-control" name="product" id="product">
                            <option value="">------------ @lang('All Products') ------------</option>
                            @foreach($products as $key=>$product)
                                <option value="{{$key}}">{{$product}} {{'(' . __('ID:') . ' '.$key.')'}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <hr>
                <div class="form-group{{ $errors->has('period') ? ' has-error' : '' }}">
                    {!! Form::label('period', __('Period:')) !!}
                    {!! Form::select('period', [
                    'Today'=>__('Today'),
                    'Yesterday'=>__('Yesterday'),
                    'Last 7 Days'=>__('Last 7 Days'),
                    'Last 15 Days'=>__('Last 15 Days'),
                    'Last Month'=>__('Last Month'),
                    'Last 6 Months'=>__('Last 6 Months'),
                    'Last Year'=>__('Last Year'),
                    'Current Month' =>__('Current Month'),
                    'Current Year'=>__('Current Year')
                    ], null, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
                </div>

                <hr>
                <div class="form-group{{ $errors->has('group') ? ' has-error' : '' }}">
                    {!! Form::label('group', __('Group:')) !!}
                    {!! Form::select('group', ['Year'=>__('Year'), 'Month'=>__('Month'), 'Day'=>__('Day')], null, ['class'=>'form-control selectpicker', 'data-style'=>'btn-default']) !!}
                </div>

                <div class="form-group">
                    {!! Form::submit(__('Get Sales Report'), ['class'=>'btn btn-primary btn-block', 'name'=>'submit_button']) !!}
                </div>

                {!! Form::close() !!}
            </div>

            <div class="clearfix"></div>
            @if(isset($chartjs_sales))
            <div class="col-lg-10 col-md-12">
                <hr>
                <div class="col-md-12">
                    <div class="chartjs_product_sales">
                        <div class="panel-chart">
                            <div class="panel-heading"><pre>@lang('Sales for') <strong class="text-primary">{{$product_name}}</strong> - <strong class="text-danger"><em>{{$period}}</em></strong></pre></div>
                            <div class="panel-body">
                                {!! $chartjs_sales->render() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
<script>
    document.getElementById("period").value = 'Today';
    document.getElementById("group").value = 'Year';
</script>