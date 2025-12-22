<!-- Navbar -->
<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="ti ti-menu-2 ti-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        

        <div class="left-header col-xxl-5 col-xl-6 col-lg-5 col-md-4 col-4 col-sm-3 p-0">
            <marquee>
                <div class="notification-slider">
                    <div class="d-flex h-100"> 
                        <h6 class="mb-0 f-w-500"><span class="font-primary text-danger">&nbsp;&nbsp;Welcome to {{ @json_decode(app\Models\Company::where('website', $_SERVER['HTTP_HOST'])->first(['companyname']))->companyname }} Dashboard </span></h6><i class="icon-arrow-top-right f-light"></i>
                    </div>
                </div>
            </marquee>
        </div>
        <ul class="navbar-nav flex-row align-items-center ms-auto">
           <li class="nav-item me-2 me-xl-0">
                <a class="nav-link style-switcher-toggle hide-arrow" href="javascript:void(0);">
                    <i class="ti ti-md"></i>
                </a>
            </li>
           

            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="{{asset('theme_1/assets/img/avatars/1.png')}}" alt class="h-auto rounded-circle" />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="javascript:void(0)">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src="{{asset('theme_1/assets/img/avatars/1.png')}}" alt class="h-auto rounded-circle" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block">Hello {{ explode(' ',ucwords(@Auth::user()->name))[0] }}</span>
                                    <small class="text-muted d-block">{{@Auth::user()->role->name}}</small>
                                    <small class="text-muted">Id - {{@Auth::user()->agentcode}}</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a href="{{route('profile')}}" class="dropdown-item">
                            <i class="ti ti-user-check me-2 ti-sm"></i>
                            <span class="align-middle">
                                My Profile
                            </span>
                        </a>
                    </li>


                    <li>
                        @if (Myhelper::hasNotRole('admin') && Myhelper::can('view_commission'))
                        <a class="dropdown-item" href="{{route('resource', ['type' => 'commission'])}}">
                            <i class="ti ti-eye me-2 ti-sm"></i>
                            <span class="align-middle">View Commission</span>
                        </a>
                        @endif
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{route('logout')}}">
                            <i class="ti ti-logout me-2 ti-sm"></i>
                            <span class="align-middle">Log Out</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
        </div>

  



    <!-- Search Small Screens -->
    <div class="navbar-search-wrapper search-input-wrapper d-none">
        <input type="text" class="form-control search-input container-xxl border-0" placeholder="Search..." aria-label="Search..." />
        <i class="ti ti-x ti-sm search-toggler cursor-pointer"></i>
    </div>
</nav>
<!-- / Navbar -->