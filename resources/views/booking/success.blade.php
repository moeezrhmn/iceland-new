@extends('layouts.app')
{!! Html::style('assets/web/css/jquery.rateyo.min.css') !!}
@section('content')
    <div class="main_wrapper">
        <div class="order_container">
            <div class="container">
                <div class="row">
                    <div class="grid_section text-center">
                        <h2>
                            <span>Order History</span>
                        </h2>
                        <h6>
                            <span>Your Booking has been Confirmed Successfully. Please check your email.</span>
                        </h6>
                        <div style="height: 300px;clear: both" ></div>
                        {{--<div class="order_wrapper">--}}
                            {{--<div class="table-responsive">--}}
                                {{--<table class="table">--}}
                                    {{--<thead>--}}
                                    {{--<th></th>--}}
                                    {{--<th>Order Name</th>--}}
                                    {{--<th>Order Details</th>--}}
                                    {{--<th>No. of Orders</th>--}}
                                    {{--<th>Status</th>--}}
                                    {{--<th></th>--}}
                                    {{--<th></th>--}}
                                    {{--</thead>--}}
                                    {{--<tbody>--}}
                                    {{--<tr>--}}
                                        {{--<td>--}}
                                            {{--<img src="images/lancscape1.jpg">--}}
                                        {{--</td>--}}
                                        {{--<td>College st 1 Bedroom with Balcony--}}
                                            {{--<br>--}}
                                            {{--<ul>--}}
                                                {{--<li>--}}
                                                    {{--<strong>1</strong> BR Apartment</li>--}}
                                                {{--<li>--}}
                                                    {{--<strong>1</strong> BA</li>--}}
                                                {{--<li>--}}
                                                    {{--<strong>538</strong> sq. ft.</li>--}}
                                                {{--<li>Sleeps--}}
                                                    {{--<strong>6</strong>--}}
                                                {{--</li>--}}
                                            {{--</ul>--}}
                                        {{--</td>--}}
                                        {{--<td>--}}
                                            {{--<strong>JUL 1 - AUG 14</strong>--}}
                                            {{--<br>--}}
                                            {{--<strong>1 Guests</strong>--}}
                                        {{--</td>--}}
                                        {{--<td>2</td>--}}
                                        {{--<td>--}}
                                            {{--<span class="text-success">Confirmed</span>--}}
                                        {{--</td>--}}
                                        {{--<td>--}}
                                            {{--<a href="#" data-toggle="tooltip" data-placement="bottom" title="Edit Order">--}}
                                                {{--<i class="text-primary fas fa-edit"></i>--}}
                                            {{--</a>--}}
                                        {{--</td>--}}
                                        {{--<td>--}}
                                            {{--<a href="#" class="delete_row" data-toggle="tooltip" data-placement="bottom" title="Delete Order">--}}
                                                {{--<i class="text-danger far fa-trash-alt"></i>--}}
                                            {{--</a>--}}
                                        {{--</td>--}}
                                    {{--</tr>--}}
                                    {{--<tr>--}}
                                        {{--<td>--}}
                                            {{--<img src="images/lancscape2.jpg">--}}
                                        {{--</td>--}}
                                        {{--<td>College st 1 Bedroom with Balcony--}}
                                            {{--<br>--}}
                                            {{--<ul>--}}
                                                {{--<li>--}}
                                                    {{--<strong>1</strong> BR Apartment</li>--}}
                                                {{--<li>--}}
                                                    {{--<strong>1</strong> BA</li>--}}
                                                {{--<li>--}}
                                                    {{--<strong>538</strong> sq. ft.</li>--}}
                                                {{--<li>Sleeps--}}
                                                    {{--<strong>6</strong>--}}
                                                {{--</li>--}}
                                            {{--</ul>--}}
                                        {{--</td>--}}
                                        {{--<td>--}}
                                            {{--<strong>JUL 1 - AUG 14</strong>--}}
                                            {{--<br>--}}
                                            {{--<strong>1 Guests</strong>--}}
                                        {{--</td>--}}
                                        {{--<td>2</td>--}}
                                        {{--<td>--}}
                                            {{--<span class="text-primary">Pending</span>--}}
                                        {{--</td>--}}
                                        {{--<td>--}}
                                            {{--<a href="#" data-toggle="tooltip" data-placement="bottom" title="Edit Order">--}}
                                                {{--<i class="text-primary fas fa-edit"></i>--}}
                                            {{--</a>--}}
                                        {{--</td>--}}
                                        {{--<td>--}}
                                            {{--<a href="#" class="delete_row" data-toggle="tooltip" data-placement="bottom" title="Delete Order">--}}
                                                {{--<i class="text-danger far fa-trash-alt"></i>--}}
                                            {{--</a>--}}
                                        {{--</td>--}}
                                    {{--</tr>--}}

                                    {{--<tr>--}}
                                        {{--<td>--}}
                                            {{--<img src="images/lancscape3.jpg">--}}
                                        {{--</td>--}}
                                        {{--<td>College st 1 Bedroom with Balcony--}}
                                            {{--<br>--}}
                                            {{--<ul>--}}
                                                {{--<li>--}}
                                                    {{--<strong>1</strong> BR Apartment</li>--}}
                                                {{--<li>--}}
                                                    {{--<strong>1</strong> BA</li>--}}
                                                {{--<li>--}}
                                                    {{--<strong>538</strong> sq. ft.</li>--}}
                                                {{--<li>Sleeps--}}
                                                    {{--<strong>6</strong>--}}
                                                {{--</li>--}}
                                            {{--</ul>--}}
                                        {{--</td>--}}
                                        {{--<td>--}}
                                            {{--<strong>JUL 1 - AUG 14</strong>--}}
                                            {{--<br>--}}
                                            {{--<strong>1 Guests</strong>--}}
                                        {{--</td>--}}
                                        {{--<td>2</td>--}}
                                        {{--<td>--}}
                                            {{--<span class="text-warning">In Process</span>--}}
                                        {{--</td>--}}
                                        {{--<td>--}}
                                            {{--<a href="#" data-toggle="tooltip" data-placement="bottom" title="Edit Order">--}}
                                                {{--<i class="text-primary fas fa-edit"></i>--}}
                                            {{--</a>--}}
                                        {{--</td>--}}
                                        {{--<td>--}}
                                            {{--<a href="#" class="delete_row" data-toggle="tooltip" data-placement="bottom" title="Delete Order">--}}
                                                {{--<i class="text-danger far fa-trash-alt"></i>--}}
                                            {{--</a>--}}
                                        {{--</td>--}}
                                    {{--</tr>--}}
                                    {{--<tr>--}}
                                        {{--<td>--}}
                                            {{--<img src="images/lancscape4.jpg">--}}
                                        {{--</td>--}}
                                        {{--<td>College st 1 Bedroom with Balcony--}}
                                            {{--<br>--}}
                                            {{--<ul>--}}
                                                {{--<li>--}}
                                                    {{--<strong>1</strong> BR Apartment</li>--}}
                                                {{--<li>--}}
                                                    {{--<strong>1</strong> BA</li>--}}
                                                {{--<li>--}}
                                                    {{--<strong>538</strong> sq. ft.</li>--}}
                                                {{--<li>Sleeps--}}
                                                    {{--<strong>6</strong>--}}
                                                {{--</li>--}}
                                            {{--</ul>--}}
                                        {{--</td>--}}
                                        {{--<td>--}}
                                            {{--<strong>JUL 1 - AUG 14</strong>--}}
                                            {{--<br>--}}
                                            {{--<strong>1 Guests</strong>--}}
                                        {{--</td>--}}
                                        {{--<td>2</td>--}}
                                        {{--<td>--}}
                                            {{--<span class="text-danger">Cancelled</span>--}}
                                        {{--</td>--}}
                                        {{--<td>--}}
                                            {{--<a href="#" data-toggle="tooltip" data-placement="bottom" title="Edit Order">--}}
                                                {{--<i class="text-primary fas fa-edit"></i>--}}
                                            {{--</a>--}}
                                        {{--</td>--}}
                                        {{--<td>--}}
                                            {{--<a href="#" class="delete_row" data-toggle="tooltip" data-placement="bottom" title="Delete Order">--}}
                                                {{--<i class="text-danger far fa-trash-alt"></i>--}}
                                            {{--</a>--}}
                                        {{--</td>--}}
                                    {{--</tr>--}}
                                    {{--</tbody>--}}
                                {{--</table>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

    </script>
 
@endsection