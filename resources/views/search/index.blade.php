@extends('layouts.app')
<link rel="stylesheet" type="text/css" href="{{url('assets/admin/js/autocomplete/jquery-ui.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('assets/web/css/bootstrap-select.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('assets/web/css/daterangepicker.css')}}">
<link rel="stylesheet" type="text/css" href="{{url('assets/web/css/animate.css')}}">
@section('content')
    <!--  <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.css" />
{{--autocomplete--}} -->
    <!--
    <script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-autocomplete/1.0.7/jquery.auto-complete.js"></script> -->

    <style>
        /*  .ui-autocomplete {
            position: absolute;
            z-index: 1000;
            cursor: default;
            padding: 0;
            margin-top: 2px;
            list-style: none;
            background-color: #ffffff;
            border: 1px solid #ccc;
            -webkit-border-radius: 5px;
               -moz-border-radius: 5px;
                    border-radius: 5px;
            -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
               -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
                    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        }
        .ui-autocomplete > li {
          padding: 3px 20px;
        }
        .ui-autocomplete > li.ui-state-focus {
          background-color: #DDD;
        }
        .ui-helper-hidden-accessible {
          display: none;
        }
        .ui-menu-item-wrapper:focus{
                background: red;
        }
        */
        .autocomplete-suggestions {
            border: 1px solid #999;
            background: #FFF;
            overflow: auto;
        }

        .autocomplete-suggestion {
            padding: 2px 5px;
            white-space: nowrap;
            overflow: hidden;
        }

        .autocomplete-selected {
            background: #F0F0F0;
        }

        .autocomplete-suggestions strong {
            font-weight: normal;
            color: #3399FF;
        }

        .autocomplete-group {
            padding: 2px 5px;
        }

        .autocomplete-group strong {
            display: block;
            border-bottom: 1px solid #000;
        }

        .filter-option {
            position: relative;
            top: 4px
        }
    </style>

    <div class="main_wrapper">
        @include('layouts/partial_header')
        <div class="main_content">
            <div class="container">
                <div class="row">

                    <div class="grid_section text-center">
                        @if(!empty($ActivityData))


                                @if(isset($_GET['rst'])=='restaurant')
                                   <h2> <span id="title_sub">Restaurants</span></h2>
                                    <p id="page_line">Quickly find a restaurant around you. Vegetarian, Bistros, Fine & Casual dining.</p>

                                @elseif(isset($_GET['plc'])=='places-to-visit')
                                   <h2> <span id="title_sub">Places Of Interests</span></h2>
                                     <p id="page_line">Find out all you need to know about Icelandic nature, culture and history</p>
                                @else
                                    <h2><span id="title_sub">Book Your Adventures</span></h2>
                                        <p id="page_line">Find out all you need to know about Icelandic nature, culture and history
                                                                        						</p>
                                @endif

                            <div @if(isset($_GET['rst']) && $_GET['rst']=='restaurant' || isset($_GET['plc']) && $_GET['plc']=='places-to-visit') style="display: none;padding: 0;"
                                 @else
                                 style="padding: 0;"
                                 @endif class="grid_content row"  id="activityAppend">
                                <!--  <div class="gridContentRowDiv">
                                 </div> -->
                                @foreach ($ActivityData as $values)
                                    <?php //dd($values);?>
                                    <div class="col-lg-3 col-md-4 col-sm-6 wow fadeInLeft activityGridListing" data-wow-duration="1s" data-wow-delay=".5s">

                                        <!-- <div class="activityGridItem"> -->
                                        <a href="{{url('activities/detail/'.$values['slug'])}}" style="overflow: visible;">
                                            <span class="post_time">{{$values['duration']}}</span>
                                            <div class="d-flex justify-content-center img_wrapper">
                                                {{--<img src="{{url('/images/0.jpg')}}" alt="">--}}
                                                @if(isset($values->single_photo)&& !empty($values->single_photo))
                                                    <img src="{{ url('uploads/activities'.$values->single_photo->photo) }} ">
                                                @else
                                                    <img src="{{ url('images/no-image.png') }} ">
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
                                                </select>
                                            </div>

                                            <span class="place_name">{{$values['activity_name']}}</span>

                                        </a>
                                        <!-- </div> -->
                                    </div>

                                @endforeach
                                <div class="col-12 mt-4 float-left paginateDivMain">
                                    <nav aria-label="page navigation example">

                                        {{ $ActivityData->links() }}
                                    </nav>
                                </div>
                            </div>

                        @endif


                    </div>
                    <div class="grid_section explore_iceland text-center showSub"  @if(isset($_GET['rst']) && $_GET['rst']=='restaurant'
                                    || isset($_GET['plc']) && $_GET['plc']=='places-to-visit')
                    style="display: block;padding: 0px" @else style="display: none;padding: 0px" @endif >  <span class="">
                             {{--<h2>--}}
                            {{--<span>Sub Categories</span>--}}
                            {{--</h2>--}}
                            <p id="subcate_para">
                        </p>
                        <div class="grid_content row" id="catAppenddata">
                            @if(isset($_GET['rst']) && $_GET['rst']=='restaurant')

                                {{--restaurant start--}}
                                @if(!empty($sub_category))
                                    @foreach($sub_category as $obj)
                                        <?php
                                        /*  echo '<pre>';
                                          print_r($obj->cat_name);
                                          exit;*/
                                        ?>
                                        <div class="col-md-4 col-sm-6">
                                            <a href="{{url('restaurants/'.$obj->slug)}}">
                                                <div class="d-flex justify-content-center img_wrapper">
                                                    {{--<img src="{{url('images/landscape24.jpg')}}">--}}
                                                    @if(isset($values->single_photo)&& !empty($obj->cat_image))
                                                        <img src="{{ url('uploads/'.$obj->cat_image) }} ">
                                                    @else
                                                        <img src="{{ url('images/no-image.png') }} ">
                                                    @endif
                                                    <div class="hover_txt">
                                                        <h4>{{@$obj->cat_name}}
                                                            @if(!empty($obj->description))
                                                                <p>
                                                            {{@$obj->description}}
                                                                    <span>read more...</span>
                                                        </p>
                                                        @endif
                                                    </div>
                                                </div>

                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                                {{--restaurant end--}}


                            @else
                                {{--places start--}}
                                @if(!empty($subcat_place))
                                    @foreach($subcat_place as $obj)
                                        <?php
                                        /*  echo '<pre>';
                                          print_r($obj->cat_name);
                                          exit;*/
                                        ?>
                                        <div class="col-md-4 col-sm-6">
                                            <a href="{{url('places/'.$obj->slug)}}">
                                                <div class="d-flex justify-content-center img_wrapper">
                                                    {{--<img src="{{url('images/landscape24.jpg')}}">--}}
                                                    {{--<img src="{{url('/images/0.jpg')}}" alt="">--}}
                                                    @if(isset($values->single_photo)&& !empty($obj->cat_image))
                                                        <img src="{{ url('uploads/'.$obj->cat_image) }} ">
                                                    @else
                                                        <img src="{{ url('images/no-image.png') }} ">
                                                    @endif
                                                    <div class="hover_txt">
                                                        <h4>{{@$obj->cat_name}}
                                                            @if(!empty($obj->description))
                                                                <p>
                                                            {{@$obj->description}}
                                                                    <span>read more...</span>
                                                        </p>
                                                        @endif
                                                    </div>
                                                </div>

                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                                {{--places end--}}
                            @endif
                        </div>
                        </span>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="current_url" value="">
    {!! Html::script('assets/web/js/bootstrap.min.js') !!}
    {!! Html::script('assets/web/js/moment.js') !!}
    {!! Html::script('assets/web/js/bootstrap-select.min.js') !!}
    {!! Html::script('assets/admin/js/autocomplete/jquery-ui.js') !!}
    {!! Html::script('assets/web/js/searchAutoComplete.js') !!}
    {!! Html::script('assets/web/js/bootstrap-datetimepicker.min.js') !!}
    {!! Html::script('assets/web/js/daterangepicker.js') !!}
    {!! Html::script('assets/web/js/jquery.datetimepicker.full.min.js') !!}
    {!! Html::script('assets/web/js/custom.js') !!}

    <script>
        $(document).ready(function () {
            $('.daterange').daterangepicker({
                timePicker: true,
                /*startDate: moment().startOf('hour'),
                endDate: moment().startOf('hour').add(32, 'hour'),*/
                locale: {
                    format: 'DD/MM/YY hh:mm A'
                }
            });

// bootstrap select

        });

    </script>


    <script type="text/javascript">

        $('#autocomplete').autocomplete({
            source: 'getSearch',
            appendTo: "#options"
        });
    </script>
    <script type="text/javascript">


        $("#act_name").autocomplete({
            source: web_url + "/search/SearchActAutoName",
            appendTo: '#activityoptions',
            select: function (event, ui) {
                var e = ui.item;
                $('#act_city_id').val(e.id);
                $('input[name=activity_type]').val(e.type);

            },
            change: function (event, ui) {
                var noRecord = 'No records found';
                if (ui.item == null || ui.item == undefined || $('#act_name').val() === 'No records found') {
                    $("#act_name").val("");
                    $("#act_name").attr("disabled", false);
                }
            }

        });


        $("#plc_name").autocomplete({
            source: web_url + "/search/SearchPlcAutoName",
            appendTo: '#placeoptions',
            select: function (event, ui) {
                var e = ui.item;
                $('#place_city_id').val(e.id);
                $('input[name=search_type]').val(e.type);
            },
            change: function (event, ui) {
                var noRecord = 'No records found';
                if (ui.item == null || ui.item == undefined || $('#plc_name').val() === 'No records found') {
                    $("#plc_name").val("");
                    $("#plc_name").attr("disabled", false);
                }
            }
        });
        $("#restName").autocomplete({
            source: web_url + "/search/searchAutoRestName",
            appendTo: '#restaurantoptions',
            select: function (event, ui) {
                var e = ui.item;
                $('input[name=rest_city_id]').val(e.id);
                $('input[name=type]').val(e.type);
            },
            change: function (event, ui) {
                var noRecord = 'No records found';
                if (ui.item == null || ui.item == undefined || $('#restName').val() === 'No records found') {
                    $("#restName").val("");
                    $("#restName").attr("disabled", false);
                }
            }
        });

    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).on('click', '#Vacation-tab', function () {
// $('#gridContentRowDiv').hide();
// $('#preloader').show();
                var temp = "{{url()->current()}}";
                url =  temp;
                window.location.replace(url);
                // location.reload(true);
                /*$.ajax
                ({
                type: 'get',
                url: web_url+'/activities-more',
                success: function(result)
                {
                $('#activityAppend').html(result);
                $('#preloader').hide();
                }
                });*/
            });
