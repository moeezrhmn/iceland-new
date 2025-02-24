@extends('layouts.master')
@section('title', $isNew ? 'Create Category' : 'Edit Category')
@section('header_space')
<style type="text/css">
    #cayegory-form{
        width: 50%;
        margin: 0 auto;
    }
    .m-form .m-form__group {
        padding-top: 0px !important;
padding-bottom: 0px !important;
    }

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
.img-preview {
   
}
</style>

@endsection
@section('title_right_section')
    <a href="{{ 'admin::users.create'}}"
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
                            <a href="{{route('categories.index')}}" class="m-nav__link">
                                <span class="m-nav__link-text">
                                    All Categoroes
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
                @if(isset($item->id) && !empty($item->id))
                    {!! Form::model($item, ['url'=> ['admin\categories',$item->id],'method'=>'PUT','class' => 'm-form m-form--state m-form--fit m-form--label-align-right','id'=>'cayegory-form','files' => true]) !!}
                @else
                    {!! Form::model($item, ['action' => 'Admin\CategoriesController@store','class' => 'm-form m-form--state m-form--fit m-form--label-align-right','id'=>'cayegory-form','files' => true]) !!}
                @endif
                {!! Form::hidden('id') !!}

                <div class="m-portlet__body">
                    {{--error alert bar--}}
                    <div class="m-form__content">
                        @include('errors.flash')
                        <div class="m-alert m-alert--icon alert alert-danger m--hide" role="alert"
                             id="m_form_msg">
                            <div class="m-alert__icon">
                                <i class="la la-warning"></i>
                            </div>
                            <div class="m-alert__text">
                                Oh snap! Change a few things up and try submitting again.
                            </div>
                            <div class="m-alert__close">
                                <button type="button" class="close" data-close="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                    
                    {{--place name--}}
                    <div class="form-group m-form__group row">
                        
                        <div class="col-sm-12">
                            <label class="">
                            Category Name<span style="color: red"> *</span>
                        </label>
                            <div class="input-group m-input-group m-input-group--square">
                                {{ Form::text('cat_name', NULL, array('class' => 'form-control m-input' ,'placeholder' => 'Category Name')) }}
                            </div>
                            <span class="m-form__help">
                                
                                </span>
                        </div>
                    </div>
                    {{--email--}}
                    <div class="form-group m-form__group row">
                       
                        <div class="col-sm-12">
                             <label class="">
                            Slug 
                        </label>
                            <div class="input-group m-input-group m-input-group--square">
                               
                                {{ Form::text('slug', NULL, array('class' => 'form-control m-input','placeholder' => 'Enter Slug')) }}

                            </div>
                            {{--{{ Form::text('slug', NULL, array('class' => 'form-control m-input','placeholder' => 'Enter Slug')) }}--}}
                            <span class="m-form__help">
                                   
                                </span>
                        </div>
                    </div>

                     <div class="form-group m-form__group row">
                        
                        <div class="col-sm-12">
                            <label class="">
                            Code <span style="color: red"> *</span> (Capital Latter)
                        </label>
                            <div class="input-group m-input-group m-input-group--square">
                               
                                {{ Form::text('code', NULL, array('class' => 'form-control m-input','placeholder' => 'Enter Code')) }}

                            </div>
                            {{--{{ Form::text('code', NULL, array('class' => 'form-control m-input','placeholder' => 'Enter code')) }}--}}
                            <span class="m-form__help">
                                    
                                </span>
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        
                        <div class="col-sm-12">
                            <label class="">
                            Popularity 
                        </label>
                            <div class="input-group m-input-group m-input-group--square">
                               
                                {{ Form::text('order_no', NULL, array('class' => 'form-control m-input','placeholder' => 'Enter Popularity')) }}

                            </div>
                            {{--{{ Form::text('slug', NULL, array('class' => 'form-control m-input','placeholder' => 'Enter Slug')) }}--}}
                            <span class="m-form__help">
                                 
                                </span>
                        </div>
                    </div>
                     <div class="form-group m-form__group row">
                          <div class="form-group" style="width: 55%;padding-left: 15px;">
              <div class="main-img-preview"  style="">
                @if(isset($item->cat_image) && !empty($item->cat_image))
                 <img class="thumbnail img-preview" src="{{url('public/uploads/'.$item->cat_image)}}" title="Preview Logo" style="width: 100%">
                @else
                 <img class="thumbnail img-preview" src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" title="Preview Logo" style="width: 100%">
                @endif
               
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

                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions m-form__actions">
                        <div class="row">
                            <div class="col-lg-9 ">
                                  @if(isset($item->id) && !empty($item->id))
                                <button type="submit" class="btn btn-accent">
                                    Update
                                </button>
                                @else
 <button type="submit" class="btn btn-accent">
                                    Create
                                </button>
                                @endif
                                <a href="{{route('categories.index')}}" class="btn btn-secondary">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
            <!--end::Form-->
            </div>
            <!--end::Portlet-->
        </div>
    </div>

@stop

@section('footer_space')

        <script src="{{ asset('assets/pages/category/create.js') }}"></script>
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