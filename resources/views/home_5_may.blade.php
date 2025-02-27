@extends('layouts.app')
@section('title', $title)

{{--@section('title', $isNew ? 'Create Category' : 'Visit Iceland')--}}

@section('content')

<style type="text/css">
.selectpickerCustom {

    background: bottom;
    border: 1px solid #02529c;
    color: white;
}
    .b{
        /*overflow-x: hidden;*/
    }
</style>
    <div class="main_wrapper b">
        <div class="main_slider">
            <div class="slider_wrapper">
                <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
                    </ol>

                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100 h-100" src="{{url('/slider_images/1.jpg')}}" alt="THIS IS ICELAND">
                            <div class="carousel-caption wow fadeIn" data-wow-duration="2s" data-wow-delay=".5s">
                                <h2 class="display-4">THIS IS ICELAND</h2>
                                <p>Your trip starts here... </p>
                                <a href="{{url('book-your-adventures')}}" class="hvr-float-shadow">Book now !</a>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100 h-100" src="{{url('slider_images/2.jpg')}}" alt="Latrabjarg">
                            <div class="carousel-caption wow fadeIn" data-wow-duration="2s" data-wow-delay=".5s">
                                <h2 class="display-4">Latrabjarg </h2>
                                <p>One of Europes biggest bird cliffs Westfjord Iceland </p>
                                <a href="{{url('book-your-adventures')}}" class="hvr-float-shadow">Book now !</a>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100 h-100" src="{{url('slider_images/3.jpg')}}" alt="Geothermal  Area">
                            <div class="carousel-caption wow fadeIn" data-wow-duration="2s" data-wow-delay=".5s">
                                <h2 class="display-4"> Geothermal  Area </h2>
                                <p>Krisuvik Reykjanes Iceland</p>
                                <a href="{{url('book-your-adventures')}}" class="hvr-float-shadow">Book now !</a>
                            </div>
                        </div>

                        <div class="carousel-item">
                            <img class="d-block w-100 h-100" src="{{url('slider_images/4.jpg')}}" alt="Northern Light">
                            <div class="carousel-caption wow fadeIn" data-wow-duration="2s" data-wow-delay=".5s">
                                <h2 class="display-4">Northern Light</h2>
                                <p> Reykjavik Iceland</p>
                                <a href="{{url('tours/northern-lights-tours')}}" class="hvr-float-shadow">Book now !</a>
                            </div>
                        </div>

                        <div class="carousel-item">
                            <img class="d-block w-100 h-100" src="{{url('slider_images/5.jpg')}}" alt="Kirkjufell or Church Mountain Snaefellsnes Peninsula">
                            <div class="carousel-caption wow fadeIn" data-wow-duration="2s" data-wow-delay=".5s">
                                <h2 class="display-4">Kirkjufell or Church Mountain Snaefellsnes Peninsula</h2>
                                <p>Your trip starts here... </p>
                                <a href="{{url('book-your-adventures')}}" class="hvr-float-shadow">Book now !</a>
                            </div>
                        </div>

                        <div class="carousel-item">
                            <img class="d-block w-100 h-100" src="{{url('slider_images/6.jpg')}}" alt="Sunset Reykjavik Iceland">
                            <div class="carousel-caption wow fadeIn" data-wow-duration="2s" data-wow-delay=".5s">
                                <h2 class="display-4">Sunset Reykjavik Iceland</h2>
                                <p>Your trip starts here... </p>
                                <a href="{{url('book-your-adventures')}}" class="hvr-float-shadow">Book now !</a>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100 h-100" src="{{url('slider_images/7.jpg')}}" alt="Harpa Concert Hall">
                            <div class="carousel-caption wow fadeIn" data-wow-duration="2s" data-wow-delay=".5s">
                                <h2 class="display-4">Harpa Concert Hall</h2>
                                <p>Reykjavik Iceland </p>
                                <a href="{{url('book-your-adventures')}}" class="hvr-float-shadow">Book now !</a>
                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="container-fluid" style="padding:0px; margin: 0px; overflow-x: hidden;">
            <div class="row">
                <div class="col-md-12" style="overflow-x: hidden;">
                    <div class="custom_tabs_wrapper">
                        <div class="custom_tabs tabs_5 d-flex justify-content-center" style="height: auto;">
                            <ul class="col-xs-12">
                                <li>
                                    <a href="https://icelandmonitor.mbl.is/news/latest/" target="_blank">
                                        <i class="fas fa-newspaper"></i> News from Iceland</a>
                                </li>
                                <li>
                                    <a href="https://en.vedur.is/weather/forecasts/areas" target="_blank">
                                        <i class="fas fa-sun"></i> Weather</a>
                                </li>
                                <li>
                                    <a  target="_blank" href="https://www.isavia.is/en/keflavik-airport/flight-schedule/departures">
                                        <i class="fas fa-paper-plane"></i> Flights</a>
                                </li>
                                <li>
                                    <a href="{{url('article')}}">
                                        <i class="fas fa-info-circle"></i> Articles</a>
                                </li>
                                <li>
                                    <a href="{{url('article')}}">
                                        <i class="fas fa-taxi"></i> Safe driving in ICELAND</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="main_content">
            <div class="container">
                <div class="row">
                    <div class="grid_section text-center">
                        <h2>
                            <span>Book Your Adventures</span>
                        </h2>
                        <p>Find out and Discover the Best Things to do in Iceland
                        </p>
                        <div class="grid_content row">
                            @foreach ($ActivityData as $values)
                                <?php //dd($values); ?>
                            <div class="col-lg-3 col-md-4 col-sm-6 wow fadeInLeft activityGridListing" data-wow-duration="1s" data-wow-delay=".5s">
                                <div class="row">
                                </div>
                                  <!-- <div class="activityGridItem"> -->
                            <a href="{{url('activities/detail/'.$values['slug'])}}" style="overflow: visible;">
                                    <span class="post_time">{{$values['duration']}}</span>
                                    <div class="d-flex justify-content-center img_wrapper">
                                        @if(isset($values->single_photo)&& !empty($values->single_photo))
                                        <img src="{{ url('uploads/activities'.$values->single_photo->photo) }} " alt="{{ $values['activity_name'] }}">
                                        @else
                                            <img src="{{ url('images/no-image.png') }} " alt="{{ $values['activity_name'] }}">
                                        @endif
                                        <div class="d-flex justify-content-center align-items-center hover_txt">
                                            <p>{{ strip_tags( substr( $values['description'],0,100) ) }}
                                                <span>read more...</span>
                                            </p>
                                        </div>
                                        {{--<span>May - Oct</span>--}}
                                    </div>
                                    <div class="row">
                                        {{--<div class="col-md-12">--}}
                                        <div class="select_plan">
                                        <span>From:
                                            <strong>{{ number_format(round($values['price']))}}</strong>
                                        </span>
                                            <!-- <select class="selectpickerCustom"> -->
                                            <select class="selectpicker">
                                                <option value="USD">USD</option>
                                                <option value="ISK">ISK</option>
                                                <option value="AUD">AUD</option>
                                                <option value="CAD">CAD</option>
                                                <option value="CHF">CHF</option>
                                                <option value="DKK">DKK</option>
                                                <option value="EUR">EUR</option><option value="GBP">GBP</option>
                                                <option value="HKD">HKD</option><option value="JPY">JPY</option>
                                                <option value="KRW">KRW</option><option value="NOK">NOK</option><option value="PLN">PLN</option>
                                                <option value="RUB">RUB</option><option value="SEK">SEK</option><option value="SGD">SGD</option>
                                                <option value="EUR">EUR</option>
                                                <option value="GBP">GBP</option>
                                                <option value="HKD">HKD</option>
                                                <option value="ISK">ISK</option>
                                                <option value="JPY">JPY</option>
                                                <option value="KRW">KRW</option>
                                                <option value="NOK">NOK</option>
                                                <option value="PLN">PLN</option>
                                                <option value="RUB">RUB</option>
                                                <option value="SEK">SEK</option>
                                                <option value="SGD">SGD</option>
                                            </select>
                                        </div>
                                        {{--</div>--}}
                                    </div>
                                <div class="row">
                                    <div class="col-md-12">
                                    <span class="place_name" style="text-align: center;">{{str_limit($values['activity_name'],30)}}</span>
                                    </div>
                                </div>

                                </a>
                                  <!-- </div> -->
                            </div>
                            @endforeach
                        </div>
                        <div class="row">
                            <a href="{{url('book-your-adventures')}}" class="hvr-float-shadow view_all">View all bookings</a>
                        </div>
                    </div>
                    <div class="grid_section explore_iceland text-center">
                        <h2>
                            <span>Discover Iceland </span>
                        </h2>
                        <p>A variety of attractions, galleries & museums, parks & green areas, historical sites, statues & monuments
                        </p>
                        <div class="grid_content row wow fadeIn" data-wow-duration="1s" data-wow-delay=".5s">
                        	@for($i = 0; $i < count($SubCategoriesData); $i++)
                        	@if($i==0)
                            <div class="col-md-8 col-sm-6 col-xs-12">
                                <a href="{{url('places/'.$SubCategoriesData[$i]['slug'])}}">
                                    <div class="d-flex justify-content-center img_wrapper">
                                        <img src="{{ url('uploads/'.$SubCategoriesData[$i]['cat_image']) }}" alt="{{$SubCategoriesData[$i]['cat_name']}}">
                                        <div class="hover_txt">
                                            <h4>{{$SubCategoriesData[$i]['cat_name']}}</h4>
                                            <p>{{$SubCategoriesData[$i]['description']}}
                                                <span>read more...</span>
                                            </p>
                                        </div>
                                    </div>

                                </a>
                            </div>
                            @elseif($i==1)
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <a href="{{url('places/'.$SubCategoriesData[$i]['slug'])}}">
                                    <div class="d-flex justify-content-center img_wrapper">
                                        <img src="{{ url('uploads/'.$SubCategoriesData[$i]['cat_image']) }}" alt="{{$SubCategoriesData[$i]['cat_name']}}">
                                        <div class="hover_txt">
                                            <h4>{{$SubCategoriesData[$i]['cat_name']}}</h4>
                                            <p>{{$SubCategoriesData[$i]['description']}}
                                                <span>read more...</span>
                                            </p>
                                        </div>
                                    </div>

                                </a>
                            </div>
                            @else
                            <div class="col-md-4 col-sm-6">
                                <a href="{{url('places/'.$SubCategoriesData[$i]['slug'])}}">
                                    <div class="d-flex justify-content-center img_wrapper">
                                        <img src="{{ url('uploads/'.$SubCategoriesData[$i]['cat_image']) }}" alt="{{$SubCategoriesData[$i]['cat_name']}}">
                                        <div class="hover_txt">
                                            <h4>{{$SubCategoriesData[$i]['cat_name']}}</h4>
                                            <p>{{$SubCategoriesData[$i]['description']}}
                                                <span>read more...</span>
                                            </p>
                                        </div>
                                    </div>

                                </a>
                            </div>
                            @endif
                            @endfor
                        </div>
                        <div class="row">
                            <a href="{{url('search?plc=places-to-visit')}}" class="hvr-float-shadow view_all">View more</a>
                        </div>
                    </div>

                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="grid_section bloggers text-center">
                        <h2>
                            <span>Iceland Travel Blogs, Tips and Articles</span>
                        </h2>
                        <p> Get Iceland travel tips from travellers and the locals</p>

                        <div class="grid_content row">
                           @foreach($ArticleData as $article)

                            <div class="col-sm-12 col-md-6 wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".5s">
                                <div class="card text-left">
                                    @if(isset($article->single_photo->photo))
                                    {{--{{dd($article->single_photo->photo) }}--}}
                                    <img class="card-img-top" src="{{ url('uploads/'.$article->single_photo->photo) }}" alt="{{$article->title}}" style="height: 100%;">
                                    @endif
                                    {{--<img class="card-img-top" src="{{ asset('images/maxresdefault.jpg') }}" alt="Card image cap" style="height:60%;">--}}
                                        <div class="card-body">
                                        <h4 class="card-title">{{$article->title}}</h4>
                                        <p class="card-text">
                                           {{$article->short_des}}
                                          ...</p>
                                        <a href="{{url('article/detail/'.$article->slug)}}" class="hvr-float-shadow view_all">Read more</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                             {{--<div class="col-sm-12 col-md-6 wow fadeInRight" data-wow-duration="1s" data-wow-delay=".5s">--}}
                                                            {{--<div class="card text-left">--}}
                                                                {{--<img class="card-img-top" src="{{ url('images/img2.jpg')  }}" alt="Card image cap">--}}
                                                                {{--<div class="card-body">--}}
                                                                    {{--<h4 class="card-title">Top 10 Tours in Iceland | Both Popular & Unique</h4>--}}
                                                                    {{--<p class="card-text">Which are the most popular and best value activity and nature trips in Iceland? See this to find the best tours that you should join during your sta...</p>--}}
                                                                    {{--<a href="#" class="hvr-float-shadow view_all">Read more</a>--}}
                                                                {{--</div>--}}
                                                            {{--</div>--}}
                                                        {{--</div>--}}

                            {{--<div class="col-sm-12 col-md-6 wow fadeInRight" data-wow-duration="1s" data-wow-delay=".5s">--}}
                                {{--<div class="card text-left">--}}
                                    {{--<img class="card-img-top" src="{{ url('images/img2.jpg')  }}" alt="Card image cap">--}}
                                    {{--<div class="card-body">--}}
                                        {{--<h4 class="card-title">Top 10 Tours in Iceland | Both Popular & Unique</h4>--}}
                                        {{--<p class="card-text">Which are the most popular and best value activity and nature trips in Iceland? See this to find the best tours that you should join during your sta...</p>--}}
                                        {{--<a href="#" class="hvr-float-shadow view_all">Read more</a>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                        </div>
                        <div class="row">
                            <a href="{{url('article/')}}" class="hvr-float-shadow view_all">View more</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="grid_section img_slider text-center">
                        <h2>
                            <span>Iceland Photo Gallery</span>
                        </h2>
                        <p>Fantastic Images from Iceland to Inspire Your Next Trip</p>

                        {{--<div class="grid_content">--}}
                            {{--<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">--}}
                                {{--<div class="carousel-inner">--}}
                                    {{--<div class="carousel-item active">--}}
                                        {{--<img class="d-block w-100" src="{{url('images/img1.jpg')}}" alt="First slide">--}}
                                    {{--</div>--}}
                                    {{--<div class="carousel-item">--}}
                                        {{--<img class="d-block w-100" src="{{url('images/img2.jpg')}}" alt="Second slide">--}}
                                    {{--</div>--}}
                                    {{--<div class="carousel-item active">--}}
                                        {{--<img class="d-block w-100" src="{{url('images/slide.jpg')}}" alt="Third slide">--}}
                                    {{--</div>--}}
                                    {{--<a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">--}}
                                        {{--<span class="carousel-control-prev-icon" aria-hidden="true"></span>--}}
                                        {{--<span class="sr-only">Previous</span>--}}
                                    {{--</a>--}}
                                    {{--<a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">--}}
                                        {{--<span class="carousel-control-next-icon" aria-hidden="true"></span>--}}
                                        {{--<span class="sr-only">Next</span>--}}
                                    {{--</a>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}


                        <div class="grid_content">
                            <?php // dd($featuredData)?>
                            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                         @if(sizeof($featuredData))
                                @foreach($featuredData as $obj)

                                    @if(isset($obj->photo) && !empty($obj->photo)  )
                                    <div class="carousel-item ">
                                        <img class="gallery-100" src="{{url('uploads/'.$obj->photo)}}" alt="{{$obj->place_name}}">
                                    </div>
                                      @endif
                                @endforeach
                         @endif
                                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <a href="{{url('explore-gallery')}}" class="hvr-float-shadow view_all">Explore Gallery</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="grid_section plan_drive text-center">
                        <h2>
                            <span>Your Local Guide In Iceland</span>
                        </h2>
                        <p>
                           “Travel is the only thing you buy that makes you richer.”
                        </p>

                        {{--<style>--}}
                            {{--.Mydivishere--}}
                            {{--{--}}
                                {{--/*position:fixed;*/--}}
                                {{--/*bottom:0px;*/--}}
                                {{--/*left:0px;*/--}}
                                {{--/*right:0px;*/--}}
                                {{--/*background-color:#004369;*/--}}
                                {{--/*width:100%;*/--}}
                                {{--/*height:20px;*/--}}
                                {{--/*z-index:100;*/--}}
                                {{--color: red;--}}
                            {{--}--}}

                        {{--</style>--}}


                        {{--<script>--}}
                            {{--document.onscroll = function() {--}}
                                {{--if (window.innerHeight + window.scrollY > document.body.clientHeight) {--}}
                                    {{--document.getElementById('Mydivishere').style.display='none';--}}
                                {{--}--}}
                            {{--}--}}
                        {{--</script>--}}
                        {{--<div class="Mydivishere">--}}
                            {{--<h1 class="">Hello world</h1>--}}
                        {{--</div>--}}



                        <div class="grid_content">
                            <div class="container">
                                <div class="row">
                                    <div class="col-sm-4 col-xs-12 wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".5s">
                                        <a href="#" class="hvr-float">
                                            <i class="fas fa-camera"></i>
                                            <span>search for attractions</span>
                                        </a>
                                    </div>
                                    <div class="col-sm-4 col-xs-12 wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".5s">
                                        <a href="#" class="hvr-float">
                                            <i class="fas fa-handshake"></i>
                                            <span>contact services</span>
                                        </a>
                                    </div>
                                    <div class="col-sm-4 col-xs-12 wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".5s">
                                        <a href="#" class="hvr-float">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <span>create an itenerary</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

{{--<div class="container">--}}
    {{--<div class="row justify-content-center">--}}
        {{--<div class="col-md-8">--}}
            {{--<div class="card">--}}
                {{--<div class="card-header">Dashboard</div>--}}

                {{--<div class="card-body">--}}
                    {{--@if (session('status'))--}}
                        {{--<div class="alert alert-success">--}}
                            {{--{{ session('status') }}--}}
                        {{--</div>--}}
                    {{--@endif--}}

                    {{--You are logged in!--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
<script type="text/javascript">
    $(document).ready(function(){
        $('.selectpickerCustom').click(function(e){
            e.preventDefault();
        });

         $(".carousel-inner .carousel-item:first-child" ).addClass( "active" );

    });
</script>

@endsection

