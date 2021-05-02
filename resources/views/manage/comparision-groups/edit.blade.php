@extends('layouts.manage')

@section('title')
    @lang('Edit Specification Types')
@endsection

@section('page-header-title')
    @lang('Edit Comparision Group') <a class="btn btn-sm btn-info" href="{{route('manage.comparision-group.index')}}">@lang('View Comparision Groups')</a>
@endsection

@section('page-header-description')
    @lang('Edit Comparision Group') <a href="{{route('manage.comparision-group.index')}}">@lang('Go Back')</a>
@endsection

@section('scripts')
    @if(config('settings.toast_notifications_enable'))
    <script>
        toastr.options.closeButton = true;
        @if(session()->has('comparision_group_updated'))
            toastr.success("{{session('comparision_group_updated')}}");
        @endif
    </script>
    @endif
    <script>
        $('#add-more-specification').click(function() {
            var total_comparisions = $('.specification_types_rows > tr').length + 1;
            $icon_html = '" <td>' +
                                '<label for="comparision_type_icon[comp_icon_'+total_comparisions+']" class="btn btn-default btn-file">Choose a Icon</label> ' +
                                '<input class="form-control" style="display: none;" onchange="$(&quot;#upload-file-name-'+total_comparisions+'&quot;).html(files[0].name)" name="comparision_type_icon[comp_icon_'+total_comparisions+']" type="file" id="comparision_type_icon[comp_icon_'+total_comparisions+']"> ' +
                                '<span class="label label-info" id="upload-file-name-'+total_comparisions+'">No file chosen</span>' +
                            '</td>';
            var first_comparision = $('.specification_types_rows > tr:first').clone()[0];
            var comparision_cells = first_comparision.cells;
            var html = '<tr>'+ comparision_cells[0].outerHTML + $icon_html + comparision_cells[2].outerHTML + '</tr>';
            console.log(html);
            // html.appendTo('.specification_types_rows');
            $('.specification_types_rows').append(html);
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
    @include('partials.manage.comparision-groups.edit')
@endsection