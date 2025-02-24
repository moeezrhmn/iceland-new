@extends('layouts._table')
@section('title','Permission')
@section('create_page_url', route('permission.create'))
@section('sub-content')
    <?php
    $tableHeadings = [
        'Name',
        'Type',
        'Created',
        'Action',
    ];
    ?>

    <table id="listing" class="table table-striped table-hover tablesaw tablesaw-swipe tablesaw-sortable"
           data-tablesaw-mode="swipe" data-tablesaw-minimap="">
        <thead class="m-datatable__head">
        <tr style="height: 56px; background:#f4f3fb;">
            <th>SR#</th>
            @foreach($tableHeadings as $heading)
                <th scope="col" data-tablesaw-sortable-col="" data-tablesaw-priority="">
                    {{$heading}}
                </th>
            @endforeach

        </tr>
        </thead>
        <tfoot class="filters">
        <tr>
            <td></td>
            @foreach($tableHeadings as $key=> $heading)
                <th>
                    {{$heading}}
                </th>
                @if($key==2)
                    @break
                @endif
            @endforeach

        </tr>
        </tfoot>
        
    </table>
@endsection
@section('table_jquery')
    <script type="application/javascript">
        // Setup - add a text input to each footer cell
        jQuery(document).ready(function ($) {
            $('#listing .filters th').each(function () {
                var title = $('#myTable1 .filters th').eq($(this).index()).text();
                $(this).html('<input type="text" style="width: 90%;" placeholder="Search" />');
            });
            var table=  $('#listing').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
            "pageLength": 20,
                ajax: '{{ route('api.permission') }}',
                order: [ [0, 'desc'] ],
                columns: [
                    {data: 'id', name: 'id'},
                       {data: 'name', name: 'name'},
                    {data: 'type', name: 'type'},
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
                table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                  cell.innerHTML = i+1;
           });
                }).draw();

        });

    </script>
@endsection