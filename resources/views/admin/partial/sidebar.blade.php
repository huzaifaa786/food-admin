 <div class="app-menu navbar-menu">
     <!-- LOGO -->
     <div class="navbar-brand-box">
         <!-- Dark Logo-->
         <a href="" class="logo logo-dark">
             <span class="logo-sm">
                 <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
             </span>
             <span class="logo-lg">
                 <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="17">
             </span>
         </a>
         <!-- Light Logo-->
         <a href="" class="logo logo-light">
             <span class="logo-sm">
                 <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
             </span>
             <span class="logo-lg">
                 <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="17">
             </span>
         </a>
         <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
             id="vertical-hover">
             <i class="ri-record-circle-line"></i>
         </button>
     </div>

     <div class="dropdown sidebar-user m-1 rounded">
         <button type="button" class="btn material-shadow-none" id="page-header-user-dropdown"
             data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             <span class="d-flex align-items-center gap-2">
                 <img class="rounded header-profile-user" src="{{ asset('assets/images/users/avatar-1.jpg') }}"
                     alt="Header Avatar">
                 <span class="text-start">
                     <span class="d-block fw-medium sidebar-user-name-text">Anna Adame</span>
                     <span class="d-block fs-14 sidebar-user-name-sub-text"><i
                             class="ri ri-circle-fill fs-10 text-success align-baseline"></i> <span
                             class="align-middle">Online</span></span>
                 </span>
             </span>
         </button>
         <div class="dropdown-menu dropdown-menu-end">
             <!-- item-->
             <h6 class="dropdown-header">Welcome Anna!</h6>
             <a class="dropdown-item" href="pages-profile.html"><i
                     class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                     class="align-middle">Profile</span></a>
             <a class="dropdown-item" href="apps-chat.html"><i
                     class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i> <span
                     class="align-middle">Messages</span></a>
             <a class="dropdown-item" href="apps-tasks-kanban.html"><i
                     class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i> <span
                     class="align-middle">Taskboard</span></a>
             <a class="dropdown-item" href="pages-faqs.html"><i
                     class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> <span
                     class="align-middle">Help</span></a>
             <div class="dropdown-divider"></div>
             <a class="dropdown-item" href="pages-profile.html"><i
                     class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Balance :
                     <b>$5971.67</b></span></a>
             <a class="dropdown-item" href="pages-profile-settings.html"><span
                     class="badge bg-success-subtle text-success mt-1 float-end">New</span><i
                     class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span
                     class="align-middle">Settings</span></a>
             <a class="dropdown-item" href="auth-lockscreen-basic.html"><i
                     class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Lock
                     screen</span></a>
             <a class="dropdown-item" href="auth-logout-basic.html"><i
                     class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle"
                     data-key="t-logout">Logout</span></a>
         </div>
     </div>
     <div id="scrollbar">
         <div class="container-fluid">


             <div id="two-column-menu">
             </div>
             <ul class="navbar-nav" id="navbar-nav">
                 <li class="nav-item">
                     {{-- <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button"
                         aria-expanded="false" aria-controls="sidebarDashboards">
                         <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboards</span>
                     </a> --}}
                     {{-- <div class="collapse " id="sidebarDashboards"> --}}
                     <ul class="nav nav-sm flex-column">
                         <li class="nav-item">
                             <a href="{{ route('dashboard') }}" class="nav-link ">
                                 Dashboard </a>
                         </li>
                     </ul>
                     {{-- </div> --}}
                 </li> <!-- end Dashboard Menu -->

                 {{-- Category --}}
                 <li class="nav-item">
                    <a class="nav-link menu-link" href="#category" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="category">
                        <i class=" bx bx-category"></i> <span data-key="t-dashboards">Categories</span>
                    </a>
                    <div class="collapse menu-dropdown" id="category">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('category') }}" class="nav-link" data-key="t-category">
                                    Create Category </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('category.index') }}" class="nav-link" data-key="t-category">
                                    All Categories </a>
                            </li>
                        </ul>
                    </div>
                </li>

                 {{-- <li class="nav-item">
                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse"
                                role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboards</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarDashboards">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="{{route('dashboard')}}" class="nav-link" data-key="t-analytics">
                                            analytic </a>
                                    </li>
                                </ul>
                            </div>
                        </li> <!-- end Dashboard Menu -->


                        {{-- Sales  --}}
                 <li class="nav-item">
                     <a class="nav-link menu-link" href="#sales" data-bs-toggle="collapse" role="button"
                         aria-expanded="false" aria-controls="sales">
                         <i class="las la-file-invoice"></i> <span data-key="t-dashboards">Sales</span>
                     </a>
                     <div class="collapse menu-dropdown" id="sales">
                         <ul class="nav nav-sm flex-column">
                             <li class="nav-item">
                                 <a href="{{ route('saletable') }}" class="nav-link" data-key="t-sales">
                                     Sales Table </a>
                             </li>
                             <li class="nav-item">
                                 <a href="{{ route('sale/graph') }}" class="nav-link" data-key="t-sales">
                                     Sales Graph </a>
                             </li>
                         </ul>
                     </div>
                 </li>

                 {{-- <li class="nav-item">
             <div id="two-column-menu">
             </div>
             <ul class="navbar-nav" id="navbar-nav">
                 <li class="nav-item">
                     <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button"
                         aria-expanded="false" aria-controls="sidebarDashboards">
                         <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboards</span>
                     </a>
                     <div class="collapse menu-dropdown" id="sidebarDashboards">
                         <ul class="nav nav-sm flex-column">
                             <li class="nav-item">
                                 <a href="{{ route('dashboard') }}" class="nav-link" data-key="t-analytics">
                                     Analytic </a>
                             </li>
                         </ul>
                     </div>
                 </li> <!-- end Dashboard Menu -->
                 {{-- User Side --}}
                 <li class="nav-item">
                     <a class="nav-link menu-link" href="#user" data-bs-toggle="collapse" role="button"
                         aria-expanded="false" aria-controls="user">
                         <i class="ri-user-line"></i> <span data-key="t-dashboards">Users</span>
                     </a>
                     <div class="collapse menu-dropdown" id="user">
                         <ul class="nav nav-sm flex-column">
                             <li class="nav-item">
                                 <a href="{{ route('user.index') }}" class="nav-link" data-key="t-user">
                                     All User </a>
                             </li>
                         </ul>
                     </div>
                 </li>
                 {{-- Restaurant Side  --}}
                 <li class="nav-item">
                     <a class="nav-link menu-link" href="#resturant" data-bs-toggle="collapse" role="button"
                         aria-expanded="false" aria-controls="resturant">
                         <i class="ri-restaurant-fill"></i> <span data-key="t-dashboards">Restaurant</span>
                     </a>
                     <div class="collapse menu-dropdown" id="resturant">
                         <ul class="nav nav-sm flex-column">
                             <li class="nav-item">
                                 <a href="{{ route('resturant.index') }}" class="nav-link" data-key="t-resturant">
                                     All Restaurant </a>
                             </li>
                         </ul>
                     </div>
                 </li>
                 {{-- Drivers --}}
                 <li class="nav-item">
                     <a class="nav-link menu-link" href="#rider" data-bs-toggle="collapse" role="button"
                         aria-expanded="false" aria-controls="rider">
                         <i class="ri-e-bike-2-fill"></i> <span data-key="t-dashboards">Riders</span>
                     </a>
                     <div class="collapse menu-dropdown" id="rider">
                         <ul class="nav nav-sm flex-column">
                             <li class="nav-item">
                                 <a href="{{ route('rider') }}" class="nav-link" data-key="t-rider">
                                     All Riders </a>
                             </li>
                         </ul>
                     </div>
                 </li>

                 <li class="nav-item">
                     <a class="nav-link menu-link" href="#menu" data-bs-toggle="collapse" role="button"
                         aria-expanded="false" aria-controls="rider">
                         <i class=" ri-menu-3-fill"></i> <span data-key="t-dashboards">Menus</span>
                     </a>
                     <div class="collapse menu-dropdown" id="menu">
                         <ul class="nav nav-sm flex-column">
                             <li class="nav-item">
                                 <a href="{{route('menu.index')}}" class="nav-link" data-key="t-menu">
                                     Restraunt Menu </a>
                             </li>
                         </ul>
                     </div>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link menu-link" href="#menu" data-bs-toggle="collapse" role="button"
                         aria-expanded="false" aria-controls="rider">
                         <i class="ri-money-dollar-box-line"></i> <span data-key="t-dashboards">Fees</span>
                     </a>
                     <div class="collapse menu-dropdown" id="menu">
                         <ul class="nav nav-sm flex-column">
                             <li class="nav-item">
                                 <a href="{{route('fee.create')}}" class="nav-link" data-key="t-menu">
                                     Restraunt Registration Fee </a>
                             </li>
                         </ul>
                     </div>
                 </li>

                 {{-- <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse"
                                role="button" aria-expanded="false" aria-controls="sidebarApps">
                                <i class="ri-restaurant-fill"></i> <span data-key="t-apps">Restraunts</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarApps">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="#sidebarCalendar" class="nav-link" data-bs-toggle="collapse"
                                            role="button" aria-expanded="false" aria-controls="sidebarCalendar"
                                            data-key="t-calender">
                                            Calendar
                                        </a>
                                        <div class="collapse menu-dropdown" id="sidebarCalendar">
                                            <ul class="nav nav-sm flex-column">
                                                <li class="nav-item">
                                                    <a href="{{route('restraunts')}}" class="nav-link"
                                                        data-key="t-main-calender"> Main Calender </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="apps-calendar-month-grid.html" class="nav-link"
                                                        data-key="t-month-grid"> Month Grid </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li> --}}
             </ul>
         </div>
         <!-- Sidebar -->
     </div>

     <div class="sidebar-background"></div>
 </div>
