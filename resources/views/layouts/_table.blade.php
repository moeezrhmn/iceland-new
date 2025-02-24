@extends('layouts.master')
@section('header_space')
    <link href="{{ asset('assets/datatable/datatable_responsive.css') }}" rel="stylesheet" type="text/css"/>
    {{--<link href="{{ asset('admin/css/jquery.dataTables.css') }}" rel="stylesheet" type="text/css"/>--}}
    {{--<link href="http://cdn.datatables.net/1.10.0/css/jquery.dataTables.css" rel="stylesheet" type="text/css"/>  --}}
    <link rel="stylesheet" href="{{ asset('assets/datatable/jquery.dataTables.min.css') }}">
    <link href="{{ asset('assets/sweet_alert/sweetalert.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">

        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            @include('errors.flash')
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title m-subheader__title--separator">
                        @yield('title')
                    </h3>
                    <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                        <li class="m-nav__item m-nav__item--home">
                            <div class="m-nav__link m-nav__link--icon">
                                <i class="m-nav__link-icon la la-list"></i>
                            </div>
                        </li>
                        <li class="m-nav__item">
                            <a href="{{URL::current()}}" class="m-nav__link">
                                <span class="m-nav__link-text">
                                    All @yield('title')
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
                @hasSection('create_page_url')
                <div class="row">
                    <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                        <a href="@yield('create_page_url')" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span>
                                        Add @yield('title')
                                    </span>
                                </span>
                        </a>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
                @endif

            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                @yield('title') Listing
                            </h3>
                        </div>
                    </div>
                    <!-- <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                                <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                                     data-dropdown-toggle="hover" aria-expanded="true">
                                    <a href="#" class="m-portlet__nav-link m-portlet__nav-link--icon m-portlet__nav-link--icon-xl m-dropdown__toggle">
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
                                                            <a href="" class="m-nav__link">
                                                                <i class="m-nav__link-icon flaticon-share"></i>
                                                                <span class="m-nav__link-text">
																				Create Post
																			</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="" class="m-nav__link">
                                                                <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                                <span class="m-nav__link-text">
																				Send Messages
																			</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="" class="m-nav__link">
                                                                <i class="m-nav__link-icon flaticon-multimedia-2"></i>
                                                                <span class="m-nav__link-text">
																				Upload File
																			</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__section">
																		<span class="m-nav__section-text">
																			Useful Links
																		</span>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="" class="m-nav__link">
                                                                <i class="m-nav__link-icon flaticon-info"></i>
                                                                <span class="m-nav__link-text">
																				FAQ
																			</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="" class="m-nav__link">
                                                                <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                                                <span class="m-nav__link-text">
																				Support
																			</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__separator m-nav__separator--fit m--hide"></li>
                                                        <li class="m-nav__item m--hide">
                                                            <a href="#"
                                                               class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">
                                                                Submit
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
                    </div> -->
                </div>
                <div class="m-portlet__body">
                    <!--begin: Search Form -->
                    <div style="display: none;"
                         class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30 "
                         id="m_datatable_group_action_form">
                        <div class="row align-items-center">
                            <div class="col-xl-12">
                                <div class="m-form__group m-form__group--inline">
                                    <div class="m-form__label m-form__label-no-wrap">
                                        <label class="m--font-bold m--font-danger-">
                                            Selected
                                            <span id="m_datatable_selected_number"></span>
                                            records:
                                        </label>
                                    </div>
                                    <div class="m-form__control">
                                        <div class="btn-toolbar">
                                            <form id="bulk-form" action="{{route('bulk-oprations.all')}}"
                                                  method="post">
                                                {{csrf_field()}}
                                                <input type="hidden" name="all_id">
                                                <input type="hidden" name="action_type">
                                                <input type="hidden" name="category_id" value="@if (isset($category_id))? $category_id : 0  @endif ">
                                                <input type="hidden" name="model_instance" value="{{$modelInstance}}">
                                                <div class="dropdown">
                                                    <button type="button" class="btn btn-accent btn-sm dropdown-toggle"
                                                            data-toggle="dropdown">
                                                        Update status
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                        <button type="submit" value="active"
                                                                class="dropdown-item bulk-action">
                                                            Active
                                                        </button>
                                                        <button type="submit" value="inactive"
                                                                class="dropdown-item bulk-action"
                                                                href="javascript:void(0)">
                                                            Inactive
                                                        </button>
                                                    </div>
                                                </div>
                                                &nbsp;&nbsp;&nbsp;
                                                <button type="submit" value="delete"
                                                        class="btn btn-sm btn-danger bulk-action"
                                                        id="m_datatable_check_all">
                                                    Delete All
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end: Search Form -->
                    <!--begin: Datatable -->
                    <div class="m_datatable">
                        <div class="m_datatable m-datatable m-datatable--default m-datatable--loaded">
                       @yield('sub-content')
                          {{--  <div class="m-datatable__pager m-datatable--paging-loaded clearfix">
                                <ul class="m-datatable__pager-nav">
                                    <li>
                                        <a title="First"
                                           class="m-datatable__pager-link m-datatable__pager-link--first m-datatable__pager-link--disabled"
                                           data-page="1" disabled="disabled"><i class="la la-angle-double-left"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a title="Previous"
                                           class="m-datatable__pager-link m-datatable__pager-link--prev m-datatable__pager-link--disabled"
                                           data-page="1" disabled="disabled"><i class="la la-angle-left"></i>
                                        </a>
                                    </li>
                                    <li style="display: none;">
                                        <a title="More pages" class="m-datatable__pager-link m-datatable__pager-link--more-prev"
                                           data-page="1"><i class="la la-ellipsis-h"></i></a>
                                    </li>
                                    <li style="display: none;"><input type="text" class="m-pager-input form-control"
                                                                      title="Page number"></li>
                                    <li style=""><a
                                                class="m-datatable__pager-link m-datatable__pager-link-number m-datatable__pager-link--active"
                                                data-page="1">1</a></li>
                                    <li style="display: none;"><a title="More pages"
                                                                  class="m-datatable__pager-link m-datatable__pager-link--more-next"
                                                                  data-page="1"><i class="la la-ellipsis-h"></i></a>
                                    </li>
                                    <li><a title="Next"
                                           class="m-datatable__pager-link m-datatable__pager-link--next m-datatable__pager-link--disabled"
                                           data-page="1" disabled="disabled"><i class="la la-angle-right"></i></a>
                                    </li>
                                    <li><a title="Last"
                                           class="m-datatable__pager-link m-datatable__pager-link--last m-datatable__pager-link--disabled"
                                           data-page="1" disabled="disabled"><i
                                                    class="la la-angle-double-right"></i></a></li>
                                </ul>
                            </div>--}}
                        </div>
                        <!--end: Datatable -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer_space')
    <script src="{{ asset('assets/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/sweet_alert/sweet-alert.js') }}"></script>
   
    @yield('table_jquery')
    <script>
        $('body').on('click', '.delete', function () {
                var entity_id = $(this).data("id");
                 var category_id = $('input[name=category_id]').val();
                var model_instace = $('input[name=model_instance]').val();
                var token = '{{csrf_token()}}';
                swal({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    // confirmButtonColor: '#3085d6',
                    // cancelButtonColor: '#d33',
                    showLoaderOnConfirm: true,
                    buttons: [
                        'No, cancel it!',
                        'Yes, I am sure!'
                    ],
                    dangerMode: true,
                    // allowOutsideClick: false

                }).then(function (isConfirm) {
                    if (isConfirm) {
                        $.ajax(
                            {
                                url:'{{route('delete.all')}}',
                                type: 'POST',
                                data: {
                                    "id": entity_id,
                                    "_token": token,
                                    "model_instance": model_instace,
                                    "category_id": category_id
                                },
                                success: function (res) {
                                    swal({
                                        title: res['status'],
                                        text: res['message'],
                                        type: res['status'],
                                        showConfirmButton: true,
                                        timer: 5000,
                                        icon: 'success'
                                    }).then(function () {
                                        $('#listing').DataTable().ajax.reload();
                                    });
                                },
                                error: function (res) {
                                    swal({
                                        title: res['status'],
                                        text: res['message'],
                                        type: res['status'],
                                        showConfirmButton: true,
                                        // timer: 50000
                                    }).then(function () {
                                        // location.reload();
                                    });
                                }
                            });

                    } else {
                        swal("Cancelled", "Your Record is safe :)", "error");
                    }
                });


            delete_entity_with_sweetalert.call(this,"{{'App/User'}}");
        });
        jQuery(document).ready(function ($) {
            /////////////////when click on a heading check box
            $("#bulk-opration").click(function () {
                var isCheck = $(this).is(":checked")
                if (isCheck == true) {
                    $('#m_datatable_group_action_form').show(500);
                } else {
                    $('#m_datatable_group_action_form').hide(500);
                }
                $('.bulk-opration').not(this).prop('checked', this.checked);
                var checked = []
                $("input[name='id[]']:checked").each(function () {
                    checked.push($(this).val());
                    $('input[name=all_id]').attr('value', checked);
                });

            });
            $(document).on('click', '.bulk-opration', function () {
                var length = $('.bulk-opration:checked').length;
                if (length >0 ) {
                    $('#m_datatable_group_action_form').show(500);
                } else {
                    $('#m_datatable_group_action_form').hide(500);
                }
                var checked = []
                $("input[name='id[]']:checked").each(function () {
                    checked.push($(this).val());
                    $('input[name=all_id]').attr('value', checked);
                });

            });
            // set action type
            $('.bulk-action').on('click', function (e) {
                $('input[name=action_type]').val($(this).val())
            });
        });
    </script>
@stop
