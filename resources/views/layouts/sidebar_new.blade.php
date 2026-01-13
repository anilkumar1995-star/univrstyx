 @php
 $user = auth()->user();
 @endphp

 <div class="sidebar" id="sidebar">
     <div class="modern-profile p-3 pb-0">

         <div class="sidebar-nav mb-3">
             <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded nav-justified bg-transparent" role="tablist">
                 <li class="nav-item"><a class="nav-link active border-0" href="#">Menu</a></li>
                 <li class="nav-item"><a class="nav-link border-0" href="chat.html">Chats</a></li>
                 <li class="nav-item"><a class="nav-link border-0" href="email.html">Inbox</a></li>
             </ul>
         </div>
     </div>
     <div class="sidebar-header p-3 pb-0 pt-2">

         <div class="d-flex align-items-center justify-content-between menu-item mb-3">
             <div class="me-3">
                 <a href="calendar.html" class="btn btn-icon border btn-menubar">
                     <i class="ti ti-layout-grid-remove"></i>
                 </a>
             </div>
             <div class="me-3">
                 <a href="chat.html" class="btn btn-icon border btn-menubar position-relative">
                     <i class="ti ti-brand-hipchat"></i>
                 </a>
             </div>
             <div class="me-3 notification-item">
                 <a href="activities.html" class="btn btn-icon border btn-menubar position-relative me-1">
                     <i class="ti ti-bell"></i>
                     <span class="notification-status-dot"></span>
                 </a>
             </div>
             <div class="me-0">
                 <a href="email.html" class="btn btn-icon border btn-menubar">
                     <i class="ti ti-message"></i>
                 </a>
             </div>
         </div>
     </div>
     <div class="sidebar-inner slimscroll">
         <div id="sidebar-menu" class="sidebar-menu">
             <ul>
                 <li class="clinicdropdown">
                     <a href="{{ route('profile') }}">
                         <img src="{{ asset('theme_1/assets/img/avatars/1.png') }}" class="img-fluid" alt="Profile">
                         <div class="user-names">
                             <h5>Hello {{ explode(' ', ucwords(@Auth::user()->name))[0] }}</h5>
                             <h6>{{ @Auth::user()->role->name }} - <small>{{ @Auth::user()->agentcode }}</small></h6>
                         </div>
                     </a>
                 </li>
             </ul>
             <ul>

                 <li>
                     <h6 class="submenu-hdr">Main Menu</h6>
                     <ul>
                         @if (Myhelper::hasRole('admin'))
                         <li><a href="{{ route('homeNew') }}" class="{{ Request::is('dashboard') ? 'active' : '' }}"><i
                                     class="ti ti-home"></i><span>Dashboard
                                 </span></a></li>
                         @else
                         <li><a href="{{ url('student-dashboard') }}" class="{{ Request::is('student-dashboard') ? 'active' : '' }}"><i
                                     class="ti ti-home"></i><span>Dashboard
                                 </span></a></li>
                         @endif
                     </ul>
                 </li>


                 @if (Myhelper::hasRole('admin'))
                 @if (Myhelper::can(['view_employee', 'view_api']))
                 <li>
                     <h6 class="submenu-hdr">User Management</h6>

                     <ul>
                         <li class="submenu">
                             <a href="javascript:void(0);"
                                 class="{{ Request::is('member/*') ? 'active subdrop' : '' }}">
                                 <i class="ti ti-users"></i><span>Member Settings</span><span
                                     class="menu-arrow"></span>
                             </a>
                             <ul>
                                 <li><a href="{{ route('member', ['type' => 'allmember']) }}"
                                         class="{{ Request::is('member/allmember') ? 'active' : '' }}">All
                                         Member</a>
                                 </li>
                                 <li><a href="{{ route('member', ['type' => 'student']) }}"
                                         class="{{ Request::is('member/student') ? 'active' : '' }}">Student</a>
                                 </li>
                                 <li><a href="{{ route('member', ['type' => 'support']) }}"
                                         class="{{ Request::is('member/support') ? 'active' : '' }}">
                                         Support</a>
                                 </li>
                             </ul>
                         </li>
                     </ul>
                 </li>
                 @endif
                 @endif

                 @if (Myhelper::hasRole(['admin', 'support']))
                 <li>
                     <h6 class="submenu-hdr">User Management</h6>
                     <ul>
                         <li><a href="{{ route('tools', ['type' => 'roles']) }}"
                                 class="{{ Request::is('tools/roles') ? 'active' : '' }}"><i
                                     class="ti ti-users"></i><span>Roles
                                 </span></a></li>
                         <li><a href="{{ route('tools', ['type' => 'permissions']) }}"
                                 class="{{ Request::is('tools/permissions') ? 'active' : '' }}"><i
                                     class="ti ti-navigation-cog"></i><span>
                                     Permissions</span></a></li>
                     </ul>
                 </li>
                 @endif

                 @if (Myhelper::hasRole(['admin']))
                 <li>
                     <h6 class="submenu-hdr">Management</h6>
                     <ul>
                         <li class="submenu">
                             <a href="javascript:void(0);"
                                 class="{{ Request::is('header/list') || Request::is('slider/list') || Request::is('goal/list') || Request::is('employment/list') || 
                             Request::is('award/list') || Request::is('testimonials/list') || Request::is('instructors/list') || Request::is('learnersupport/list') || 
                             Request::is('disclaimer/list') || Request::is('application/list') || Request::is('notification/list') || Request::is('application/grievance') || Request::is('primary/color') || Request::is('homepage/settings') || Request::is('community/list') ? 'active subdrop' : '' }}">
                                 <i class="ti ti-settings-cog"></i><span>Management Data</span><span
                                     class="menu-arrow"></span>
                             </a>
                         <ul>
                         {{-- <li><a class="{{ Request::is('holiday/list') ? 'active' : '' }}"
                                 href="{{ route('holidayView') }}">Holiday
                                 List</a>
                         </li> --}}
                          <li><a class="{{ Request::is('notification/list') ? 'active' : ''}}"
                                 href="{{route('Notification')}}">Announcements
                             </a></li>
                         <li><a class="{{ Request::is('header/list') ? 'active' : ''}}"
                                 href="{{route('header')}}">Header Heading
                             </a></li>
                         <li><a class="{{ Request::is('slider/list') ? 'active' : ''}}"
                                 href="{{route('slider')}}">Slider Content
                             </a></li>
                         <li><a class="{{ Request::is('goal/list') ? 'active' : '' }}"
                                 href="{{ route('goalsView') }}">Goals
                                 List</a></li>
                         <li><a class="{{ Request::is('employment/list') ? 'active' : '' }}"
                                 href="{{ route('employmentView') }}">Employment Partner
                             </a></li>
                         <li><a class="{{ Request::is('award/list') ? 'active' : '' }}"
                                 href="{{ route('awardView') }}">Awards & Accomplishments
                             </a></li>
                         <li><a class="{{ Request::is('testimonials/list') ? 'active' : ''}}"
                                 href="{{route('testimonial')}}">Testimonial
                             </a></li>
                         <li><a class="{{ Request::is('instructors/list') ? 'active' : ''}}"
                                 href="{{route('instructor')}}">Instructors
                             </a></li>
                         <li><a class="{{ Request::is('learnersupport/list') ? 'active' : ''}}"
                                 href="{{route('learnersupport')}}">Learner Support
                             </a></li>
                         <li><a class="{{ Request::is('disclaimer/list') ? 'active' : ''}}"
                                 href="{{route('disclaimer')}}">Disclaimer
                             </a></li>
                         <li><a class="{{ Request::is('application/list') ? 'active' : ''}}"
                                 href="{{route('application.list')}}">Applications List
                             </a></li>
                         <li><a class="{{ Request::is('application/grievance') ? 'active' : ''}}"
                                 href="{{route('grievance.list')}}">Grievance List
                             </a></li>
                         <li><a class="{{ Request::is('primary/color') ? 'active' : ''}}"
                                 href="{{route('primary.list')}}">Primary Color Change
                             </a></li>
                         <li><a class="{{ Request::is('homepage/settings') ? 'active' : ''}}"
                                 href="{{route('homepage.list')}}">Home Page Settings
                             </a></li>
                         <li><a class="{{ Request::is('community/list') ? 'active' : ''}}"
                                 href="{{route('community.list')}}">Community
                             </a></li>
                     </ul>
                 </li>
             </ul>
             </li>
             @endif
             @if (Myhelper::hasRole(['student']))
             <li>
                 <h6 class="submenu-hdr">Support</h6>
                 <ul>

                     <li><a class="{{ Request::is('application/list') ? 'active' : ''}}"
                             href="{{route('application.list')}}"><i class="ti ti-file-invoice"></i><span>Applications List
                             </span></a></li>
                     <li><a class="{{ Request::is('application/grievance') ? 'active' : ''}}"
                             href="{{route('grievance.list')}}"><i class="ti ti-file-invoice"></i><span>Grievance List
                             </span></a></li>

                 </ul>
             </li>
             @endif
             @if (Myhelper::hasRole(['student','admin']))
             <li>
                 <h6 class="submenu-hdr">Education Fee</h6>
                 <ul>
                     <li class="submenu">
                         <a href="javascript:void(0);"
                             class="{{ Request::is('education/*') || Request::is('student/*') ? 'active subdrop' : '' }}">
                             <i class="ti ti-settings-cog"></i><span>Fee Payment</span><span
                                 class="menu-arrow"></span>
                         </a>
                         <ul>
                             <li><a href="{{ route('coursefeeView') }}"
                                     class="{{ Request::is('education/list') ? 'active' : '' }}">Fee Category</a>
                             </li>
                             <li><a class="{{ Request::is('education/fees/list') ? 'active' : ''}}"
                                     href="{{route('fees.list')}}">Fees Payment List
                                 </a></li>
                         </ul>
                     </li>
                 </ul>
             </li>
             @endif
             @if (Myhelper::hasRole(['admin']))
             <li>
                 <h6 class="submenu-hdr">Degrees & Courses</h6>
                 <ul>
                     <li class="submenu">
                         <a href="javascript:void(0);"
                             class="{{ Request::is('programmes/list') || Request::is('degree/*') || Request::is('employee/*') ? 'active subdrop' : '' }}">
                             <i class="ti ti-file-invoice"></i><span>Degree & Courses</span><span
                                 class="menu-arrow"></span>
                         </a>
                         <ul>
                             <li><a href="{{ route('degreeCategoryView') }}"
                                     class="{{ Request::is('degree/categorylist') ? 'active' : '' }}">Degree
                                     Category</a></li>
                             <li><a href="{{ route('degreeView') }}"
                                     class="{{ Request::is('degree/list') ? 'active' : '' }}">University &
                                     Courses</a></li>
                             <li><a href="{{ route('showProgramme') }}"
                                     class="{{ Request::is('programmes/list') ? 'active' : '' }}">Programmes</a>
                             </li>
                         </ul>
                     </li>
                 </ul>
             </li>
             @endif
             @if (Myhelper::hasRole(['admin']))
             <li>
                 <h6 class="submenu-hdr">Free Courses</h6>
                 <ul>
                     <li class="submenu">
                         <a href="javascript:void(0);"
                             class="{{ Request::is('course/*') || Request::is('employee/*') ? 'active subdrop' : '' }}">
                             <i class="ti ti-settings-cog"></i><span>Free Course</span><span
                                 class="menu-arrow"></span>
                         </a>
                         <ul>
                             <li><a href="{{ route('courseCategoryView') }}"
                                     class="{{ Request::is('course/categorylist') ? 'active' : '' }}">Course
                                     Category</a></li>
                             <li><a href="{{ route('courseView') }}"
                                     class="{{ Request::is('course/list') ? 'active' : '' }}">Course List</a>
                             </li>
                         </ul>
                     </li>
                 </ul>
             </li>
             @endif
             @if (Myhelper::hasRole(['admin']))
             <li>
                 <h6 class="submenu-hdr">Footer</h6>
                 <ul>
                     <li class="submenu">
                         <a href="javascript:void(0);"
                             class="{{ Request::is('footer/*') || Request::is('footer/*') ? 'active subdrop' : '' }}">
                             <i class="ti ti-settings-cog"></i><span>Support</span><span
                                 class="menu-arrow"></span>
                         </a>
                         <ul>
                             <li><a href="{{ route('footerCategoryView') }}"
                                     class="{{ Request::is('footer/categorylist') ? 'active' : '' }}">Refund & Privacy Policy
                                 </a></li>
                             <li><a href="{{ route('ourpresencemedia') }}"
                                     class="{{ Request::is('footer/media') ? 'active' : '' }}">Our Presence
                                     Media</a></li>
                             <li><a href="{{ route('aboutus') }}"
                                     class="{{ Request::is('footer/aboutus') ? 'active' : '' }}">About Us</a></li>
                             <li><a href="{{ route('contactus') }}"
                                     class="{{ Request::is('footer/contactus') ? 'active' : '' }}">Contact Us</a></li>


                         </ul>
                     </li>
                 </ul>
             </li>
             @endif
             @if (Myhelper::hasRole('admin'))
             <li>
                 <h6 class="submenu-hdr">Settings</h6>
                 <ul>
                     <li class="submenu">
                         <a href="javascript:void(0);"
                             class="{{ Request::is('profile/*') || Request::is('api/*') ? 'active subdrop' : '' }}">
                             <i class="ti ti-settings-cog"></i><span>General Settings</span><span
                                 class="menu-arrow"></span>
                         </a>
                         <ul>
                             <li><a href="{{ route('profile') }}"
                                     class="{{ Request::is('profile/*') ? 'active' : '' }}">Profile</a></li>
                             <li><a href="{{ route('apilog') }}"
                                     class="{{ Request::is('api/log') ? 'active' : '' }}">API Log</a></li>
                         </ul>
                     </li>
                 </ul>
             </li>
             @endif

             </ul>
         </div>
     </div>
 </div>