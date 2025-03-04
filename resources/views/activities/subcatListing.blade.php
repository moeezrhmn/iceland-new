@extends('layouts.app')

@section('title', @$sub_cat_detail->cat_name ? $sub_cat_detail->cat_name: 'Visit Iceland' )



@section('style')



<link rel="stylesheet" type="text/css" href="{{url('assets/admin/js/autocomplete/jquery-ui.css')}}">

<style>

    #mapCanvasMainDiv.fixed {position: fixed;top: 0; /*padding: 0;*/}

    footer{position: relative;}

    .main_slider.bg_slider.bgSliderCustom {

        height: 0px;

        min-height: 360px;

    }
    /* zeeshan css */
    nav.top_web_sol svg.w-5.h-5 {
        width: 18px;
        margin-top: 20px;
    }

    nav.top_web_sol .flex.justify-between.flex-1.sm\:hidden {
        display: none;
    }
    nav.top_web_sol p.text-sm.text-gray-700.leading-5.dark\:text-gray-400 {
        display: none;
    }
    /* end */

    #unfavorite {

        display: none;

    }

    .search_wrapper.searchWrapper {

        bottom: 20%;

        padding: 20px 20px 4px 20px;

    }



    @media screen and (max-width: 440px){

        .search_wrapper.searchWrapper{

            bottom: 7%;

            padding: 20px 20px 4px 20px;

        }

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

    .b{

        overflow-x: hidden;

    }

</style>

@endsection

@section('content')

    <div class="main_wrapper b">

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



                </div>

                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">

                    <span class="sr-only">Previous</span>

                </a>

                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">

                    <span class="sr-only">Next</span>

                </a>

            </div>



            <div class="search_wrapper searchWrapper">

                {{-- <ul class="nav nav-tabs" id="myTab" role="tablist">



                     <li class="nav-item">

                         <a class="nav-link @if(isset($_GET['activtiy_term'])) active @endif" id="Vacation-tab" data-toggle="tab" href="#Vacation" role="tab" aria-controls="Vacation" aria-selected="false">

                             <i class="fas fa-tree"></i>Activities</a>

                     </li>



                 </ul>--}}

                <div>



                    <div class=" ">

                        <form action="{{url('activities/search')}}" method="get" id="form_search_act">

                            <div class="row">

                                <div class="form-group col-md-5" style="margin-bottom: 0px">

                                    <div class="form-group" style="margin-bottom: 0px">

                                        <!-- <label>Search Restaurants</label> -->

                                        <input type="text" name="activtiy_term"

                                               value="@if(isset($_GET['activtiy_term']) && $_GET['activtiy_term']!=""){{trim($_GET['activtiy_term'])}}  @endif"

                                               class="form-control input_hotel" id="act_name"

                                               placeholder="City, activity name">

                                        <input name="city_id" id="act_city_id" type="hidden">

                                        <input name="activity_type" type="hidden">

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

                                                    selected>Excursions

                                            </option>

                                            @if(!empty($subcat_place))

                                                @foreach($subcat_place as $sub_cat)

                                                    <option value="{{$sub_cat->id}}" @if(isset($sub_cat_detail->id)

                                             && $sub_cat_detail->id==$sub_cat->id || isset($sub_catid)

                                             && $sub_catid==$sub_cat->id ) selected="selected" @endif >{{@$sub_cat->cat_name}}</option>

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

                    </div>



                </div>

            </div>

        </div>

        <div class="main_content">

            <div class="container">

                <div class="filter">

                    <!-- <form class="d-flex justify-content-center align-items-center">

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

                    </form> -->

                </div>

            </div>

            <div class="container-fluid">

                <div class="search_results">

                    <div class="clearfix">
                <! ------  New code is added by waseem -------------->
                <div class="col maps col maps map-section float-right d-none d-sm-block" style="margin-top: 40px;">

                <div class="col-md-9 map-right resturant_map hidden-sm" id="mapCanvasMainDiv">

                    <div style="height: 653px;width: 400px;" id="mapCanvas"></div>

                </div>

                </div>
                <!-------- Below code is commented by Waseem--------- -->

                        <!-- <div class="col maps float-right d-none d-sm-block d-md-block">

                            {{--<div class="col-md-9 map-right resturant_map hidden-sm">

                                <div style="height: 653px;width: 400px;" id="mapCanvas"></div>

                            </div>--}}

                            <div class="col-md-9 map-right resturant_map hidden-sm" id="mapCanvasMainDiv">

                                <div style="height: 653px;width: 400px;" id="mapCanvas" class="itsmymap"></div>

                            </div>

                        </div> -->

                        <style>

                            @media screen and (min-width: 1500px){

                                .itsmymap{

                                    height: 653px;

                                    width: 746px !important;

                                    position: relative;

                                    overflow: hidden;

                                    right: 367px;

                                }

                                .custom_results{

                                    width: 67% !important;

                                }

                                .buttonisbutton{

                                    margin-right: 50px; !important;

                                }

                            }

                            @media screen and(max-width: 1745px){

                                .itsmymap{

                                    height: 653px;

                                    width: 553px !important;

                                    position: relative;

                                    overflow: hidden;

                                    margin-left: 70%;

                                }

                            }

                        </style>

                      

                        <div class="col custom_results float-left">



                            @if(!empty($places) && sizeof($places)>0 )

                                <div class="d-flex search_sorting">

                                    <div class="col">

                                        1-{{count($places)}} of {{$places->total()}}

                                    </div>

                                    {{--<label for=""> Sort By:</label>--}}

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

                                <?php

                                $i=0;

                                ?>

                                @foreach($places as $obj)

                                    <style>

                                        @media screen and(max-width: 1366px) {

                                            .media2 {

                                                position: relative;

                                                height: 42.5%;

                                            }

                                        }







                                        @media screen and(min-width: 768px){

                                            .buttonisbutton{

                                                margin-right: 15pxm !important;

                                            }

                                        }

                                        /*@media screen and(min-width: 736px){*/

                                            /*.custom_checkbox{*/

                                                /*margin-left: 330px !important;*/

                                                /*float: right;*/

                                            /*}*/

                                        /*}*/



                                   </style>

                                    <div class="card text-left">

                                        <div class="card-body">

                                            <div class="media media2" style="margin-bottom:-23px;">

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

                                                    {{--<input id="heart" class="heart" type="checkbox" />

                                                    <label for="heart">❤</label>--}}

                                                </div>



                                                {{--    <a href="{{url('/activities/detail/'.$obj->slug)}}"

                                                       class="hvr-float-shadow view_all">

                                                        --}}{{--@if(!empty($obj->single_photo->photo) && file_exists(public_path('uploads/'.@$obj->single_photo->photo)))--}}{{--

                                                        @if(!empty($obj->single_photo->photo))

                                                            @if($obj->category_id==3)

                                                                <img src="{{url('uploads/activities'.@$obj->single_photo->photo)}}"

                                                                     alt="{{@$obj->place_name}}">

                                                            @else($obj->category_id==1 || $obj->category_id==2)

                                                                <img src="{{url('uploads/'.@$obj->single_photo->photo)}}"

                                                                     alt="{{@$obj->place_name}}">

                                                            @endif

                                                            --}}{{--<img src="{{url('uploads/activities'.@$obj->single_photo->photo)}}"--}}{{--

                                                                 --}}{{--alt="{{@$obj->place_name}}">--}}{{--

                                                        @else

                                                            <img src="{{url('/images/no-image.png')}}"

                                                                 class="img-responsive" alt="image">

                                                        @endif



                                                    </a>--}}



                                                <a href="{{url('/activities/detail/'.$obj->slug)}}" class="hvr-float-shadow ">

                                                    @if(!empty($obj->single_photo->photo))

                                                        @if($obj->category_id==3)

                                                    <img src="{{url('uploads/activities'.@$obj->single_photo->photo)}}" alt="{{@$obj->place_name}}" style="width:

                                                    100%;position: relative;height: 104%;">

                                                    @else

                                                    <img src="{{url('uploads/'.@$obj->single_photo->photo)}}" alt="{{@$obj->place_name}}" style="width:

                                                    100%;position: relative;height: 104%;">

                                                    @endif

                                                    @else

                                                    <img src="{{url('/images/no-image.png')}}" class="img-responsive" alt="image" style="width:

                                                    100%;position: relative;height: 104%;">

                                                @endif



                                                </a>



                                                <div class="media-body" style="padding:10px;">



                                                    {{--<div class=" float-right">--}}



                                                    {{--</div>--}}



                                                    <h4>{{@$obj->place_name}}</h4>

                                                    <h4>{{@$obj->restaurant_name}}</h4>

                                                    <h4>{{@$obj->activity_name}}</h4>

                                                    <p>

                                                        <img src="{{url('images/map-pink.png')}}" alt="No marker">

                                                        <span><a href="#">{{@$obj->address->address}}</a></span>





                                                    </p>

                                                    {{-- <ul>

                                                         <li>

                                                             <strong>1</strong> BR Apartment

                                                         </li>

                                                         <li>

                                                             <strong>1</strong> BA

                                                         </li>

                                                         <li>

                                                             <strong>538</strong> sq. ft.

                                                         </li>

                                                         <li>Sleeps

                                                             <strong>6</strong>

                                                         </li>

                                                     </ul>--}}

                                                    <div class="discription d-none d-sm-block">

                                                        <p>

                                                            {{str_limit(strip_tags(trim($obj->description)),180, '...')}}

                                                        </p>

                                                    </div>

                                                    <div class="">

                                                        <style>

                                                            @media screen and (max-width: 441px){

                                                                .itsOk{

                                                                    background-color: #fff;

                                                                }

                                                            }

                                                        </style>

                                                        <div class="search_reviews itsOk" style="position: relative;bottom: 0;top: -5px;width: 104%;left: -10px;">

                                                            <div class="float-right" style="margin-top: -10px;margin-right: 15px;">

                                                                {{--<a href="checkout.html" class="hvr-float-shadow view_all">Book Now</a>--}}

                                                                @if(isset($obj->phone)) <i class="fa fa-phone"></i>:{{$obj->phone}} @endif <br>

                                                                <div class="d-none d-sm-block buttonisbutton">

                                                                    <a href="{{url('/activities/detail/'.$obj->slug)}}" class="hvr-float-shadow view_all" style="bottom: 10px;">Book Now</a>

                                                                </div>

                                                            </div>

                                                            {{--<small class="text-success">Very Good! 4.2/5 </small>--}}

                                                            {{--<h5>$137 per night</h5>--}}

                                                            <div class="clearfix" style="padding-top: 10px;">



                                                                <!-- <a href="#" data-toggle="modal" data-target=".place_description">

                                                                     <span>View details for total price</span>

                                                              </a>-->

                                                                {{--<div class="rateit float-left"></div>--}}

                                                                @if(isset($obj->reviews_avg->rating) && !empty($obj->reviews_avg->rating))

                                                                    <div class="rating">



                                                                        <div class="rateYo-{{@$i}}"></div>

                                                                        <small>

                                                                        </small>

                                                                        <?php

                                                                        if($obj->reviews_avg->rating>5){

                                                                            // echo 'greater';

                                                                            $star_rating='5';

                                                                        }else{

                                                                            // echo 'less';

                                                                            $star_rating=@$obj->reviews_avg->rating;

                                                                        }

                                                                        ?>

                                                                    </div>

                                                                    <script>

                                                                        $(document).ready(function () {

                                                                            showRating(<?=$i?>, <?=@$star_rating?>);

                                                                        });

                                                                    </script>

                                                                @endif



                                                                <h5 style="margin-bottom:20px;">

                                                                @if(!empty($obj->price))${{ number_format(round($obj->price))}} @endif</h5>

                                                                {{--<div class="row margin_top2em">--}}

                                                                {{--@if(!empty($obj->website_url))--}}

                                                                {{--<div class="col-md-2">--}}

                                                                {{--<a href="{{@$obj->website_url}}"><i class="fa fa-chrome"></i></a>--}}

                                                                {{--</div>--}}

                                                                {{--@endif--}}

                                                                {{--@if(!empty($obj->social_1))--}}

                                                                {{--<div class="col-md-2">--}}

                                                                {{--<a href="{{@$obj->social_1}}"><i class="fa fa-facebook-f"></i></a>--}}

                                                                {{--</div>--}}

                                                                {{--@endif--}}

                                                                {{--@if(!empty($obj->social_2))--}}

                                                                {{--<div class="col-md-2">--}}

                                                                {{--<a href="{{@$obj->social_2}}"><i class="fa fa-twitter"></i></a>--}}

                                                                {{--</div>--}}

                                                                {{--@endif--}}

                                                                {{--@if(!empty($obj->social_3))--}}

                                                                {{--<div class="col-md-2">--}}

                                                                {{--<a href="{{@$obj->social_3}}"><i class="fa fa-instagram"></i></a>--}}

                                                                {{--</div>--}}

                                                                {{--@endif--}}

                                                                {{--@if(!empty($obj->social_4))--}}

                                                                {{--<div class="col-md-2">--}}

                                                                {{--<a href="{{@$obj->social_4}}"><i class="fa fa-tripadvisor"></i></a>--}}

                                                                {{--</div>--}}

                                                                {{--@endif--}}



                                                                {{--</div>--}}

                                                            </div>

                                                        </div>

                                                    {{-- <div class="float-right">



                                                             <a href="{{url('/activities/detail/'.$obj->slug)}}"

                                                                class="hvr-float-shadow view_all">Book Now</a>



                                                     </div>--}}

                                                    <!-- <small class="text-success">Very Good! 4.2/5 </small>

                                                <h5>$137 per night</h5>

                                                <div class="clearfix">

                                                    <a href="{{url('place/item/')}}" data-toggle="modal" data-target=".place_description">

                                                        <span>View details for total price</span>

                                                    </a>



                                                </div> -->

                                                    </div>

                                                </div>

                                            </div>



                                        </div>



                                    </div>

                                @endforeach



                                {{--<style>--}}

                                {{--@media screen and (max-width: 440px){--}}

                                {{--.b2{--}}

                                {{--margin-right:-44px;--}}

                                {{--padding: 10px;--}}

                                {{--}--}}

                                {{--}--}}

                                {{--</style>--}}

                                <div class="col-md-2"></div>

                                <div class="col-md-12 mt-4 float-left paginateDivMain b2">

                                    <nav class="top_web_sol" aria-label="page navigation example">

                                        {{ $places->links() }}

                                    </nav>

                                </div>

                                <div class="col-md-2"></div>

                            @endif





                        </div>



                        @if(empty($places) )

                            <h4 style="color: gray; text-align: center; margin-left: 30%; margin-top: 15%;"> No Record Found </h4>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>

    <input type="hidden" value="{{Auth::id()}}" id="auth_user_login" name="">

    {!! Html::script('assets/web/js/favorite.js') !!}

    @include('maps_pages.search_maps')

    {!! Html::script('assets/web/js/jquery.rateyo.min.js') !!}

    <!-- auto complete start -->

    {!! Html::script('assets/admin/js/autocomplete/jquery-ui.js') !!}





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

            appendTo: '#activityoptions',

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

            appendTo: '#placeoptions',

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

            appendTo: '#restaurantoSearchOptions',

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

    <!-- auto complete end -->





@endsection