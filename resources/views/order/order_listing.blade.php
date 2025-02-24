@extends('layouts.master')
@section('title', trans('general.heading.users'))
@section('header_space')
    <link href="{{ asset('assets/datatable/datatable_responsive.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
@endsection
@section('title_right_section')
    <a href="{{ 'admin::users.create'}}" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill btn btn-success pull-right">asdfsadf</a>
@endsection
@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title m-subheader__title--separator">
                        Responsive Columns
                    </h3>
                    <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                        <li class="m-nav__item m-nav__item--home">
                            <a href="#" class="m-nav__link m-nav__link--icon">
                                <i class="m-nav__link-icon la la-home"></i>
                            </a>
                        </li>
                        <li class="m-nav__separator">
                            -
                        </li>
                        <li class="m-nav__item">
                            <a href="" class="m-nav__link">
                                <span class="m-nav__link-text">
                                    Datatables
                                </span>
                            </a>
                        </li>
                        <li class="m-nav__separator">
                            -
                        </li>
                        <li class="m-nav__item">
                            <a href="" class="m-nav__link">
                                <span class="m-nav__link-text">
                                    Base
                                </span>
                            </a>
                        </li>
                        <li class="m-nav__separator">
                            -
                        </li>
                        <li class="m-nav__item">
                            <a href="" class="m-nav__link">
                                <span class="m-nav__link-text">
                                    Responsive Columns
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div>
                    <div class="row">
                        <div class="col-xl-4 order-1 order-xl-2 m--align-right">
                            <a href="#" class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span>
                                        New Order
                                    </span>
                                </span>
                            </a>
                            <div class="m-separator m-separator--dashed d-xl-none"></div>
                        </div>
                    </div>
                    {{--<div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"--}}
                    {{--data-dropdown-toggle="hover" aria-expanded="true">--}}
                    {{--<a href="#"--}}
                    {{--class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--outline-2x m-btn--air m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">--}}
                    {{--<i class="la la-plus m--hide"></i>--}}
                    {{--<i class="la la-ellipsis-h"></i>--}}
                    {{--</a>--}}
                    {{--<div class="m-dropdown__wrapper">--}}
                    {{--<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>--}}
                    {{--<div class="m-dropdown__inner">--}}
                    {{--<div class="m-dropdown__body">--}}
                    {{--<div class="m-dropdown__content">--}}
                    {{--<ul class="m-nav">--}}
                    {{--<li class="m-nav__section m-nav__section--first m--hide">--}}
                    {{--<span class="m-nav__section-text">--}}
                    {{--Quick Actions--}}
                    {{--</span>--}}
                    {{--</li>--}}
                    {{--<li class="m-nav__item">--}}
                    {{--<a href="" class="m-nav__link">--}}
                    {{--<i class="m-nav__link-icon flaticon-share"></i>--}}
                    {{--<span class="m-nav__link-text">--}}
                    {{--Activity--}}
                    {{--</span>--}}
                    {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="m-nav__item">--}}
                    {{--<a href="" class="m-nav__link">--}}
                    {{--<i class="m-nav__link-icon flaticon-chat-1"></i>--}}
                    {{--<span class="m-nav__link-text">--}}
                    {{--Messages--}}
                    {{--</span>--}}
                    {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="m-nav__item">--}}
                    {{--<a href="" class="m-nav__link">--}}
                    {{--<i class="m-nav__link-icon flaticon-info"></i>--}}
                    {{--<span class="m-nav__link-text">--}}
                    {{--FAQ--}}
                    {{--</span>--}}
                    {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="m-nav__item">--}}
                    {{--<a href="" class="m-nav__link">--}}
                    {{--<i class="m-nav__link-icon flaticon-lifebuoy"></i>--}}
                    {{--<span class="m-nav__link-text">--}}
                    {{--Support--}}
                    {{--</span>--}}
                    {{--</a>--}}
                    {{--</li>--}}
                    {{--<li class="m-nav__separator m-nav__separator--fit"></li>--}}
                    {{--<li class="m-nav__item">--}}
                    {{--<a href="#"--}}
                    {{--class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">--}}
                    {{--Submit--}}
                    {{--</a>--}}
                    {{--</li>--}}
                    {{--</ul>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                </div>
            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content">
            <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Static Datatable
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
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
                    </div>
                </div>
                <div class="m-portlet__body">
                    <!--begin: Search Form -->
                    <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30">
                        <div class="row align-items-center">
                            <div class="col-xl-8 order-2 order-xl-1">
                                <div class="form-group m-form__group row align-items-center">
                                    <div class="col-md-4">
                                        <div class="m-input-icon m-input-icon--left">
                                            <input type="text" class="form-control m-input" placeholder="Search..."
                                                   id="m_form_search">
                                            <span class="m-input-icon__icon m-input-icon__icon--left">
                                                <span>
                                                    <i class="la la-search"></i>
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="m-form m-form--label-align-right m--margin-top-20 m--margin-bottom-30 "
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
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-accent btn-sm dropdown-toggle"
                                                        data-toggle="dropdown">
                                                    Update status
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                    <a class="dropdown-item" href="#">
                                                        Pending
                                                    </a>
                                                    <a class="dropdown-item" href="#">
                                                        Delivered
                                                    </a>
                                                    <a class="dropdown-item" href="#">
                                                        Canceled
                                                    </a>
                                                </div>
                                            </div>
                                            &nbsp;&nbsp;&nbsp;
                                            <button class="btn btn-sm btn-danger" type="button"
                                                    id="m_datatable_check_all">
                                                Delete All
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end: Search Form -->
                    <!--begin: Datatable -->
                    <div class="m_datatable">
                        <div class="m_datatable m-datatable m-datatable--default m-datatable--loaded" id="record_selection" style="">
                            <table class="table table-striped table-hover tablesaw tablesaw-swipe tablesaw-sortable"
                                   data-tablesaw-mode="swipe" data-tablesaw-minimap="">
                                <thead class="m-datatable__head">
                                <tr class="m-datatable__row" style="height: 56px; background:#f4f3fb;">
                                    <th scope="col" data-tablesaw-sortable-col=""
                                        data-tablesaw-priority="persist"
                                        class="tablesaw-cell-persist" style="">
                                            <span>
                                                <label class="m-checkbox m-checkbox--single m-checkbox--all m-checkbox--solid m-checkbox--brand">
                                                    <input type="checkbox">
                                                    <span></span>
                                                </label>
                                            </span>
                                    </th>
                                    <th scope="col" data-tablesaw-sortable-col=""
                                        data-tablesaw-priority="persist" class="tablesaw-cell-persist">
                                        <span>Order ID</span>
                                    </th>
                                    <th scope="col" data-tablesaw-sortable-col=""
                                        data-tablesaw-priority="">
                                        <span>Ship City</span>
                                    </th>
                                    <th scope="col" data-tablesaw-sortable-col=""
                                        data-tablesaw-priority="">
                                        <span>Website</span>
                                    </th>
                                    <th scope="col" data-tablesaw-sortable-col="" data-tablesaw-priority="">
                                        <span>Department</span>
                                    </th>
                                    <th scope="col" data-tablesaw-sortable-col=""
                                        data-tablesaw-priority="">
                                        <span>Ship Date</span>
                                    </th>
                                    <th scope="col" data-tablesaw-sortable-col=""
                                        data-tablesaw-priority="">
                                        <span>Actions</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="m-datatable__body" style="">
                                <tr data-row="0" class="m-datatable__row m-datatable__row--even"
                                    style="height: 55px;">
                                    <td class="title tablesaw-cell-persist">
                                            <span>
                                                <label class="m-checkbox m-checkbox--single m-checkbox--all m-checkbox--solid m-checkbox--brand boday_check_box">
                                                    <input type="checkbox" value="1">
                                                    <span></span>
                                                </label>
                                            </span>
                                    </td>
                                    <td class="title tablesaw-cell-persist"><span>53150-422</span>
                                    </td>
                                    <td><span>Qaram Qōl</span>
                                    </td>
                                    <td><span>dropbox.com</span>
                                    </td>
                                    <td><span>Baby</span></td>
                                    <td><span>5/20/2017</span>
                                    </td>
                                    <td>
                                        <span>
                                            <div class="dropdown ">
                                                <a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown">
                                                    <i class="la la-ellipsis-h"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#">
                                                        <i class="la la-edit"></i> Edit Details
                                                    </a>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="la la-leaf"></i> Update Status
                                                    </a>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="la la-print"></i> Generate Report
                                                    </a>
                                                </div>
                                            </div>
                                            <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">
                                                <i class="la la-edit"></i>
                                            </a>
                                            <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">
                                                <i class="la la-trash"></i>
                                            </a>
                                        </span>
                                    </td>
                                </tr>
                                <tr data-row="1" class="m-datatable__row" style="height: 55px;">
                                    <td data-field="RecordID" class="title tablesaw-cell-persist">
                                        <span>
                                            <label class="m-checkbox m-checkbox--single m-checkbox--all m-checkbox--solid m-checkbox--brand boday_check_box">
                                                <input type="checkbox" value="2">
                                                <span></span>
                                            </label>
                                        </span>
                                    </td>
                                    <td data-field="OrderID" class="title tablesaw-cell-persist">
                                        <span>49999-763</span>
                                    </td>
                                    <td data-field="ShipCity" class="">
                                        <span>Mogok</span>
                                    </td>
                                    <td data-field="Website" class="">
                                        <span>cafepress.com</span>
                                    </td>
                                    <td data-field="Department" class="">
                                        <span>Outdoors</span></td>
                                    <td data-field="ShipDate" class="">
                                        <span>11/28/2016</span>
                                    </td>
                                    <td data-field="Actions" class="">
                                        <span>
                                            <div class="dropdown ">
                                                <a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                                                   data-toggle="dropdown">
                                                    <i class="la la-ellipsis-h"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#">
                                                        <i class="la la-edit"></i> Edit Details
                                                    </a>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="la la-leaf"></i> Update Status
                                                    </a>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="la la-print"></i> Generate Report
                                                    </a>
                                                </div>
                                            </div>
                                            <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                                               title="Edit details">
                                                <i class="la la-edit"></i>
                                            </a>
                                            <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill"
                                               title="Delete">
                                                <i class="la la-trash"></i>
                                            </a>
                                        </span>
                                    </td>
                                </tr>
                                <tr data-row="2" class="m-datatable__row m-datatable__row--even"
                                    style="height: 55px;">
                                    <td class="title tablesaw-cell-persist">
                                            <span>
                                                <label class="m-checkbox m-checkbox--single m-checkbox--all m-checkbox--solid m-checkbox--brand boday_check_box">
                                                    <input type="checkbox" value="1">
                                                    <span></span>
                                                </label>
                                            </span>
                                    </td>
                                    <td class="title tablesaw-cell-persist"><span>53150-422</span>
                                    </td>
                                    <td><span>Qaram Qōl</span>
                                    </td>
                                    <td><span>dropbox.com</span>
                                    </td>
                                    <td><span>Baby</span></td>
                                    <td><span>5/20/2017</span>
                                    </td>
                                    <td>
                                        <span>
                                            <div class="dropdown ">
                                                <a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown">
                                                    <i class="la la-ellipsis-h"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item" href="#">
                                                        <i class="la la-edit"></i> Edit Details
                                                    </a>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="la la-leaf"></i> Update Status
                                                    </a>
                                                    <a class="dropdown-item" href="#">
                                                        <i class="la la-print"></i> Generate Report
                                                    </a>
                                                </div>
                                            </div>
                                            <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">
                                                <i class="la la-edit"></i>
                                            </a>
                                            <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">
                                                <i class="la la-trash"></i>
                                            </a>
                                        </span>
                                    </td>
                                </tr>
                                <tr data-row="3" class="m-datatable__row" style="height: 55px;">
                                    <td data-field="RecordID" class="title tablesaw-cell-persist">
                                        <span>
                                            <label class="m-checkbox m-checkbox--single m-checkbox--all m-checkbox--solid m-checkbox--brand boday_check_box">
                                                <input type="checkbox" value="2">
                                                <span></span>
                                            </label>
                                        </span>
                                    </td>
                                    <td data-field="OrderID" class="title tablesaw-cell-persist">
                                        <span>49999-763</span>
                                    </td>
                                    <td data-field="ShipCity" class="">
                                        <span>Mogok</span>
                                    </td>
                                    <td data-field="Website" class="">
                                        <span>cafepress.com</span>
                                    </td>
                                    <td data-field="Department" class="">
                                        <span>Outdoors</span></td>
                                    <td data-field="ShipDate" class="">
                                        <span>11/28/2016</span>
                                    </td>
                                    <td data-field="Actions" class="">
                                            <span>
                                                <div class="dropdown ">
                                                    <a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                                                       data-toggle="dropdown">
                                                        <i class="la la-ellipsis-h"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#">
                                                            <i class="la la-edit"></i> Edit Details
                                                        </a>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="la la-leaf"></i> Update Status
                                                        </a>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="la la-print"></i> Generate Report
                                                        </a>
                                                    </div>
                                                </div>
                                                <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                                                   title="Edit details">
                                                    <i class="la la-edit"></i>
                                                </a>
                                                <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill"
                                                   title="Delete">
                                                    <i class="la la-trash"></i>
                                                </a>
                                            </span>
                                    </td>
                                </tr>
                                <tr data-row="4" class="m-datatable__row m-datatable__row--even"
                                    style="height: 55px;">
                                    <td class="title tablesaw-cell-persist">
                                            <span>
                                                <label class="m-checkbox m-checkbox--single m-checkbox--all m-checkbox--solid m-checkbox--brand boday_check_box">
                                                    <input type="checkbox" value="1">
                                                    <span></span>
                                                </label>
                                            </span>
                                    </td>
                                    <td class="title tablesaw-cell-persist"><span>53150-422</span>
                                    </td>
                                    <td><span>Qaram Qōl</span>
                                    </td>
                                    <td><span>dropbox.com</span>
                                    </td>
                                    <td><span>Baby</span></td>
                                    <td><span>5/20/2017</span>
                                    </td>
                                    <td>
                                            <span>
                                                <div class="dropdown ">
                                                    <a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown">
                                                        <i class="la la-ellipsis-h"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#">
                                                            <i class="la la-edit"></i> Edit Details
                                                        </a>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="la la-leaf"></i> Update Status
                                                        </a>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="la la-print"></i> Generate Report
                                                        </a>
                                                    </div>
                                                </div>
                                                <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">
                                                    <i class="la la-edit"></i>
                                                </a>
                                                <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">
                                                    <i class="la la-trash"></i>
                                                </a>
                                            </span>
                                    </td>
                                </tr>
                                <tr data-row="5" class="m-datatable__row" style="height: 55px;">
                                    <td data-field="RecordID" class="title tablesaw-cell-persist">
                                            <span>
                                                <label class="m-checkbox m-checkbox--single m-checkbox--all m-checkbox--solid m-checkbox--brand boday_check_box">
                                                    <input type="checkbox" value="2">
                                                    <span></span>
                                                </label>
                                            </span>
                                    </td>
                                    <td data-field="OrderID" class="title tablesaw-cell-persist">
                                        <span>49999-763</span>
                                    </td>
                                    <td data-field="ShipCity" class="">
                                        <span>Mogok</span>
                                    </td>
                                    <td data-field="Website" class="">
                                        <span>cafepress.com</span>
                                    </td>
                                    <td data-field="Department" class="">
                                        <span>Outdoors</span></td>
                                    <td data-field="ShipDate" class="">
                                        <span>11/28/2016</span>
                                    </td>
                                    <td data-field="Actions" class="">
                                            <span>
                                                <div class="dropdown ">
                                                    <a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                                                       data-toggle="dropdown">
                                                        <i class="la la-ellipsis-h"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#">
                                                            <i class="la la-edit"></i> Edit Details
                                                        </a>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="la la-leaf"></i> Update Status
                                                        </a>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="la la-print"></i> Generate Report
                                                        </a>
                                                    </div>
                                                </div>
                                                <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                                                   title="Edit details">
                                                    <i class="la la-edit"></i>
                                                </a>
                                                <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill"
                                                   title="Delete">
                                                    <i class="la la-trash"></i>
                                                </a>
                                            </span>
                                    </td>
                                </tr>
                                <tr data-row="6" class="m-datatable__row m-datatable__row--even"
                                    style="height: 55px;">
                                    <td class="title tablesaw-cell-persist">
                                            <span>
                                                <label class="m-checkbox m-checkbox--single m-checkbox--all m-checkbox--solid m-checkbox--brand boday_check_box">
                                                    <input type="checkbox" value="1">
                                                    <span></span>
                                                </label>
                                            </span>
                                    </td>
                                    <td class="title tablesaw-cell-persist"><span>53150-422</span>
                                    </td>
                                    <td><span>Qaram Qōl</span>
                                    </td>
                                    <td><span>dropbox.com</span>
                                    </td>
                                    <td><span>Baby</span></td>
                                    <td><span>5/20/2017</span>
                                    </td>
                                    <td>
                                            <span>
                                                <div class="dropdown ">
                                                    <a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown">
                                                        <i class="la la-ellipsis-h"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#">
                                                            <i class="la la-edit"></i> Edit Details
                                                        </a>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="la la-leaf"></i> Update Status
                                                        </a>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="la la-print"></i> Generate Report
                                                        </a>
                                                    </div>
                                                </div>
                                                <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">
                                                    <i class="la la-edit"></i>
                                                </a>
                                                <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">
                                                    <i class="la la-trash"></i>
                                                </a>
                                            </span>
                                    </td>
                                </tr>
                                <tr data-row="7" class="m-datatable__row" style="height: 55px;">
                                    <td data-field="RecordID" class="title tablesaw-cell-persist">
                                            <span>
                                                <label class="m-checkbox m-checkbox--single m-checkbox--all m-checkbox--solid m-checkbox--brand boday_check_box">
                                                    <input type="checkbox" value="2">
                                                    <span></span>
                                                </label>
                                            </span>
                                    </td>
                                    <td data-field="OrderID" class="title tablesaw-cell-persist">
                                        <span>49999-763</span>
                                    </td>
                                    <td data-field="ShipCity" class="">
                                        <span>Mogok</span>
                                    </td>
                                    <td data-field="Website" class="">
                                        <span>cafepress.com</span>
                                    </td>
                                    <td data-field="Department" class="">
                                        <span>Outdoors</span></td>
                                    <td data-field="ShipDate" class="">
                                        <span>11/28/2016</span>
                                    </td>
                                    <td data-field="Actions" class="">
                                            <span>
                                                <div class="dropdown ">
                                                    <a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                                                       data-toggle="dropdown">
                                                        <i class="la la-ellipsis-h"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#">
                                                            <i class="la la-edit"></i> Edit Details
                                                        </a>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="la la-leaf"></i> Update Status
                                                        </a>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="la la-print"></i> Generate Report
                                                        </a>
                                                    </div>
                                                </div>
                                                <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                                                   title="Edit details">
                                                    <i class="la la-edit"></i>
                                                </a>
                                                <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill"
                                                   title="Delete">
                                                    <i class="la la-trash"></i>
                                                </a>
                                            </span>
                                    </td>
                                </tr>
                                <tr data-row="8" class="m-datatable__row m-datatable__row--even"
                                    style="height: 55px;">
                                    <td class="title tablesaw-cell-persist">
                                            <span>
                                                <label class="m-checkbox m-checkbox--single m-checkbox--all m-checkbox--solid m-checkbox--brand boday_check_box">
                                                    <input type="checkbox" value="1">
                                                    <span></span>
                                                </label>
                                            </span>
                                    </td>
                                    <td class="title tablesaw-cell-persist"><span>53150-422</span>
                                    </td>
                                    <td><span>Qaram Qōl</span>
                                    </td>
                                    <td><span>dropbox.com</span>
                                    </td>
                                    <td><span>Baby</span></td>
                                    <td><span>5/20/2017</span>
                                    </td>
                                    <td>
                                            <span>
                                                <div class="dropdown ">
                                                    <a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown">
                                                        <i class="la la-ellipsis-h"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#">
                                                            <i class="la la-edit"></i> Edit Details
                                                        </a>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="la la-leaf"></i> Update Status
                                                        </a>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="la la-print"></i> Generate Report
                                                        </a>
                                                    </div>
                                                </div>
                                                <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">
                                                    <i class="la la-edit"></i>
                                                </a>
                                                <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">
                                                    <i class="la la-trash"></i>
                                                </a>
                                            </span>
                                    </td>
                                </tr>
                                <tr data-row="9" class="m-datatable__row" style="height: 55px;">
                                    <td data-field="RecordID" class="title tablesaw-cell-persist">
                                            <span>
                                                <label class="m-checkbox m-checkbox--single m-checkbox--all m-checkbox--solid m-checkbox--brand boday_check_box">
                                                    <input type="checkbox" value="2">
                                                    <span></span>
                                                </label>
                                            </span>
                                    </td>
                                    <td data-field="OrderID" class="title tablesaw-cell-persist">
                                        <span>49999-763</span>
                                    </td>
                                    <td data-field="ShipCity" class="">
                                        <span>Mogok</span>
                                    </td>
                                    <td data-field="Website" class="">
                                        <span>cafepress.com</span>
                                    </td>
                                    <td data-field="Department" class="">
                                        <span>Outdoors</span></td>
                                    <td data-field="ShipDate" class="">
                                        <span>11/28/2016</span>
                                    </td>
                                    <td data-field="Actions" class="">
                                            <span>
                                                <div class="dropdown ">
                                                    <a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                                                       data-toggle="dropdown">
                                                        <i class="la la-ellipsis-h"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#">
                                                            <i class="la la-edit"></i> Edit Details
                                                        </a>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="la la-leaf"></i> Update Status
                                                        </a>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="la la-print"></i> Generate Report
                                                        </a>
                                                    </div>
                                                </div>
                                                <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill"
                                                   title="Edit details">
                                                    <i class="la la-edit"></i>
                                                </a>
                                                <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill"
                                                   title="Delete">
                                                    <i class="la la-trash"></i>
                                                </a>
                                            </span>
                                    </td>
                                </tr>
                                <tr data-row="10" class="m-datatable__row m-datatable__row--even"
                                    style="height: 55px;">
                                    <td class="title tablesaw-cell-persist">
                                            <span>
                                                <label class="m-checkbox m-checkbox--single m-checkbox--all m-checkbox--solid m-checkbox--brand boday_check_box">
                                                    <input type="checkbox" value="1">
                                                    <span></span>
                                                </label>
                                            </span>
                                    </td>
                                    <td class="title tablesaw-cell-persist"><span>53150-422</span>
                                    </td>
                                    <td><span>Qaram Qōl</span>
                                    </td>
                                    <td><span>dropbox.com</span>
                                    </td>
                                    <td><span>Baby</span></td>
                                    <td><span>5/20/2017</span>
                                    </td>
                                    <td>
                                            <span>
                                                <div class="dropdown ">
                                                    <a href="#" class="btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown">
                                                        <i class="la la-ellipsis-h"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#">
                                                            <i class="la la-edit"></i> Edit Details
                                                        </a>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="la la-leaf"></i> Update Status
                                                        </a>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="la la-print"></i> Generate Report
                                                        </a>
                                                    </div>
                                                </div>
                                                <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details">
                                                    <i class="la la-edit"></i>
                                                </a>
                                                <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">
                                                    <i class="la la-trash"></i>
                                                </a>
                                            </span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="m-datatable__pager m-datatable--paging-loaded clearfix">
                                <ul class="m-datatable__pager-nav">
                                    <li><a title="First"
                                           class="m-datatable__pager-link m-datatable__pager-link--first m-datatable__pager-link--disabled"
                                           data-page="1" disabled="disabled"><i class="la la-angle-double-left"></i></a>
                                    </li>
                                    <li><a title="Previous"
                                           class="m-datatable__pager-link m-datatable__pager-link--prev m-datatable__pager-link--disabled"
                                           data-page="1" disabled="disabled"><i class="la la-angle-left"></i></a>
                                    </li>
                                    <li style="display: none;"><a title="More pages"
                                                                  class="m-datatable__pager-link m-datatable__pager-link--more-prev"
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
                                <!--<div class="m-datatable__pager-info">-->
                                <!--<div class="btn-group bootstrap-select m-datatable__pager-size"-->
                                <!--style="width: 70px;">-->
                                <!--<button type="button" class="btn dropdown-toggle bs-placeholder btn-default"-->
                                <!--data-toggle="dropdown"-->
                                <!--role="button" title="Select page size"><span-->
                                <!--class="filter-option pull-left">Select page size</span>&nbsp;<span-->
                                <!--class="bs-caret"><span-->
                                <!--class="caret"></span></span></button>-->
                                <!--<div class="dropdown-menu open" role="combobox">-->
                                <!--<ul class="dropdown-menu inner" role="listbox" aria-expanded="false">-->
                                <!--<li data-original-index="1"><a tabindex="0" class=""-->
                                <!--data-tokens="null" role="option"-->
                                <!--aria-disabled="false"-->
                                <!--aria-selected="false"><span-->
                                <!--class="text">10</span><span-->
                                <!--class="glyphicon glyphicon-ok check-mark"></span></a></li>-->
                                <!--<li data-original-index="2"><a tabindex="0" class=""-->
                                <!--data-tokens="null" role="option"-->
                                <!--aria-disabled="false"-->
                                <!--aria-selected="false"><span-->
                                <!--class="text">20</span><span-->
                                <!--class="glyphicon glyphicon-ok check-mark"></span></a></li>-->
                                <!--<li data-original-index="3"><a tabindex="0" class=""-->
                                <!--data-tokens="null" role="option"-->
                                <!--aria-disabled="false"-->
                                <!--aria-selected="false"><span-->
                                <!--class="text">30</span><span-->
                                <!--class="glyphicon glyphicon-ok check-mark"></span></a></li>-->
                                <!--<li data-original-index="4"><a tabindex="0" class=""-->
                                <!--data-tokens="null" role="option"-->
                                <!--aria-disabled="false"-->
                                <!--aria-selected="false"><span-->
                                <!--class="text">50</span><span-->
                                <!--class="glyphicon glyphicon-ok check-mark"></span></a></li>-->
                                <!--<li data-original-index="5"><a tabindex="0" class=""-->
                                <!--data-tokens="null" role="option"-->
                                <!--aria-disabled="false"-->
                                <!--aria-selected="false"><span-->
                                <!--class="text">100</span><span-->
                                <!--class="glyphicon glyphicon-ok check-mark"></span></a></li>-->
                                <!--</ul>-->
                                <!--</div>-->
                                <!--<select class="selectpicker m-datatable__pager-size"-->
                                <!--title="Select page size" data-width="70px"-->
                                <!--data-selected="-1" tabindex="-98">-->
                                <!--<option class="bs-title-option" value="">Select page size</option>-->
                                <!--<option value="10">10</option>-->
                                <!--<option value="20">20</option>-->
                                <!--<option value="30">30</option>-->
                                <!--<option value="50">50</option>-->
                                <!--<option value="100">100</option>-->
                                <!--</select></div>-->
                                <!--<span class="m-datatable__pager-detail">Displaying 1 - 14 records</span></div>-->
                            </div>
                        </div>
                        <!--end: Datatable -->
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('footer_space')
    <script src="{{ asset('assets/datatable/datatable_responsive.js') }}"></script>

    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

@stop