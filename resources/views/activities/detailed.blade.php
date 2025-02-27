@extends('layouts.app')
@section('title', @$item->activity_name)

@section('style')
{!! Html::style('assets/web/css/jquery.rateyo.min.css') !!}
<style>
    .btn.nav-link {
        margin-bottom: 5px;
        padding-left: 1.5px;
    }
    .shareSocialLi{
        z-index: 99;
        position: relative;
        width: 75px;
    }
    #social-links {
        position: fixed;
        top: 40%;
    }
    .shareSocialLi{
        z-index: 99;
        position: relative;
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
@endsection

@section('content')
<div class="main_wrapper">
    <div class="description_wrapper">
        <div id="social-links">

            <ul>
                <li class="shareSocialLi"><a href="https://www.facebook.com/sharer/sharer.php?u={{url()->current()}}&image={{@$item->photo[0]->photo}}&text={{@$item->description}}" class="social-button " id="">
                        <i class="fa fa-facebook"></i></a></li>
                <li class="shareSocialLi"><a href="https://twitter.com/intent/tweet?text={{@$item->activity_name}};&image={{@$item->photo[0]->photo}}url={{url()->current()}}" class="social-button " id="">
                        <i class="fa fa-twitter"></i></a></li>
                <li class="shareSocialLi"><a href="https://plus.google.com/share?url={{url()->current()}}&image={{@$item->photo[0]->photo}}" class="social-button " id="">
                        <i class="fa fa-google"></i></a></li>
                {{--<li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=http://jorenvanhocht.be&amp;title=my share text&amp;summary=dit is de linkedin summary" class="social-button " id=""><span class="fa fa-linkedin"></span></a></li>--}}
            </ul>
        </div>
        <div class="container">
            <h2>{{@$item->activity_name}}</h2>
            <img src="{{url('images/map-pink.png')}}" style="margin-left: -1px;" alt="No marker"><p style="margin-bottom: 0rem;margin-left: 30px;margin-top: -20px;">
                <a href="javascript:void(0);">{{@$item->address->address}}</a></p> <br>
            <div class="row">
                @if(!empty($item->website_url))
                    <div class="col-md-2">
                        <a href="{{@$obj->website_url}}"><i class="fa fa-chrome"></i></a>
                    </div>
                @endif
              {{--  @if(!empty($item->social_1))
                    <div class="col-md-2">
                        <a href="{{@$item->social_1}}"><i class="fa fa-facebook-f"></i></a>
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
                @endif--}}
            </div>
            {{--<div id="bokun-w10907_9c63e30b_b811_4c3e_8922_884876727926">Loading...</div>--}}
            {{--<script type="text/javascript">--}}
                {{--var w10907_9c63e30b_b811_4c3e_8922_884876727926;--}}
                {{--(function (d, t) {--}}
                    {{--var host = 'widgets.bokun.io';--}}
                    {{--var frameUrl = 'https://' + host + '/widgets/10907?bookingChannelUUID=9d1c7257-c452-49e1-a2ee-79b0275ea726&amp;activityId='+{{$item->product_id}}+--}}
                    {{--'&amp;lang=en&amp;ccy=USD&amp;hash=w10907_9c63e30b_b811_4c3e_8922_884876727926';--}}
                    {{--var s = d.createElement(t), options = {--}}
                        {{--'host': host,--}}
                        {{--'frameUrl': frameUrl,--}}
                        {{--'widgetHash': 'w10907_9c63e30b_b811_4c3e_8922_884876727926',--}}
                        {{--'autoResize': true,--}}
                        {{--'height': '',--}}
                        {{--'width': '100%',--}}
                        {{--'minHeight': 0,--}}
                        {{--'async': true,--}}
                        {{--'ssl': true,--}}
                        {{--'affiliateTrackingCode': '',--}}
                        {{--'transientSession': true,--}}
                        {{--'cookieLifetime': 43200--}}
                    {{--};--}}
                    {{--s.src = 'https://' + host + '/assets/javascripts/widgets/embedder.js';--}}
                    {{--s.onload = s.onreadystatechange = function () {--}}
                        {{--var rs = this.readyState;--}}
                        {{--if (rs) if (rs != 'complete') if (rs != 'loaded') return;--}}
                        {{--try {--}}
                            {{--w10907_9c63e30b_b811_4c3e_8922_884876727926 = new BokunWidgetEmbedder();--}}
                            {{--w10907_9c63e30b_b811_4c3e_8922_884876727926.initialize(options);--}}
                            {{--w10907_9c63e30b_b811_4c3e_8922_884876727926.display();--}}
                        {{--} catch (e) {--}}
                        {{--}--}}
                    {{--};--}}
                    {{--var scr = d.getElementsByTagName(t)[0], par = scr.parentNode;--}}
                    {{--par.insertBefore(s, scr);--}}
                {{--})(document, 'script');--}}
            {{--</script>--}}
            <!-----End code here--->
            <div id="description" class="main_content">
                <div class="row">
                    <div class="col-lg-8 col-sm-12">
                        <div class="image_gallery">
                            <ul id="image-gallery" class="gallery list-unstyled cS-hidden">
                                @if(sizeof($item->photo) )
                                    @foreach($item->photo  as $row )
                                        <li data-thumb="{{ url('uploads/activities'.$row['photo']) }}">
                                        {{--<li data-thumb="{{ asset('images/page1.jpg') }}" style="max-height: 100px;">--}}
                                            <img src="{{ url('uploads/activities'.@$row['photo']) }}" alt="{{@$item->activity_name}}" {{-- style="max-height: 100px;"--}}>
                                            {{--<img src="{{ asset('images/page1.jpg') }}">--}}
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="row rate_like">
                            {{--<div class="col d-flex justify-content-start social_like">
                                <a href="#"><img src="{{url('images/like.png')}}"></a>
                            </div>--}}
                            <div class="col d-flex justify-content-end">
                                @if(isset($item->reviews_avg->rating) && !empty($item->reviews_avg->rating))
                                    <span>Rate Us</span>
                                    {{--<span class="rateit"></span>--}}
                                    <div class="rating">
                                        <?php
                                        $i = 0;
                                        ?>
                                        <div class="rateYo-{{$i}}"></div>
                                        <small>
                                        </small>
                                        <?php
                                        if ($item->reviews_avg->rating > 5) {
                                            // echo 'greater';
                                            $star_rating = '5';
                                        } else {
                                            // echo 'less';
                                            $star_rating = @$item->reviews_avg->rating;
                                        }
                                        ?>
                                    </div>
                                    <script>
                                        $(document).ready(function () {
                                            showRating('<?php echo $i?>', '<?=@$star_rating?>');
                                        });
                                    </script>
                                @endif
                            </div>
                        </div>
                        <input type="hidden" value="{{Auth::id()}}" id="auth_user_login" name="">
                        <div class="tab_content">

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
                                         content="{{@$item->category_id}}" class="favorite" style="background: #02529C;color: white;display: none" >
                                        <a class="btn  nav-link btn_full_outline fav" style="background: #02529C;color: white; text-align:center;"
                                           href="javascript:void(0)">
                                            <i class=" icon-heart"></i> Add Favorites</a>
                                    </div>
                                    @if(isset($favoruite->id) && !empty($favoruite->id))
                                        <div id="unfavorite-{{@$item->id}}" class="">
                                            <a class="btn nav-link btn-danger btn_full_outline unfavorite"
                                               content="{{@$item->category_id}}"
                                               data-action="{{@$item->id}}" href="javascript:void(0)" style="text-align:center;">
                                                <i class=" icon-heart"></i> Remove Favorites</a>
                                         </div>
                                    @else
                                        <div id="favorite-{{@$item->id}}" class="">
                                            <a class="btn  nav-link btn_full_outline favorite"
                                               style="background: #02529C;text-align:center;color: white" content="{{@$item->category_id}}"
                                               data-action="{{@$item->id}}" href="javascript:void(0)" style="text-align:center;">
                                                <i class=" icon-heart"></i> Add Favorites</a>

                                        </div>
                                @endif
                                <!-- add to favorit end -->
                                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                         aria-orientation="vertical">
                                        <a class="nav-link active" id="v-pills-description-tab" data-toggle="pill"
                                           href="#v-pills-description" role="tab"
                                           aria-controls="v-pills-description" aria-selected="true" style="text-align:center;">Description</a>
                                        {{--<a class="nav-link" id="v-pills-facts-tab" data-toggle="pill"--}}
                                           {{--href="#v-pills-facts" role="tab" aria-controls="v-pills-facts"--}}
                                           {{--aria-slected="false">Quick Facts</a>--}}
                                        <a class="nav-link" id="v-pills-map-tab" data-toggle="pill"
                                           href="#v-pills-map" role="tab" aria-controls="v-pills-map"
                                           aria-selected="false" style="text-align:center;">Map</a>
                                      <!--  <a class="nav-link" id="v-pills-video-tab" data-toggle="pill"
                                           href="#v-pills-video" role="tab" aria-controls="v-pills-video"
                                           aria-selected="false" style="text-align:center;">Video</a>-->
                                        <a class="nav-link" id="v-pills-reviews-tab" data-toggle="pill"
                                           href="#v-pills-reviews" role="tab" aria-controls="v-pills-reviews"
                                           aria-selected="false" style="text-align:center;">Reviews</a>
                                    </div>
                                </div>
                                <div class="col-lg-9 col-sm-12">
                                    <div class="tab-content" id="v-pills-tabContent">
                                        <div class="tab-pane fade show active" id="v-pills-description"
                                             role="tabpanel" aria-labelledby="v-pills-description-tab">
                                            <h4>{{@$item->$activity_name}}</h4>
                                        @php //dd($item->description); @endphp
                                            <p>{!!@$item->description!!}</p>
                                           {{--<div>--}}
                                            {{--<div>{{strip_tags(@$item->description)}}</div>--}}
                                            <!-- <h4>Heading title</h4>
                                             <p>Once you reach the crater, you will find an opening and an elevator crane. After being equipped with a helmet and harness, you will enter the lift's basket and begin your descent. Nowhere else in the world can you enter a magma chamber this way, which is part of what makes this tour so unique and worthwhile. This lift journey toward the centre of the earth covers 198 metres and takes about six minutes.</p> -->
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-facts" role="tabpanel"
                                             aria-labelledby="v-pills-facts-tab">
                                            <div class="info_section border-bottom">
                                                <h4>Tour information:</h4>
                                                <ul>
                                                    <li>
                                                        <strong>Available</strong>
                                                        <span>May. - Oct. </span>
                                                    </li>
                                                    <li>
                                                        <strong>Duration</strong>
                                                        <span>6 hours</span>
                                                    </li>
                                                    <li>
                                                        <strong>Activities</strong>
                                                        <span>Caving</span>
                                                    </li>
                                                    <li>
                                                        <strong>Difficulty</strong>
                                                        <span>Moderate</span>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="info_section border-bottom">
                                                <h4>Pickup information:</h4>
                                                <ul>
                                                    <li>
                                                        <strong>Pickup time :</strong>
                                                        <span>	07:30 08:30, 09:30, 10:30, 11:30, 12:30, 13:30, 14:30, 15:30, 16:30,</span>
                                                        <p>Please be at your pickup location in time for your
                                                            departure. Should your pickup location be at a bus stop
                                                            and you need assistance finding it, seek guidance in
                                                            your Hotel's reception or contact your tour provider
                                                            directly.</p>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="info_section styled_list">
                                                <h4>Included:</h4>
                                                <ul>
                                                    <li>
                                                        <span>Pick-up from and return to your accommodation in Reykjavik</span>
                                                    </li>
                                                    <li>
                                                        <span>All safety gear (helmets, harness, etc.)</span>
                                                    </li>
                                                    <li>
                                                        <span>Small refreshments (soup, coffee/tea and perhaps some sweets)</span>
                                                    </li>
                                                    <li>
                                                        <span>Experienced guides</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>


                                        <div class="tab-pane fade custom_iframe"
                                             style="height: 100%;margin: 0;padding: 0;" id="v-pills-map"
                                             role="tabpanel"
                                             aria-labelledby="v-pills-map-tab">

                                            <div class="col-md-12 map-right hidden-sm hidden-xs">
                                                <!-- <div style="height: 400px;" class="map_city" id="mapId"></div> -->
                                                <div style="height: 400px;" class="map_city" id="mapId"></div>

                                            </div>
                                        </div>
                                        <div class="tab-pane fade custom_iframe" id="v-pills-video" role="tabpanel"
                                             aria-labelledby="v-pills-video-tab">
                                            <iframe src="https://www.youtube.com/embed/mPBaqh3dcVM?rel=0"
                                                    frameborder="0" allow="autoplay; encrypted-media"
                                                    allowfullscreen>

                                            </iframe>
                                        </div>

                                        <div class="tab-pane fade user_reviews" id="v-pills-reviews" role="tabpanel"
                                             aria-labelledby="v-pills-reviews-tab">
                                            <ul class="list-unstyled">
                                                @if(!empty($reviews))
                                                    @foreach($reviews as $review)
                                                        <li class="media">
                                                            <img class="mr-3"
                                                                 src="{{url('uploads/'.$review->user_detail->user_photo)}}"
                                                                 alt="Generic placeholder image">
                                                            <div class="media-body" style="margin-left: 30px;">
                                                                <h4 class="mt-0 mb-1">{{$review->user_detail->first_name}} {{$review->user_detail->last_name}}</h4>
                                                                <p>{{$review->comment}}</p>
                                                            </div>
                                                        </li>
                                                @endforeach
                                            @endif
                                            </ul>
                                                <!--   <li class="media my-4">
                                                    <img class="mr-3" src="{{url('images/0.jpg')}}"
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
                                                    <img class="mr-3" src="{{url('images/0.jpg')}}"
                                                         alt="Generic placeholder image">
                                                    <div class="media-body">
                                                        <h4 class="mt-0 mb-1">List-based media object</h4>
                                                        <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel
                                                            metus scelerisque ante sollicitudin.</p>
                                                    </div>
                                                </li> -->
                                            <!-- <div class="checkout_wrapper">
                                                <form class="add_review">
                                                    <textarea class="form-control"
                                                              placeholder="Add your review here..."
                                                              rows="3"></textarea>
                                                    <button type="submit" class="btn hvr-float-shadow view_all">
                                                        Submit review
                                                    </button>
                                                </form>
                                            </div> -->
                                            <div class="checkout_wrapper">
                                                @if(Auth::id())
                                                    <form class="add_review" action="{{url('review/store')}}" method="post">
                                                        @csrf
                                                        @else
                                                   <form class="add_review" action="javascript:void(0);"  method="post">
                                                @endif
                                                                <span class="rateit" style=""></span>
                                                                <input type="hidden" name="rating_star"
                                                                       id="rating_star">

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
                                                                           value="3">
                                                                @endif
                                                                @if(Auth::id())
                                                                    <button type="submit"
                                                                            class="btn hvr-float-shadow view_all itsbtn">
                                                                        Submit review
                                                                    </button>
                                                                @else
                                                                    <button data-toggle="modal" id="reviewBtn"
                                                                            data-target=".user_login"
                                                                            class="btn hvr-float-shadow view_all itsbtn">
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

                    <div class="col-lg-4 col-sm-12">
                        <!-----start code here--->

                        <div id="bokun-w10907_7d30f0d9_cb98_4483_8082_6c3af92c89eb">Loading...</div>
                        <script type="text/javascript">
                            var w10907_7d30f0d9_cb98_4483_8082_6c3af92c89eb;
                            (function(d, t) {
                                var host = 'widgets.bokun.io';
                                var frameUrl = 'https://' + host + '/widgets/10907?bookingChannelUUID=9d1c7257-c452-49e1-a2ee-79b0275ea726&amp;activityId='+{{$item->product_id}}+'&amp;lang=en&amp;ccy=USD&amp;hash=w10907_7d30f0d9_cb98_4483_8082_6c3af92c89eb';
                                var s = d.createElement(t), options = {'host': host, 'frameUrl': frameUrl, 'widgetHash':'w10907_7d30f0d9_cb98_4483_8082_6c3af92c89eb', 'autoResize':true,'height':'450','width':'500', 'minHeight': 450,'async':true, 'ssl':true, 'affiliateTrackingCode': '', 'transientSession': true, 'cookieLifetime': 43200 };
                                s.src = 'https://' + host + '/assets/javascripts/widgets/embedder.js';
                                s.onload = s.onreadystatechange = function() {
                                    var rs = this.readyState; if (rs) if (rs != 'complete') if (rs != 'loaded') return;
                                    try {
                                        w10907_7d30f0d9_cb98_4483_8082_6c3af92c89eb = new BokunWidgetEmbedder(); w10907_7d30f0d9_cb98_4483_8082_6c3af92c89eb.initialize(options); w10907_7d30f0d9_cb98_4483_8082_6c3af92c89eb.display();
                                    } catch (e) {}
                                };
                                var scr = d.getElementsByTagName(t)[0], par = scr.parentNode; par.insertBefore(s, scr);
                            })(document, 'script');
                        </script>
                        <!------------->

                        <div class="row" style="margin-top: 50px;">
                            {{--<div class="col-md-8"></div>--}}
                            <div class="col-md-12 pull-right">
                                <div class="row">
                                    <div class="col-md-2">
                                        <a href=""><i class="fa fa-google"></i></a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href=""><i class="fa fa-facebook"></i></a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href=""><i class="fa fa-twitter"></i></a>
                                    </div>
                                    <div class="col-md-2">
                                        <a href=""><i class="fa fa-instagram"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <style>
                        @media screen and (max-width: 440px){
                            .itsbtn{
                                margin-top: 10px;
                            }
                        }

                    </style>


                    {{--<div class="col-lg-4 col-sm-12">--}}

                        {{--<div class="sidebar_content border">--}}
                            {{--<h4>Reserve this tour</h4>--}}
                            {{--<p>Continue to reserve a spot on this trip. You can contact us any time to change your--}}
                                {{--booking. Choose a date to find availability and see prices </p>--}}
                            {{--<div class="form-group">--}}
                                {{--<input id="datetimepicker" class="datepicker form-control"--}}
                                       {{--placeholder="Choose a date" type="text">--}}
                            {{--</div>--}}
                            {{--<div class="select_plan ">--}}
                                {{--<span class="from">From: <strong>{{$item->price}}</strong></span>--}}
                                {{--<select class="selectpicker">--}}
                                    {{--<option value="USD">USD</option>--}}
                                    {{--<option value="AUD">AUD</option>--}}
                                    {{--<option value="CAD">CAD</option>--}}
                                    {{--<option value="CHF">CHF</option>--}}
                                    {{--<option value="DKK">DKK</option>--}}
                                    {{--<option value="EUR">EUR</option>--}}
                                    {{--<option value="GBP">GBP</option>--}}
                                    {{--<option value="HKD">HKD</option>--}}
                                    {{--<option value="ISK">ISK</option>--}}
                                    {{--<option value="JPY">JPY</option>--}}
                                    {{--<option value="KRW">KRW</option>--}}
                                    {{--<option value="NOK">NOK</option>--}}
                                    {{--<option value="PLN">PLN</option>--}}
                                    {{--<option value="RUB">RUB</option>--}}
                                    {{--<option value="SEK">SEK</option>--}}
                                    {{--<option value="SGD">SGD</option>--}}
                                {{--</select>--}}

                            {{--</div>--}}


                            {{--<a href="{{url('activity/checkout')}}" class="hvr-float-shadow view_all addToYourList"--}}
                            {{--<a href="javascript:void(0);" class="hvr-float-shadow view_all addToYourList"--}}
                               {{--data-action="{{@$item->id}}">add to your list</a>--}}
                            {{--<div class="tour_features">--}}
                                {{--<ul>--}}
                                    {{--<li><span data-toggle="tooltip" data-placement="bottom" title="Tooltip title">Free cancellation</span>--}}
                                    {{--</li>--}}
                                    {{--<li><span data-toggle="tooltip" data-placement="bottom" title="Tooltip title">Free pickup</span>--}}
                                    {{--</li>--}}
                                    {{--<li><span data-toggle="tooltip" data-placement="bottom" title="Tooltip title">No credit card fees</span>--}}
                                    {{--</li>--}}
                                    {{--<li><span data-toggle="tooltip" data-placement="bottom" title="Tooltip title">No booking fees</span>--}}
                                    {{--</li>--}}
                                {{--</ul>--}}
                            {{--</div>--}}

                        {{--</div>--}}
                        {{--<a href="#" class="hvr-float-shadow view_all">terms of service</a>--}}
                        {{--<a href="#" class="hvr-float-shadow view_all">inquire about this tour</a>--}}
                        {{--<!--   <div class="row" style="margin:0;padding:0;">--}}
                     {{--<div class="col-lg-12" id="map_map" style="height:100%;">--}}
                         {{--dsafasfgsadhgsaldghsa;fshgfhsadfsjkl;adf--}}
                     {{--</div>--}}
                 {{--</div> -->--}}
                    {{--</div>--}}

                </div>

            </div>

        </div>
    </div>
</div>

<!-- review modal  -->
<!-- BEGIN SIDEBAR -->
{!! Html::script('assets/web/js/favorite.js') !!}
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCR43v6jvHEpZN4QAd3mck0AIrkC2P1g0U&libraries=places"
        async defer></script>
<?php include(base_path('resources/views/layouts/jquery_pages/detail_maps.blade.php'));?>

{{--@include('layouts.jquery_pages.detail_script');--}}
<!--    --><?php //include('layouts/jquery_pages/place_detail_script.php'); ?>
<!-- Specific scripts -->

{!! Html::script('assets/web/js/icheck.js') !!}

<script type="text/javascript">
    $(document).ready(function ($) {
        $(".addToYourList").click(function () {
            var a = $(this).attr("data-action");
            // var _token = $("input[name='_token']").val();
            var user = $("#auth_user_login").val();
            var date = $(".datepicker ").val();
            // alert(date);

            if (date != '') {
                $.ajax({
                    type: "GET",
                    url: web_url + "/activities/add-cart",
                    data: {instance_id: a},
                    success: function (data) {
                        if (data != '') {
                            var val = $('.getCatCount').text();
                            var newValue = parseInt(data);
                            $('.getCatCount').html(newValue);

                            //''window.location = web_url+"/activity/checkout";
                        }
                    }
                });
            } else {
                // $('.xdsoft_datetimepicker').css({'display':'block'});
                alert('Please Choose Date First');
            }


            // rateit-range-3
        });
        $(document).on('click', '.rateit-range', function () {
            var rating_value = $(this).attr('aria-valuenow');
            $('#rating_star').val(rating_value);
            //alert(rating_value);
        })
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {

        {{--setTimeout(function () {--}}
            {{--//alert('dddddd'+{{$item->product_id}});--}}
           {{--// alert($("iframe").contents().activity - selector.html());--}}
            {{--//  alert(   $(".activity-selector").html());--}}

        {{--}, 6000);--}}

        // .activity-selector

    });

</script>

@endsection