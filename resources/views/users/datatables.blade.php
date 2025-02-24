@extends('layouts._table')
@section('title','Administrators')
@section('create_page_url', route('users.create'))
@section('sub-content')
    <?php
    $tableHeadings = [
        'Name',
        'Email',
        'Status',
        'Created',
        'Action',
    ];
    ?>
    <table id="listing" class="table table-striped table-hover tablesaw tablesaw-swipe tablesaw-sortable"
           data-tablesaw-mode="swipe" data-tablesaw-minimap="">
        <thead class="m-datatable__head">
        <tr style="height: 56px; background:#f4f3fb;">
            <th scope="col" data-sorting="false" data-orderable="false"
                class="tablesaw-cell-persist tablesaw-sortable-head">
                <span>
                    <label class="m-checkbox m-checkbox--single m-checkbox--all m-checkbox--solid m-checkbox--brand">
                        <input id="bulk-opration" type="checkbox">
                        <span></span>
                    </label>
                </span>
            </th>
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
                @if($key==3)
                    @break
                @endif
            @endforeach
            <td></td>
        </tr>
        </tfoot>
        <tbody class="m-datatable__body">
        @foreach($items as $item)
            <tr data-row="1" style="height: 55px;">
                <td data-field="RecordID" class="title tablesaw-cell-persist">
                    <span>
                        <label class="m-checkbox m-checkbox--single m-checkbox--all m-checkbox--solid m-checkbox--brand boday_check_box">
                            <input name="id[]" class="bulk-opration" type="checkbox" value="{{$item->id}}">
                            <span></span>
                        </label>
                    </span>
                </td>
                <td>
                    <span>{{$item->name}}</span>
                </td>
                <td>
                    <span>{{$item->email}}</span>
                </td>
                <td>
                    <span>  @if ($item->status == "Active")
                            <span style="width: 110px;">
                            <span class="m-badge  m-badge--success m-badge--wide">Active</span>
                        </span>
                        @else
                            <span style="width: 110px;">
                            <span class="m-badge  m-badge--danger m-badge--wide">Inactive</span>
                    </span>
                        @endif
            </span>
                </td>
                <td>
                    <span>
                        {{date('d-m-Y', strtotime($item->created_at))}}
                    </span>
                </td>
                <td>
                    <span>
                        <div class="dropdown ">
                            <a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                               data-toggle="dropdown">
                                <i class="la la-ellipsis-h"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a data-id="{{$item->id}}" class="dropdown-item  status-update"
                                   href="javascript:void(0)">
                                    <i class="la la-print"></i> Update Status
                                </a>
                            </div>
                        </div>
                        <a href="{{route('users.edit',$item->id)}}"
                           class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                           title="Edit details">
                            <i class="la la-edit"></i>
                        </a>
                        <a data-id="{{$item->id}}" href="javascript:void(0)"
                           class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete"
                           title="Delete">
                            <i class="la la-trash"></i>
                        </a>
                    </span>
                </td>

            </tr>
        @endforeach
        </tbody>
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
                deferLoading: [0],
                deferLoading: [{{$perPage}}, {{$total}}],
                ajax: '{{ route('api.users') }}',
                order: [],

                columns: [
                    {data: 'id', name: 'id', orderable: false, searchable: false},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
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