@extends('layouts.master')
@section('title',  'Create Deal' )
@section('header_space')
<style type="text/css">
    .fileUpload #logo-id {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 33px;
    cursor: pointer;
    opacity: 0;
    filter: alpha(opacity=0);
}
.note-editable.panel-body{
    height: 230px !important;
}
.error_label{
        color: red;
    }
</style>
@endsection
@section('title_right_section')
    <a href="{{ 'admin::permission.create'}}"
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
                            <a href="{{route('deals.index')}}" class="m-nav__link">
                                <span class="m-nav__link-text">
                                    All Delas
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
               <form method="post" class="m-form m-form--state m-form--fit m-form--label-align-right" style="padding: 20px" enctype="multipart/form-data" action="{{ url('/admin/deals') }}" id="form_sample_3">
            {{ csrf_field() }}
            <div class="form-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button>
                        <span> You have some errors. Please check below. </span>
                    </div>
                @endif
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Category <span class="error_label">*</span> </label>
                            <select class="form-control " name="category_name" id="category">
                                <option value="0">Select Category</option>
                           
                                @foreach($categories as $obj)
                                    <option value="{{$obj->id}}">{{$obj->cat_name}}</option>
                                @endforeach
                         
                            </select>
                            <p class="text-danger">{{$errors->first('cat_name  ')}}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Offered By <span class="error_label">*</span> </label>
                            <select class="form-control   select2 " id="select2-multiple-input-sm1" name="place_id">
                                <option value="{{ old('place_id') }}">Select Place</option>
                              @foreach($places as $row)
                                    <option value="{{$row->id}}">{{$row->place_name}}</option>
                                @endforeach
                            </select>
                            <p class="text-danger">{{$errors->first('place_id')}}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Deal Name <span class="error_label">*</span></label>
                            <input value="{{ old('deal_name') }}" name="deal_name" type="text" id="deal_name" class="form-control required"
                                   placeholder="Deal Name">
                            <p class="text-danger">{{$errors->first('deal_title')}}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                     <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Valid From <span class="error_label">*</span></label>
                            <input name="valid_from" type="text" id="" placeholder="Valid From " class="form-control  date_input date m_datetimepicker_6 " >
                            
                            <p class="text-danger">{{$errors->first('valid_from')}}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Valid To<span class="error_label">*</span></label>
                           <input name="valid_to" type="text" id="" placeholder="Valid To" class="form-control required date_input date m_datetimepicker_6">
                            <p class="text-danger">{{$errors->first('valid_from')}}</p>
                        </div>
                    </div>




                    <!-- <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Valid From <span class="error_label">*</span></label>
                            <div class="col-md-12 input-group input-large date date-picker input_largedate " data-date-format="yyyy-mm-dd"
                                 data-date-start-date="+0d">
                                <input name="valid_from" type="text" id="" class="form-control  date_input date m_datetimepicker_6 " >
                                <span class="input-group-btn">
                                    <button class="btn default date_btn" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                            </div>
                            <p class="text-danger">{{$errors->first('valid_from')}}</p>
                        </div>
                    </div> -->
                  <!--   <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Valid To <span class="error_label">*</span></label>
                            <div class="col-md-12 input-group input-large date date-picker input_largedate" data-date-format="yyyy-mm-dd"
                                 data-date-start-date="+0d">
                                <input name="valid_to" type="text" id="" class="form-control required date_input date m_datetimepicker_6">
                                <span class="input-group-btn">
                                    <button class="btn default date_btn" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                            </div>
                            <p class="text-danger">{{$errors->first('valid_to')}}</p>
                        </div>
                    </div> -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Discount Price <span class="error_label">*</span></label>
                            <input value="{{ old('discount_price') }}" name="discount_price" type="text" id="discount_price" class="form-control required"
                                   placeholder="Discount Price">
                            <p class="text-danger">{{$errors->first('discount_price')}}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 ">
                        <div class="form-group">
                            <label class="control-label">Currency <span class="error_label">*</span></label>
                            <select class="form-control required select2" name="currency" id="currency">
                                <option value="{{ old('currency') }}">Select Currency</option>
                                @foreach($currency as $row)
                                    <option value="{{$row->currency_code}}">{{$row->currency_name}}</option>
                                @endforeach
                            </select>
                            <p class="text-danger">{{$errors->first('discount_price')}}</p>
                        </div>
  <div class="form-group">
           <label class="control-label">Deals image</label>
                          <div class="form-group" style="width: 100%;padding-left: 15px;">
              <div class="main-img-preview"  style="">
               
                 <img class="thumbnail img-preview" src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" title="Preview Logo" style="width: 100%">
               
               
              </div>
              <div class="input-group" style="">
                <input id="fakeUploadLogo" class="form-control fake-shadow" placeholder="Choose File" disabled="disabled">
                <div class="input-group-btn">
                  <div class="fileUpload btn btn-danger fake-shadow">
                    <span><i class="glyphicon glyphicon-upload"></i> Upload Image</span>
                    <input id="logo-id" name="file" type="file" class="attachment_upload">
                  </div>
                </div>
              </div>
             
            </div>
                    
                    </div>
                    
                    </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label class="control-label">Description {{--<span class="error_label">*</span>--}}</label>
                        {{-- <input value=""  name="description" type="text" class="form-control"></div>--}}
                        <textarea name="description" class="summernote ">{{old('description')}}
                            </textarea>
                        <p class="text-danger">{{$errors->first('description')}}</p>
                    </div>
                </div>

            </div>

                 <div class="row">
                <div class="col-md-12">
                    <div class="pull-right">
                        <button type="submit" class="btn btn-accent btn_deals">
                            <i class="fa fa-check"></i> Save
                        </button>
                        <a href="{{ url('admin/deals') }}" class="btn btn-secondary"> Cancel </a>
                    </div>
                </div>
            </div>
            </div>

        </form>
        <!-- END FORM-->
            </div>
            <!--end::Portlet-->
        </div>
    </div>

@stop

@section('footer_space')

   <script src="{{ asset('assets/pages/deals/create.js') }}"></script>
      <script src="{{ asset('assets/demo/default/custom/components/forms/widgets/summernote.js') }}"></script>

         <script src="{{ asset('assets/demo/default/custom/components/forms/widgets/bootstrap-datetimepicker.js') }}"></script>
<script>
        $(document).on('change', "#category", function () {
            var cat_id = $(this).val();
            //alert(cat_id);
         
            $.ajax
            ({
                type: "GET",
                url: admin_url + "/admin/deals/get_places/"+cat_id,
              
                success: function (data) {
                    $("#select2-multiple-input-sm1").html(data);
                  
                }
            });
        });
        //        on change desi

    </script>
     <script type="text/javascript">
            $(document).ready(function() {
    var brand = document.getElementById('logo-id');
    brand.className = 'attachment_upload';
    brand.onchange = function() {
        document.getElementById('fakeUploadLogo').value = this.value.substring(12);
    };

    // Source: http://stackoverflow.com/a/4459419/6396981
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                $('.img-preview').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#logo-id").change(function() {
        readURL(this);
    });
});



        </script>

@stop