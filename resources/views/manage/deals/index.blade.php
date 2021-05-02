@extends('layouts.manage')

@section('title')
    @lang('View Deals')
@endsection

@section('page-header-title')
    @lang('View Deals')
    @can('create', App\Deal::class)
        <a class="btn btn-sm btn-info" href="{{route('manage.deals.create')}}">@lang('Add Deal')</a>
    @endcan
@endsection

@section('page-header-description')
    @lang('View and Manage Deals')
@endsection

@section('styles')
    <!-- DATA TABLE STYLE -->
    <link href="{{asset('css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/dataTables-responsive/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/dataTables-responsive/responsive.bootstrap.min.css')}}" rel="stylesheet">
    @include('includes.datatable_style')
@endsection

@section('scripts')
    <!-- DATA TABLE SCRIPTS -->
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/dataTables.bootstrap.min.js')}}"></script>
    @include('partials.manage.dataTables-responsive')
    <script>
        function searchByColumn(table) {
            var condition = {{Auth::user()->can('delete', App\Deal::class) ? 1 : 0}};
            var defaultSearch = (condition ? 2 : 1);
            $('#select-column').on('change', function() {
                defaultSearch = this.value;
                if(defaultSearch == (condition ? 4 : 3)) {
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
                table.column(defaultSearch).search(this.value).draw();
            });
        }
    </script>
    <script>
        $(document).ready(function () {
            var table = $('#deals-table').DataTable({
                responsive: true,
            });
            new $.fn.dataTable.FixedHeader( table );
            searchByColumn( table );
        });
    </script>
    @if(config('settings.toast_notifications_enable'))
    <script>
        toastr.options.closeButton = true;
        @if(session()->has('deal_created'))
            toastr.success("{{session('deal_created')}}");
        @endif

        @if(session()->has('deal_deleted'))
            toastr.success("{{session('deal_deleted')}}");
        @endif

        @if(session()->has('deal_not_deleted'))
            toastr.error("{{session('deal_not_deleted')}}");
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
            @if(session()->has('deal_created'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{session('deal_created')}}</strong>
                </div>
            @endif
            @if(session()->has('deal_deleted'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{session('deal_deleted')}}</strong>
                </div>
            @endif
            @if(session()->has('deal_not_deleted'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{session('deal_not_deleted')}}</strong>
                </div>
            @endif
            @include('partials.manage.deals.index')
        </div>
    </div>
@endsection