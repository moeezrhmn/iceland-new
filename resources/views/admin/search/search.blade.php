@extends('layouts.app')

@section('content')
 

    <div class="main_wrapper">
        <div class="main_slider bg_slider">
            <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="d-block w-100 h-100" src="{{url('public/images/lancscape1.jpg')}}" alt="First slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100 h-100" src="{{url('public/images/lancscape4.jpg')}}" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100 h-100" src="{{url('public/images/lancscape2.jpg')}}" alt="Third slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100 h-100" src="{{url('public/images/lancscape5.jpg')}}" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100 h-100" src="{{url('public/images/lancscape3.jpg')}}" alt="Third slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100 h-100" src="{{url('public/images/lancscape6.jpg')}}" alt="Second slide">
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
                        <a class="nav-link active" id="Vacation-tab" data-toggle="tab" href="#Vacation" role="tab" aria-controls="Vacation" aria-selected="false">
                            <i class="fas fa-tree"></i>Vacation Spots</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="Discover-tab" data-toggle="tab" href="#Discover" role="tab" aria-controls="Discover" aria-selected="false">
                            <i class="fas fa-search"></i>Restaurants</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">

                    <div class="tab-pane fade show active" id="Vacation" role="tabpanel" aria-labelledby="Vacation-tab">
                        <form>
                            <div class="row">
                                <div class="form-group col-12">
                                    <input type="text" class="destination form-control" id="autocomplete" url="http://localhost/northernadventure/getSearchData" placeholder="Destination, hotel name, airport, train station, landmark, or address">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <input type="text" class="checkin datepicker form-control" placeholder="Check-in">
                                </div>
                                <div class="form-group col">
                                    <input type="text" class="checkout datepicker form-control" placeholder="Check-out">
                                </div>
                                <div class="form-group col-5">
                                    <div class="select_option">
                                        <select class="selectpicker">
                                            <option>option 1</option>
                                            <option>option 2</option>
                                            <option>option 3</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    <button type="submit" class="btn hvr-float-shadow view_all">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="Discover" role="tabpanel" aria-labelledby="Discover-tab">
                        <form>
                            <div class="row">
                                <div class="form-group col-12">
                                    <input type="text" class="destination form-control" placeholder="What are you looking for...">
                                </div>

                                <div class="form-group col-12">
                                    <button type="submit" class="btn hvr-float-shadow view_all">Search</button>
                                </div>
                                <div class="col search_list">
                                    <h4>Things you can search for:</h4>
                                    <ul>
                                        <li>summer break deals in the bahamas</li>
                                        <li>last minute deals to vancouver</li>
                                        <li>all inclusive vacations to mexico</li>
                                        <li>price alerts on flights</li>
                                        <li>things to do in chicago</li>
                                    </ul>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="main_content">
            <div class="container">
                <div class="row">
                    <div class="grid_section text-center">
                        <h2>
                            <span>Papular destinations</span>
                        </h2>
                        <p>Explore the world’s most extensive selection of things to see and do in Iceland
                        </p>
                        <div class="slider_container">
                            <div class="popular">
                                <div class="slider_card">
                                    <a href="#">
                                        <div class="img_holder">
                                            <img src="images/lancscape1.jpg">
                                        </div>
                                        <div class="slider_content">
                                            <h3>Place Title</h3>
                                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="slider_card">
                                    <a href="#">
                                        <div class="img_holder">
                                            <img src="images/lancscape2.jpg">
                                        </div>
                                        <div class="slider_content">
                                            <h3>Place Title</h3>
                                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="slider_card">
                                    <a href="#">
                                        <div class="img_holder">
                                            <img src="images/lancscape3.jpg">
                                        </div>
                                        <div class="slider_content">
                                            <h3>Place Title</h3>
                                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="slider_card">
                                    <a href="#">
                                        <div class="img_holder">
                                            <img src="images/lancscape4.jpg">
                                        </div>
                                        <div class="slider_content">
                                            <h3>Place Title</h3>
                                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid_section explore_iceland text-center">
                        <h2>
                            <span>explore ICELAND</span>
                        </h2>
                        <p>Find out all you need to know about Icelandic nature, culture and history
                        </p>
                        <div class="grid_content row">
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <a href="description.html">
                                    <div class="d-flex justify-content-center img_wrapper">
                                        <img src="images/jpg.jpg">
                                        <div class="hover_txt">
                                            <h4>Heading text</h4>
                                            <p>Jump aboard this incredible boat trip in one of the world’s most inspiring places
                                                <span>read more...</span>
                                            </p>
                                        </div>
                                    </div>

                                </a>
                            </div>
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <a href="description.html">
                                    <div class="d-flex justify-content-center img_wrapper">
                                        <img src="images/landscape24.jpg">
                                        <div class="hover_txt">
                                            <h4>Heading text</h4>
                                            <p>Jump aboard this incredible boat trip in one of the world’s most inspiring places
                                                <span>read more...</span>
                                            </p>
                                        </div>
                                    </div>

                                </a>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <a href="#">
                                    <div class="d-flex justify-content-center img_wrapper">
                                        <img src="images/jpg.jpg">
                                        <div class="hover_txt">
                                            <h4>Heading text</h4>
                                            <p>Jump aboard this incredible boat trip in one of the world’s most inspiring places
                                                <span>read more...</span>
                                            </p>
                                        </div>
                                    </div>

                                </a>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <a href="#">
                                    <div class="d-flex justify-content-center img_wrapper">
                                        <img src="images/landscape24.jpg">
                                        <div class="hover_txt">
                                            <h4>Heading text</h4>
                                            <p>Jump aboard this incredible boat trip in one of the world’s most inspiring places
                                                <span>read more...</span>
                                            </p>
                                        </div>
                                    </div>

                                </a>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <a href="#">
                                    <div class="d-flex justify-content-center img_wrapper">
                                        <img src="images/img2.jpg">
                                        <div class="hover_txt">
                                            <h4>Heading text</h4>
                                            <p>Jump aboard this incredible boat trip in one of the world’s most inspiring places
                                                <span>read more...</span>
                                            </p>
                                        </div>
                                    </div>

                                </a>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <a href="#">
                                    <div class="d-flex justify-content-center img_wrapper">
                                        <img src="images/landscape24.jpg">
                                        <div class="hover_txt">
                                            <h4>Heading text</h4>
                                            <p>Jump aboard this incredible boat trip in one of the world’s most inspiring places
                                                <span>read more...</span>
                                            </p>
                                        </div>
                                    </div>

                                </a>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <a href="#">
                                    <div class="d-flex justify-content-center img_wrapper">
                                        <img src="images/img1.jpg">
                                        <div class="hover_txt">
                                            <h4>Heading text</h4>
                                            <p>Jump aboard this incredible boat trip in one of the world’s most inspiring places
                                                <span>read more...</span>
                                            </p>
                                        </div>
                                    </div>

                                </a>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <a href="#">
                                    <div class="d-flex justify-content-center img_wrapper">
                                        <img src="images/slide.jpg">
                                        <div class="hover_txt">
                                            <h4>Heading text</h4>
                                            <p>Jump aboard this incredible boat trip in one of the world’s most inspiring places
                                                <span>read more...</span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


@endsection