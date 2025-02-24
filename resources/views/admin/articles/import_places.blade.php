@extends('layouts.master')
@section('title', 'Import')
@section('header_space')
<style type="text/css">
    #place_form_sample_3{
        width: 70%;
        margin: 0 auto;
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
               <form method="post" class="m-form m-form--state m-form--fit m-form--label-align-right" enctype="multipart/form-data" action="{{ url('admin/places/excel') }}" id="place_form_sample_3"
              class="m-form m-form--state m-form--fit m-form--label-align-right ">
              <div class="m-portlet__body">
            {{--{{ method_field('POST')}}--}}
            {{ csrf_field() }}
             <input type="hidden" value="4" name="category_id" id="category_id">
             
            <div class="form-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <button class="close" data-close="alert"></button>
                        <span> You have <?php echo count($errors->all()) ?> errors. Please check below.</span>
                    </div>
                @endif
                
                <div class="row ">
                    <div class="col-md-6">
                        <div class="form-group m-form__group ">
                            <label class="control-label">Choose Excel File</label><br>
                        <input value="" name="file" type="file" id="file" class=" required" placeholder="Place Name">
                       
                        </div>
                    </div>
                </div>
                    
              

        </div>
        <div class="row" style="padding: 15px">
            <div class="col-md-6"></div>
            
                <div class="col-md-6 right">
                    <div class="form-actions pull-right">
                <button style="margin-right: 10px" type="submit" class="btn btn-accent btn_save">
                    <i class="fa fa-check"></i> Import
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

  
    
@stop