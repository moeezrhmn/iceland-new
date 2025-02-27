@extends('layouts.app')
{!! Html::style('assets/web/css/jquery.rateyo.min.css') !!}
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
                            <div class="row">
                                <div class="col-md-8 col-12 border-right">
                                    <h5 class="mb-3">Payment Details</h5>
                                    <form>

                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <input type="text" class="form-control" id="inputAddress" placeholder="First name">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input type="text" class="form-control" id="inputAddress" placeholder="Last name">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-12">
                                                <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="inputAddress" placeholder="Addresss">
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <input type="text" class="form-control" placeholder="City" id="inputCity">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <select id="inputState" class="selectpicker">
                                                    <option selected>Choose...</option>
                                                    <option>option 1</option>
                                                    <option>option 2</option>
                                                    <option>option 3</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <input type="text" class="form-control" id="inputZip" placeholder="Zip">
                                            </div>
                                        </div>
                                        <h5 class="mb-3 mt-4">Payment Methods</h5>

                                        <div class="form-group">

                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="inputAddress" placeholder="Name on card">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="inputAddress" placeholder="Card number">
                                        </div>
                                        <div class="row">

                                            <div class="form-group col-md-6">
                                                <select id="inputState" class="selectpicker">
                                                    <option selected>Valild From...</option>
                                                    <option>option 1</option>
                                                    <option>option 2</option>
                                                    <option>option 3</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <select id="inputState" class="selectpicker">
                                                    <option selected>Valild To...</option>
                                                    <option>option 1</option>
                                                    <option>option 2</option>
                                                    <option>option 3</option>
                                                </select>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control" id="inputZip" placeholder="CCV">
                                        </div>
                                        <div class="form-group">
                                            <p style="text-align: center"><h2 style="text-align: center">Total : <span> {{$item1->options[0]->formattedAmount}}</span></h2></p>
                                        </div>
                                        <div class="form-group mt-4">
                                            <div class="mr-3 custom-control-inline custom-control custom-radio">
                                                <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input">
                                                <label class="custom-control-label" for="customRadio1"><img src="{{url('')}}/images/pay1.png">
                                                    <img src="{{url('')}}/images/pay3.png">

                                                </label>
                                            </div>
                                            <div class="custom-control-inline custom-control custom-radio">
                                                <input type="radio" id="payment" name="customRadio" class="custom-control-input">
                                                <label class="custom-control-label" for="payment"><img src="{{url('')}}/images/pay4.png"></label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn hvr-float-shadow view_all">Checkout</button>
                                    </form>

                                </div>
                                <div class="col-md-4 col-12 search_results">
                                    <?php
                                    $items=  Darryldecode\Cart\Facades\CartFacade ::getContent();
                                    ?>
                                    @if(isset($items) && !empty($items))
                                        @foreach($items as $itemCart)

                                    <div class="wow fadeIn" id="cart-{{$itemCart['id']}}" data-wow-duration="1s" data-wow-delay=".5s">
                                        <div class="row">
                                            <div class="col-md-6 offset-7">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <a href="javascript:void(0);" class="cartRemove" style="font-size: 12px;color: grey"  data-action="{{$itemCart['id']}}">Remove</a>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <a href="javascript:void(0);" data-action="{{$itemCart['id']}}" style="font-size: 12px;color: grey">Edit</a>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                        <div class="card text-left">
                                            {{--@if(!empty($itemCart['image']) && Storage::disk('uploads')->exists($itemCart['image']))--}}
                                            @if(!empty($itemCart['image']) && file_exists(public_path().'/uploads/'.$itemCart['image']))
                                            {{--<img class="card-img-top" src="{{url('uploads/img2.jpg')}}" alt="Card image cap">--}}
                                                <img class="card-img-top" src="{{url('uploads/'.@$itemCart['image'])}}" alt="Card image cap">
                                            @else
                                                <img class="card-img-top" src="{{url('images/img2.jpg')}}" alt="Card image cap">

                                            @endif
                                                <div class="card-body">

                                                <div class="media-body">
                                                    <h5>{{@$itemCart['name']}}</h5>
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
                                                        <h5>{{@$itemCart['price']}}</h5>

                                                        <!--                                                        <a href="order.html" class="hvr-float-shadow view_all">Book Now</a>-->
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                        @endforeach
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