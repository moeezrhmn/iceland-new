@extends('layouts.app')

<link rel="stylesheet" type="text/css" href="{{url('assets/admin/js/autocomplete/jquery-ui.css')}}">

<link rel="stylesheet" type="text/css" href="{{url('assets/web/css/bootstrap-select.min.css')}}">

<link rel="stylesheet" type="text/css" href="{{url('assets/web/css/daterangepicker.css')}}">

<link rel="stylesheet" type="text/css" href="{{url('assets/web/css/animate.css')}}">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

{{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">--}}

{{--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>--}}

{{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>--}}

<style>

    /*.search_results .media-body h4 {font-size: 16px;}*/

    .mapsMinMakerDiv{right: 10px;position: relative;top: -8px;}

    #mapCanvasMainDiv.fixed {position: fixed;top: 0; /*padding: 0;*/}

    footer{position: relative;}

    /*search header panel*/

    .search_wrapper .tab-content {margin-top: 10px;}

    .main_slider.bg_slider.bgSliderCustom {height: 370px;}

    .search_wrapper.searchWrapper {bottom: 12%;padding: 20px 20px 4px 20px;}

    .form-group {margin-bottom: 0.2rem !important;}

    .search_wrapper .tab-content {margin-top: 12px !important;}

    .view_all {margin: 0px auto 0px !important;}

    #unfavorite {

        display: none;

    }

    .recordNo{

        width: 60%;

        margin: 0 auto;

        border: 1px solid gainsboro;

        padding: 1.5em;

        color: grey;

    }

    .recordNo>h1{

        text-align: center;

    }

    .main_con{

        overflow-x: hidden;

    }

    .main_slider{

        height: 370px !important;

    }



</style>

@section('content')

    {{--<div class="main_wrapper">--}}



    @include('layouts/partial_header')



    <div class="main_content main_con">

        <div class="container">

            <div class="filter">

                <form class="d-flex justify-content-center align-items-center">

                    <!--  <div class="form-group col select_option">

                        <select class="selectpicker">

                            <option>option 1</option>

                            <option>option 2</option>

                            <option>option 3</option>

                        </select>

                    </div>

                    <div class="form-group col select_option">

                        <select class="selectpicker">

                            <option>option 1</option>

                            <option>option 2</option>

                            <option>option 3</option>

                        </select>

                    </div>

                    <div class="form-group col select_option">

                        <select class="selectpicker">

                            <option>option 1</option>

                            <option>option 2</option>

                            <option>option 3</option>

                        </select>

                    </div>

                    <div class="form-group col">

                        <button type="submit" class="btn view_all hvr-float-shadow">Search</button>

                    </div>-->

                </form>

            </div>

        </div>



        <div class="container-fluid">

            <div class="search_results">

                <div class="clearfix">

                    {{--col maps float-right--}}

                    <div class="col maps col maps map-section float-right d-none d-sm-block" style="margin-top: 40px;">

                        <div class="col-md-9 map-right resturant_map hidden-sm" id="mapCanvasMainDiv">

                            <div style="height: 653px;width: 400px;" id="mapCanvas"></div>

                        </div>

                    </div>
                    
                    <style>
                        @media screen and (max-width: 1000px) {
                            .map-section{display:none !important}   
                        }</style>

                    @if(!empty($places) && count($places)>0)



                        <?php

                        $i=0;

                        ?>

                        <div class="col custom_results float-left">

                            <div class="d-flex search_sorting">



                                <div class="col">

                                    <?php

                                    /*echo '<pre>';

                                    print_r($places->total());

                                    exit;

                                     */?>



                                    1-{{count($places)}} of {{$places->total()}}

                                </div>

                                <div class="sort_dropdown mr-auto">

                                    <ul>

                                        <li class="nav-item dropdown">

                                            <select class="form-control sort_by select2" style="font-size: 13px;position: relative;top: -7px;" id="sort">

                                                <option value="0">Sort By</option>

                                                <option

                                                        title="Sort By Recent" @if (isset($_GET['sort']) && $_GET['sort'] == "recent") selected="selected" @endif

                                                value="recent">Sort By Recent

                                                </option>

                                                <option

                                                        title="Sort By Name" @if (isset($_GET['sort']) && $_GET['sort'] == "name") selected="selected" @endif

                                                value="name">Sort By Name

                                                </option>

                                                <option

                                                        title="Sort By Rating" @if (isset($_GET['sort']) && $_GET['sort'] == "rating") selected="selected" @endif

                                                value="rating">Sort By Rating

                                                </option>



                                            </select>

                                        </li>

                                    </ul>

                                </div>

                            </div>

                            <br>

                            @foreach($places as $obj)

                                      @php
                                            if(Request::segment(1)=='restaurants' || Request::segment(1)=='restaurants'){

                                                $path= url('/restaurants/detail/'.$obj->slug);

                                                $place_name = $obj->restaurant_name;



                                           } elseif(Request::segment(1)=='places'){



                                                   $path= url('/places/detail/'.$obj->slug);

                                                    $place_name = $obj->place_name;

                                           } else{

                                                     $path= url('/activities/detail/'.$obj->slug);

                                                      $place_name = $obj->activity_name;

                                                  }

                                            @endphp



                                <div class="card text-left">

                                    <div class="card-body">

                                        <div class="media">

                                            <div class="custom_checkbox">



                                                <!-- favorite start -->

                                                <div id="unfav-{{@$obj->id}}" data-action="{{@$obj->id}}" class="unfavorite"

                                                     content="{{@$obj->category_id}}" style="display: none">

                                                    <a class="btn_full_outline unfav"

                                                       href="javascript:void(0)">

                                                        <i class=" icon-heart"></i>  <label for="heart" style="color: red">❤</label></a>

                                                </div>

                                                <div id="fav-{{@$obj->id}}" data-action="{{@$obj->id}}"

                                                     content="{{@$obj->category_id}}" class="favorite" style="display: none">

                                                    <a class="btn_full_outline fav"

                                                       href="javascript:void(0)">

                                                        <i class=" icon-heart"></i>  <label for="heart" style="color:black " >❤</label></a>

                                                </div>



                                                @if(isset($obj->favoruite) && !empty($obj->favoruite))

                                                    <div id="unfavorite-{{@$obj->id}}" class="">

                                                        <a class="btn_full_outline unfavorite" content="{{@$obj->category_id}}"

                                                           data-action="{{@$obj->id}}" href="javascript:void(0)">

                                                            <i class=" icon-heart"></i>  <label for="heart" style="color: red">❤</label></a>

                                                    </div>

                                                @else

                                                    <div id="favorite-{{@$obj->id}}" class="">

                                                        <a class="btn_full_outline favorite" content="{{@$obj->category_id}}"

                                                           data-action="{{@$obj->id}}" href="javascript:void(0)">

                                                            <i class=" icon-heart"></i> <label for="heart" style="color:black ">❤</label></a>



                                                    </div>

                                                @endif

                                            </div>



                                        <a href="{{$path}}" class="hvr-float-shadow ">



                                                @if(!empty($obj->single_photo->photo))



                                                    @if($obj->category_id==3)

                                                        <img src="{{url('uploads/activities'.@$obj->single_photo->photo)}}" alt="{{@$obj->place_name}}"

                                                             style="">

                                                    @else

                                                        <img src="{{url('uploads/'.@$obj->single_photo->photo)}}" alt="{{@$obj->place_name}}"

                                                             style="">

                                                    @endif

                                                @else

                                                    <img src="{{url('/images/win17.jpg')}}" class="card-img" alt="image"

                                                         style=""  >

                                                @endif

                                            </a>

                                            <div class="media-body" style="padding: 10px;">

                                                <div class="d-none d-sm-block">

                                                    <div class="rateit float-right"></div>

                                                </div>

                                                <h5>{{@$place_name}}</h5>

                                                <p>

                                                    <style>

                                                        .ops{

                                                            position: relative;

                                                            top: 4px;

                                                            right: 8px;

                                                            /*margin-bottom: 30px;*/

                                                        }

                                                    </style>

                                                    <img src="{{url('images/map-pink.png')}}" >

                                                    <span class="ops"><a href="#">{{@$obj->address->address.', '.@$obj->address->city}}</a></span>

                                                </p>

                                                <ul>

                                                    <li>

                                                        <a href="#" data-toggle="modal" data-target=".place_description" class="pull-left"></a>

                                                        <div class="d-none d-sm-block">{{str_limit(strip_tags(html_entity_decode(trim($obj->description) )),300, '...')}}</div>

                                                    </li>

                                                </ul>

                                                {{--<br><br><br>--}}

                                                <div style="background: #f0f0f0;position: absolute;bottom: 0;padding: 11px;margin-left: -10px;width: 100%;" class="ok">



                                                    <style>



                                                        @media screen and (max-width: 441px) {

                                                            .ok {

                                                                background-color: #fff !important;

                                                                /*position: absolute;*/

                                                                position: absolute;

                                                                padding: 10px;

                                                                margin-left: -15px;

                                                                width: 100%;

                                                                bottom: 30px !important;

                                                                top: 405px;



                                                            }

                                                            .media-body{

                                                                height: 150px;

                                                            }

                                                            .ops>a{

                                                                position: relative;

                                                                top: 20px;

                                                                right: 30px;

                                                            }

                                                        }



                                                        @media screen and (max-width: 1024px){

                                                            .ops{

                                                                position: relative;

                                                                /*top: -15px;*/

                                                                /*right: -32px;*/

                                                                left: 0px;

                                                                top: 0px;





                                                            }

                                                        }

                                                        .ops>a{

                                                            position:relative;

                                                            top: 0px;

                                                            right: 0px;

                                                            /*top: -5px;*/

                                                            /*right: -5px;*/

                                                        }

                                                        @media screen and (max-width: 441px) {

                                                            .ok {

                                                                background-color: #fff !important;

                                                                position: absolute;

                                                                padding: 11px;

                                                                margin-left: -15px;

                                                                width: 100%;

                                                                bottom: 25px !important;

                                                            }

                                                            .media-body{

                                                                height: 150px;

                                                            }

                                                            .ops>a{

                                                                position: relative;

                                                                top: 5px;

                                                                right: 5px;

                                                            }

                                                        }



                                                        /*@media screen and(max-width: 1240px) {*/

                                                            /*.ops>a{*/

                                                                /*position: relative;*/

                                                                /*!*top: -20px;*!*/

                                                                /*!*right: -25px;*!*/

                                                                /*margin: 30px;*/

                                                                /*top: -20px;*/

                                                            /*}*/

                                                        }

                                                        @media screen and(max-width: 768px){

                                                            .ops>a{

                                                                position: relative;

                                                                left: 25px;

                                                                top: -16px;

                                                            }

                                                        }



                                                    </style>

                                                    <div class="float-right d-none d-sm-block" style="margin-right: 370px;margin-top:15px;">



                                                        @if(Request::segment(1)=='restaurants' || Request::segment(1)=='restaurants')

                                                            <a href="{{$path}}" class="hvr-float-shadow view_all">Detail</a>

                                                        @elseif(Request::segment(1)=='places')

                                                            <a href="{{$path}}" class="hvr-float-shadow view_all">Detail</a>

                                                        @else

                                                            <a href="{{$path}}" class="hvr-float-shadow view_all">Book Now</a>

                                                        @endif

                                                    </div>

                                                   @if(Request::segment(1)=='activities')



                                                        @if(!empty($obj->price))

                                                            <h5 style="margin-bottom: 10px;">${{ number_format(round($obj->price)) }}</h5>

                                                        @endif

                                                    @endif





                                                    {{--@if(Request::segment(1)=='restaurants' || Request::segment(1)=='restaurants')--}}

                                                    {{--@elseif(Request::segment(1)=='places')--}}

                                                    {{--@else--}}

                                                        {{--@if(!empty($obj->price))--}}

                                                            {{--<h5 style="margin-bottom: 10px;">£{{$obj->price}}</h5>--}}

                                                        {{--@endif--}}

                                                    {{--@endif--}}

                                                    <div class="d-none d-sm-block">

                                                    <a href="#" data-toggle="modal" data-target=".place_description">

                                                    <span>

                                                    @if(!empty($obj->website_url))

                                                    <a href="{{@$obj->website_url}}"><i class="fa fa-globe"></i></a>

                                                    @endif

                                                    <a href="{{@$obj->social_1}}"><i class="fa fa-facebook"></i></a>

                                                    <a href="{{@$obj->social_2}}"><i class="fa fa-twitter"></i></a>

                                                    <a href="{{@$obj->social_3}}"><i class="fa fa-instagram"></i></a>

                                                    <a href="{{@$obj->social_4}}"><i class="fa fa-tripadvisor"></i></a>

                                                    {{--<a href="{{@$obj->social_4}}"><i class="fa fa-twitter"></i></a>--}}

                                                    {{--<a href="{{@$obj->social_4}}"><i class="fa fa-instagram"></i></a>--}}

                                                    {{--<a href="{{@$obj->social_4}}"><i class="fa fa-facebook"></i></a>--}}

                                                        @if(!empty($obj->phone))

                                                            <i class="fa fa-phone"></i>:{{$obj->phone}}

                                                        @endif

                                                    </span>

                                                    </a>

                                                    </div>



                                                </div>

                                            </div>

                                        </div>

                                    </div>



                                </div>



                                    @endforeach

                                    <div class="col-12 mt-4 float-left paginateDivMain">

                                        <nav aria-label="page navigation example">



                                            {{--{{ $places->links() }}--}}

                                            <?php

                                            // echo '<pre>';

                                            // print_r(Request::segment(1));

                                            // exit;



                                            ?>

                                            @if(Request::segment(1)=='activities')

                                            {{$places->appends(['activtiy_term' => @$_GET['activtiy_term'],'city_id' => @$_GET['city_id']

                                                ,'activity_type' => @$_GET['activity_type'],'cuisine' => @$_GET['cuisine']])->render()}}

                                            @elseif(Request::segment(1)=='restaurants')

                                            {{$places->appends(['term' => @$_GET['term'],'rest_city_id' => @$_GET['rest_city_id']

                                                ,'type' => @$_GET['type'],'cuisine' => @$_GET['cuisine']])->render()}}

                                            @elseif(Request::segment(1)=='places')

                                            {{$places->appends(['city_id' => @$_GET['city_id'],'search_type' => @$_GET['search_type']

                                                ,'city' => @$_GET['city'],'subcategory' => @$_GET['subcategory']])->render()}}

                                            @endif



                                        </nav>

                                    </div>

                                </div>

                                @else

                                <div class="recordNo">



