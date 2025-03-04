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
            <!--begin::Portlet-->
            <div class="m-portlet">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Inputs Highlighted Validation State
                            </h3>
                        </div>
                    </div>
                </div>
                <!--begin::Form-->
                <form action="{{url('/')}}" class="m-form m-form--state m-form--fit m-form--label-align-right" id="m_form_2">
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
                            <label class="col-form-label col-lg-3 col-sm-12">
                                Email *
                            </label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <input type="text" class="form-control m-input" name="email" placeholder="Enter your email">
                                <span class="m-form__help">
                                    {{--We'll never share your email with anyone else.--}}
                                </span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">
                                URL *
                            </label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <div class="input-group">
                                    <input type="text" class="form-control m-input" name="url" placeholder="Enter your url">
                                    <span class="input-group-addon">
                                        .via.com
                                    </span>
                                </div>
                                <span class="m-form__help">
                                    {{--Please enter your website URL.--}}
                                </span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">
                                Digits
                            </label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <div class="m-input-icon m-input-icon--left">
                                    <input type="text" class="form-control m-input" name="digits" placeholder="Enter digits">
                                    <span class="m-input-icon__icon m-input-icon__icon--left">
                                        <span>
                                            <i class="la la-calculator"></i></span>
                                    </span>
                                </div>
                                <span class="m-form__help">
                                    {{--Please enter only digits--}}
                                </span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">
                                Credit Card
                            </label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <div class="input-group">
                                    <input type="text" class="form-control m-input" name="creditcard" placeholder="Enter card number">
                                    <span class="input-group-addon">
                                        <i class="la la-credit-card"></i>
                                    </span>
                                </div>
                                <span class="m-form__help">
                                    {{--Please enter your credit card number--}}
                                </span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">
                                US Phone
                            </label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <div class="input-group">
                                    <input type="text" class="form-control m-input" name="phone" placeholder="Enter phone">
                                    <span class="input-group-btn">
                                        <a href="#" class="btn btn-brand">
                                            <i class="la la-phone"></i>
                                        </a>
                                    </span>
                                </div>
                                <span class="m-form__help">
                                    {{--Please enter your US phone number--}}
                                </span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">
                                Option *
                            </label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <select class="form-control m-input" name="option">
                                    <option value="">Select</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                                <span class="m-form__help">
                                    {{--Please select an option.--}}
                                </span>
                            </div>
                        </div>
                        {{--<div class="form-group m-form__group row">--}}
                            {{--<label class="col-form-label col-lg-3 col-sm-12">--}}
                                {{--Options *--}}
                            {{--</label>--}}
                            {{--<div class="col-lg-4 col-md-9 col-sm-12">--}}
                                {{--<select class="form-control m-input" name="options" multiple size="5">--}}
                                    {{--<option>--}}
                                        {{--1--}}
                                    {{--</option>--}}
                                    {{--<option>--}}
                                        {{--2--}}
                                    {{--</option>--}}
                                    {{--<option>--}}
                                        {{--3--}}
                                    {{--</option>--}}
                                    {{--<option>--}}
                                        {{--4--}}
                                    {{--</option>--}}
                                    {{--<option>--}}
                                        {{--5--}}
                                    {{--</option>--}}
                                {{--</select>--}}
                                {{--<span class="m-form__help">--}}
												{{--Please select at least one or maximum 4 options--}}
											{{--</span>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">
                                Memo *
                            </label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <textarea class="form-control m-input" name="memo" placeholder="Enter a menu"></textarea>
                                <span class="m-form__help">
                                    {{--Please enter a menu within text length range 10 and 100.--}}
                                </span>
                            </div>
                        </div>
                        <div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space"></div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">
                                Checkbox *
                            </label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <div class="m-checkbox-inline">
                                    <label class="m-checkbox">
                                        <input type="checkbox" name="checkbox">
                                        Tick me
                                        <span></span>
                                    </label>
                                </div>
                                <span class="m-form__help">
                                    {{--Please tick the checkbox--}}
                                </span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">
                                Checkboxes *
                            </label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <div class="m-checkbox-list">
                                    <label class="m-checkbox">
                                        <input type="checkbox" name="checkboxes">
                                        Option 1
                                        <span></span>
                                    </label>
                                    <label class="m-checkbox">
                                        <input type="checkbox" name="checkboxes">
                                        Option 2
                                        <span></span>
                                    </label>
                                    <label class="m-checkbox">
                                        <input type="checkbox" name="checkboxes">
                                        Option 3
                                        <span></span>
                                    </label>
                                </div>
                                <span class="m-form__help">
                                    Please select at lease 1 and maximum 2 options
                                </span>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-lg-3 col-sm-12">
                                Radios *
                            </label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <div class="m-radio-inline">
                                    <label class="m-radio">
                                        <input type="checkbox" name="radio" checked value="1">
                                        Option 1
                                        <span></span>
                                    </label>
                                    <label class="m-radio">
                                        <input type="checkbox" name="radio" value="1">
                                        Option 2
                                        <span></span>
                                    </label>
                                    <label class="m-radio">
                                        <input type="radio" name="radio" value="1">
                                        Option 3
                                        <span></span>
                                    </label>
                                </div>
                                <span class="m-form__help">
                                    {{--Please select an option--}}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__foot m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions">
                            <div class="row">
                                <div class="col-lg-9 ml-lg-auto">
                                    <button type="submit" class="btn btn-accent">
                                        Validate
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

@stop

@section('footer_space')
    <script src="{{ asset('assets/demo/default/custom/components/forms/validation/form-controls.js') }}"></script>

@stop