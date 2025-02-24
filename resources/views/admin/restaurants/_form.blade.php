@extends('layouts.master')
@section('title', 'Add Restaurant')
@section('header_space')
    <link href="{{ asset('public/admin/css/select2.css') }}" rel="stylesheet" type="text/css" />
<style type="text/css">
    .m-form.m-form--state.m-form--fit.m-form--label-align-right{
        padding-bottom: 10px;
    }
    .error_label{
        color: red;
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
                            <a href="{{route('restaurants.index')}}" class="m-nav__link">
                                <span class="m-nav__link-text">
                                    All @yield('title')
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
            <form method="post" class="m-form m-form--state m-form--fit m-form--label-align-right" enctype="multipart/form-data" action="{{ url('admin/restaurants') }}" id="place_form_sample_3"
              class="m-form m-form--state m-form--fit m-form--label-align-right" style="padding: 15px;">
                {{ csrf_field() }}
                <div class="form-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <button class="close" data-close="alert"></button>
                            <span> You have <?php echo count($errors->all()) ?> errors. Please check below. </span>
                        </div>
                    @endif
                
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Restaurant Name <span
                                            class="error_label">*</span></label>
                                <input value="{{old('restaurant_name')}}" name="restaurant_name" type="text"
                                       id="restaurant_name" class="form-control required"
                                       placeholder="Name">
                                <p class="text-danger">{{$errors->first('restaurant_name')}}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Slug</label>
                                <input value="{{old('slug')}}" name="slug" type="text" class="form-control"
                                       placeholder="Resturant Slug">
                            </div>
                        </div>

                    </div>
                    <!--/row-->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="select2-multiple-input-sm" class="control-label">Subcategory</label>
                                <select name="subcategory[]" id="select2-multiple-input-sm"
                                     data-placeholder="Select Subcategory"    class="form-control input-sm select2-multiple" multiple>
                                    <?php
                                    if(old('subcategory'))
                                    {
                                        $sub_array = old('subcategory');
                                    }
                                    else{
                                        $sub_array = array();
                                    }
                                    ?>
                                    @foreach($subcategory as $subcatObj)
                                        <option  @if(in_array($subcatObj->id,$sub_array)) selected="selected" @endif  value="{{$subcatObj->id}}">{{$subcatObj->cat_name}}</option>
                                    @endforeach
                                </select>
                                <p class="text-danger">{{$errors->first('subcategory')}}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="select2-multiple-input-sm" class="control-label">Keywords</label>
                                        <select name="keywords[]" id="select2-multiple-input-sm1" class="form-control input-sm select2-multiple" data-placeholder="Select Keywords"  multiple>
                                            <?php
                                            if(old('keywords'))
                                            {
                                                $key_array = old('keywords');
                                            }
                                            else{
                                                $key_array = array();
                                            }
                                            ?>
                                            @foreach($keywords as $keyword)
                                                <option  @if(in_array($keyword->id,$key_array)) selected="selected" @endif value="{{$keyword->id}}">{{$keyword->keyword_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                               <!--  <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label"></label>
                                        <a data-toggle="modal" href="#add_product_btn" class="btn btn-success add_button">Add</a>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <!--/row-->
                    <div class="row">
                        <!--/span-->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">SSN</label>
                                <input value="{{old('ssn')}}" name="ssn" type="text" id="mask_ssn" placeholder="SSN"
                                       class="form-control">
                                <p class="text-danger">{{$errors->first('ssn')}}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Order No <span class="error_label">*</span></label>
                                <input min="1" value="{{old('order_no')}}" name="order_no" type="number"
                                       placeholder="Order No"
                                       class="form-control required">
                                <p class="text-danger">{{$errors->first('order_no')}}</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Phone No <span class="error_label">*</span></label>
                                <input value="{{old('phone')}}" name="phone" type="text"
                                       placeholder="Phone No" class="form-control required"></div>
                            <p class="text-danger">{{$errors->first('phone')}}</p>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Website</label>
                                <input value="{{old('website')}}" name="website" type="url" placeholder="Website"
                                       id="website"
                                       class="form-control">
                            </div>
                        </div>

                        <!--/span-->
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Facebook Link</label>
                                <input value="{{old('social_1')}}" name="social_1" type="url" id="social_1"
                                       placeholder="Facebook Link" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Twitter Link</label>
                                <input value="{{old('social_2')}}" name="social_2" type="url" id="social_2"
                                       placeholder="Twitter link" class="form-control">
                            </div>
                        </div>



                        <!--/span-->
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Tripadvisor Link</label>
                                <input value="{{old('social_3')}}" name="social_3"  type="url"
                                       placeholder="Tripadvisor Link" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Instagram</label>
                                <input value="{{old('social_4')}}" name="social_4"  type="url"
                                       placeholder="Instagram" class="form-control">
                            </div>
                        </div>

                        <!--/span-->

                    </div>

                      <div class="row">
                    <div class="col-md-6">
                        <div class="form-group m-form__group row">
                            <label class="control-label">Description <span class="error_label">*</span></label>
                        
                        </div>
                            <textarea name="description"  class="summernote"  >{{old('description')}}
                            </textarea>
                            <p class="text-danger">{{$errors->first('description')}}</p>
                     </div>
                
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <div class="checkbox-list">
                                <label class="control-label">Featured</label><br>
                                <input @if(old('is_featured')) checked @endif type="checkbox" id="inlineCheckbox1" name="is_featured" value="1">Is featured
                            </div>
                        </div>
                        <div class="form-group ">
                        <label class="control-label"> Choose Images <span class="error_label">*</span></label>
                        <br>
                        <input type="file" class="" name="file[]" id="photo"  onchange="readFile(this);" multiple>
                        </div>
                        <div id="status"></div>
                         <div id="photos" class="row" style="width: 100%"></div>
                    </div>

                </div>
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6 pull-right">
                            <div class="form-actions pull-right">
                        <button type="submit" class="btn btn-accent">Save & Next <i class="fa fa-arrow-right"></i></button>
                        <a href="{{url('admin/restaurants')}}" class="btn default"> Cancel </a>
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

   <script src="{{ asset('assets/pages/places/create.js') }}"></script>

   
     <script src="{{ asset('assets/demo/default/custom/components/forms/widgets/summernote.js') }}"></script>

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
    <!-- multiple images -->

<script>
    function readFile(input) {
    $("#status").html('Processing...');
    counter = input.files.length;
        for(x = 0; x<counter; x++){
            if (input.files && input.files[x]) {

                var reader = new FileReader();

                reader.onload = function (e) {
            $("#photos").append('<div class="imagePlace'+x+'" style="width: 135px;"><input style="margin-left: 60px;" type="radio" name="main_image"><img src="'+e.target.result+'" class="img-thumbnail" style="width: 238px;height: 140px;border: none;"><a href="javascript:void(0);" class="col-md-4 col-sm-3 col-xs-3 imageRemove" contact-id="'+x+'" style="color:red;padding-right: 0px;" >Remove </a> </div>');
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
         $('.imagePlace'+id).hide();
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