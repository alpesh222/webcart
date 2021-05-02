@extends('layouts.manage')

@section('title')
    @lang('Manage Comparision Groups')
@endsection

@section('page-header-title')
    @lang('Manage Comparision Groups')
@endsection

@section('page-header-description')
    @lang('View and Manage Comparision Groups')
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
            var condition = {{Auth::user()->can('delete', App\ComparisionGroup::class) ? 1 : 0}};
            var defaultSearch = (condition ? 2 : 1);
            $('#select-column').on('change', function() {
                defaultSearch = this.value;
            });
            $('#search-by-column').on('change', function(){
                table.search( '' ).columns().search( '' ).draw();
                table.column(defaultSearch).search(this.value).draw();
            });
        }
    </script>
    @if(config('settings.export_table_enable'))
    @include('partials.manage.dataTables-export')
    <script>
        $(document).ready(function () {
            @if(Auth::user()->can('delete', App\ComparisionGroup::class))
                var arrayColumns = [1,2,3];
            @else
                var arrayColumns = [0,1,2];
            @endif
            var table = $('#comparision_groups-table').DataTable({
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
            var table = $('#comparision_groups-table').DataTable({
                responsive: true
            });
            new $.fn.dataTable.FixedHeader( table );
            searchByColumn( table );
        });
    </script>
    @endif
    @include('includes.form_delete_all_script')
    
    @if(config('settings.toast_notifications_enable'))
    <script>
        toastr.options.closeButton = true;
        @if(session()->has('comparision_group_created'))
            toastr.success("{{session('comparision_group_created')}}");
        @endif

        @if(session()->has('comparision_group_not_created'))
        toastr.error("{{session('comparision_group_not_created')}}");
        @endif

        @if(session()->has('comparision_group_deleted'))
            toastr.success("{{session('comparision_group_deleted')}}");
        @endif

        @if(session()->has('comparision_group_not_deleted'))
            toastr.error("{{session('comparision_group_not_deleted')}}");
        @endif
    </script>
    @endif
    <script>
        var advancedSearch = $('.advanced-search');
        advancedSearch.hide();
        $(document).on('click', '.advanced-search-toggle', function() {
            advancedSearch.fadeToggle();
        });

        $('#add-more-specification').click(function() {
            $('.specification_types_rows > tr:first').clone().appendTo('.specification_types_rows');
        });
        $('#comparision_groups_box').on('click', '.remove_row', function() {
            var rowCount =  $('.specification_types_rows tr').length;
            if(rowCount > 1) {
                $(this).closest('tr').remove();
            }
        });
    </script>

@endsection

@section('content')
    <div class="row">
        @can('create', App\ComparisionGroup::class)
            @include('partials.manage.comparision-groups.create')
        @endcan

        <div class="col-md-12">
            <hr>
            @if(session()->has('comparision_group_deleted'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{session('comparision_group_deleted')}}</strong>
                </div>
            @endif

            @if(session()->has('comparision_group_not_deleted'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{session('comparision_group_not_deleted')}}</strong>
                </div>
            @endif

            @include('partials.manage.comparision-groups.index')
        </div>
    </div>
@endsection