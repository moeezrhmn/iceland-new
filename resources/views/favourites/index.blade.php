@extends('layouts.app')
<link rel="stylesheet" type="text/css" href="{{url('assets/admin/js/autocomplete/jquery-ui.css')}}">
<style>
    .main_slider.bg_slider.bgSliderCustom {
        height: 0px;
        min-height: 306px;
    }
    #unfavorite {
        display: none;
    }
    .search_wrapper.searchWrapper {
        bottom: 20%;
        padding: 20px 20px 4px 20px;
    }
</style>
@section('content')

    <div class="intro_header">
        <div class="main_content">
        <div class="container" style="margin-top: 100px;">
            <div class="row">
                <div class="grid_section text-center">
                    <h2><span>My Favourites</span></h2>
                    <p>Explore the world’s most extensive selection of things to see and do in Iceland</p>
                    <h3 style="float: left; margin-left: -25px;"><span style="font-size: 25px">Book Your Adventures</span></h3>
                    <br><br>
                    <div class="grid_content myOrders_grid row wow fadeIn" data-wow-duration="1s" data-wow-delay=".5s">
                        @if(!empty($activities))
                            @foreach($activities as $values)
                                <div class="col-lg-3 col-md-4 col-sm-6 wow fadeInLeft activityGridListing" data-wow-duration="1s" data-wow-delay=".5s">
                                    <!-- <div class="activityGridItem"> -->
                                    <a href="{{url('activities/detail/'.$values['slug'])}}" style="overflow: visible;">
                                        <span class="post_time">{{$values['duration']}}</span>
                                        <div class="d-flex justify-content-center img_wrapper">
                                            @if(isset($values->photo)&& !empty($values->photo))
                                                <img src="{{ url('uploads/activities/'.$values->photo) }}" alt="{{$values['name']}}">
                                            @else
                                                <img src="{{ url('images/no-image.png') }} "  alt="{{$values['name']}}">
                                            @endif
                                            <div class="d-flex justify-content-center align-items-center hover_txt">
                                                <p>{{ strip_tags( substr( $values['description'],0,100) ) }}
                                                    <span>read more...</span>
                                                </p>
                                            </div>
                                            {{--<span>May - Oct</span>--}}
                                        </div>

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

                                        <span class="place_name">{{$values['name']}}</span>

                                    </a>
                                {{--<div class="action_btns">--}}
                                {{--<a href="results.html"><i class="fas fa-edit"></i></a>--}}
                                {{--<a href="javascript:void(0);" favid="{{$values->id}}" class="delete_order"><i class="fas fa-trash"></i></a>--}}
                                {{--</div>--}}
                                <!-- </div> -->


                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="grid_section text-center">
                    <h3 style="float: left; margin-left: -25px;"><span style="font-size: 25px">Restaurants</span></h3>
                    <br><br>
                    <div class="grid_content myOrders_grid row wow fadeIn" data-wow-duration="1s" data-wow-delay=".5s">
                        @if(!empty($restaurants))
                            @foreach($restaurants as $obj)
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <a href="{{url('restaurants/detail/'.$obj->slug)}}">

                                        <div class="d-flex justify-content-center img_wrapper">
                                            <img src="{{asset('uploads/'.$obj->photo)}}">
                                            <div class="d-flex justify-content-center align-items-center hover_txt">
                                                {{--<p> {{str_limit(strip_tags(trim($obj->description)),80, '...')}} <span>read more...</span></p>--}}
                                            </div>
                                            <span class="place_name" style="text-align: center;">{{$obj->name}}</span>
                                        </div>
                                        {{-- <div class="select_plan">


                                             <span>From: <strong>{{$obj->price}}</strong></span>
                                             <select class="selectpicker">
                                                 <option>USD</option>
                                                 <option>EUR</option>
                                                 <option>YEN</option>
                                             </select>
                                         </div>--}}
                                        {{--<span class="place_name">{{$obj->name}}</span>--}}

                                    </a>
                                    <div class="action_btns">
                                        {{--<a href="results.html"><i class="fas fa-edit"></i></a>--}}
                                        <a href="javascript:void(0);" favid="{{$obj->id}}" class="delete_order"><i class="fas fa-trash"></i></a>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="grid_section text-center">
                    <h3 style="float: left; margin-left: -25px;"><span style="font-size: 25px">Places Of Interests</span></h3>
                    <br><br>
                    <div class="grid_content myOrders_grid row wow fadeIn" data-wow-duration="1s" data-wow-delay=".5s">
                        @if(!empty($places))
                            @foreach($places as $obj)

                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <a href="{{url('places/detail/'.$obj->slug)}}">

                                        <div class="d-flex justify-content-center img_wrapper">
                                            <img src="{{asset('uploads/'.$obj->photo)}}">
                                            <div class="d-flex justify-content-center align-items-center hover_txt">
                                                {{--<p> {{str_limit(strip_tags(trim($obj->description)),80, '...')}} <span>read more...</span></p>--}}
                                            </div>
                                            <span class="place_name" style="text-align: center;">{{$obj->name}}</span>
                                        </div>
                                        {{-- <div class="select_plan">
                                             <span>From: <strong>{{$obj->price}}</strong></span>
                                             <select class="selectpicker">
                                                 <option>USD</option>
                                                 <option>EUR</option>
                                                 <option>YEN</option>
                                             </select>
                                         </div>--}}
                                        {{--<span class="place_name">{{$obj->name}}</span>--}}

                                    </a>
                                    <div class="action_btns">
                                        {{--<a href="results.html"><i class="fas fa-edit"></i></a>--}}
                                        <a href="javascript:void(0);" favid="{{$obj->id}}" class="delete_order"><i class="fas fa-trash"></i></a>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>

    <input type="hidden" value="{{Auth::id()}}" id="auth_user_login" name="">
    {!! Html::script('assets/web/js/favorite.js') !!}
<!--    --><?php //include(base_path('assets/web/pages/searchMpas.php'));?>
    <script>
        $(document).ready(function () {
            $('.delete_order').click(function () {
                var favid=$(this).attr('favid');
               // alert(favid)
                $.ajax({
                    type:"GET",
                    url:web_url+"/favourites/removefavorite",
                    data:{favid:favid},

                    success:function(o){

                    }
                });
            })
        })
    </script>

    <!-- auto complete end -->

@endsection