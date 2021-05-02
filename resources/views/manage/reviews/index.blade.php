@extends('layouts.manage')

@section('title')
    @lang('View Reviews')
@endsection

@section('page-header-title')
    @lang('View Reviews')
@endsection

@section('page-header-description')
    @lang('View and Manage Reviews')
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
    <style>
        #action_button {
            width: 50px;
        }
    </style>
@endsection

@section('scripts')
    <!-- DATA TABLE SCRIPTS -->
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/dataTables.bootstrap.min.js')}}"></script>
    @include('partials.manage.dataTables-responsive')
    <script>
        function searchByColumn(table) {
            var condition = {{Auth::user()->can('update-review', App\Review::class) || Auth::user()->can('delete-review', App\Review::class) ? 1 : 0}};
            var defaultSearch = (condition ? 2 : 1);
            $('#select-column').on('change', function() {
                defaultSearch = this.value;
                if(defaultSearch == (condition ? 7 : 6)) {
                    $("#search-by-column")
                        .replaceWith('<select class="form-control" id="search-by-column">' +
                            '<option value="">@lang('Choose Option')</option>' +
                            '<option value="Approved">@lang('Approved')</option>' +
                            '<option value="Pending">@lang('Pending')</option>' +
                            '</select>');
                } else {
                    $("#search-by-column")
                        .replaceWith('<input class="form-control" type="text" id="search-by-column" placeholder="@lang('Search by Column')">');
                }
            });
            $('#search-by-column').on('change', function(){
                table.search( '' ).columns().search( '' ).draw();
                if(defaultSearch == 5) {
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
                        @if(Auth::user()->can('delete', App\Review::class))
                var arrayColumns = [1,2,3,4,5,6,7,8,9,10];
                        @else
                var arrayColumns = [0,1,2,3,4,5,6,7,8,9];
                        @endif
                var table = $('#reviews-table').DataTable({
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
                        order: [],
                        searching: false, paging: false, info: false
                    });
                new $.fn.dataTable.FixedHeader( table );
                searchByColumn( table );
            });
        </script>
    @else
        <script>
            $(document).ready(function () {
                var table = $('#reviews-table').DataTable({
                    responsive: true,
                    order: [],
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
        @if(session()->has('review_selected'))
            toastr.success("{{session('review_selected')}}");
        @endif

        @if(session()->has('review_not_selected'))
            toastr.error("{{session('review_not_selected')}}");
        @endif

        @if(session()->has('review_deleted'))
            toastr.success("{{session('review_deleted')}}");
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
            if(perPage) {
                perPage = parseInt(perPage)
            } else {
                perPage = 15;
            }

            var requestUrl = url + '?s=' + search;

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
            @if(session()->has('review_selected'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{session('review_selected')}}</strong>
                </div>
            @endif
            @if(session()->has('review_not_selected'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{session('review_not_selected')}}</strong>
                </div>
            @endif
            @if(session()->has('review_deleted'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{session('review_deleted')}}</strong>
                </div>
            @endif
            @include('partials.manage.reviews.index')
        </div>
    </div>
@endsection