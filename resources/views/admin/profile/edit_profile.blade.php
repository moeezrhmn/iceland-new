@extends('layouts.master')
@section('title', 'My Profile')
@section('header_space')
<style type="text/css">
    #user-form{
        width: 50%;
        margin: 0 auto;
    }
    .m-form .m-form__group {
        padding-top: 0px !important;
padding-bottom: 0px !important;
    }
    .fileUpload #logo-id {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 33px;
    cursor: pointer;
    opacity: 0;
    filter: alpha(opacity=0);
}
.form-group.m-form__group.row{
    padding-bottom: 15px !important;
}
.m-subheader {
    padding: 30px 30px 30px 30px;
}
</style>

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
      
                        <div class="row">

                            <div class="col-lg-3">
                                <div class="m-portlet m-portlet--full-height ">
                                    <div class="m-portlet__body">
                                        <div class="m-card-profile">
                                            <div class="m-card-profile__title m--hide">
                                                Your Profile
                                            </div>
                                            <div class="m-card-profile__pic">
                                                <div class="m-card-profile__pic-wrapper" style="margin: 0px;border: 0px;height: 106px;">
                                                    <img style="height: 106px" src="{{url('uploads/'.$edit_user->user_photo)}}" alt="">
                                                </div>
                                               <!-- change image -->
                                                  <div class=" m-form__group row">
                          <div class="form-group" style="width: 55%;padding-left: 15px;">
            
              <div class="input-group" style="">
                <form method="post" action="{{url('admin/profile/update_image')}}"  enctype="multipart/form-data" >
                     {{ csrf_field() }}
                   
                     <!-- <input id="fakeUploadLogo" class="form-control fake-shadow" placeholder="Choose File" disabled="disabled"> -->
                <div class="input-group-btn">
                  <div class="fileUpload btn  fake-shadow" id="updat_image">
                    <span ><i class="glyphicon glyphicon-upload"></i> <a href="javascript:void(0);" >Edit</a></span>
                    <input id="logo-id" name="file" type="file" class="attachment_upload">
                  </div>
                </div>
                  <div class="m-form__actions " id="updateBtnSub" style="display: none">
                                                        <div class="row">
                                                            <div class="col-2"></div>
                                                            <div class="col-7">
                                                                <button type="Submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">
                                                                    Update
                                                                </button>
                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                </form>
               
              </div>
             
            </div>
                    
                    </div>






                                            </div>
                                            <div class="m-card-profile__details">
                                                <span class="m-card-profile__name">
                                                 @if(!empty($edit_user->name))  {{@$edit_user->name}} @else {{@$edit_user->first_name}}.' '.{{@$edit_user->last_name}} @endif
                                                </span>
                                                <a href="" class="m-card-profile__email m-link">
                                                    {{@$edit_user->email}}
                                                </a>
                                            </div>
                                        </div>
                                        <ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
                                            <li class="m-nav__separator m-nav__separator--fit"></li>
                                            <li class="m-nav__section m--hide">
                                                <span class="m-nav__section-text">
                                                    Section
                                                </span>
                                            </li>
                                            <li class="m-nav__item">
                                                <a href="../header/profile&amp;demo=default.html" class="m-nav__link">
                                                    <i class="m-nav__link-icon flaticon-profile-1"></i>
                                                    <span class="m-nav__link-title">
                                                        <span class="m-nav__link-wrap">
                                                            <span class="m-nav__link-text">
                                                                My Profile
                                                            </span>
                                                            <span class="m-nav__link-badge">
                                                                <span class="m-badge m-badge--success">
                                                                    2
                                                                </span>
                                                            </span>
                                                        </span>
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="m-nav__item">
                                                <a href="../header/profile&amp;demo=default.html" class="m-nav__link">
                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                    <span class="m-nav__link-text">
                                                        Activity
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="m-nav__item">
                                                <a href="../header/profile&amp;demo=default.html" class="m-nav__link">
                                                    <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                    <span class="m-nav__link-text">
                                                        Messages
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="m-nav__item">
                                                <a href="../header/profile&amp;demo=default.html" class="m-nav__link">
                                                    <i class="m-nav__link-icon flaticon-graphic-2"></i>
                                                    <span class="m-nav__link-text">
                                                        Sales
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="m-nav__item">
                                                <a href="../header/profile&amp;demo=default.html" class="m-nav__link">
                                                    <i class="m-nav__link-icon flaticon-time-3"></i>
                                                    <span class="m-nav__link-text">
                                                        Events
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="m-nav__item">
                                                <a href="../header/profile&amp;demo=default.html" class="m-nav__link">
                                                    <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                                    <span class="m-nav__link-text">
                                                        Support
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                        <!-- <div class="m-portlet__body-separator"></div> -->
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div class="m-portlet m-portlet--full-height m-portlet--tabs ">
                                    <div class="m-portlet__head">
                                        <div class="m-portlet__head-tools">
                                            <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
                                                <li class="nav-item m-tabs__item">
                                                    <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_user_profile_tab_1" role="tab" aria-expanded="true">
                                                        <i class="flaticon-share m--hide"></i>
                                                        Update Profile
                                                    </a>
                                                </li>
                                                <li class="nav-item m-tabs__item">
                                                    <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_user_profile_tab_2" role="tab" aria-expanded="false">
                                                        Change Password
                                                    </a>
                                                </li>
                                                
                                            </ul>
                                        </div>
                                        
                                    </div>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="m_user_profile_tab_1" aria-expanded="true">
                                            <form class="m-form m-form--fit m-form--label-align-right" method="Post" action="{{url('admin/profile/update')}}" id="profile_update" >
                                                 {{ csrf_field() }}
                                                <div class="m-portlet__body">
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
                                                   <!--  <div class="form-group m-form__group m--margin-top-10 m--hide">
                                                        <div class="alert m-alert m-alert--default" role="alert">
                                                            The example form below demonstrates common HTML form elements that receive updated styles from Bootstrap with additional classes.
                                                        </div>
                                                    </div> -->
                                                    <div class="form-group m-form__group row">
                                                        <div class="col-10 ml-auto">
                                                            <h3 class="m-form__section">
                                                                1. Personal Details
                                                            </h3>
                                                        </div>
                                                    </div>
                                                     <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            First Name
                                                        </label>
                                                        <div class="col-7">
                                                            <input class="form-control m-input" name="first_name" value="{{@$edit_user->first_name}}" type="text">
                                                        </div>
                                                    </div>
                                                     <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Last Name
                                                        </label>
                                                        <div class="col-7">
                                                            <input class="form-control m-input" name="last_name" value="{{@$edit_user->last_name}}" type="text">
                                                        </div>
                                                    </div>
                                                   <!--  <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Full Name <span style="color: red"> *</span>
                                                        </label>
                                                        <div class="col-7">
                                                            <input class="form-control m-input" name="name" value="{{@$edit_user->name}}" type="text">
                                                        </div>
                                                    </div> -->
                                                    <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Email
                                                        </label>
                                                        <div class="col-7">
                                                            <input class="form-control m-input" name="email" value="{{@$edit_user->email}}" type="text">
                                                        </div>
                                                    </div>
                                                   
                                                    <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Phone No.
                                                        </label>
                                                        <div class="col-7">
                                                            <input class="form-control m-input" name="phone_no" value="{{$edit_user->phone_no}}" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-2x"></div>
                                                    <div class="form-group m-form__group row">
                                                        <div class="col-10 ml-auto">
                                                            <h3 class="m-form__section">
                                                                2. Address
                                                            </h3>
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Address
                                                        </label>
                                                        <div class="col-7">
                                                            <input class="form-control m-input" name="address" value="{{$edit_user->address}}" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            City
                                                        </label>
                                                        <div class="col-7">
                                                            <input class="form-control m-input" name="city" value="{{$edit_user->city}}" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            State
                                                        </label>
                                                        <div class="col-7">
                                                            <input class="form-control m-input" name="state" value="{{$edit_user->state}}" type="text">
                                                        </div>
                                                    </div>
                                                     <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Country
                                                        </label>
                                                        <div class="col-7">
                                                            <select class="form-control select2" name="country_code" >
                                                                @if(!empty($country))
                                                                @foreach($country as $obj)
                                                                <option @if(isset($edit_user->country_code) && $edit_user->country_code == $obj->code) selected="selected" @endif value="{{$obj->code}}">{{$obj->name}}</option>
                                                               
                                                                @endforeach
                                                                @endif
                                                            </select>
                                                          
                                                        </div>
                                                    </div>
                                                   <!--  <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Postcode
                                                        </label>
                                                        <div class="col-7">
                                                            <input class="form-control m-input" value="45000" type="text">
                                                        </div>
                                                    </div> -->
                                                    <div class="m-form__seperator m-form__seperator--dashed m-form__seperator--space-2x"></div>
                                                    <div class="form-group m-form__group row">
                                                        <div class="col-10 ml-auto">
                                                            <h3 class="m-form__section">
                                                                3. Social Links
                                                            </h3>
                                                        </div>
                                                    </div>
                                                  
                                                    <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Facebook
                                                        </label>
                                                        <div class="col-7">
                                                            <input class="form-control m-input" name="facebook_id" value="{{@$edit_user->facebook_id}}" type="url">
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label for="example-text-input"  class="col-2 col-form-label">
                                                            Twitter
                                                        </label>
                                                        <div class="col-7">
                                                            <input class="form-control m-input" name="twitter_id" value="{{@$edit_user->twitter_id}}" type="url">
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-2 col-form-label">
                                                            Google
                                                        </label>
                                                        <div class="col-7">
                                                            <input class="form-control m-input" name="google_id" value="{{@$edit_user->google_id}}" type="url">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="m-portlet__foot m-portlet__foot--fit">
                                                    <div class="m-form__actions">
                                                        <div class="row">
                                                            <div class="col-2"></div>
                                                            <div class="col-7">
                                                                <button type="Submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">
                                                                    Update
                                                                </button>
                                                                &nbsp;&nbsp;
                                                                <button type="reset" class="btn btn-secondary m-btn m-btn--air m-btn--custom">
                                                                    Cancel
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane" id="m_user_profile_tab_2" aria-expanded="false">
                                            <form class="m-form m-form--fit m-form--label-align-right" method="Post" action="{{url('admin/profile/change_password')}}" id="change_password">
                                                 {{ csrf_field() }}
                                                <div class="m-portlet__body">
                                                
                                                    <div class="form-group m-form__group row">
                                                        <div class="col-10 ml-auto">
                                                            <h3 class="m-form__section">
                                                               Change Password
                                                            </h3>
                                                        </div>
                                                    </div>

                                                    <!-- <div class="form-group m-form__group row">
                                                        <label for="example-text-input"  class="col-2 col-form-label">
                                                            Current Password
                                                        </label>
                                                        <div class="col-7">
                                                            <input class="form-control m-input" name="current_password" value="" type="text">
                                                        </div>
                                                    </div> -->
                                                     <div class="form-group m-form__group row">
                                                        <label for="example-text-input"  class="col-4 col-form-label">
                                                            New Password <span style="color: red"> *</span>
                                                        </label>
                                                        <div class="col-7">
                                                            <input class="form-control m-input" id="password" name="password" value="" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <label for="example-text-input" class="col-4 col-form-label">
                                                            Confirm Password <span style="color: red"> *</span>
                                                        </label>
                                                        <div class="col-7">
                                                            <input class="form-control m-input" name="password_confirmation"  value="" type="text">
                                                        </div>
                                                    </div>
                                                  
                                                        <div class="m-portlet__foot m-portlet__foot--fit">
                                                    <div class="m-form__actions">
                                                        <div class="row">
                                                            <div class="col-2"></div>
                                                            <div class="col-7">
                                                                <button type="Submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">
                                                                     Change
                                                                </button>
                                                                &nbsp;&nbsp;
                                                                <button type="reset" class="btn btn-secondary m-btn m-btn--air m-btn--custom">
                                                                    Cancel
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                    
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
    </div>

@stop

@section('footer_space')
    
        <script src="{{ asset('assets/pages/profile/edit.js') }}"></script>
  
     <script type="text/javascript">
            $(document).ready(function() {
                $(document).on('click','#updat_image',function(){
                
                    $('#updateBtnSub').css({'display':'block'});


                });
    
});



        </script>
@stop