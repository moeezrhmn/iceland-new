@extends('layouts.master')
    @section('title', 'TripXonic |Edit place ')
    @section('styles')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
{!! Html::style('assets/admin/plugins/bootstrap-fileinput/bootstrap-fileinput.css') !!}
{!! Html::style('assets/admin/plugins/bootstrap-summernote/dist/summernote.css') !!}
<!-- END PAGE LEVEL PLUGINS -->
<style>
    .shop_image {float: left;margin: 5px;}
</style>
@endsection
@section('content')
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> Activity
    <small>Edit a activity and update them to this site.</small>
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
            <span>Edit Activity</span>
        </li>
    </ul>
    <div class="page-toolbar">
        <div class="btn-group pull-right">
            <a href="{{ url('admin/activities') }}">
                <button class="btn grey-cascade" type="button"><i class="fa fa-arrow-left"></i> Back</button>
            </a>
        </div>
    </div>
</div>
<!-- End PAGE BAR -->

<div class="portlet light bordered">
    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <form method="post" enctype="multipart/form-data" action=" {{ url('admin/activities/'.$activity->id) }}"
              id="" class="horizontal-form dropzone">
            <input name="prev_url" type="hidden" value="<?php echo URL::previous(); ?>">
            {{ method_field('PUT') }}
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
                            <input value="{{$activity->place_name}}" name="place_name" type="text" id="place_name"
                                   class="form-control required" placeholder="Activity Name">
                            <p class="text-danger">{{$errors->first('place_name')}}</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Slug</label>
                            <input value="{{$activity->slug}}" name="slug" type="text" class="form-control"
                                   placeholder="Activity Slug">
                        </div>
                    </div>
                        <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Order No {{--<span class="error_label">*</span>--}}</label>
                            <input value="{{$activity->order_no}}" name="order_no" type="number"
                                   placeholder="Order No" class="form-control "></div>
                      {{--  <p class="text-danger">{{$errors->first('order_no')}}</p>--}}
                    </div>
                </div>
            
 <div class="row">
                    <input value="{{$activity->track_id}}" name="track_id" type="hidden" id="mask_track_id"
                           placeholder="Track Id" lass="form-control">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="select2-multiple-input-sm" class="control-label">Subcategory</label>
                        <select name="subcategory[]" id="select2-multiple-input-sm"
                                class="form-control input-sm select2-multiple" multiple>
                            <?php
                            $array=array();
                            foreach ($activity->subCategories_edit as $data)
                            {
                                $array[] = $data->id;
                            }
                            ?>
                            @foreach($subcategory as $subcatAll)
                                <option  <?php if (in_array($subcatAll->id, $array)) { ?> selected="selected" <?php } ?>                                               value="{{$subcatAll->id}}">{{$subcatAll->cat_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <?php
echo '<pre>';
print_r($keywords);
exit;

                        ?>
                        <label for="select2-multiple-input-sm" class="control-label">Keywords</label>
                        <select name="keywords[]" id="select2-multiple-input-sm1"
                                class="form-control input-sm select2-multiple" multiple>
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
                        </select>
                    </div>
                </div>
                <div class="row">
                <!--<div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">SSN </label>
                            <input value="{{$activity->ssn}}" name="ssn" type="text" id="mask_ssn"
                                   placeholder="SSN"
                                   class="form-control"></div>
                        <p class="text-danger">{{$errors->first('ssn')}}</p>
                    </div>-->
                    <!--/span-->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Phone No </label>
                            <input value="{{$activity->phone}}" name="phone" type="text"
                                   placeholder="Phone No" class="form-control"></div>
                        <p class="text-danger">{{$errors->first('phone')}}</p>
                    </div>
                    <!--/span-->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Website</label>
                            <input value="{{$activity->website}}" name="website" type="url" placeholder="Website"
                                   class="form-control">
                            <p class="text-danger">{{$errors->first('website')}}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Address <span class="error_label">*</span> (Search Your desired address )</label>
                            <div class="input-group">
                                <input id="geocomplete" value="{{old('search_address')}}{{ @$activity->address[0]->address }}" name=""
                                       class="form-control" type="text">
                                <span id="find" class="input-group-addon"><i class="fa fa-search"></i></span>
                            </div>
                            <p class="text-danger">{{$errors->first('search_address')}}</p>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Latitude</label>
                                    <input value="{{ @$activity->address[0]->latitude }}" name="lat" type="text"
                                           placeholder="Latitude" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Longitude</label>
                                    <input value="{{ @$activity->address[0]->longitude }}" name="lng" type="text"
                                           placeholder="Facebook Link" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Address</label>
                                    <input value="{{ @$activity->address[0]->address }}" name="formatted_address" type="text"
                                           placeholder="Address" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Country</label>
                                    <input value="{{ @$activity->address[0]->country }}" name="country" type="text"
                                           placeholder="Country" class="form-control">
                                    <input value="" name="country_short" type="hidden"
                                           placeholder="Country" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">State</label>
                                    <input value="{{ @$activity->address[0]->state }}" name="administrative_area_level_1"
                                           type="text"
                                           placeholder="State" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">City<span class="error_label">*</span></label>
                                    <input value="{{ @$activity->address[0]->city }}" name="locality" type="text"
                                           placeholder="City" class="form-control required">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Zip Code</label>
                                    <input value="{{ @$activity->address[0]->zipcode }}" name="postal_code" type="text"
                                           placeholder="Zip Code" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Email</label>
                                    <input value="{{ @$activity->address[0]->email }}" name="email" type="text"
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

                            <div class="map_canvas" style="height: 313px; width:97%"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Facebook Link</label>
                            <input value="{{$activity->social_1}}" name="social_1" type="url" id="social_1"
                                   placeholder="Facebook Link" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Twitter link</label>
                            <input value="{{$activity->social_2}}" name="social_2" type="url" id="social_2"
                                   placeholder="Twitter link"
                                   class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Linkdin Link</label>
                            <input value="{{$activity->social_3}}" name="social_3" id="social_3" type="url"
                                   placeholder="Linkdin Link"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Instagram</label>
                            <input value="{{$activity->social_4}}" name="social_4" id="social_4" type="url"
                                   placeholder="Instagram"
                                   class="form-control">
                        </div>
                    </div>
                    <!--/span-->
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Description {{--<span class="error_label">*</span>--}}</label>
                            {{-- <input value=""  name="description" type="text" class="form-control"></div>--}}
                            <textarea name="description"  class="summernote_1">
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
                            <input type="file" name="file[]"   class="multi with-preview" multiple accept="gif|jpg|png|jpeg" id="image"/>
                        </div>

                        <div id="images_list" class="control-group">
                            <div id="imgShow" style=""></div>

                            @php print_r($activity->photo); @endphp
                            @if(sizeof($activity->photo))
                                @foreach($activity->photo as $photoobj)

                                    <div class="shop_image " id="image_{{$photoobj->photo_id}}">
                                        <div class="radio_btn">
                                            <input type="radio" name="main_image" class="MultiFile-title"
                                                   <?php echo ($photoobj->main == 1) ? 'checked' : ''; ?> value="{{$photoobj->photo_id}}">
                                        </div>
                                        <img alt="hotel image" style="width:125px;height:125px;"
                                             src="{{url('uploads/'.$photoobj->photo)}}"/>
                                        <div>
                                        </div>
                                        <a href="javascript:void(0);" class=" MultiFile-remove image_remove"
                                           id="{{$photoobj->photo_id}}">
                                            Remove
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-actions right">
                    <button type="submit" class="btn green">
                        <i class="fa fa-check"></i> Update
                    </button>
                    <a href="{{url('admin/activities')}}" class="btn default"> Cancel </a>
                </div>
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
        $("#geocomplete").geocomplete({
            map: ".map_canvas",
            location: [<?=@$activity->address[0]->latitude?>,<?=@$activity->address[0]->longitude?>],
            details: "form ",
            markerOptions: {
                draggable: true
            },
            mapOptions: {
                zoom: 16,
                scrollwheel: true,
                mapTypeId: "roadmap"
            },
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
</script>
<script>
    $(document).ready(function (e) {
        $('.image_remove').click(function () {
            var id = $(this).attr('id');
            // alert('.image_'.concat(id));
            $.ajax({
                type: "GET",
                url: admin_url + "/admin/activities/remove_image",
                data: {'id': id},
                success: function (data) {
                    /*alert(data);*/
                    $('#image_'.concat(data)).hide();
                }
            });
        });
    });
</script>
@endsection