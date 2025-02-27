@extends('layouts.app')

@section('content')


    <div class="main_wrapper">
        <div class="description_wrapper">
            <div class="container">
               
                <h1>{{@$item->restaurant_name}}</h1>


                <div id="description" class="main_content">
                   
                    <div class="row">
                        <div class="col-lg-8 col-sm-12">
                            <div class="image_gallery">
                                <ul id="image-gallery" class="gallery list-unstyled cS-hidden">
                                    @if(sizeof($item->photo) )
                                        @foreach($item->photo  as $row )
                                            <li data-thumb="{{ url('uploads/'.@$row->photo) }}">
                                                <img src="{{ url('uploads/'.@$row->photo) }}">
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            <div class="row rate_like">
                                <div class="col d-flex justify-content-start social_like">
                                    <a href="#"><img src="{{url('images/like.png')}}"></a>
                                </div>
                                <div class="col d-flex justify-content-end">
                                    <span>Rate Us</span>
                                    <span class="rateit"></span>
                                </div>
                            </div>
                            <div class="tab_content">
                                <div class="row">
                                    <div class="col-lg-3 col-sm-12 border-right">
                                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                             aria-orientation="vertical">
                                            <a class="nav-link active" id="v-pills-description-tab" data-toggle="pill"
                                               href="#v-pills-description" role="tab"
                                               aria-controls="v-pills-description" aria-selected="true">Description</a>
                                            {{--<a class="nav-link" id="v-pills-facts-tab" data-toggle="pill"--}}
                                               {{--href="#v-pills-facts" role="tab" aria-controls="v-pills-facts"--}}
                                               {{--aria-slected="false">Quick Facts</a>--}}
                                            <!-- <a class="nav-link" id="v-pills-map-tab" data-toggle="pill"
                                               href="#v-pills-map" role="tab" aria-controls="v-pills-map"
                                               aria-selected="false">Map</a> -->
                                            <a class="nav-link" id="v-pills-video-tab" data-toggle="pill"
                                               href="#v-pills-video" role="tab" aria-controls="v-pills-video"
                                               aria-selected="false">Video</a>
                                            <a class="nav-link" id="v-pills-reviews-tab" data-toggle="pill"
                                               href="#v-pills-reviews" role="tab" aria-controls="v-pills-reviews"
                                               aria-selected="false">Reviews</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-9 col-sm-12">
                                        <div class="tab-content" id="v-pills-tabContent">
                                            <div class="tab-pane fade show active" id="v-pills-description"
                                                 role="tabpanel" aria-labelledby="v-pills-description-tab">
                                                <h4>{{@$item->restaurant_name}}</h4>
                                                <p>{!!@$item->description!!}</p>
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
                                                        <img class="mr-3" src="{{url('uploads/'.$review->user_detail->user_photo)}}"
                                                             alt="Generic placeholder image">
                                                        <div class="media-body">
                                                            <h4 class="mt-0 mb-1">{{$review->user_detail->first_name}} {{$review->user_detail->last_name}}</h4>
                                                            <p>{{$review->comment}}</p>
                                                        </div>
                                                    </li>
                                                    @endforeach
                                                    @endif
                                                   <!--  <li class="media my-4">
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
                                                </ul>
                                                <div class="checkout_wrapper">
                                                  @if(Auth::id())
                                                    <form class="add_review"  action="{{url('review/store')}}" method="post">
                                                        @csrf
                                                      @else
                                                         <form class="add_review"  action="javascript:void(0);" method="post">
                                                      @endif
                                                    
                                                        <textarea class="form-control" name="comment" 
                                                                  placeholder="Add your review here..."
                                                                  rows="3"></textarea>
                                                                  <input type="hidden" name="instance_id" value="{{@$item->id}}">
                                                                   <input type="hidden" name="category_id" value="2">
                                                                  @if(Auth::id())
                                                        <button type="submit" class="btn hvr-float-shadow view_all">
                                                            Submit review
                                                        </button>
                                                        @else
                                                        <button data-toggle="modal" id="reviewBtn" data-target=".user_login" class="btn hvr-float-shadow view_all">
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAPUTGhVxI4piPZBg8wXT587e9EzDOar5w&libraries=places&callback=initMap" async defer></script>

 <?php include(base_path('resources/views/layouts/jquery_pages/detail_maps.blade.php'));?>


<!-- <script>
  $(document).ready(function(){
    $('#reviewBtn').click(function(event){
      slert('fsdfs')
     event.preventDefault();
    })
  })
</script> -->
@endsection