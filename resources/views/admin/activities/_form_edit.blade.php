@extends('layouts.master')
@section('title', 'Edit Activity')
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
.error_label{
        color: red;
    }
    .select2-selection.select2-selection--multiple{
        height: 38px;
    }
    </style>
@endsection
@section('title_right_section')
    <a href="{{ 'admin::activities.create'}}"
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
                            <a href="{{route('activities.index')}}" class="m-nav__link">
                                <span class="m-nav__link-text">
                                    All activities
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
               <form method="post" enctype="multipart/form-data" class="m-form m-form--state m-form--fit m-form--label-align-right" action=" {{ url('admin/activities/'.$activity->id) }}"
              id="form_sample_3" class="m-form m-form--state m-form--fit m-form--label-align-right" style="padding: 20px;">
            <input name="prev_url" type="hidden" value="<?php echo URL::previous(); ?>">
             <input type="hidden" value="3" name="category_id" id="category_id">
            {{ method_field('PUT') }}
            {{ csrf_field() }}

            <div class="form-body">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <button class="close" data-close="alert"></button>
                    <span> You have <?php echo count($errors->all()) ?> errors. Please check below.</span>

                </div>
                @endif

                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Activity Name <span class="error_label">*</span></label>
                            <input value="{{$activity->activity_name}}" name="activity_name" type="text" id="activity_name"
                                   class="form-control required" placeholder="Activity Name">
                            <p class="text-danger">{{$errors->first('activity_name')}}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Slug</label>
                            <input value="{{$activity->slug}}" name="slug" type="text" class="form-control"
                                   placeholder="Activity Slug">
                        </div>
                    </div>
            
                </div>
                <div class="row">
                    <input value="{{$activity->track_id}}" name="track_id" type="hidden" id="mask_track_id"
                           class="form-control">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="select2-multiple-input-sm" class="control-label">Subcategory</label>
                         <?php
                            $array=array();
                            foreach ($activity->subCategories_edit as $data)
                            {
                                $array[] = $data->id;
                            }
                            //dd($subcategory);
                            ?>
                        <select name="subcategory[]" id="select2-multiple-input-sm"
                                class="form-control input-sm select2-multiple" data-placeholder="Select Subcategory" multiple>
                            @foreach($subcategory as $subcatAll)
                                <option  <?php if(in_array($subcatAll->id, $array)) { ?> selected="selected" <?php } ?>
                                value="{{$subcatAll->id}}">{{$subcatAll->cat_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="select2-multiple-input-sm" class="control-label">Keywords</label>
                        <select name="keywords[]" id="select2-multiple-input-sm1"
                                class="form-control input-sm select2-multiple" data-placeholder="Select Keywords" multiple>
                                @if(!empty($activity))
                            <?php
                            $key_array=array();
                            foreach ($activity->keywords as $keyObj)
                            {
                                $key_array[] = $keyObj->keyword_id;
                            }
                            ?>
                            @foreach($keywords as $keywordAll)
                                <option  <?php if (in_array($keywordAll->id, $key_array)) { ?> selected="selected" <?php } ?>
                                value="{{$keywordAll->id}}">{{$keywordAll->keyword_name}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">SSN </label>
                            <input value="{{$activity->ssn}}" name="ssn" type="text" id="mask_ssn"
                                   placeholder="SSN"
                                   class="form-control"></div>
                        <p class="text-danger">{{$errors->first('ssn')}}</p>
                    </div>
                    <!--/span-->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Order No {{--<span class="error_label">*</span>--}}</label>
                            <input value="{{$activity->order_no}}" name="order_no" type="number"
                                   placeholder="Order No" class="form-control "></div>
                      {{--  <p class="text-danger">{{$errors->first('order_no')}}</p>--}}
                    </div>


                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Duration</label>
                                <input value="{{$activity->duration}}" name="duration" type="text" id="duration"
                                       placeholder="Duration" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Price</label>
                                <input value="{{$activity->price}}" name="price" type="text" id="price"
                                       placeholder="Price"
                                       class="form-control">
                            </div>
                        </div>


                </div>

                   <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Phone No </label>
                            <input value="{{$activity->phone}}" name="phone" type="text"
                                   placeholder="Phone No" class="form-control"></div>
                        {{-- <p class="text-danger">{{$errors->first('phone')}}</p>--}}
                    </div>
                    <!--/span-->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Website</label>
                            <input value="{{$activity->website_url}}" name="website_url" type="url" placeholder="Website"
                                   class="form-control">
                            <p class="text-danger">{{$errors->first('website_url')}}</p>
                        </div>
                    </div>
                   </div>


                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Address <span class="error_label">*</span> (Search Your desired address )</label>
                            <div class="input-group">
                                <input id="geocomplete" value="{{old('search_address')}}{{ @$activity->address->address }}"
                                       class="form-control" type="text">
                                <span id="find" class="input-group-addon"><i class="fa fa-search"></i></span>
                            </div>
                            <p class="text-danger">{{$errors->first('search_address')}}</p>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Latitude</label>
                                    <input value="{{ @$activity->address->latitude }}" id="lat" name="lat" type="text"
                                           placeholder="Latitude" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Longitude</label>
                                    <input value="{{ @$activity->address->longitude }}" id="long" name="lng" type="text"
                                           placeholder="Longitude" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Address</label>
                                    <input value="{{ @$activity->address->address }}" name="formatted_address" type="text"
                                           placeholder="Address" class="form-control">
                                </div>
                            </div>
                            <?php
                            //dd($activity->address)
                            ?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Country</label>
                                    <input value="{{ @$activity->address->country }}" name="country" type="text"
                                           placeholder="Country" class="form-control">
                                    <input value="{{ @$activity->address->country }}" name="country_short" type="hidden"
                                            class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">State</label>
                                    <input value="{{ @$activity->address->state }}" name="administrative_area_level_1"
                                           type="text"
                                           placeholder="State" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">City<span class="error_label">*</span></label>
                                    <input value="{{ @$activity->address->city }}" name="locality" type="text"
                                           placeholder="City" class="form-control required">
                                </div>
                            </div>
                            <div class="col-md-6">
                                            <div class="form-group m-form__group row">
                                                <label class="control-label">Region</label>
                                                       <select class="form-control" id="region" name="region">
                                                           <option>Select</option>
                                                           @if(!empty($region))
                                                           @foreach($region as $obj)
                                                           <option @if(isset($activity->address->region) && $activity->address->region==$obj->name  ) selected @endif value="{{$obj->name}}">{{$obj->name}}</option>
                                                           @endforeach
                                                           @endif
                                                       </select>
                                                {{--<script> $('#region').val();</script>--}}
                                            </div>
                                        </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Zip Code</label>
                                    <input value="{{ @$activity->address->zipcode }}" name="postal_code" type="text"
                                           placeholder="Zip Code" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Email</label>
                                    <input value="{{ @$activity->address->email }}" name="email" type="text"
                                           placeholder="Email" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Map</label>
                            <div class="map_canvas" style="height: 313px; width:100%">

                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Description <span class="error_label">*</span></label>
                            {{-- <input value=""  name="description" type="text" class="form-control"></div>--}}
                            <textarea name="description"  class="summernote">
                                {{$activity->description}}
                            </textarea>
                            <p class="text-danger">{{$errors->first('description')}}</p>
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <div class="checkbox-list">
                                <label class="control-label">Featured </label>
                                <input @if($activity->is_featured)  checked="checked" @endif type="checkbox"
                                       id="inlineCheckbox1" name="is_featured" value="1">Is featured
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label"> Choose Images <span class="error_label">*</span></label>
                            <p id="image_error" class="text-danger">{{$errors->first('file')}}</p>
                            <input type="file" name="file[]"  onchange="readFile(this);"    class="multi with-preview" multiple accept="gif|jpg|png|jpeg" id="image"/>
                        </div>
                        <div id="images_list" class="control-group">
                            <div id="imgShow" style=""></div>
                            @if(sizeof($activity->photo))
                                @foreach($activity->photo as $photoobj)
                                    <div class="col-md-3 shop_image imagePlace" id="image_{{$photoobj->photo_id}}">
                                        <div class="radio_btn">
                                            <input style="margin: 0 auto;
width: 145%;"  type="radio" name="main_image" class="MultiFile-title"
                                                   <?php echo ($photoobj->main == 1) ? 'checked' : ''; ?> value="{{$photoobj->photo_id}}">
                                        </div>
                                        <img alt="activities image" style="width:125px;height:125px;"
                                             src="{{url('public/uploads/activities/thumb'.$photoobj->photo)}}"/>
                                        <div>
                                        </div>
                                        <a style="color: red" href="javascript:void(0);" class=" MultiFile-remove image_remove"
                                           id="{{$photoobj->photo_id}}">
                                            Remove
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                               <div id="status"></div>
                         <div id="photos" class="row" style="width: 100%;margin-left: 12px;"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <div class="form-actions pull-right">
                    <button style="" type="submit" class="btn btn-accent">
                        <i class="fa fa-check"></i> Update
                    </button>
                    <a href="{{url('admin/activities')}}" class="btn btn-secondary"> Cancel </a>
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
     <script src="{{ asset('assets/demo/default/custom/components/forms/widgets/summernote.js') }}"></script>

   <script src="{{ asset('assets/pages/activities/create.js') }}"></script>

     <script type="{{ asset('public/admin/js/select2.js') }}"></script>
     <script type="text/javascript">
         $(document).ready(
    function () {
        $(".select2-multiple").select2();
    }
);
    </script>
     <!-- <script src="{{ asset('assets/pages/activities/jquery.geocomplete.js') }}"></script> -->
      <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAPUTGhVxI4piPZBg8wXT587e9EzDOar5w&sensor=false&amp;libraries=places">
    </script>
        {!! Html::script('assets/admin/js/jquery.geocomplete.js') !!}
    <script type="text/javascript">
        
        $(function () {
            $("#geocomplete").geocomplete({
                map: ".map_canvas",
                location: [$('#lat').val(), $('#long').val()],
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
      
   
    </script>
    <script>
    function readFile(input) {
    $("#status").html('Processing...');
    counter = input.files.length;
        for(x = 0; x<counter; x++){
            if (input.files && input.files[x]) {

                var reader = new FileReader();

                reader.onload = function (e) {
 $("#photos").append('<div class="imagePlace_'+x+'" id="image_" style="width: 135px;"><input style="margin-left: 60px;" type="radio" name="main_image"><img src="'+e.target.result+'" class="img-thumbnail" style="width: 238px;height: 140px;border: none;"><a href="javascript:void(0);" class="col-md-4 col-sm-3 col-xs-3 imageRemove" contact-id="'+x+'" style="color:red;padding-right: 0px;" > Remove </a></div>');
                };

                reader.readAsDataURL(input.files[x]);
            }
    }
    if(counter == x){$("#status").html('');}
  }
</script>
<!-- <script type="text/javascript">
     $(document).ready(function (e) {
        $(document).on('click','.imageRemove',function () {
            
         var id = $(this).attr('contact-id');
         $(this).hide();
             });
    });
</script> -->
<script type="text/javascript">
     $(document).ready(function (e) {
        $(document).on('click','.imageRemove',function () {
         var id = $(this).attr('contact-id');
         $('.imagePlace_'+id).hide();
             });
    });
</script>
    <script>
    $(document).ready(function (e) {
        $(document).on('click','.image_remove',function () {
            
         var id = $(this).attr('id');
         // alert(id);
            $.ajax({
                type: "GET",
                url: admin_url + "/admin/activities/remove_image",
                data: {'id': id},
                success: function (data) {
                  //  alert(data);
                    $('#image_'+id).hide();
                }
            });
        });
    });
</script>
@stop