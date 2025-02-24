<header class="m-grid__item  m-header " data-minimize-mobile="hide" data-minimize-offset="200"
        data-minimize-mobile-offset="200" data-minimize="minimize">
    <div class="m-container m-container--fluid m-container--full-height">
        <div class="m-stack m-stack--ver m-stack--desktop">
            <!-- BEGIN: Brand -->
            <div class="m-stack__item m-brand  m-brand--skin-dark ">
                <div class="m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-stack__item--middle m-brand__logo">
                        <div class="m-brand__logo-wrapper" style="color: white">
                            <img style="width: 100%;" alt="Book Your Adventures" src="{{url('images/logo.png')}}"/>
                            <!-- <h4 style="font-size: 2rem;"> Guide.is</h4> -->
                        </div>
                    </div>

                    <div class="m-stack__item m-stack__item--middle m-brand__tools">
                        <!-- BEGIN: Left Aside Minimize Toggle -->
                        <a href="javascript:;" id="m_aside_left_minimize_toggle"
                           class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block">
                            <span></span>
                        </a>
                        <!-- END -->
                        <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                        <a href="javascript:;" id="m_aside_left_offcanvas_toggle"
                           class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                        </a>
                        <!-- END -->
                        <!-- BEGIN: Responsive Header Menu Toggler -->
                        <a id="m_aside_header_menu_mobile_toggle" href="javascript:;"
                           class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                        </a>
                        <!-- END -->
                        <!-- BEGIN: Topbar Toggler -->
                        <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;"
                           class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                            <i class="flaticon-more"></i>
                        </a>
                        <!-- BEGIN: Topbar Toggler -->
                    </div>
                </div>
            </div>
            <!-- END: Brand -->
            <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
                <!-- BEGIN: Horizontal Menu -->
                <div id="m_header_menu"
                     class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark ">
                    <ul class="m-menu__nav  m-menu__nav--submenu-arrow ">
                        <li class="m-menu__item  m-menu__item--submenu m-menu__item--rel"
                            data-menu-submenu-toggle="click" aria-haspopup="true">
                            <a href="#" class="m-menu__link m-menu__toggle">
                                <i class="m-menu__link-icon flaticon-layers"></i>
                                <span class="m-menu__link-text">
                                    Security
                                </span>
                                <i class="m-menu__hor-arrow la la-angle-down"></i>
                                <i class="m-menu__ver-arrow la la-angle-right"></i>
                            </a>
                            <div class="m-menu__submenu m-menu__submenu--classic m-menu__submenu--left">
                                <span class="m-menu__arrow m-menu__arrow--adjust"></span>
                                <ul class="m-menu__subnav">
                                    <li class="m-menu__item " aria-haspopup="true">
                                        <a href="{{route('users.index')}}" class="m-menu__link">
                                            <i class="m-menu__link-icon flaticon-users"></i>
                                            <span class="m-menu__link-text">
                                                Administrator
                                            </span>
                                        </a>
                                    </li>
                                <!--   <li class="m-menu__item " aria-haspopup="true">
                                        <a href="{{route('role.index')}}" class="m-menu__link">
                                            <i class="m-menu__link-icon flaticon-interface-2"></i>
                                            <span class="m-menu__link-text">
                                                Role
                                            </span>
                                        </a>
                                    </li>
                                    <li class="m-menu__item " aria-haspopup="true">
                                        <a href="{{route('permission.index')}}" class="m-menu__link">
                                            <i class="m-menu__link-icon flaticon-lock-1"></i>
                                            <span class="m-menu__link-text">
                                                Permission
                                            </span>
                                        </a>
                                    </li> -->
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- END: Horizontal Menu -->
                <!-- BEGIN: Topbar -->
                <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
                    <div class="m-stack__item m-topbar__nav-wrapper">
                        <ul class="m-topbar__nav m-nav m-nav--inline">
                            <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light"
                                data-dropdown-toggle="click">
                                <a href="#" class="m-nav__link m-dropdown__toggle">
												<span class="m-topbar__userpic">
                                                    @if(!empty(Auth::user()->user_photo))
                                                        <img style="height: 40px"
                                                             src="{{url('uploads/'.@Auth::user()->user_photo)}}"
                                                             class="m--img-rounded m--marginless m--img-centered"
                                                             alt=""/>
                                                    @else
                                                        {{  @Auth::user()->name}}

                                                    @endif
												</span>
                                    <span class="m-topbar__username m--hide">
													Nick
												</span>
                                </a>
                                <div class="m-dropdown__wrapper">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                    <div class="m-dropdown__inner">
                                        <div class="m-dropdown__header m--align-center"
                                             style="background: url('{{url('uploads/'.@Auth::user()->user_photo)}}'); background-size: cover;">
                                            <div class="m-card-user m-card-user--skin-dark">
                                                <div class="m-card-user__pic">
                                                    <img src="{{'uploads/'.@Auth::user()->user_photo}}"
                                                         class="m--img-rounded m--marginless" alt=""/>
                                                </div>
                                                <div class="m-card-user__details">

																<span class="m-card-user__name m--font-weight-500"
                                                                      style="color: black">
																	{{ @Auth::user()->name }}
																</span>
                                                    <a href="" class="m-card-user__email m--font-weight-300 m-link"
                                                       style="color: black">
                                                        {{ @Auth::user()->email }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">
                                                <ul class="m-nav m-nav--skin-light">

                                                    <li class="m-nav__item">

                                                        <a href="{{url('admin/profile')}}" class="dropdown-item ">
                                                            <i class="m-nav__link-icon flaticon-profile-1" style="padding-right: 10px;

font-size: 20px;"></i> Profile
                                                        </a>
                                                    </li>


                                                    <li class="m-nav__item">
                                                        <a href="{{url('admin/setting')}}" class="dropdown-item ">
                                                            <i class="m-nav__link-icon flaticon-profile-1"
                                                               style="padding-right: 10px;font-size: 20px;"></i>
                                                            Setting
                                                        </a>
                                                    </li>
                                                    @guest
                                                        <li><a class="m-nav__item"
                                                               href="{{ route('login') }}">{{ __('Login') }}</a></li>
                                                        <li><a class="m-nav__item"
                                                               href="{{ route('register') }}">{{ __('Register') }}</a>
                                                        </li>
                                                    @else
                                                        <li class="m-nav__item">
                                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                                               onclick="event.preventDefault();
                                                                        document.getElementById('logout-form').submit();">
                                                                <i class="m-nav__link-icon flaticon-profile-1"
                                                                   style="padding-right: 10px;font-size: 20px;"></i>
                                                                {{ __('Logout') }}
                                                            </a>

                                                            <form id="logout-form" action="{{ url('admin/logout') }}"
                                                                  method="POST" style="display: none;">
                                                                @csrf
                                                            </form>
                                                        </li>

                                                    @endguest

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- END: Topbar -->
            </div>
        </div>
    </div>
</header>
