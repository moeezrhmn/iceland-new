<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">
    <!-- BEGIN: Aside Menu -->
    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark "
            data-menu-vertical="true"
            data-menu-scrollable="false" data-menu-dropdown-timeout="500">
        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
            <li class="m-menu__item @if(route('dashboard') == URL::current()) m-menu__item--active @endif" aria-haspopup="true">
                <a href="{{url('admin/dashboard')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon flaticon-line-graph"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                                Dashboard
                            </span>
                            <span class="m-menu__link-badge">
                                <span class="m-badge m-badge--danger">
                                    15
                                </span>
                            </span>
                        </span>
                    </span>
                </a>
            </li>
           <!--  <li class="m-menu__item @if(route('orders.index') == URL::current()) m-menu__item--active @endif" aria-haspopup="true">
                <a href="{{url('/orders')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon flaticon-line-graph"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                                Order
                            </span>
                        </span>
                    </span>
                </a>
            </li> -->
            <li class="m-menu__section">
                <h4 class="m-menu__section-text">
                    Sections
                </h4>
                <i class="m-menu__section-icon flaticon-more-v3"></i>
            </li>
            <li class="m-menu__item  m-menu__item--submenu @if(route('users.index') == URL::current() || route('permission.index') == URL::current()|| route('role.index') == URL::current() || route('administrator.index') == URL::current()) m-menu__item--open m-menu__item--expanded @endif" aria-haspopup="true"
                data-menu-submenu-toggle="hover">
                <a href="#" class="m-menu__link m-menu__toggle">
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">
                        Security
                    </span>
                    <i class="m-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="m-menu__submenu">
                    <span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">

                        <li class="m-menu__item @if(route('administrator.index') == URL::current())  m-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{route('administrator.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot ">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">
                                    Administrators
                                </span>
                            </a>
                        </li>

                        <li class="m-menu__item @if(route('users.index') == URL::current())  m-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{route('users.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot ">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">
                                   Staff Users
                                </span>
                            </a>
                        </li>
                  <li class="m-menu__item @if(route('role.index') == URL::current())  m-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{route('role.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">
                                    Role
                                </span>
                            </a>
                        </li>
                        <li class="m-menu__item @if(route('permission.index') == URL::current())  m-menu__item--active @endif" aria-haspopup="true">
                            <a href="{{route('permission.index')}}" class="m-menu__link ">
                                <i class="m-menu__link-bullet m-menu__link-bullet--dot">
                                    <span></span>
                                </i>
                                <span class="m-menu__link-text">
                                    Permissions
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="m-menu__item @if(route('users.index') == URL::current()) m-menu__item--active @endif" aria-haspopup="true">
                <a href="{{url('admin/customers')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon fa
fa-database "></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                                Customers
                            </span>
                        </span>
                    </span>
                </a>
            </li>

 <li class="m-menu__item @if(route('categories.index') == URL::current()) m-menu__item--active @endif" aria-haspopup="true">
                <a href="{{url('admin/categories')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon fa 
fa-database "></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                                Categories
                            </span>
                        </span>
                    </span>
                </a>
            </li>
            <li class="m-menu__item @if(route('subcategories.index') == URL::current()) m-menu__item--active @endif" aria-haspopup="true">
                <a href="{{url('admin/subcategories')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon flaticon-line-graph"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                                SubCategories
                            </span>
                        </span>
                    </span>
                </a>
            </li>

            <li class="m-menu__item @if(url('admin/keywords') == URL::current()) m-menu__item--active @endif" aria-haspopup="true">
                <a href="{{url('admin/keywords')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon fa fa-tags"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                                Keywords
                            </span>
                        </span>
                    </span>
                </a>
            </li>

            <li class="m-menu__item @if(url('admin/activities') == URL::current()) m-menu__item--active @endif" aria-haspopup="true">
                <a href="{{url('admin/activities')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon fa
fa-paper-plane "></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                               Activities
                            </span>
                        </span>
                    </span>
                </a>
            </li>

            <li class="m-menu__item @if(route('places.index') == URL::current()) m-menu__item--active @endif" aria-haspopup="true">
                <a href="{{url('admin/places')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon fa
fa-paper-plane "></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                                Places of Interests
                            </span>
                        </span>
                    </span>
                </a>
            </li>

              <li class="m-menu__item @if(url('admin/restaurants') == URL::current()) m-menu__item--active @endif" aria-haspopup="true">
                <a href="{{url('admin/restaurants')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon fa
fa-paper-plane "></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                                Restaurants
                            </span>
                        </span>
                    </span>
                </a>
            </li>
          <li class="m-menu__item @if(url('admin/suppliers') == URL::current()) m-menu__item--active @endif" aria-haspopup="true">
                <a href="{{url('admin/suppliers')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon fa
fa-paper-plane "></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                               Suppliers
                            </span>
                        </span>
                    </span>
                </a>
            </li>

            <li class="m-menu__item @if(route('articles.index') == URL::current()) m-menu__item--active @endif" aria-haspopup="true">
                <a href="{{url('admin/articles')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon fa
fa-paper-plane "></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                                Articles
                            </span>
                        </span>
                    </span>
                </a>
            </li>

            <li class="m-menu__item @if(route('deals.index') == URL::current()) m-menu__item--active @endif" aria-haspopup="true">
                <a href="{{url('admin/deals')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon fa fa-binoculars"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                                Deals
                            </span>
                        </span>
                    </span>
                </a>
            </li>

            <li class="m-menu__item @if(route('email-templates.index') == URL::current()) m-menu__item--active @endif" aria-haspopup="true">
                <a href="{{url('admin/email-templates')}}" class="m-menu__link ">
                    <i class="m-menu__link-icon fa fa-binoculars"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wracap">
                            <span class="m-menu__link-text">
                                Email Templates
                            </span>
                        </span>
                    </span>
                </a>
            </li>
            
        </ul>
    </div>
    <!-- END: Aside Menu -->
</div>