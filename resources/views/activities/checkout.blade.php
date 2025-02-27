@extends('layouts.app')
{{--{!! Html::style('assets/web/css/jquery.rateyo.min.css') !!}--}}
@section('style')
<style type="text/css">
    .error{
        color:red !important;
    }
    </style>
@endsection

@section('content')

    <div class="main_wrapper">
        <div class="order_container">
            <div class="container">
                <div class="row">
                    <div class="grid_section">
                        <h2 class="text-center">
                            <span>Checkout</span>
                        </h2>
                        <div class="checkout_wrapper">
                            {{--@php--}}
                                {{--dump($errors);--}}
                                {{--dump($errors->all() );--}}


                            {{--@endphp--}}
                            @if(Session::has('message'))
                                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                            @endif
                            @if($errors)

                                {{--@foreach ($errors as $error)--}}
                                    {{--<div>{{ $error }}</div>--}}
                                {{--@endforeach--}}
                            @endif

                            <div class="row">
                                <div class="col-md-8 col-12 border-right">
                                    <h5 class="mb-3">Payment Details</h5>
                                    <form name="checkout_form" method="post" action="{{url('checkout')}}" id="checkout_form">
                                        {{ csrf_field() }}

                                        <input  type="hidden" name="sessionId" value="{{$sessionId}}" id="sessionId">
                                        <input  type="hidden" name="amount" value="{{$item->options[0]->amount}}" id="amount">
                                        <input  type="hidden" name="currency" value="{{$item->options[0]->currency}}" id="currency">
                                        <input  type="hidden" name="uti" value="{{$item->options[0]->paymentMethods->cardProvider->uti}}" id="uti">

                                        <input  type="hidden" name="checkout_data" value="{{$result}}" id="checkout_data">

                                        {{--@if(isset($item->questions->activityBookings))--}}
                                            {{--@foreach($item->questions->activityBookings as $activityBookings)--}}
                                        {{--<input  type="hidden" name="activityBookings[]" value="@php $activityBookings @endphp" id="activityBookings">--}}
                                            {{--@endforeach--}}
                                            {{--@endif--}}

                                        {{--<div class="row">--}}
                                            {{--<div class="form-group col-md-6">--}}
                                                {{--<input type="text" name="first_name" class="form-control" id="first_name" placeholder="First name">--}}
                                            {{--</div>--}}
                                            {{--<div class="form-group col-md-6">--}}
                                                {{--<input type="text" name="last_name" class="form-control" id="last_name" placeholder="Last name">--}}
                                            {{--</div>--}}
                                        {{--</div>--}}

                                        <div class="row">
                                            <div class="form-group col-6">
                                                <input type="text" name="first_name" class="form-control" id="first_name" placeholder="Name">
                                            </div>
                                            <div class="form-group col-6">
                                                <input type="email" name="email" class="form-control" id="email" placeholder="Email">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <input type="text" name="city" class="form-control" placeholder="City" id="city">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <input type="text" class="form-control" name="card_number" id="card_number"  placeholder="Card number">
                                            </div>
                                            <div class="form-group col-md-3" >
                                                <select  class="form-control" name="expiry_month" id="expiry_month" >
                                                    <option value=""> Expiry Month</option>
                                                    @for($i=1; $i<=12; $i++)
                                                    <option value="{{$i}}"> {{$i}}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <select  class="form-control" name="expiry_year" id="expiry_year" >
                                                    <option value=""> Expiry Year</option>
                                                    @for($i=2019; $i<=2030; $i++)
                                                        <option value="{{$i}}"> {{$i}}</option>
                                                    @endfor
                                                </select>

                                            </div>
                                        </div>
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <input type="text" name="cvc" class="form-control"  min="3" id="cvc" placeholder="CVC">
                                                </div>

                                            </div>


                                        {{--<input  type="hidden" name="activityBookings[]" value="@php $activityBookings @endphp" id="activityBookings">--}}

      <?php
      if(sizeof($item->questions->activityBookings)) {

         foreach ($item->questions->activityBookings as $activityBookings)
          {

                // dump($activityBookings);
            $passenger_arr=[];

           foreach($activityBookings->passengers as $passengers  )
           {

                    $extras_arr=[];

                    if(sizeof($passengers->extras))
                    {
                    foreach($passengers->extras as $extras)
                    {
                        $answers_arr=[];

                    if(sizeof($extras->questions))
                        {?>

                                        <h5 class="mb-3 mt-4">Booking Details </h5>

                      <?php

                 foreach($extras->questions as $questions)
                            {
?>

                                      <input type="hidden" name="EXTRAS_QUESTION[]" value="{{$questions->questionId}}" class="form-control"   >

                                        <div class="form-group col-md-6">
                                            <input type="text" name="EXTRAS_ANSWER[]" class="form-control" value="" id="question_id" placeholder="{{$questions->label}}">
                                        </div>

<?php
                             $answers_arr[] = array( "questionId" => $questions->questionId,"values"=>["EXTRAS_QUESTION_$questions->questionId" ]

                                                 );
                            }
                        }

                   $extras_arr[] = array( "bookingId" => $extras->bookingId,
                                //   "extraTitle" => $extras->extraTitle,
                                   "extraId" => $extras->extraId,
                                   "answers"=> $answers_arr  );


                   }

                 }

             $passenger_arr[] = array(
             "bookingId" => $passengers->bookingId,
             "pricingCategoryId" => $passengers->pricingCategoryId,
             "passengerDetails" => [],
             "answers" => [],
             "extras" => $extras_arr
             );
         }

         $ACTdata[] = array("activityId" => $activityBookings->activityId,
                       "bookingId" => $activityBookings->bookingId,
                     "answers" => [],
                     "pickupAnswers" => [],
                     "dropoffAnswers"=> [],
                     "passengers"=> $passenger_arr

          );
         }
}

     $activity_data = json_encode($ACTdata);

    //  dump($ACTdata);
                        /* $ttt=  '   "extras": [
                                                 {
                                                 "bookingId": "2158"
                                                 "extraTitle": "Flight number",
                                                 "extraId": 0,
                                                 "answers": [
                                                 {
                                                 "questionId": "2158",
                                                 "values": [
                                                 "string"
                                                 ]
                                                 }
                                                 ]

                                                 }
                                                 ]';*/




    ?>

