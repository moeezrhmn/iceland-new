@extends('layouts.master')
@section('title', $isNew ? 'Create User' : 'Edit User')
@section('header_space')

@endsection
@section('title_right_section')
    <a href="{{ 'admin::users.create'}}"
       class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill btn btn-success pull-right">asdfsadf</a>
@endsection
@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title m-subheader__title--separator">
                        @yield('title')
                    </h3>
                    <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                        <li class="m-nav__item m-nav__item--home">
                            <a href="{{URL::previous()}}" class="m-nav__link m-nav__link--icon">
                                <i class="m-nav__link-icon la la-users"></i>
                            </a>
                        </li>
                        <li class="m-nav__separator">
                            -
                        </li>
                        <li class="m-nav__item">
                            <a href="{{route('users.index')}}" class="m-nav__link">
                                <span class="m-nav__link-text">
                                    All Users
                                </span>
                            </a>
                        </li>
                        <li class="m-nav__separator">
                            -
                        </li>
                        <li class="m-nav__item">
                            <a href="{{URL::current()}}" class="m-nav__link">
                                <span class="m-nav__link-text">
                                    @yield('title')
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- END: Subheader -->
        <div class="m-content">
            <!--begin::Portlet-->
            <div class="m-portlet">
                <!--begin::Form-->
                @if(isset($item->id) && !empty($item->id))
                    {!! Form::model($item, ['url'=> ['users',$item->id],'method'=>'PUT','class' => 'm-form m-form--state m-form--fit m-form--label-align-right','id'=>'user-form']) !!}
                @else
                    {!! Form::model($item, ['action' => 'Admin\UserController@store','class' => 'm-form m-form--state m-form--fit m-form--label-align-right','id'=>'user-form']) !!}
                @endif
                {!! Form::hidden('id') !!}

                <div class="m-portlet__body">
                    {{--error alert bar--}}
                    <div class="m-form__content">
                        @include('errors.flash')
                        <div class="m-alert m-alert--icon alert alert-danger m--hide" role="alert"
                             id="m_form_msg">
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
                    {{--user name--}}
                    <div class="form-group m-form__group row">
                        <label class="col-form-label col-lg-3 col-sm-12">
                            Username<span style="color: red"> *</span>
                        </label>
                        <div class="col-lg-4 col-md-9 col-sm-12">
                            <div class="input-group m-input-group m-input-group--square">
                                <span class="input-group-addon">
                                    <i class="la la-user"></i>
                                </span>
                                {{ Form::text('name', NULL, array('class' => 'form-control m-input','placeholder' => 'Enter Your Name')) }}

                            </div>
                            <span class="m-form__help">
                                    {{--We'll never share your email with anyone else.--}}
                                </span>
                        </div>
                    </div>
                    {{--email--}}
                    <div class="form-group m-form__group row">
                        <label class="col-form-label col-lg-3 col-sm-12">
                            Email <span style="color: red"> *</span>
                        </label>
                        <div class="col-lg-4 col-md-9 col-sm-12">
                            <div class="input-group m-input-group m-input-group--square">
                                <span class="input-group-addon">
                                    <i class="la la-envelope"></i>
                                </span>
                                {{ Form::text('email', NULL, array('class' => 'form-control m-input','placeholder' => 'Enter Your Email')) }}

                            </div>
                            {{--{{ Form::text('email', NULL, array('class' => 'form-control m-input','placeholder' => 'Enter Your Email')) }}--}}
                            <span class="m-form__help">
                                    {{--We'll never share your email with anyone else.--}}
                                </span>
                        </div>
                    </div>
                    {{--password field--}}
                    <div class="form-group m-form__group row">
                        <label class="col-form-label col-lg-3 col-sm-12">
                            Password @if(!isset($item->id))<span style="color: red"> *</span>@endif
                        </label>
                        <div class="col-lg-4 col-md-9 col-sm-12">
                            <input name="password" id="password" type="password" class="form-control m-input">
                            <span class="m-form__help">
                                    {{--We'll never share your email with anyone else.--}}
                                </span>
                        </div>
                    </div>
                    {{--confirm password field--}}
                    <div class="form-group m-form__group row">
                        <label class="col-form-label col-lg-3 col-sm-12">
                            Confirm Password @if(!isset($item->id))<span style="color: red"> *</span>@endif
                        </label>
                        <div class="col-lg-4 col-md-9 col-sm-12">
                            <input name="password_confirmation" id="password_confirmation" type="password" class="form-control m-input">
                            <span class="m-form__help">
                                    {{--We'll never share your email with anyone else.--}}
                                </span>
                        </div>
                    </div>
                    {{--status dropdown--}}
                    <div class="form-group m-form__group row">
                        <label class="col-form-label col-lg-3 col-sm-12">
                            Status <span style="color: red"> *</span>
                        </label>
                        <div class="col-lg-4 col-md-9 col-sm-12">
                            {{ Form::select('status', getdropdownKeyValueSame(\App\User::$status),null, ['class' => 'form-control m-input']) }}
                            <span class="m-form__help">

                                </span>
                        </div>
                    </div>

                </div>

                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions">
                        <div class="row">
                            <div class="col-lg-9 ml-lg-auto">
                                <button type="submit" class="btn btn-accent">
                                    Create
                                </button>
                                <a href="{{route('users.index')}}" class="btn btn-secondary">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
            <!--end::Form-->
            </div>
            <!--end::Portlet-->
        </div>
    </div>

@stop

@section('footer_space')
    @if(isset($item->id) && !empty($item->id))
        <script src="{{ asset('assets/pages/users/edit.js') }}"></script>
    @else
        <script src="{{ asset('assets/pages/users/create.js') }}"></script>
    @endif
@stop