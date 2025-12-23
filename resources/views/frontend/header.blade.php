<header id="header" class="site-header text-black">
  <div class="header-top py-2 fixed-top">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-4">
          <div class="d-flex items-center">
         
            <a class="position-relative logo me-4 mt-1" href="{{ url('/') }}">
              @if(!empty($headerdata->header_image))
                  <img 
                      alt="iUniversity-logo"
                      src="https://images.incomeowl.in/incomeowl/crm/images/{{ $headerdata->header_image }}" height="34px" width="122px">
              @else
                  <img 
                      alt="iUniversity-logo"
                      src="{{ asset('frontend/images/I-University_logo_11.png') }}">
              @endif
            </a>
            <div class="search-box position-relative d-flex w-100 items-center">
              <input type="search" value="{{ request('query') }}" class="search-input border border-rounded-10 ps-3 pe-4 py-2 d-flex w-100 bg-white" placeholder="Explore Courses">
              <button type="button" class="search-btn border search-wrap position-absolute" style="right:10px;">
                <i class="fa-solid fa-magnifying-glass"></i>
              </button>
            </div>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="d-flex justify-content-end">
            <div class="navbar-block" id="menu">
              <ul class="menu">
                <li class="menu-item dropdown">
                  <span class="dropdown-toggle menu-link">
                    {{ $headerdata->header_1 ?? 'For working Professionals' }} <i class="bx bx-chevron-down"></i>
                  </span>
                  <div class="dropdown-content">
                    <div class="container">
                      <div class="row m-3">
                        <!-- Left Side (Categories Menu) -->
                        <div class="col-md-4 ">
                          <ul class="nav flex-column nav-pills me-3 menu-tab" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            @foreach($categories as $index => $category)
                            <button class="nav-link {{ $index == 0 ? 'active' : '' }}"
                              id="v-{{ $category->degree_category_slug }}-tab"
                              data-bs-toggle="pill"
                              data-bs-target="#v-{{ $category->id }}"
                              type="button"
                              role="tab"
                              aria-controls="v-{{ $category->id }}"
                              aria-selected="{{ $index == 0 ? 'true' : 'false' }}">
                              {{ $category->degree_category }}
                              <i class="fa-solid fa-chevron-right"></i>
                            </button>
                            @endforeach
                          </ul>
                        </div>

                        <!-- Right Side (Tab Content) -->
                        <div class="col-md-8">
                          <div class="tab-content" id="v-pills-tabContent">
                            @foreach($categories as $index => $category)
                            <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}"
                              id="v-{{ $category->id }}"
                              role="tabpanel"
                              aria-labelledby="v-{{ $category->degree_category_slug }}-tab">

                              <h4 class="m-3">{{ $category->degree_category }}</h4>

                              {{-- Universities Show --}}
                              @if($category->universities && $category->universities->isNotEmpty())
                              @foreach($category->universities as $type => $universities)
                              <div class="row">
                                @foreach($universities as $uni)
                                <div class="col-lg-3 mb-3">
                                  <a href="{{ url('programme/'.$uni->id) }}">
                                    <div class="d-flex w-100 align-items-start gap-2">
                                      <img src="https://images.incomeowl.in/incomeowl/crm/images/{{ $uni->degree_category_icon }}"
                                        width="50" height="50" class="rounded-1" />
                                      <span class="d-flex flex-column g-2">
                                        <p class="text-gray small mb-0" style="font-size: 11px;">{{ $uni->university_name }}</p>
                                        <p class="text-dark fw-semibold mb-0" style="font-size:9px;">{{ $uni->degree_name }}</p>
                                      </span>
                                    </div>
                                  </a>
                                </div>
                                @endforeach
                              </div>
                              @endforeach
                              @else
                              <p class="text-muted">No record found.</p>
                              @endif

                            </div>
                            @endforeach
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <li class="menu-item dropdown">
                  <span class="dropdown-toggle menu-link">
                    {{ $headerdata->header_2 ?? 'For College Students' }} <i class="bx bx-chevron-down"></i>
                  </span>
                  <div class="dropdown-content">
                    <div class="dropdown-column">
                      <div class="dropdown-group">
                        <div class="dropdown-block">
                          <span class="dropdown-icon"><i class="bx bx-podcast"></i></span>
                          <div class="dropdown-inner">
                            <a href="#" class="text-base font-medium">Podcasts</a>
                            <p class="text-base font-normal">
                              Hear and enjoy our inspiration podcast together with us.
                            </p>
                          </div>
                        </div>
                        <div class="dropdown-block">
                          <span class="dropdown-icon"><i class="bx bx-video"></i></span>
                          <div class="dropdown-inner">
                            <a href="#" class="text-base font-medium">Tutorials</a>
                            <p class="text-base font-normal">
                              Learn video tutorial with our professional instructors.
                            </p>
                          </div>
                        </div>
                      </div>
                      <div class="dropdown-group">
                        <div class="dropdown-block">
                          <span class="dropdown-icon"><i class="bx bx-book-open"></i></span>
                          <div class="dropdown-inner">
                            <a href="{{ url('footer/contact-us/1') }}" class="text-base font-medium">Help Center</a>
                            <p class="text-base font-normal">
                              Discover how to register, install and use our products.
                            </p>
                          </div>
                        </div>
                        <div class="dropdown-block">
                          <span class="dropdown-icon"><i class="bx bx-bookmark"></i></span>
                          <div class="dropdown-inner">
                            <a href="{{ url('community/view') }}" class="text-base font-medium">Community</a>
                            <p class="text-base font-normal">
                              Share and connect with other user in our communities.
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <!-- <li class="menu-item dropdown">
                  <span class="dropdown-toggle menu-link">
                    Study Abroad <i class="bx bx-chevron-down"></i>
                  </span>
                  <div class="dropdown-content">
                    <div class="dropdown-column">
                      <div class="dropdown-group">
                        <div class="dropdown-block">
                          <span class="dropdown-icon"><i class="bx bx-podcast"></i></span>
                          <div class="dropdown-inner">
                            <a href="#" class="text-base font-medium">Podcasts</a>
                            <p class="text-base font-normal">
                              Hear and enjoy our inspiration podcast together with us.
                            </p>
                          </div>
                        </div>
                        <div class="dropdown-block">
                          <span class="dropdown-icon"><i class="bx bx-video"></i></span>
                          <div class="dropdown-inner">
                            <a href="#" class="text-base font-medium">Tutorials</a>
                            <p class="text-base font-normal">
                              Learn video tutorial with our professional instructors.
                            </p>
                          </div>
                        </div>
                      </div>
                      <div class="dropdown-group">
                        <div class="dropdown-block">
                          <span class="dropdown-icon"><i class="bx bx-book-open"></i></span>
                          <div class="dropdown-inner">
                            <a href="#" class="text-base font-medium">Help Center</a>
                            <p class="text-base font-normal">
                              Discover how to register, install and use our products.
                            </p>
                          </div>
                        </div>
                        <div class="dropdown-block">
                          <span class="dropdown-icon"><i class="bx bx-bookmark"></i></span>
                          <div class="dropdown-inner">
                            <a href="#" class="text-base font-medium">Community</a>
                            <p class="text-base font-normal">
                              Share and connect with other user in our communities.
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </li> -->
                <li class="menu-item dropdown">
                  <span class="dropdown-toggle menu-link">
                    {{ $headerdata->header_3 ?? 'More' }} <i class="bx bx-chevron-down"></i>
                  </span>
                  <div class="dropdown-content">
                    <div class="container">
                      <div class="right-tab">
                        <div class="row g-2">
                          @php $shown = 0; @endphp

                          @foreach($categories as $category)
                          @php
                          // flatten all universities (ignore type grouping)
                          $allUniversities = collect($category->universities)->flatten();
                          @endphp

                          @if($allUniversities->isNotEmpty())
                          @foreach($allUniversities as $uni)
                          @if($shown >= 18)
                          @break(2) {{-- stop both foreach loops after 18 --}}
                          @endif
                          <div class="col-lg-2 col-md-4 col-sm-6">
                            <a href="{{ url('programme/'.$uni->id) }}">
                              <div class="d-flex w-100 align-items-start gap-2">
                                <img src="https://images.incomeowl.in/incomeowl/crm/images/{{ $uni->degree_category_icon }}"
                                  width="40" height="40" class="rounded-1" />
                                <span class="d-flex flex-column g-1">
                                  <p class="text-gray small mb-0" style="font-size: 10px;">
                                    {{ $uni->university_name }}
                                  </p>
                                  <p class="text-dark fw-semibold mb-0" style="font-size: 8px;">
                                    {{ $uni->degree_name }}
                                  </p>
                                </span>
                              </div>
                            </a>
                          </div>
                          @php $shown++; @endphp
                          @endforeach
                          @endif
                          @endforeach
                        </div>
                      </div>
                    </div>
                  </div>
                </li>

              </ul>
            </div>
            <div class="d-flex align-items-center">
              @if(Auth::check())
              <!-- <a class="btn-free me-3 btn-outline-primary" href="#" data-bs-toggle="modal" data-bs-target="#feeModal">
                Pay Fee
              </a> -->
              <a class="btn-free me-3 btn-outline-primary" href="{{route('coursefeeView')}}">Pay Fee</a>
              @else
              <a class="btn-free me-3 btn-outline-primary" href="#" data-bs-toggle="modal" data-bs-target="#stepmodal">Pay Fee</a>
              @endif
              @guest
              <a class="btn-free me-3 border bg-primary text-white" href="#" data-bs-toggle="modal" data-bs-target="#stepmodal">Sign Up</a>
              @endguest

              @auth
              {{-- User logged in --}}
              <div class="dropdown">
                <button class="btn btn-dark d-flex align-items-center px-2 py-1 rounded-3"
                  id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-user-circle me-2 fs-5"></i>
                  @php
                  $name = Auth::user()->name;
                  $words = explode(' ', $name);
                  $initials = strtoupper(substr($words[0], 0, 1) . substr(end($words), 0, 1));
                  @endphp

                  <span class="fw-semibold small">{{ $initials }}</span>

                  <i class="fa fa-caret-down ms-2"></i>
                </button>

                <ul class="dropdown-menu dropdown-menu-end shadow-sm small" aria-labelledby="userMenu" style="min-width:130px !important; font-size:13px; padding:5px 0;">
                  <li>
                    <a class="dropdown-item d-flex align-items-center" href="{{route('coursefeeView')}}">
                      <i class="fa fa-plus-circle me-2 text-primary"></i> Fee Payment
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                      <i class="fa fa-wallet me-2 text-success"></i> Wallet &emsp;₹ {{(number_format($walletBalance, 0))}}
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item d-flex align-items-center" href="{{ route('profile') }}">
                      <i class="fa fa-user me-2 text-info"></i> Profile
                    </a>
                  </li>
                  <li>
                    <hr class="dropdown-divider">
                  </li>
                  <li>
                    <a class="dropdown-item" href="{{ route('logout') }}">
                      <i class="fa-solid fa-right-from-bracket text-danger"></i> Logout
                    </a>
                  </li>
                </ul>

              </div>
              @endauth
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- register modal -->

  <div class="modal fade bd-example-modal-lg" id="registerModal" tabindex="-1" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">New Member Registration</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"></span>
          </button>
        </div>
        <div class="modal-body">
          <form id="registerForm" action="{{ route('register') }}" method="post">
            {{ csrf_field() }}
            <div class="row">
              <div class="form-group">

                <select name="slug" class="form-control my-1 select" required>
                  <option value="">Select Member Type</option>
                  <option value="student">Student</option>
                  <option value="teacher">Teacher</option>
                </select>
              </div>
            </div>

            <h5 class="mb-2">Personal Details</h5>
            <div class="row">
              <div class="form-group my-1 col-md-6">

                <input type="text" name="name" class="form-control my-1"
                  required>
                <label for="name">Name</label>

              </div>

              <div class="form-group" id="email">
                <input type="email" name="email" class="form-control"
                  required>
                <label for="email">Email Address</label>
              </div>
              <div class="form-group my-1 col-md-6">

                <input type="tel" maxlength="10" name="mobile" class="form-control my-1"
                  required>
                <label for="mobile">Mobile Number</label>

                <div class="alert-message" id="mobileError"></div>
              </div>
            </div>
            <div class="form-group my-1 col-md-12">
              <textarea name="address" class="form-control my-1" placeholder="Address" rows="3" required=""></textarea>

            </div>

            {{-- <h5 class="my-2">Upload Your Documents</h5>
                        <div class="row">
                            <div class="form-group col-md-6 my-1">
                                <label>Passport size photo <span class="text-danger fw-bold">*</span></label>

                                <input type="file" class="form-control my-1" autocomplete="off" name="profiles" placeholder="Enter Demat account" required">
                            </div>
                            <div class="form-group col-md-6 my-1">
                                <label>Pancard Photo <span class="text-danger fw-bold">*</span></label>
                                <input type="file" class="form-control my-1" autocomplete="off"
                                    name="pancardpics" placeholder="Enter Business saving account" required>
                            </div>
                            <div class="form-group col-md-6 my-1">
                                <label>Aadharcard Front Photo <span class="text-danger fw-bold">*</span></label>
                                <input type="file" class="form-control my-1" autocomplete="off"
                                    name="aadharcardpics" placeholder="Enter Digital saving account" value=""
                                    required>
                            </div>
                            <div class="form-group col-md-6 my-1">
                                <label>Aadharcard Back Photo <span class="text-danger fw-bold">*</span></label>
                                <input type="file" class="form-control my-1" autocomplete="off"
                                    name="aadharcardpicsback" placeholder="Enter Digital saving account"
                                    value="" required>
                            </div>
                        </div> --}}
            <div class="form-group">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!--s register modal end -->


  <div class="modal fade signupSheet" id="stepmodal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
    tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <div id="multi-step-form">
            <div class="step step-1">
              <div class="row">
                <div class="col-lg-6 leftsheet">
                  <img src="{{ asset('') }}frontend/images/login/signup.svg" style="width: 100%; height: 100%; object-fit: contain;" class="img-fluid">
                  <a href="javascript:void(0)" class="btnLogin promotionBtn"> <svg width="20" height="20" viewBox="0 0 23 23"
                      fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="title">
                      <title>Promotion</title>
                      <path
                        d="M15.5189 15.0943V18.4025H17.173V15.0943H18.8271L16.346 12.6132L13.8648 15.0943H15.5189ZM10.5567 4.34277C8.73718 4.34277 7.24851 5.83145 7.24851 7.65093C7.24851 9.47042 8.73718 10.9591 10.5567 10.9591C12.3762 10.9591 13.8648 9.47042 13.8648 7.65093C13.8648 5.83145 12.3762 4.34277 10.5567 4.34277ZM10.5567 12.6132C6.9177 12.6132 3.94035 14.1018 3.94035 15.9213V17.5754H11.7972C11.5491 16.9138 11.3837 16.2522 11.3837 15.5078C11.3837 14.5154 11.6318 13.6056 12.1281 12.6959C11.6318 12.6959 11.1356 12.6132 10.5567 12.6132Z"
                        fill="currentColor"></path>
                    </svg> Promotion</a>
                  <a href="javascript:void(0)" class="btnLogin switchBtn"> <svg width="20" height="20" viewBox="0 0 23 23" fill="none"
                      xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="title">
                      <title>Career Switch</title>
                      <path
                        d="M19.8146 9.03172L16.1901 5.40723V8.1256H9.84726V9.93785H16.1901V12.6562M7.12889 10.844L3.50439 14.4685L7.12889 18.093V15.3746H13.4718V13.5623H7.12889V10.844Z"
                        fill="currentColor"></path>
                    </svg> Career Switch</a>
                  <a href="javascript:void(0)" class="btnLogin hikeBtn"> <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                      xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="title">
                      <title>Salary Hike</title>
                      <mask id="mask0_271_6453" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24"
                        style="mask-type: alpha;">
                        <rect width="24" height="24" fill="#D9D9D9"></rect>
                      </mask>
                      <g mask="url(#mask0_271_6453)">
                        <path d="M3.4 18L2 16.6L9.4 9.15L13.4 13.15L18.6 8H16V6H22V12H20V9.4L13.4 16L9.4 12L3.4 18Z"
                          fill="currentColor"></path>
                      </g>
                    </svg> Salary Hike</a>
                </div>
                <div class="col-lg-6 rightSheet">
                  <form action="{{ route('send.otp') }}" class="login-event">
                    <input type="hidden" id="redirect_url" value="{{ url()->current() }}">
                    <h5 class="modal-title" id="exampleModalToggleLabel">Welcome! Sign up or Login</h5>
                    <div class="form-group" id="phoneLogin">
                      <input type="tel" id="mobile_code" class="form-control" placeholder="Phone Number" name="mobile"
                        pattern="(\d{10})|(^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$)" maxlength="10">
                    </div>
                    <div class="form-group d-none" id="emailLogin">
                      <input type="email" id="email" name="email" class="form-control" autocomplete="off" required>
                      <label for="email">Email Address</label>
                    </div>
                    <span class="or-type">or</span>
                    <button type="button" class="emailToggle">Continue with Email</button>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary next-step" id="btnSubmit" disabled>Continue</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="step step-2">
              <div class="row">
                <div class="col-lg-6 leftsheet">
                  <img src="{{ asset('') }}frontend/images/login/signup.svg" style="width: 100%; height: 100%; object-fit: contain;" class="img-fluid">
                  <a href="#" class="btnLogin promotionBtn"> <svg width="20" height="20" viewBox="0 0 23 23"
                      fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="title">
                      <title>Promotion</title>
                      <path
                        d="M15.5189 15.0943V18.4025H17.173V15.0943H18.8271L16.346 12.6132L13.8648 15.0943H15.5189ZM10.5567 4.34277C8.73718 4.34277 7.24851 5.83145 7.24851 7.65093C7.24851 9.47042 8.73718 10.9591 10.5567 10.9591C12.3762 10.9591 13.8648 9.47042 13.8648 7.65093C13.8648 5.83145 12.3762 4.34277 10.5567 4.34277ZM10.5567 12.6132C6.9177 12.6132 3.94035 14.1018 3.94035 15.9213V17.5754H11.7972C11.5491 16.9138 11.3837 16.2522 11.3837 15.5078C11.3837 14.5154 11.6318 13.6056 12.1281 12.6959C11.6318 12.6959 11.1356 12.6132 10.5567 12.6132Z"
                        fill="currentColor"></path>
                    </svg> Promotion</a>
                  <a href="#" class="btnLogin switchBtn"> <svg width="20" height="20" viewBox="0 0 23 23" fill="none"
                      xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="title">
                      <title>Career Switch</title>
                      <path
                        d="M19.8146 9.03172L16.1901 5.40723V8.1256H9.84726V9.93785H16.1901V12.6562M7.12889 10.844L3.50439 14.4685L7.12889 18.093V15.3746H13.4718V13.5623H7.12889V10.844Z"
                        fill="currentColor"></path>
                    </svg> Career Switch</a>
                  <a href="#" class="btnLogin hikeBtn"> <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                      xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="title">
                      <title>Salary Hike</title>
                      <mask id="mask0_271_6453" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24"
                        style="mask-type: alpha;">
                        <rect width="24" height="24" fill="#D9D9D9"></rect>
                      </mask>
                      <g mask="url(#mask0_271_6453)">
                        <path d="M3.4 18L2 16.6L9.4 9.15L13.4 13.15L18.6 8H16V6H22V12H20V9.4L13.4 16L9.4 12L3.4 18Z"
                          fill="currentColor"></path>
                      </g>
                    </svg> Salary Hike</a>
                </div>
                <div class="col-lg-6 rightSheet text-start">

                  <form action="{{ route('send.otp') }}" class="otp-form">
                    <a href="#" class="prev-step"><i class="fa-solid fa-arrow-left-long"></i> </a>
                    <h5 class="modal-title mb-0" id="exampleModalToggleLabel">We've sent an OTP on</h5>
                    <p> +91 <span id="displayMobile">1234567890</span> <a href="#" style="color: blue;" id="editMobile">Edit</a></p>
                    <div class="otpCover">
                      <input type="tel" id="otp-number-input-1" placeholder="-" class="otp-number-input" maxlength="1"
                        autocomplete="off">
                      <input type="tel" id="otp-number-input-2" placeholder="-" class="otp-number-input" maxlength="1"
                        autocomplete="off">
                      <input type="tel" id="otp-number-input-3" placeholder="-" class="otp-number-input" maxlength="1"
                        autocomplete="off">
                      <input type="tel" id="otp-number-input-4" placeholder="-" class="otp-number-input" maxlength="1"
                        autocomplete="off">
                    </div>
                    <div class="d-flex">
                      <p class="me-2">Didn't receive OTP?</p>
                      <p id="verifiBtn" class="or-type"> Resend in <span id="counter"></span> </p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary otp-verify-btn next-step" disabled>Verify OTP</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="step step-3">
              <div class="row">
                <div class="col-lg-6 leftsheet">
                  <img src="{{ asset('') }}frontend/images/login/signup.svg" style="width: 100%; height: 100%; object-fit: contain;" class="img-fluid">
                  <a href="#" class="btnLogin promotionBtn"> <svg width="20" height="20" viewBox="0 0 23 23"
                      fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="title">
                      <title>Promotion</title>
                      <path
                        d="M15.5189 15.0943V18.4025H17.173V15.0943H18.8271L16.346 12.6132L13.8648 15.0943H15.5189ZM10.5567 4.34277C8.73718 4.34277 7.24851 5.83145 7.24851 7.65093C7.24851 9.47042 8.73718 10.9591 10.5567 10.9591C12.3762 10.9591 13.8648 9.47042 13.8648 7.65093C13.8648 5.83145 12.3762 4.34277 10.5567 4.34277ZM10.5567 12.6132C6.9177 12.6132 3.94035 14.1018 3.94035 15.9213V17.5754H11.7972C11.5491 16.9138 11.3837 16.2522 11.3837 15.5078C11.3837 14.5154 11.6318 13.6056 12.1281 12.6959C11.6318 12.6959 11.1356 12.6132 10.5567 12.6132Z"
                        fill="currentColor"></path>
                    </svg> Promotion</a>
                  <a href="#" class="btnLogin switchBtn"> <svg width="20" height="20" viewBox="0 0 23 23" fill="none"
                      xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="title">
                      <title>Career Switch</title>
                      <path
                        d="M19.8146 9.03172L16.1901 5.40723V8.1256H9.84726V9.93785H16.1901V12.6562M7.12889 10.844L3.50439 14.4685L7.12889 18.093V15.3746H13.4718V13.5623H7.12889V10.844Z"
                        fill="currentColor"></path>
                    </svg> Career Switch</a>
                  <a href="#" class="btnLogin hikeBtn"> <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                      xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="title">
                      <title>Salary Hike</title>
                      <mask id="mask0_271_6453" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24"
                        style="mask-type: alpha;">
                        <rect width="24" height="24" fill="#D9D9D9"></rect>
                      </mask>
                      <g mask="url(#mask0_271_6453)">
                        <path d="M3.4 18L2 16.6L9.4 9.15L13.4 13.15L18.6 8H16V6H22V12H20V9.4L13.4 16L9.4 12L3.4 18Z"
                          fill="currentColor"></path>
                      </g>
                    </svg> Salary Hike</a>
                </div>
                <div class="col-lg-6 rightSheet text-start">
                  <form action="{{ route('save.step') }}">
                    <div class="scrollable-dialogue">
                      <a href="#" class="prev-step"><i class="fa-solid fa-arrow-left-long"></i> </a>
                      <h5 class="modal-title" id="exampleModalToggleLabel">Enter your details to get started</h5>
                      <div class="form-group">
                        <input type="text" class="form-control fillDetail" placeholder="Full name" id="FullName">
                        <label for="FullName">Full name</label>
                      </div>
                      <div class="form-group">
                        <input type="email" class="form-control fillDetail" placeholder="Email Address"
                          id="Fullemail">
                        <label for="Fullemail">Full Email</label>
                      </div>
                      <div class="form-group">
                        <select class="form-control fillDetail" id="highest_qualification" name="highest_qualification">
                          <option selected disabled> Highest Qualifications</option>
                          <option value="B.Sc"> B.Sc</option>
                          <option value="M.Sc."> M.Sc.</option>
                          <option value="MCA"> MCA</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <select class="form-control fillDetail" id="area_of_interest" name="area_of_interest">
                          <option selected disabled> Area of interest</option>
                          <option value="B.Sc"> B.Sc</option>
                          <option value="M.Sc."> M.Sc.</option>
                          <option value="MCA"> MCA</option>
                        </select>
                      </div>
                      <a href="#" class="refferalCode">Have a Refferal Code ?</a>
                    </div>
                    <div class="modal-footer">
                      <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                        <label class="form-check-label" for="flexCheckChecked">
                          Send me updates on Whatsapp
                        </label>
                      </div>
                      <button type="button" class="btn btn-primary save-step-btn next-step" id="submitbutton" disabled>Continue</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="step step-4">
              <div class="row">
                <div class="col-lg-6 leftsheet align-items-center">
                  <img src="{{ asset('') }}frontend/images/login/calendly.svg" class="img-fluid">
                </div>
                <div class="col-lg-6 rightSheet text-start">
                  <a href="#" class="prev-step"><i class="fa-solid fa-arrow-left-long"></i> </a>
                  <form class="align-items-start">
                    <div class="scrollable-dialogue">
                      <button type="button" class="skipbtn" data-bs-dismiss="modal" aria-label="Close">Skip</button>
                      <h5 class="modal-title">Schedule a <span>Free </span> call with our Course expert, Now!</h5>
                      <p> this is so that we can recommend programs that suit you best</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary step-4 position-relative next-step">Continue</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="step step-5">
              <div class="row">
                <div class="col-lg-6 leftsheet align-items-center">
                  <img src="{{ asset('') }}frontend/images/login/calendly.svg" class="img-fluid">
                </div>
                <div class="col-lg-6 rightSheet text-start fullBodyScroll">
                  <form class="align-items-start" id="step5Form" action="{{ route('final.signup') }}" method="POST">
                    @csrf
                    <button type="button" class="skipbtn" data-bs-dismiss="modal" aria-label="Close">Skip</button>
                    <ul class="infoHead">
                      <li><i class="fa-solid fa-info"></i> Additional Info</li>
                      <li><i class="fa-regular fa-calendar"></i> Book a Call</li>
                    </ul>
                    <h5 class="modal-title mb-2" id="exampleModalToggleLabel">We would like to know more</h5>
                    <p class="mb-2">Help us tailor your experience by finding the right course expert</p>
                    <div class="form-group">
                      <select name="interested_course" class="form-control fillDetail">
                        <option selected disabled> Interested in joining a course ?</option>
                        <option value="B.Sc"> B.Sc</option>
                        <option value="M.Sc."> M.Sc.</option>
                        <option value="MCA"> MCA</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <select name="enroll_plan" class="form-control fillDetail">
                        <option selected disabled> By when do you plan to enroll ?</option>
                        <option value="B.Sc"> B.Sc</option>
                        <option value="M.Sc."> M.Sc.</option>
                        <option value="MCA"> MCA</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <select name="career_advice" class="form-control fillDetail">
                        <option selected disabled> Looking for expert career advice ?</option>
                        <option value="B.Sc"> B.Sc</option>
                        <option value="M.Sc."> M.Sc.</option>
                        <option value="MCA"> MCA</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <select name="work_experience" class="form-control fillDetail">
                        <option selected disabled> Work Experience </option>
                        <option value="B.Sc"> B.Sc</option>
                        <option value="M.Sc."> M.Sc.</option>
                        <option value="MCA"> MCA</option>
                      </select>
                    </div>
                   <div class="form-group mb-3">
                      <input type="text" id="callback_date" name="callback_date" 
                            class="form-control fillDetail" 
                            placeholder="Select Date & Time" readonly>
                  </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary final-step">Submit</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            
          </div>
        </div>
      </div>
    </div>
  </div>









  <!-- Signup  -->
  <div class="modal fade signupSheet" id="signup" aria-hidden="true" aria-labelledby="exampleModalToggleLabel"
    tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-6 leftsheet">
              <img src="{{ asset('') }}frontend/images/login/signup.svg" style="width: 100%; height: 100%; object-fit: contain;" class="img-fluid">
              <a href="#" class="btnLogin promotionBtn"> <svg width="20" height="20" viewBox="0 0 23 23" fill="none"
                  xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="title">
                  <title>Promotion</title>
                  <path
                    d="M15.5189 15.0943V18.4025H17.173V15.0943H18.8271L16.346 12.6132L13.8648 15.0943H15.5189ZM10.5567 4.34277C8.73718 4.34277 7.24851 5.83145 7.24851 7.65093C7.24851 9.47042 8.73718 10.9591 10.5567 10.9591C12.3762 10.9591 13.8648 9.47042 13.8648 7.65093C13.8648 5.83145 12.3762 4.34277 10.5567 4.34277ZM10.5567 12.6132C6.9177 12.6132 3.94035 14.1018 3.94035 15.9213V17.5754H11.7972C11.5491 16.9138 11.3837 16.2522 11.3837 15.5078C11.3837 14.5154 11.6318 13.6056 12.1281 12.6959C11.6318 12.6959 11.1356 12.6132 10.5567 12.6132Z"
                    fill="currentColor"></path>
                </svg> Promotion</a>
              <a href="#" class="btnLogin switchBtn"> <svg width="20" height="20" viewBox="0 0 23 23" fill="none"
                  xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="title">
                  <title>Career Switch</title>
                  <path
                    d="M19.8146 9.03172L16.1901 5.40723V8.1256H9.84726V9.93785H16.1901V12.6562M7.12889 10.844L3.50439 14.4685L7.12889 18.093V15.3746H13.4718V13.5623H7.12889V10.844Z"
                    fill="currentColor"></path>
                </svg> Career Switch</a>
              <a href="#" class="btnLogin hikeBtn"> <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                  xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="title">
                  <title>Salary Hike</title>
                  <mask id="mask0_271_6453" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24"
                    style="mask-type: alpha;">
                    <rect width="24" height="24" fill="#D9D9D9"></rect>
                  </mask>
                  <g mask="url(#mask0_271_6453)">
                    <path d="M3.4 18L2 16.6L9.4 9.15L13.4 13.15L18.6 8H16V6H22V12H20V9.4L13.4 16L9.4 12L3.4 18Z"
                      fill="currentColor"></path>
                  </g>
                </svg> Salary Hike</a>
            </div>
            <div class="col-lg-6 rightSheet">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              <form action="{{ route('send.otp') }}" class="login-event">
                <h5 class="modal-title" id="exampleModalToggleLabel">Welcome! Sign up or Login</h5>
                <div class="form-group" id="phoneLogin">
                  <input type="tel" id="mobile_code" class="form-control" placeholder="Phone Number" name="phone"
                    pattern="(\d{10})|(^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$)" maxlength="10">
                </div>
                <div class="form-group d-none" id="emailLogin">
                  <input type="email" id="email" autocomplete="off" required>
                  <label for="email">Email Address</label>
                </div>
                <span class="or-type">or</span>
                <button type="button" class="emailToggle">Continue with Email</button>
                <div class="modal-footer">
                  <button class="btn btn-primary next-step" id="btnSubmit">Continue</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade signupSheet" id="OtpPage" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
    tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

      </div>
    </div>
  </div>
  <div class="modal fade signupSheet" id="detailtostart" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2"
    tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="row">
          <div class="col-lg-6 leftsheet">
            <img src="{{ asset('') }}frontend/images/login/signup.svg" class="img-fluid">
            <a href="#" class="btnLogin promotionBtn"> <svg width="20" height="20" viewBox="0 0 23 23" fill="none"
                xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="title">
                <title>Promotion</title>
                <path
                  d="M15.5189 15.0943V18.4025H17.173V15.0943H18.8271L16.346 12.6132L13.8648 15.0943H15.5189ZM10.5567 4.34277C8.73718 4.34277 7.24851 5.83145 7.24851 7.65093C7.24851 9.47042 8.73718 10.9591 10.5567 10.9591C12.3762 10.9591 13.8648 9.47042 13.8648 7.65093C13.8648 5.83145 12.3762 4.34277 10.5567 4.34277ZM10.5567 12.6132C6.9177 12.6132 3.94035 14.1018 3.94035 15.9213V17.5754H11.7972C11.5491 16.9138 11.3837 16.2522 11.3837 15.5078C11.3837 14.5154 11.6318 13.6056 12.1281 12.6959C11.6318 12.6959 11.1356 12.6132 10.5567 12.6132Z"
                  fill="currentColor"></path>
              </svg> Promotion</a>
            <a href="#" class="btnLogin switchBtn"> <svg width="20" height="20" viewBox="0 0 23 23" fill="none"
                xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="title">
                <title>Career Switch</title>
                <path
                  d="M19.8146 9.03172L16.1901 5.40723V8.1256H9.84726V9.93785H16.1901V12.6562M7.12889 10.844L3.50439 14.4685L7.12889 18.093V15.3746H13.4718V13.5623H7.12889V10.844Z"
                  fill="currentColor"></path>
              </svg> Career Switch</a>
            <a href="#" class="btnLogin hikeBtn"> <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg" role="img" aria-labelledby="title">
                <title>Salary Hike</title>
                <mask id="mask0_271_6453" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24"
                  style="mask-type: alpha;">
                  <rect width="24" height="24" fill="#D9D9D9"></rect>
                </mask>
                <g mask="url(#mask0_271_6453)">
                  <path d="M3.4 18L2 16.6L9.4 9.15L13.4 13.15L18.6 8H16V6H22V12H20V9.4L13.4 16L9.4 12L3.4 18Z"
                    fill="currentColor"></path>
                </g>
              </svg> Salary Hike</a>
          </div>
          <div class="col-lg-6 rightSheet text-start">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <form class="otp-event align-items-start">
              <a href="#" data-bs-target="#OtpPage" data-bs-toggle="modal" data-bs-dismiss="modal"><i
                  class="fa-solid fa-arrow-left-long"></i> </a>
              <h5 class="modal-title mb-0" id="exampleModalToggleLabel">Enter your details to get started</h5>
              <p> +91 1234567890 <a href="#"> Edit </a></p>
              <div class="otpCover">
                <input type="tel" id="otp-number-input-1" placeholder="-" class="otp-number-input" maxlength="1"
                  autocomplete="off">
                <input type="tel" id="otp-number-input-2" placeholder="-" class="otp-number-input" maxlength="1"
                  autocomplete="off">
                <input type="tel" id="otp-number-input-3" placeholder="-" class="otp-number-input" maxlength="1"
                  autocomplete="off">
                <input type="tel" id="otp-number-input-4" placeholder="-" class="otp-number-input" maxlength="1"
                  autocomplete="off">
              </div>
              <div class="d-flex">
                <p class="me-2">Didn't receive OTP?</p>
                <p id="verifiBtn" class="or-type"> Resend in <span id="counter"></span> </p>
              </div>
              <div class="modal-footer">
                <button class="btn btn-primary otp-submit" disabled>Continue</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Signup -->

  @if(request()->is('/') || request()->is('student-dashboard'))
  <nav id="header-nav" class="navbar navbar-expand-lg navigation-expand">
    <div class="container">
      <button class="navbar-toggler d-d-flex d-lg-none order-3 border-0 ms-2" type="button" data-bs-toggle="offcanvas"
        data-bs-target="#bdNavbar" aria-controls="bdNavbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="offcanvas offcanvas-end align-items-center" tabindex="-1" id="bdNavbar">
        <div class="offcanvas-header px-4 pb-0">
          <a class="navbar-brand ps-3" href="index-2.html">
            <img src="{{ asset('') }}frontend/images/i-university-logo-01.png" class="logo" alt="logo">
          </a>
          <button type="button" class="btn-close btn-close-black p-5" data-bs-dismiss="offcanvas" aria-label="Close"
            data-bs-target="#bdNavbar"></button>
        </div>
        <div class="offcanvas-body ">
          <ul id="navbar" class="navbar-nav fw-bold justify-content-center align-items-center d-flex-grow-1">
            <ul id="navbar" class="navbar-nav fw-bold justify-content-center align-items-center d-flex-grow-1">

              @foreach($categories as $cat)
              <li class="nav-item dropdown ktm-mega-menu">
                <a class="nav-link border-0 dropdown-toggle me-4"
                  href="#"
                  id="navbarDropdown{{ $cat->id }}"
                  role="button"
                  data-bs-toggle="dropdown"
                  data-bs-auto-close="outside"
                  aria-expanded="false">

                  {{-- Dynamic Icon --}}
                  <img src="https://images.incomeowl.in/incomeowl/crm/images/{{ $cat->degree_category_icon }}"
                    alt="{{ $cat->degree_category }} Icon" width="30" height="30" />

                  {{-- Dynamic Category Name --}}
                  <span class="category-text">{{ $cat->degree_category }}</span>
                </a>

                {{-- Mega Menu Dropdown --}}
                <div class="dropdown-menu mega-menu p-3" aria-labelledby="navbarDropdown{{ $cat->id }}">
                  <div class="container">
                    <div class="row">

                      {{-- Left Sidebar (Types) --}}
                      @if(!empty($cat->types))
                      <div class="col-lg-3">
                        <div class="left-tab">
                          <h4><i class="fa-solid fa-list me-2"></i> Domains</h4>
                          <div class="nav flex-column nav-pills menu-tab"
                            id="v-pills-tab{{ $cat->id }}" role="tablist">

                            @foreach($cat->types as $type)
                            <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                              id="v-{{ $type }}-tab{{ $cat->id }}"
                              data-bs-toggle="pill"
                              data-bs-target="#v-{{ $type }}{{ $cat->id }}"
                              type="button" role="tab"
                              aria-controls="v-{{ $type }}{{ $cat->id }}"
                              aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                              {{ ucwords(str_replace('_', ' ', $type)) }}
                              <i class="fa-solid fa-chevron-right float-end"></i>
                            </button>
                            @endforeach
                          </div>
                        </div>
                      </div>

                      {{-- Right Content Area --}}
                      <div class="col-lg-9">
                        <div class="right-tab">
                          <div class="tab-content" id="v-pills-tabContent{{ $cat->id }}">
                            @foreach($cat->types as $type)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                              id="v-{{ $type }}{{ $cat->id }}" role="tabpanel"
                              aria-labelledby="v-{{ $type }}-tab{{ $cat->id }}">

                              {{-- Header --}}
                              <div class="d-flex justify-content-between mb-3">
                                <h4>{{ ucfirst($cat->degree_category) }}</h4>
                                <div class="view-all-btn">
                                  <a href="{{ url('category/'.$cat->id.'/'.$type) }}">View All</a>
                                  <i class="fa-solid fa-chevron-right"></i>
                                </div>
                              </div>

                              {{-- Universities List --}}
                              <div class="row">
                                @if(isset($cat->universities[$type]))
                                @foreach($cat->universities[$type] as $university)
                                <div class="col-lg-4 mb-3">
                                  <a href="{{ url('programme/'.$university->id) }}">
                                    <div class="d-flex w-100 align-items-start gap-2">
                                      <img src="https://images.incomeowl.in/incomeowl/crm/images/{{ $university->degree_category_icon }}"
                                        width="50" height="50" class="rounded-1" />
                                      <span class="d-flex flex-column g-2">
                                        <p class="text-gray small mb-0" style="font-size: 12px;">{{ $university->university_name }}</p>
                                        <p class="text-dark fw-semibold mb-0" style="font-size: 10px;">{{ $university->degree_name }}</p>
                                      </span>
                                    </div>
                                  </a>
                                </div>
                                @endforeach
                                @else
                                <div class="col-lg-12">
                                  <p class="text-muted">No universities found for this type.</p>
                                </div>
                                @endif
                              </div>

                            </div>
                            @endforeach
                          </div>
                        </div>
                      </div>
                      @endif

                    </div>
                  </div>
                </div>
              </li>
              @endforeach


            </ul>

          </ul>
        </div>
      </div>
    </div>
  </nav>
  @endif
</header>