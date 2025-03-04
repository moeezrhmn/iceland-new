@extends('layouts.master')
@section('title', $isNew ? 'Create Keyword' : 'Edit Keyword')
@section('header_space')
<style type="text/css">
    #keyword-form{
        width: 50%;
        margin: 0 auto;
    }
    .m-form .m-form__group {
        padding-top: 0px !important;
padding-bottom: 0px !important;
    }
</style>
@endsection
@section('title_right_section')
    <a href="{{ 'admin::permission.create'}}"
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
                            <a href="{{route('keywords.index')}}" class="m-nav__link">
                                <span class="m-nav__link-text">
                                    All Keywords
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
                    <form action="{{ route('keywords.update', $item->id) }}" method="POST" class="m-form m-form--state m-form--fit m-form--label-align-right" id="keyword-form">
                    @method('PUT')
                @else
                    <form action="{{ route('keywords.store') }}" method="POST" class="m-form m-form--state m-form--fit m-form--label-align-right" id="keyword-form">
                @endif
                    @csrf
                    <input type="hidden" name="id" value="{{ old('id', $item->id ?? '') }}">


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
                      {{--status dropdown--}}
                    <div class="form-group m-form__group row">
                        
                        <div class="col-sm-12">
                            <label class="">
                           Category Type <span style="color: red"> *</span>
                        </label>
                            <select class="form-control required "  name="category_id">
                                <option value="">Select Category</option>
                                @foreach($categories as $row)
                                    <option @if(isset($item->category_id) && $item->category_id==$row->id) selected @endif value="{{$row->id}}">{{$row->cat_name}}</option>
                                @endforeach
                            </select>
                            <span class="m-form__help">
                                </span>
                        </div>
                    </div>
                    {{--user name--}}
                    <div class="form-group m-form__group row">
                        
                        <div class="col-sm-12">
                            <label class="">
                            Keyword Name<span style="color: red"> *</span>
                        </label>
                            <div class="input-group m-input-group m-input-group--square">
                            <input type="text" name="keyword_name" class="form-control m-input" placeholder="Keyword Name" value="{{ old('keyword_name', $item->keyword_name ?? '') }}">

                            </div>
                            <span class="m-form__help">
                                    {{--We'll never share your email with anyone else.--}}
                                </span>
                        </div>
                    </div>

                  
                  

                </div>

                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions">
                        <div class="row">
                            <div class="col-lg-9 ">
                               

   @if(isset($item->id) && !empty($item->id))
                                <button type="submit" class="btn btn-accent">
                                    Update
                                </button>
                                @else
 <button type="submit" class="btn btn-accent">
                                    Create
                                </button>
                                @endif

                                <a href="{{route('keywords.index')}}" class="btn btn-secondary">
                                    Cancel
                                </a>
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

    <script src="{{ asset('assets/pages/keywords/create.js') }}"></script>

@stop