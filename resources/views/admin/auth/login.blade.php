<html lang="en" >
<!-- begin::Head -->
<head>
    <meta charset="utf-8" />
    <title>
        Travel | Login
    </title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]},
            active: function () {
                sessionStorage.fonts = true;
            }
        });


        window.togSales = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

    <script src="{{ asset('js/jquery.js') }}"></script>
    <!--end::Web font -->
    <!--begin::Base Styles -->
    <link href="{{ asset('assets/vendors/base/vendors.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/demo/default/base/style.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css"/>
    <!--end::Base Styles -->
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.ico') }}"/>
</head>
<!-- end::Head -->
<!-- end::Body -->
<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--singin m-login--2 m-login-2--skin-1" id="m_login" style="background-image:url( {{asset('/assets/app/media/img//bg/bg-1.jpg')}});">
        <div class="m-grid__item m-grid__item--fluid	m-login__wrapper">
            <div class="m-login__container">
                <div class="m-login__logo">
                    <a href="#">
                        <img src="{{asset('/assets/app/media/img//logos/logo-1.png')}}" style="width: 65%;">
                    </a>
                </div>
                <div class="m-login__signin">
                    <div class="m-login__head">
                        <h3 class="m-login__title">
                            Sign In To Admin
                        </h3>
                    </div>
                    <form class="m-login__form m-form" method="POST" action="{{ route('login')}}">
                        @csrf
                        <!-- <input type="hidden" name="route" value="{{URL::previous()}}"> -->
                         <input type="hidden" name="route" value="{{url('admin/dashboard')}}">
                        <div class="form-group m-form__group">
                            <input id="email" type="email" class="form-control m-input{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Enter Email ID" required autofocus>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif

                        </div>
                        <div class="form-group m-form__group">
                            <input id="password" type="password" class="form-control m-input m-login__form-input--last{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Enter Password" name="password" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>
                        <div class="row m-login__form-sub">
                         <!--    <div class="col m--align-left m-login__form-left">
                                <label class="m-checkbox  m-checkbox--light">
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                                    <span></span>
                                </label>
                            </div> -->
                            <div class="col m--align-right m-login__form-right">
                                <a class="m-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            </div>
                        </div>
                        <div class="m-login__form-action">
                            <button type="submit" id="m_login_signin_submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primary">
                                Sign In
                            </button>
                        </div>

                    </form>
                </div>
                <div class="m-login__signup">
                    <div class="m-login__head">
                        <h3 class="m-login__title">
                            Sign Up
                        </h3>
                        <div class="m-login__desc">
                            Enter your details to create your account:
                        </div>
                    </div>
                    <form class="m-login__form m-form" action="">
                        <div class="form-group m-form__group">
                            <input class="form-control m-input" type="text" placeholder="Fullname" name="fullname">
                        </div>
                        <div class="form-group m-form__group">
                            <input class="form-control m-input" type="text" placeholder="Email" name="email" autocomplete="off">
                        </div>
                        <div class="form-group m-form__group">
                            <input class="form-control m-input" type="password" placeholder="Password" name="password">
                        </div>
                        <div class="form-group m-form__group">
                            <input class="form-control m-input m-login__form-input--last" type="password" placeholder="Confirm Password" name="rpassword">
                        </div>
                        <div class="row form-group m-form__group m-login__form-sub">
                            <div class="col m--align-left">
                                <label class="m-checkbox m-checkbox--light">
                                    <input type="checkbox" name="agree">
                                    I Agree the
                                    <a href="#" class="m-link m-link--focus">
                                        terms and conditions
                                    </a>
                                    .
                                    <span></span>
                                </label>
                                <span class="m-form__help"></span>
                            </div>
                        </div>
                        <div class="m-login__form-action">
                            <button id="m_login_signup_submit" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">
                                Sign Up
                            </button>
                            &nbsp;&nbsp;
                            <button id="m_login_signup_cancel" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
                {{--<div class="m-login__forget-password">--}}
                    {{--<div class="m-login__head">--}}
                        {{--<h3 class="m-login__title">--}}
                            {{--Forgotten Password ?--}}
                        {{--</h3>--}}
                        {{--<div class="m-login__desc">--}}
                            {{--Enter your email to reset your password:--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<form class="m-login__form m-form" action="">--}}
                        {{--<div class="form-group m-form__group">--}}
                            {{--<input class="form-control m-input" type="text" placeholder="Email" name="email" id="m_email" autocomplete="off">--}}
                        {{--</div>--}}
                        {{--<div class="m-login__form-action">--}}
                            {{--<button type="submit" id="m_login_forget_password_submit" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">--}}
                                {{--Request--}}
                            {{--</button>--}}
                            {{--&nbsp;&nbsp;--}}
                            {{--<button id="m_login_forget_password_cancel" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn">--}}
                                {{--Cancel--}}
                            {{--</button>--}}
                        {{--</div>--}}
                    {{--</form>--}}
                {{--</div>--}}
                {{--<div class="m-login__account">--}}
							{{--<span class="m-login__account-msg">--}}
								{{--Don't have an account yet ?--}}
							{{--</span>--}}
                    {{--&nbsp;&nbsp;--}}
                    {{--<a href="javascript:;" id="m_login_signup" class="m-link m-link--light m-login__account-link">--}}
                        {{--Sign Up--}}
                    {{--</a>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>
</div>
<!-- end:: Page -->
<!--begin::Base Scripts -->
<script src="{{ asset('assets/vendors/base/vendors.bundle.js') }}"></script>
<script src="{{ asset('assets/demo/default/base/scripts.bundle.js') }}"></script>
<!--end::Base Scripts -->
<!--begin::Page Snippets -->
<script src="{{asset('/assets/snippets/pages/user/login.js')}}" type="text/javascript"></script>
<!--end::Page Snippets -->
</body>
<!-- end::Body -->
</html>



