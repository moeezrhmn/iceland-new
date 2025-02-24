@extends('layouts.master')
@section('title', trans('general.heading.users'))
@section('header_space')
    <link href="{{ asset('assets/datatable/datatable.css') }}" rel="stylesheet" type="text/css"/>
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
                        Form Controls
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
												Forms
											</span>
                            </a>
                        </li>
                        <li class="m-nav__separator">
                            -
                        </li>
                        <li class="m-nav__item">
                            <a href="" class="m-nav__link">
											<span class="m-nav__link-text">
												Form Validation
											</span>
                            </a>
                        </li>
                        <li class="m-nav__separator">
                            -
                        </li>
                        <li class="m-nav__item">
                            <a href="" class="m-nav__link">
											<span class="m-nav__link-text">
												Form Controls
											</span>
                            </a>
                        </li>
                    </ul>
                </div>
                {{--<div>--}}
                {{--<div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" data-dropdown-toggle="hover" aria-expanded="true">--}}
                {{--<a href="#" class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--outline-2x m-btn--air m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">--}}
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
                {{--<a href="#" class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">--}}
                {{--Submit--}}
                {{--</a>--}}
                {{--</li>--}}
                {{--</ul>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content">
            <div class="row">
                <div class="col-lg-12">
                    <!--begin::Portlet-->
                    <div class="m-portlet">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon m--hide">
													<i class="la la-gear"></i>
												</span>
                                    <h3 class="m-portlet__head-text">
                                        3 Columns Form Layout
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <!--begin::Form-->
                        <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed" id="m_form_2">
                            <div class="m-portlet__body">
                                <div class="m-form__content">
                                    <div class="m-alert m-alert--icon alert alert-danger m--hide" role="alert" id="m_form_2_msg">
                                        <div class="m-alert__icon">
                                            <i class="la la-warning"></i>
                                        </div>
                                        <div class="m-alert__text">
                                            Oh snap! Change a few things up and try submitting again.
                                        </div>
                                        <div class="m-alert__close">
                                            <button type="button" class="close" data-close="alert" aria-label="Close"></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-4">
                                        <label>
                                            Full Name:
                                        </label>
                                        <input type="text" name="full" class="form-control m-input" placeholder="Enter full name">
                                        <span class="m-form__help">
                                            {{--Please enter your full name--}}
                                        </span>
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="">
                                            Email:
                                        </label>
                                        <div class="input-group m-input-group m-input-group--square">
                                            <span class="input-group-addon">
                                                <i class="la la-envelope"></i>
                                            </span>
                                            <input type="email" name="email" class="form-control m-input" placeholder="Enter email">
                                        </div>
                                        <span class="m-form__help">
                                            {{--Please enter your email--}}
                                        </span>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>
                                            Username:
                                        </label>
                                        <div class="input-group m-input-group m-input-group--square">
                                            <span class="input-group-addon">
                                                <i class="la la-user"></i>
                                            </span>
                                            <input type="text" class="form-control m-input" placeholder="Enter User Name">
                                        </div>
                                        <span class="m-form__help">
                                            {{--Please enter your username--}}
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-4">
                                        <label class="">
                                            Contact:
                                        </label>
                                        <div class="m-input-icon m-input-icon--right">
                                            <input type="text" name="phone" class="form-control m-input" placeholder="Enter contact number">
                                            <span class="m-input-icon__icon m-input-icon__icon--right">
                                                <span>
                                                    <i class="la la-mobile-phone"></i>
                                                </span>
                                            </span>
                                        </div>
                                        <span class="m-form__help">
                                            {{--Please enter your contact--}}
                                        </span>
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="">
                                            Fax:
                                        </label>
                                        <div class="m-input-icon m-input-icon--right">
                                            <input type="text" class="form-control m-input" placeholder="Fax number">
                                            <span class="m-input-icon__icon m-input-icon__icon--right">
                                                <span>
                                                    <i class="la la-info-circle"></i>
                                                </span>
                                            </span>
                                        </div>
                                        <span class="m-form__help">
                                            {{--Please enter fax--}}
                                        </span>
                                    </div>
                                    <div class="col-lg-4">
                                        <label>
                                            Address:
                                        </label>
                                        <div class="m-input-icon m-input-icon--right">
                                            <input type="text" class="form-control m-input" placeholder="Enter your address">
                                            <span class="m-input-icon__icon m-input-icon__icon--right">
                                                <span>
                                                    <i class="la la-map-marker"></i>
                                                </span>
                                            </span>
                                        </div>
                                        <span class="m-form__help">
                                            {{--Please enter your address--}}
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-lg-4">
                                        <label class="">
                                            Postcode:
                                        </label>
                                        <div class="m-input-icon m-input-icon--right">
                                            <input type="text" class="form-control m-input" placeholder="Enter your postcode">
                                            <span class="m-input-icon__icon m-input-icon__icon--right">
                                                <span>
                                                    <i class="la la-bookmark-o"></i>
                                                </span>
                                            </span>
                                        </div>
                                        <span class="m-form__help">
                                            {{--Please enter your postcode--}}
                                        </span>
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="">
                                            User Group:
                                        </label>
                                        <div class="m-radio-inline">
                                            <label class="m-radio m-radio--solid">
                                                <input type="radio" name="example_2" checked value="2">
                                                Sales Person
                                                <span></span>
                                            </label>
                                            <label class="m-radio m-radio--solid">
                                                <input type="radio" name="example_2" value="2">
                                                Customer
                                                <span></span>
                                            </label>
                                        </div>
                                        <span class="m-form__help">
                                            {{--Please select user group--}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                                <div class="m-form__actions m-form__actions--solid">
                                    <div class="row">
                                        <div class="col-lg-4"></div>
                                        <div class="col-lg-8">
                                            <button type="submit" class="btn btn-primary">
                                                Submit
                                            </button>
                                            <button type="reset" class="btn btn-secondary">
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Portlet-->
                </div>
            </div>
        </div>
    </div>

@stop

@section('footer_space')
    <script src="{{ asset('assets/demo/default/custom/components/forms/validation/form-controls.js') }}"></script>

@stop