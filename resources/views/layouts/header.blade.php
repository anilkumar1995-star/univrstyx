 <div class="header">

     <!-- Logo -->
     <div class="header-left active">
         @if (@Auth::user()->company->logo)
             <a href="{{ route('homeNew') }}" class="logo logo-normal">
                
                 <img src="{{ asset('assets1/img/ipayment-logo.png') }}" alt="Logo" style="width:1-0%">
             </a>
         @else
             <a href="{{ route('homeNew') }}" class="header-logo">
                 <span>{{ @Auth::user()->company->companyname }}</span>
             </a>
         @endif
         <a id="toggle_btn" href="javascript:void(0);">
             <i class="ti ti-arrow-bar-to-left"></i>
         </a>
     </div>
     <!-- /Logo -->

     <a id="mobile_btn" class="mobile_btn" href="#sidebar">
         <span class="bar-icon">
             <span></span>
             <span></span>
             <span></span>
         </span>
     </a>

     <div class="header-user">
         <ul class="nav user-menu">

             <!-- Search -->
             <li class="nav-item nav-search-inputs me-auto">
                 <div class="top-nav-search">
                     <a href="javascript:void(0);" class="responsive-search">
                         <i class="fa fa-search"></i>
                     </a>
                     <form action="#" class="dropdown">
                         <div class="searchinputs" id="dropdownMenuClickable">
                             <input type="text" placeholder="Search">
                             <div class="search-addon">
                                 <button type="submit"><i class="ti ti-command"></i></button>
                             </div>
                         </div>
                     </form>
                 </div>
             </li>
             <!-- /Search -->



             <!-- Nav List -->
             <li class="nav-item nav-list">
                 <ul class="nav">
                     <li>
                         <div>
                             <a href="#" class="btn btn-icon border btn-menubar btnFullscreen">
                                 <i class="ti ti-maximize"></i>
                             </a>
                         </div>
                     </li>
                     <li class="dark-mode-list">
                         <a href="javascript:void(0);" id="dark-mode-toggle" class="dark-mode-toggle">
                             <i class="ti ti-sun light-mode active"></i>
                             <i class="ti ti-moon dark-mode"></i>
                         </a>
                     </li>
                     </ul>
             </li>
             <!-- /Nav List -->

             <!-- Profile Dropdown -->
             <li class="nav-item dropdown has-arrow main-drop">
                 <a href="javascript:void(0);" class="nav-link userset" data-bs-toggle="dropdown">
                     <span class="user-info">
                         <span class="user-letter">
                             <img src="{{ asset('theme_1/assets/img/avatars/1.png') }}" alt="Profile">
                         </span>
                         <span class="badge badge-success rounded-pill"></span>
                     </span>
                 </a>
                 <div class="dropdown-menu menu-drop-user">
                     <div class="profilename">
                         {{-- <a class="dropdown-item" href="index.html">
                                    <i class="ti ti-layout-2"></i> Dashboard
                                </a> --}}
                         <a class="dropdown-item" href="{{ route('profile') }}">
                             <i class="ti ti-user"></i> My Profile
                         </a>
                         
                       {{--  @if (Myhelper::hasNotRole('admin') && Myhelper::can('view_commission'))
                             <a class="dropdown-item" href="{{ route('resource', ['type' => 'commission']) }}">
                                 <i class="ti ti-eye"></i> View Commission
                             </a>
                         @endif --}}
                            @if (Auth::check() && Myhelper::hasRole('student'))
                          <a class="dropdown-item" href="#">
                            <i class="ti ti-wallet"></i> Wallet 
                            <span class="text-success ms-1"> &emsp;₹ {{(number_format($walletBalance, 0))}}</span>
                        </a>
                        @endif
                         <a class="dropdown-item" href="{{ route('logout') }}">
                             <i class="ti ti-lock"></i> Logout
                         </a>
                     </div>
                 </div>
             </li>
             <!-- /Profile Dropdown -->

         </ul>
     </div>

     <!-- Mobile Menu -->
     <div class="dropdown mobile-user-menu">
         <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
             aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
         <div class="dropdown-menu">
             {{-- <a class="dropdown-item" href="index.html">
                        <i class="ti ti-layout-2"></i> Dashboard
                    </a> --}}
             <a class="dropdown-item" href="{{ route('profile') }}">
                 <i class="ti ti-user"></i> My Profile
             </a>
          {{--   @if (Myhelper::hasNotRole('admin') && Myhelper::can('view_commission'))
                 <a class="dropdown-item" href="{{ route('resource', ['type' => 'commission']) }}">
                     <i class="ti ti-eye"></i> View Commission
                 </a>
             @endif --}}
               @if (Auth::check() && Myhelper::hasRole('student'))
                          <a class="dropdown-item" href="#">
                            <i class="ti ti-wallet"></i> Wallet 
                            <span class="text-success ms-1"> &emsp;₹ {{(number_format($walletBalance, 0))}}</span>
                        </a>
                        @endif
             <a class="dropdown-item" href="{{ route('logout') }}">
                 <i class="ti ti-lock"></i> Logout
             </a>
         </div>
     </div>
     <!-- /Mobile Menu -->

 </div>
