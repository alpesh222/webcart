@extends('layouts.manage')

@section('title')
    @lang('View Staff')
@endsection

@section('page-header-title')
    @lang('View Staff')
    @can('create', App\User::class)
        <a class="btn btn-sm btn-info" href="{{route('manage.users.create')}}">@lang('Add Staff')</a>
    @endcan
@endsection

@section('page-header-description')
    @lang('View and Manage Staff')
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
                if(defaultSearch == 5 || defaultSearch == 6) {
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
            var arrayColumns = [0,2,3,4,5,6];
            var table = $('#users-table').DataTable({
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
                }]
            });
            new $.fn.dataTable.FixedHeader( table );
            searchByColumn( table );
        });
    </script>
    @else
    <script>
        $(document).ready(function () {
            var table = $('#users-table').DataTable({
                responsive: true,
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
        @if(session()->has('user_updated'))
            toastr.success("{{session('user_updated')}}");
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
            @if(session()->has('user_created'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{session('user_created')}}</strong>
                </div>
            @endif
            @if(session()->has('user_updated'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{session('user_updated')}}</strong>
                </div>
            @endif
            @include('partials.manage.users.index')
        </div>
    </div>
@endsection