<input type="hidden" value="{{$activity_data}}" name="activity_data" >



                                        <div class="form-group">
                                            <p style="text-align: center"><h2 style="text-align: center">Total : <span> {{$item->options[0]->formattedAmount}}</span></h2></p>
                                        </div>
                                {{--<div class="form-group mt-4">--}}
                                    {{--<div class="mr-3 custom-control-inline custom-control custom-radio">--}}
                                        {{--<input type="radio" id="customRadio1" name="customRadio" checked class="custom-control-input">--}}
                                        {{--<label class="custom-control-label" for="customRadio1"><img src="{{url('')}}/images/pay1.png">--}}
                                            {{--<img src="{{url('')}}/images/pay3.png">--}}

                                        {{--</label>--}}
                                    {{--</div>--}}
                                    {{--<div class="custom-control-inline custom-control custom-radio">--}}
                                        {{--<input type="radio" id="payment" name="customRadio"  class="custom-control-input">--}}
                                        {{--<label class="custom-control-label" for="payment"><img src="{{url('')}}/images/pay4.png"></label>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                        <button type="submit" class="btn hvr-float-shadow view_all">Pay</button>
                                    </form>

                                </div>
                                <div class="col-md-4 col-12 search_results">

                                    {{--@if(sizeof($item->questions->activityBookings))--}}
                                        {{--@foreach($item->questions->activityBookings as $activityBookings)--}}
                                        @if(isset($item->options[0]->invoice->productInvoices))
                                        @php $product= $item->options[0]->invoice->productInvoices;
                                        //dd($product);
                                        @endphp

                                        @for($i=0; $i<count($product); $i++)

                                    <div class="wow fadeIn" id="cart-" data-wow-duration="1s" data-wow-delay=".5s">
                                        <div class="row">
                                            <div class="col-md-6 offset-7">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        @php // dump($item->questions->activityBookings[$i]);  @endphp

                                                        <a href="{{'remove-booking/'.$sessionId.'/'.$item->questions->activityBookings[$i]->bookingId}}" class="cartRemove" style="font-size: 12px;color: grey"  data-action="">Remove</a>
                                                    </div>
                                                    {{--<div class="col-md-6">--}}
                                                        {{--<a href="javascript:void(0);" data-action="" style="font-size: 12px;color: grey">Edit</a>--}}
                                                    {{--</div>--}}
                                                </div>
                                            </div>


                                        </div>
                                        <div class="card text-left">
                                            {{--@if(!empty($itemCart['image']) && file_exists(public_path().'/uploads/'.$itemCart['image']))--}}
                                                <img class="card-img-top" src="{{@$product[$i]->product->keyPhoto->derived[1]->url}}" alt="Card image cap">
                                            {{--@else--}}
                                                {{--<img class="card-img-top" src="{{url('images/img2.jpg')}}" alt="Card image cap">--}}
                                            {{--@endif--}}
                                                <div class="card-body">

                                                <div class="media-body">
                                                    <h5>{{@$product[$i]->product->title}}</h5>
                                                    <p>
                                                        {{--<img src="{{url('')}}/images/map-pink.png">--}}
                                                        {{--<span>0.5 mi to Sydney center</span>--}}
                                                    </p>
                                                    <ul>
                                                        <li>
                                                            <strong>Date</strong> {{@$product[$i]->dates}}</li>
                                                        <li>
                                                            <strong>Booking for</strong>
                                                        @php $person= $product[$i]->lineItems; @endphp
                                                {{--@if(isset($person)&& sizeof($person) )--}}

                                                    @if(count($person)==1)
                                                        {{@$person[0]->quantity.' '.$person[0]->title }}
                                                    @elseif(count($person)==2)
                                                        {{@$person[0]->quantity.' '.$person[0]->title.' and '.$person[1]->quantity.' '.$person[1]->title }}
                                                    @else
                                                        {{@$person[0]->quantity.' '.$person[0]->title.', '.$person[1]->quantity.' '.$person[1]->title.' and '
                                                                .$person[2]->quantity.' '.$person[2]->title }}
                                                    @endif
                                                            {{--@endif--}}
                                                        <li>
                                                    </ul>
                                                    <div class="search_reviews">
                                                        <h5>{{@$product[$i]->totalAsText}}</h5>

                                                        <!--                                                        <a href="order.html" class="hvr-float-shadow view_all">Book Now</a>-->
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                        @endfor
                                    @endif


                                   {{-- <div class="wow fadeIn" data-wow-duration="1s" data-wow-delay=".5s">
                                        <div class="card text-left">
                                            <img class="card-img-top" src="{{url('images/lancscape1.jpg')}}" alt="Card image cap">
                                            <div class="card-body">

                                                <div class="media-body">
                                                    <h5>College st 1 Bedroom with Balcony</h5>
                                                    <p>
                                                        <img src="{{url('')}}/images/map-pink.png">
                                                        <span>0.5 mi to Sydney center</span>
                                                    </p>
                                                    <ul>
                                                        <li>
                                                            <strong>1</strong> BR Apartment</li>
                                                        <li>
                                                            <strong>1</strong> BA</li>
                                                        <li>
                                                            <strong>538</strong> sq. ft.</li>
                                                        <li>Sleeps
                                                            <strong>6</strong>
                                                        </li>
                                                    </ul>
                                                    <div class="search_reviews">
                                                        <h5>$137 per night</h5>
                                                        <!--

                                                        <a href="order.html" class="hvr-float-shadow view_all">Book Now</a>
-->
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="wow fadeIn" data-wow-duration="1s" data-wow-delay=".5s">
                                        <div class="card text-left">
                                            <img class="card-img-top" src="{{url('images/lancscape1.jpg')}}" alt="Card image cap">
                                            <div class="card-body">

                                                <div class="media-body">
                                                    <h5>College st 1 Bedroom with Balcony</h5>
                                                    <p>
                                                        <img src="{{url('')}}/images/map-pink.png">
                                                        <span>0.5 mi to Sydney center</span>
                                                    </p>
                                                    <ul>
                                                        <li>
                                                            <strong>1</strong> BR Apartment</li>
                                                        <li>
                                                            <strong>1</strong> BA</li>
                                                        <li>
                                                            <strong>538</strong> sq. ft.</li>
                                                        <li>Sleeps
                                                            <strong>6</strong>
                                                        </li>
                                                    </ul>
                                                    <div class="search_reviews">
                                                        <h5>$137 per night</h5>

                                                        <!--                                                        <a href="order.html" class="hvr-float-shadow view_all">Book Now</a>-->
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function ($) {

            $("#checkout_form").validate({submitHandler: function(form) {
                    // do other things for a valid form
                   form.submit();
                },
                rules: {
                    first_name:{
                        required:true,
                        minlength:3
                    },
                    email: {
                        required: true,
                    },
                    phone: {
                        required: true,
                        minlength:11,
                    },
                    city: {
                        required: true
                    },
                    card_name: {

                        required: true
                    },
                    card_number: {
                        minlength:16,
                        required: true

                        },
                    expiry_month: {
                        required: true
                    },
                    expiry_year: {
                        required: true
                    },
                    cvc: {
                            required: true
                        }

                },
                messages: {

                }
            });


            $(".cartRemove").click(function () {
                var a = $(this).attr("data-action");
                // var _token = $("input[name='_token']").val();

                    $.ajax({
                        type: "GET",
                        url: web_url + "/activities/remove-cart",
                        data: {instance_id: a},
                        success: function (data) {
                            if(data!=''){
                                $('#cart-'+a).remove();
                            }
                        }
                    });
            });
        });
    </script>
 
@endsection