@extends('layouts.app_new')
{{-- @extends('layouts.app') --}}
@section('title', ucwords($user->name) . ' Profile')
@section('bodyClass', 'has-detached-left')
@section('pagetitle', ucwords($user->name) . ' Profile')

@section('content')
    <style>
        .select2-container--default .select2-selection--single {
            height: 40px !important;
            padding: 3px 6px !important;
            border: 1px solid #d9d9d9 !important;
        }
    </style>
    <div class="content">
        <div class="row">
            <div class="col-lg-12 ">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between mb-lg-n4">
                        <div class="card-title mb-0">
                            <h5 class="mb-0">
                                <h4>My Profile</h4>
                            </h5>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class=" rounded">
                            <div class="row gap-4 gap-sm-0">
                                <div class="">
                                    <ul class="nav nav-tabs nav-pills w-100 border-bottom tab-style-1 d-sm-flex" role="tablist">
                                        <li class="nav-item w-25">
                                            <button type="button" class="nav-link active" role="tab"
                                                data-bs-toggle="tab" data-bs-target="#navs-justified-profile"
                                                aria-controls="navs-justified-profile" aria-selected="true">
                                                Profile Details
                                            </button>
                                        </li>
                                        @if ((Auth::id() == $user->id && Myhelper::can('password_reset')) || Myhelper::can('member_password_reset'))
                                            <li class="nav-item w-25">
                                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                                    data-bs-target="#navs-justified-password"
                                                    aria-controls="navs-justified-password" aria-selected="false">
                                                    Password Manager
                                                </button>
                                            </li>
                                        @endif

                                        @if (Auth::user()->role_id == 3)
                                            <li class="nav-item w-25">
                                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                                    data-bs-target="#navs-justified-salary"
                                                    aria-controls="navs-justified-salary" aria-selected="false">
                                                    Salary Details
                                                </button>
                                            </li>
                                        @endif

                                    </ul>

                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="navs-justified-profile" role="tabpanel">
                                            <form id="profileForm" action="{{ route('profileUpdate') }}" method="post"
                                                enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="id" value="{{ $user->id }}">
                                                <input type="hidden" name="actiontype" value="profile">

                                                <div class="row">
                                                    <div class="form-group col-md-4 my-1">
                                                        <label>Name</label>
                                                        <input type="text" name="name" class="form-control my-1"
                                                            value="{{ $user->name }}" required=""
                                                            placeholder="Enter Value">
                                                    </div>
                                                    <div class="form-group col-md-4 my-1">
                                                        <label>Mobile</label>
                                                        <input type="tel" maxlength="10"
                                                            {{ Myhelper::hasNotRole('admin') ? 'disabled=""' : 'name=mobile' }}
                                                            required="" value="{{ $user->mobile }}"
                                                            class="form-control my-1" placeholder="Enter Value">
                                                    </div>
                                                    <div class="form-group col-md-4 my-1">
                                                        <label>Email</label>
                                                        <input type="email" name="email" class="form-control my-1"
                                                            value="{{ $user->email }}" required=""
                                                            placeholder="Enter Value">
                                                    </div>

                                                    <div class="form-group col-md-4 my-1">
                                                        <label class="mb-1">State</label> <br />
                                                        <select name="state" class="form-control my-1 select2 js-example-basic-single"
                                                            required="">
                                                            <option value="">Select State</option>
                                                            @foreach ($state as $state)
                                                                <option value="{{ $state->state }}">{{ $state->state }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-4 my-1">
                                                        <label>City</label>
                                                        <input type="text" name="city" class="form-control my-1"
                                                            value="{{ $user->city }}" required=""
                                                            placeholder="Enter Value">
                                                    </div>
                                                    <div class="form-group col-md-4 my-1">
                                                        <label>PIN Code</label>
                                                        <input type="tel" name="pincode" class="form-control my-1"
                                                            value="{{ $user->pincode }}" required="" maxlength="6"
                                                            minlength="6" placeholder="Enter Value">
                                                    </div>

                                                    <div class="form-group col-md-4 my-1">
                                                        <label>Gender</label>
                                                        <select name="gender" class="form-control my-1" required="">
                                                            <option value="">Select Gender</option>
                                                            <option value="male">Male</option>
                                                            <option value="female">Female</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-4 my-1">
                                                        <label>Address</label>
                                                        <input type="text" name="address" class="form-control my-1"
                                                            rows="3" required="" placeholder="Enter Value"
                                                            value="{{ $user->address }}"></input>
                                                    </div>
                                                    {{-- @if (Myhelper::hasRole('admin'))
                                                    <div class="form-group col-md-4 my-1">
                                                        <label>Security PIN</label>
                                                        <input type="password" name="mpin" autocomplete="off"
                                                            class="form-control my-1" required="">
                                                    </div>
                                                @endif --}}

                                                    @if ((Auth::id() == $user->id && Myhelper::can('profile_edit')) || Myhelper::can('member_profile_edit'))
                                                        <div class="col-sm-12">
                                                            <button class="btn btn-primary float-end mt-2" type="submit"
                                                                data-loading-text="<i class='fa fa-spin fa-spinner'></i> Updating...">Update
                                                                Profile</button>
                                                        </div>
                                                    @endif
                                                </div>
                                            </form>
                                        </div>

                                        <div class="tab-pane fade " id="navs-justified-password" role="tabpanel">
                                            <form id="passwordForm" action="{{ route('profileUpdate') }}" method="post"
                                                enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="id" value="{{ $user->id }}">
                                                <input type="hidden" name="actiontype" value="password">
                                                <div class="panel panel-default">

                                                    <div class="panel-body p-b-0">
                                                        <div class="row">
                                                            @if (Auth::id() == $user->id || (Myhelper::hasNotRole('admin') && !Myhelper::can('member_password_reset')))
                                                                <div class="form-group col-md-4 my-1">
                                                                    <label>Old Password</label>
                                                                    <input type="password" name="oldpassword"
                                                                        class="form-control my-1" required=""
                                                                        placeholder="Enter Value">
                                                                </div>
                                                            @endif

                                                            <div class="form-group col-md-4 my-1">
                                                                <label>New Password</label>
                                                                <input type="password" name="password" id="password"
                                                                    class="form-control my-1" required=""
                                                                    placeholder="Enter Value">
                                                            </div>

                                                            @if (Auth::id() == $user->id || (Myhelper::hasNotRole('admin') && !Myhelper::can('member_password_reset')))
                                                                <div class="form-group col-md-4 my-1">
                                                                    <label>Confirmed Password</label>
                                                                    <input type="password" name="password_confirmation"
                                                                        class="form-control my-1" required=""
                                                                        placeholder="Enter Value">
                                                                </div>
                                                            @endif
                                                            {{-- @if (Myhelper::hasRole('admin'))
                                                            <div class="form-group col-md-4 my-1">
                                                                <label>Security PIN</label>
                                                                <input type="password" name="mpin" autocomplete="off"
                                                                    class="form-control my-1" required="">
                                                            </div> 
                                                        @endif --}}
                                                            <div class="col-sm-12">
                                                                <button class="btn btn-primary mt-2 float-end"
                                                                    type="submit"
                                                                    data-loading-text="<i class='fa fa-spin fa-spinner'></i> Resetting...">Password
                                                                    Reset</button>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>


                                        @if (Auth::user()->role_id == 3)
                                            <div class="tab-pane fade " id="navs-justified-salary" role="tabpanel">
                                                <table width="100%" class="table border-top mb-5" id="datatable"
                                                    role="grid" aria-describedby="user-list-page-info">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th width="20%">Id</th>
                                                            <th width="20%">User Details</th>
                                                            <th width="20%">Salary Details</th>
                                                            <th width="20%">Extra details</th>
                                                            <th width="20%">Joining Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($salaryDet as $salary)
                                                            <tr>
                                                                <td>{{ $salary->emp_id }} <br /> {{ $salary->created_at }}
                                                                </td>
                                                                <td>{{ $user->name }} <br /> {{ $user->email }}</td>
                                                                <td>
                                                                    Basic Salary - ₹{{ $salary->basic_salary }} <br />
                                                                    Gross Salary - ₹{{ $salary->gross_salary }} <br />
                                                                    Net Salary - ₹{{ $salary->net_salary }}
                                                                </td>
                                                                <td>
                                                                    CTC - ₹{{ $salary->ctc }} <br />
                                                                    HRA - ₹{{ $salary->hra }} <br />
                                                                    DA - ₹{{ $salary->da }} <br />
                                                                    PF - ₹{{ $salary->pf }}
                                                                </td>
                                                                <td>{{ $salary->joining }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection


@push('script')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2();
            $('[name="state"]').val('{{ $user->state }}').trigger('change');
            $('[name="gender"]').val('{{ $user->gender }}').trigger('change');
            @if (\Myhelper::hasRole('admin'))
                $('[name="parent_id"]').val('{{ $user->parent_id }}').trigger('change');
                $('[name="role_id"]').val('{{ $user->role_id }}').trigger('change');
            @endif
            // $('[href="#{{ $tab }}"]').trigger('click');
            $("#profileForm").validate({
                rules: {
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
                    }
                },
                messages: {
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
                        minlength: "Your mobile number must be 6 digit",
                        maxlength: "Your mobile number must be 6 digit"
                    },
                    address: {
                        required: "Please enter address",
                    }
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    if (element.prop("tagName").toLowerCase().toLowerCase() === "select") {
                        error.insertAfter(element.closest(".form-group").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var form = $('form#profileForm');
                    form.find('span.text-danger').remove();
                    $('form#profileForm').ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('Please wait...').attr(
                                'disabled', true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button:submit').html('Update Profile').attr(
                                'disabled', false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                notify("Profile Successfully Updated", 'success');
                                window.location.reload();
                            } else {
                                notify(data.status, 'warning');
                            }
                        },
                        error: function(errors) {
                            showError(errors, form.find('.panel-body'));
                        }
                    });
                }
            });

            $("#kycForm").validate({
                rules: {
                    aadharcard: {
                        required: true,
                        minlength: 12,
                        number: true,
                        maxlength: 12
                    },
                    pancard: {
                        required: true,
                    },
                    shopname: {
                        required: true,
                    }
                },
                messages: {
                    aadharcard: {
                        required: "Please enter aadharcard",
                        number: "Mobile number should be numeric",
                        minlength: "Your mobile number must be 12 digit",
                        maxlength: "Your mobile number must be 12 digit"
                    },
                    pancard: {
                        required: "Please enter pancard",
                    },
                    shopname: {
                        required: "Please enter shop name",
                    }
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    if (element.prop("tagName").toLowerCase().toLowerCase() === "select") {
                        error.insertAfter(element.closest(".form-group").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var form = $('form#kycForm');
                    form.find('span.text-danger').remove();
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('Please wait...').attr(
                                'disabled', true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button:submit').html('Update Profile').attr(
                                'disabled', false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                notify("Profile Successfully Updated", 'success');
                                window.location.reload();
                            } else {
                                notify(data.status, 'warning');
                            }
                        },
                        error: function(errors) {
                            showError(errors, form.find('.panel-body'));
                            form.find('button:submit').html('Update Profile').attr(
                                'disabled', false).removeClass('btn-secondary');

                        }
                    });
                }
            });

            $("#passwordForm").validate({
                rules: {
                    @if (Auth::id() == $user->id || (Myhelper::hasNotRole('admin') && !Myhelper::can('member_password_reset')))
                        oldpassword: {
                            required: true,
                        },
                        password_confirmation: {
                            required: true,
                            minlength: 8,
                            equalTo: "#password"
                        },
                    @endif
                    password: {
                        required: true,
                        minlength: 8,
                    }
                },
                messages: {
                    @if (Auth::id() == $user->id || (Myhelper::hasNotRole('admin') && !Myhelper::can('member_password_reset')))
                        oldpassword: {
                            required: "Please enter old password",
                        },
                        password_confirmation: {
                            required: "Please enter confirmed password",
                            minlength: "Your password lenght should be atleast 8 character",
                            equalTo: "New password and confirmed password should be equal"
                        },
                    @endif
                    password: {
                        required: "Please enter new password",
                        minlength: "Your password lenght should be atleast 8 character",
                    }
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    if (element.prop("tagName").toLowerCase().toLowerCase() === "select") {
                        error.insertAfter(element.closest(".form-group").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var form = $('form#passwordForm');
                    form.find('span.text-danger').remove();
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('Please wait...').attr(
                                'disabled', true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button:submit').html('Password Reset').attr(
                                'disabled', false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                notify("Password Successfully Changed", 'success');
                                window.location.reload();
                            } else {
                                notify(data.status, 'warning');
                            }
                        },
                        error: function(errors) {
                            showError(errors, form.find('.panel-body'));
                        }
                    });
                }
            });

            $("#memberForm").validate({
                rules: {
                    parent_id: {
                        required: true
                    }
                },
                messages: {
                    parent_id: {
                        required: "Please select parent member"
                    }
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    if (element.prop("tagName").toLowerCase().toLowerCase() === "select") {
                        error.insertAfter(element.closest(".form-group").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var form = $('form#memberForm');
                    form.find('span.text-danger').remove();
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('Please wait...').attr(
                                'disabled', true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button:submit').html('Change').attr('disabled',
                                false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                notify("Mapping Successfully Changed", 'success');
                                window.location.reload();
                            } else {
                                notify(data.status, 'warning');
                            }
                        },
                        error: function(errors) {
                            showError(errors);
                        }
                    });
                }
            });

            $("#certificateForm").validate({
                rules: {
                    coo: {
                        required: true
                    },
                    cmo: {
                        required: true
                    }
                },
                messages: {
                    coo: {
                        required: "Please enter COO name"
                    },
                    cmo: {
                        required: "Please enter CMO name"
                    }

                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    if (element.prop("tagName").toLowerCase().toLowerCase() === "select") {
                        error.insertAfter(element.closest(".form-group").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var form = $('form#certificateForm');
                    form.find('span.text-danger').remove();
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('Please wait...').attr(
                                'disabled', true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button:submit').html('Change').attr('disabled',
                                false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                notify("Mapping Successfully Changed", 'success');
                                window.location.reload();
                            } else {
                                notify(data.status, 'warning');
                            }
                        },
                        error: function(errors) {
                            showError(errors);
                        }
                    });
                }
            });






            $("#roleForm").validate({
                rules: {
                    role_id: {
                        required: true
                    }
                },
                messages: {
                    role_id: {
                        required: "Please select member role"
                    }
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    if (element.prop("tagName").toLowerCase().toLowerCase() === "select") {
                        error.insertAfter(element.closest(".form-group").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var form = $('form#roleForm');
                    form.find('span.text-danger').remove();
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('Please wait...').attr(
                                'disabled', true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button:submit').html('Change').attr('disabled',
                                false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                notify("Role Successfully Changed", 'success');
                                window.location.reload();
                            } else {
                                notify(data.status, 'warning');
                            }
                        },
                        error: function(errors) {
                            showError(errors);
                        }
                    });
                }
            });

            $("#bankForm").validate({
                rules: {
                    account: {
                        required: true
                    },
                    bank: {
                        required: true
                    },
                    ifsc: {
                        required: true
                    }
                },
                messages: {
                    account: {
                        required: "Please enter member account"
                    },
                    bank: {
                        required: "Please enter member bank"
                    },
                    ifsc: {
                        required: "Please enter bank ifsc"
                    }
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    if (element.prop("tagName").toLowerCase().toLowerCase() === "select") {
                        error.insertAfter(element.closest(".form-group").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var form = $('form#bankForm');
                    form.find('span.text-danger').remove();
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('Please wait...').attr(
                                'disabled', true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button:submit').html('Submit').attr('disabled',
                                false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                notify("Bank Details Successfully Changed", 'success');
                                window.location.reload();
                            } else {
                                notify(data.status, 'warning');
                            }
                        },
                        error: function(errors) {
                            showError(errors, form.find('.panel-body'));
                        }
                    });
                }
            });

            $("#pinForm").validate({
                rules: {
                    oldpin: {
                        required: true,
                    },
                    pin_confirmation: {
                        required: true,
                        minlength: 4,
                        equalTo: "#pin"
                    },
                    pin: {
                        required: true,
                        minlength: 4,
                    }
                },
                messages: {
                    oldpin: {
                        required: "Please enter old pin",
                    },
                    pin_confirmation: {
                        required: "Please enter confirmed pin",
                        minlength: "Your pin lenght should be atleast 4 character",
                        equalTo: "New pin and confirmed pin should be equal"
                    },
                    pin: {
                        required: "Please enter new pin",
                        minlength: "Your pin lenght should be atleast 4 character",
                    }
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    if (element.prop("tagName").toLowerCase().toLowerCase() === "select") {
                        error.insertAfter(element.closest(".form-group").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var form = $('form#pinForm');
                    form.find('span.text-danger').remove();
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('Please wait...').attr(
                                'disabled', true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button:submit').html('Reset Pin').attr('disabled',
                                false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                form[0].reset();
                                notify("Pin Successfully Changed", 'success');
                                window.location.reload();
                            } else {
                                notify(data.status, 'warning');
                            }
                        },
                        error: function(errors) {
                            // showError(errors, form.find('.panel-body'));
                            form.find('button:submit').html('Reset Pin').attr('disabled',
                                false).removeClass('btn-secondary');
                            console.log(errors.responseJSON.status);
                            notify(errors.responseJSON[0] || errors.responseJSON.status ||
                                "Something went wrong", 'error');
                        }
                    });
                }
            });
        });

        function OTPRESEND() {
            var mobile = "{{ Auth::user()->mobile }}";
            if (mobile.length > 0) {
                $.ajax({
                        url: '{{ route('getotp') }}',
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            'mobile': mobile
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
                        if (data.status == "TXN") {
                            notify("Otp sent successfully", 'success');
                        } else {
                            notify(data.message, 'warning');
                        }
                    })
                    .fail(function() {
                        notify("Something went wrong, try again", 'warning');
                    });
            } else {
                notify("Enter your registered mobile number", 'warning');
            }
        }
    </script>
@endpush
