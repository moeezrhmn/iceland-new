@extends('layouts.master')
@section('title', 'Dashboard')
@section('header_space')
    <link href="{{ asset('css/calendar.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">
                        Dashboard
                    </h3>
                </div>
                <div>
                    <span class="m-subheader__daterange" id="m_dashboard_daterangepicker">
                        <span class="m-subheader__daterange-label">
                            <span class="m-subheader__daterange-title"></span>
                            <span class="m-subheader__daterange-date m--font-brand"></span>
                        </span>
                        <a href="#"
                           class="btn btn-sm btn-brand m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill">
                            <i class="la la-angle-down"></i>
                        </a>
                    </span>
                </div>
            </div>
        </div>
        <!-- END: Subheader -->
        @yield('content-area')
        <div class="m-content">
            <!--Begin::Main Portlet-->
            <div class="row">
                <div class="col-xl-4">
                    <!--begin:: Widgets/Top Products-->
                    <div class="m-portlet m-portlet--bordered-semi m-portlet--full-height">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        Trends
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <ul class="m-portlet__nav">
                                    <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                                        data-dropdown-toggle="hover" aria-expanded="true">
                                        <a href="#"
                                           class="m-portlet__nav-link m-dropdown__toggle dropdown-toggle btn btn--sm m-btn--pill btn-secondary m-btn m-btn--label-brand">
                                            All
                                        </a>
                                        <div class="m-dropdown__wrapper">
                                                <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"
                                                      style="left: auto; right: 36.5px;"></span>
                                            <div class="m-dropdown__inner">
                                                <div class="m-dropdown__body">
                                                    <div class="m-dropdown__content">
                                                        <ul class="m-nav">
                                                            <li class="m-nav__item">
                                                                <a href="" class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                    <span class="m-nav__link-text">
																					Activity
																				</span>
                                                                </a>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a href="" class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                                    <span class="m-nav__link-text">
																					Messages
																				</span>
                                                                </a>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a href="" class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-info"></i>
                                                                    <span class="m-nav__link-text">
																					FAQ
																				</span>
                                                                </a>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a href="" class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                                                    <span class="m-nav__link-text">
																					Support
																				</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <!--begin::Widget5-->
                            <div class="m-widget4">
                                <div class="m-widget4__chart m-portlet-fit--sides m--margin-top-10 m--margin-top-20"
                                     style="height:260px;">
                                    <canvas id="m_chart_trends_stats"></canvas>
                                </div>
                                <div class="m-widget4__item">
                                    <div class="m-widget4__img m-widget4__img--logo">
                                        <img src="{{url('assets/app/media/img/client-logos/logo3.png')}}" alt="">
                                    </div>
                                    <div class="m-widget4__info">
													<span class="m-widget4__title">
														Phyton
													</span>
                                        <br>
                                        <span class="m-widget4__sub">
														A Programming Language
													</span>
                                    </div>
                                    <span class="m-widget4__ext">
													<span class="m-widget4__number m--font-danger">
														+$17
													</span>
												</span>
                                </div>
                                <div class="m-widget4__item">
                                    <div class="m-widget4__img m-widget4__img--logo">
                                        <img src="{{ url('assets/app/media/img/client-logos/logo1.png')}}" alt="">
                                    </div>
                                    <div class="m-widget4__info">
													<span class="m-widget4__title">
														FlyThemes
													</span>
                                        <br>
                                        <span class="m-widget4__sub">
														A Let's Fly Fast Again Language
													</span>
                                    </div>
                                    <span class="m-widget4__ext">
													<span class="m-widget4__number m--font-danger">
														+$300
													</span>
												</span>
                                </div>
                                <div class="m-widget4__item">
                                    <div class="m-widget4__img m-widget4__img--logo">
                                        <img src="{{ url('assets/app/media/img/client-logos/logo2.png')}}" alt="">
                                    </div>
                                    <div class="m-widget4__info">
													<span class="m-widget4__title">
														AirApp
													</span>
                                        <br>
                                        <span class="m-widget4__sub">
														Awesome App For Project Management
													</span>
                                    </div>
                                    <span class="m-widget4__ext">
													<span class="m-widget4__number m--font-danger">
														+$6700
													</span>
												</span>
                                </div>
                            </div>
                            <!--end::Widget 5-->
                        </div>
                    </div>
                    <!--end:: Widgets/Top Products-->
                </div>
                <div class="col-xl-4">
                    <!--begin:: Widgets/Activity-->
                    <div class="m-portlet m-portlet--bordered-semi m-portlet--widget-fit m-portlet--full-height m-portlet--skin-light">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text m--font-light">
                                        Activity
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <ul class="m-portlet__nav">
                                    <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                                        data-dropdown-toggle="hover">
                                        <a href="#"
                                           class="m-portlet__nav-link m-portlet__nav-link--icon m-portlet__nav-link--icon-xl">
                                            <i class="fa fa-genderless m--font-light"></i>
                                        </a>
                                        <div class="m-dropdown__wrapper">
                                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                            <div class="m-dropdown__inner">
                                                <div class="m-dropdown__body">
                                                    <div class="m-dropdown__content">
                                                        <ul class="m-nav">
                                                            <li class="m-nav__section m-nav__section--first">
																			<span class="m-nav__section-text">
																				Quick Actions
																			</span>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a href="" class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                    <span class="m-nav__link-text">
																					Activity
																				</span>
                                                                </a>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a href="" class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                                    <span class="m-nav__link-text">
																					Messages
																				</span>
                                                                </a>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a href="" class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-info"></i>
                                                                    <span class="m-nav__link-text">
																					FAQ
																				</span>
                                                                </a>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a href="" class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                                                    <span class="m-nav__link-text">
																					Support
																				</span>
                                                                </a>
                                                            </li>
                                                            <li class="m-nav__separator m-nav__separator--fit"></li>
                                                            <li class="m-nav__item">
                                                                <a href="#"
                                                                   class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">
                                                                    Cancel
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <div class="m-widget17">
                                <div class="m-widget17__visual m-widget17__visual--chart m-portlet-fit--top m-portlet-fit--sides m--bg-danger">
                                    <div class="m-widget17__chart" style="height:320px;">
                                        <canvas id="m_chart_activities"></canvas>
                                    </div>
                                </div>
                                <div class="m-widget17__stats">
                                    <div class="m-widget17__items m-widget17__items-col1">
                                        <div class="m-widget17__item">
														<span class="m-widget17__icon">
															<i class="flaticon-truck m--font-brand"></i>
														</span>
                                            <span class="m-widget17__subtitle">
															Delivered
														</span>
                                            <span class="m-widget17__desc">
															15 New Paskages
														</span>
                                        </div>
                                        <div class="m-widget17__item">
														<span class="m-widget17__icon">
															<i class="flaticon-paper-plane m--font-info"></i>
														</span>
                                            <span class="m-widget17__subtitle">
															Reporeted
														</span>
                                            <span class="m-widget17__desc">
															72 Support Cases
														</span>
                                        </div>
                                    </div>
                                    <div class="m-widget17__items m-widget17__items-col2">
                                        <div class="m-widget17__item">
														<span class="m-widget17__icon">
															<i class="flaticon-pie-chart m--font-success"></i>
														</span>
                                            <span class="m-widget17__subtitle">
															Ordered
														</span>
                                            <span class="m-widget17__desc">
															72 New Items
														</span>
                                        </div>
                                        <div class="m-widget17__item">
														<span class="m-widget17__icon">
															<i class="flaticon-time m--font-danger"></i>
														</span>
                                            <span class="m-widget17__subtitle">
															Arrived
														</span>
                                            <span class="m-widget17__desc">
															34 Upgraded Boxes
														</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end:: Widgets/Activity-->
                </div>
                <div class="col-xl-4">
                    <!--begin:: Widgets/Blog-->
                    <div class="m-portlet m-portlet--bordered-semi m-portlet--full-height">
                        <div class="m-portlet__head m-portlet__head--fit">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-action">
                                    <button type="button" class="btn btn-sm m-btn--pill  btn-brand">
                                        Blog
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <div class="m-widget19">
                                <div class="m-widget19__pic m-portlet-fit--top m-portlet-fit--sides"
                                     style1="height: 280px">
                                    <img src="{{ url('assets/app/media/img/blog/blog1.jpg')}}" alt="">
                                    <h3 class="m-widget19__title m--font-light">
                                        Introducing New Feature
                                    </h3>
                                    <div class="m-widget19__shadow"></div>
                                </div>
                                <div class="m-widget19__content">
                                    <div class="m-widget19__header">
                                        <div class="m-widget19__user-img">
                                            <img class="m-widget19__img" src="{{ url('assets/app/media/img/users/user1.jpg')}}"
                                                 alt="">
                                        </div>
                                        <div class="m-widget19__info">
														<span class="m-widget19__username">
															Anna Krox
														</span>
                                            <br>
                                            <span class="m-widget19__time">
															UX/UI Designer, Google
														</span>
                                        </div>
                                        <div class="m-widget19__stats">
														<span class="m-widget19__number m--font-brand">
															18
														</span>
                                            <span class="m-widget19__comment">
															Comments
														</span>
                                        </div>
                                    </div>
                                    <div class="m-widget19__body">
                                        Lorem Ipsum is simply dummy text of the printing and typesetting industry
                                        scrambled it to make text of the printing and typesetting industry scrambled
                                        a type specimen book text of the dummy text of the printing printing and
                                        typesetting industry scrambled dummy text of the printing.
                                    </div>
                                </div>
                                <div class="m-widget19__action">
                                    <button type="button"
                                            class="btn m-btn--pill btn-secondary m-btn m-btn--hover-brand m-btn--custom">
                                        Read More
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end:: Widgets/Blog-->
                </div>
            </div>
            <!--End::Main Portlet-->
            <!--Begin::Main Portlet-->
            <div class="m-portlet">
                <div class="m-portlet__body  m-portlet__body--no-padding">
                    <div class="row m-row--no-padding m-row--col-separator-xl">
                        <div class="col-xl-4">
                            <!--begin:: Widgets/Stats2-1 -->
                            <div class="m-widget1">
                                <div class="m-widget1__item">
                                    <div class="row m-row--no-padding align-items-center">
                                        <div class="col">
                                            <h3 class="m-widget1__title">
                                                Member Profit
                                            </h3>
                                            <span class="m-widget1__desc">
															Awerage Weekly Profit
														</span>
                                        </div>
                                        <div class="col m--align-right">
														<span class="m-widget1__number m--font-brand">
															+$17,800
														</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-widget1__item">
                                    <div class="row m-row--no-padding align-items-center">
                                        <div class="col">
                                            <h3 class="m-widget1__title">
                                                Orders
                                            </h3>
                                            <span class="m-widget1__desc">
															Weekly Customer Orders
														</span>
                                        </div>
                                        <div class="col m--align-right">
														<span class="m-widget1__number m--font-danger">
															+1,800
														</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-widget1__item">
                                    <div class="row m-row--no-padding align-items-center">
                                        <div class="col">
                                            <h3 class="m-widget1__title">
                                                Issue Reports
                                            </h3>
                                            <span class="m-widget1__desc">
															System bugs and issues
														</span>
                                        </div>
                                        <div class="col m--align-right">
														<span class="m-widget1__number m--font-success">
															-27,49%
														</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end:: Widgets/Stats2-1 -->
                        </div>
                        <div class="col-xl-4">
                            <!--begin:: Widgets/Daily Sales-->
                            <div class="m-widget14">
                                <div class="m-widget14__header m--margin-bottom-30">
                                    <h3 class="m-widget14__title">
                                        Daily Sales
                                    </h3>
                                    <span class="m-widget14__desc">
													Check out each collumn for more details
												</span>
                                </div>
                                <div class="m-widget14__chart" style="height:120px;">
                                    <canvas id="m_chart_daily_sales"></canvas>
                                </div>
                            </div>
                            <!--end:: Widgets/Daily Sales-->
                        </div>
                        <div class="col-xl-4">
                            <!--begin:: Widgets/Profit Share-->
                            <div class="m-widget14">
                                <div class="m-widget14__header">
                                    <h3 class="m-widget14__title">
                                        Profit Share
                                    </h3>
                                    <span class="m-widget14__desc">
													Profit Share between customers
												</span>
                                </div>
                                <div class="row  align-items-center">
                                    <div class="col">
                                        <div id="m_chart_profit_share" class="m-widget14__chart"
                                             style="height: 160px">
                                            <div class="m-widget14__stat">
                                                45
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="m-widget14__legends">
                                            <div class="m-widget14__legend">
                                                <span class="m-widget14__legend-bullet m--bg-accent"></span>
                                                <span class="m-widget14__legend-text">
																37% Sport Tickets
															</span>
                                            </div>
                                            <div class="m-widget14__legend">
                                                <span class="m-widget14__legend-bullet m--bg-warning"></span>
                                                <span class="m-widget14__legend-text">
																47% Business Events
															</span>
                                            </div>
                                            <div class="m-widget14__legend">
                                                <span class="m-widget14__legend-bullet m--bg-brand"></span>
                                                <span class="m-widget14__legend-text">
																19% Others
															</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end:: Widgets/Profit Share-->
                        </div>
                    </div>
                </div>
            </div>
            <!--End::Main Portlet-->
            <!--Begin::Main Portlet-->
            <div class="row">
                <div class="col-xl-6">
                    <!--begin:: Widgets/Tasks -->
                    <div class="m-portlet m-portlet--full-height">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        Tasks
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <ul class="nav nav-pills nav-pills--brand m-nav-pills--align-right m-nav-pills--btn-pill m-nav-pills--btn-sm"
                                    role="tablist">
                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link active" data-toggle="tab"
                                           href="#m_widget2_tab1_content" role="tab">
                                            Today
                                        </a>
                                    </li>
                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link" data-toggle="tab"
                                           href="#m_widget2_tab2_content1" role="tab">
                                            Week
                                        </a>
                                    </li>
                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link" data-toggle="tab"
                                           href="#m_widget2_tab3_content1" role="tab">
                                            Month
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="m_widget2_tab1_content">
                                    <div class="m-widget2">
                                        <div class="m-widget2__item m-widget2__item--primary">
                                            <div class="m-widget2__checkbox">
                                                <label class="m-checkbox m-checkbox--solid m-checkbox--single m-checkbox--brand">
                                                    <input type="checkbox">
                                                    <span></span>
                                                </label>
                                            </div>
                                            <div class="m-widget2__desc">
															<span class="m-widget2__text">
																Make Metronic Great  Again.Lorem Ipsum Amet
															</span>
                                                <br>
                                                <span class="m-widget2__user-name">
																<a href="#" class="m-widget2__link">
																	By Bob
																</a>
															</span>
                                            </div>
                                            <div class="m-widget2__actions">
                                                <div class="m-widget2__actions-nav">
                                                    <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                                                         data-dropdown-toggle="hover">
                                                        <a href="#" class="m-dropdown__toggle">
                                                            <i class="la la-ellipsis-h"></i>
                                                        </a>
                                                        <div class="m-dropdown__wrapper">
                                                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                                            <div class="m-dropdown__inner">
                                                                <div class="m-dropdown__body">
                                                                    <div class="m-dropdown__content">
                                                                        <ul class="m-nav">
                                                                            <li class="m-nav__item">
                                                                                <a href="" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                                    <span class="m-nav__link-text">
																									Activity
																								</span>
                                                                                </a>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                                                    <span class="m-nav__link-text">
																									Messages
																								</span>
                                                                                </a>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-info"></i>
                                                                                    <span class="m-nav__link-text">
																									FAQ
																								</span>
                                                                                </a>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                                                                    <span class="m-nav__link-text">
																									Support
																								</span>
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-widget2__item m-widget2__item--warning">
                                            <div class="m-widget2__checkbox">
                                                <label class="m-checkbox m-checkbox--solid m-checkbox--single m-checkbox--brand">
                                                    <input type="checkbox">
                                                    <span></span>
                                                </label>
                                            </div>
                                            <div class="m-widget2__desc">
															<span class="m-widget2__text">
																Prepare Docs For Metting On Monday
															</span>
                                                <br>
                                                <span class="m-widget2__user-name">
																<a href="#" class="m-widget2__link">
																	By Sean
																</a>
															</span>
                                            </div>
                                            <div class="m-widget2__actions">
                                                <div class="m-widget2__actions-nav">
                                                    <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                                                         data-dropdown-toggle="hover">
                                                        <a href="#" class="m-dropdown__toggle">
                                                            <i class="la la-ellipsis-h"></i>
                                                        </a>
                                                        <div class="m-dropdown__wrapper">
                                                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                                            <div class="m-dropdown__inner">
                                                                <div class="m-dropdown__body">
                                                                    <div class="m-dropdown__content">
                                                                        <ul class="m-nav">
                                                                            <li class="m-nav__item">
                                                                                <a href="" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                                    <span class="m-nav__link-text">
																									Activity
																								</span>
                                                                                </a>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                                                    <span class="m-nav__link-text">
																									Messages
																								</span>
                                                                                </a>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-info"></i>
                                                                                    <span class="m-nav__link-text">
																									FAQ
																								</span>
                                                                                </a>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                                                                    <span class="m-nav__link-text">
																									Support
																								</span>
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-widget2__item m-widget2__item--brand">
                                            <div class="m-widget2__checkbox">
                                                <label class="m-checkbox m-checkbox--solid m-checkbox--single m-checkbox--brand">
                                                    <input type="checkbox">
                                                    <span></span>
                                                </label>
                                            </div>
                                            <div class="m-widget2__desc">
															<span class="m-widget2__text">
																Make Widgets Great Again.Estudiat Communy Elit
															</span>
                                                <br>
                                                <span class="m-widget2__user-name">
																<a href="#" class="m-widget2__link">
																	By Aziko
																</a>
															</span>
                                            </div>
                                            <div class="m-widget2__actions">
                                                <div class="m-widget2__actions-nav">
                                                    <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                                                         data-dropdown-toggle="hover">
                                                        <a href="#" class="m-dropdown__toggle">
                                                            <i class="la la-ellipsis-h"></i>
                                                        </a>
                                                        <div class="m-dropdown__wrapper">
                                                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                                            <div class="m-dropdown__inner">
                                                                <div class="m-dropdown__body">
                                                                    <div class="m-dropdown__content">
                                                                        <ul class="m-nav">
                                                                            <li class="m-nav__item">
                                                                                <a href="" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                                    <span class="m-nav__link-text">
																									Activity
																								</span>
                                                                                </a>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                                                    <span class="m-nav__link-text">
																									Messages
																								</span>
                                                                                </a>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-info"></i>
                                                                                    <span class="m-nav__link-text">
																									FAQ
																								</span>
                                                                                </a>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                                                                    <span class="m-nav__link-text">
																									Support
																								</span>
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-widget2__item m-widget2__item--success">
                                            <div class="m-widget2__checkbox">
                                                <label class="m-checkbox m-checkbox--solid m-checkbox--single m-checkbox--brand">
                                                    <input type="checkbox">
                                                    <span></span>
                                                </label>
                                            </div>
                                            <div class="m-widget2__desc">
															<span class="m-widget2__text">
																Make Metronic Great Again.Lorem Ipsum
															</span>
                                                <br>
                                                <span class="m-widget2__user-name">
																<a href="#" class="m-widget2__link">
																	By James
																</a>
															</span>
                                            </div>
                                            <div class="m-widget2__actions">
                                                <div class="m-widget2__actions-nav">
                                                    <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                                                         data-dropdown-toggle="hover">
                                                        <a href="#" class="m-dropdown__toggle">
                                                            <i class="la la-ellipsis-h"></i>
                                                        </a>
                                                        <div class="m-dropdown__wrapper">
                                                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                                            <div class="m-dropdown__inner">
                                                                <div class="m-dropdown__body">
                                                                    <div class="m-dropdown__content">
                                                                        <ul class="m-nav">
                                                                            <li class="m-nav__item">
                                                                                <a href="" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                                    <span class="m-nav__link-text">
																									Activity
																								</span>
                                                                                </a>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                                                    <span class="m-nav__link-text">
																									Messages
																								</span>
                                                                                </a>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-info"></i>
                                                                                    <span class="m-nav__link-text">
																									FAQ
																								</span>
                                                                                </a>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                                                                    <span class="m-nav__link-text">
																									Support
																								</span>
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-widget2__item m-widget2__item--danger">
                                            <div class="m-widget2__checkbox">
                                                <label class="m-checkbox m-checkbox--solid m-checkbox--single m-checkbox--brand">
                                                    <input type="checkbox">
                                                    <span></span>
                                                </label>
                                            </div>
                                            <div class="m-widget2__desc">
															<span class="m-widget2__text">
																Completa Financial Report For Emirates Airlines
															</span>
                                                <br>
                                                <span class="m-widget2__user-name">
																<a href="#" class="m-widget2__link">
																	By Bob
																</a>
															</span>
                                            </div>
                                            <div class="m-widget2__actions">
                                                <div class="m-widget2__actions-nav">
                                                    <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                                                         data-dropdown-toggle="hover">
                                                        <a href="#" class="m-dropdown__toggle">
                                                            <i class="la la-ellipsis-h"></i>
                                                        </a>
                                                        <div class="m-dropdown__wrapper">
                                                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                                            <div class="m-dropdown__inner">
                                                                <div class="m-dropdown__body">
                                                                    <div class="m-dropdown__content">
                                                                        <ul class="m-nav">
                                                                            <li class="m-nav__item">
                                                                                <a href="" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                                    <span class="m-nav__link-text">
																									Activity
																								</span>
                                                                                </a>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                                                    <span class="m-nav__link-text">
																									Messages
																								</span>
                                                                                </a>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-info"></i>
                                                                                    <span class="m-nav__link-text">
																									FAQ
																								</span>
                                                                                </a>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                                                                    <span class="m-nav__link-text">
																									Support
																								</span>
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-widget2__item m-widget2__item--info">
                                            <div class="m-widget2__checkbox">
                                                <label class="m-checkbox m-checkbox--solid m-checkbox--single m-checkbox--brand">
                                                    <input type="checkbox">
                                                    <span></span>
                                                </label>
                                            </div>
                                            <div class="m-widget2__desc">
															<span class="m-widget2__text">
																Completa Financial Report For Emirates Airlines
															</span>
                                                <br>
                                                <span class="m-widget2__user-name">
																<a href="#" class="m-widget2__link">
																	By Sean
																</a>
															</span>
                                            </div>
                                            <div class="m-widget2__actions">
                                                <div class="m-widget2__actions-nav">
                                                    <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                                                         data-dropdown-toggle="hover">
                                                        <a href="#" class="m-dropdown__toggle">
                                                            <i class="la la-ellipsis-h"></i>
                                                        </a>
                                                        <div class="m-dropdown__wrapper">
                                                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                                            <div class="m-dropdown__inner">
                                                                <div class="m-dropdown__body">
                                                                    <div class="m-dropdown__content">
                                                                        <ul class="m-nav">
                                                                            <li class="m-nav__item">
                                                                                <a href="" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                                    <span class="m-nav__link-text">
																									Activity
																								</span>
                                                                                </a>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                                                    <span class="m-nav__link-text">
																									Messages
																								</span>
                                                                                </a>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-info"></i>
                                                                                    <span class="m-nav__link-text">
																									FAQ
																								</span>
                                                                                </a>
                                                                            </li>
                                                                            <li class="m-nav__item">
                                                                                <a href="" class="m-nav__link">
                                                                                    <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                                                                    <span class="m-nav__link-text">
																									Support
																								</span>
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="m_widget2_tab2_content"></div>
                                <div class="tab-pane" id="m_widget2_tab3_content"></div>
                            </div>
                        </div>
                    </div>
                    <!--end:: Widgets/Tasks -->
                </div>
                <div class="col-xl-6">
                    <!--begin:: Widgets/Support Tickets -->
                    <div class="m-portlet m-portlet--full-height">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        Support Tickets
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <ul class="m-portlet__nav">
                                    <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                                        data-dropdown-toggle="hover" aria-expanded="true">
                                        <a href="#"
                                           class="m-portlet__nav-link m-portlet__nav-link--icon m-portlet__nav-link--icon-xl m-dropdown__toggle">
                                            <i class="la la-ellipsis-h m--font-brand"></i>
                                        </a>
                                        <div class="m-dropdown__wrapper">
                                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                            <div class="m-dropdown__inner">
                                                <div class="m-dropdown__body">
                                                    <div class="m-dropdown__content">
                                                        <ul class="m-nav">
                                                            <li class="m-nav__item">
                                                                <a href="" class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                    <span class="m-nav__link-text">
																					Activity
																				</span>
                                                                </a>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a href="" class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                                    <span class="m-nav__link-text">
																					Messages
																				</span>
                                                                </a>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a href="" class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-info"></i>
                                                                    <span class="m-nav__link-text">
																					FAQ
																				</span>
                                                                </a>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a href="" class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                                                    <span class="m-nav__link-text">
																					Support
																				</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <div class="m-widget3">
                                <div class="m-widget3__item">
                                    <div class="m-widget3__header">
                                        <div class="m-widget3__user-img">
