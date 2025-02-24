@extends('layouts.app')

@section('content')
    <link rel="stylesheet" type="text/css" href="{{url('assets/admin/js/autocomplete/jquery-ui.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('assets/web/css/bootstrap-select.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('assets/web/css/daterangepicker.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('assets/web/css/animate.css')}}">

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

    @media screen and (max-width: 440px){
        .mar{
            position: relative;
            margin-top: 70px;
        }
    }
</style>

    <div class="main_wrapper">
        <div class="mar">
        @include('layouts/partial_header')

        </div>
        <div class="main_content">
            <div class="container">
                <div class="row">

                    <div class="grid_section explore_iceland text-center">
                 @if(!empty($ActivityData))
                        <h2>
                            <span id="page_heading">Book Your Adventures</span>
                        </h2>
                        <p id="page_line">Find out all you need to know about Icelandic nature, culture and history
						</p>
                  <div class="grid_content row" id="activityAppend">

                         @foreach ($ActivityData as $values)
                                <?php //dd($values);?>
                            <div class="col-lg-3 col-md-4 col-sm-6 wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".5s">

                                    <a href="{{url('activities/detail/'.$values['slug'])}}" style="overflow: visible;">
                                    <span class="post_time">{{$values['duration']}}</span>
                                    <div class="d-flex justify-content-center img_wrapper">
                                        @if(isset($values->single_photo)&& !empty($values->single_photo))
                                        <img src="{{ url('public/uploads/activities'.$values->single_photo->photo) }} " alt="{{@$item->activity_name}}">
                                        @else
                                            <img src="{{ url('public/images/no-image.png') }}" alt="No Image">
                                        @endif
                                        <div class="d-flex justify-content-center align-items-center hover_txt">
                                            <p>{{strip_tags(substr($values['description'],0,100))}}
                                                <span>read more...</span>
                                            </p>
                                        </div>
                                        {{--<span>May - Oct</span>--}}
                                    </div>
                                    <div class="select_plan">
                                        <span>From:
                                            <strong>{{$values['price']}}</strong>
                                        </span>
                                        <!-- <select class="selectpickerCustom"> -->
                                        <select class="selectpicker">
                                            <option value="USD">USD</option>
                                            <option value="AUD">AUD</option>
                                            <option value="CAD">CAD</option>
                                            <option value="CHF">CHF</option>
                                            <option value="DKK">DKK</option>
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
                                    <span class="place_name">{{$values['activity_name']}}</span>
                                </a>
                            </div>
                            @endforeach
                      <div class="col-12 mt-4 float-left paginateDivMain">
                          <nav aria-label="page navigation example">
                              {{ $ActivityData->links() }}
                          </nav>
                      </div>
                  </div>
                        @endif

                        <div class="grid_content row" id="catAppenddata">
                           <!--  <div class="col-md-4 col-sm-6">
                                <a href="#">
                                    <div class="d-flex justify-content-center img_wrapper">
                                        <img src="{{url('public/images/landscape24.jpg')}}>
                                        <div class="hover_txt">
                                            <h4>Heading text</h4>
                                            <p>Jump aboard this incredible boat trip in one of the world’s most inspiring places
                                                <span>read more...</span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div> -->
                        </div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Html::script('assets/web/js/bootstrap.min.js') !!}
    {!! Html::script('assets/web/js/moment.js') !!}
    {!! Html::script('assets/web/js/bootstrap-select.min.js') !!}
    {!! Html::script('assets/admin/js/autocomplete/jquery-ui.js') !!}
    {!! Html::script('assets/web/js/searchAutoComplete.js') !!}


    {!! Html::script('assets/web/js/bootstrap-datetimepicker.min.js') !!}
    {!! Html::script('assets/web/js/daterangepicker.js') !!}
    {!! Html::script('assets/web/js/jquery.datetimepicker.full.min.js') !!}
    {!! Html::script('assets/web/js/custom.js') !!}



<script type="text/javascript">
$('#autocomplete').autocomplete({
source: 'getSearch',
appendTo: "#options"
});
</script>
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
      $("#act_name").autocomplete({
            source: web_url + "/search/SearchActAutoName",
            appendTo:'#activityoptions',
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
            appendTo:'#placeoptions',
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
        $("#rest_name").autocomplete({
            source: web_url + "/search/searchAutoRestName",
            appendTo:'#restaurantoptions',
            select: function (event, ui) {
                var e = ui.item;
                $('input[name=rest_city_id]').val(e.id);
                $('input[name=type]').val(e.type);
            },
            change: function (event, ui) {
                var noRecord = 'No records found';
                if (ui.item == null || ui.item == undefined || $('#rest_name').val() === 'No records found') {
                    $("#rest_name").val("");
                    $("#rest_name").attr("disabled", false);
                }
            }
        });

</script>
 <script type="text/javascript">
     $(document).ready(function(){
          $(document).on('click','#Vacation-tab', function(){
            // $('#gridContentRowDiv').hide();
        // $('#preloader').show();
         location.reload(true);
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
        $(document).on('click','#placesTab', function(){
        $('#preloader').show();
            $('.fadeInLeft').hide();
            $('.paginateDivMain').hide();
            $('.showSub').show();
  $.ajax
    ({
        type: 'get',
        url: web_url+'/place/subcategory',
        success: function(result)
        {
            $('#page_heading').html('Places Of Interests');
             $('#page_line').html('Find out all you need to know about Icelandic nature, culture and history.');
           $('#catAppenddata').html(result);
             $('#preloader').hide();
        }
    });
        });
         $(document).on('click','#restaurantTab', function(){
             $('#preloader').show();
                 $('.fadeInLeft').hide();
                 $('.paginateDivMain').hide();
                  $('.showSub').show();
                  $.ajax
                    ({
                        type: 'get',
                        url: web_url+'/restaurant/subcategory',
                        success: function(result)
                        {

                            $('#page_heading').html('Restaurants');
                            $('#page_line').html('Quickly find a restaurant around you. Vegetarian, Bistros, Fine & Casual dining.');
                           $('#catAppenddata').html(result);
                            $('#preloader').hide();
                        }
                    });
        });
     })
 </script>

  {{--@include('layouts.jquery_pages.homeScript'); --}}
@endsection