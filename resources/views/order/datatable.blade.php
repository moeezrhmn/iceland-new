@extends('layouts._table')
@section('title','Order')
@section('sub-content')
    <?php
    $tableHeadings = [
        'Title',
        'Username',
        'Email',
        'Price',
        'City',
        'Created',
        'Action',
    ];
    ?>
    <table id="listing" class="table table-striped table-hover tablesaw tablesaw-swipe tablesaw-sortable"
           data-tablesaw-mode="swipe" data-tablesaw-minimap="">
        <thead class="m-datatable__head">
        <tr style="height: 56px; background:#f4f3fb;">
            @foreach($tableHeadings as $heading)
                <th scope="col" data-tablesaw-sortable-col="" data-tablesaw-priority="">
                    {{$heading}}
                </th>
            @endforeach
        </tr>
        </thead>
        <tfoot class="filters">
        <tr>
            @foreach($tableHeadings as $key=> $heading)
                <th>
                    {{$heading}}
                </th>
                @if($key==5)
                    @break
                @endif
            @endforeach
            <td></td>

        </tr>
        </tfoot>
        <tbody class="m-datatable__body">
        @foreach($items as $item)
            <tr data-row="1" style="height: 55px;">
                <td><span>{{$item->title}}</span></td>
                <td><span>{{@$item->username}}</span></td>
                <td><span>{{@$item->email}}</span></td>
                <td><span>{{@$item->price}}</span></td>
                <td><span>{{@$item->city}}</span></td>
                <td><span>{{date('d-m-Y', strtotime($item->created_at))}}</span></td>
                <td>
                    <span>

                        <a href="javascript:void(0);" content="{{json_encode(@$item)}}"
                           class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill orderDetail"
                           title="Details">
                          <i class="la la-eye "></i>
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
    <!--begin::Modal-->
    <div class="modal fade" id="m_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Modal title
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">
												&times;
											</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.

                    </p>
                   {{-- <p>
                        i would like to inform you that i have an piece of work at home on Monday 30th April,2018. .So i am unable to come to the office.Kindly consider my request and grant me full day leave that is  Monday 30th March,2018.  It would be a favor for me.
                    </p>--}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                   {{-- <button type="button" class="btn btn-primary">
                        Save changes
                    </button>--}}
                </div>
            </div>
        </div>
    </div>
    <!--end::Modal-->
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
                deferLoading: [{{$perPage}}, {{$total}}],
                ajax: '{{ route('api.order') }}',
                order: [ [0, 'desc'] ],
                columns: [
                    {data: 'title', name: 'title'},
                    {data: 'username', name: 'username'},
                    {data: 'email', name: 'email'},
                    {data: 'price', name: 'price'},
                    {data: 'city', name: 'city'},
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
            $('.orderDetail').click(function () {
                var data=$(this).attr('content');
               // alert(data)
                var item=JSON.parse(data);
               // alert(item.payment_id)
                $('#m_modal_1').modal('show');



            });

        });

    </script>
@endsection