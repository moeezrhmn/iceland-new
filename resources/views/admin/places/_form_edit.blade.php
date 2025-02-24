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
.error_label{
        color: red;
    }
    .select2-selection.select2-selection--multiple{
        height: 38px;
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
               <form method="post" enctype="multipart/form-data" class="m-form m-form--state m-form--fit m-form--label-align-right" action=" {{ url('admin/places/'.$edit_place->id) }}"
              id="form_sample_3" class="m-form m-form--state m-form--fit m-form--label-align-right" style="padding: 20px;">
            <input name="prev_url" type="hidden" value="<?php echo URL::previous(); ?>">
             <input type="hidden" value="1" name="category_id" id="category_id">
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
                            <label class="control-label">Place Name <span class="error_label">*</span></label>
                            <input value="{{$edit_place->place_name}}" name="place_name" type="text" id="place_name"
                                   class="form-control required" placeholder="Place Name">
                            <p class="text-danger">{{$errors->first('place_name')}}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Slug</label>
                            <input value="{{$edit_place->slug}}" name="slug" type="text" class="form-control"
                                   placeholder="Place Slug">
                        </div>
                    </div>
            
                </div>
                <div class="row">
                    <input value="{{$edit_place->track_id}}" name="track_id" type="hidden" id="mask_track_id"
                           class="form-control">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                        <label for="select2-multiple-input-sm" class="control-label">Subcategory</label>
                         <?php
                            $array=array();
                            foreach ($edit_place->subCategories_edit as $data)
                            {
                                $array[] = $data->id;
                            }
                            //print_r($subcategory);
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
                                @if(!empty($edit_place))
                            <?php
                            $key_array=array();
                            foreach ($edit_place->keywords as $keyObj)
                            {
                                $key_array[] = $keyObj->id;
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
                            <input value="{{$edit_place->ssn}}" name="ssn" type="text" id="mask_ssn"
                                   placeholder="SSN"
                                   class="form-control"></div>
                        <p class="text-danger">{{$errors->first('ssn')}}</p>
                    </div>
                    <!--/span-->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Order No {{--<span class="error_label">*</span>--}}</label>
                            <input value="{{$edit_place->order_no}}" name="order_no" type="number"
                                   placeholder="Order No" class="form-control "></div>
                      {{--  <p class="text-danger">{{$errors->first('order_no')}}</p>--}}
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Phone No </label>
                            <input value="{{$edit_place->phone}}" name="phone" type="text"
                                   placeholder="Phone No" class="form-control"></div>
                       {{-- <p class="text-danger">{{$errors->first('phone')}}</p>--}}
                    </div>
                    <!--/span-->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Website</label>
                            <input value="{{$edit_place->website_url}}" name="website_url" type="url" placeholder="Website"
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
                                <input id="geocomplete" value="{{old('search_address')}}{{ @$edit_place->address->address }}"
                                       class="form-control" type="text">
                                <span id="find" class="input-group-addon"><i class="fa fa-search"></i></span>
                            </div>
                            <p class="text-danger">{{$errors->first('search_address')}}</p>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Latitude</label>
                                    <input value="{{ @$edit_place->address->latitude }}" id="lat" name="lat" type="text"
                                           placeholder="Latitude" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Longitude</label>
                                    <input value="{{ @$edit_place->address->longitude }}" id="long" name="lng" type="text"
                                           placeholder="Longitude" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Address</label>
                                    <input value="{{ @$edit_place->address->address }}" name="formatted_address" type="text"
                                           placeholder="Address" class="form-control">
                                </div>
                            </div>
                            <?php
                            //dd($edit_place->address)
                            ?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Country</label>
                                    <input value="{{ @$edit_place->address->country }}" name="country" type="text"
                                           placeholder="Country" class="form-control">
                                    <input value="{{ @$edit_place->address->country }}" name="country_short" type="hidden"
                                            class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">State</label>
                                    <input value="{{ @$edit_place->address->state }}" name="administrative_area_level_1"
                                           type="text"
                                           placeholder="State" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">City<span class="error_label">*</span></label>
                                    <input value="{{ @$edit_place->address->city }}" name="locality" type="text"
                                           placeholder="City" class="form-control required">
                                </div>
                            </div>
                            <div class="col-md-6">
                                            <div class="form-group m-form__group row">
                                                <label class="control-label">Region</label>
                                                       <select class="form-control " name="region">
                                                           <option>Select</option>
                                                           @if(!empty($region))
                                                           @foreach($region as $obj)
                                                           <option @if(isset($edit_place->address->region) && $edit_place->address->region==$obj->name  ) selected @endif value="{{$obj->name}}">{{$obj->name}}</option>
                                                           @endforeach
                                                           @endif
                                                       </select>

                                            </div>
                                        </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Zip Code</label>
                                    <input value="{{ @$edit_place->address->zipcode }}" name="postal_code" type="text"
                                           placeholder="Zip Code" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Email</label>
                                    <input value="{{ @$edit_place->address->email }}" name="email" type="text"
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
                            <label class="control-label">Facebook Link</label>
                            <input value="{{$edit_place->social_1}}" name="social_1" type="url" id="social_1"
                                   placeholder="Facebook Link" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Twitter link</label>
                            <input value="{{$edit_place->social_2}}" name="social_2" type="url" id="social_2"
                                   placeholder="Twitter link"
                                   class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Tripadvisor Link</label>
                            <input value="{{$edit_place->social_3}}" name="social_3" id="social_3" type="url"
                                   placeholder="Tripadvisor Link"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Instagram</label>
                            <input value="{{$edit_place->social_4}}" name="social_4" id="social_4" type="url"
                                   placeholder="Instagram"
                                   class="form-control">
                        </div>
                    </div>
                    <!--/span-->
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Description <span class="error_label">*</span></label>
                            {{-- <input value=""  name="description" type="text" class="form-control"></div>--}}
                            <textarea name="description"  class="summernote">
                                {{$edit_place->description}}
                            </textarea>
                            <p class="text-danger">{{$errors->first('description')}}</p>
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <div class="checkbox-list">
                                <label class="control-label">Featured </label>
                                <input @if($edit_place->is_featured)  checked="checked" @endif type="checkbox"
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
                            @if(sizeof($edit_place->photo))
                                @foreach($edit_place->photo as $photoobj)
                                    <div class="col-md-3 shop_image imagePlace" id="image_{{$photoobj->photo_id}}">
                                        <div class="radio_btn">
                                            <input style="margin: 0 auto;width: 145%;"  type="radio" name="main_image" class="MultiFile-title"
                                                   <?php echo ($photoobj->main == 1) ? 'checked' : ''; ?> value="{{$photoobj->photo_id}}">
                                        </div>
                                        <img alt="Place image" style="width:125px;height:125px;"
                                             src="{{url('public/uploads/'.$photoobj->photo)}}"/>
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
                    <a href="{{url('admin/places')}}" class="btn btn-secondary"> Cancel </a>
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

   <script src="{{ asset('assets/pages/places/create.js') }}"></script>
     <script type="{{ asset('public/admin/js/select2.js') }}"></script>
    {{--<script type="http://select2.github.io/select2/select2-3.5.1/select2.js"></script>--}}
    <script type="text/javascript">
         $(document).ready(
    function () {
        $(".select2-multiple").select2();
    }
);
    </script>
     <!-- <script src="{{ asset('assets/pages/places/jquery.geocomplete.js') }}"></script> -->
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
                url: admin_url + "/admin/places/remove_image",
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