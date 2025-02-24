@extends('layouts.master')
@section('title', 'Edit Restaurant')
@section('header_space')
    <link href="{{ asset('public/admin/css/select2.css') }}" rel="stylesheet" type="text/css"/>

    <style type="text/css">
        .form-group.m-form__group.row {
            padding-bottom: 10px;
        }

        .shop_image {
            float: left;
            margin: 15px;
        }

        .error_label {
            color: red;
        }
    </style>
@endsection
@section('title_right_section')
    <a href="{{ 'admin::restaurants.create'}}"
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
                                    All restaurants
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
                <form method="post" style="padding: 15px" enctype="multipart/form-data"
                      action="{{ url('admin/restaurants/'.$edit_place->id) }}"
                      id="form_sample_3">
                    <input name="prev_url" type="hidden" value="<?php echo URL::previous(); ?>">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <div class="form-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <button class="close" data-close="alert"></button>
                                <span> You have some form errors. Please check below.</span>

                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Restaurant Name <span
                                                class="error_label">*</span></label>
                                    <input value="{{$edit_place->restaurant_name}}" name="restaurant_name" type="text"
                                           id="restaurant_name"
                                           class="form-control required" placeholder="restaurant Name">

                                    <p class="text-danger">{{$errors->first('restaurant_name')}}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Slug</label>
                                    <input value="{{$edit_place->slug}}" name="slug" type="text" class="form-control"
                                           placeholder="Restaurant Slug">

                                    <p class="text-danger">{{$errors->first('place_name')}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="select2-multiple-input-sm" class="control-label">Subcategory</label>
                                    <select name="subcategory[]" id="select2-multiple-input-sm"
                                            class="form-control input-sm select2-multiple"
                                            data-placeholder="Select Subcategory" multiple>
                                        <?php
                                        $array = array();
                                        foreach ($edit_place->subCategories as $data) {
                                            $array[] = $data->id;
                                        }
                                        ?>
                                        @if(sizeof($subcategory))
                                            @foreach($subcategory as $subcatAll)
                                                <option
                                                    <?php if (in_array($subcatAll->id, $array)) { ?> selected="selected"
                                                    <?php } ?> value="{{$subcatAll->id}}">{{$subcatAll->cat_name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="select2-multiple-input-sm"
                                                   class="control-label">Keywords</label>
                                            <select name="keywords[]" id="select2-multiple-input-sm1"
                                                    class="form-control input-sm select2-multiple"
                                                    data-placeholder="Select Keywords" multiple>
                                                <?php
                                                $key_array = array();
                                                foreach ($edit_place->keywords as $keyObj) {
                                                    $key_array[] = $keyObj->id;
                                                }
                                                ?>
                                                @foreach($keywords as $keywordAll)
                                                    <option
                                                        <?php if (in_array($keywordAll->id, $key_array)) { ?> selected="selected"
                                                        <?php } ?>
                                                        value="{{$keywordAll->id}}">{{$keywordAll->keyword_name}}</option>
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

                            <!--/span-->
                        </div>
                        <div class="row">
                            <!--/span-->
                            <div class="col-md-3">

                                <div class="form-group">
                                    <label class="control-label">SSN </label>
                                    <input value="{{$edit_place->ssn}}" name="ssn" type="text" id="mask_ssn"
                                           placeholder="SSN"
                                           class="form-control"></div>
                                <p class="text-danger">{{$errors->first('ssn')}}</p>

                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Order
                                        No {{--<span class="error_label">*</span>--}}</label>
                                    <input min="1" value="{{$edit_place->order_no}}" name="order_no" type="number"
                                           placeholder="Order No" class="form-control "></div>
                                {{--  <p class="text-danger">{{$errors->first('order_no')}}</p>--}}
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Phone No <span class="error_label">*</span></label>
                                    <input value="{{$edit_place->phone}}" name="phone" type="text"
                                           placeholder="Phone No" class="form-control"></div>
                                <p class="text-danger">{{$errors->first('phone')}}</p>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Website</label>
                                    <input value="{{$edit_place->website}}" name="website" type="url"
                                           placeholder="Website"
                                           id="website" class="form-control">

                                    <p class="text-danger">{{$errors->first('first_name')}}</p>
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
                                    <label class="control-label">Instagram </label>
                                    <input value="{{$edit_place->social_3}}" name="social_3" id="social_3" type="url"
                                           placeholder="Instagram"
                                           class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Tripadvisor Link</label>
                                    <input value="{{$edit_place->social_4}}" name="social_4" id="social_4" type="url"
                                           placeholder="Tripadvisor Link"
                                           class="form-control">
                                </div>
                            </div>


                            <!--/span-->
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Description<span class="error_label">*</span></label>
                                    {{-- <input value=""  name="description" type="text" class="form-control"></div>--}}
                                    <textarea name="description" class="summernote">
                                {{$edit_place->description}}
                            </textarea>
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
                                    <label class="control-label"> Choose Images <span
                                                class="error_label">*</span></label>

                                    <p id="image_error" class="text-danger">{{$errors->first('file')}}</p>
                                    <input type="file" name="file[]" onchange="readFile(this);"
                                           class="multi with-preview" multiple accept="gif|jpg|png"
                                           id="image">
                                </div>

                                <div id="images_list" class="control-group">
                                    <div id="imgShow" style=""></div>
                                    @foreach($edit_place->photo as $photoobj)
                                        <div class="shop_image " id="image_{{$photoobj->photo_id}}">
                                            <div class="radio_btn">
                                                <input type="radio" name="main_image" class="MultiFile-title"
                                                       <?php echo ($photoobj->main == 1) ? 'checked' : ''; ?> value="{{$photoobj->photo_id}}">
                                            </div>
                                            <img alt="Restaurant image" style="width:125px;height:125px;"
                                                 src="{{url('public/uploads/'.$photoobj->photo)}}"/>

                                            <div>
                                            </div>
                                            <a href="javascript:void(0);" class=" MultiFile-remove image_remove"
                                               id="{{$photoobj->photo_id}}">
                                                Remove
                                            </a>

                                        </div>
                                    @endforeach
                                    <div id="status"></div>
                                    <div id="photos" class="row" style="width: 100%;margin-left: 12px;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-6 ">
                                <div class="form-actions pull-right">
                                <!-- <a id="update" content="{{ url('admin/restaurants/') }}" href="javascript:void(0)"  class="btn btn-accent">
                        <i class="fa fa-check"></i> Update
                    </a> -->
                                    <button type="submit" class="btn btn-accent">Update</button>
                                    <a content="{{url('admin/restaurants/address/'.$edit_place->id)}}"
                                       href="{{url('admin/restaurants/address/'.$edit_place->id)}}"
                                       class="btn btn-accent">
                                        <i class="fa fa-check"></i> Edit Address
                                    </a>
                                <!-- <a content="{{url('admin/restaurants/menu/'.$edit_place->id)}}" href="javascript:void(0)"  class="btn btn-accent">
                        <i class="fa fa-check"></i> Edit Menu
                    </a> -->
                                    <a href="{{url('admin/restaurants')}}" class="btn btn-default"> Cancel </a>
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
    <script type="text/javascript">
        $(document).ready(
            function () {
                $(".select2-multiple").select2();
            }
        );
    </script>
    <script src="{{ asset('assets/pages/places/jquery.geocomplete.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAPUTGhVxI4piPZBg8wXT587e9EzDOar5w&sensor=false&amp;libraries=places"></script>

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
            for (x = 0; x < counter; x++) {
                if (input.files && input.files[x]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $("#photos").append('<div class="imagePlace' + x + '" style="width: 135px;"><input style="margin-left: 60px;" type="radio" name="main_image"><img src="' + e.target.result + '" class="img-thumbnail" style="width: 238px;height: 140px;border: none;"><a href="javascript:void(0);" class="col-md-4 col-sm-3 col-xs-3 imageRemove" contact-id="' + x + '" style="color:red;padding-right: 0px;" >Remove </a> </div>');
                    };

                    reader.readAsDataURL(input.files[x]);
                }
            }
            if (counter == x) {
                $("#status").html('');
            }
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function (e) {
            $(document).on('click', '.imageRemove', function () {
                var id = $(this).attr('contact-id');
                $('.imagePlace' + id).hide();
            });
        });
    </script>

    <script>
        $(document).ready(function (e) {
            $(document).on('click', '.image_remove', function () {

                var id = $(this).attr('id');
                // alert(id);
                $.ajax({
                    type: "GET",
                    url: admin_url + "/admin/restaurants/remove_image/" + id,
                    // data: {'id': id},
                    success: function (data) {
                        //  alert(data);
                        $('#image_' + id).hide();
                    }
                });
            });
        });
    </script>
@stop