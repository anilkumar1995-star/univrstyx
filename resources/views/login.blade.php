<!DOCTYPE html>

<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('theme_1/assets/') }}" data-template="vertical-menu-template">

<head>

    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Streamline your business with our advanced CRM template. Easily integrate and customize to manage sales, support, and customer interactions efficiently. Perfect for any business size">
    <meta name="keywords"
        content="Advanced CRM template, customer relationship management, business CRM, sales optimization, customer support software, CRM integration, customizable CRM, business tools, enterprise CRM solutions">
    <meta name="author" content="Dreams Technologies">
    <meta name="robots" content="index, follow">
    <title>Login - {{ @$company->companyname }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logos/icon.png') }}">
    <link rel="icon" sizes="180x180" href="{{ asset('logos/icon.png') }}">
    <!-- Favicon -->

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon"
        href="{{ Imagehelper::getImageUrl() . json_decode(app\Models\Company::where('id', '1')->first(['logo']))->logo }}"
        class=" img-fluid rounded" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets1/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets1/plugins/tabler-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets1/plugins/flag-icons.css') }}">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets1/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets1/plugins/fontawesome/css/all.min.css') }}">
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets1/css/style.css') }}">

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('asset/assets1/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset/assets1/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('asset/assets1/libs/typeahead-js/typeahead.css') }}" />
    <!-- Vendor -->
    <link rel="stylesheet" href="{{ asset('asset/assets1/libs/formvalidation/dist/css/formValidation.min.css') }}" />

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.css" />

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.js"></script>

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('asset/assets1/css/pages/page-auth.css') }}" />

    <style>
        .form-group p {
            color: red;
        }
    </style>
</head>

