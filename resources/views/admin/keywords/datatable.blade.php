@extends('layouts._table')
@section('title','Keywords')
@section('create_page_url', route('keywords.create'))
@section('sub-content')
    <?php
    $tableHeadings = [
        'keyword Name',
        'Category',
        'Status',
        'Created',
        
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
             <th style="width: 85px">Action</th>

        </tr>
        </thead>
        <tfoot class="filters">
        <tr>
<td></td>
            @foreach($tableHeadings as $key=> $heading)
                <th>
                    {{$heading}}
                </th>
                @if($key==3)
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
              "pageLength": 25,
              "lengthMenu": [[10, 25, 50,100,250,500,1000, -1], [10, 25, 50,100,250,500,1000, "All"]],
                ajax: '{{ url('admin/keyword-listing') }}',
                
                columns: [
                 {data: 'id', name: 'id'},
                    {data: 'keyword_name', name: 'keyword_name'},
                    {data: 'cat_name', name: 'cat_name'},
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
    table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
        cell.innerHTML = i+1;
    });
}).draw();

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