<h5>No record found</h5>

</div>

                                @endif







                        </div>

                        </div>

                </div>

                </div>

            </div>

        {{--</div>--}}


        {{--</div>--}}

        <input type="hidden" value="{{Auth::id()}}" id="auth_user_login" name="">

        {!! Html::script('assets/web/js/bootstrap.min.js') !!}

        {!! Html::script('assets/web/js/moment.js') !!}

        {!! Html::script('assets/web/js/favorite.js') !!}
        
        @include('maps_pages.search_maps')
        
        <?php //include(base_path('assets/web/pages/searchMpas.php'));?>

        {!! Html::script('assets/web/js/jquery.rateyo.min.js') !!}

    <!-- auto complete start -->

        {!! Html::script('assets/admin/js/autocomplete/jquery-ui.js') !!}

        {!! Html::script('assets/web/js/searchAutoComplete.js') !!}







        {!! Html::script('assets/web/js/bootstrap-datetimepicker.min.js') !!}

        {!! Html::script('assets/web/js/daterangepicker.js') !!}

        {!! Html::script('assets/web/js/jquery.datetimepicker.full.min.js') !!}





        <script>

            $(document).ready(function () {

                $('.daterange').daterangepicker({

                    timePicker: true,

                    /*startDate: moment().startOf('hour'),

                    endDate: moment().startOf('hour').add(32, 'hour'),*/

                    locale: {

                        format: 'DD/MM/YY hh:mm A'

                    }

                });



// bootstrap select

            });

        </script>

        <script type="text/javascript">

            var num = 750; //number of pixels before modifying styles



            $(window).bind('scroll', function () {

                if ($(window).scrollTop() > num) {

                    $('#mapCanvasMainDiv').addClass('fixed');

                } else {

                    $('#mapCanvasMainDiv').removeClass('fixed');

                }

            });

            $('#autocomplete').autocomplete({

                source: 'getSearch',

                appendTo: "#options"

            });

        </script>

        <script type="text/javascript">





            $("#act_name").autocomplete({

                source: web_url + "/search/SearchActAutoName",

                appendTo:'#activityoptions',

                select: function (event, ui) {

                    var e = ui.item;

                    $('#act_city_id').val(e.id);

                    $('input[name=activity_type]').val(e.type);

                },

                change: function (event, ui) {

                    var noRecord = 'No records found';

                    if (ui.item == null || ui.item == undefined || $('#act_name').val() === 'No records found') {

                        $("#act_name").val("");

                        $("#act_name").attr("disabled", false);

                    }

                }



            });





            $("#plc_name").autocomplete({

                source: web_url + "/search/SearchPlcAutoName",

                appendTo:'#placeoptions',

                select: function (event, ui) {

                    var e = ui.item;

                    $('#place_city_id').val(e.id);

                    $('input[name=search_type]').val(e.type);

                },

                change: function (event, ui) {

                    var noRecord = 'No records found';

                    if (ui.item == null || ui.item == undefined || $('#plc_name').val() === 'No records found') {

                        $("#plc_name").val("");

                        $("#plc_name").attr("disabled", false);

                    }

                }







            });

            $("#rest_name_search").autocomplete({

                source: web_url + "/search/searchAutoRestName",

                appendTo:'#restaurantoSearchOptions',

                select: function (event, ui) {

                    var e = ui.item;

                    $('input[name=city_id]').val(e.id);

                    $('input[name=type]').val(e.type);

                },

                change: function (event, ui) {

                    var noRecord = 'No records found';

                    if (ui.item == null || ui.item == undefined || $('#rest_name_search').val() === 'No records found') {

                        $("#rest_name_search").val("");

                        $("#rest_name_search").attr("disabled", false);

                    }

                }

            });

            $("#restName").autocomplete({

            source: web_url + "/search/searchAutoRestName",

            appendTo: '#restaurantoptions',

            select: function (event, ui) {

                var e = ui.item;

                $('input[name=rest_city_id]').val(e.id);

                $('input[name=type]').val(e.type);

            },

            change: function (event, ui) {

                var noRecord = 'No records found';

                if (ui.item == null || ui.item == undefined || $('#restName').val() === 'No records found') {

                    $("#restName").val("");

                    $("#restName").attr("disabled", false);

                }

            }

        });



        </script>

        <script>

            // function initialize()

            // {

            //     var myLatLng = new google.maps.LatLng(28.617161,77.208111);

            //     var map = new google.maps.Map(document.getElementById("map"),

            //         {

            //             zoom: 17,

            //             center: myLatLng,

            //             mapTypeId: google.maps.MapTypeId.ROADMAP

            //         });

            //     var marker = new google.maps.Marker(

            //         {

            //             position: myLatLng,

            //             map: map,

            //             title: 'Rajya Sabha'

            //         });

            // }

            $(document).ready(function () {

                // initialize();

                $(document).on("click", ".map_modal_show", function () {



                    var hotelName = ($(this).attr('hotelName'));

                    var lat = ($(this).attr('lat'));

                    var long = ($(this).attr('long'));

                    //alert(lat);

                    // alert(long);

                    // alert(hotelName);





                });

            });



        </script>

        <!-- auto complete end -->





@endsection





