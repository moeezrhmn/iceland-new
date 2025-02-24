@extends('layouts.master')
@section('title',  'Edit Email Template' )
@section('header_space')
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
                            <a href="{{route('email-templates.index')}}" class="m-nav__link">
                                <span class="m-nav__link-text">
                                    All Email Templates
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
        <form method="post" enctype="multipart/form-data" action="{{url('admin/email-templates')}}" id="form_sample_3"  class="m-form m-form--state m-form--fit " style="padding: 15px" novalidate="novalidate">
                
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
                                    <label class="control-label">Type <span class="error_label">*</span></label>
                                    <select class="form-control required" name="template_type" aria-required="true">
                                        <option value="">Select</option>
                                        <option @if(!empty($emailtemplates->template_type) && $emailtemplates->template_type=='reservation-confirm') selected="selected" @endif value="reservation-confirm">Reservation confirmed</option>
                                        <option @if(!empty($emailtemplates->template_type) && $emailtemplates->template_type=='trip-planner') selected="selected" @endif value="trip-planner">Trip planner</option>
                                        <option @if(!empty($emailtemplates->template_type) && $emailtemplates->template_type=='email_confirmation') selected="selected" @endif value="email_confirmation">Confirmation Email Template</option>
                                        <option @if(!empty($emailtemplates->template_type) && $emailtemplates->template_type=='sign_up_welcome') selected="selected" @endif value="sign_up_welcome">Sign Up Welcome Email Template</option>
                                     <span>*</span></select>
                                </div>
                            </div>
                           <!--  <div class="col-md-3">
                                <label class="control-label">Supplier:</label><br>
                                <input type="checkbox"  value="all_supplier" name="send_email[]">  All<br>
                                <input type="checkbox" value="restaurant" name="send_email[]">  Restaurants<br>
                                <input type="checkbox" value="hotel" name="send_email[]">  Hotels<br>

                            </div> -->
                            <div class="col-md-3">
                                <label class="control-label">Site users:</label><br>
                                <input type="checkbox" value="site_users" name="send_email[]">  All<br>

                            </div>
                            <div class="col-md-3">
                                <label class="control-label">Subscribers:</label><br>
                               <input type="checkbox" value="newsletter" name="send_email[]">  All<br>

                            </div>
                        </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Name <span class="error_label">*</span></label>
                                <input value="{{$emailtemplates->template_name}}" name="template_name"  type="text" id="place_name" class="form-control required" placeholder="Template  Name" aria-required="true">
                                <p class="text-danger"></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Subject<span class="error_label">*</span></label>
                                <input value="{{$emailtemplates->template_subject}}" name="template_subject" type="text" class="form-control required" placeholder="Template Subject" aria-required="true">
                                <p class="text-danger"></p>
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="control-label">Description<span class="error_label">*</span></label>
                                
                                <textarea name="description" class="summernote" style="">  
                                {{$emailtemplates->description}}  

                                                        </textarea>
                                <p class="text-danger"></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="portlet-body">
                                <label class="control-label">Shot Code</label>
                                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">

                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th> Short Code</th>
                                        <th> Value</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="odd gradeX">
                                        <td> 1</td>
                                        <td>[name]</td>
                                        <td> test</td>

                                    </tr>
                                    <tr class="odd gradeX">
                                        <td> 2</td>
                                        <td>[email]</td>
                                        <td> test@gmail.com</td>
                                    </tr>

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                        <div class="form-actions pull-right">
                    <button type="submit" class="btn btn-accent">
                        <i class="fa fa-check"></i> Save
                    </button>
                    <a href="{{url('admin/email-templates')}}" class="btn btn-default"> Cancel </a>
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