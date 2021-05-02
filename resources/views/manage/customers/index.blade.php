@extends('layouts.manage')

@section('title')
    @lang('View Customers')
@endsection

@section('page-header-title')
    @lang('View Customers')
@endsection

@section('page-header-description')
    @lang('View Customers')
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
            var defaultSearch = 2;
            $('#select-column').on('change', function() {
                defaultSearch = this.value;
            });
            $('#search-by-column').on('change', function(){
                table.search( '' ).columns().search( '' ).draw();
                if(defaultSearch == 6) {
                    table.column(defaultSearch).search( '^' + this.value, true, false).draw();
                } else {
                    table.column(defaultSearch).search(this.value).draw();
                }
            });
        }
        function searchByColumn2(table) {
            var defaultSearch = 1;
            $('#select-column2').on('change', function() {
                defaultSearch = this.value;
            });
            $('#search-by-column2').on('change', function(){
                table.search( '' ).columns().search( '' ).draw();
                table.column(defaultSearch).search(this.value).draw();
            });
        }
    </script>
    @if(config('settings.export_table_enable'))
    @include('partials.manage.dataTables-export')
    <script>
        $(document).ready(function () {
            var arrayColumnsCustomers = [0,1,2,3,4,5,6];
            var table = $('#customers-table').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                buttons: [
               {
                   extend: 'pdf',
                   exportOptions: {
                        columns: arrayColumnsCustomers
                    }
               },
               {
                   extend: 'csv',
                   exportOptions: {
                        columns: arrayColumnsCustomers
                    }
               },
               {
                   extend: 'excel',
                   exportOptions: {
                        columns: arrayColumnsCustomers
                    }
               },
               {
                   extend: 'print',
                   exportOptions: {
                        columns: arrayColumnsCustomers
                    }
                }],
                searching: false, paging: false, info: false
            });
            new $.fn.dataTable.FixedHeader( table );
            searchByColumn2( table );

            @if(Auth::user()->can('read', App\Order::class))
                @if(Auth::user()->can('update-customers', App\Order::class))
                var arrayColumnsUsers = [1,3,4,5,6,7,8,9];
                @else
                var arrayColumnsUsers = [0,2,3,4,5,6,7,8];
                @endif
            @else
                @if(Auth::user()->can('update-customers', App\Order::class))
                var arrayColumnsUsers = [1,3,4,5,6,7,8,9];
                @else
                var arrayColumnsUsers = [0,2,3,4,5,6,7];
                @endif
            @endif
            var table = $('#users-table').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                buttons: [
               {
                   extend: 'pdf',
                   exportOptions: {
                        columns: arrayColumnsUsers
                    }
               },
               {
                   extend: 'csv',
                   exportOptions: {
                        columns: arrayColumnsUsers
                    }
               },
               {
                   extend: 'excel',
                   exportOptions: {
                        columns: arrayColumnsUsers
                    }
               },
               {
                   extend: 'print',
                   exportOptions: {
                        columns: arrayColumnsUsers
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
            var table = $('#customers-table').DataTable({
                responsive: true,
                searching: false, paging: false, info: false
            });
            new $.fn.dataTable.FixedHeader( table );
            searchByColumn2( table );
        });
    </script>
    <script>
        $(document).ready(function () {
            var table = $('#users-table').DataTable({
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
        @if(session()->has('user_created'))
            toastr.success("{{session('user_created')}}");
        @endif
    </script>
    @endif
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

        $(document).on('click', '#search-btn_c', function(e) {
            e.preventDefault();
            var url = $(this).data('url');
            var search = $('#keyword_c').val();
            var perPage = $('#per_page_c').val();
            if(perPage) {
                perPage = parseInt(perPage)
            } else {
                perPage = 15;
            }

            var requestUrl = url + '?s_c=' + search;

            var urlParams = new URLSearchParams(window.location.search);
            var all = urlParams.get('all_c');

            if(parseInt(all) > 0) {
                requestUrl += '&all_c=' + all;
            } else {
                requestUrl += '&per_page_c=' + perPage;
            }
            location.href = requestUrl;
        });
    </script>
    @include('includes.form_delete_all_script')
@endsection

@section('content')
    @include('partials.manage.customers.index')
@endsection