@extends('layouts.master')
@section('title', 'Add Article')
@section('header_space')
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
               <form method="post" class="m-form m-form--state m-form--fit m-form--label-align-right" enctype="multipart/form-data" action="{{ url('admin/articles') }}" id="place_form_sample_3"
              class="m-form m-form--state m-form--fit m-form--label-align-right ">
              <div class="m-portlet__body">
            {{--{{ method_field('POST')}}--}}
            {{ csrf_field() }}
           
             
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
                            <label class="control-label">Name <span class="error_label">*</span></label>
                            <input value="{{old('title')}}" name="title" type="text" id="place_name" class="form-control required"
                                   placeholder="Name">
                            <p class="text-danger">{{$errors->first('title')}}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group m-form__group row">
                            <label class="control-label">Publish By <span class="error_label">*</span></label>
                            <input value="{{old('publish_by')}}" name="publish_by" type="text" id="place_name" class="form-control required"
                                   placeholder="Publish By">
                            <p class="text-danger">{{$errors->first('publish_by')}}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group m-form__group row">
                            <label class="control-label">Slug  <span class="error_label">*</span></label>
                            <input value="{{old('slug')}}" name="slug" type="text" id="place_name" class="form-control required"
                                   placeholder="Slug">
                            <p class="text-danger">{{$errors->first('publishby')}}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group m-form__group row">
                            <label class="control-label">Keywords </label>
                           {{-- <input value="{{old('keyword')}}" name="keyword" type="text" id="place_name" class="form-control required"
                                   placeholder="Keywords">--}}
                            <select name="keyword[]" id="select2-multiple-input-sm1" class="form-control input-sm select2-multiple"
                                    data-placeholder="Select Keywords" multiple>
                                @foreach($keywords as $keyObj)
                                    <option @if(old('category_id') == $keyObj->id) selected="selected" @endif value="{{$keyObj->id}}">{{$keyObj->keyword_name}}</option>
                                @endforeach
                            </select>
                            <p class="text-danger">{{$errors->first('keyword')}}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group m-form__group row">
                            <label class="control-label">Order No <span class="error_label">*</span></label>
                            <input value="{{old('order_no')}}" name="order_no" type="text" id="place_name" class="form-control required"
                                   placeholder="Order No">
                            <p class="text-danger">{{$errors->first('order_no')}}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group m-form__group row">
                            <label class="control-label">Publish On <span class="error_label">*</span></label>
                            <input value="{{old('publish_on')}}" name="publish_on" type="text" id="place_name" class="form-control required"
                                   placeholder="Publish On">
                            <p class="text-danger">{{$errors->first('publish_on')}}</p>
                        </div>
                    </div>
               <div class="col-md-6">
                        <div class="form-group m-form__group row">
                            <label class="control-label">Short Description</label>
                            <textarea name="short_des" class="form-control"></textarea>
                        </div>
                    </div>
               
                    </div>
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
                <a href="{{url('admin/articles')}}" class="btn btn-secondary"> Cancel </a>
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

   <script src="{{ asset('assets/pages/articals/create.js') }}"></script>
   <script type="{{ asset('admin_outer/js/select2.js') }}"></script>
   <script type="text/javascript">
       $(document).ready(
           function () {
               $(".select2-multiple").select2();
           }
       );
   </script>
     <script src="{{ asset('assets/demo/default/custom/components/forms/widgets/summernote.js') }}"></script>
 

<script>
    function readFile(input) {
    $("#status").html('Processing...');
    counter = input.files.length;
        for(x = 0; x<counter; x++){
            if (input.files && input.files[x]) {

                var reader = new FileReader();

                reader.onload = function (e) {
            $("#photos").append('<div class="col-md-3 col-sm-3 col-xs-3 imagePlace" id="image_"+x> <input type="radio" name="main_image" style="margin-left: 35px;"> <img src="'+e.target.result+'" class="img-thumbnail"><a href="javascript:void(0);" class="image_remove" >Remove </a></div>');
                };

                reader.readAsDataURL(input.files[x]);
            }
    }
    if(counter == x){$("#status").html('');}
  }
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
   
</script>
@stop