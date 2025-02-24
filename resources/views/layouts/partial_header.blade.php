<div class="main_slider bg_slider">
    <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100 h-100" src="{{url('images/search/1.png')}}" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100 h-100" src="{{url('images/search/2.png')}}" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100 h-100" src="{{url('images/search/3.png')}}" alt="Third slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100 h-100" src="{{url('images/search/4.png')}}" alt="Fourth slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100 h-100" src="{{url('images/search/5.png')}}" alt="Fifth slide">
            </div>

        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="sr-only">Next</span>
        </a>
    </div>

    <div class="search_wrapper">
        <ul class="nav nav-tabs" id="myTab" role="tablist">

            <li class="nav-item">
                <a class="nav-link  @if(isset($_GET['plc']) && $_GET['plc'] =='places-to-visit' || isset($_GET['rst']) && $_GET['rst']=='restaurant'
                || Request::segment(1)=='places' || Request::segment(1)=='restaurants'|| Request::segment(1)=='get-restaurants-by'
                ) @else active @endif"
                   id="Vacation-tab" data-toggle="tab" href="#Vacation" role="tab" aria-controls="Vacation"
                   aria-selected="false">
                    <i class="fas fa-tree"></i>Excursions</a>
            </li>

            <li class="nav-item" id="restaurantTab">
                <a class="nav-link @if(isset($_GET['rst'])&& $_GET['rst']=='restaurant' || Request::segment(1)=='restaurants'
                || Request::segment(1)=='get-restaurants-by') active @endif"
                   id="Discover-tab" data-toggle="tab" href="#Discover" role="tab"
                   aria-controls="Discover" aria-selected="false">
                    <i class="fas fa-building"></i>Restaurants</a>
            </li>
            <li class="nav-item" id="placesTab">
                <a class="nav-link @if(isset($_GET['plc']) && $_GET['plc']=='places-to-visit' || Request::segment(1)=='places') active @endif"
                   id="Places-tab" data-toggle="tab" href="#Places" role="tab"
                   aria-controls="Discover" aria-selected="false">
                    <i class="fas fa-map-marker-alt"></i>Places of Interests</a>
            </li>


        </ul>
        <?php

        ?>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade
                @if(isset($_GET['plc']) && $_GET['plc'] =='places-to-visit'
                || isset($_GET['rst']) && $_GET['rst'] =='restaurant'  || Request::segment(1)=='places'
                || Request::segment(1)=='restaurants' || Request::segment(1)=='restaurants') @else active @endif show"
                                 id="Vacation" role="tabpanel" aria-labelledby="Accomodation-tab">
                <form action="{{url('activities/search')}}" method="get" id="form_search_act">
                    <div class="row">
                        <div class="form-group col-6">
                            {{--<input type="text" class="destination form-control" placeholder="Destination, hotel name, airport, train station, landmark, or address">--}}

                            <input type="text" name="activtiy_term"
                                   value="@if(isset($_GET['activtiy_term']) && $_GET['activtiy_term']!=""){{trim($_GET['activtiy_term'])}} @endif"
                                   class="form-control required input_hotel " id="act_name"
                                   placeholder="City, activity name">
                            <input name="city_id" value="{{@$_GET['city_id']}}" id="act_city_id" type="hidden">
                            <input name="activity_type" value="{{@$_GET['activity_type']}}" type="hidden">
                            <span class="icon icon-location" aria-hidden="true"></span>
                        </div>
                        <div class="row">
                            <div class="form-group col-12" id="activityoptions">
                            </div>
                        </div>
                        <!--- commented by waseem for  Activity search--->
                        {{--<div class="form-group col">--}}
                            {{--<input type="text" class="daterange form-control" name="daterange" value=" "/>--}}
                        {{--</div>--}}

                        <div class="form-group col">
                            <!-- <label>Food type</label> -->
                            <select class="ddslick form-control" name="cuisine" id="style-6">
                                <option value=""
                                        selected>Excursions
                                </option>
                                @if(!empty($activtySubcategory))
                                    @foreach($activtySubcategory as $sub_cat)
                                        <option @if(isset($_GET['cuisine']) && $_GET['cuisine']==$sub_cat->id ) selected @endif
                                        value="{{$sub_cat->id}}">{{@$sub_cat->cat_name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group col-12">
                            <button type="submit" class="btn hvr-float-shadow view_all">Search</button>
                        </div>

                    </div>
                </form>
            </div>



            <div class="tab-pane fade @if(isset($_GET['rst']) && $_GET['rst']=='restaurant'
            || Request::segment(1)=='restaurants' || Request::segment(1)=='restaurants' ) active @endif show"
                 id="Discover" role="tabpanel" aria-labelledby="Discover-tab">
                <form action="{{url('restaurants/search')}}" method="get" id="form_search_rest">
                   
                    <div class="row">


                        <div class="col-md-6">
                            <div class="form-group">
                                <!-- <label>Search Restaurants</label> -->
                                <input type="text" name="term"
                                       value="@if(isset($_GET['term']) && $_GET['term']!=""){{trim($_GET['term'])}} @endif"
                                       class="form-control required input_hotel" id="restName"
                                       placeholder="City, Restaurant name">

                                <input name="rest_city_id" value="{{@$_GET['rest_city_id']}}" type="hidden">
                                <input name="type" value="{{@$_GET['type']}}" type="hidden">
                                <span class="icon icon-location" aria-hidden="true"></span>
                            </div>
                            <div class="row">
                                <div class="form-group col-12" id="restaurantoptions">

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <!-- <label>Food type</label> -->
                                <select class="ddslick form-control" name="cuisine" id="style-6">
                                    <option value=""
                                            selected>All restaurants
                                    </option>
                                    @if(isset($sub_category) && !empty($sub_category) )
                                    @foreach($sub_category as $sub_cat)
                                        <option @if(isset($_GET['cuisine']) && $_GET['cuisine']==$sub_cat->id ) selected @endif
                                                value="{{$sub_cat->id}}">{{$sub_cat->cat_name}}</option>
                                    @endforeach
                                        @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- End row -->
                    <span class="" aria-hidden="true">
                                @if(Session::has('restaurant_search_error'))
                            <p style="color: red;font-size: 14px"> {{ Session::get('restaurant_search_error') }}</p>
                        @endif</span>
                    {{--<hr>--}}
                    <button type="submit" class="btn hvr-float-shadow view_all" style="background:rgba(0, 0, 0, .5);">Search</button>

                </form>
            </div>

            <div class="tab-pane fade @if(isset($_GET['plc']) && $_GET['plc']=='places-to-visit' || Request::segment(1)=='places') active @endif show"
                 id="Places" role="tabpanel" aria-labelledby="Places-tab">
                <form method="get" action="{{url('places/search')}}" id="form_search_places">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <!-- <label>Search Places</label> -->
                                {{-- <input type="text" class="form-control"  name="activity_search"
                                        placeholder="Type your search terms">--}}
                                <input name="city_id" id="place_city_id" value="{{@$_GET['city_id']}}" type="hidden">
                                <input name="search_type" id="search_type" value="{{@$_GET['search_type']}}" type="hidden">
                                <input type="text" name="city"
                                       value="@if(isset($_GET['city']) && $_GET['city']!=""){{trim($_GET['city'])}} @endif"
                                       class="form-control required input_hotel" id="plc_name"
                                       placeholder="City, Place name">
                                <span class="icon icon-location" aria-hidden="true"></span>
                            </div>
                            <div class="row">
                                <div class="form-group col-12" id="placeoptions">

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6" style="margin-top:7px;">
                            <div class="form-group">
                                <!-- <label>Things to do</label> -->
                                <select class="ddslick form-control" name="subcategory">
                                    <option value="0"
                                            data-imagesrc="{{url('assets/web')}}/img/icons_search/all_tours.png"
                                            selected>All Places
                                    </option>
                                    @foreach($subcat_place as $sub_cat)
                                        <option @if(isset($_GET['subcategory']) && $_GET['subcategory']==$sub_cat->id ) selected @endif
                                                value="{{$sub_cat->id}}">{{$sub_cat->cat_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- End row -->
                    <span class="" aria-hidden="true">
                                @if(Session::has('place_search_error'))
                            <p style="color: red;font-size: 14px"> {{ Session::get('place_search_error') }}</p>
                        @endif</span>
                    {{--<hr>--}}
                    <button type="submit" class="btn hvr-float-shadow view_all" style="background:rgba(0, 0, 0, .5);">Search</button>
                </form>
            </div>
        </div>
    </div>
</div>