<img class="m-widget3__img" src="{{ url('assets/app/media/img/users/user1.jpg')}}"
                                                 alt="">
                                        </div>
                                        <div class="m-widget3__info">
														<span class="m-widget3__username">
															Melania Trump
														</span>
                                            <br>
                                            <span class="m-widget3__time">
															2 day ago
														</span>
                                        </div>
                                        <span class="m-widget3__status m--font-info">
														Pending
													</span>
                                    </div>
                                    <div class="m-widget3__body">
                                        <p class="m-widget3__text">
                                            Lorem ipsum dolor sit amet,consectetuer edipiscing elit,sed diam nonummy
                                            nibh euismod tinciduntut laoreet doloremagna aliquam erat volutpat.
                                        </p>
                                    </div>
                                </div>


                                <div class="m-widget3__item">
                                    <div class="m-widget3__header">
                                        <div class="m-widget3__user-img">
                                            <img class="m-widget3__img" src="{{ asset('assets/app/media/img/users/user4.jpg')}}"
                                                 alt="">
                                        </div>
                                        <div class="m-widget3__info">
														<span class="m-widget3__username">
															Lebron King James
														</span>
                                            <br>
                                            <span class="m-widget3__time">
															1 day ago
														</span>
                                        </div>
                                        <span class="m-widget3__status m--font-brand">
														Open
													</span>
                                    </div>
                                    <div class="m-widget3__body">
                                        <p class="m-widget3__text">
                                            Lorem ipsum dolor sit amet,consectetuer edipiscing elit,sed diam nonummy
                                            nibh euismod tinciduntut laoreet doloremagna aliquam erat volutpat.Ut
                                            wisi enim ad minim veniam,quis nostrud exerci tation ullamcorper.
                                        </p>
                                    </div>
                                </div>
                                <div class="m-widget3__item">
                                    <div class="m-widget3__header">
                                        <div class="m-widget3__user-img">
                                            <img class="m-widget3__img" src="{{ url('assets/app/media/img/users/user5.jpg')}}"
                                                 alt="">
                                        </div>
                                        <div class="m-widget3__info">
														<span class="m-widget3__username">
															Deb Gibson
														</span>
                                            <br>
                                            <span class="m-widget3__time">
															3 weeks ago
														</span>
                                        </div>
                                        <span class="m-widget3__status m--font-success">
														Closed
													</span>
                                    </div>
                                    <div class="m-widget3__body">
                                        <p class="m-widget3__text">
                                            Lorem ipsum dolor sit amet,consectetuer edipiscing elit,sed diam nonummy
                                            nibh euismod tinciduntut laoreet doloremagna aliquam erat volutpat.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end:: Widgets/Support Tickets -->
                </div>
            </div>
            <!--End::Main Portlet-->
            <!--Begin::Main Portlet-->
            <div class="row">
                <div class="col-xl-8">
                    <div class="m-portlet m-portlet--mobile">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        Exclusive Datatable Plugin
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <ul class="m-portlet__nav">
                                    <li class="m-portlet__nav-item">
                                        <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                                             data-dropdown-toggle="hover" aria-expanded="true">
                                            <a href="#"
                                               class="m-portlet__nav-link m-portlet__nav-link--icon m-portlet__nav-link--icon-xl m-dropdown__toggle">
                                                <i class="la la-plus m--hide"></i>
                                                <i class="la la-ellipsis-h m--font-brand"></i>
                                            </a>
                                            <div class="m-dropdown__wrapper">
                                                <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                                <div class="m-dropdown__inner">
                                                    <div class="m-dropdown__body">
                                                        <div class="m-dropdown__content">
                                                            <ul class="m-nav">
                                                                <li class="m-nav__section m-nav__section--first">
																				<span class="m-nav__section-text">
																					Quick Actions
																				</span>
                                                                </li>
                                                                <li class="m-nav__item">
                                                                    <a href="" class="m-nav__link">
                                                                        <i class="m-nav__link-icon flaticon-share"></i>
                                                                        <span class="m-nav__link-text">
																						Create Post
																					</span>
                                                                    </a>
                                                                </li>
                                                                <li class="m-nav__item">
                                                                    <a href="" class="m-nav__link">
                                                                        <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                                        <span class="m-nav__link-text">
																						Send Messages
																					</span>
                                                                    </a>
                                                                </li>
                                                                <li class="m-nav__item">
                                                                    <a href="" class="m-nav__link">
                                                                        <i class="m-nav__link-icon flaticon-multimedia-2"></i>
                                                                        <span class="m-nav__link-text">
																						Upload File
																					</span>
                                                                    </a>
                                                                </li>
                                                                <li class="m-nav__section">
																				<span class="m-nav__section-text">
																					Useful Links
																				</span>
                                                                </li>
                                                                <li class="m-nav__item">
                                                                    <a href="" class="m-nav__link">
                                                                        <i class="m-nav__link-icon flaticon-info"></i>
                                                                        <span class="m-nav__link-text">
																						FAQ
																					</span>
                                                                    </a>
                                                                </li>
                                                                <li class="m-nav__item">
                                                                    <a href="" class="m-nav__link">
                                                                        <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                                                        <span class="m-nav__link-text">
																						Support
																					</span>
                                                                    </a>
                                                                </li>
                                                                <li class="m-nav__separator m-nav__separator--fit m--hide"></li>
                                                                <li class="m-nav__item m--hide">
                                                                    <a href="#"
                                                                       class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">
                                                                        Submit
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <!--begin: Datatable -->
                            <div class="m_datatable" id="m_datatable_latest_orders"></div>
                            <!--end: Datatable -->
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <!--begin:: Widgets/Audit Log-->
                    <div class="m-portlet m-portlet--full-height">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        Audit Log
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <ul class="nav nav-pills nav-pills--brand m-nav-pills--align-right m-nav-pills--btn-pill m-nav-pills--btn-sm"
                                    role="tablist">
                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link active" data-toggle="tab"
                                           href="#m_widget4_tab1_content" role="tab">
                                            Today
                                        </a>
                                    </li>
                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link" data-toggle="tab"
                                           href="#m_widget4_tab2_content" role="tab">
                                            Week
                                        </a>
                                    </li>
                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link" data-toggle="tab"
                                           href="#m_widget4_tab3_content" role="tab">
                                            Month
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="m_widget4_tab1_content">
                                    <div class="m-scrollable" data-scrollable="true" data-max-height="400"
                                         style="height: 400px; overflow: hidden;">
                                        <div class="m-list-timeline m-list-timeline--skin-light">
                                            <div class="m-list-timeline__items">
                                                <div class="m-list-timeline__item">
                                                    <span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
                                                    <span class="m-list-timeline__text">
																	12 new users registered
																</span>
                                                    <span class="m-list-timeline__time">
																	Just now
																</span>
                                                </div>
                                                <div class="m-list-timeline__item">
                                                    <span class="m-list-timeline__badge m-list-timeline__badge--info"></span>
                                                    <span class="m-list-timeline__text">
																	System shutdown
																	<span class="m-badge m-badge--success m-badge--wide">
																		pending
																	</span>
																</span>
                                                    <span class="m-list-timeline__time">
																	14 mins
																</span>
                                                </div>
                                                <div class="m-list-timeline__item">
                                                    <span class="m-list-timeline__badge m-list-timeline__badge--danger"></span>
                                                    <span class="m-list-timeline__text">
																	New invoice received
																</span>
                                                    <span class="m-list-timeline__time">
																	20 mins
																</span>
                                                </div>
                                                <div class="m-list-timeline__item">
                                                    <span class="m-list-timeline__badge m-list-timeline__badge--accent"></span>
                                                    <span class="m-list-timeline__text">
																	DB overloaded 80%
																	<span class="m-badge m-badge--info m-badge--wide">
																		settled
																	</span>
																</span>
                                                    <span class="m-list-timeline__time">
																	1 hr
																</span>
                                                </div>
                                                <div class="m-list-timeline__item">
                                                    <span class="m-list-timeline__badge m-list-timeline__badge--warning"></span>
                                                    <span class="m-list-timeline__text">
																	System error -
																	<a href="#" class="m-link">
																		Check
																	</a>
																</span>
                                                    <span class="m-list-timeline__time">
																	2 hrs
																</span>
                                                </div>
                                                <div class="m-list-timeline__item">
                                                    <span class="m-list-timeline__badge m-list-timeline__badge--brand"></span>
                                                    <span class="m-list-timeline__text">
																	Production server down
																</span>
                                                    <span class="m-list-timeline__time">
																	3 hrs
																</span>
                                                </div>
                                                <div class="m-list-timeline__item">
                                                    <span class="m-list-timeline__badge m-list-timeline__badge--info"></span>
                                                    <span class="m-list-timeline__text">
																	Production server up
																</span>
                                                    <span class="m-list-timeline__time">
																	5 hrs
																</span>
                                                </div>
                                                <div class="m-list-timeline__item">
                                                    <span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
                                                    <span href="" class="m-list-timeline__text">
																	New order received
																	<span class="m-badge m-badge--danger m-badge--wide">
																		urgent
																	</span>
																</span>
                                                    <span class="m-list-timeline__time">
																	7 hrs
																</span>
                                                </div>
                                                <div class="m-list-timeline__item">
                                                    <span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
                                                    <span class="m-list-timeline__text">
																	12 new users registered
																</span>
                                                    <span class="m-list-timeline__time">
																	Just now
																</span>
                                                </div>
                                                <div class="m-list-timeline__item">
                                                    <span class="m-list-timeline__badge m-list-timeline__badge--info"></span>
                                                    <span class="m-list-timeline__text">
																	System shutdown
																	<span class="m-badge m-badge--success m-badge--wide">
																		pending
																	</span>
																</span>
                                                    <span class="m-list-timeline__time">
																	14 mins
																</span>
                                                </div>
                                                <div class="m-list-timeline__item">
                                                    <span class="m-list-timeline__badge m-list-timeline__badge--danger"></span>
                                                    <span class="m-list-timeline__text">
																	New invoice received
																</span>
                                                    <span class="m-list-timeline__time">
																	20 mins
																</span>
                                                </div>
                                                <div class="m-list-timeline__item">
                                                    <span class="m-list-timeline__badge m-list-timeline__badge--accent"></span>
                                                    <span class="m-list-timeline__text">
																	DB overloaded 80%
																	<span class="m-badge m-badge--info m-badge--wide">
																		settled
																	</span>
																</span>
                                                    <span class="m-list-timeline__time">
																	1 hr
																</span>
                                                </div>
                                                <div class="m-list-timeline__item">
                                                    <span class="m-list-timeline__badge m-list-timeline__badge--danger"></span>
                                                    <span class="m-list-timeline__text">
																	New invoice received
																</span>
                                                    <span class="m-list-timeline__time">
																	20 mins
																</span>
                                                </div>
                                                <div class="m-list-timeline__item">
                                                    <span class="m-list-timeline__badge m-list-timeline__badge--accent"></span>
                                                    <span class="m-list-timeline__text">
																	DB overloaded 80%
																	<span class="m-badge m-badge--info m-badge--wide">
																		settled
																	</span>
																</span>
                                                    <span class="m-list-timeline__time">
																	1 hr
																</span>
                                                </div>
                                                <div class="m-list-timeline__item">
                                                    <span class="m-list-timeline__badge m-list-timeline__badge--warning"></span>
                                                    <span class="m-list-timeline__text">
																	System error -
																	<a href="#" class="m-link">
																		Check
																	</a>
																</span>
                                                    <span class="m-list-timeline__time">
																	2 hrs
																</span>
                                                </div>
                                                <div class="m-list-timeline__item">
                                                    <span class="m-list-timeline__badge m-list-timeline__badge--brand"></span>
                                                    <span class="m-list-timeline__text">
																	Production server down
																</span>
                                                    <span class="m-list-timeline__time">
																	3 hrs
																</span>
                                                </div>
                                                <div class="m-list-timeline__item">
                                                    <span class="m-list-timeline__badge m-list-timeline__badge--info"></span>
                                                    <span class="m-list-timeline__text">
																	Production server up
																</span>
                                                    <span class="m-list-timeline__time">
																	5 hrs
																</span>
                                                </div>
                                                <div class="m-list-timeline__item">
                                                    <span class="m-list-timeline__badge m-list-timeline__badge--success"></span>
                                                    <span href="" class="m-list-timeline__text">
																	New order received
																	<span class="m-badge m-badge--danger m-badge--wide">
																		urgent
																	</span>
																</span>
                                                    <span class="m-list-timeline__time">
																	7 hrs
																</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="m_widget4_tab2_content"></div>
                                <div class="tab-pane" id="m_widget4_tab3_content"></div>
                            </div>
                        </div>
                    </div>
                    <!--end:: Widgets/Audit Log-->
                </div>
            </div>
            <!--End::Main Portlet-->
            <!--Begin::Main Portlet-->
            <div class="row">
                <div class="col-xl-4">
                    <!--begin:: Widgets/Sales Stats-->
                    <div class="m-portlet m-portlet--bordered-semi m-portlet--full-height">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        Sales Stats
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <ul class="m-portlet__nav">
                                    <li class="m-portlet__nav-item m-portlet__nav-item--last m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                                        data-dropdown-toggle="hover">
                                        <a href="#"
                                           class="m-portlet__nav-link m-portlet__nav-link--icon m-portlet__nav-link--icon-xl">
                                            <i class="fa fa-genderless m--font-brand"></i>
                                        </a>
                                        <div class="m-dropdown__wrapper">
                                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                            <div class="m-dropdown__inner">
                                                <div class="m-dropdown__body">
                                                    <div class="m-dropdown__content">
                                                        <ul class="m-nav">
                                                            <li class="m-nav__section m-nav__section--first">
																			<span class="m-nav__section-text">
																				Quick Actions
																			</span>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a href="" class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                    <span class="m-nav__link-text">
																					Activity
																				</span>
                                                                </a>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a href="" class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                                    <span class="m-nav__link-text">
																					Messages
																				</span>
                                                                </a>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a href="" class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-info"></i>
                                                                    <span class="m-nav__link-text">
																					FAQ
																				</span>
                                                                </a>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a href="" class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                                                    <span class="m-nav__link-text">
																					Support
																				</span>
                                                                </a>
                                                            </li>
                                                            <li class="m-nav__separator m-nav__separator--fit"></li>
                                                            <li class="m-nav__item">
                                                                <a href="#"
                                                                   class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">
                                                                    Cancel
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <!--begin::Widget 6-->
                            <div class="m-widget15">
                                <div class="m-widget15__chart" style="height:180px;">
                                    <canvas id="m_chart_sales_stats"></canvas>
                                </div>
                                <div class="m-widget15__items">
                                    <div class="row">
                                        <div class="col">
                                            <div class="m-widget15__item">
															<span class="m-widget15__stats">
																63%
															</span>
                                                <span class="m-widget15__text">
																Sales Grow
															</span>
                                                <div class="m--space-10"></div>
                                                <div class="progress m-progress--sm">
                                                    <div class="progress-bar bg-danger" role="progressbar"
                                                         style="width: 25%;" aria-valuenow="25" aria-valuemin="0"
                                                         aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="m-widget15__item">
															<span class="m-widget15__stats">
																54%
															</span>
                                                <span class="m-widget15__text">
																Orders Grow
															</span>
                                                <div class="m--space-10"></div>
                                                <div class="progress m-progress--sm">
                                                    <div class="progress-bar bg-warning" role="progressbar"
                                                         style="width: 40%;" aria-valuenow="50" aria-valuemin="0"
                                                         aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="m-widget15__item">
															<span class="m-widget15__stats">
																41%
															</span>
                                                <span class="m-widget15__text">
																Profit Grow
															</span>
                                                <div class="m--space-10"></div>
                                                <div class="progress m-progress--sm">
                                                    <div class="progress-bar bg-success" role="progressbar"
                                                         style="width: 55%;" aria-valuenow="75" aria-valuemin="0"
                                                         aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="m-widget15__item">
															<span class="m-widget15__stats">
																79%
															</span>
                                                <span class="m-widget15__text">
																Member Grow
															</span>
                                                <div class="m--space-10"></div>
                                                <div class="progress m-progress--sm">
                                                    <div class="progress-bar bg-primary" role="progressbar"
                                                         style="width: 60%;" aria-valuenow="100" aria-valuemin="0"
                                                         aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="m-widget15__desc">
                                    * lorem ipsum dolor sit amet consectetuer sediat elit
                                </div>
                            </div>
                            <!--end::Widget 6-->
                        </div>
                    </div>
                    <!--end:: Widgets/Sales Stats-->
                </div>
                <div class="col-xl-4">
                    <!--begin:: Widgets/Inbound Bandwidth-->
                    <div class="m-portlet m-portlet--bordered-semi m-portlet--half-height m-portlet--fit"
                         style="min-height: 300px">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        Inbound Bandwidth
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <ul class="m-portlet__nav">
                                    <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                                        data-dropdown-toggle="hover" aria-expanded="true">
                                        <a href="#"
                                           class="m-portlet__nav-link m-dropdown__toggle dropdown-toggle btn btn--sm m-btn--pill btn-secondary m-btn m-btn--label-brand">
                                            Today
                                        </a>
                                        <div class="m-dropdown__wrapper">
                                                <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"
                                                      style="left: auto; right: 36.5px;"></span>
                                            <div class="m-dropdown__inner">
                                                <div class="m-dropdown__body">
                                                    <div class="m-dropdown__content">
                                                        <ul class="m-nav">
                                                            <li class="m-nav__item">
                                                                <a href="" class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                    <span class="m-nav__link-text">
																					Activity
																				</span>
                                                                </a>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a href="" class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                                    <span class="m-nav__link-text">
																					Messages
																				</span>
                                                                </a>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a href="" class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-info"></i>
                                                                    <span class="m-nav__link-text">
																					FAQ
																				</span>
                                                                </a>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a href="" class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                                                    <span class="m-nav__link-text">
																					Support
																				</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <!--begin::Widget5-->
                            <div class="m-widget20">
                                <div class="m-widget20__number m--font-success">
                                    670
                                </div>
                                <div class="m-widget20__chart" style="height:160px;">
                                    <canvas id="m_chart_bandwidth1"></canvas>
                                </div>
                            </div>
                            <!--end::Widget 5-->
                        </div>
                    </div>
                    <!--end:: Widgets/Inbound Bandwidth-->
                    <div class="m--space-30"></div>
                    <!--begin:: Widgets/Outbound Bandwidth-->
                    <div class="m-portlet m-portlet--bordered-semi m-portlet--half-height m-portlet--fit"
                         style="min-height: 300px">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        Outbound Bandwidth
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <ul class="m-portlet__nav">
                                    <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                                        data-dropdown-toggle="hover" aria-expanded="true">
                                        <a href="#"
                                           class="m-portlet__nav-link m-dropdown__toggle dropdown-toggle btn btn--sm m-btn--pill btn-secondary m-btn m-btn--label-brand">
                                            Today
                                        </a>
                                        <div class="m-dropdown__wrapper">
                                                <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"
                                                      style="left: auto; right: 36.5px;"></span>
                                            <div class="m-dropdown__inner">
                                                <div class="m-dropdown__body">
                                                    <div class="m-dropdown__content">
                                                        <ul class="m-nav">
                                                            <li class="m-nav__item">
                                                                <a href="" class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                    <span class="m-nav__link-text">
																					Activity
																				</span>
                                                                </a>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a href="" class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                                    <span class="m-nav__link-text">
																					Messages
																				</span>
                                                                </a>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a href="" class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-info"></i>
                                                                    <span class="m-nav__link-text">
																					FAQ
																				</span>
                                                                </a>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a href="" class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                                                    <span class="m-nav__link-text">
																					Support
																				</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <!--begin::Widget5-->
                            <div class="m-widget20">
                                <div class="m-widget20__number m--font-warning">
                                    340
                                </div>
                                <div class="m-widget20__chart" style="height:160px;">
                                    <canvas id="m_chart_bandwidth2"></canvas>
                                </div>
                            </div>
                            <!--end::Widget 5-->
                        </div>
                    </div>
                    <!--end:: Widgets/Outbound Bandwidth-->
                </div>
                <div class="col-xl-4">
                    <!--begin:: Widgets/Top Products-->
                    <div class="m-portlet m-portlet--full-height m-portlet--fit">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        Top Products
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <ul class="m-portlet__nav">
                                    <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                                        data-dropdown-toggle="hover" aria-expanded="true">
                                        <a href="#"
                                           class="m-portlet__nav-link m-dropdown__toggle dropdown-toggle btn btn--sm m-btn--pill btn-secondary m-btn m-btn--label-brand">
                                            All
                                        </a>
                                        <div class="m-dropdown__wrapper">
                                                <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"
                                                      style="left: auto; right: 36.5px;"></span>
                                            <div class="m-dropdown__inner">
                                                <div class="m-dropdown__body">
                                                    <div class="m-dropdown__content">
                                                        <ul class="m-nav">
                                                            <li class="m-nav__item">
                                                                <a href="" class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                    <span class="m-nav__link-text">
																					Activity
																				</span>
                                                                </a>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a href="" class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                                    <span class="m-nav__link-text">
																					Messages
																				</span>
                                                                </a>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a href="" class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-info"></i>
                                                                    <span class="m-nav__link-text">
																					FAQ
																				</span>
                                                                </a>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a href="" class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                                                    <span class="m-nav__link-text">
																					Support
																				</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <!--begin::Widget5-->
                            <div class="m-widget4 m-widget4--chart-bottom" style="min-height: 480px">
                                <div class="m-widget4__item">
                                    <div class="m-widget4__img m-widget4__img--logo">
                                        <img src="{{ url('assets/app/media/img/client-logos/logo3.png')}}" alt="">
                                    </div>
                                    <div class="m-widget4__info">
													<span class="m-widget4__title">
														Phyton
													</span>
                                        <br>
                                        <span class="m-widget4__sub">
														A Programming Language
													</span>
                                    </div>
                                    <span class="m-widget4__ext">
													<span class="m-widget4__number m--font-brand">
														+$17
													</span>
												</span>
                                </div>
                                <div class="m-widget4__item">
                                    <div class="m-widget4__img m-widget4__img--logo">
                                        <img src="{{ url('assets/app/media/img/client-logos/logo1.png')}}" alt="">
                                    </div>
                                    <div class="m-widget4__info">
													<span class="m-widget4__title">
														FlyThemes
													</span>
                                        <br>
                                        <span class="m-widget4__sub">
														A Let's Fly Fast Again Language
													</span>
                                    </div>
                                    <span class="m-widget4__ext">
													<span class="m-widget4__number m--font-brand">
														+$300
													</span>
												</span>
                                </div>
                                <div class="m-widget4__item">
                                    <div class="m-widget4__img m-widget4__img--logo">
                                        <img src="{{ url('assets/app/media/img/client-logos/logo4.png')}}" alt="">
                                    </div>
                                    <div class="m-widget4__info">
													<span class="m-widget4__title">
														Starbucks
													</span>
                                        <br>
                                        <span class="m-widget4__sub">
														Good Coffee & Snacks
													</span>
                                    </div>
                                    <span class="m-widget4__ext">
													<span class="m-widget4__number m--font-brand">
														+$300
													</span>
												</span>
                                </div>
                                <div class="m-widget4__chart m-portlet-fit--sides m--margin-top-20"
                                     style="height:260px;">
                                    <canvas id="m_chart_trends_stats_2"></canvas>
                                </div>
                            </div>
                            <!--end::Widget 5-->
                        </div>
                    </div>
                    <!--end:: Widgets/Top Products-->
                </div>
            </div>
            <!--End::Main Portlet-->
            <!--Begin::Section-->
            <div class="row">
                <div class="col-lg-12">
                    <!--begin::Portlet-->
                    <div class="m-portlet" id="m_portlet">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
						<span class="m-portlet__head-icon">
							<i class="flaticon-map-location"></i>
						</span>
                                    <h3 class="m-portlet__head-text">
                                        Basic Calendar
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <ul class="m-portlet__nav">
                                    <li class="m-portlet__nav-item">
                                        <a href="#"
                                           class="btn btn-accent m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
								<span>
									<i class="la la-plus"></i>
									<span>Add Event</span>
								</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <div id="m_calendar" class="fc fc-unthemed fc-ltr">
                                <div class="fc-toolbar fc-header-toolbar">
                                    <div class="fc-left">
                                        <div class="fc-button-group">
                                            <button type="button"
                                                    class="fc-prev-button fc-button fc-state-default fc-corner-left">
                                                <span class="fc-icon fc-icon-left-single-arrow">

                                                </span>
                                            </button>
                                            <button type="button"
                                                    class="fc-next-button fc-button fc-state-default fc-corner-right">
                                                <span class="fc-icon fc-icon-right-single-arrow"></span>
                                            </button>
                                        </div>
                                        <button type="button"
                                                class="fc-today-button fc-button fc-state-default fc-corner-left fc-corner-right fc-state-disabled"
                                                disabled="">
                                            today
                                        </button>
                                    </div>
                                    <div class="fc-right">
                                        <div class="fc-button-group">
                                            <button type="button"
                                                    class="fc-month-button fc-button fc-state-default fc-corner-left fc-state-active">
                                                month
                                            </button>
                                            <button type="button"
                                                    class="fc-agendaWeek-button fc-button fc-state-default">
                                                week
                                            </button>
                                            <button type="button"
                                                    class="fc-agendaDay-button fc-button fc-state-default">
                                                day
                                            </button>
                                            <button type="button"
                                                    class="fc-listWeek-button fc-button fc-state-default fc-corner-right">
                                                list
                                            </button>
                                        </div>
                                    </div>
                                    <div class="fc-center">
                                        <h2>April 2018</h2>
                                    </div>
                                    <div class="fc-clear">
                                    </div>
                                </div>
                                <div class="fc-view-container" style="">
                                    <div class="fc-view fc-month-view fc-basic-view" style="">
                                        <table class="">
                                            <thead class="fc-head">
                                            <tr>
                                                <td class="fc-head-container fc-widget-header">
                                                    <div class="fc-row fc-widget-header">
                                                        <table class="">
                                                            <thead>
                                                            <tr>
                                                                <th class="fc-day-header fc-widget-header fc-sun">
                                                                    <span>Sun</span>
                                                                </th>
                                                                <th class="fc-day-header fc-widget-header fc-mon">
                                                                    <span>Mon</span>
                                                                </th>
                                                                <th class="fc-day-header fc-widget-header fc-tue"><span>Tue</span>
                                                                </th>
                                                                <th class="fc-day-header fc-widget-header fc-wed"><span>Wed</span>
                                                                </th>
                                                                <th class="fc-day-header fc-widget-header fc-thu"><span>Thu</span>
                                                                </th>
                                                                <th class="fc-day-header fc-widget-header fc-fri"><span>Fri</span>
                                                                </th>
                                                                <th class="fc-day-header fc-widget-header fc-sat"><span>Sat</span>
                                                                </th>
                                                            </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                            </thead>
                                            <tbody class="fc-body">
                                            <tr>
                                                <td class="fc-widget-content">
                                                    <div class="fc-scroller fc-day-grid-container"
                                                         style="overflow: hidden; height: 676px;">
                                                        <div class="fc-day-grid fc-unselectable">
                                                            <div class="fc-row fc-week fc-widget-content fc-rigid"
                                                                 style="height: 112px;">
                                                                <div class="fc-bg">
                                                                    <table class="">
                                                                        <tbody>
                                                                        <tr>
                                                                            <td class="fc-day fc-widget-content fc-sun fc-past"
                                                                                data-date="2018-04-01"></td>
                                                                            <td class="fc-day fc-widget-content fc-mon fc-past"
                                                                                data-date="2018-04-02"></td>
                                                                            <td class="fc-day fc-widget-content fc-tue fc-past"
                                                                                data-date="2018-04-03"></td>
                                                                            <td class="fc-day fc-widget-content fc-wed fc-past"
                                                                                data-date="2018-04-04"></td>
                                                                            <td class="fc-day fc-widget-content fc-thu fc-past"
                                                                                data-date="2018-04-05"></td>
                                                                            <td class="fc-day fc-widget-content fc-fri fc-past"
                                                                                data-date="2018-04-06"></td>
                                                                            <td class="fc-day fc-widget-content fc-sat fc-past"
                                                                                data-date="2018-04-07"></td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="fc-content-skeleton">
                                                                    <table>
                                                                        <thead>
                                                                        <tr>
                                                                            <td class="fc-day-top fc-sun fc-past"
                                                                                data-date="2018-04-01"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-04-01&quot;,&quot;type&quot;:&quot;day&quot;}">1</a>
                                                                            </td>
                                                                            <td class="fc-day-top fc-mon fc-past"
                                                                                data-date="2018-04-02"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-04-02&quot;,&quot;type&quot;:&quot;day&quot;}">2</a>
                                                                            </td>
                                                                            <td class="fc-day-top fc-tue fc-past"
                                                                                data-date="2018-04-03"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-04-03&quot;,&quot;type&quot;:&quot;day&quot;}">3</a>
                                                                            </td>
                                                                            <td class="fc-day-top fc-wed fc-past"
                                                                                data-date="2018-04-04"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-04-04&quot;,&quot;type&quot;:&quot;day&quot;}">4</a>
                                                                            </td>
                                                                            <td class="fc-day-top fc-thu fc-past"
                                                                                data-date="2018-04-05"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-04-05&quot;,&quot;type&quot;:&quot;day&quot;}">5</a>
                                                                            </td>
                                                                            <td class="fc-day-top fc-fri fc-past"
                                                                                data-date="2018-04-06"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-04-06&quot;,&quot;type&quot;:&quot;day&quot;}">6</a>
                                                                            </td>
                                                                            <td class="fc-day-top fc-sat fc-past"
                                                                                data-date="2018-04-07"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-04-07&quot;,&quot;type&quot;:&quot;day&quot;}">7</a>
                                                                            </td>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr>
                                                                            <td class="fc-event-container"><a
                                                                                        class="fc-day-grid-event fc-h-event fc-event fc-start fc-end m-fc-event--danger m-fc-event--solid-warning fc-draggable fc-resizable"
                                                                                        data-original-title="" title="">
                                                                                    <div class="fc-content"><span
                                                                                                class="fc-title">All Day Event</span>
                                                                                    </div>
                                                                                    <div class="fc-resizer fc-end-resizer"></div>
                                                                                </a></td>
                                                                            <td class="fc-event-container"><a
                                                                                        class="fc-day-grid-event fc-h-event fc-event fc-start fc-end m-fc-event--primary fc-draggable fc-resizable"
                                                                                        data-original-title="" title="">
                                                                                    <div class="fc-content"><span
                                                                                                class="fc-title">Company Trip</span>
                                                                                    </div>
                                                                                    <div class="fc-resizer fc-end-resizer"></div>
                                                                                </a></td>
                                                                            <td class="fc-event-container" colspan="2">
                                                                                <a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end m-fc-event--light m-fc-event--solid-primary fc-draggable fc-resizable"
                                                                                   data-original-title="" title="">
                                                                                    <div class="fc-content"><span
                                                                                                class="fc-title">ICT Expo 2017 - Product Release</span>
                                                                                    </div>
                                                                                    <div class="fc-resizer fc-end-resizer"></div>
                                                                                </a></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="fc-row fc-week fc-widget-content fc-rigid"
                                                                 style="height: 112px;">
                                                                <div class="fc-bg">
                                                                    <table class="">
                                                                        <tbody>
                                                                        <tr>
                                                                            <td class="fc-day fc-widget-content fc-sun fc-past"
                                                                                data-date="2018-04-08"></td>
                                                                            <td class="fc-day fc-widget-content fc-mon fc-past"
                                                                                data-date="2018-04-09"></td>
                                                                            <td class="fc-day fc-widget-content fc-tue fc-past"
                                                                                data-date="2018-04-10"></td>
                                                                            <td class="fc-day fc-widget-content fc-wed fc-past"
                                                                                data-date="2018-04-11"></td>
                                                                            <td class="fc-day fc-widget-content fc-thu fc-past"
                                                                                data-date="2018-04-12"></td>
                                                                            <td class="fc-day fc-widget-content fc-fri fc-past"
                                                                                data-date="2018-04-13"></td>
                                                                            <td class="fc-day fc-widget-content fc-sat fc-past"
                                                                                data-date="2018-04-14"></td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="fc-content-skeleton">
                                                                    <table>
                                                                        <thead>
                                                                        <tr>
                                                                            <td class="fc-day-top fc-sun fc-past"
                                                                                data-date="2018-04-08"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-04-08&quot;,&quot;type&quot;:&quot;day&quot;}">8</a>
                                                                            </td>
                                                                            <td class="fc-day-top fc-mon fc-past"
                                                                                data-date="2018-04-09"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-04-09&quot;,&quot;type&quot;:&quot;day&quot;}">9</a>
                                                                            </td>
                                                                            <td class="fc-day-top fc-tue fc-past"
                                                                                data-date="2018-04-10"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-04-10&quot;,&quot;type&quot;:&quot;day&quot;}">10</a>
                                                                            </td>
                                                                            <td class="fc-day-top fc-wed fc-past"
                                                                                data-date="2018-04-11"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-04-11&quot;,&quot;type&quot;:&quot;day&quot;}">11</a>
                                                                            </td>
                                                                            <td class="fc-day-top fc-thu fc-past"
                                                                                data-date="2018-04-12"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-04-12&quot;,&quot;type&quot;:&quot;day&quot;}">12</a>
                                                                            </td>
                                                                            <td class="fc-day-top fc-fri fc-past"
                                                                                data-date="2018-04-13"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-04-13&quot;,&quot;type&quot;:&quot;day&quot;}">13</a>
                                                                            </td>
                                                                            <td class="fc-day-top fc-sat fc-past"
                                                                                data-date="2018-04-14"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-04-14&quot;,&quot;type&quot;:&quot;day&quot;}">14</a>
                                                                            </td>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td class="fc-event-container"><a
                                                                                        class="fc-day-grid-event fc-h-event fc-event fc-start fc-end m-fc-event--danger fc-draggable"
                                                                                        data-original-title="" title="">
                                                                                    <div class="fc-content"><span
                                                                                                class="fc-time">4p</span>
                                                                                        <span class="fc-title">Repeating Event</span>
                                                                                    </div>
                                                                                </a></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td class="fc-event-container"><a
                                                                                        class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable fc-resizable"
                                                                                        data-original-title="" title="">
                                                                                    <div class="fc-content"><span
                                                                                                class="fc-title">Dinner</span>
                                                                                    </div>
                                                                                    <div class="fc-resizer fc-end-resizer"></div>
                                                                                </a></td>
                                                                            <td></td>
                                                                            <td class="fc-event-container"><a
                                                                                        class="fc-day-grid-event fc-h-event fc-event fc-start fc-end m-fc-event--accent fc-draggable"
                                                                                        data-original-title="" title="">
                                                                                    <div class="fc-content"><span
                                                                                                class="fc-time">1:30p</span>
                                                                                        <span class="fc-title">Reporting</span>
                                                                                    </div>
                                                                                </a></td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="fc-row fc-week fc-widget-content fc-rigid"
                                                                 style="height: 112px;">
                                                                <div class="fc-bg">
                                                                    <table class="">
                                                                        <tbody>
                                                                        <tr>
                                                                            <td class="fc-day fc-widget-content fc-sun fc-past"
                                                                                data-date="2018-04-15"></td>
                                                                            <td class="fc-day fc-widget-content fc-mon fc-past"
                                                                                data-date="2018-04-16"></td>
                                                                            <td class="fc-day fc-widget-content fc-tue fc-past"
                                                                                data-date="2018-04-17"></td>
                                                                            <td class="fc-day fc-widget-content fc-wed fc-past"
                                                                                data-date="2018-04-18"></td>
                                                                            <td class="fc-day fc-widget-content fc-thu fc-past"
                                                                                data-date="2018-04-19"></td>
                                                                            <td class="fc-day fc-widget-content fc-fri fc-past"
                                                                                data-date="2018-04-20"></td>
                                                                            <td class="fc-day fc-widget-content fc-sat fc-past"
                                                                                data-date="2018-04-21"></td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="fc-content-skeleton">
                                                                    <table>
                                                                        <thead>
                                                                        <tr>
                                                                            <td class="fc-day-top fc-sun fc-past"
                                                                                data-date="2018-04-15"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-04-15&quot;,&quot;type&quot;:&quot;day&quot;}">15</a>
                                                                            </td>
                                                                            <td class="fc-day-top fc-mon fc-past"
                                                                                data-date="2018-04-16"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-04-16&quot;,&quot;type&quot;:&quot;day&quot;}">16</a>
                                                                            </td>
                                                                            <td class="fc-day-top fc-tue fc-past"
                                                                                data-date="2018-04-17"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-04-17&quot;,&quot;type&quot;:&quot;day&quot;}">17</a>
                                                                            </td>
                                                                            <td class="fc-day-top fc-wed fc-past"
                                                                                data-date="2018-04-18"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-04-18&quot;,&quot;type&quot;:&quot;day&quot;}">18</a>
                                                                            </td>
                                                                            <td class="fc-day-top fc-thu fc-past"
                                                                                data-date="2018-04-19"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-04-19&quot;,&quot;type&quot;:&quot;day&quot;}">19</a>
                                                                            </td>
                                                                            <td class="fc-day-top fc-fri fc-past"
                                                                                data-date="2018-04-20"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-04-20&quot;,&quot;type&quot;:&quot;day&quot;}">20</a>
                                                                            </td>
                                                                            <td class="fc-day-top fc-sat fc-past"
                                                                                data-date="2018-04-21"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-04-21&quot;,&quot;type&quot;:&quot;day&quot;}">21</a>
                                                                            </td>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td class="fc-event-container"><a
                                                                                        class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable"
                                                                                        data-original-title="" title="">
                                                                                    <div class="fc-content"><span
                                                                                                class="fc-time">4p</span>
                                                                                        <span class="fc-title">Repeating Event</span>
                                                                                    </div>
                                                                                </a></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="fc-row fc-week fc-widget-content fc-rigid"
                                                                 style="height: 112px;">
                                                                <div class="fc-bg">
                                                                    <table class="">
                                                                        <tbody>
                                                                        <tr>
                                                                            <td class="fc-day fc-widget-content fc-sun fc-past"
                                                                                data-date="2018-04-22"></td>
                                                                            <td class="fc-day fc-widget-content fc-mon fc-past"
                                                                                data-date="2018-04-23"></td>
                                                                            <td class="fc-day fc-widget-content fc-tue fc-today "
                                                                                data-date="2018-04-24"></td>
                                                                            <td class="fc-day fc-widget-content fc-wed fc-future"
                                                                                data-date="2018-04-25"></td>
                                                                            <td class="fc-day fc-widget-content fc-thu fc-future"
                                                                                data-date="2018-04-26"></td>
                                                                            <td class="fc-day fc-widget-content fc-fri fc-future"
                                                                                data-date="2018-04-27"></td>
                                                                            <td class="fc-day fc-widget-content fc-sat fc-future"
                                                                                data-date="2018-04-28"></td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="fc-content-skeleton">
                                                                    <table>
                                                                        <thead>
                                                                        <tr>
                                                                            <td class="fc-day-top fc-sun fc-past"
                                                                                data-date="2018-04-22"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-04-22&quot;,&quot;type&quot;:&quot;day&quot;}">22</a>
                                                                            </td>
                                                                            <td class="fc-day-top fc-mon fc-past"
                                                                                data-date="2018-04-23"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-04-23&quot;,&quot;type&quot;:&quot;day&quot;}">23</a>
                                                                            </td>
                                                                            <td class="fc-day-top fc-tue fc-today "
                                                                                data-date="2018-04-24"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-04-24&quot;,&quot;type&quot;:&quot;day&quot;}">24</a>
                                                                            </td>
                                                                            <td class="fc-day-top fc-wed fc-future"
                                                                                data-date="2018-04-25"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-04-25&quot;,&quot;type&quot;:&quot;day&quot;}">25</a>
                                                                            </td>
                                                                            <td class="fc-day-top fc-thu fc-future"
                                                                                data-date="2018-04-26"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-04-26&quot;,&quot;type&quot;:&quot;day&quot;}">26</a>
                                                                            </td>
                                                                            <td class="fc-day-top fc-fri fc-future"
                                                                                data-date="2018-04-27"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-04-27&quot;,&quot;type&quot;:&quot;day&quot;}">27</a>
                                                                            </td>
                                                                            <td class="fc-day-top fc-sat fc-future"
                                                                                data-date="2018-04-28"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-04-28&quot;,&quot;type&quot;:&quot;day&quot;}">28</a>
                                                                            </td>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr>
                                                                            <td rowspan="6"></td>
                                                                            <td class="fc-event-container" colspan="2">
                                                                                <a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end m-fc-event--accent fc-draggable fc-resizable"
                                                                                   data-original-title="" title="">
                                                                                    <div class="fc-content"><span
                                                                                                class="fc-title">Conference</span>
                                                                                    </div>
                                                                                    <div class="fc-resizer fc-end-resizer"></div>
                                                                                </a></td>
                                                                            <td class="fc-event-container" rowspan="6">
                                                                                <a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end m-fc-event--primary fc-draggable"
                                                                                   data-original-title="" title="">
                                                                                    <div class="fc-content"><span
                                                                                                class="fc-time">7a</span>
                                                                                        <span class="fc-title">Birthday Party</span>
                                                                                    </div>
                                                                                </a></td>
                                                                            <td rowspan="6"></td>
                                                                            <td rowspan="6"></td>
                                                                            <td class="fc-event-container" rowspan="6">
                                                                                <a class="fc-day-grid-event fc-h-event fc-event fc-start fc-end m-fc-event--solid-info m-fc-event--light fc-draggable fc-resizable"
                                                                                   href="http://google.com/"
                                                                                   data-original-title="" title="">
                                                                                    <div class="fc-content"><span
                                                                                                class="fc-title">Click for Google</span>
                                                                                    </div>
                                                                                    <div class="fc-resizer fc-end-resizer"></div>
                                                                                </a></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td rowspan="5"></td>
                                                                            <td class="fc-event-container fc-limited"><a
                                                                                        class="fc-day-grid-event fc-h-event fc-event fc-start fc-end fc-draggable"
                                                                                        data-original-title="" title="">
                                                                                    <div class="fc-content"><span
                                                                                                class="fc-time">10:30a</span>
                                                                                        <span class="fc-title">Meeting</span>
                                                                                    </div>
                                                                                </a></td>
                                                                            <td class="fc-more-cell" rowspan="1">
                                                                                <div><a class="fc-more">+5 more</a>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr class="fc-limited">
                                                                            <td class="fc-event-container"><a
                                                                                        class="fc-day-grid-event fc-h-event fc-event fc-start fc-end m-fc-event--info fc-draggable"
                                                                                        data-original-title="" title="">
                                                                                    <div class="fc-content"><span
                                                                                                class="fc-time">12p</span>
                                                                                        <span class="fc-title">Lunch</span>
                                                                                    </div>
                                                                                </a></td>
                                                                        </tr>
                                                                        <tr class="fc-limited">
                                                                            <td class="fc-event-container"><a
                                                                                        class="fc-day-grid-event fc-h-event fc-event fc-start fc-end m-fc-event--warning fc-draggable"
                                                                                        data-original-title="" title="">
                                                                                    <div class="fc-content"><span
                                                                                                class="fc-time">2:30p</span>
                                                                                        <span class="fc-title">Meeting</span>
                                                                                    </div>
                                                                                </a></td>
                                                                        </tr>
                                                                        <tr class="fc-limited">
                                                                            <td class="fc-event-container"><a
                                                                                        class="fc-day-grid-event fc-h-event fc-event fc-start fc-end m-fc-event--metal fc-draggable"
                                                                                        data-original-title="" title="">
                                                                                    <div class="fc-content"><span
                                                                                                class="fc-time">5:30p</span>
                                                                                        <span class="fc-title">Happy Hour</span>
                                                                                    </div>
                                                                                </a></td>
                                                                        </tr>
                                                                        <tr class="fc-limited">
                                                                            <td class="fc-event-container"><a
                                                                                        class="fc-day-grid-event fc-h-event fc-event fc-start fc-end m-fc-event--solid-focus m-fc-event--light fc-draggable"
                                                                                        data-original-title="" title="">
                                                                                    <div class="fc-content"><span
                                                                                                class="fc-time">8p</span>
                                                                                        <span class="fc-title">Dinner</span>
                                                                                    </div>
                                                                                </a></td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="fc-row fc-week fc-widget-content fc-rigid"
                                                                 style="height: 112px;">
                                                                <div class="fc-bg">
                                                                    <table class="">
                                                                        <tbody>
                                                                        <tr>
                                                                            <td class="fc-day fc-widget-content fc-sun fc-future"
                                                                                data-date="2018-04-29"></td>
                                                                            <td class="fc-day fc-widget-content fc-mon fc-future"
                                                                                data-date="2018-04-30"></td>
                                                                            <td class="fc-day fc-widget-content fc-tue fc-other-month fc-future"
                                                                                data-date="2018-05-01"></td>
                                                                            <td class="fc-day fc-widget-content fc-wed fc-other-month fc-future"
                                                                                data-date="2018-05-02"></td>
                                                                            <td class="fc-day fc-widget-content fc-thu fc-other-month fc-future"
                                                                                data-date="2018-05-03"></td>
                                                                            <td class="fc-day fc-widget-content fc-fri fc-other-month fc-future"
                                                                                data-date="2018-05-04"></td>
                                                                            <td class="fc-day fc-widget-content fc-sat fc-other-month fc-future"
                                                                                data-date="2018-05-05"></td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="fc-content-skeleton">
                                                                    <table>
                                                                        <thead>
                                                                        <tr>
                                                                            <td class="fc-day-top fc-sun fc-future"
                                                                                data-date="2018-04-29"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-04-29&quot;,&quot;type&quot;:&quot;day&quot;}">29</a>
                                                                            </td>
                                                                            <td class="fc-day-top fc-mon fc-future"
                                                                                data-date="2018-04-30"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-04-30&quot;,&quot;type&quot;:&quot;day&quot;}">30</a>
                                                                            </td>
                                                                            <td class="fc-day-top fc-tue fc-other-month fc-future"
                                                                                data-date="2018-05-01"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-05-01&quot;,&quot;type&quot;:&quot;day&quot;}">1</a>
                                                                            </td>
                                                                            <td class="fc-day-top fc-wed fc-other-month fc-future"
                                                                                data-date="2018-05-02"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-05-02&quot;,&quot;type&quot;:&quot;day&quot;}">2</a>
                                                                            </td>
                                                                            <td class="fc-day-top fc-thu fc-other-month fc-future"
                                                                                data-date="2018-05-03"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-05-03&quot;,&quot;type&quot;:&quot;day&quot;}">3</a>
                                                                            </td>
                                                                            <td class="fc-day-top fc-fri fc-other-month fc-future"
                                                                                data-date="2018-05-04"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-05-04&quot;,&quot;type&quot;:&quot;day&quot;}">4</a>
                                                                            </td>
                                                                            <td class="fc-day-top fc-sat fc-other-month fc-future"
                                                                                data-date="2018-05-05"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-05-05&quot;,&quot;type&quot;:&quot;day&quot;}">5</a>
                                                                            </td>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div class="fc-row fc-week fc-widget-content fc-rigid"
                                                                 style="height: 116px;">
                                                                <div class="fc-bg">
                                                                    <table class="">
                                                                        <tbody>
                                                                        <tr>
                                                                            <td class="fc-day fc-widget-content fc-sun fc-other-month fc-future"
                                                                                data-date="2018-05-06"></td>
                                                                            <td class="fc-day fc-widget-content fc-mon fc-other-month fc-future"
                                                                                data-date="2018-05-07"></td>
                                                                            <td class="fc-day fc-widget-content fc-tue fc-other-month fc-future"
                                                                                data-date="2018-05-08"></td>
                                                                            <td class="fc-day fc-widget-content fc-wed fc-other-month fc-future"
                                                                                data-date="2018-05-09"></td>
                                                                            <td class="fc-day fc-widget-content fc-thu fc-other-month fc-future"
                                                                                data-date="2018-05-10"></td>
                                                                            <td class="fc-day fc-widget-content fc-fri fc-other-month fc-future"
                                                                                data-date="2018-05-11"></td>
                                                                            <td class="fc-day fc-widget-content fc-sat fc-other-month fc-future"
                                                                                data-date="2018-05-12"></td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="fc-content-skeleton">
                                                                    <table>
                                                                        <thead>
                                                                        <tr>
                                                                            <td class="fc-day-top fc-sun fc-other-month fc-future"
                                                                                data-date="2018-05-06"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-05-06&quot;,&quot;type&quot;:&quot;day&quot;}">6</a>
                                                                            </td>
                                                                            <td class="fc-day-top fc-mon fc-other-month fc-future"
                                                                                data-date="2018-05-07"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-05-07&quot;,&quot;type&quot;:&quot;day&quot;}">7</a>
                                                                            </td>
                                                                            <td class="fc-day-top fc-tue fc-other-month fc-future"
                                                                                data-date="2018-05-08"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-05-08&quot;,&quot;type&quot;:&quot;day&quot;}">8</a>
                                                                            </td>
                                                                            <td class="fc-day-top fc-wed fc-other-month fc-future"
                                                                                data-date="2018-05-09"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-05-09&quot;,&quot;type&quot;:&quot;day&quot;}">9</a>
                                                                            </td>
                                                                            <td class="fc-day-top fc-thu fc-other-month fc-future"
                                                                                data-date="2018-05-10"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-05-10&quot;,&quot;type&quot;:&quot;day&quot;}">10</a>
                                                                            </td>
                                                                            <td class="fc-day-top fc-fri fc-other-month fc-future"
                                                                                data-date="2018-05-11"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-05-11&quot;,&quot;type&quot;:&quot;day&quot;}">11</a>
                                                                            </td>
                                                                            <td class="fc-day-top fc-sat fc-other-month fc-future"
                                                                                data-date="2018-05-12"><a
                                                                                        class="fc-day-number"
                                                                                        data-goto="{&quot;date&quot;:&quot;2018-05-12&quot;,&quot;type&quot;:&quot;day&quot;}">12</a>
                                                                            </td>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td></td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Portlet-->
                </div>
            </div>
            <!--End::Section-->
            <!--Begin::Main Portlet-->
            <div class="row">
                <div class="col-xl-8">
                    <!--begin:: Widgets/Best Sellers-->
                    <div class="m-portlet m-portlet--full-height">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        Best Sellers
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <ul class="nav nav-pills nav-pills--brand m-nav-pills--align-right m-nav-pills--btn-pill m-nav-pills--btn-sm"
                                    role="tablist">
                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link active" data-toggle="tab"
                                           href="#m_widget5_tab1_content" role="tab">
                                            Last Month
                                        </a>
                                    </li>
                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link" data-toggle="tab"
                                           href="#m_widget5_tab2_content" role="tab">
                                            last Year
                                        </a>
                                    </li>
                                    <li class="nav-item m-tabs__item">
                                        <a class="nav-link m-tabs__link" data-toggle="tab"
                                           href="#m_widget5_tab3_content" role="tab">
                                            All time
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <!--begin::Content-->
                            <div class="tab-content">
                                <div class="tab-pane active" id="m_widget5_tab1_content" aria-expanded="true">
                                    <!--begin::m-widget5-->
                                    <div class="m-widget5">
                                        <div class="m-widget5__item">
                                            <div class="m-widget5__pic">
                                                <img class="m-widget7__img"
                                                     src="{{ url('assets/app/media/img//products/product6.jpg')}}" alt="">
                                            </div>
                                            <div class="m-widget5__content">
                                                <h4 class="m-widget5__title">
                                                    Great Logo Designn
                                                </h4>
                                                <span class="m-widget5__desc">
																Make Metronic Great  Again.Lorem Ipsum Amet
															</span>
                                                <div class="m-widget5__info">
																<span class="m-widget5__author">
																	Author:
																</span>
                                                    <span class="m-widget5__info-label">
																	author:
																</span>
                                                    <span class="m-widget5__info-author-name">
																	Fly themes
																</span>
                                                    <span class="m-widget5__info-label">
																	Released:
																</span>
                                                    <span class="m-widget5__info-date m--font-info">
																	23.08.17
																</span>
                                                </div>
                                            </div>
                                            <div class="m-widget5__stats1">
															<span class="m-widget5__number">
																19,200
															</span>
                                                <br>
                                                <span class="m-widget5__sales">
																sales
															</span>
                                            </div>
                                            <div class="m-widget5__stats2">
															<span class="m-widget5__number">
																1046
															</span>
                                                <br>
                                                <span class="m-widget5__votes">
																votes
															</span>
                                            </div>
                                        </div>
                                        <div class="m-widget5__item">
                                            <div class="m-widget5__pic">
                                                <img class="m-widget7__img"
                                                     src="{{ url('assets/app/media/img//products/product10.jpg')}}" alt="">
                                            </div>
                                            <div class="m-widget5__content">
                                                <h4 class="m-widget5__title">
                                                    Branding Mockup
                                                </h4>
                                                <span class="m-widget5__desc">
																Make Metronic Great  Again.Lorem Ipsum Amet
															</span>
                                                <div class="m-widget5__info">
																<span class="m-widget5__author">
																	Author:
																</span>
                                                    <span class="m-widget5__info-author m--font-info">
																	Fly themes
																</span>
                                                    <span class="m-widget5__info-label">
																	Released:
																</span>
                                                    <span class="m-widget5__info-date m--font-info">
																	23.08.17
																</span>
                                                </div>
                                            </div>
                                            <div class="m-widget5__stats1">
															<span class="m-widget5__number">
																24,583
															</span>
                                                <br>
                                                <span class="m-widget5__sales">
																sales
															</span>
                                            </div>
                                            <div class="m-widget5__stats2">
															<span class="m-widget5__number">
																3809
															</span>
                                                <br>
                                                <span class="m-widget5__votes">
																votes
															</span>
                                            </div>
                                        </div>
                                        <div class="m-widget5__item">
                                            <div class="m-widget5__pic">
                                                <img class="m-widget7__img"
                                                     src="{{ url('assets/app/media/img//products/product11.jpg')}}" alt="">
                                            </div>
                                            <div class="m-widget5__content">
                                                <h4 class="m-widget5__title">
                                                    Awesome Mobile App
                                                </h4>
                                                <span class="m-widget5__desc">
																Make Metronic Great  Again.Lorem Ipsum Amet
															</span>
                                                <div class="m-widget5__info">
																<span class="m-widget5__author">
																	Author:
																</span>
                                                    <span class="m-widget5__info-author m--font-info">
																	Fly themes
																</span>
                                                    <span class="m-widget5__info-label">
																	Released:
																</span>
                                                    <span class="m-widget5__info-date m--font-info">
																	23.08.17
																</span>
                                                </div>
                                            </div>
                                            <div class="m-widget5__stats1">
															<span class="m-widget5__number">
																10,054
															</span>
                                                <br>
                                                <span class="m-widget5__sales">
																sales
															</span>
                                            </div>
                                            <div class="m-widget5__stats2">
															<span class="m-widget5__number">
																1103
															</span>
                                                <br>
                                                <span class="m-widget5__votes">
																votes
															</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::m-widget5-->
                                </div>
                                <div class="tab-pane" id="m_widget5_tab2_content" aria-expanded="false">
                                    <!--begin::m-widget5-->
                                    <div class="m-widget5">
                                        <div class="m-widget5__item">
                                            <div class="m-widget5__pic">
                                                <img class="m-widget7__img"
                                                     src="{{ url('assets/app/media/img//products/product11.jpg')}}" alt="">
                                            </div>
                                            <div class="m-widget5__content">
                                                <h4 class="m-widget5__title">
                                                    Branding Mockup
                                                </h4>
                                                <span class="m-widget5__desc">
																Make Metronic Great  Again.Lorem Ipsum Amet
															</span>
                                                <div class="m-widget5__info">
																<span class="m-widget5__author">
																	Author:
																</span>
                                                    <span class="m-widget5__info-author m--font-info">
																	Fly themes
																</span>
                                                    <span class="m-widget5__info-label">
																	Released:
																</span>
                                                    <span class="m-widget5__info-date m--font-info">
																	23.08.17
																</span>
                                                </div>
                                            </div>
                                            <div class="m-widget5__stats1">
															<span class="m-widget5__number">
																24,583
															</span>
                                                <br>
                                                <span class="m-widget5__sales">
																sales
															</span>
                                            </div>
                                            <div class="m-widget5__stats2">
															<span class="m-widget5__number">
																3809
															</span>
                                                <br>
                                                <span class="m-widget5__votes">
																votes
															</span>
                                            </div>
                                        </div>
                                        <div class="m-widget5__item">
                                            <div class="m-widget5__pic">
                                                <img class="m-widget7__img"
                                                     src="{{ url('assets/app/media/img//products/product6.jpg')}}" alt="">
                                            </div>
                                            <div class="m-widget5__content">
                                                <h4 class="m-widget5__title">
                                                    Great Logo Designn
                                                </h4>
                                                <span class="m-widget5__desc">
																Make Metronic Great  Again.Lorem Ipsum Amet
															</span>
                                                <div class="m-widget5__info">
																<span class="m-widget5__author">
																	Author:
																</span>
                                                    <span class="m-widget5__info-author m--font-info">
																	Fly themes
																</span>
                                                    <span class="m-widget5__info-label">
																	Released:
																</span>
                                                    <span class="m-widget5__info-date m--font-info">
																	23.08.17
																</span>
                                                </div>
                                            </div>
                                            <div class="m-widget5__stats1">
															<span class="m-widget5__number">
																19,200
															</span>
                                                <br>
                                                <span class="m-widget5__sales">
																sales
															</span>
                                            </div>
                                            <div class="m-widget5__stats2">
															<span class="m-widget5__number">
																1046
															</span>
                                                <br>
                                                <span class="m-widget5__votes">
																votes
															</span>
                                            </div>
                                        </div>
                                        <div class="m-widget5__item">
                                            <div class="m-widget5__pic">
                                                <img class="m-widget7__img"
                                                     src="{{ url('assets/app/media/img//products/product10.jpg')}}" alt="">
                                            </div>
                                            <div class="m-widget5__content">
                                                <h4 class="m-widget5__title">
                                                    Awesome Mobile App
                                                </h4>
                                                <span class="m-widget5__desc">
																Make Metronic Great  Again.Lorem Ipsum Amet
															</span>
                                                <div class="m-widget5__info">
																<span class="m-widget5__author">
																	Author:
																</span>
                                                    <span class="m-widget5__info-author m--font-info">
																	Fly themes
																</span>
                                                    <span class="m-widget5__info-label">
																	Released:
																</span>
                                                    <span class="m-widget5__info-date m--font-info">
																	23.08.17
																</span>
                                                </div>
                                            </div>
                                            <div class="m-widget5__stats1">
															<span class="m-widget5__number">
																10,054
															</span>
                                                <br>
                                                <span class="m-widget5__sales">
																sales
															</span>
                                            </div>
                                            <div class="m-widget5__stats2">
															<span class="m-widget5__number">
																1103
															</span>
                                                <br>
                                                <span class="m-widget5__votes">
																votes
															</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::m-widget5-->
                                </div>
                                <div class="tab-pane" id="m_widget5_tab3_content" aria-expanded="false">
                                    <!--begin::m-widget5-->
                                    <div class="m-widget5">
                                        <div class="m-widget5__item">
                                            <div class="m-widget5__pic">
                                                <img class="m-widget7__img"
                                                     src="{{ url('assets/app/media/img//products/product10.jpg')}}" alt="">
                                            </div>
                                            <div class="m-widget5__content">
                                                <h4 class="m-widget5__title">
                                                    Branding Mockup
                                                </h4>
                                                <span class="m-widget5__desc">
																Make Metronic Great  Again.Lorem Ipsum Amet
															</span>
                                                <div class="m-widget5__info">
																<span class="m-widget5__author">
																	Author:
																</span>
                                                    <span class="m-widget5__info-author m--font-info">
																	Fly themes
																</span>
                                                    <span class="m-widget5__info-label">
																	Released:
																</span>
                                                    <span class="m-widget5__info-date m--font-info">
																	23.08.17
																</span>
                                                </div>
                                            </div>
                                            <div class="m-widget5__stats1">
															<span class="m-widget5__number">
																10.054
															</span>
                                                <br>
                                                <span class="m-widget5__sales">
																sales
															</span>
                                            </div>
                                            <div class="m-widget5__stats2">
															<span class="m-widget5__number">
																1103
															</span>
                                                <br>
                                                <span class="m-widget5__votes">
																votes
															</span>
                                            </div>
                                        </div>
                                        <div class="m-widget5__item">
                                            <div class="m-widget5__pic">
                                                <img class="m-widget7__img"
                                                     src="{{ url('assets/app/media/img//products/product11.jpg')}}" alt="">
                                            </div>
                                            <div class="m-widget5__content">
                                                <h4 class="m-widget5__title">
                                                    Great Logo Designn
                                                </h4>
                                                <span class="m-widget5__desc">
																Make Metronic Great  Again.Lorem Ipsum Amet
															</span>
                                                <div class="m-widget5__info">
																<span class="m-widget5__author">
																	Author:
																</span>
                                                    <span class="m-widget5__info-author m--font-info">
																	Fly themes
																</span>
                                                    <span class="m-widget5__info-label">
																	Released:
																</span>
                                                    <span class="m-widget5__info-date m--font-info">
																	23.08.17
																</span>
                                                </div>
                                            </div>
                                            <div class="m-widget5__stats1">
															<span class="m-widget5__number">
																24,583
															</span>
                                                <br>
                                                <span class="m-widget5__sales">
																sales
															</span>
                                            </div>
                                            <div class="m-widget5__stats2">
															<span class="m-widget5__number">
																3809
															</span>
                                                <br>
                                                <span class="m-widget5__votes">
																votes
															</span>
                                            </div>
                                        </div>
                                        <div class="m-widget5__item">
                                            <div class="m-widget5__pic">
                                                <img class="m-widget7__img"
                                                     src="{{ url('assets/app/media/img//products/product6.jpg')}}" alt="">
                                            </div>
                                            <div class="m-widget5__content">
                                                <h4 class="m-widget5__title">
                                                    Awesome Mobile App
                                                </h4>
                                                <span class="m-widget5__desc">
																Make Metronic Great  Again.Lorem Ipsum Amet
															</span>
                                                <div class="m-widget5__info">
																<span class="m-widget5__author">
																	Author:
																</span>
                                                    <span class="m-widget5__info-author m--font-info">
																	Fly themes
																</span>
                                                    <span class="m-widget5__info-label">
																	Released:
																</span>
                                                    <span class="m-widget5__info-date m--font-info">
																	23.08.17
																</span>
                                                </div>
                                            </div>
                                            <div class="m-widget5__stats1">
															<span class="m-widget5__number">
																19,200
															</span>
                                                <br>
                                                <span class="m-widget5__sales">
																1046
															</span>
                                            </div>
                                            <div class="m-widget5__stats2">
															<span class="m-widget5__number">
																1046
															</span>
                                                <br>
                                                <span class="m-widget5__votes">
																votes
															</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::m-widget5-->
                                </div>
                            </div>
                            <!--end::Content-->
                        </div>
                    </div>
                    <!--end:: Widgets/Best Sellers-->
                </div>
                <div class="col-xl-4">
                    <!--begin:: Widgets/Authors Profit-->
                    <div class="m-portlet m-portlet--bordered-semi m-portlet--full-height">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        Authors Profit
                                    </h3>
                                </div>
                            </div>
                            <div class="m-portlet__head-tools">
                                <ul class="m-portlet__nav">
                                    <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                                        data-dropdown-toggle="hover">
                                        <a href="#"
                                           class="m-portlet__nav-link m-dropdown__toggle dropdown-toggle btn btn--sm m-btn--pill btn-secondary m-btn m-btn--label-brand">
                                            All
                                        </a>
                                        <div class="m-dropdown__wrapper">
                                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                            <div class="m-dropdown__inner">
                                                <div class="m-dropdown__body">
                                                    <div class="m-dropdown__content">
                                                        <ul class="m-nav">
                                                            <li class="m-nav__section m-nav__section--first">
																			<span class="m-nav__section-text">
																				Quick Actions
																			</span>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a href="" class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                                    <span class="m-nav__link-text">
																					Activity
																				</span>
                                                                </a>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a href="" class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                                    <span class="m-nav__link-text">
																					Messages
																				</span>
                                                                </a>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a href="" class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-info"></i>
                                                                    <span class="m-nav__link-text">
																					FAQ
																				</span>
                                                                </a>
                                                            </li>
                                                            <li class="m-nav__item">
                                                                <a href="" class="m-nav__link">
                                                                    <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                                                    <span class="m-nav__link-text">
																					Support
																				</span>
                                                                </a>
                                                            </li>
                                                            <li class="m-nav__separator m-nav__separator--fit"></li>
                                                            <li class="m-nav__item">
                                                                <a href="#"
                                                                   class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">
                                                                    Cancel
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="m-portlet__body">
                            <div class="m-widget4">
                                <div class="m-widget4__item">
                                    <div class="m-widget4__img m-widget4__img--logo">
                                        <img src="{{ url('assets/app/media/img/client-logos/logo5.png')}}" alt="">
                                    </div>
                                    <div class="m-widget4__info">
                                        <span class="m-widget4__title">
                                            Trump Themes
                                        </span>
                                        <br>
                                        <span class="m-widget4__sub">
                                            Make Metronic Great Again
                                        </span>
                                    </div>
                                    <span class="m-widget4__ext">
                                        <span class="m-widget4__number m--font-brand">
                                            +$2500
                                        </span>
                                    </span>
                                </div>
                                <div class="m-widget4__item">
                                    <div class="m-widget4__img m-widget4__img--logo">
                                        <img src="{{ url('assets/app/media/img/client-logos/logo4.png')}}" alt="">
                                    </div>
                                    <div class="m-widget4__info">
                                        <span class="m-widget4__title">
                                            StarBucks
                                        </span>
                                        <br>
                                        <span class="m-widget4__sub">
                                            Good Coffee & Snacks
                                        </span>
                                    </div>
                                    <span class="m-widget4__ext">
                                        <span class="m-widget4__number m--font-brand">
                                            -$290
                                        </span>
                                    </span>
                                </div>
                                <div class="m-widget4__item">
                                    <div class="m-widget4__img m-widget4__img--logo">
                                        <img src="{{ url('assets/app/media/img/client-logos/logo3.png')}}" alt="">
                                    </div>
                                    <div class="m-widget4__info">
                                        <span class="m-widget4__title">
                                            Phyton
                                        </span>
                                        <br>
                                        <span class="m-widget4__sub">
                                            A Programming Language
                                        </span>
                                    </div>
                                    <span class="m-widget4__ext">
                                        <span class="m-widget4__number m--font-brand">
                                            +$17
                                        </span>
                                    </span>
                                </div>
                                <div class="m-widget4__item">
                                    <div class="m-widget4__img m-widget4__img--logo">
                                        <img src="{{ url('assets/app/media/img/client-logos/logo2.png')}}" alt="">
                                    </div>
                                    <div class="m-widget4__info">
                                        <span class="m-widget4__title">
                                            GreenMakers
                                        </span>
                                        <br>
                                        <span class="m-widget4__sub">
                                            Make Green Great Again
                                        </span>
                                    </div>
                                    <span class="m-widget4__ext">
                                        <span class="m-widget4__number m--font-brand">
                                            -$2.50
                                        </span>
                                    </span>
                                </div>
                                <div class="m-widget4__item">
                                    <div class="m-widget4__img m-widget4__img--logo">
                                        <img src="{{ url('assets/app/media/img/client-logos/logo1.png')}}" alt="">
                                    </div>
                                    <div class="m-widget4__info">
                                        <span class="m-widget4__title">
                                            FlyThemes
                                        </span>
                                        <br>
                                        <span class="m-widget4__sub">
                                            A Let's Fly Fast Again Language
                                        </span>
                                    </div>
                                    <span class="m-widget4__ext">
                                        <span class="m-widget4__number m--font-brand">
                                            +$200
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end:: Widgets/Authors Profit-->
                </div>
            </div>
            <!--End::Main Portlet-->m
        </div>
    </div>
@endsection
<script src="{{ asset('assets/app/js/dashboard.js')}}"></script>
<script src="{{ asset('assets/app/js/calendar.js')}}"></script>
<script src="{{ asset('assets/app/js/calendar-responsive.js')}}"></script>