// /////////////////////////////// places click ///////////////////////////
            $(document).on('click', '#placesTab', function () {
                $('#preloader').show();
                $('.fadeInLeft').hide();
                $('.paginateDivMain').hide();
                $('.showSub').show();
                $.ajax
                ({
                    type: 'get',
                    url: web_url + '/place/subcategory',
                    success: function (result) {
                        $('#catAppenddata').html(result);
                        $('#title_sub').html('Places of Interests');
                        $('#page_line').html('Find out all you need to know about Icelandic nature, culture and history');
                       // $('#subcate_para').html('Find out all you need to know about Icelandic nature, culture and history');
                        $('#preloader').hide();
                    }
                });
            });
            $(document).on('click', '#restaurantTab', function () {
                $('#preloader').show();
                $('.fadeInLeft').hide();
                $('.paginateDivMain').hide();
                $('.showSub').show();
                $.ajax
                ({
                    type: 'get',
                    url: web_url + '/restaurant/subcategory',
                    success: function (result) {

                        $('#catAppenddata').html(result);
                        $('#title_sub').html('Restaurants');
                        $('#page_line').html('Quickly find a restaurant around you. Vegetarian, Bistros, Fine & Casual dining.');
                        $('#preloader').hide();
                    }
                });
            });
        })
    </script>

    {{--@include('layouts.jquery_pages.homeScript');--}}
@endsection