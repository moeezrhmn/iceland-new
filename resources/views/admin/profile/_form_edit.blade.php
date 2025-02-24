@extends('layouts.master')
@section('title', 'Edit Place')
@section('header_space')
    <link href="{{ asset('public/admin/css/select2.css') }}" rel="stylesheet" type="text/css" />
    <style type="text/css">
    .form-group.m-form__group.row{
        padding-bottom: 10px;
    }
        .shop_image {
    float: left;
    margin: 15px;
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
                            <a href="{{route('places.index')}}" class="m-nav__link">
                                <span class="m-nav__link-text">
                                    All Places
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
                <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PROFILE SIDEBAR -->
                <div class="profile-sidebar">
                    <!-- PORTLET MAIN -->
                    <div class="portlet light profile-sidebar-portlet">
                        <!-- SIDEBAR USERPIC -->
                        <div class="profile-userpic">
                            @if($edit_user->user_photo)

                                <img class="img-responsive" src="{{url('public/uploads/'.$edit_user->user_photo)}}" alt="" />
                            @else
                                <img class="img-responsive" src="{{ asset('assets/admin/images/demo.jpg') }}" alt="" />
                            @endif
                        </div>
                        <!-- END SIDEBAR USERPIC -->
                        <!-- SIDEBAR USER TITLE -->
                        <div class="profile-usertitle">
                            <div class="profile-usertitle-name"> {{$edit_user->first_name ." ".$edit_user->last_name }} </div>
                            <div class="profile-usertitle-job">

                            </div>
                        </div>
                        <!-- END SIDEBAR USER TITLE -->
                        <!-- SIDEBAR MENU -->
                        <div class="profile-usermenu">


                                <ul class="nav">
                                    <li class="active">
                                        <a href="#tab_1_1" data-toggle="tab">Personal Info</a>
                                    </li>
                                    <li>
                                        <a href="#tab_1_2" data-toggle="tab">Change Image</a>
                                    </li>
                                    <li>
                                        <a href="#tab_1_3" data-toggle="tab">Change Password</a>
                                    </li>
                                    <li>
                                        <a href="#tab_1_4" data-toggle="tab">Privacy Settings</a>
                                    </li>
                                </ul>

                            {{--<ul class="nav">--}}

                                {{--<li class="active">--}}
                                    {{--<a href="{{url('admin/profile#tab_1_2')}}" data-toggle="tab">--}}
                                        {{--<i class="icon-settings"></i> Change Image--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                                {{--<li class="active">--}}
                                    {{--<a href="#tab_1_3">--}}
                                        {{--<i class="icon-settings"></i> Change Password--}}
                                    {{--</a>--}}
                                {{--</li>--}}
                            {{--</ul>--}}
                        </div>
                        <!-- END MENU -->
                    </div>
                    <!-- END PORTLET MAIN -->
                </div>
                <!-- END BEGIN PROFILE SIDEBAR -->
                <!-- BEGIN PROFILE CONTENT -->
                <div class="profile-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light ">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption caption-md">
                                        <i class="icon-globe theme-font hide"></i>
                                        <span class="caption-subject font-blue-madison bold uppercase">Profile Account</span>
                                    </div>
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab_1_1" data-toggle="tab">Personal Info</a>
                                        </li>
                                        <li>
                                            <a href="#tab_1_2" data-toggle="tab">Change Image</a>
                                        </li>
                                        <li>
                                            <a href="#tab_1_3" data-toggle="tab">Change Password</a>
                                        </li>
                                        <li>
                                            <a href="#tab_1_4" data-toggle="tab">Privacy Settings</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="portlet-body">
                                    <div class="tab-content">
                                        <!-- PERSONAL INFO TAB -->
                                        <div class="tab-pane active" id="tab_1_1">
                                            <form action="{{url('admin/profile/update')}}" id="form_sample_3">
                                                {{ csrf_field() }}
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">First Name <span class="error_label">*</span></label>
                                                        <input type="text" placeholder="John" name="first_name" id="first_name" value="{{$edit_user->first_name }}" class="form-control" /> </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Last Name <span class="error_label">*</span></label>
                                                        <input type="text" placeholder="Doe" name="last_name" id="last_name" value="{{$edit_user->last_name }}" class="form-control" /> </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Email <span class="error_label">*</span></label>
                                                        <input type="text" placeholder="Doe" name="email" id="email" value="{{$edit_user->email }}" readonly class="form-control" /> </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Phone Number <span class="error_label">*</span></label>
                                                        <input type="text" placeholder="+1 646 580 DEMO (6284)" id="phone_no" name="phone_no" value="{{$edit_user->phone_no }}" class="form-control" />

                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Address <span class="error_label">*</span></label>
                                                        <input name="address"  class="form-control" id="address" value="{{$edit_user->address }}" placeholder="We are KeenThemes!!!">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">State <span class="error_label">*</span></label>
                                                        <input type="text"  value="{{$edit_user->state }}" id="state" name="state" placeholder="state" class="form-control" /> </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">City <span class="error_label">*</span></label>
                                                        <input type="text"   value="{{$edit_user->city }}" id="city" name="city" placeholder="state" class="form-control" /> </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="control-label">Country </label>
                                                        {{--<input type="text" name="country_id"  value="{{$edit_user->user_type }}" class="form-control" /> </div>--}}
                                                        <select name="country_code" class="form-control select2" >
                                                        @foreach($country as $obj)
                                                                <option @if($obj->code == $edit_user->country_code ) selected="selected" @endif value="{{$obj->code}}">{{$obj->name}}</option>

                                                            @endforeach
                                                        </select>
                                                </div>
                                                </div>


                                                <div class="col-md-6">
                                                <div class="form-group">
                                                    <button type="submit" class="btn green"> Save Changes </button>
                                                    <a href="{{ url('admin/dashboard') }}" class="btn default"> Cancel </a>
                                                </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- END PERSONAL INFO TAB -->
                                        <!-- CHANGE AVATAR TAB -->
                                        <div class="tab-pane" id="tab_1_2">
                                            <p> Please add you latest photo with size of 250 x 300 px. </p>
                                            <form method="post" enctype="multipart/form-data" action="{{ url('admin/profile/update_image') }}" role="form">

                                               {{ csrf_field() }}
                                                <div class="form-group">
                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                            @if($edit_user->user_photo)

                                                                <img class="img-responsive" src="{{url('public/uploads/'.$edit_user->user_photo)}}" alt="" />
                                                            @else
                                                                <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                                                                {{--<img class="img-responsive" src="{{ asset('assets/admin/images/demo.jpg') }}" alt="" />--}}
                                                            @endif


                                                        </div>


                                                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                                        <div>
                                                                        <span class="btn default btn-file">
                                                                            <span class="fileinput-new"> Select image </span>
                                                                            <span class="fileinput-exists"> Change </span>
                                                                            <input id="user_profile_pic" type="file" multiple accept="gif|jpg|" name="file"> </span>
                                                            <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                                        </div>
                                                    </div>
                                                    <span style="color:red ;" id="user_profile_pic-error" class="help-block help-block-error"></span>

                                                </div>
                                                <div class="margin-top-10">
                                                    <button type="submit" class="btn green"> Submit </button>
                                                    {{--<a href="javascript:;" class="btn default"> Cancel </a>--}}
                                                </div>
                                            </form>
                                        </div>
                                        <!-- END CHANGE AVATAR TAB -->
                                        <!-- CHANGE PASSWORD TAB -->

                                        <div class="tab-pane" id="tab_1_3">
                                            <form method="post" id="change_password" action="{{url('admin/profile/change_password')}}">
                                                {{csrf_field() }}
                                                <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Current Password</label>
                                                    <input type="password" class="form-control" placeholder="Current Password" id="current_password" name="current_password" value="" /> </div>
                                                <span style="color:red ;" id="current_password-error" class="help-block help-block-error"></span>
                                                <div class="f orm-group">
                                                    <label class="control-label">New Password</label>
                                                    <input name="password" id="password" placeholder="New Password" type="password" class="form-control" /> </div>
                                                <div class="form-group">
                                                    <label class="control-label">Re-type New Password</label>
                                                    <input name="confirm_password" id="confirm_password" placeholder="Re-type New Password" type="password" class="form-control" /> </div>
                                                <div class="margin-top-10">
                                                    <button type="submit" class="btn green"> Change Password </button>
                                                    {{--<a href="javascript:;" class="btn default"> Cancel </a>--}}
                                                </div>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- END CHANGE PASSWORD TAB -->
                                        <!-- PRIVACY SETTINGS TAB -->
                                        <div class="tab-pane" id="tab_1_4">
                                            <form action="#">
                                                <table class="table table-light table-hover">
                                                    <tr>
                                                        <td> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus.. </td>
                                                        <td>
                                                            <label class="uniform-inline">
                                                                <input type="radio" name="optionsRadios1" value="option1" /> Yes </label>
                                                            <label class="uniform-inline">
                                                                <input type="radio" name="optionsRadios1" value="option2" checked/> No </label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td> Enim eiusmod high life accusamus terry richardson ad squid wolf moon </td>
                                                        <td>
                                                            <label class="uniform-inline">
                                                                <input type="checkbox" value="" /> Yes </label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td> Enim eiusmod high life accusamus terry richardson ad squid wolf moon </td>
                                                        <td>
                                                            <label class="uniform-inline">
                                                                <input type="checkbox" value="" /> Yes </label>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td> Enim eiusmod high life accusamus terry richardson ad squid wolf moon </td>
                                                        <td>
                                                            <label class="uniform-inline">
                                                                <input type="checkbox" value="" /> Yes </label>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <!--end profile-settings-->
                                                <div class="margin-top-10">
                                                    <a href="javascript:;" class="btn green"> Save Changes </a>
                                                    {{--<a href="javascript:;" class="btn default"> Cancel </a>--}}
                                                </div>
                                            </form>
                                        </div>
                                        <!-- END PRIVACY SETTINGS TAB -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END PROFILE CONTENT -->
            </div>
        </div>

            </div>
            <!--end::Portlet-->
        </div>
    </div>

@stop

@section('footer_space')
     <script src="{{ asset('assets/demo/default/custom/components/forms/widgets/summernote.js') }}"></script>

   <script src="{{ asset('assets/pages/places/create.js') }}"></script>

     <script type="{{ asset('public/admin/js/select2.js') }}"></script>
    <script type="text/javascript">
         $(document).ready(
    function () {
        $(".select2-multiple").select2();
    }
);
    </script>
     <script src="{{ asset('assets/pages/places/jquery.geocomplete.js') }}"></script>
      <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAPUTGhVxI4piPZBg8wXT587e9EzDOar5w&sensor=false&amp;libraries=places">
    </script>
    <script type="text/javascript">
         <script>
        $(function () {
            $("#geocomplete").geocomplete({
                map: ".map_canvas",
                location: [64.12652059999999, -21.817439299999933],
                details: "form ",
                markerOptions: {
                    draggable: true
                }
            });

            $("#geocomplete").bind("geocode:dragged", function (event, latLng) {
             $("input[name=lat]").val(latLng.lat());
                $("input[name=lng]").val(latLng.lng());
                $("#reset").show();
            });
            $("#reset").click(function () {
                $("#geocomplete").geocomplete("resetMarker");
                $("#reset").hide();
                return false;
            });

            $("#find").click(function () {
                $("#geocomplete").trigger("geocode");
            });
        });
        ///////////////////////////////get single  address for update////////////////////////
        $(document).on('click', "#address_edit", function () {
            var token = $("input[name='_token']").val();
            var id = $(this).attr('data-content');
            $.ajax
            ({
                //contentType: "application/json; charset=utf-8",
                type: "POST",
                url: admin_url + "/admin/restaurants/edit_address",
                data: {'id': id, '_token': token},
                dataType: 'json',
                success: function (data) {
                    //alert(data.latitude);
                    $("input[name='lat']").val(data.latitude);
                    $("input[name='lng']").val(data.longitude);
                    $("input[name='formatted_address']").val(data.address);
                    $("#geocomplete").val(data.address);
                    $("#geocomplete").val(data.address);
                    $("#geocomplete").val(data.address);
                    $("#geocomplete").val(data.address);
                    $("#geocomplete").val(data.address);
                    $("#geocomplete").val(data.address);
                    $("input[name='country']").val(data.country);
                    $("input[name='locality']").val(data.city);
                    $("input[name='administrative_area_level_1']").val(data.state);
                    $("input[name='country']").val(data.country);
                    $("input[name='postal_code']").val(data.zipcode);
                    $("input[name='address_id']").val(data.address_id);
                }
            });
        });
   
    </script>
    <script>
    function readFile(input) {
    $("#status").html('Processing...');
    counter = input.files.length;
        for(x = 0; x<counter; x++){
            if (input.files && input.files[x]) {

                var reader = new FileReader();

                reader.onload = function (e) {
 $("#photos").append('<div class="col-md-3 col-sm-3 col-xs-3 imagePlace"><input style="margin-left: 35px;" type="radio" name="main_image"><img src="'+e.target.result+'" class="img-thumbnail"> <a href="javascript:void(0);" class="image_remove" >Remove </a></div>');
                };

                reader.readAsDataURL(input.files[x]);
            }
    }
    if(counter == x){$("#status").html('');}
  }
</script>
    <script>
    $(document).ready(function (e) {
        $(document).on('click','.image_remove',function () {
            
           $('.imagePlace').hide();
        });
    });
</script>
@stop