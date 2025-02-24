<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-131847867-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-131847867-1');
    </script>

    <!---Added Google tag manager--->
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-M3F2B2M');
    </script>
    <!-- End Google Tag Manager -->

    <meta name="msvalidate.01" content="2DB4B554E54B9978199790EBC7916B28" />
    <meta name="google-site-verification" content="wMKCy4hIvGRk9Zu2KR7LB7qZqO__n704BBLl1LIeDR4" />

    <meta name="ahrefs-site-verification" content="b8825d4bd3f88f89fc368768ab0920fd84844b88be53253426e9325ab6fb9290">
    <meta name="keywords" content="Visit Iceland on Guide.is, Day Tours,travel packages,travel, Iceland, Reykjavik, Golden Circle, geysir iceland, Blue Lagoon,
    Flybus, Airport Transfer, Glacier Tour, Day Tours in Iceland, Reykjavik Excursions, articles, attractions,
    Iceland Tours, Northern Lights Tour, Northern Lights, Superjeep, Whale Watching,Flights info,Iceland Weather forecast, Roads conditions around Iceland,
News from Iceland,  Book activity tours and several trips around Reykjavik, Dining out in Reykjavik,
All Restaurants in Reykjavik Iceland,Holiday. Self-Drive tours, Rent a car, find accommodation">

    <meta name="description" content="Visit Iceland on Guide.is is a fully licensed travel agent & and tour provider in Iceland,
     offering day tours, guided trips around Iceland. Book a tour with us online!">
    <meta name="author" content="Waseem Khaliq">
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://www.guide.is" />
    <meta property="og:site_name" content="Guide.is" />

    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') </title>

    <link rel="shortcut icon" type="image/jpg" href="{{ asset('images/favicon.jpg') }}" />
    <!-- Bootstrap -->

    <link href="https://fonts.googleapis.com/css?family=Exo+2:300,400,500,600,700" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-select.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/rateit.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fontawesome-all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/lightslider.css') }}" rel="stylesheet">
    <link href="{{ asset('css/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('css/slick-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('css/hover.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="{{url('assets/web/css/jquery.rateyo.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/media.css') }}" rel="stylesheet">
    <script src="https://unpkg.com/popper.js/dist/umd/popper.min.js"></script>


    {{-------------------------------------My CDNS----------------------------------------------------------}}

    {{-------------------------------------My CDNS----------------------------------------------------------}}
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script src="{{url('assets/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{url('js/bootstrap.min.js')}}"></script>

    <style type="text/css">
        .ddslick>option {
            color: black;
        }

        .margin_top2em {
            margin-top: 1.9em;
        }
    </style>

    <style type="text/css">
        .preloader {
            height: 100%;
            width: 100%;
            position: relative;
        }

        .sk-spinner.sk-spinner-wave {

            width: 100%;
            height: 100%;
            background: whitesmoke;
            position: fixed;
            z-index: 99999999999999;
        }
    </style>

    <!-- Fonts -->


    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else

    @endif
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M3F2B2M"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <!-- header start -->
    {{--header start--}}
    @include('layouts.header')
    {{--header end--}}

    <script type="text/javascript">
        var web_url = "<?php echo url('/') ?>";
    </script>
    <!-- Slider -->
    <div id="preloader" style="display: none;">
        <div class="sk-spinner sk-spinner-wave">
            <img src="{{url('assets/web/img/material-loader.gif')}}" alt="Please Wait">
        </div>
    </div>
    @yield('style')
    @yield('content')

    @include('layouts.footer')




    <div class="modal fade user_modal user_login" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" id="loginFormDiv">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="{{ url('images/plus.png') }}" alt="PLus button"></button>
                <div class="grid_section text-center" style="font-size: 25px; margin-bottom: -30px; !important;">
                    <h2><span>Login</span></h2>
                </div>
                <div class="main_wrapper account_wrapper checkout_wrapper">
                    <form method="post" id="login_form" action="{{url('userlogin')}}">
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                        </div>
                        <p id="loginpasswordError" style="color: #dd4c4c;text-align: left;font-size: 15px;"></p>
                        <a href="javascript:void(0);" id="forgetpasswordid" class="forgot" style="color: #ff5252 !important;">Forgot password ?</a>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" id="m_login_signup_submit" class="btn hvr-float-shadow view_all">Login</button>

                        @if ($errors->login->any())
                        <script type="text/javascript">
                            $('.user_login').modal('show');
                        </script>
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->login->toArray() as $err)
                                <li style="text-align:center">{{ $err[0] }}</li>
                                <hr />
                                @endforeach

                            </ul>
                        </div>
                        @endif
                    </form>
                </div>


            </div>

            {{--forget password --}}
            <div class="modal-content" id="forgetpasswordDiv" style="display: none">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="{{ url('images/plus.png') }}" alt="Forgot Password"></button>
                <div class="grid_section text-center" style="font-size: 25px; margin-bottom: -60px !important;">
                    <h2><span>Forget Password</span></h2>
                    <br>
                </div>
                <div class="container">
                    <div class="row" style="margin-top:60px; margin-bottom: -40px;">
                        Enter your email and we'll send you the instructions to recover your password:
                    </div>
                </div>
                <p id="forgetloginpasswordmsg" style="color: green"></p>
                <div class="main_wrapper account_wrapper checkout_wrapper">
                    <form method="post" id="login_form" action="" style="    margin-bottom: 60px;">
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" id="forgetInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                        </div>
                        <p id="forgetpasswordError" style="color: #dd4c4c;text-align: left;font-size: 15px;"></p>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <a href="javascript:void(0);" id="forget_signup_submit" class="btn hvr-float-shadow view_all">Submit</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{--register modal --}}
    <div class="modal fade user_modal user_signup" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <img src="{{ url('images/plus.png') }}" alt=" Sign up "></button>
                <div class="grid_section text-center" style="margin-bottom: -30px;">
                    <h2><span>Signup</span></h2>
                </div>
                <div class="main_wrapper account_wrapper checkout_wrapper">

                    <form method="post" id="signup_form" action="{{url('user_registration')}}">

                        <div class="row">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" id="su_first_name" name="first_name" placeholder="First name">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <input type="email" class="form-control" id="register_email" name="email" placeholder="Email">
                                <p id="registerEmailError" style="color: red"></p>
                            </div>
                            <div class="form-group col-12">
                                <input type="password" class="form-control" name="password" id="inputPassword4" placeholder="Password">
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="address" id="inputAddress" placeholder="Addresss">
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <input type="text" name="city" class="form-control" placeholder="City" id="inputCity">
                            </div>
                            <div class="form-group col-md-6">
                                <select id="" name="country_code" class="form-control">
                                    <option>Select Country</option>
                                    <?php
                                    $country =  \App\Models\Country::all();
                                    ?>
                                    @if(!empty($country))
                                    @foreach($country as $obj)
                                    <option name="{{$obj->code}}">{{$obj->name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" id="m_register_signup_submit" class="btn hvr-float-shadow view_all">Register</button>
                        @if ($errors->register->any())
                        <script type="text/javascript">
                            $('.user_signup').modal('show');
                        </script>
                        <div class="alert alert-danger">
                            <ul>

                                @foreach($errors->register->toArray() as $err)
                                <li style="text-align:center">{{ $err[0] }}</li>
                                <hr />
                                @endforeach

                            </ul>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('js/jquery.datetimepicker.full.min.js')}}"></script>
    <script src="{{asset('js/slick.min.js')}}"></script>
    <script src="{{asset('js/wow.min.js')}}"></script>
    <script src="{{asset('js/lightslider.js')}}"></script>
    <script src="{{asset('js/jquery.rateit.min.js')}}"></script>
    <script src="{{asset('js/custom.js')}}"></script>

    <script src="https://openexchangerates.github.io/money.js/money.min.js"></script>
    <script src="{{asset('js/currency_conversion.js')}}"></script>
    <script src="{{asset('js/jquery.validate.min.js')}}"></script>


    <script src="{{url('assets/web/js/jquery.rateyo.min.js')}}"></script>


    <script>
        $(document).ready(function() {
            $('#forgetpasswordid').click(function() {
                $('#loginFormDiv').hide();
                $('#forgetpasswordDiv').show();
            })
            $('#forget_signup_submit').click(function() {
                var token = $("input[name='_token']").val();
                var email = $('#forgetInputEmail1').val();
                // alert(email)
                $.ajax({
                    type: "POST",
                    url: web_url + "/send-forget-email",
                    data: {
                        'email': email,
                        '_token': token
                    },
                    success: function(data) {
                        if (data) {
                            $("#forgetloginpasswordmsg").html(data);
                        }
                    }
                });
            })
            $('#m_login_signup_submit').click(function(e) {

                var token = $("input[name='_token']").val();
                var email = $('#exampleInputEmail1').val();
                var password = $('#exampleInputPassword1').val();
                //alert(email)
                $.ajax({
                    type: "POST",
                    url: web_url + "/loginVerfi",
                    data: {
                        'email': email,
                        'password': password,
                        '_token': token
                    },
                    success: function(data) {
                        if (data != '') {

                            $("#loginpasswordError").html(data);
                        } else {

                            // $("#loginpassword").html('');
                            /* ajaxSent = true;
                             $('form').submit();
                             return true;*/
                            location.reload(); //

                        }

                    }
                });
            });
            $('#m_register_signup_submit').click(function(e) {

                var token = $("input[name='_token']").val();

                var first_name = $("#su_first_name").val();
                var last_name = $("#last_name").val();
                var register_email = $("#register_email").val();
                var password = $("#inputPassword4").val();
                var address = $("#inputAddress").val();
                var city = $("#inputCity").val();
                var state = $("#inputState").val();
                var zip = $("#inputZip").val();
                //alert(register_email);
                if (first_name == '' || last_name == '' || zip == '' || register_email == '' || password == '' || city == '') {
                    $('#errorFields').html("Please fill all fields...!!!!!!");

                } else {

                    // var email=$('#register_email').val();
                    // var data = $("#signup_form").serialize();
                    // var password=$('#exampleInputPassword1').val();
                    //alert(email)
                    $.ajax({
                        type: "POST",
                        url: web_url + "/check-email-register",
                        data: {
                            'first_name': first_name,
                            'last_name': last_name,
                            'email': register_email,
                            'password': password,
                            'address': address,
                            'city': city,
                            'state': state,
                            'zip': zip,
                            '_token': token
                        },
                        success: function(data) {

                            if (data != '') {
                                //   alert('error')
                                $("#registerEmailError").html(data);
                            } else {
                                //alert('ok');
                                // $("#registerEmail").html('');
                                /* ajaxSent = true;
                                 $('form').submit();
                                 return true;*/
                                location.reload(); //
                            }

                        }
                    });
                }




            })
        })
    </script>
    <!-- auto -->
    <script type="text/javascript">
        $("#login_form").validate({
            submitHandler: function(form) {
                // do other things for a valid form
                // form.submit();
            },
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 4
                }
            },
            messages: {
                email: {
                    required: "We need your email address to log you in",
                    email: "Your email address is not valid"
                    //email: "Your email address must be in the format of name@domain.com"
                },
                password: {
                    required: "Password is required",
                    minlength: "Your password must contain minimum 8 characters"
                }
            }
        });
        $("#signup_form").validate({
            submitHandler: function(form) {
                // do other things for a valid form
                //form.submit();
            },
            rules: {
                country_code: "required",
                zip: "required",
                address: "required",
                city: "required",
                first_name: "required",
                last_name: "required",
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 8
                }
            },
            messages: {
                first_name: "Please specify your first name",
                address: "Please specify your Address",
                country_code: "Please Choose your Country",
                city: "Please specify your City",
                zip: "Required",
                last_name: "Please specify your last name",
                email: {
                    required: "We need your email address to contact you",
                    email: "Your email address is not valid"
                    // email: "Your email address must be in the format of name@domain.com"
                },
                password: {
                    required: "Password is required",
                    minlength: "Your password must contain minimum 8 characters"
                }
            }
        });
    </script>
</body>

</html>