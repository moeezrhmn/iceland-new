@extends('layouts.master')
@section('title', 'TripXonic |Add Activity ')

@section('styles')
        <!-- BEGIN PAGE LEVEL PLUGINS -->
{!! Html::style('assets/admin/plugins/bootstrap-summernote/dist/summernote.css') !!}
{!! Html::style('assets/admin/plugins/bootstrap-fileinput/bootstrap-fileinput.css') !!}
<style>


</style>
<!-- END PAGE LEVEL PLUGINS -->
@endsection
@section('content')
        <!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> Activity
    <small>Create a new activity and add them to this site.</small>
</h3>
<!-- END PAGE TITLE-->
<!-- BEGIN PAGE BAR -->
<div class="page-bar">

    <ul class="page-breadcrumb">
        <li>
            <a href="{{ url('admin/activities') }}">Activities</a>
            <i class="fa fa-angle-right"></i>
        </li>
        <li>
            <span>Add Activity</span>
        </li>
    </ul>
    <div class="page-toolbar">

        <div class="btn-group pull-right">
            <a class="btn grey-cascade" href="{{ url('admin/activities') }}">
                <i class="fa fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
</div>
<!-- End PAGE BAR -->
<div class="portlet light bordered">
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form method="post" enctype="multipart/form-data" action="{{ url('admin/activities') }}" id="form_sample_3"
              class="horizontal-form dropzone">
            {{--{{ method_field('POST')}}--}}
            {{ csrf_field() }}
            <input type="hidden" name="category_id" id="category_id" value="2"/>

            <div class="form-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button>
                        <span> You have <?php echo count($errors->all()) ?> errors. Please check below.</span>
                    </div>
                @endif
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    You have some form errors. Please check below.
                </div>
                <div class="alert alert-success display-hide">
                    <button class="close" data-close="alert"></button>
                    Your form validation is successful!
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Activity Name <span class="error_label">*</span></label>
                            <input value="{{old('place_name')}}" name="place_name" type="text" id="place_name"
                                   class="form-control required"
                                   placeholder="Activity Name">

                            <p class="text-danger">{{$errors->first('place_name')}}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Slug</label>
                            <input value="{{old('slug')}}" name="slug" type="text" class="form-control"
                                   placeholder="Activity Slug">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Order No <span class="error_label">*</span></label>
                            <input value="{{old('order_no')}}" name="order_no" type="number" placeholder="Order No"
                                   class="form-control required">

                            <p class="text-danger">{{$errors->first('order_no')}}</p>
                        </div>
                    </div>
                    <!--                    <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label">Category <span class="error_label">*</span></label>
                                                <select class="form-control required" name="category_id" id="category_id">
                                                    <option value="">Select</option>
                                                    @foreach($categories as $catObj)
                            <option @if(old('category_id') == $catObj->id) selected="selected" @endif value="{{$catObj->id}}">{{$catObj->cat_name}}</option>
                                                    @endforeach
                            </select>
                            <p class="text-danger">{{$errors->first('category_id')}}</p>
                                            </div>
                                        </div>-->

                </div>

                <!--/row-->
                <div class="row">
                    <div class="col-md-6">
                        <label for="select2-multiple-input-sm" class="control-label">Subcategory</label>
                        <select name="subcategory[]" id="select2-multiple-input-sm"
                                class="form-control input-sm select2-multiple" multiple>
                            @foreach($categories as $catObj)
                                <option @if(old('category_id') == $catObj->id) selected="selected" @endif value="{{$catObj->id}}">{{$catObj->cat_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="select2-multiple-input-sm" class="control-label">Keywords</label>
                        <select name="keywords[]" id="select2-multiple-input-sm1"
                                class="form-control input-sm select2-multiple" multiple>
                            @foreach($keywords as $keyObj)
                                <option @if(old('category_id') == $keyObj->id) selected="selected" @endif value="{{$keyObj->id}}">{{$keyObj->keyword_name}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Address <span class="error_label">*</span> (Search Your desired
                                address )</label>

                            <div class="input-group">
                                <input id="geocomplete" value="Reykjavík, Iceland" name="search_address"
                                       class="form-control required input_address" type="text">
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
                                <div class="form-group">
                                    <label class="control-label">Latitude</label>
                                    <input value="{{old('lat')}}" name="lat" type="text"
                                           placeholder="Latitude" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Longitude</label>
                                    <input value="{{old('lng')}}" name="lng" type="text"
                                           placeholder="Longitude" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Address</label>
                                    <input value="" name="formatted_address" type="text"
                                           placeholder="Address" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Country</label>
                                    <input value="{{old('country')}}" name="country" type="text"
                                           placeholder="Country" class="form-control">
                                    <input value="{{old('country_short')}}" name="country_short" type="hidden"
                                           placeholder="Country" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">State</label>
                                    <input value="{{old('administrative_area_level_1')}}"
                                           name="administrative_area_level_1" type="text"
                                           placeholder="State" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">City<span class="error_label">*</span></label>
                                    <input value="{{old('locality')}}" name="locality" type="text"
                                           placeholder="City" class="form-control required">
                                </div>
                            </div>
                            <div class="row">
                                <!--/span-->
                                <!--                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="control-label">SSN</label>
                                                            <input value="{{old('ssn')}}"  name="ssn" type="text" id="mask_ssn" placeholder="SSN" class="form-control">
                                                            <p class="text-danger">{{$errors->first('ssn')}}</p>
                                                        </div>
                                                    </div>-->


                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
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
                        <div class="form-group">
                            <label class="control-label">Map</label>

                            <div class="map_canvas" style="height: 313px; width:100%"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Phone No <span class="error_label">*</span></label>
                            <input value="{{old('phone')}}" name="phone" type="text" placeholder="Phone No"
                                   class="form-control required">

                            <p class="text-danger">{{$errors->first('phone')}}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Website</label>
                            <input value="{{old('website')}}" name="website" type="url" placeholder="Website"
                                   id="website"
                                   class="form-control">
                        </div>
                    </div>
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
                            <label class="control-label">Twitter link</label>
                            <input value="{{old('social_2')}}" name="social_2" type="url" id="social_2"
                                   placeholder="Twitter link" class="form-control">
                        </div>
                    </div>
                    <!--/span-->
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Linkedin Link</label>
                            <input value="{{old('social_3')}}" name="social_3" id="social_3" type="url"
                                   placeholder="Linkdin Link" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Instagram</label>
                            <input value="{{old('social_4')}}" name="social_4" id="social_4" type="url"
                                   placeholder="Instagram" class="form-control">
                        </div>
                    </div>
                    <!--/span-->
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Description {{--<span class="error_label">*</span>--}}</label>
                            {{-- <input value=""  name="description" type="text" class="form-control"></div>--}}
                            <textarea name="description" class="summernote_1 ">{{old('description')}}
                            </textarea>

                            <p class="text-danger">{{$errors->first('description')}}</p>
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <div class="checkbox-list">
                                <label class="control-label">Featured</label>
                                <input @if(old('is_featured')) checked @endif type="checkbox" id="inlineCheckbox1"
                                       name="is_featured" value="1">Is featured
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label"> Choose Images <span class="error_label">*</span></label>

                            <p id="image_error" class="text-danger">{{$errors->first('file')}}</p>
                            <input type="file" name="file[]" class="multi with-preview required" multiple
                                   accept="gif|jpg|png|" id="image"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions right">
                <button type="submit" class="btn green btn_save">
                    <i class="fa fa-check"></i> Save
                </button>
                <a href="{{url('admin/activities')}}" class="btn default"> Cancel </a>
            </div>
        </form>
        <!-- END FORM-->
    </div>

</div>
@endsection
@section('script')

        <!-- BEGIN PAGE LEVEL PLUGINS -->
{!! Html::script('assets/admin/plugins/bootstrap-summernote/dist/summernote.js') !!}
{!! Html::script('assets/admin/js/form-input-mask.min.js') !!}
{!! Html::script('assets/admin/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') !!}
{!! Html::script('assets/admin/plugins/jquery.input-ip-address-control-1.0.min.js') !!}
{!! Html::script('assets/admin/js/jquery.multiFile.js') !!}

        <!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL script -->
{!! Html::script('assets/admin/js/components-editors.min.js') !!}
{!! Html::script('assets/admin/js/pages/places.js') !!}
        <!-- End PAGE LEVEL script -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAPUTGhVxI4piPZBg8wXT587e9EzDOar5w&sensor=false&amp;libraries=places">
</script>
{!! Html::script('assets/admin/js/jquery.geocomplete.js') !!}

<script>
    $(function () {
//     var cat_id  =  $('#category_id').val();
//       
//            var $exampleMulti = $("#select2-multiple-input-sm").select2();
//            var $exampleMulti1 = $("#select2-multiple-input-sm1").select2();
//            var token = $("input[name='_token']").val();
//            //var cat_id = $(this).val();
//            $exampleMulti.val(null).trigger("change");
//            $exampleMulti1.val(null).trigger("change");
//
//            if (cat_id > 0) {
//                // alert(cat_id);
//               
//                $.ajax
//                        ({
//                            type: "POST",
//                            url: admin_url + "/admin/places/get_subcategories",
//                            data: {'id': cat_id, '_token': token},
//                            success: function (data) {
//                                $("#select2-multiple-input-sm").html(data);
//                            }
//                        });
//                $.ajax
//                        ({
//                            type: "POST",
//                            url: admin_url + "/admin/places/get_keywords",
//                            data: {'id': cat_id, '_token': token},
//                            success: function (data) {
//                                $("#select2-multiple-input-sm1").html(data);
//                            }
//                        });
//            }
        /////////////////////////

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

@endsection