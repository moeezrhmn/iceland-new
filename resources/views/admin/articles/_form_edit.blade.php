@extends('layouts.master')
@section('title', 'Edit Article')
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
   .imgThumbnail{
    max-width: 143px !important;
height: 150px !important;
border: none !important;
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
                            <a href="{{route('articles.index')}}" class="m-nav__link">
                                <span class="m-nav__link-text">
                                    All Articles
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
               <form method="post" enctype="multipart/form-data" class="m-form m-form--state m-form--fit m-form--label-align-right" action=" {{ url('admin/articles/'.$edit_place->id) }}"
              id="form_sample_3" class="m-form m-form--state m-form--fit m-form--label-align-right" style="padding: 20px;">
            <input name="prev_url" type="hidden" value="<?php echo URL::previous(); ?>">
             <!-- <input type="hidden" value="4" name="category_id" id="category_id"> -->
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
                            <label class="control-label">Title <span class="error_label">*</span></label>
                            <input value="{{$edit_place->title}}" name="title" type="text" id="title"
                                   class="form-control required" placeholder="Title">
                            <p class="text-danger">{{$errors->first('title')}}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group m-form__group row">
                            <label class="control-label">Publish By <span class="error_label">*</span></label>
                            <input value="{{$edit_place->publish_by}}" name="publish_by" type="text" id="place_name" class="form-control required"
                                   placeholder="Publish By">
                            <p class="text-danger">{{$errors->first('publish_by')}}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group m-form__group row">
                            <label class="control-label">Slug </label>
                            <input value="{{$edit_place->publish_by}}" name="slug" type="text" id="place_name" class="form-control"
                                   placeholder="Slug">
                            <p class="text-danger">{{$errors->first('publishby')}}</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group m-form__group row">
                            <label class="control-label">Keywords <span class="error_label">*</span></label>
                          {{--  <input value="{{$edit_place->keyword}}" name="keyword" type="text" id="place_name" class="form-control required"
                                   placeholder="Keywords">--}}
                            <select name="keyword[]" id="select2-multiple-input-sm1"
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
                            <p class="text-danger">{{$errors->first('keyword')}}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group m-form__group row">
                            <label class="control-label">Order No <span class="error_label">*</span></label>
                            <input value="{{$edit_place->order_no}}" name="order_no" type="text" id="place_name" class="form-control required"
                                   placeholder="Order No">
                            <p class="text-danger">{{$errors->first('order_no')}}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group m-form__group row">
                            <label class="control-label">Publish On <span class="error_label">*</span></label>
                            <input value="{{$edit_place->publish_on}}" name="publish_on" type="text" id="place_name" class="form-control required"
                                   placeholder="Publish On">
                            <p class="text-danger">{{$errors->first('publish_on')}}</p>
                        </div>
                    </div>
                   <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Short Description</label>
                              <textarea name="short_des" class="form-control"  placeholder="Short Description" >{{$edit_place->short_des}}</textarea>

                        </div>
                    </div>
            
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
                            <label class="control-label"> Choose Images <span class="error_label">*</span></label>
                            <p id="image_error" class="text-danger">{{$errors->first('file')}}</p>
                            <input type="file" name="file[]" type="radio" onchange="readFile(this);"    class="multi with-preview" multiple accept="gif|jpg|png|jpeg" id="image"/>
                        </div>
                        <div id="images_list" class="control-group">
                            <div id="imgShow" style=""></div>
                            @if(!empty($photo))
                                @foreach($photo as $photoobj)
                                <?php

                                ?>
                                    <div class="col-md-3 shop_image imagePlace" id="image_{{@$photoobj->photo_id}}">
                                        <div class="radio_btn">
                                            <input style="margin: 0 auto;
width: 145%;"  type="radio" name="main_image" class="MultiFile-title"
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
                         <div id="photos" class="row" style="width: 100%"></div>
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
     <script type="text/javascript">
         $(document).ready(
             function () {
                 $(".select2-multiple").select2();
             }
         );
     </script>
   
    <script>
    function readFile(input) {
    $("#status").html('Processing...');
    counter = input.files.length;
        for(x = 0; x<counter; x++){
            if (input.files && input.files[x]) {

                var reader = new FileReader();

                reader.onload = function (e) {
 $("#photos").append('<div class="col-md-3 col-sm-3 col-xs-3" id="image-"><input style="margin-left: 35px;" type="radio" name="main_image"><img src="'+e.target.result+'" class="img-thumbnail imgThumbnail"> <a href="javascript:void(0);" class="imageRemove" style="color:red" >Remove </a></div>');
                };

                reader.readAsDataURL(input.files[x]);
            };
            $()
    }
    if(counter == x){$("#status").html('');}
  }
</script>
  <script>
    $(document).ready(function (e) {
        $(document).on('click','.image_remove',function () {
            var id = $(this).attr('id')
            alert(id)
            $.ajax({
                type: "GET",
                url: admin_url + "/admin/articles/remove-image/"+id,
                // data: {'id': id},
                success: function (data) {
                    alert(data);
                    $('#image_'.concat(data)).hide();
                }
            });
        });
    });
</script> 
@stop