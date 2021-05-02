@extends('layouts.manage')

@section('title')
    @lang('View Coupons')
@endsection

@section('page-header-title')
    @lang('View Coupons')
    @can('create-coupon', App\Voucher::class)
        <a class="btn btn-sm btn-info" href="{{route('manage.coupons.create')}}">@lang('Add Coupon')</a>
    @endcan
@endsection

@section('page-header-description')
    @lang('View Coupons')
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
            var condition = {{Auth::user()->can('delete-coupon', App\Vo::class) ? 1 : 0}};
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
    <script>
        $(document).ready(function () {
            var table = $('#coupons-table').DataTable({
                responsive: true,
            });
            new $.fn.dataTable.FixedHeader( table );
            searchByColumn( table );
        });
    </script>
    @if(config('settings.toast_notifications_enable'))
    <script>
        toastr.options.closeButton = true;
        @if(session()->has('coupon_created'))
            toastr.success("{{session('coupon_created')}}");
        @endif

        @if(session()->has('coupon_deleted'))
            toastr.success("{{session('coupon_deleted')}}");
        @endif

        @if(session()->has('coupon_not_deleted'))
            toastr.error("{{session('coupon_not_deleted')}}");
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
            @if(session()->has('coupon_created'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{session('coupon_created')}}</strong>
                </div>
            @endif
            @if(session()->has('coupon_deleted'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{session('coupon_deleted')}}</strong>
                </div>
            @endif
            @if(session()->has('coupon_not_deleted'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>{{session('coupon_not_deleted')}}</strong>
                </div>
            @endif
            @include('partials.manage.coupons.index')
        </div>
    </div>
@endsection