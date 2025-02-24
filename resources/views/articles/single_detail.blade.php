@extends('layouts.app')
<style>
    .cardTextCustom{
        color: gray;
        font-size: 18px;
    }
</style>
@section('content')


    <div class="main_wrapper">
        <div class="intro_header">

            <div class="main_content">
                <div class="container">
                    <div class="row">
                        <div class="grid_section bloggers search_results text-center">

                            <h2><span>{{@$data->title}}</span></h2>
                            {{--<h2><span>Detailed Information</span></h2>--}}
                            <p>Contact a local for insider travel information and personal recomendations
                            </p>
                            <div class="grid_content row">

                                <div class="col-sm-12">
                                    <div class="card text-left">

                                        <img class="card-img-top" src="{{ url('public/uploads/'.@$data->single_photo->photo) }}"

                                             alt="Card image cap">
                                        @php //dd($data->single_photo->photo); @endphp
                                        <div class="card-body">

                                            <div class="media-body">
                                                {{--<div class="rateit float-right" style="padding: 6px;"></div>--}}
                                                <h4>{{@$data->$title}}</h4>
                                                {{--<p>--}}
                                                    {{--<img src="{{url('public/images/map-pink.png')}}">--}}
                                                    {{--<span>0.5 mi to Sydney center</span>--}}
                                                {{--</p>--}}
                                                <ul>

                                                    @if(!empty($data->keywords))
                                                        @foreach($data->keywords as $key=> $keyword)
                                                            <li class="text-capitalize">
                                                                {{--<strong>1</strong> --}}{{$keyword->keyword_name}}
                                                            </li>
                                                            @break($key==3)
                                                            {{--@continue($keyword==3)--}}
                                                        @endforeach
                                                    @endif
                                                   {{-- <li>
                                                        <strong>1</strong> BA
                                                    </li>
                                                    <li>
                                                        <strong>538</strong> sq. ft.
                                                    </li>
                                                    <li>Sleeps
                                                        <strong>6</strong>
                                                    </li>--}}
                                                </ul>
                                               <div class="search_reviews">

                                                    {{-- <div class="float-right">
                                                        <a href="checkout.html" class="hvr-float-shadow view_all">Book
                                                            Now</a>
                                                    </div>
                                                    <small class="text-success">Very Good! 4.2/5</small>
                                                    <h5>$137 per night</h5>--}}
                                                    <div class="clearfix">
                                                    </div>
                                                    <p class="pt-3 card-text cardTextCustom">{!!@$data->description!!}</p>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <span>Publish By : <strong>{{@$data->publish_by}}</strong></span>
                                                            <p>Publish On : <a href="{{@$data->publish_on}}">{{@$data->publish_on}}</a></p>
                                                        </div>
                                                        <div class="col-md-6">

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>


@endsection