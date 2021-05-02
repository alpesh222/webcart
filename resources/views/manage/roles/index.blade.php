@extends('layouts.manage')

@section('title')
    @lang('View Roles')
@endsection

@section('page-header-title')
    @lang('View Roles')
    @can('create', App\Role::class)
        <a class="btn btn-sm btn-info" href="{{route('manage.roles.create')}}">@lang('Add Role')</a>
    @endcan
    @can('update', App\User::class)
        <a class="text-info pull-right" href="{{route('manage.users.index')}}"><h5 class="text-primary">@lang('Assign Role to User')</h5></a>
    @endcan
@endsection

@section('page-header-description')
    @lang('View and Manage Roles')
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
            var condition = {{Auth::user()->can('delete', App\Role::class) ? 1 : 0}};
            var defaultSearch = (condition ? 2 : 1);
            $('#select-column').on('change', function() {
                defaultSearch = this.value;
            });
            $('#search-by-column').on('change', function(){
                table.search( '' ).columns().search( '' ).draw();
                if(defaultSearch == (condition ? 2 : 1)) {
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
                if(defaultSearch == 1) {
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
            @if(Auth::user()->can('delete', App\Role::class))
                var arrayColumns = [1,2];
            @else
                var arrayColumns = [0,1];
            @endif
            var table = $('#roles-table').DataTable({
                responsive: true,
                dom: 'lBfrtip',
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
                }]
            });
            new $.fn.dataTable.FixedHeader( table );
            searchByColumn( table );

            var arrayColumns2 = [0,1,2];
            var table2 = $('#roles-permissions-table').DataTable({
                responsive: true,
                dom: 'lBfrtip',
                buttons: [
               {
                   extend: 'pdf',
                   exportOptions: {
                        columns: arrayColumns2
                    }
               },
               {
                   extend: 'csv',
                   exportOptions: {
                        columns: arrayColumns2
                    }
               },
               {
                   extend: 'excel',
                   exportOptions: {
                        columns: arrayColumns2
                    }
               },
               {
                   extend: 'print',
                   exportOptions: {
                        columns: arrayColumns2
                    }
                }]
            });
            new $.fn.dataTable.FixedHeader( table2 );
            searchByColumn2( table2 );
        });
    </script>
    @else
    <script>
        $(document).ready(function () {
            var table = $('#roles-table').DataTable({
                responsive: true,
            });
            new $.fn.dataTable.FixedHeader( table );
            searchByColumn(table);

            var table2 = $('#roles-permissions-table').DataTable({
                responsive: true,
            });
            new $.fn.dataTable.FixedHeader( table2 );
            searchByColumn2(table2);
        });
    </script>
    @endif
    @include('includes.form_delete_all_script')
    @if(config('settings.toast_notifications_enable'))
    <script>
        toastr.options.closeButton = true;
        @if(session()->has('role_created'))
            toastr.success("{{session('role_created')}}");
        @endif

        @if(session()->has('role_deleted'))
            toastr.success("{{session('role_deleted')}}");
        @endif

        @if(session()->has('role_not_deleted'))
            toastr.error("{{session('role_not_deleted')}}");
        @endif
    </script>
    @endif
    <script>
        var advancedSearch = $('.advanced-search');
        advancedSearch.hide();
        $(document).on('click', '.advanced-search-toggle', function() {
            advancedSearch.fadeToggle();
        });
    </script>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if(session()->has('role_created'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{session('role_created')}}</strong>
                </div>
            @endif
            @if(session()->has('role_deleted'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{session('role_deleted')}}</strong>
                </div>
            @endif
            @if(session()->has('role_not_deleted'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{session('role_not_deleted')}}</strong>
                </div>
            @endif
            @include('partials.manage.roles.index')
        </div>
    </div>
@endsection