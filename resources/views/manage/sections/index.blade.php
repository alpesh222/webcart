@extends('layouts.manage')

@section('title')
    @lang('Manage Sections')
@endsection

@section('page-header-title')
    @lang('Manage Sections')
@endsection

@section('page-header-description')
    @lang('View and Manage Sections')
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
        .bolden {
            font-family: "Arial Black";
        }
    </style>
@endsection

@section('scripts')
    <script src="{{asset('js/tinymce/tinymce.min.js')}}"></script>
    @include('includes.tinymce')
    <!-- DATA TABLE SCRIPTS -->
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/dataTables.bootstrap.min.js')}}"></script>
    @include('partials.manage.dataTables-responsive')
    <script>
        function searchByColumn(table) {
            var condition = {{Auth::user()->can('delete', App\Section::class) ? 1 : 0}};
            var defaultSearch = (condition ? 2 : 1);
            $('#select-column').on('change', function() {
                defaultSearch = this.value;
                if(defaultSearch == (condition ? 3 : 4)) {
                    $("#search-by-column")
                        .replaceWith('<select class="form-control" id="search-by-column">' +
                            '<option value="">@lang('Choose Option')</option>' +
                            '<option value="active">@lang('active')</option>' +
                            '<option value="inactive">@lang('inactive')</option>' +
                            '</select>');
                } else if(defaultSearch == (condition ? 2 : 1)) {
                    $("#search-by-column")
                        .replaceWith('<select class="form-control" id="search-by-column">' +
                            '<option value="">@lang('Choose Option')</option>' +
                            '<option value="Above Main Slider">@lang('Above Main Slider')</option>' +
                            '<option value="Below Main Slider">@lang('Below Main Slider')</option>' +
                            '<option value="Above Deal Slider">@lang('Above Deal Slider')</option>' +
                            '<option value="Below Deal Slider">@lang('Below Deal Slider')</option>' +
                            '<option value="Above Footer">@lang('Above Footer')</option>' +
                            '<option value="Above Side Banners">@lang('Above Side Banners')</option>' +
                            '<option value="Below Side Banners">@lang('Below Side Banners')</option>' +
                            '</select>');
                } else {
                    $("#search-by-column")
                        .replaceWith('<input class="form-control" type="text" id="search-by-column" placeholder="@lang('Search by Column')">');
                }
            });
            $(document).on('change','#search-by-column', function() {
                table.search( '' ).columns().search( '' ).draw();
                if(defaultSearch == (condition ? 5 : 4)) {
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
            @if(Auth::user()->can('delete', App\Section::class))
                var arrayColumns = [1,2,3,4];
            @else
                var arrayColumns = [0,1,2,3];
            @endif

            var table = $('#sections-table').DataTable({
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
            searchByColumn(table);
        });
    </script>
    @else
    <script>
        $(document).ready(function () {
            var table = $('#sections-table').DataTable({
                responsive: true,
            });
            new $.fn.dataTable.FixedHeader( table );
            searchByColumn(table);
        });
    </script>
    @endif
    @include('includes.form_delete_all_script')
    
    @if(config('settings.toast_notifications_enable'))
    <script>
        toastr.options.closeButton = true;
        @if(session()->has('section_created'))
            toastr.success("{{session('section_created')}}");
        @endif

        @if(session()->has('section_deleted'))
            toastr.success("{{session('section_deleted')}}");
        @endif

        @if(session()->has('section_not_deleted'))
            toastr.error("{{session('section_not_deleted')}}");
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
        @can('create', App\Section::class)
            @include('partials.manage.sections.create')
        @endcan
    </div>
    <div class="row">
        <div class="col-md-12">
            @if(session()->has('section_deleted'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{session('section_deleted')}}</strong>
                </div>
            @endif

            @if(session()->has('section_not_deleted'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{session('section_not_deleted')}}</strong>
                </div>
            @endif

            @include('partials.manage.sections.index')
        </div>
    </div>
@endsection