<body>
    <!-- Content -->
    @if (env('MAINTENANCE_MODE', false))
        {{ Artisan::call('down') }}
    @endif

    <div class="authentication-wrapper authentication-cover authentication-bg">
        <div class="authentication-inner row sign-in-page" style="height: 90%;">
            <!-- Left side: Illustration + Logo -->
            <div class="d-none d-lg-flex col-lg-7 p-4 flex-column justify-content-center align-items-center bg-white">
                <img src="{{ asset('assets1/img/logo1.jpg') }}" alt="auth-illustration" class="img-fluid rounded"
                    style="max-width: 85%;width:80%;height:70%;">
            </div>
            <!-- /Left Text -->

            <!-- Login -->
            <div class="d-flex col-12 col-lg-5 align-items-center p-md-5 p-3">
                <div class="w-px-400 mx-auto sign-in-from">
                 
                    <div class="mb-5 w-50">
                        <img src="{{ asset('frontend/images/I-University_logo_11.png') }}" class="img-fluid w-75" alt="Logo">
                    </div>
                    <div class="mb-5">
                        <h4 class="my-2 fs-20">Sign In</h4>
                        <p>Please sign in to access the University Admin Panel and manage courses, degrees, and syllabus</p>
                    </div>

                    <form action="{{ route('authCheck') }}" method="POST" class="login-form">
                        <p style="color:red"><b class="errorText"></b></p>
                        <p style="color:teal"><b class="successText"></b></p>
                        {{ csrf_field() }}
                        <input type="number" class="form-control" hidden name="latitude" id="latitude" required
                            placeholder="latitude">
                        <input type="number" class="form-control" hidden name="longitude" id="longitude" required
                            placeholder="longitude">
                        <div class="mb-3">
                            <label class="col-form-label">Mobile Number :</label>
                            <div class="position-relative">
                                <span class="input-icon-addon">
                                    <i class="ti ti-mail"></i>
                                </span>
                                <input type="number"name="mobile" pattern="[0-9]*" maxlength="10" minlength="10"
                                    required class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label">Password :</label>
                            <div class="pass-group">
                                <input type="password"name="password" class="pass-input form-control">
                                <span class="ti toggle-password ti-eye-off"></span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="form-check form-check-md d-flex align-items-center">
                                <input class="form-check-input" type="checkbox" value="" id="checkebox-md"
                                    checked="">
                                <label class="form-check-label" for="checkebox-md">
                                    Remember Me
                                </label>
                            </div>
                            {{-- <div class="text-end">
                                <a href="javascript:void(0)" onclick="forgetPassword()"
                                    class="text-primary fw-medium link-hover">Forgot
                                    Password?</a>
                            </div> --}}
                        </div>
                        <div class="formdata">

                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary w-100">Sign In</button>
                        </div>
                        <!-- <div class="mb-3">
                            <h6>New on our platform?<a href="#" data-bs-toggle="modal"
                                    data-bs-target="#registerModal" class="text-purple link-hover"> Create
                                    an account</a></h6>
                        </div>  -->
            
                    </form>

                    {{-- <div class="d-flex align-items-center my-4">
                        <div class="flex-grow-1 border-top"></div>
                        <span class="mx-3">OR</span>
                        <div class="flex-grow-1 border-top"></div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center flex-wrap mb-2">
                        <div class="text-center me-2 flex-fill">
                            <a href="javascript:void(0);"
                                class="br-10 p-2 px-4 btn bg-pending d-flex align-items-center justify-content-center">
                                <!-- Icon from SVG -->
                                <img class="img-fluid m-1" src="{{ asset('assets1/img/icons/facebook-logo.svg') }}"
                                    alt="Facebook">
                            </a>
                        </div>
                        <div class="text-center me-2 flex-fill">
                            <a href="javascript:void(0);"
                                class="br-10 p-2 px-4 btn bg-white d-flex align-items-center justify-content-center">
                                <img class="img-fluid m-1" src="{{ asset('assets1/img/icons/google-logo.svg') }}"
                                    alt="Google">
                            </a>
                        </div>
                        <div class="text-center flex-fill">
                            <a href="javascript:void(0);"
                                class="bg-dark br-10 p-2 px-4 btn btn-dark d-flex align-items-center justify-content-center">
                                <img class="img-fluid m-1" src="{{ asset('assets1/img/icons/apple-logo.svg') }}"
                                    alt="Apple">
                            </a>
                        </div>
                    </div> --}}
                </div>
            </div>
            <!-- /Login -->
        </div>
    </div>


    <div class="modal fade" id="passwordResetModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Forgot Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <form id="passwordRequestForm" action="{{ route('authReset') }}" method="post">
                        <b>
                            <p class="text-danger"></p>
                        </b>
                        <input type="hidden" name="type" value="request">
                        {{ csrf_field() }}
                        <div class="form-group my-1">
                            <label>Mobile</label>
                            <input type="text" name="mobile" class="form-control my-1"
                                placeholder="Enter Mobile Number" required="">
                        </div>
                        <div class="form-group my-1">
                            <button class="btn btn-primary btn-block text-uppercase waves-effect waves-light"
                                type="submit"
                                data-loading-text="<i class='fa fa-spin fa-spinner'></i> Resetting">Reset
                                Request</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="passwordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Forgot Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    <form id="passwordForm" action="{{ route('authReset') }}" method="post">
                        <b>
                            <p class="text-danger"></p>
                        </b>
                        <input type="hidden" name="mobile">
                        <input type="hidden" name="type" value="reset">
                        {{ csrf_field() }}
                        <div class="form-group my-1">
                            <label>Reset Token</label>
                            <input type="text" name="token" class="form-control my-1" placeholder="Enter OTP"
                                required="">
                        </div>
                        <div class="form-group my-1">
                            <label>New Password</label>
                            <input type="password" name="password" class="form-control my-1"
                                placeholder="Enter New Password" required="">
                        </div>
                        <div class="form-group mt-3">
                            <button class="btn btn-primary btn-block text-uppercase waves-effect waves-light"
                                type="submit"
                                data-loading-text="<i class='fa fa-spin fa-spinner'></i> Resetting">Reset
                                Password</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

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
                        <input type="hidden" name="agentcode" value="{{ date('ymdhis') }}">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="form-group mb-1 col-md-4">
                                <label>Member Type</label>
                                <select name="slug" class="form-control my-1 select" required>
                                    <option value="">Select Member Type</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->slug }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <h5 class="mb-2">Personal Details</h5>
                        <div class="row">
                            <div class="form-group my-1 col-md-4">
                                <label for="exampleInputEmail1">Name</label>
                                <input type="text" name="name" class="form-control my-1"
                                    placeholder="Enter your name" required>
                            </div>
                            <div class="form-group my-1 col-md-4">
                                <label for="exampleInputPassword1">Email</label>
                                <input type="text" name="email" class="form-control my-1"
                                    placeholder="Enter your email id" required>
                                <div class="alert-message" id="emailError"></div>
                            </div>
                            <div class="form-group my-1 col-md-4">
                                <label for="exampleInputPassword1">Mobile</label>

                                <input type="tel" maxlength="10" name="mobile" class="form-control my-1"
                                    placeholder="Enter your mobile" required>

                                <div class="alert-message" id="mobileError"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group my-1 col-md-4">
                                <label>State</label>
                                <select name="state" class="form-control my-1 state" required>
                                    <option value="">Select State</option>
                                    @foreach ($states as $state)
                                        <option value="{{ $state->state_name }}">{{ $state->state_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group my-1 col-md-4">
                                <label>City</label>
                                <input type="text" name="city" class="form-control my-1" value=""
                                    required="" placeholder="Enter Value">
                            </div>
                            <div class="form-group my-1 col-md-4">
                                <label>Pincode</label>

                                <input type="tel" name="pincode" class="form-control my-1" value=""
                                    required="" maxlength="6" minlength="6" placeholder="Enter Value"
                                    pattern="[0-9]*">

                            </div>
                      {{--     <div class="form-group my-1 col-md-4">
                                <label>Shop Name</label>
                                <input type="text" name="shopname" class="form-control my-1" value=""
                                    required="" placeholder="Enter Value">
                                <div class="alert-message" id="shopnameError"></div>
                            </div>
                            <div class="form-group my-1 col-md-4">
                                <label>Pancard</label>
                                <input type="text" name="pancard" class="form-control my-1" value=""
                                    id="pancard" required="" placeholder="Enter Value">
                                <div class="alert-message" id="pancardError"></div>
                            </div>
                            <div class="form-group my-1 col-md-4">
                                <label>Aadhar</label>
                                <input type="text" name="aadharcard" required="" class="form-control my-1"
                                    id="aadharcard" placeholder="Enter Value" pattern="[0-9]*" maxlength="12"
                                    minlength="12">
                                <div class="alert-message" id="aadharcardError"></div>
                            </div>
                        </div>--}} 
                        <div class="row">
                            <div class="form-group my-1 col-md-12">
                                <label>Address</label>
                                <textarea name="address" class="form-control my-1" rows="3" required="" placeholder="Enter Value"></textarea>
                            </div>
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

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('theme_1/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('theme_1/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('theme_1/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('theme_1/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('theme_1/assets/vendor/libs/node-waves/node-waves.js') }}"></script>

    <script src="{{ asset('theme_1/assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('theme_1/assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('theme_1/assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>

    <script src="{{ asset('theme_1/assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('theme_1/assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
    <script src="{{ asset('theme_1/assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
    <script src="{{ asset('theme_1/assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('') }}assets/js/core/jquery.validate.min.js"></script>
    <!-- Page JS -->
    <script src="{{ asset('theme_1/assets/js/pages-auth.js') }}"></script>
    <script src="{{ asset('') }}theme/js/jquery.min.js"></script>
    <script src="{{ asset('') }}theme/js/jquery.appear.js"></script>
    <script src="{{ asset('') }}theme/js/countdown.min.js"></script>
    <script src="{{ asset('') }}theme/js/waypoints.min.js"></script>
    <script src="{{ asset('') }}theme/js/jquery.counterup.min.js"></script>
    <script src="{{ asset('') }}theme/js/wow.min.js"></script>
    <script src="{{ asset('') }}theme/js/apexcharts.js"></script>
    <script src="{{ asset('') }}theme/js/lottie.js"></script>
    <script src="{{ asset('') }}theme/js/slick.min.js"></script>
    <script src="{{ asset('') }}theme/js/select2.min.js"></script>
    <script src="{{ asset('') }}theme/js/owl.carousel.min.js"></script>
    <script src="{{ asset('') }}theme/js/jquery.magnific-popup.min.js"></script>
    <script src="{{ asset('') }}theme/js/smooth-scrollbar.js"></script>
    <script src="{{ asset('') }}theme/js/style-customizer.js"></script>
    <script src="{{ asset('') }}theme/js/chart-custom.js"></script>
    <script src="{{ asset('') }}theme/js/custom.js"></script>
    <script src="{{ asset('') }}assets/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="{{ asset('') }}assets/js/core/jquery.validate.min.js"></script>
    <script type="text/javascript" src="{{ asset('') }}assets/js/core/jquery.form.min.js"></script>
    <script type="text/javascript" src="{{ asset('') }}assets/js/core/sweetalert2.min.js"></script>
    <script type="text/javascript" src="{{ asset('') }}assets/js/plugins/forms/selects/select2.min.js"></script>
    <script src="{{ asset('') }}assets/js/core/snackbar.js"></script>
    <script>
        $(document).ready(function() {

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {

                        var lat = position.coords.latitude;
                        var lng = position.coords.longitude;


                        $('.login-form').append(`
                    <input type="hidden" name="latitude" value="${lat}">
                    <input type="hidden" name="longitude" value="${lng}">
                `);
                    },
                    function(error) {
                        if (error.code === error.PERMISSION_DENIED) {
                            swal("Location Blocked", "Please allow location access to log in.", "warning");
                        }
                    }
                );
            } else {
                swal("Unsupported Browser", "Your browser does not support location services.", "error");
            }
            $('#passwordView').click(function() {
                var passwordType = $(this).closest('form').find('[name="password"]').attr('type');
                if (passwordType == "password") {
                    $(this).closest('form').find('[name="password"]').attr('type', "text");
                    $(this).find('i').removeClass('a fa-eye').addClass('fa fa-eye-slash');
                } else {
                    $(this).closest('form').find('[name="password"]').attr('type', "password");
                    $(this).find('i').addClass('a fa-eye').removeClass('fa fa-eye-slash');
                }
            });
            var number = 1 + Math.floor(Math.random() * 100000);
            $('#capcha').text(number);
            $(".login-form").validate({
                rules: {
                    mobile: {
                        required: true,
                        minlength: 10,
                        number: true,
                        maxlength: 11
                    },
                    password: {
                        required: true,
                    },
                    capchaConfirm: {
                        required: true,
                    },
                    capcha: {
                        required: true,
                        minlength: 6,
                        equalTo: "#capchaConfirm"
                    },
                },
                messages: {
                    mobile: {
                        required: "Please enter mobile number",
                        number: "Mobile number should be numeric",
                        minlength: "Your mobile number must be 10 digit",
                        maxlength: "Your mobile number must be 10 digit"
                    },
                    capcha: {
                        required: "Please enter captcha",
                        number: "Captcha should be numeric",
                        equalTo: "Invalid Captcha",
                        minlength: "Your captcha  must be 6 digit",

                    },
                    password: {
                        required: "Please enter password",
                    },
                    capchaConfirm: {
                        required: "Please enter password",
                    }
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    if (element.prop("tagName").toLowerCase() === "select") {
                        error.insertAfter(element.closest(".form-group").find(".select2"));
                    } else {
                        error.insertAfter(element);
                        $
                    }
                },
                submitHandler: function() {

                    if (navigator.permissions) {
                        navigator.permissions.query({
                            name: 'geolocation'
                        }).then(function(permissionStatus) {
                            if (permissionStatus.state === "denied") {
                                swal("Location Blocked",
                                    "Please allow location access from browser settings to proceed.",
                                    "warning");
                                return;
                            }


                            if (permissionStatus.state === "prompt" || permissionStatus
                                .state === "granted") {
                                navigator.geolocation.getCurrentPosition(function(position) {
                                    var lat = position.coords.latitude;
                                    var lng = position.coords.longitude;


                                    $('.login-form').append(`
                        <input type="hidden" name="latitude" value="${lat}">
                        <input type="hidden" name="longitude" value="${lng}">
                    `);


                                    var form = $('.login-form');
                                    form.ajaxSubmit({
                                        dataType: 'json',
                                        beforeSubmit: function() {
                                            swal({
                                                title: 'Wait!',
                                                text: 'We are checking your login credential',
                                                onOpen: () => {
                                                    swal.showLoading()
                                                },
                                                allowOutsideClick: () =>
                                                    !swal
                                                    .isLoading()
                                            });
                                        },
                                        success: function(data) {
                                            swal.close();
                                            if (data.status == "Login") {
                                                swal({
                                                    type: 'success',
                                                    title: 'Success',
                                                    text: 'Successfully logged in.',
                                                    showConfirmButton: false,
                                                    timer: 2000,
                                                    onClose: () => {
                                                        window
                                                            .location
                                                            .reload();
                                                    },
                                                });
                                            } else if (data.status ==
                                                "otpsent" || data.status ==
                                                "preotp") {
                                                $('div.formdata').append(`
                                    <div class="form-group my-3">
                                        <div class="d-flex justify-content-between">
                                            <label for="otp">OTP</label>
                                            <a href="javascript:void(0)" onclick="OTPRESEND()">
                                                <small>Resend OTP</small>
                                            </a>
                                        </div>
                                        <input type="password" class="form-control my-1" placeholder="Enter Otp" name="otp" required>
                                    </div>
                                `);

                                                if (data.status ==
                                                    "preotp") {
                                                    $('b.successText').text(
                                                        'Please use previous otp sent on your mobile.'
                                                    );
                                                    setTimeout(() => $(
                                                            'b.successText'
                                                        ).text(''),
                                                        5000);
                                                }
                                            }
                                        },
                                        error: function(errors) {
                                            swal.close();
                                            if (errors.status == '400') {
                                                $('b.errorText').text(errors
                                                    .responseJSON.status
                                                );
                                            } else {
                                                $('b.errorText').text(
                                                    'Something went wrong, try again later.'
                                                );
                                            }
                                            setTimeout(() => $(
                                                'b.errorText').text(
                                                ''), 5000);
                                        }
                                    });
                                }, function(error) {
                                    // If user denies when prompted
                                    swal("Location Error",
                                        "We couldn't get your location. Please allow access to proceed.",
                                        "error");
                                });
                            }
                        });
                    } else {
                        swal("Unsupported Browser",
                            "Your browser does not support location permissions.", "error");
                    }
                }

            });

            $("#registerForm").validate({
                rules: {
                    slug: {
                        required: true
                    },
                    name: {
                        required: true,
                    },
                    mobile: {
                        required: true,
                        minlength: 10,
                        number: true,
                        maxlength: 10
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    state: {
                        required: true,
                    },
                    city: {
                        required: true,
                    },
                    pincode: {
                        required: true,
                        minlength: 6,
                        number: true,
                        maxlength: 6
                    },
                    address: {
                        required: true,
                    },
                    aadharcard: {
                        required: true,
                        minlength: 12,
                        number: true,
                        maxlength: 12
                    },
                    pancard: {
                        required: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    shopname: {
                        required: true,
                    }

                },
                messages: {
                    slug: {
                        required: "Please select member type",
                    },
                    name: {
                        required: "Please enter name",
                    },
                    mobile: {
                        required: "Please enter mobile",
                        number: "Mobile number should be numeric",
                        minlength: "Your mobile number must be 10 digit",
                        maxlength: "Your mobile number must be 10 digit"
                    },
                    email: {
                        required: "Please enter email",
                        email: "Please enter valid email address",
                    },
                    state: {
                        required: "Please select state",
                    },
                    city: {
                        required: "Please enter city",
                    },
                    pincode: {
                        required: "Please enter pincode",
                        number: "Mobile number should be numeric",
                        minlength: "Your pincode number must be 6 digit",
                        maxlength: "Your pincode number must be 6 digit"
                    },
                    address: {
                        required: "Please enter address",
                    },
                    aadharcard: {
                        required: "Please enter aadharcard",
                        number: "Aadhar should be numeric",
                        minlength: "Your aadhar number must be 12 digit",
                        maxlength: "Your aadhar number must be 12 digit"
                    },
                    pancard: {
                        required: "Please enter pancard",
                        minlength: "Your pancard number must be 10 digit",
                        maxlength: "Your pancard number must be 10 digit"
                    },
                    shopname: {
                        required: "Please enter shopname"

                    },
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    if (element.prop("tagName").toLowerCase() === "select") {
                        error.insertAfter(element.closest(".form-group").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var form = $('#registerForm');
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('Please wait...').attr(
                                "disabled",
                                true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button:submit').html('Submit').attr("disabled",
                                false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status == "TXN") {
                                $('#registerModal').modal('hide');
                                notify('Your request has been submitted successfully, please wait for confirmation',
                                    'success');
                            } else {
                                notify(data.message, 'error');
                            }
                        },
                        error: function(errors) {
                            form.find('button:submit').html('Submit').attr("disabled",
                                false).removeClass('btn-secondary');
                            if (errors.status == '422') {
                                // notify(errors.responseJSON.errors[0], 'warning');
                                $('#emailError').text(errors.responseJSON.errors.email);
                                $('#mobileError').text(errors.responseJSON.errors.mobile);
                                $('#shopnameError').text(errors.responseJSON.errors
                                    .shopname);
                                $('#pancardError').text(errors.responseJSON.errors.pancard);
                                $('#aadharcardError').text(errors.responseJSON.errors
                                    .aadharcard);

                            } else {
                                swal("Oh No!", "Something went wrong, try again later!",
                                    "error");
                                //  notify('Something went wrong, try again later.', 'warning');
                            }
                        }
                    });
                }
            });

            $("#passwordForm").validate({
                rules: {
                    token: {
                        required: true,
                        number: true
                    },
                    password: {
                        required: true,
                    }
                },
                messages: {
                    mobile: {
                        required: "Please enter reset token",
                        number: "Reset token should be numeric",
                    },
                    password: {
                        required: "Please enter password",
                    }
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    if (element.prop("tagName").toLowerCase() === "select") {
                        error.insertAfter(element.closest(".form-group").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var form = $('#passwordForm');
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button[type="submit"]').html('Please wait...').attr(
                                'disabled', true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button[type="submit"]').html('Reset Password').attr(
                                'disabled', false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status == "TXN") {
                                $('#passwordModal').modal('hide');
                                swal({
                                    type: 'success',
                                    title: 'Reset!',
                                    text: 'Password Successfully Changed',
                                    showConfirmButton: true
                                });
                            } else {
                                notify(data.message, 'error');
                            }
                        },
                        error: function(errors) {
                            if (errors.status == '400') {
                                notify(errors.responseJSON.message, 'error');
                            } else if (errors.status == '422' || errors.responseJSON
                                .statuscode == 'ERR') {
                                notify(errors.responseJSON[0] || errors.responseJSON
                                    .message, 'error');
                                // $.each(errors.responseJSON.errors, function(index, value) {
                                //     form.find('[name="' + index + '"]').closest(
                                //         'div.form-group').append(
                                //         '<p class="error">' + value + '</span>');
                                // });
                                // form.find('p.error').first().closest('.form-group').find(
                                //     'input').focus();
                                // setTimeout(function() {
                                //     form.find('p.error').remove();
                                // }, 5000);
                            } else {
                                notify('Something went wrong, try again later.', 'error');
                            }
                        }
                    });
                }
            });



            $("#otpForm").validate({
                rules: {
                    otp: {
                        required: true,
                        number: true
                    }

                },
                messages: {
                    otp: {
                        required: "Please enter otp",
                        number: "Reset otp should be numeric",
                    }

                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    if (element.prop("tagName").toLowerCase() === "select") {
                        error.insertAfter(element.closest(".form-group").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var form = $('#otpForm');
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            swal({
                                title: 'Wait!',
                                text: 'We are checking your details',
                                onOpen: () => {
                                    swal.showLoading()
                                },
                                allowOutsideClick: () => !swal.isLoading()
                            });
                        },
                        success: function(data) {
                            swal.close();
                            if (data.status == "TXN") {
                                $('#otpModal').modal('hide');

                                // $('#registerForm').find(':input[type=submit]').removeAttr('disabled');
                                $('#registerForm').find('[name="address"]').val(data
                                    .address);
                                $("#address").prop('readonly', true);
                                $('#registerForm').find('[name="name"]').val(data
                                    .full_name);
                                $("#name").prop('readonly', true);
                                $('#registerForm').find('[name="city"]').val(data.city);
                                $("#city").prop('readonly', true);
                                $('#registerForm').find('[name="pincode"]').val(data.pin);
                                $("#pincode").prop('readonly', true);
                                $('#registerForm').find('[name="state"]').select2().val(data
                                    .state).trigger('change');
                                $("state").prop('readonly', true);
                                // $('#registerForm').find('[name="state"]').val();
                                swal("Verified", "Your Adhar Card is Verified " + data
                                    .full_name, "success");

                            } else {
                                $('#aadharcard').val('');
                                swal({
                                    type: 'warning',
                                    title: '!ERROR',
                                    text: data.message,
                                    showConfirmButton: true
                                });
                            }
                        },
                        error: function(errors) {
                            swal.close();
                            if (errors.status == '400') {
                                notify(errors.responseJSON.status, 'error');
                            } else {
                                notify('Something went wrong, try again later.', 'error');
                            }
                        }
                    });
                }
            });



        });

        // function notify(msg, type = "success") {
        //     let snackbar = new SnackBar;
        //     snackbar.make("message", [
        //         msg,
        //         null,
        //         "bottom",
        //         "right",
        //         "text-" + type
        //     ], 5000);
        // }


        function notify(text, status) {
            new Notify({
                status: status,
                title: null,
                text: text,
                effect: 'fade',
                customClass: null,
                customIcon: null,
                showIcon: true,
                showCloseButton: true,
                autoclose: true,
                autotimeout: 2000,
                gap: 20,
                distance: 15,
                type: 1,
                position: 'right top'
            })
        }




        function forgetPassword() {

            var mobile = $('.login-form').find('[name="mobile"]').val();
            var form = $('.login-form');
            if (mobile != '') {

                $.ajax({
                    url: `{{ route('authReset') }}`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    data: {
                        'type': 'request',
                        "mobile": mobile
                    },
                    beforeSubmit: function() {
                        form.find('button[type="submit"]').html('Please wait...').attr('disabled', true)
                            .addClass('btn-secondary');
                    },
                    complete: function() {
                        form.find('button[type="submit"]').attr('disabled', false).removeClass('btn-secondary');
                    },
                    success: function(data) {
                        swal.close();
                        if (data.status == "TXN") {
                            notify(data.message, 'success');
                            $('#passwordResetModal').modal('hide');
                            $('#passwordForm').find('input[name="mobile"]').val(mobile);
                            $('#passwordModal').modal('show');
                        } else {
                            $('b.errorText').text(data.message);
                            setTimeout(function() {
                                $('b.errorText').text('');
                            }, 5000);
                        }
                    },
                    error: function(errors) {
                        form.find('button[type="submit"]').html('Reset Password').attr('disabled', false)
                            .removeClass('btn-secondary');

                        if (errors.status == '400') {
                            $('b.errorText').text(errors.responseJSON.message);
                            setTimeout(function() {
                                $('b.errorText').text('');
                            }, 5000);
                        } else {
                            $('b.errorText').text("Something went wrong, try again later.");
                            setTimeout(function() {
                                $('b.errorText').text('');
                            }, 5000);
                        }
                    }
                })

            } else {
                $('b.errorText').text('Enter your registered mobile number');
                setTimeout(function() {
                    $('b.errorText').text('');
                }, 5000);
            }
        }

        function OTPRESEND() {
            var mobile = $('input[name="mobile"]').val();
            var password = $('input[name="password"]').val();
            if (mobile.length > 0) {
                $.ajax({
                        url: '{{ route('authCheck') }}',
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            'mobile': mobile,
                            'password': password,
                            'otp': "resend"
                        },
                        beforeSend: function() {
                            swal({
                                title: 'Wait!',
                                text: 'Please wait, we are working on your request',
                                onOpen: () => {
                                    swal.showLoading()
                                }
                            });
                        },
                        complete: function() {
                            swal.close();
                        }
                    })
                    .done(function(data) {
                        if (data.status == "otpsent") {
                            $('b.successText').text('Otp sent successfully');
                            setTimeout(function() {
                                $('b.successText').text('');
                            }, 5000);
                        } else {
                            $('b.errorText').text(data.message);
                            setTimeout(function() {
                                $('b.errorText').text('');
                            }, 5000);
                        }
                    })
                    .fail(function() {
                        $('b.errorText').text('Something went wrong, try again');
                        setTimeout(function() {
                            $('b.errorText').text('');
                        }, 5000);
                    });
            } else {
                $('b.errorText').text('Enter your registered mobile number');
                setTimeout(function() {
                    $('b.errorText').text('');
                }, 5000);
            }
        }
    </script>

</body>

</html>
