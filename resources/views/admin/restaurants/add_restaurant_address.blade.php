@extends('layouts.master')
@section('title', ' Address')
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
                                    All Restaurant
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
            <form method="post" enctype="multipart/form-data"
          action="{{ url('admin/restaurants/address_store/'.$restaurant_id) }}"
          id="form_sample_3"
          class="horizontal-form" style="padding: 15PX">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label">Address  <span class="error_label">*</span></label>
                <div class="input-group">
                    <input id="geocomplete" value="" name="search_address" class="form-control" type="text">
                    <span id="find" class="input-group-addon"><i class="fa fa-search"></i></span>
                </div>
                <span class="help-block">You can type desired address here to get Latitude &amp; Longitude from Google Maps.</span>
                <p class="text-danger">{{$errors->first('search_address')}}</p>
            </div>
        </div>

        <div class="col-md-6">
                <input value="" name="address_id" type="hidden"
                       class="form-control">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-6" >
                        <div class="form-group">
                            <label class="control-label">Latitude</label>
                            <input value="" name="lat" type="text"
                                   placeholder="Latitude" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Address</label>
                            <input value="" name="formatted_address" type="text"
                                   placeholder="Address" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="control-label">State</label>
                            <input value="" name="administrative_area_level_1" type="text"
                                   placeholder="State" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Region</label>

                            <select class="form-control" name="region" id="" >
                                <option value="0">Select</option>
                                @if(isset($is_city) && !empty($is_city))
                                    @foreach($is_city as $obj)
                                <option class="region" value="{{$obj->name}}">{{$obj->name}}</option>
                                    @endforeach
                                    @endif
                            </select>
                            {{--<input value="" name="region" type="text"
                                   placeholder="Region" class="form-control">--}}
                        </div>
                        <div class="form-group">
                            <label class="control-label">Zip Code</label>
                            <input value="" name="postal_code" type="text"
                                   placeholder="Zip Code" class="form-control">
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">longitude</label>
                            <input value="" name="lng" type="text"
                                   placeholder="longitude" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Country</label>
                            <input value="" name="country" type="text"
                                   placeholder="Country" class="form-control">
                            <input value="" name="country_short" type="hidden"
                                   class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="control-label">City</label>
                            <input value="" name="locality" type="text"
                                   placeholder="City" class="form-control">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <input value="" name="email" type="text"
                                   placeholder="Email" class="form-control">
                        </div>
                    </div>
                </div>
                <a id="reset" href="#" style="display:none;">Reset Marker</a>
                <div class="form-actions pull-left">
                    <button type="submit" class="btn btn-accent">
                        <i class="fa fa-check"></i> Save
                    </button>
                    <a href="{{url('admin/restaurants')}}" class="btn btn-default"> Finish </a>
                </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">Map</label>
                <div class="map_canvas" style="height: 375px; width: 460px;"></div>
            </div>
        </div>
    </div>
 </form>
            <!--end::Form-->
            </div>
            <!--end::Portlet-->
                      @if(sizeof($address_list) && !empty($address_list))
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-comments"></i>All Addresses
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover table-checkable order-column"
                       id="sample_1">
                    <thead style="background: white">
                    <tr>
                        <th> Record#</th>
                        <th> Country</th>
                        <th> City</th>
                        <th> Region</th>
                        <th> State</th>
                        <th> Latitude</th>
                        <th> Longitude</th>
                        <th> Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>

                        @foreach($address_list as $row)
                            <tr class="odd gradeX">

                                <td> {{ $i }}</td>
                                <td> {{ $row->country}}</td>
                                <td>{{ $row->city }}</td>
                                <td>{{ $row->region }}</td>
                                <td class="center"> {{ $row->state }}  </td>
                                <td>{{ $row->latitude}} </td>
                                <td>{{ $row->longitude}} </td>
                                <td>

                                    <a id="address_edit" data-content="{{$row->address_id}}"
                                            class="btn blue">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                   <a data-toggle="modal"
                                            id="{{url('admin/restaurants/address_delete/'.$row->address_id)}}"
                                            href="#draggable"  class="btn red">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    <div class="modal fade draggable-modal" id="draggable" tabindex="-1"  aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                    <h4 class="modal-title">Are you sure you want to delete it?</h4>
                                                </div>
                                                {{--<div class="modal-body"> Modal body goes here </div>--}}
                                                <div class="modal-footer">
                                                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">No</button>
                                                    <form method="get" id="del_modal" action="{{url('admin/restaurants/address_delete/'.$row->address_id)}}">
                                                        <button type="submit" class="btn green">Yes</button>
                                                    </form>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    {{--<form method="get" action="{{url('admin/restaurants/'.$row->address_id.'/edit') }}">--}}
                                    {{--</form>--}}
                                    {{--<span class="label label-sm label-success"> <a href="#">Edit</a>  </span>--}}
                                    {{--<span class="label label-sm label-danger"> <a href="{{url('admin/user/'.$row->id) }}">Delete</a>  </span>--}}
                                </td>
                            </tr>
                            <?php $i++; ?>
                        @endforeach


                    </tbody>
                </table>
                <?php //echo $users->render(); ?>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
@endif


        </div>

    </div>


@stop


@section('footer_space')

  
   <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAPUTGhVxI4piPZBg8wXT587e9EzDOar5w&sensor=false&amp;libraries=places">
</script>
{!! Html::script('assets/admin/js/jquery.geocomplete.js') !!}
<script>
    $(function () {
        $("#geocomplete").geocomplete({
            map: ".map_canvas",
            details: "form ",
            location: [64.12652059999999, -21.817439299999933],
            mapOptions: {
                zoom: 17
            },
            markerOptions: {
                draggable: true
            }
        });
        $("#geocomplete").bind("geocode:dragged", function (event, latLng) {
            $("input[name=lat]").val(latLng.lat());
            $("input[name=lng]").val(latLng.lng());
            $("#reset").show();
        });

        $("#find").click(function () {

            $("#geocomplete").trigger("geocode");
        });
    });
    ///////////////////////////////get single  address for update////////////////////////
    $(document).on('click', "#address_edit", function () {
        var token = $("input[name='_token']").val();
        var id = $(this).attr('data-content');
       // alert(id)
        $("#loader").css("display", "block");
        $("html, body").animate({ scrollTop: 0 }, 600);
        $.ajax
        ({
            //contentType: "application/json; charset=utf-8",
            type: "POST",
            url: '{{ url("/admin/restaurants/edit_address") }}',
            data: {'id': id, '_token': token},
            dataType: 'json',
            success: function (data) {
                 //alert(data.region);
                $("input[name='lat']").val(data.latitude);
                $("input[name='lng']").val(data.longitude);
                $("input[name='formatted_address']").val(data.address);
                $("#geocomplete").val(data.address);
                $("input[name='country']").val(data.country);
                $("input[name='locality']").val(data.city);
                var region= $("input[name='region']").val(data.region);
                $("input[name='administrative_area_level_1']").val(data.state);
                $("input[name='country']").val(data.country);
                $("input[name='email']").val(data.email);
                $("input[name='postal_code']").val(data.zipcode);
                $("input[name='address_id']").val(data.address_id);
                $("#loader").css("display", "none");
                $("#geocomplete").trigger("geocode");
                if(region!==''){
                    //alert(data.region);
                    $("select[name='region']").find("option[value='"+data.region+"']").attr("selected",true);
                }
            }
        });


    });
</script>

@stop