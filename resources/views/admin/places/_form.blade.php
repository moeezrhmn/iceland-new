@extends('layouts.master')
@section('title', 'Add Place')
@section('header_space')
{{--<link rel="stylesheet" type="text/css" href="http://select2.github.io/select2/select2-3.5.1/select2.css">--}}
<link href="{{ asset('admin_outer/css/select2.css') }}" rel="stylesheet" type="text/css" />
<style type="text/css">
    .form-group.m-form__group.row{
        padding-bottom: 10px;
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
               <form method="post" class="m-form m-form--state m-form--fit m-form--label-align-right" enctype="multipart/form-data" action="{{ url('admin/places') }}" id="place_form_sample_3"
              class="m-form m-form--state m-form--fit m-form--label-align-right ">
              <div class="m-portlet__body">
            {{--{{ method_field('POST')}}--}}
            {{ csrf_field() }}
             <input type="hidden" value="1" name="category_id" id="category_id">
             
            <div class="form-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button>
                        <span> You have <?php echo count($errors->all()) ?> errors. Please check below.</span>
                    </div>
                @endif
                
                <div class="row ">
                    <div class="col-md-6">
                        <div class="form-group m-form__group row">
                            <label class="control-label">Place Name <span class="error_label">*</span></label>
                            <input value="{{old('place_name')}}" name="place_name" type="text" id="place_name" class="form-control required"
                                   placeholder="Place Name">
                            <p class="text-danger">{{$errors->first('place_name')}}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group m-form__group row">
                            <label class="control-label">Slug</label>
                            <input value="{{old('slug')}}" name="slug" type="text" class="form-control"
                                   placeholder="Place Slug">
                        </div>
                    </div>
                    <!--<div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Category <span class="error_label">*</span></label>
                            <select class="form-control required" name="category_id" id="category_id">
                                <option value="">Select</option>
                                @foreach($categories as $catObj)
                                    <option @if(old('category_id') == $catObj->id) selected="selected" @endif value="{{$catObj->id}}">{{$catObj->cat_name}}</option>
                                @endforeach
                            </select>
                            <p class="text-danger">{{$errors->first('category_id')}}</p>
                        </div>-->
                    </div>
                </div>

                <!--/row-->
                <div class="row">
                    <div class="col-md-6 ">
                            <div class="form-group m-form__group row">
                        <label for="select2-multiple-input-sm" class="control-label">Subcategory</label>
                        <select name="subcategory[]" id="select2-multiple-input-sm" class="form-control input-sm select2-multiple" data-placeholder="Select Subcategory" multiple>
                            @foreach($categories as $catObj)
                                <option @if(old('category_id') == $catObj->id) selected="selected" @endif value="{{$catObj->id}}">{{$catObj->cat_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    </div>
                    <div class="col-md-6">
                            <div class="form-group m-form__group row">
                        <label for="select2-multiple-input-sm" class="control-label">Keywords</label>
                        <select name="keywords[]" id="select2-multiple-input-sm1" class="form-control input-sm select2-multiple" data-placeholder="Select Keywords" multiple>
                            @foreach($keywords as $keyObj)
                                <option @if(old('category_id') == $keyObj->id) selected="selected" @endif value="{{$keyObj->id}}">{{$keyObj->keyword_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    </div>

                </div>
                <div class="row">
                    <!--/span-->
                    <div class="col-md-3">
                        <div class="form-group m-form__group row">
                            <label class="control-label">SSN</label>
                            <input value="{{old('ssn')}}"  name="ssn" type="text" id="mask_ssn" placeholder="SSN" class="form-control">
                            <p class="text-danger">{{$errors->first('ssn')}}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group m-form__group row">
                            <label class="control-label">Order No <span class="error_label">*</span></label>
                            <input value="{{old('order_no')}}" name="order_no" type="number" placeholder="Order No" class="form-control required">
                            <p class="text-danger">{{$errors->first('order_no')}}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group m-form__group row">
                            <label class="control-label">Phone No {{--<span class="error_label">*</span>--}}</label>
                            <input value="{{old('phone')}}" name="phone" type="text" placeholder="Phone No" class="form-control">
                           {{-- <p class="text-danger">{{$errors->first('phone')}}</p>--}}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group m-form__group row">
                            <label class="control-label">Website</label>
                            <input value="{{old('website_url')}}" name="website_url" type="url" placeholder="Website" id="website"
                                   class="form-control">
                        </div>
                    </div>
                    <!--/span-->
                </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group m-form__group row">
                                <label class="control-label">Address <span class="error_label">*</span> (Search Your desired address )</label>
                                <div class="input-group">
                                    <input id="geocomplete" value="Reykjavík, Iceland" name="search_address" class="form-control required input_address" type="text">
                                       <span id="find" class="input-group-btn">
                                    <button class="btn default date_btn" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                                </div>
                                <p class="text-danger">{{$errors->first('search_address')}}</p>
                            </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group m-form__group row">
                                                <label class="control-label">Latitude</label>
                                                <input value="{{old('lat')}}" name="lat" type="text"
                                                       placeholder="Latitude" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group m-form__group row">
                                                <label class="control-label">Longitude</label>
                                                <input value="{{old('lng')}}" name="lng" type="text"
                                                       placeholder="Longitude" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group m-form__group row">
                                                <label class="control-label">Address</label>
                                                <input value="" name="formatted_address" type="text"
                                                       placeholder="Address" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group m-form__group row">
                                                <label class="control-label">Country</label>
                                                <input value="{{old('country')}}"  name="country" type="text"
                                                       placeholder="Country" class="form-control">
                                                <input value="{{old('country_short')}}" name="country_short" type="hidden"
                                                       class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group m-form__group row">
                                                <label class="control-label">State</label>
                                                <input value="{{old('administrative_area_level_1')}}" name="administrative_area_level_1" type="text"
                                                       placeholder="State" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group m-form__group row">
                                                <label class="control-label">City<span class="error_label">*</span></label>
                                                <input value="{{old('locality')}}" name="locality" type="text"
                                                       placeholder="City" class="form-control required">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group m-form__group row">
                                                <label class="control-label">Region</label>
                                               <!--  <input value="{{old('region')}}" name="region" type="text"
                                                       placeholder="City" class="form-control "> -->
                                                       <select class="form-control " name="region">
                                                           <option>Select</option>
                                                           @if(!empty($region))
                                                           @foreach($region as $obj)
                                                           <option value="{{$obj->name}}">{{$obj->name}}</option>
                                                           @endforeach
                                                           @endif
                                                       </select>

                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group m-form__group row">
                                                <label class="control-label">Zip Code</label>
                                                <input value="{{old('postal_code')}}" name="postal_code" type="text"
                                                       placeholder="Zip Code" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group m-form__group row">
                                    <label class="control-label">Map</label>
                                    <div class="map_canvas" style="height: 313px; width:100%"></div>
                                </div>
                            </div>
                        </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group m-form__group row">
                                <label class="control-label">Facebook Link</label>
                                <input value="{{old('social_1')}}" name="social_1" type="url" id="social_1" placeholder="Facebook Link" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group m-form__group row">
                                <label class="control-label">Twitter link</label>
                                <input value="{{old('social_2')}}" name="social_2" type="url" id="social_2" placeholder="Twitter link" class="form-control">
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group m-form__group row">
                                <label class="control-label">Tripadvisor Link</label>
                                <input value="{{old('social_3')}}" name="social_3" id="social_3" type="url" placeholder="Tripadvisor Link" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group m-form__group row">
                                <label class="control-label">Instagram</label>
                                <input value="{{old('social_4')}}" name="social_4" id="social_4" type="url" placeholder="Instagram" class="form-control">
                            </div>
                        </div>
                        <!--/span-->
                    </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group m-form__group row">
                            <label class="control-label">Description <span class="error_label">*</span></label>
                        
                        </div>
                            <textarea name="description"  class="summernote required"  >{{old('description')}}
                            </textarea>
                            <p class="text-danger">{{$errors->first('description')}}</p>
                     </div>
                
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <div class="checkbox-list">
                                <label class="control-label">Featured</label>
                                <input @if(old('is_featured')) checked @endif type="checkbox" id="inlineCheckbox1" name="is_featured" value="1">Is featured
                            </div>
                        </div>
                        <div class="form-group ">
                        <label class="control-label"> Choose Images <span class="error_label">*</span></label>
                        <br>
                        <input type="file" class="required" name="file[]" id="photo"  onchange="readFile(this);" multiple>
                        </div>
                        <div id="status"></div>
                         <div id="photos" class="row" style="width: 100%"></div>
                    </div>

                </div>

        </div>
        <div class="row" style="padding: 15px">
            <div class="col-md-6"></div>
            
                <div class="col-md-6 right">
                    <div class="form-actions pull-right">
                <button style="margin-right: 10px" type="submit" class="btn btn-accent btn_save">
                    <i class="fa fa-check"></i> Create
                </button>
                <a href="{{url('admin/places')}}" class="btn btn-secondary"> Cancel </a>
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

   <script src="{{ asset('assets/pages/places/create.js') }}"></script>

     <script src="{{ asset('assets/demo/default/custom/components/forms/widgets/summernote.js') }}"></script>
   <script type="{{ asset('admin_outer/js/select2.js') }}"></script>
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
   /*     $(document).on('click', "#address_edit", function () {
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
                     $("#geocomplete").val(data.address);
                    $("input[name='country']").val(data.country);
                    $("input[name='locality']").val(data.city);
                     $("input[name='region']").val(data.region);
                    $("input[name='administrative_area_level_1']").val(data.state);
                    $("input[name='country']").val(data.country);
                    $("input[name='postal_code']").val(data.zipcode);
                    $("input[name='address_id']").val(data.address_id);
                }
            });
        });*/
   
    </script>
    <!-- multiple images -->

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
        $('.image_remove').click(function () {
            var id = $(this).attr('id');
            // alert('.image_'.concat(id));
            $.ajax({
                type: "GET",
                url: admin_url + "/admin/places/remove_image",
                data: {'id': id},
                success: function (data) {
                    /*alert(data);*/
                    $('#image_'.concat(data)).hide();
                }
            });
        });
    });
</script>
 <script>
    $(document).ready(function (e) {
        $(document).on('click','.image_remove',function () {
            alert();
           $('.imagePlace').remove();
        });
    });
</script>
@stop