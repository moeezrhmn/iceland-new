
<header>
    <nav class="custom_navbar navbar fixed-top navbar-expand-lg">
        <a class="navbar-brand" href="{{url('/')}}">
            <img src="{{url('images/logo.png')}}" alt="Book Your Adventures">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon">
					<i class="fas fa-bars"></i>
				</span>
        </button>


        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav mr-auto">
                <li class="nav-item active submenu columnl1">
                    <a class="nav-link dropdown-toggle" href="#">Book your trip
                        <span class="sr-only">(current)</span>
                    </a>
                    <div class="subMenu_wrapper">

                        <ul>
                            <h3>By Category</h3>
                            <li>
                                <a href="#" class="hvr-underline-from-left">All tours</a>
                            </li>
                            <li>
                                <a href="#" class="hvr-underline-from-left">Day tours</a>
                            </li>
                            <li>
                                <a href="#" class="hvr-underline-from-left">Romance</a>
                            </li>
                            <li>
                                <a href="#" class="hvr-underline-from-left">family holidays</a>
                            </li>
                            <li>
                                <a href="#" class="hvr-underline-from-left">best of island</a>
                            </li>
                            <li>
                                <a href="#" class="hvr-underline-from-left">active holidays</a>
                            </li>
                            <li>
                                <a href="#" class="hvr-underline-from-left">highlands</a>
                            </li>
                        </ul>
                        <ul>
                            <h3>By lenght</h3>
                            <li>
                                <a href="#" class="hvr-underline-from-left">All tours</a>
                            </li>
                            <li>
                                <a href="#" class="hvr-underline-from-left">1 day</a><a href="#" class="hvr-underline-from-left">2 days</a>
                            </li>
                            <li>
                                <a href="#" class="hvr-underline-from-left">3 days</a><a href="#" class="hvr-underline-from-left">4 days</a>
                            </li>
                            <li>
                                <a href="#" class="hvr-underline-from-left">5 days</a><a href="#" class="hvr-underline-from-left">6 days</a>
                            </li>
                            <li>
                                <a href="#" class="hvr-underline-from-left">7 days</a><a href="#" class="hvr-underline-from-left">8 days</a>
                            </li>
                            <li>
                                <a href="#" class="hvr-underline-from-left">9 days</a><a href="#" class="hvr-underline-from-left">10 days</a>
                            </li>
                        </ul>
                        <ul>
                            <h3>By season</h3>
                            <li>
                                <a href="#" class="hvr-underline-from-left">All tours</a>
                            </li>
                            <li>
                                <a href="#" class="hvr-underline-from-left">available all year</a>
                            </li>
                            <li>
                                <a href="#" class="hvr-underline-from-left">only in summer</a>
                            </li>
                            <li>
                                <a href="#" class="hvr-underline-from-left">only in winter</a>
                            </li>
                        </ul>
                        <ul>
                            <h3>Requests</h3>
                            <li>
                                <a href="#" class="hvr-underline-from-left">Request a Private Guided Tour</a>
                            </li>
                            <li>
                                <a href="#" class="hvr-underline-from-left">Request help booking a trip</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item submenu column1">
                    <a class="nav-link dropdown-toggle" href="#">Rent a car</a>
                    <div class="subMenu_wrapper">
                        <ul>
                            <li class="submenu level2">
                                <a href="#" class="dropdown-toggle">link 1</a>
                                <div class="subMenu_wrapper">
                                    <ul>
                                        <li>
                                            <a href="#" class="hvr-underline-from-left">link 1-1</a>
                                        </li>
                                        <li>
                                            <a href="#" class="hvr-underline-from-left">link 2-1</a>
                                        </li>
                                        <li>
                                            <a href="#" class="hvr-underline-from-left">link 3-1</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a href="#" class="hvr-underline-from-left">link 2</a>
                            </li>
                            <li>
                                <a href="#" class="hvr-underline-from-left">link 3</a>
                            </li>
                            <li>
                                <a href="#" class="hvr-underline-from-left">link 4</a>
                            </li>
                            <li>
                                <a href="#" class="hvr-underline-from-left">link 5</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item submenu column1">
                    <a class="nav-link" href="#">Connect with locals</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Explore Iceland
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php
                        $subcat_act= App\Models\Category::where('parent_id',3)->where('status','Active')->get()
                        ?>
                        @if(isset($subcat_act) && !empty($subcat_act))
                            @foreach($subcat_act as $subcat)
                                <a class="dropdown-item" href="{{url('get-activities/'.$subcat->slug)}}">{{$subcat->cat_name}}</a>
                                <div class="dropdown-divider"></div>
                            @endforeach
                        @endif
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
                <a href="#" style="width: 36px;">
                    <?php
                    $items=  Darryldecode\Cart\Facades\CartFacade ::getContent()
                    ?>
                    <strong class="getCatCount">{{count(@$items)}}</strong>
                    <i class="fas fa-shopping-cart"></i>
                </a>
            </li>
            <li>
                <a href="{{url('search')}}">
                    <i class="fas fa-search"></i>
                </a>
            </li>
            <li class="nav-item dropdown choose_language">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="{{url('images/flags_03.png')}}">
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">
                        <img src="{{url('images/flags_03.png')}}">
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
                        <img src="{{url('images/flags_05.png')}}">
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">
                        <img src="{{url('images/flags_08.png')}}">
                    </a>
                </div>
            </li>
            @if(!empty(Auth::id()))
                <li>
                    <a href="#" class="user">
                        <img src="{{url('images/0.jpg')}}">
                    </a>
                    <div class="edit_user">
                        <ul>
                            <li><a href="{{url('edit-profile')}}">Edit Profile</a></li>
                            <li><a href="{{url('change-password')}}">Change Password</a></li>
                            <li><a href="{{url('logout')}}">Logout</a></li>
                        </ul>
                    </div>
                </li>
            @endif
        </ul>
    </nav>
