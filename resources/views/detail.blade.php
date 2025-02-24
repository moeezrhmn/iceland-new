@extends('layouts.app')
{!! Html::style('assets/web/css/jquery.rateyo.min.css') !!}
<style type="text/css">
    #unfavorite {
        display: none;
    }
    .btn.nav-link {
        margin-bottom: 5px;
        padding-left: 1.5px;

    }
    .shareSocialLi{
        width: 75px;
    }
    #social-links {
        position: fixed;
        top: 40%;
    }
    .fa {
        padding: 20px;
        font-size: 30px;
        width: 50px;
        text-align: center;
        text-decoration: none;
        margin: 5px 2px;
    }

    .fa:hover {
        opacity: 0.7;
    }

    .fa-facebook {
        background: #3B5998;
        color: white;
    }

    .fa-twitter {
        background: #55ACEE;
        color: white;
    }

    .fa-google {
        background: #dd4b39;
        color: white;
    }
</style>

@section('content')
    <div class="main_wrapper">
        <div class="description_wrapper">
            <div id="social-links" class=" d-none d-sm-block">
                <ul>
                    {{--<li class="shareSocialLi"><a href="https://www.facebook.com/sharer/sharer.php?u={{url()->current()}}&picture={{url('public/uploads/'.@$item->photo[0]->photo)}}" class="social-button " id="">--}}
                    <li class="shareSocialLi"><a href="#" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURIComponent(location.href),'facebook-share-dialog','width=626,height=436');return false;" class="social-button " id="">
                            <i class="fa fa-facebook"></i></a></li>
                    <li class="shareSocialLi"><a href="https://twitter.com/intent/tweet?url={{url()->current()}}&picture={{url('public/uploads/'.@$item->photo[0]->photo)}}&text={{@$item->restaurant_name}}{{@$item->place_name}}" class="social-button " id="">
                            <i class="fa fa-twitter"></i></a></li>
                    {{--<li class="shareSocialLi"><a href="https://twitter.com/intent/tweet?url={{@$item->restaurant_name}}{{@$item->slug}}{!!@$item->description!!}&amp;url={{url()->current()}}" class="social-button " id="">
                            <img src="{{asset('public/images/twitter.jpg')}}" alt=""></a></li>--}}
                    <li class="shareSocialLi"><a href="https://plus.google.com/share?url={{url()->current()}}&image={{@$item->photo[0]->photo}}" class="social-button " id="">
                            <i class="fa fa-google"></i></a></li>
                    {{--<li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=http://jorenvanhocht.be&amp;title=my share text&amp;summary=dit is de linkedin summary" class="social-button " id=""><span class="fa fa-linkedin"></span></a></li>--}}
                </ul>
            </div>
            <div class="container">
                <h2>{{@$item->restaurant_name}}</h2>
                <h2 style="font-size: 30px;margin-bottom: 15px;">{{@$item->place_name}}</h2>
                {{--style="margin-bottom: 0rem;"--}}
                <div class="row" style="margin-bottom: 15px;">
                <div class="col-md-12"><img src="{{url('public/images/map-pink.png')}}" class="pull-left">
                    <a href="#" style="margin-left: 10px;">{{@$item->address->address}}</a>
                </div>
                </div>
                {{--skjdfdskfhsfh--}}
                {{--skjdfdskfhsfhdkfj--}}
                {{--skjdfdskfhsfhdkfj--}}

                <div id="description" class="main_content">
                    <div class="row">
                        <div class="col-lg-8 col-sm-12">
                            <div class="image_gallery">
                                <ul id="image-gallery" class="gallery list-unstyled cS-hidden">
                                    @if(sizeof($item->photo) )
                                        @foreach($item->photo  as $row )
                                            <li data-thumb="{{ url('public/uploads/'.@$row->photo) }}">
                                                <img src="{{ url('public/uploads/'.@$row->photo) }}">
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            <div class="row rate_like">
                                {{--<div class="col d-flex justify-content-start social_like">
                                    <a href="#"><img src="{{url('public/images/like.png')}}"></a>
                                </div>--}}
                                <div class="col d-flex justify-content-end">
                                    @if(isset($item->reviews_avg->rating) && !empty($item->reviews_avg->rating))
                                    <span>Rate Us</span>
                                    {{--<span class="rateit"></span>--}}

                                        <div class="rating">
                                            <?php
                                            $i=0;
                                            ?>
                                            <div class="rateYo-{{$i}}"></div>
                                            <small>
                                            </small>
                                            <?php
                                            if($item->reviews_avg->rating>5){
                                                // echo 'greater';
                                                $star_rating='5';
                                            }else{
                                                // echo 'less';
                                                $star_rating=@$item->reviews_avg->rating;
                                            }
                                            ?>
                                        </div>
                                        <script>
                                            $(document).ready(function () {
                                                showRating(<?=$i?>, <?=@$star_rating?>);
                                            });
                                        </script>
                                    @endif
                                </div>
                            </div>
                            <div class="tab_content">
                                <input type="hidden" value="{{Auth::id()}}" id="auth_user_login" name="">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-12 border-right">
                                        <!-- favorite start -->
                                        <div id="unfav-{{@$item->id}}" data-action="{{@$item->id}}" class="unfavorite"
                                             content="{{@$item->category_id}}" style="display: none">
                                            <a class="btn nav-link btn-danger btn_full_outline unfav"
                                               href="javascript:void(0)">
                                                <i class=" icon-heart"></i> Remove Favorites</a>
                                        </div>
                                        <div id="fav-{{@$item->id}}" data-action="{{@$item->id}}"
                                             content="{{@$item->category_id}}" class="favorite"  style="display: none;background: #02529C;color: white">
                                            <a class="btn nav-link  btn_full_outline fav"
                                               href="javascript:void(0)">
                                                <i class=" icon-heart"></i>Add to Favorite</a>
                                        </div>
                                        <?php
                                        /*echo '<pre>';
                                        print_r($favoruite);
                                        exit;*/
                                        ?>
                                        @if(isset($favoruite->id) && !empty($favoruite->id))
                                            <div id="unfavorite-{{@$item->id}}">
                                                <a class="btn nav-link btn-danger  btn_full_outline unfavorite" content="{{@$item->category_id}}"
                                                   data-action="{{@$item->id}}" href="javascript:void(0)">
                                                    <i class=" icon-heart"></i> Remove Favorites</a>
                                            </div>
                                        @else
                                            <div id="favorite-{{@$item->id}}" class="" style=" text-align: center;">
                                                <a class="btn nav-link  btn_full_outline favorite" content="{{@$item->category_id}}"
                                                   style="background: #02529C;color: #fff;" data-action="{{@$item->id}}" href="javascript:void(0)">
                                                    <i class=" icon-heart"></i> Add to Favorite</a>

                                            </div>
                                    @endif
                                    <!-- add to favorit end -->
                                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                             aria-orientation="vertical" style="text-align: center;">
                                            <a class="nav-link active" id="v-pills-description-tab" data-toggle="pill"
                                               href="#v-pills-description" role="tab"
                                               aria-controls="v-pills-description" aria-selected="true">Description</a>
                                            {{--<a class="nav-link" id="v-pills-facts-tab" data-toggle="pill"--}}
                                               {{--href="#v-pills-facts" role="tab" aria-controls="v-pills-facts"--}}
                                               {{--aria-slected="false">Quick Facts</a>--}}
                                            <!-- <a class="nav-link" id="v-pills-map-tab" data-toggle="pill"
                                               href="#v-pills-map" role="tab" aria-controls="v-pills-map"
                                               aria-selected="false">Map</a> -->
                                            {{--<a class="nav-link" id="v-pills-video-tab" data-toggle="pill"--}}
                                               {{--href="#v-pills-video" role="tab" aria-controls="v-pills-video"--}}
                                               {{--aria-selected="false">Video</a>--}}
                                            <a class="nav-link btn btn-default" id="v-pills-reviews-tab" data-toggle="pill"
                                               href="#v-pills-reviews" role="tab" aria-controls="v-pills-reviews"
                                               aria-selected="false" style="background-color: #02529C; color:#fff;margin-top:5;">Reviews</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-9 col-sm-12">
                                        <div class="tab-content" id="v-pills-tabContent">
                                            <div class="tab-pane fade show active" id="v-pills-description"
                                                 role="tabpanel" aria-labelledby="v-pills-description-tab">
                                                <h4>{{@$item->restaurant_name}}</h4>
                                                <h4>{{@$item->place_name}}</h4>
                                                <p>{!!@$item->description!!}</p>
                                                <div class="row">
                                                    <div class="col-md-8"></div>
                                                    <div class="col-md-4 pull-right">
                                                        <div class="row">
                                                            @if(!empty($item->website_url))
                                                                <div class="col-md-2">
                                                                    <a href="{{@$obj->website_url}}"><i class="fa fa-google"></i></a>
                                                                </div>
                                                            @endif
                                                            @if(!empty($item->social_1))
                                                                <div class="col-md-2">
                                                                    <a href="{{@$item->social_1}}"><i class="fa fa-facebook"></i></a>
                                                                </div>
                                                            @endif
                                                            @if(!empty($item->social_2))
                                                                <div class="col-md-2">
                                                                    <a href="{{@$item->social_2}}"><i class="fa fa-twitter"></i></a>
                                                                </div>
                                                            @endif
                                                            @if(!empty($item->social_3))
                                                                <div class="col-md-2">
                                                                    <a href="{{@$item->social_3}}"><i class="fa fa-instagram"></i></a>
                                                                </div>
                                                            @endif
                                                            @if(!empty($item->social_4))
                                                                <div class="col-md-2">
                                                                    <a href="{{@$item->social_4}}"><i class="fa fa-tripadvisor"></i></a>
                                                                </div>
                                                            @endif
                                                                {{--&nbsp;&nbsp;--}}
                                                                {{--<div class="col-md-2">--}}
                                                                    {{--<a href="#"><i class="fa fa-facebook"></i></a>--}}
                                                                {{--</div>&nbsp;&nbsp;--}}
                                                                {{--<div class="col-md-2">--}}
                                                                    {{--<a href="#"><i class="fa fa-instagram"></i></a>--}}
                                                                {{--</div>&nbsp;&nbsp;--}}
                                                                {{--<div class="col-md-2">--}}
                                                                    {{--<a href="#"><i class="fa fa-twitter"></i></a>--}}
                                                                {{--</div>--}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <h4>Heading title</h4>
                                                <p>Once you reach the crater, you will find an opening and an elevator crane. After being equipped with a helmet and harness, you will enter the lift's basket and begin your descent. Nowhere else in the world can you enter a magma chamber this way, which is part of what makes this tour so unique and worthwhile. This lift journey toward the centre of the earth covers 198 metres and takes about six minutes.</p> -->
                                            </div>
                                            {{--<div class="tab-pane fade" id="v-pills-facts" role="tabpanel"--}}
                                                 {{--aria-labelledby="v-pills-facts-tab">--}}
                                                {{--<div class="info_section border-bottom">--}}
                                                    {{--<h4>Tour information:</h4>--}}
                                                    {{--<ul>--}}
                                                        {{--<li>--}}
                                                            {{--<strong>Available</strong>--}}
                                                            {{--<span>May. - Oct. </span>--}}
                                                        {{--</li>--}}
                                                        {{--<li>--}}
                                                            {{--<strong>Duration</strong>--}}
                                                            {{--<span>6 hours</span>--}}
                                                        {{--</li>--}}
                                                        {{--<li>--}}
                                                            {{--<strong>Activities</strong>--}}
                                                            {{--<span>Caving</span>--}}
                                                        {{--</li>--}}
                                                        {{--<li>--}}
                                                            {{--<strong>Difficulty</strong>--}}
                                                            {{--<span>Moderate</span>--}}
                                                        {{--</li>--}}
                                                    {{--</ul>--}}
                                                {{--</div>--}}
                                                {{--<div class="info_section border-bottom">--}}
                                                    {{--<h4>Pickup information:</h4>--}}
                                                    {{--<ul>--}}
                                                        {{--<li>--}}
                                                            {{--<strong>Pickup time :</strong>--}}
                                                            {{--<span>	07:30 08:30, 09:30, 10:30, 11:30, 12:30, 13:30, 14:30, 15:30, 16:30,</span>--}}
                                                            {{--<p>Please be at your pickup location in time for your--}}
                                                                {{--departure. Should your pickup location be at a bus stop--}}
                                                                {{--and you need assistance finding it, seek guidance in--}}
                                                                {{--your Hotel's reception or contact your tour provider--}}
                                                                {{--directly.</p>--}}
                                                        {{--</li>--}}
                                                    {{--</ul>--}}
                                                {{--</div>--}}
                                                {{--<div class="info_section styled_list">--}}
                                                    {{--<h4>Included:</h4>--}}
                                                    {{--<ul>--}}
                                                        {{--<li>--}}
                                                            {{--<span>Pick-up from and return to your accommodation in Reykjavik</span>--}}
                                                        {{--</li>--}}
                                                        {{--<li>--}}
                                                            {{--<span>All safety gear (helmets, harness, etc.)</span>--}}
                                                        {{--</li>--}}
                                                        {{--<li>--}}
                                                            {{--<span>Small refreshments (soup, coffee/tea and perhaps some sweets)</span>--}}
                                                        {{--</li>--}}
                                                        {{--<li>--}}
                                                            {{--<span>Experienced guides</span>--}}
                                                        {{--</li>--}}
                                                    {{--</ul>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            <!--   <div class="tab-pane fade custom_iframe" style="height: 100%;margin: 0;padding: 0;" id="v-pills-map" role="tabpanel"
                                                   aria-labelledby="v-pills-map-tab">
                                                  <div class="col-md-12 map-right hidden-sm hidden-xs">
                                                      <div style="height: 300px;" class="map_city" id="mapId"></div>
                                                  </div>
                                              </div> -->
                                            <div class="tab-pane fade custom_iframe" id="v-pills-video" role="tabpanel"
                                                 aria-labelledby="v-pills-video-tab">
                                                <iframe src="https://www.youtube.com/embed/mPBaqh3dcVM?rel=0"
                                                        frameborder="0" allow="autoplay; encrypted-media"
                                                        allowfullscreen></iframe>
                                            </div>
                                            <?php
                                            /*echo '<pre>';
                                            print_r($reviews);
                                            exit;*/

                                            ?>
                                            <div class="tab-pane fade user_reviews" id="v-pills-reviews" role="tabpanel"
                                                 aria-labelledby="v-pills-reviews-tab">
                                                <ul class="list-unstyled">
                                                    @if(!empty($reviews))
                                                        @foreach($reviews as $review)
                                                            <li class="media">
                                              @if(isset($review->user_detail->user_photo))
                                                <img class="mr-3" src="{{url('public/uploads/'.$review->user_detail->user_photo)}}" alt="">
                                                 @else
                                                 <img class="mr-3" src=" {{url('public/images/0.jpg')}}" alt="">
                                                @endif

                                                                <div class="media-body">
                                                                    <h6 class="mt-0 mb-1">{{$review->user_detail->first_name}} {{$review->user_detail->last_name}}</h6>
                                                                    <p>{{$review->comment}}</p>
                                                                </div>
                                                            </li>
                                                    @endforeach
                                                @endif
                                                <!--  <li class="media my-4">
                                                        <img class="mr-3" src="{{url('public/images/0.jpg')}}"
                                                             alt="Generic placeholder image">
                                                        <div class="media-body">
                                                            <h4 class="mt-0 mb-1">List-based media object</h4>
                                                            <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel
                                                                metus scelerisque ante sollicitudin. Cras purus odio,
                                                                vestibulum in vulputate at, tempus viverra turpis. Fusce
                                                                condimentum nunc ac nisi vulputate fringilla. Donec
                                                                lacinia congue felis in faucibus.</p>
                                                        </div>
                                                    </li>
                                                    <li class="media">
                                                        <img class="mr-3" src="{{url('public/images/0.jpg')}}"
                                                             alt="Generic placeholder image">
                                                        <div class="media-body">
                                                            <h4 class="mt-0 mb-1">List-based media object</h4>
                                                            <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel
                                                                metus scelerisque ante sollicitudin.</p>
                                                        </div>
                                                    </li> -->
                                                </ul>
                                                <div class="checkout_wrapper">
                                                    @if(Auth::id())
                                                        <form class="add_review" action="{{url('review/store')}}"
                                                              method="post">
                                                            @csrf
                                                      @else
                                                                <form class="add_review" action="javascript:void(0);"
                                                                      method="post">
                                                     @endif
                                                                    <span class="rateit" style=""></span>
                                                                    <input type="hidden" name="rating_star" id="rating_star">

                                                                    <textarea class="form-control" name="comment"
                                                                              placeholder="Add your review here..."
                                                                              rows="3"></textarea>
                                                                    <input type="hidden" name="instance_id"
                                                                           value="{{@$item->id}}">
                                                                    @if($item->place_name)
                                                                        <input type="hidden" name="category_id"
                                                                               value="1">
                                                                    @else
                                                                        <input type="hidden" name="category_id"
                                                                               value="2">
                                                                    @endif
                                                                    @if(Auth::id())
                                                                        <button type="submit"
                                                                                class="btn hvr-float-shadow view_all">
                                                                            Submit review
                                                                        </button>
                                                                    @else
                                                                        <button data-toggle="modal" id="reviewBtn"
                                                                                data-target=".user_login"
                                                                                class="btn hvr-float-shadow view_all">
                                                                            Submit review
                                                                        </button>
                                                                    @endif

                                                                </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="col-md-12 map-right hidden-sm hidden-xs">
                                <div style="height: 400px;" class="map_city" id="mapId"></div>
                            </div>
                        </div>


                    </div>

                </div>

            </div>
        </div>
    </div>
    {!! Html::script('assets/web/js/favorite.js') !!}
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAPUTGhVxI4piPZBg8wXT587e9EzDOar5w&libraries=places&callback=initMap"
            async defer></script>
    <?php include(base_path('resources/views/layouts/jquery_pages/detail_maps.blade.php'));?>
    {!! Html::script('assets/web/js/jquery.rateyo.min.js') !!}
    {!! Html::script('assets/web/js/icheck.js') !!}
    {{--    @include('layouts.jquery_pages.detail_script');--}}
    <script>
        $(document).on('click','.rateit-range',function () {
            var rating_value=$(this).attr('aria-valuenow');
            $('#rating_star').val(rating_value);
            //alert(rating_value);
        })
    </script>
    <!-- <script>
  $(document).ready(function(){
    $('#reviewBtn').click(function(event){
      slert('fsdfs')
     event.preventDefault();
    })
  })
</script> -->
    <script src="{{ asset('js/share.js') }}"></script>
@endsection