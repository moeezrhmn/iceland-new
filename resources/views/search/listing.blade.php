@extends('layouts.app')

@section('title', @$sub_cat_detail->cat_name)

@section('style')

<link rel="stylesheet" type="text/css" href="{{url('assets/admin/js/autocomplete/jquery-ui.css')}}">

{!! Html::style('assets/web/css/jquery.rateyo.min.css') !!}

<style>

    #mapCanvasMainDiv.fixed {position: fixed;top: 0; /*padding: 0;*/}

    footer{position: relative;}

    .main_slider.bg_slider.bgSliderCustom {

        height: 415px;

        /*min-height: 370px;*/

    }

    #unfavorite {

        display: none;

    }

    .search_wrapper.searchWrapper {

        bottom: 20%;

        padding: 20px 20px 4px 20px;

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

    /*@media only screen and(max-width: 1500px){*/

        /*.myclass{*/

            /*!*position: relative;*!*/

            /*width: 80% !important;*/

            /*!*color: red;*!*/

        /*}*/

    /*}*/

</style>

@endsection

@section('content')



    <div class="main_wrapper" style="overflow-x: hidden;">



        <div class="main_slider bg_slider bgSliderCustom">

            <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-ride="carousel">

                <div class="carousel-inner">

                    <div class="carousel-item active">

                        <img class="d-block w-100 h-100" src="{{url('images/search/1.png')}}"

                             alt="First slide">

                    </div>

                    <div class="carousel-item">

                        <img class="d-block w-100 h-100" src="{{url('images/search/2.png')}}"

                             alt="Second slide">

                    </div>

                    <div class="carousel-item">

                        <img class="d-block w-100 h-100" src="{{url('images/search/3.png')}}"

                             alt="Third slide">

                    </div>

                    <div class="carousel-item">

                        <img class="d-block w-100 h-100" src="{{url('images/search/4.png')}}"

                             alt="Second slide">

                    </div>

                    <div class="carousel-item">

                        <img class="d-block w-100 h-100" src="{{url('images/search/5.png')}}"

                             alt="Third slide">

                    </div>

                    {{--<div class="carousel-item">--}}

                    {{--<img class="d-block w-100 h-100" src="{{url('images/lancscape6.jpg')}}"--}}

                    {{--alt="Second slide">--}}

                    {{--</div>--}}

                </div>

                {{-- <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">

                     <span class="sr-only">Previous</span>

                 </a>

                 <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">

                     <span class="sr-only">Next</span>

                 </a>--}}

            </div>



            <div class="search_wrapper searchWrapper">

                {{-- <ul class="nav nav-tabs" id="myTab" role="tablist">



                     <li class="nav-item">

                         <a class="nav-link @if(isset($_GET['activtiy_term'])) active @endif" id="Vacation-tab" data-toggle="tab" href="#Vacation" role="tab" aria-controls="Vacation" aria-selected="false">

                             <i class="fas fa-tree"></i>Activities</a>

                     </li>



                 </ul>--}}

                <div>



                    <div class="main_content main_con">

                        @if(!empty(Request::segment(1)=='restaurants'))

                            <form action="{{url('restaurants/search')}}" method="get" id="form_search_rest">

                                {{csrf_field()}}

                                <div class="row">

                                    <div class="form-group col-md-5" style="margin-bottom:0px">

                                        <div class="form-group" style="margin-bottom: 0px">

                                            <!-- <label>Search Restaurants</label> -->

                                            <input type="text" name="term"

                                                   value="@if(isset($_GET['term']) && $_GET['term']!=""){{trim($_GET['term'])}} @endif"

                                                   class="form-control required input_hotel" id="restName"

                                                   placeholder="City, Restaurant name">



                                            <input name="rest_city_id" type="hidden">

                                            <input name="type" type="hidden">

                                            <span class="icon icon-location" aria-hidden="true"></span>

                                        </div>

                                        <div class="row">

                                            <div class="form-group col-12" id="restaurantoptions">



                                            </div>

                                        </div>

                                    </div>

                                    <div class="form-group  col-md-5" style="margin-bottom: 0px;margin-top: 8px;">

                                        <div class="form-group" style="margin-bottom: 0px">

                                            <!-- <label>Food type</label> -->

                                            <select class="ddslick form-control" name="cuisine" id="style-6">

                                                <option value=""

                                                        selected>All restaurants

                                                </option>

                                                @if(isset($sub_category) && !empty($sub_category) )

                                                    @foreach($sub_category as $sub_cat)

                                                        <option @if(isset($sub_cat_detail->id)

                                             && $sub_cat_detail->id==$sub_cat->id ) selected="selected" @endif

                                                        value="{{$sub_cat->id}}">{{$sub_cat->cat_name}}</option>

                                                    @endforeach

                                                @endif

                                            </select>

                                        </div>

                                    </div>

                                    <div class="form-group col-2">

                                        <button type="submit" class="btn hvr-float-shadow view_all" style="background-color: rgba(0, 0, 0, .5);">Search</button>

                                    </div>

                                </div>

                                <!-- End row -->

                                <span class="" aria-hidden="true">

                                @if(Session::has('restaurant_search_error'))

                                        <p style="color: red;font-size: 14px"> {{ Session::get('restaurant_search_error') }}</p>

                                    @endif

                                </span>

                                {{--<hr>--}}





                            </form>

                        @else

                            <form action="{{url('places/search')}}" method="get" id="form_search_act">

                                <div class="row">

                                    <div class="form-group col-md-5" style="margin-bottom:0px">

                                        <div class="form-group" style="margin-bottom: 0px">

                                            <!-- <label>Search Restaurants</label> -->

                                            <input name="city_id" id="place_city_id" value="0" type="hidden">

                                            <input name="search_type" id="search_type" value="0" type="hidden">

                                            <input type="text" name="city"

                                                   value="@if(isset($_GET['city']) && $_GET['city']!=""){{trim($_GET['city'])}} @endif"

                                                   class="form-control  input_hotel" id="plc_name"

                                                   placeholder="City, Place name">

                                            <span class="icon icon-location" aria-hidden="true"></span>

                                        </div>

                                        <div class="row">

                                            <div class="form-group col-12" id="activityoptions">

                                            </div>

                                        </div>



                                    </div>



                                    <div class="form-group  col-md-5" style="margin-bottom: 0px;margin-top: 8px;">

                                        <div class="form-group" style="margin-bottom: 0px">

                                            <!-- <label>Food type</label> -->

                                            <select class="ddslick form-control" name="cuisine" id="style-6">

                                                <option value=""

                                                        selected>Places

                                                </option>

                                                @if(!empty($subcat_place))

                                                    @foreach($subcat_place as $sub_cat)

                                                        <option value="{{$sub_cat->id}}" @if(isset($sub_cat_detail->id)

                                             && $sub_cat_detail->id==$sub_cat->id ) selected="selected" @endif >{{@$sub_cat->cat_name}}</option>

                                                    @endforeach

                                                @endif

                                            </select>

                                        </div>

                                    </div>

                                    <div class="form-group col-2">

                                        <button type="submit" class="btn hvr-float-shadow view_all">Search</button>

                                    </div>

                                </div>

                                {{-- <div class="row">

                                     <div class="form-group col-12" id="options">



                                     </div>

                                 </div>--}}





                            </form>

                        @endif



                    </div>



                </div>

            </div>

        </div>



        <div class="main_content">

            <div class="container">



                <div class="filter">

                    <!--  <form class="d-flex justify-content-center align-items-center">

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

                          <div class="form-group col select_option">

                              <select class="selectpicker">

                                  <option>option 1</option>

                                  <option>option 2</option>

                                  <option>option 3</option>

                              </select>

                          </div>

                          <div class="form-group col">

                              <button type="submit" class="btn view_all hvr-float-shadow">Search</button>

                          </div>

                      </form>-->



                </div>

            </div>

            <div class="container-fluid">

                <div class="search_results">

                    {{--<div style="height:150px;"></div>--}}

                    {{--<h2 style="margin-top:30px; margin-bottom:40px;"> {{$sub_cat_detail->cat_name}}</h2>--}}



                    <div class="clearfix" >
                    <! ------  New code is added by waseem -------------->
                        <div class="col maps col maps map-section float-right d-none d-sm-block" style="margin-top: 40px;">

                        <div class="col-md-9 map-right resturant_map hidden-sm" id="mapCanvasMainDiv">

                            <div style="height: 653px;width: 400px;" id="mapCanvas"></div>

                        </div>

                        </div>
                <!-------- Below code is commented by Waseem--------- -->    

                        <!-- <div class="col maps float-right d-none d-sm-block" style="overflow-x: hidden;">

                            <div class="col-md-9 map-right resturant_map hidden-sm" id="mapCanvasMainDiv">
                            <!-- <div style="height: 653px;width: 400px;" id="mapCanvas" class="itsmap"></div> -->
                               <!-- <div style="height: 653px;width: 400px;" id="mapCanvas"></div>

                            </div>

                        </div> -->

                        <div class="col custom_results float-left">



                            @if(!empty($places))

                                <div class="d-flex search_sorting">

                                    <div class="col">1-{{count($places)}} of {{count($places)}}</div>

                                    <div class="sort_dropdown mr-auto">

                                        <ul>

                                            <li class="nav-item dropdown">

                                                <select class="form-control sort_by select2" style="font-size: 13px;position: relative;top: -7px; margin-bottom:10px;" id="sort">

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

                                <?php

                                $i=1;

                                ?>

                                <style>

                                    /*@media screen and (max-width: 2762px){*/

                                        /*.card .text-left{*/

                                            /*width: 80% !important;*/

                                        /*}*/

                                    /*}*/

                                </style>

                                @foreach($places as $obj)

                                    <div class="card text-left itscard">

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

                                                    <?php

                                                    /*echo '<pre>';

                                                    print_r($favoruite);

                                                    exit;*/

                                                    ?>

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

                                                <a  @if(!empty(Request::segment(1)=='restaurants')) href="{{url('/restaurants/detail/'.$obj->slug)}}"

                                                        @else href="{{url('/places/detail/'.$obj->slug)}}" @endif class="hvr-float-shadow">

                                                    {{--@if(!empty($obj->single_photo->photo) && file_exists(public_path('uploads/'.@$obj->single_photo->photo)))--}}

                                                        @if(!empty($obj->single_photo->photo))

                                                            @if($obj->category_id==3)

                                                                <img src="{{url('uploads/activities'.@$obj->single_photo->photo)}}" alt="{{@$obj->activity_name}}">

                                                            @else

                                                                <img src="{{url('uploads/'.@$obj->single_photo->photo)}}" alt="{{@$obj->place_name}}">

                                                            @endif

                                                        @else

                                                        <img src="{{url('images/no-image.png')}}" class="img-responsive" alt="No image">

                                                        @endif

                                                </a>

                                                <br>

                                                <div class="media-body" style="padding:10px;">

                                                    <div class="rateit float-right"></div>

                                                    <h5 style="font-size: 20px ;display:inline;">{{@$obj->place_name}}</h5>

                                                    <h5 style="font-size: 20px ;display:inline;">{{@$obj->restaurant_name}}</h5>

                                                    <p>

                                                        <img src="{{url('images/map-pink.png')}}" >

                                                        <span><a href="#">{{@$obj->address->address.', '.@$obj->address->city}}</a></span>

                                                    </p>

                                                    <div class="d-none d-sm-block">

                                                        <p>

                                                            {{str_limit(strip_tags(html_entity_decode(trim($obj->description))),200, '...')}}

                                                        </p>

                                                    </div>

                                                <div class="search_reviews ok" style="position: relative;top: 25px;width: 105%;right: 10px;">

                                                        <style>

                                                            @media screen and (max-width: 440px){

                                                                .ok{

                                                                    background-color: #fff;

                                                                }

                                                                .ok2{

                                                                    position: relative;

                                                                    top: 5px;

                                                                }

                                                            }

                                                            .ok3{

                                                                position: relative;

                                                                top: -30px;

                                                            }

                                                            @media  screen and (min-width: 1500px) {

                                                                .ok{

                                                                    /*width: calc(100% - 1000px);*/

                                                                    position: relative;

                                                                    top: 72px !important;

                                                                    /*padding-left: 0;*/

                                                                }

                                                                .buttonisbutton{

                                                                    margin-right: 70px;

                                                                }

                                                                .maps{

                                                                    height: 100vh;

                                                                    max-width: 780px;

                                                                    padding-right: 0;

                                                                    margin-top: 40px;

                                                                }

                                                                .itsmap{

                                                                    height: 653px;

                                                                    width:745px !important;

                                                                    position: relative;

                                                                    overflow: hidden;

                                                                }

                                                            }

                                                        </style>

                                                        <div class="float-right d-none d-sm-block buttonisbutton">



                                                         @if(Request::segment(1)=='restaurants' || Request::segment(1)=='restaurants')

                                                                <a href="{{url('/restaurants/detail/'.$obj->slug)}}" class="hvr-float-shadow view_all">Detail</a>

                                                                @elseif(Request::segment(1)=='places' || Request::segment(1)=='get-places-by')

                                                                <a href="{{url('/places/detail/'.$obj->slug)}}" class="hvr-float-shadow view_all">Detail</a>

                                                                @else

                                                                <a href="{{url('/activities/detail/'.$obj->slug)}}" class="hvr-float-shadow view_all">Book Now</a>

                                                                @endif

                                                            </div>



                                                                @if(!empty($obj->price) && $obj->category_id==1)

                                                                    <h5>${{  number_format(round($obj->price)) }}</h5>

                                                                @endif

                                                        <br><br>

                                                        <div class="clearfix ok2 " >

                                                            @if(isset($obj->reviews_avg->rating) && !empty($obj->reviews_avg->rating))

                                                                <div class="rating">

                                                                    <div class="rateYo-{{$i}}"></div>

                                                                    <?php

                                                                    if($obj->reviews_avg->rating>5){

                                                                        $star_rating='5';

                                                                    }else{

                                                                        $star_rating=@$obj->reviews_avg->rating;

                                                                    }

                                                                    ?>

                                                                    <script>

                                                                        $(document).ready(function () {

                                                                            showRating(<?=$i?>, <?=@$star_rating?>);

                                                                        });

                                                                    </script>



                                                                    @endif

                                                                    <div class="d-none d-sm-block" style="margin-top: -30px;">

                                                                        <a href="#" data-toggle="modal" data-target=".place_description">



                                                                    @if(!empty($obj->website_url))

                                                                         <a href="{{@$obj->website_url}}"><i class="fa fa-globe"></i></a>

                                                                     @endif

                                                                         <a href="{{@$obj->social_1}}"><i class="fa fa-facebook"></i></a>

                                                                         <a href="{{@$obj->social_2}}"><i class="fa fa-twitter"></i></a>

                                                                         <a href="{{@$obj->social_3}}"><i class="fa fa-instagram"></i></a>

                                                                         <a href="{{@$obj->social_4}}"><i class="fa fa-tripadvisor"></i></a>



                                                                    @if(!empty($obj->phone))

                                                                        <i class="fa fa-phone"></i>:{{$obj->phone}}

                                                                    @endif

                                                                    </a>

                                                                    </div>

                                                                 </div>

                                                        </div>

                                                </div>

                                            </div>

                                            </div>

                                        </div>

                                    <?php $i++ ?>





                                 @endforeach





                                    {{--</div>--}}

                        {{--</div>--}}

                                        @endif



                                        <style>

                                            @media screen and (min-width: 360px){

                                                .paginateor{

                                                    position: relative;

                                                    right: 21% !important;

                                                }

                                            }

                                            @media screen and (min-width: 1280px){

                                                .paginateor{

                                                    position: relative;

                                                    left: 5px;

                                                }

                                            }

                                            @media screen and (min-width: 760px){

                                                .paginateor{

                                                    position: relative;

                                                    left: 10px !important;

                                                }

                                            }



                                        </style>

                                <div class="col-12" style="width: 5000px;">

                                    <nav aria-label="page navigation example" class="paginateor">

                                        {{ $places->links() }}

                                    </nav>

                                </div>

                        </div>

                        @if(empty($places))

                            <div class="recordNo">



                                <h5>No record found</h5>

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>

    <input type="hidden" value="{{Auth::id()}}" id="auth_user_login" name="">

    {!! Html::script('assets/web/js/favorite.js') !!}

    <?php // include(base_path('assets/web/pages/searchMpas.php'));?>

    @include('maps_pages.search_maps')


    <!-- auto complete start -->    
    {!! Html::script('assets/admin/js/autocomplete/jquery-ui.js') !!}



    {!! Html::script('assets/web/js/jquery.rateyo.min.js') !!}

    {!! Html::script('assets/web/js/searchAutoComplete.js') !!}



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



    </script>

    <!-- auto complete end ./////////////////-->

@endsection