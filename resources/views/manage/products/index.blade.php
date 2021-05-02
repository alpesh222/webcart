@extends('layouts.manage')

@section('title')
    @lang('View Products')
@endsection

@section('page-header-title')
    @lang('View Products')
    @if (Auth::user()->can('create', App\Product::class) || isset($vendor))
        <a class="btn btn-sm btn-info" href="{{route('manage.products.create')}}">@lang('Add Product')</a>
    @endif
@endsection

@section('page-header-description')
    @lang('View and Manage Products')
@endsection

@section('styles')
    <!-- DATA TABLE STYLE -->
    <link href="{{asset('css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/dataTables-responsive/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/dataTables-responsive/responsive.bootstrap.min.css')}}" rel="stylesheet">
    @if(config('settings.export_table_enable'))
    <link href="{{asset('css/dataTables-export/buttons.dataTables.min.css')}}" rel="stylesheet">
    @endif
    @include('includes.datatable_style')
@endsection

@section('scripts')
    <!-- DATA TABLE SCRIPTS -->
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/dataTables.bootstrap.min.js')}}"></script>
    @include('partials.manage.dataTables-responsive')
    <script>
        function searchByColumn(table) {
            var condition = {{(Auth::user()->can('delete', App\Product::class) || isset($vendor)) ? 1 : 0}};
            var defaultSearch = (condition ? 3 : 2);
            $('#select-column').on('change', function() {
                defaultSearch = this.value;
                if(defaultSearch == (condition ? 14 : 13)) {
                    $("#search-by-column")
                        .replaceWith('<select class="form-control" id="search-by-column">' +
                            '<option value="">@lang('Choose Option')</option>' +
                            '<option value="active">@lang('active')</option>' +
                            '<option value="inactive">@lang('inactive')</option>' +
                            '</select>');
                } else {
                    $("#search-by-column")
                        .replaceWith('<input class="form-control" type="text" id="search-by-column" placeholder="@lang('Search by Column')">');
                }
            });
            $(document).on('change','#search-by-column', function() {
                table.search( '' ).columns().search( '' ).draw();
                if(defaultSearch == (condition ? 14 : 13)) {
                    table.column(defaultSearch).search( '^' + this.value, true, false).draw();
                } else {
                    table.column(defaultSearch).search(this.value).draw();
                }
            });
        }
    </script>
    @if(config('settings.export_table_enable'))
    @include('partials.manage.dataTables-export')
    <script>
        $(document).ready(function () {
            @if(Auth::user()->can('delete', App\Product::class) || isset($vendor))
                var arrayColumns = [1,3,4,5,6,7,8,9,10,11,12,13,14,15,16];
            @else
                var arrayColumns = [0,2,3,4,5,6,7,8,9,10,11,12,13,14,15];
            @endif
            var table = $('#products-table').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                buttons: [
               {
                   extend: 'pdf',
                   exportOptions: {
                        columns: arrayColumns
                    }
               },
               {
                   extend: 'csv',
                   exportOptions: {
                        columns: arrayColumns
                    }
               },
               {
                   extend: 'excel',
                   exportOptions: {
                        columns: arrayColumns
                    }
               },
               {
                   extend: 'print',
                   exportOptions: {
                        columns: arrayColumns
                    }
               }],
               searching: false, paging: false, info: false
            });
            new $.fn.dataTable.FixedHeader( table );
            searchByColumn( table );
        });
    </script>
    @else
    <script>
        $(document).ready(function () {
            var table = $('#products-table').DataTable({
                responsive: true,
                searching: false, paging: false, info: false
            });
            new $.fn.dataTable.FixedHeader( table );
            searchByColumn( table );
        });
    </script>
    @endif
    @if(config('settings.toast_notifications_enable'))
    <script>
        toastr.options.closeButton = true;
        @if(session()->has('product_created'))
            toastr.success("{{session('product_created')}}");
        @endif

        @if(session()->has('product_deleted'))
            toastr.success("{{session('product_deleted')}}");
        @endif

        @if(session()->has('product_not_deleted'))
            toastr.error("{{session('product_not_deleted')}}");
        @endif
    </script>
    @endif
    @include('includes.form_delete_all_script')
    <script>
        var advancedSearch = $('.advanced-search');
        advancedSearch.hide();
        $(document).on('click', '.advanced-search-toggle', function() {
            advancedSearch.fadeToggle();
        });
        $(document).on('click', '#search-btn', function(e) {
            e.preventDefault();
            var url = $(this).data('url');
            var search = $('#keyword').val();
            var perPage = $('#per_page').val();
            var vendor = $('#vendor').val();
            if(perPage) {
                perPage = parseInt(perPage)
            } else {
                perPage = 15;
            }

            var requestUrl = url + '?s=' + search;


            if(vendor) {
                requestUrl += '&vendor=' + parseInt(vendor);
            }

            var urlParams = new URLSearchParams(window.location.search);
            var all = urlParams.get('all');

            if(parseInt(all) > 0) {
                requestUrl += '&all=' + all;
            } else {
                requestUrl += '&per_page=' + perPage;
            }

            location.href = requestUrl;
        });
    </script>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if(session()->has('product_created'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{session('product_created')}}</strong> <a target="_blank" href="{{route('front.product.show', session('product_view'))}}">View</a>
                </div>
            @endif
            @if(session()->has('product_deleted'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{session('product_deleted')}}</strong>
                </div>
            @endif
            @if(session()->has('product_not_deleted'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{session('product_not_deleted')}}</strong>
                </div>
            @endif
            @include('partials.manage.products.index')
        </div>
    </div>
@endsection