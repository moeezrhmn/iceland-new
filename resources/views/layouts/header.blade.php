<style>
    .dropdown-menu.show{
        min-height: 100px;
        max-height: 20em;
        overflow-y: scroll;
    }
</style>
<header>

    <nav class="custom_navbar navbar fixed-top navbar-expand-lg">
        <a class="navbar-brand" href="{{url('/')}}">
            <img src="{{url('images/logo.png')}}" alt="Book Your Adventures">
        </a>
        {{--<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>--}}
        {{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>--}}
        <button class="navbar-toggler" type="button" id="navbar" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon">
					<i class="fas fa-bars"></i>
					{{--<i class="fa fa-close d-none d-md-block"></i>--}}
				</span>
            {{--<style>--}}
                {{--@media screen and (max-width: 441px){--}}
                    {{--.navbar-toggler-icon{--}}
                        {{--color: red;--}}
                    {{--}--}}
                {{--}--}}
            {{--</style>--}}
                {{--<span class="">--}}

                {{--</span>--}}
        </button>
@php
$ActiviySubcat = \App\Models\Category::select('id','cat_name','slug','order_no')->where('parent_id',3)->where('status','Active')->orderBy('order_no')->get();
@endphp
        <div class="collapse navbar-collapse"  id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active submenu columnl1">
                    <a class="nav-link dropdown-toggle" href="#">Book your Adventures
                        <span class="sr-only"></span>
                    </a>
                    <div class="subMenu_wrapper">
                        <ul>
                            @for($i=0; $i<8; $i++)
                            <li>
                                <a href="{{url('tours/'.$ActiviySubcat[$i]->slug)}}" class="hvr-underline-from-left">{{$ActiviySubcat[$i]->cat_name}}</a>
                            </li>
                            @endfor
                        </ul>
                        <ul>
                            {{--<h3>By lenght</h3>--}}
                            @for($i=8; $i<16; $i++)
                                <li>
                                    <a href="{{url('tours/'.$ActiviySubcat[$i]->slug)}}" class="hvr-underline-from-left">{{$ActiviySubcat[$i]->cat_name}}</a>
                                </li>
                            @endfor
                            {{--<li>--}}
                                {{--<a href="#" class="hvr-underline-from-left">All tours</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="#" class="hvr-underline-from-left">1 day</a><a href="#" class="hvr-underline-from-left">2 days</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="#" class="hvr-underline-from-left">3 days</a><a href="#" class="hvr-underline-from-left">4 days</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="#" class="hvr-underline-from-left">5 days</a><a href="#" class="hvr-underline-from-left">6 days</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="#" class="hvr-underline-from-left">7 days</a><a href="#" class="hvr-underline-from-left">8 days</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<a href="#" class="hvr-underline-from-left">9 days</a><a href="#" class="hvr-underline-from-left">10 days</a>--}}
                            {{--</li>--}}
                        </ul>
                        <ul>
                            <h3>On Request</h3>
                            @for($i=16; $i<22; $i++)
                                <li>
                                    <a href="{{url('tours/'.$ActiviySubcat[$i]->slug)}}" class="hvr-underline-from-left">{{$ActiviySubcat[$i]->cat_name}}</a>
                                </li>
                            @endfor
                        </ul>
                    </div>
                </li>
                <li class="nav-item submenu column1">
                    <a class="nav-link" href="{{url('tours/day-tours')}}">Day Tours</a>

                </li>
                <li class="nav-item submenu column1">

                    <a class="nav-link" href="{{url('tours/northern-lights-tours')}}">Northern Lights</a>

                </li>
                <li class="nav-item submenu column1">
                    <a class="nav-link" href="{{url('tours/all-tours')}}">  All Tours</a>
                </li>
                <li class="nav-item submenu column1">
                    {{--<a class="nav-link" href="#">Northern Lights</a>--}}
                    <a class="nav-link dropdown-toggle" href="#">Discover Iceland</a>
                    <div class="subMenu_wrapper">
                        <ul>
                            <li>
                                <a href="{{url('search?plc=places-to-visit')}}" class="hvr-underline-from-left">Places of Interests</a>
                            </li>
                            <li>
                                <a href="{{url('search?rst=restaurant')}}" class="hvr-underline-from-left">Restaurants</a>
                            </li>
                            <li>
                                <a href="{{url('article')}}" class="hvr-underline-from-left">Articles</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
        <ul class="account_cart_links my-2 my-lg-0">
            @if(empty(Auth::id()))
                <li>
                    <a href="#" data-toggle="modal" data-target=".user_login">Login</a>
                </li>
                <li>
                    <a href="#" data-toggle="modal" data-target=".user_signup">
                        <span>|</span>Signup
                    </a>
                </li>
            @endif
            <li>
                <a href="#">
                    {{--<i class="fas fa-shopping-cart"></i>--}}
                </a>
            </li>
            <li>
                <a href="{{url('search')}}">
                    <i class="fas fa-search"></i>
                </a>
            </li>
            <li class="nav-item dropdown choose_language">
                {{--<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
                    {{--<img src="{{url('images/flags_03.png')}}">--}}
                {{--</a>--}}
                {{--<div class="dropdown-menu" aria-labelledby="navbarDropdown">--}}
                    {{--<a class="dropdown-item" href="#">--}}
                        {{--<img src="{{url('images/flags_03.png')}}">--}}
                    {{--</a>--}}
                    {{--<div class="dropdown-divider"></div>--}}
                    {{--<a class="dropdown-item" href="#">--}}
                        {{--<img src="{{url('images/flags_05.png')}}">--}}
                    {{--</a>--}}
                    {{--<div class="dropdown-divider"></div>--}}
                    {{--<a class="dropdown-item" href="#">--}}
                        {{--<img src="{{url('images/flags_08.png')}}">--}}
                    {{--</a>--}}
                {{--</div>--}}
            </li>
            @if(!empty(Auth::id()))
                <li>
                    <a href="#" class="user">
                         {{--/*  */--}}
                        @if(isset($edit_user->user_photo) && !empty($edit_user->user_photo))
                        <img height="35px" alt="Visit Iceland on Guide.is" src="{{url('uploads/'.@$edit_user->user_photo)}}">
                            @else
                            <img  height="35px" alt="Visit Iceland on Guide.is" src="{{url('images/0.jpg')}}">
                        @endif
                    </a>
                    <div class="edit_user"  style="padding: 7px;font-weight: bold;width: 400%;">
                        <ul>
                            <li><a href="{{url('edit-profile')}}" style="margin-left: -10px;"><i class="fa fa-user-circle-o" style="font-size:13px"></i>Edit Profile</a></li>
                            <li><a href="{{url('change-password')}}"><i class="fa fa-lock" style="font-size:13px;margin-left: -12px;"></i>Change Password</a></li>
                            <li style="margin-top: 10px;margin-bottom: 10px;"><a href="{{url('favourites-listing')}}"><i class='fas fa-heart' style='font-size:13px'></i> &nbsp;&nbsp;My Favourites</a></li>
                            <li style="margin-top: -7px;"><a href="{{url('logout')}}" style="margin-left: -10px;"><i class="fa fa-sign-out" style="font-size:13px"></i>Logout</a></li>
                        </ul>
                    </div>
                </li>
            @endif
        </ul>
    </nav>
</header>