<footer style="z-index: 100; position: relative;">
    <div class="upper_footer">
        {{--<link rel="stylesheet" href="{{url('css/font-awesome.min.css')}}">--}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <h4>About Us</h4>
                    <p>We know you have worked hard for your trip to Iceland. Let us help you to make the most of this visit. We have a team of experts who are ready to make sure that you will.</p>
                    <a href="{{url('cancellation-policy')}}"> Terms and cancellation policy</a>
                    <a href="{{url('terms-conditions')}}"> Terms & Conditions</a>
                    <a href="{{url('privacy-policy')}}"> Privacy Policy</a>
                    

                </div>
                @php
                    $quickLink = \App\Models\Category::select('id','cat_name','slug','order_no')->where('status','Active')->where('parent_id',3)
                    ->orderBy('order_no')->get();
                  // dd($quickLink);
                @endphp
                <div class="col-md-3 col-sm-6">
                    <h4>Photography tours</h4>
                    <ul>
                        @for($i=24; $i<30; $i++)
                            <li>
                                <a href="{{url('tours/'.$quickLink[$i]->slug)}}">{{$quickLink[$i]->cat_name}}</a>
                            </li>
                        @endfor
                        {{--<li>--}}
                            {{--<a href="#"> Bird Watch Tours</a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="#"> Special occasion</a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="#"> Wedding & anniversary</a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="#"> Interior of Iceland (Explore the highlands)</a>--}}
                        {{--</li>--}}
                    </ul>
                </div>
                <div class="col-md-3 col-sm-6">
                    <h4>BEST SELLERS</h4>
                    <ul>

                        @for($i=31; $i<39; $i++)
                            <li>
                                <a href="{{url('tours/'.$quickLink[$i]->slug)}}">{{$quickLink[$i]->cat_name}}</a>
                            </li>
                        @endfor


                        {{--<li>--}}
                            {{--<a href="#">Day tours</a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="#"> Guided Tours</a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="#"> Self Drive Tours</a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="#"> Travel Packages</a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="#"> Private Tours</a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="#"> Luxury Tours</a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="#"> Winter Tours</a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="#"> Summer Tours</a>--}}
                        {{--</li>--}}
                    </ul>
                </div>
                <div class="col-md-3 col-sm-6">
                    <h4>Send us an inquiry</h4>
                    <form method="post" action="{{url('/news-letter-register')}}">
                        <div class="form-group">
                            @csrf
                            <input type="text" name="first_name" class="form-control " required placeholder="First Name">
                        </div>
                        <div class="form-group">
                            <input type="text" name="email" class="form-control" required placeholder="Email">
                        </div>
                        <button type="submit" class="btn view_all hvr-float-shadow" style="border-radius: 0px"> SUBMIT </button>

                    </form>

                    <ul class="nav list-inline social_links">
                        <li>
                            <a href="#" title="Facebook">
                                <i class="fa fa-facebook"></i>
                            </a>
                        </li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <li>
                            <a target="_blank" href="#" title="Twitter">
                                <i class="fa fa-twitter"></i>
                            </a>
                        </li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <li>
                            <a target="_blank" href="#" title="Instagram">
                                <i class="fa fa-instagram"></i>
                                {{--<i class="fa fa-globe"></i>--}}
                            </a>
                        </li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <li>
                            <a target="_blank" href="#" title="Pinterest">
                                <i class="fa fa-pinterest"></i>
                            </a>
                        </li>
                        {{--<li>--}}
                            {{--<a target="_blank" href="#" title="Pinterest">--}}
                                {{--<i class="fa fa-globe"></i>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    </ul>
                </div>
            </div>
            <br>
            <br>
            <div class="row border-top pt-3">
                <div class="col-sm-12 col-md-6">
                    <p>
                       <a  style="color:white"   href="https://maps.app.goo.gl/Ts9o8eKLnEupvzvf6" target="_blank">
                       <i class="fas fa-map-marker-alt"> </i>Suðurlandsbraut 4a, 108 Reykjavík</a> </p>
                </div>
                <div class="col-sm-12 col-md-3">
                    <a href="tel:354 893 4060" title="">
                        <i class="fas fa-phone"></i>+354 893 4060</a>
                </div>
                <div class="col-sm-12 col-md-3">
                    <a href="mailto:iceland@icelandonline.com" title="">
                        <i class="fas fa-envelope"></i>iceland@icelandonline.com
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="lower_footer text-center">
        <div class="container-fluid">
            <p>Copyright © 2018 Today Publication ehf. - All Rights Reserved</p>
        </div>
    </div>

</footer>
<style>

    .fa{
        text-align: center;
        text-decoration: none;
        padding: 9px;
        border-radius: 100%;
        width: 35px;
        height: 34px;
        font-weight: bold;
        align-items: center;
    }
    /*.fa:hover{*/
        /*opacity: 0.7;*/
        /*color: red;*/
    /*}*/
    .fa-globe{
        background: #000;
        color: #fff;
    }
    .fa-twitter{
        background-color: #55ACEE;
        /*background: #fff;*/
        color: #fff;
    }
    .fa-facebook{
        background-color: #3B5998;
        /*background: #fff;*/
        color: #fff;
    }
    .fa-instagram {
        color: #fff;
        background-image: linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%, #cc2366 75%,#bc1888 100%);
    }
    .fa-pinterest {
        background: #cb2027;
        /*background: #fff;*/
        color: #fff;
    }
    .fa-google {
        background: #dd4b39;
        color: #fff;
    }
    .fa-tripadvisor{
        color: #fff;
        background-color: #4CAF50;
    }
</style>

{{--<div class="ice-footer container-fluid">--}}

    {{--<div class="container">--}}
        {{--<div class="row">--}}
            {{--<div class="col-md-3">--}}
                {{--<h5>About Us</h5>--}}
                {{--<p align="justify">We know you have worked hard for your trip to Iceland. Let us help you to make the most of this visit. We have a team of experts who are ready to make sure that you will.</p>--}}
                {{--<a  href="#"> Terms & Conditions</a><br>    --}}
                {{--<a  href="#"> Privacy Policy</a><br>--}}
                {{----}}
            {{--</div>--}}
            {{--<div class="col-md-3">--}}
            {{--<ul style="list-style: none;">--}}
                {{--<li style="padding: 1px;"><h5 ><a  href="#">Photography tours</a></h5></li>--}}
                {{--<li style="padding: 1px;"><span><a  href="#"> Bird Watch Tours</a>  </span></li>--}}
                {{--<li style="padding: 1px;"><a  href="#"> Special occasion</a></li>--}}
                {{--<li style="padding: 1px;"><a  href="#"> Wedding & anniversary</a></li>--}}
                {{--<li style="padding: 1px;"><a  href="#"> Interior of Iceland (Explore the highlands)</a></li>--}}
            {{--</ul>--}}
                {{----}}
                {{----}}
                {{----}}
                {{----}}
            {{--</div>--}}
            {{--<div class="col-md-3">--}}
                {{--<ul style="list-style: none;">--}}
                {{--<li style="padding: 1px;"><h5 style="color: red"><a  href="#">BEST SELLERS</a></h5></li>--}}
                {{--<li style="padding: 1px;"><a  href="#">Day tours</a></li>--}}
                {{--<li style="padding: 1px;"><span><a  href="#"> Guided Tours</a></span></li>--}}
                {{--<li style="padding: 1px;"><a  href="#"> Self Drive Tours</a></li>--}}
                {{--<li style="padding: 1px;"><a  href="#"> Travel Packages</a></li>--}}
                {{--<li style="padding: 1px;"><a  href="#"> Private Tours</a></li>--}}
                {{--<li style="padding: 1px;"><a  href="#"> Luxury Tours</a></li>--}}
                {{--<li style="padding: 1px;"><a  href="#"> Winter Tours</a></li>--}}
                {{--<li style="padding: 1px;"><a  href="#"> Summer Tours</a></li>--}}
            {{--</ul>--}}
            {{--</div>--}}
            {{--<div class="col-md-3">--}}
                {{--<h5>Newsletter sign up</h5>--}}
                {{--<form action="index_submit" method="get" accept-charset="utf-8">--}}
                    {{--<div class="form-group">--}}
                        {{--<input type="text" name="" class="form-control" placeholder="First Name">--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                        {{--<input type="text" name="" class="form-control" placeholder="Email ">--}}
                    {{--</div>--}}
                    {{--<button type="submit" class="btn btn-outline-default" style="border-radius: 0px"> SUBMIT </button>--}}

                {{--</form>--}}
                {{--<br>--}}
                {{--<ul class="nav list-inline">--}}
                    {{--<li><a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>--}}
                    {{--<li><a href="#" title="Twitter"><i class="fab fa-twitter"></i></a></li>--}}
                    {{--<li><a href="#" title="Linkedin"><i class="fab fa-linkedin-in"></i></a></li>--}}
                    {{--<li><a href="#" title="Instagram"><i class="fab fa-instagram"></i></a></li>--}}
                {{--</ul>--}}
            {{--</div>--}}
            {{----}}
        {{--</div>--}}
        {{--<hr class='styled' />--}}
        {{--<div class="row">--}}
            {{--<div class="col-md-"></div>--}}
          {{----}}
          {{--<div class="collink col-sm-6 col-md-6"><a  href="#" title="Weather">--}}
          {{--<i class="fas fa-map-marker-alt"></i> Reykjavik Iceland</a></div>--}}
          {{--<div class="collink col-sm-6 col-md-3">--}}
          {{--<a href="#" title=""><i class="fas fa-phone"></i>+354 779 2727</a></div>--}}
          {{--<div class="collink col-sm-6 col-md-3">--}}
          {{--<a href="#" title="">--}}
          {{--<i class="fas fa-envelope"></i></a></div>--}}
          {{----}}
        {{----}}
        {{----}}
    {{--</div>--}}
        {{----}}
    {{--</div>--}}
    {{----}}
{{--</div>--}}
{{--<div class="copy-footer container-fluid">--}}
    {{--<div class="copywrite row">--}}
            {{--<div class="col-sm-12" style="text-align: center;">Copyright © 2017 Extreme Iceland. All Rights Reserved</div>--}}
            {{----}}
        {{--</div>--}}
{{--</div>--}}