</header>
{{--<nav class="navbar navbar-expand-lg navbar-dark bg-blue fixed-top">--}}
{{--<div class="container">--}}
{{--<a class="navbar-brand" href="{{url('/')}}"><img  src="{{url('assets/')}}/{{url('images/logo.png')}}" alt="logo"  style='margin-right:104px;' width="135px"></a>--}}
{{--<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">--}}
{{--<span class="navbar-toggler-icon"></span>--}}
{{--</button>--}}

{{--<div class="collapse navbar-collapse" id="navbarSupportedContent">--}}
{{--<ul class="navbar-nav mr-auto">--}}
{{--<li class="nav-item active">--}}
{{--<a class="nav-link" href="{{url('/')}}">Home <span class="sr-only">(current)</span></a>--}}
{{--</li>&nbsp;&nbsp;&nbsp;&nbsp;--}}
{{--<li class="nav-item">--}}
{{--<a class="nav-link" href="#">Book your trip</a>--}}
{{--</li>--}}
{{--&nbsp;&nbsp;&nbsp;&nbsp;--}}
{{--<li class="nav-item">--}}
{{--<a class="nav-link" href="#">Rent a car</a>--}}
{{--</li>&nbsp;&nbsp;&nbsp;&nbsp;--}}
{{--<li class="nav-item dropdown">--}}
{{--<a class="nav-link " href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--Explore Iceland <span class="fa fa-angle-down"></span>--}}
{{--</a>--}}
{{--<div class="dropdown-menu" aria-labelledby="navbarDropdown">--}}
{{--<a class="dropdown-item" href="#">Nature of Iceland</a>--}}
{{--<a class="dropdown-item" href="#">Travel Information</a>--}}
{{--<div class="dropdown-divider"></div>--}}
{{--<a class="dropdown-item" href="#">Reykjavik Guide</a>--}}
{{--</div>--}}
{{--</li>--}}
{{--</ul> --}}
{{--<div class="form-inline my-2 my-lg-0">--}}
{{--<ul class="nav navbar-nav navbar-right">--}}
{{--<li class="dropdown">--}}

{{--<a href="#"  data-toggle="dropdown"> <span class="fa fa-user usr"></span></a>--}}
{{--<ul id="login-dp" class="dropdown-menu dropdown-menu-left">--}}
{{--@if(!Auth::user())--}}
{{--<li>--}}
{{--<div class="row">--}}
{{--<div class="col-md-12" id="m_login">--}}
{{--Login via--}}
{{--<div class="social-buttons">--}}
{{--<a href="#" class="btn btn-fb"><i class="fab fa-facebook-f"></i> Facebook</a>--}}
{{--<a href="#" class="btn btn-tw"><i class="fab fa-twitter"></i> Twitter</a>--}}
{{--</div>--}}
{{--or--}}
{{--<form class="m-login__form m-form"   method="post" action="{{ url('/login') }}" >--}}
{{--@csrf--}}
{{--<input type="hidden" name="user" value="user">--}}
{{--<input type="hidden" name="route" value="{{url('/')}}">--}}
{{--<!--   <div class="form-group">--}}
{{--<label class="sr-only" for="exampleInputEmail2">Email address</label>--}}
{{--<input type="email"  name="email" class="form-control" id="email" placeholder="Email address" required>--}}
{{--</div> -->--}}

{{--<div class="form-group m-form__group">--}}
{{--<input id="email" type="email" class="form-control m-input{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Enter Email ID" required autofocus>--}}

{{--@if ($errors->has('email'))--}}
{{--<span class="invalid-feedback">--}}
{{--<strong>{{ $errors->first('email') }}</strong>--}}
{{--</span>--}}
{{--@endif--}}

{{--</div>--}}

{{--<!-- <div class="form-group">--}}
{{--<label class="sr-only" for="exampleInputPassword2">Password</label>--}}
{{--<input type="password" name="password" class="form-control" id="password" placeholder="Password" required>--}}
{{--<div class="help-block text-right"><a href="">Forget the password ?</a></div>--}}
{{--</div> -->--}}
{{--<div class="form-group m-form__group">--}}
{{--<input id="password" type="password" class="form-control m-input m-login__form-input--last{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Enter Password" name="password" required>--}}

{{--@if ($errors->has('password'))--}}
{{--<span class="invalid-feedback">--}}
{{--<strong>{{ $errors->first('password') }}</strong>--}}
{{--</span>--}}
{{--@endif--}}
{{--</div>--}}


{{--<div class="form-group">--}}
{{--<button type="submit" id="webLogin" class="btn btn-primary btn-block">Sign in</button>--}}
{{--<!--    <button type="submit" id="webLogin" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primary">--}}
{{--Sign In--}}
{{--</button> -->--}}
{{--</div>--}}
{{--<div class="checkbox">--}}
{{--<label>--}}
{{--<input type="checkbox"> keep me logged-in--}}
{{--</label>--}}
{{--</div>--}}
{{--</form>--}}
{{--</div>--}}
{{--<div class="bottom text-center">--}}
{{--New here ? <a href="#"><b>Join Us</b></a>--}}
{{--</div>--}}
{{--</div>--}}
{{--</li>--}}
{{--@else--}}
{{--<li>--}}
{{--<a href="">Profile</a>--}}
{{--</li>--}}
{{--<li>--}}
{{--<a href="{{url('logout')}}">Logout</a>--}}
{{--</li>--}}
{{--@endif--}}
{{--</ul>--}}
{{--</li>--}}
{{--</ul>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--}}
{{--<span class="basket-shop"><i class="fas fa-shopping-cart"></i> <sup>0</sup></span>--}}
{{--<!-- Button to Open the Modal -->--}}
{{--<button type="button" class="btn-search" data-toggle="modal" data-target="#myModal">--}}
{{--<span class="fa fa-search"></span>--}}
{{--</button>&nbsp;&nbsp;&nbsp;&nbsp;--}}
{{--<!-- <div class="pull-right">--}}
{{--<ul class="nav pull-right">--}}
{{----}}
{{--<li class="dropdown"><a href="#" class="" data-toggle="dropdown"> <img src="{{url('assets/')}}/{{url('images/0.jpg" class="avatar"></a>--}}
{{--<ul class="dropdown-menu user-menu">--}}
{{--<li><a href="/user/preferences"><i class="fa fa-cog"></i> Preferences</a></li>--}}
{{--<li><a href="/help/support"><i class="fa fa-envelope"></i> Contact Support</a></li>--}}
{{--<li class="divider"></li>--}}
{{--<li><a href="/auth/logout"><i class="fa fa-off"></i> Logout</a></li>--}}
{{--</ul>--}}
{{--</li>--}}
{{--</ul>--}}
{{--</div> -->--}}

{{----}}
{{--</form>--}}
{{--</div>--}}
{{--</div>--}}
{{--</nav>--}}