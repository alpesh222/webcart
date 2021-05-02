@extends('layouts.manage')

@section('title')
    @lang('View Shipments')
@endsection

@section('page-header-title')
    @lang('View Shipments')
    @can('create', App\Shipment::class)
        <a class="btn btn-sm btn-info" href="{{route('manage.shipments.create')}}">@lang('Add Shipment')</a>
    @endcan
@endsection

@section('page-header-description')
    @lang('View and Manage Shipments')
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
            var condition = {{Auth::user()->can('delete', App\Shipment::class) ? 1 : 0}};
            var defaultSearch = (condition ? 2 : 1);
            $('#select-column').on('change', function() {
                defaultSearch = this.value;
            });
            $(document).on('change','#search-by-column', function() {
                table.search( '' ).columns().search( '' ).draw();
                table.column(defaultSearch).search(this.value).draw();
            });
        }
    </script>
    @if(config('settings.export_table_enable'))
    @include('partials.manage.dataTables-export')
    <script>
        $(document).ready(function () {
            @if(Auth::user()->can('delete', App\Shipment::class))
                var arrayColumns = [1,2,3,4,5,6,7,8,9];
            @else
                var arrayColumns = [0,1,2,3,4,5,6,7,8];
            @endif
            var table = $('#shipments-table').DataTable({
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
        });
    </script>
    @else
    <script>
        $(document).ready(function () {
            var table = $('#shipments-table').DataTable({
                responsive: true,
            });
            new $.fn.dataTable.FixedHeader( table );
            searchByColumn(table);
        });
    </script>
    @endif
    @if(config('settings.toast_notifications_enable'))
    <script>
        toastr.options.closeButton = true;
        @if(session()->has('shipment_created'))
            toastr.success("{{session('shipment_created')}}");
        @endif

        @if(session()->has('shipment_deleted'))
            toastr.success("{{session('shipment_deleted')}}");
        @endif

        @if(session()->has('shipment_not_deleted'))
            toastr.error("{{session('shipment_not_deleted')}}");
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
    </script>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if(session()->has('shipment_created'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{session('shipment_created')}}</strong>
                </div>
            @endif
            @if(session()->has('shipment_deleted'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{session('shipment_deleted')}}</strong>
                </div>
            @endif
            @if(session()->has('shipment_not_deleted'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{session('shipment_not_deleted')}}</strong>
                </div>
            @endif
            @include('partials.manage.shipments.index')
        </div>
    </div>
@endsection