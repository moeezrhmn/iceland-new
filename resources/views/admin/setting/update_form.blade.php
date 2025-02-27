@extends('layouts.master')
@section('title', 'Setting')
@section('header_space')
    <link href="{{ asset('admin_outer/css/select2.css') }}" rel="stylesheet" type="text/css" />
<style type="text/css">
    .form-group.m-form__group.row{
        padding-bottom: 10px;
    }
</style>
@endsection
@section('title_right_section')
    <a href="{{ 'admin::places.create'}}"
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
                            <a href="{{route('setting.index')}}" class="m-nav__link">
                                <span class="m-nav__link-text">
                                    All Setting
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
               <form method="post" class="m-form m-form--state m-form--fit m-form--label-align-right" enctype="multipart/form-data" action="{{ url('admin/update_setting') }}" id="setting_form_sample_3"
              class="m-form m-form--state m-form--fit m-form--label-align-right ">
              <div class="m-portlet__body">
            {{--{{ method_field('POST')}}--}}
            {{ csrf_field() }}
          
             
            <div class="form-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button>
                        <span> You have <?php echo count($errors->all()) ?> errors. Please check below.</span>
                    </div>
                @endif
                
                
                </div>

               
                <div class="row">
                    <!--/span-->
                    <div class="col-md-4">
                        <div class="form-group m-form__group row">
                            <label class="control-label">Support Email <span class="error_label">*</span></label>
                            <input value="@if(!empty($setting->support_email)) {{$setting->support_email}} @endif"  name="support_email" type="text" id="mask_ssn" placeholder="Support Email" class="form-control">
                            <p class="text-danger">{{$errors->first('support_email')}}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group m-form__group row">
                            <label class="control-label">Sale Email <span class="error_label">*</span></label>
                            <input value="@if(!empty($setting->sale_email)) {{$setting->sale_email}} @endif" name="sale_email" type="email" placeholder="sale_email" class="form-control required">
                            <p class="text-danger">{{$errors->first('sale_email')}}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group m-form__group row">
                            <label class="control-label">Contact No <span class="error_label">*</span></label>
                            <input value="@if(!empty($setting->contact_no)) {{$setting->contact_no}} @endif" name="contact_no" type="text" placeholder="Contact No" class="form-control ">
                            <p class="text-danger">{{$errors->first('contact_no')}}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group m-form__group row">
                            <label class="control-label">Address <span class="error_label">*</span></label>
                            <input value="@if(!empty($setting->address)) {{$setting->address}} @endif" name="address" type="text" placeholder="Address" class="form-control">
                           {{-- <p class="text-danger">{{$errors->first('address')}}</p>--}}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group m-form__group row">
                            <label class="control-label">City <span class="error_label">*</span></label>
                            <input value="@if(!empty($setting->city)) {{$setting->city}} @endif" name="city" type="text" placeholder="City" id="city"
                                   class="form-control">
                        </div>
                    </div>
                      <div class="col-md-4">
                        <div class="form-group m-form__group row">
                            <label class="control-label">State <span class="error_label">*</span></label>
                            <input value="@if(!empty($setting->state)) {{$setting->state}} @endif" name="state" type="text" placeholder="State" id="city"
                                   class="form-control">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group m-form__group row">
                            <label class="control-label">Country <span class="error_label">*</span></label>
                            <input value="@if(!empty($setting->country_code)) {{$setting->country_code}} @endif"  name="country_code" type="text" id="mask_ssn" placeholder="Country Code" class="form-control">
                            <p class="text-danger">{{$errors->first('country_code')}}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group m-form__group row">
                            <label class="control-label">Zipcode</label>
                            <input value="@if(!empty($setting->zipcode)) {{$setting->zipcode}} @endif" name="zipcode" type="text" placeholder="Zipcode" class="form-control required">
                            <p class="text-danger">{{$errors->first('zipcode')}}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group m-form__group row">
                            <label class="control-label">Facebook</label>
                            <input value="@if(!empty($setting->social_1)) {{$setting->social_1}} @endif" name="social_1" type="text" placeholder="Facebook" class="form-control ">
                            <p class="text-danger">{{$errors->first('social_1')}}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group m-form__group row">
                            <label class="control-label">Twitter {{--<span class="error_label">*</span>--}}</label>
                            <input value="@if(!empty($setting->social_2)) {{$setting->social_2}} @endif" name="social_2" type="text" placeholder="Twitter" class="form-control">
                           {{-- <p class="text-danger">{{$errors->first('social_2')}}</p>--}}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group m-form__group row">
                            <label class="control-label">Google Analytic</label>
                            <textarea  class="form-control" name="google_analytic">@if(!empty($setting->google_analytic)) {{$setting->google_analytic}} @endif</textarea>
                        </div>
                    </div>
                     <div class="col-md-4">
                        <div class="form-group m-form__group row">
                            <label class="control-label">I Frame</label>
                            <textarea  class="form-control" name="map_iframe">@if(!empty($setting->map_iframe)) {{$setting->map_iframe}} @endif</textarea>
                        </div>
                    </div>
                    <!--/span-->
                </div>
                <div class="row col-md-12">
                    <div class="col-md-6"></div>
                     <div class="col-md-6 pull-right">
                    <div class="form-actions pull-right">
                <button type="submit" class="btn btn-accent btn_save">
                    <i class="fa fa-check"></i> Update
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

   <script src="{{ asset('assets/pages/setting/update.js') }}"></script>

     <script src="{{ asset('assets/demo/default/custom/components/forms/widgets/summernote.js') }}"></script>

    
    

    <!-- multiple images -->



@stop