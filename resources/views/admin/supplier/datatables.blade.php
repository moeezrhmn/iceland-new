@extends('layouts._table')
@section('title','Supplier')
@section('create_page_url', route('suppliers.create'))
@section('sub-content')
    <?php
    $tableHeadings = [
        'Supplier Name',
        'Count',
        'Term',
        'Status',
        'Created'
    ];
    ?>
    <div class="row">
        <div class="col-md-10 listing_main-search">
            {{--<form method="POST" id="search-form" class="form-inline" role="form">--}}
            {{--<div class="col-md-3 col-xs-5 hotel_places_listing">--}}
            {{--<div class="form-group">--}}
            {{--<select class="form-control select2" id="subcategory_id" onchange="$('#listing').DataTable().draw()"  data-placeholder="Select Sub Categories" name="subcat_id">--}}
            {{--@if(sizeof($subcategory))--}}
            {{--<option value="0">Select Sub Categories</option>--}}
            {{--@foreach($subcategory as $row)--}}
            {{--<option  value="{{$row->id}}" >{{ $row->cat_name }}</option>--}}
            {{--<option  @if(isset($_GET['subcat_id']) && $_GET['subcat_id'] ==$row->id) selected="selected" @endif data-{{ $row->id }}="{{ $row->cat_name }}">{{ $row->cat_name }}</option>--}}
            {{--@endforeach--}}
            {{--@endif--}}
            {{--</select>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<!-- <div class="col-md-1 col-xs-2 hotel_places_listing">--}}
            {{--<div class="form_button">--}}
            {{--<button type="submit" class="btn btn-success">--}}
            {{--Search--}}
            {{--</button>--}}
            {{--</div>--}}
            {{--</div> -->--}}
            {{--</form>--}}
        </div>

    </div>

    <div class="m-portlet__head-tools pull-right">
        <ul class="m-portlet__nav" style="list-style-type: none;">
            <li class="m-portlet__nav-item">
                <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                     data-dropdown-toggle="hover" aria-expanded="true">
                    <a href="#"
                       class="m-portlet__nav-link m-portlet__nav-link--icon m-portlet__nav-link--icon-xl m-dropdown__toggle">
                        <i class="la la-plus m--hide"></i>
                        <i class="la la-ellipsis-h m--font-brand"></i>
                    </a>
                    <div class="m-dropdown__wrapper">
                        <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                        <div class="m-dropdown__inner">
                            <div class="m-dropdown__body">
                                <div class="m-dropdown__content">
                                    <ul class="m-nav">
                                        <li class="m-nav__section m-nav__section--first">
                                                                        <span class="m-nav__section-text">
                                                                            Quick Actions
                                                                        </span>
                                        </li>
                                        <li class="m-nav__item">
                                            <a href="{{url('admin/activities/import-excel')}}" class="m-nav__link">
                                                <i class="m-nav__link-icon flaticon-share"></i>
                                                <span class="m-nav__link-text">
                                                                               Import Excel File
                                                                            </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>


    <table id="listing" class="table table-striped table-hover tablesaw tablesaw-swipe tablesaw-sortable"
           data-tablesaw-mode="swipe" data-tablesaw-minimap="">
        <thead class="m-datatable__head">
        <tr style="height: 56px; background:#f4f3fb;">
            <th>Sr#</th>
            @foreach($tableHeadings as $heading)
                <th scope="col" data-tablesaw-sortable-col="" data-tablesaw-priority="">
                    {{$heading}}
                </th>
            @endforeach
            <th style="width: 80px">Action</th>
        </tr>
        </thead>
        {{--<thead class="m-datatable__head">--}}
        {{--<tr style="height: 56px; background:#f4f3fb;">--}}
            {{--<th>Sr#</th>--}}
            {{--<th scope="col" data-sorting="false" data-orderable="false"--}}
                {{--class="tablesaw-cell-persist tablesaw-sortable-head">--}}
                {{--<span>--}}
                    {{--<label class="m-checkbox m-checkbox--single m-checkbox--all m-checkbox--solid m-checkbox--brand">--}}
                        {{--<input id="bulk-opration" type="checkbox">--}}
                        {{--<span></span>--}}
                    {{--</label>--}}
                {{--</span>--}}
            {{--</th>--}}

            {{--@foreach($tableHeadings as $heading)--}}
                {{--<th scope="col" data-tablesaw-sortable-col="" data-tablesaw-priority="">--}}
                    {{--{{$heading}}--}}
                {{--</th>--}}
            {{--@endforeach--}}
            {{--<th style="width: 80px">Action</th>--}}

        {{--</tr>--}}
        {{--</thead>--}}
        <tfoot class="filters">
        <tr>
            <td></td>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <td></td>
        </tr>
        </tfoot>

    </table>
@endsection

@section('table_jquery')
    <script type="application/javascript">
        // Setup - add a text input to each footer cell
        jQuery(document).ready(function ($) {
            $.fn.dataTable.ext.errMode = 'none';

            $('#listing .filters th').each(function () {
                var title = $('#myTable1 .filters th').eq($(this).index()).text();
                $(this).html('<input type="text" style="width: 90%;" placeholder="Search" />');
            });


            var table = $('#listing').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                "pageLength": 25,
                "lengthMenu": [[10, 25, 50, 100, 250, 500, 1000, -1], [10, 25, 50, 100, 250, 500, 1000, "All"]],
                ajax: {
                    url: '{{ url('admin/supplier-listing') }}',

                },
                order: [],
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'supplier_name', name: 'supplier_name'},
                    {data: 'count', name: 'count'},
                    {data: 'term', name: 'term'},
                    {data: 'status', name: 'status'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'actions', name: 'actions', orderable: false, searchable: false}
                ]
            });
            table.columns().eq(0).each(function (colIdx) {
                $('input', table.column(colIdx).footer()).on('keyup change', function () {
                    table.column(colIdx)
                        .search(this.value)
                        .draw();
                });
            });
            table.on('order.dt search.dt', function () {
                table.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
            $('select[name="subcat_id"]').change(function () {

                if (!$(this).val()) {

                    table.columns().search("").draw();
                } else {

                    table.columns().search("");
                    var option = $(this).find(":selected");
                    var columns = Object.keys(option.data());
                    alert(columns)
                    $.each(columns, function (k, v) {
                        table.columns(parseInt(v)).search(option.data(v));
                    });
                    table.draw();
                }
            });

        });


        $(document).ready(function (e) {
            $(document).on('click', '.status-update', function () {
                $('#preloader').show();
                var entity_id = $(this).data("id");
                var model_instace = $('input[name=model_instance]').val();
                var token = '{{csrf_token()}}';
                $.ajax({
                    type: "POST",
                    url: '{{route('status.all') }}',
                    data: {
                        "id": entity_id,
                        "_token": token,
                        "model_instance": model_instace
                    },
                    success: function (data) {
                        $('#listing').DataTable().ajax.reload();
                        $('#preloader').hide();
                    }
                });
            });
        });
    </script>
@endsection
