@extends('layouts.app_new')
@section('title', ucwords($type) . ' List')
@section('pagetitle', ucwords($type) . ' List')

@php
    $table = 'yes';
@endphp


@section('content')
    <div class="content">
        <div class="row">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-4">
                        <h4 class="page-title">@yield('pagetitle')<span class="count-title">All</span></h4>
                    </div>
                    <div class="col-8 text-end">
                        <div class="head-icons">
                            <a href="{{ route('member', ['type' => $type]) }}" data-bs-toggle="tooltip"
                                data-bs-placement="top" data-bs-original-title="Refresh">
                                <i class="ti ti-refresh-dot"></i>
                            </a>
                            <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Collapse" id="collapse-header" class="">
                                <i class="ti ti-chevrons-up"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-12 col-sm-12 order-1 order-lg-2 mb-4 mb-lg-0">

                <div class="card">
                    <div class="card-header">
                        <!-- Search -->
                        <div class="row align-items-center">

                            <div class="col-sm-12">
                                <div class="d-flex align-items-center flex-wrap row-gap-2 justify-content-sm-end">
                                    <div class="dropdown">
                                        <a href="javascript:void(0);" class="dropdown-toggle" data-bs-toggle="dropdown"><i
                                                class="ti ti-package-export me-2"></i>Export</a>
                                        <div class="dropdown-menu  dropdown-menu-end">
                                            <ul>
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item"><i
                                                            class="ti ti-file-type-pdf text-danger me-1"></i>Export
                                                        as PDF</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);" class="dropdown-item"><i
                                                            class="ti ti-file-type-xls text-green me-1"></i>Export
                                                        as Excel </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    @if ($role || sizeOf($roles) > 0)
                                        <div class="user-list-files d-flex float-end">
                                            @if (Request::is('member/all') || Request::is('member/support'))
                                                <a href="javascript:void(0)" type="button" class="btn btn-primary ms-2"
                                                    data-bs-toggle="offcanvas" data-bs-target="#addEmployeeCanvas">
                                                    <i class="ti ti-square-rounded-plus ti-sm"></i> Add New</a>
                                            @endif
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <!-- /Search -->
                    </div>

                    <div class="card-body">
                        <!-- Filter -->

                        @include('layouts.pageheader')
                        <!-- /Filter -->
                        <div class="table-responsive custom-table">
                            <table class="table" id="datatable">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="sorting">#</th>
                                        <th class="sorting">Name</th>
                                        <th class="sorting">Company Profile</th>
                                        <th class="sorting">Department Details</th>
                                        @if ($type == 'api')
                                            <th class="sorting">Code</th>
                                        @endif
                                        <th class="sorting">Action</th>
                                        <th class="sorting">Update Date</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="addEmployeeCanvas" data-bs-backdrop="static">
        <div class="offcanvas-header bg-primary">


            <h5 class="offcanvas-title  text-white">Add New Employee</h5>



            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form method="POST" class="memberForm" action="{{ route('memberstore') }}">
                @csrf

                @if ($type != 'api')
                    <input type="hidden" name="role_id" value="3">
                @else
                    <input type="hidden" name="role_id" value="2">
                    <input type="hidden" name="pretype" value="api">
                @endif
                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required maxlength="150">
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required maxlength="100">
                </div>

                <div class="mb-3">
                    <label>Mobile</label>
                    <input type="text" name="mobile" class="form-control" required maxlength="10">
                </div>


                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="active">Active</option>
                        <option value="pending">Pending</option>
                        <option value="block">Inactive</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Gender</label>
                    <select name="gender" class="form-control" required>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Address</label>
                    <textarea name="address" class="form-control" rows="2" maxlength="500"></textarea>
                </div>
                    <button type="submit" class="btn btn-primary w-100">Add Employee</button>
            </form>
        </div>
    </div>

    {{-- <div class="offcanvas offcanvas-end" tabindex="-1" id="assignTicketCanvas" data-bs-backdrop="static">
        <div class="offcanvas-header bg-primary">
            <h5 class="offcanvas-title  text-white">Assign Tickets</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form enctype="multipart/form-data" action="{{ route('assignticketstore') }}" method="POST"
                id="ticketForm">

                {{ csrf_field() }}


                <input type="hidden" name="user_id" value="{{ \Auth::id() }}">
                <input type="hidden" name="emp_id">
                <input type="hidden" name="email">
                <input type="hidden" name="name">
                <input type="hidden" name="department_name">
                <input type="hidden" name="partner_id">
                <div class="form-group mb-3">
                    <label for="ticket_select_1">Select Ticket:</label>
                    <select class="form-control" id="ticket_select_1" name="ticket_id">
                        <option value="">Select Ticket</option>
                        @foreach ($tickets as $tckt)
                            <option value="{{ $tckt->ticket_id }}" data-description="{{ $tckt->description }}">
                                {{ $tckt->ticket_id }} ({{ $tckt->subject }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="ticket_select_2">Ticket Details:</label>
                    <select class="form-control" id="ticket_select_2" name="ticket_id_readonly" disabled>
                        <option value="">Select Ticket</option>
                        @foreach ($tickets as $tckt)
                            <option value="{{ $tckt->ticket_id }}">{{ $tckt->priority }} ({{ $tckt->description }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <input type="hidden" name="description" id=" data-description" value="">

                <button class="btn btn-primary d-grid w-100 mb-3">Assign Ticket</button>


            </form>

        </div>
    </div> --}}
    @if (isset($permissions) && $permissions && Myhelper::can('member_permission_change'))

        <div class="modal" id="permissionModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Member Permission</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"></span>
                        </button>
                    </div>
                    <form id="permissionForm" action="{{ route('toolssetpermission') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="user_id">
                        <div class="modal-body p-0">
                            <div class="table-responsive">
                                <table id="datatable" class="table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="230px;">Section Category</th>
                                            <th>
                                                <span class="pull-left m-t-5 m-l-10">Permissions</span>
                                                <div class="md-checkbox pull-right">
                                                    <input type="checkbox" id="selectall">
                                                    <label for="selectall">Select All</label>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permissions as $key => $value)
                                            <tr>
                                                <td>
                                                    <div class="md-checkbox mymd">
                                                        <input type="checkbox" class="selectall"
                                                            id="{{ ucfirst($key) }}">
                                                        <label for="{{ ucfirst($key) }}">{{ ucfirst($key) }}</label>
                                                    </div>
                                                </td>
                                                <td class="row">
                                                    @foreach ($value as $permission)
                                                        <div class="md-checkbox  py-1 col-md-4 mymd">
                                                            <input type="checkbox" class="case"
                                                                id="{{ $permission->id }}" name="permissions[]"
                                                                value="{{ $permission->id }}">
                                                            <label
                                                                for="{{ $permission->id }}">{{ $permission->name }}</label>
                                                        </div>
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-raised legitRipple" data-bs-dismiss="modal"
                                aria-hidden="true">Close</button>
                            <button class="btn btn-primary" type="submit"
                                data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

@endsection

@push('style')
    <style>
        .md-checkbox {
            margin: 5px 0px;
        }

        .select2-container--default .select2-selection--single {
            height: 37px !important;
            padding: 3px 6px !important;
            border: 1px solid #d9d9d9 !important;
        }
    </style>
@endpush

@push('script')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript">
       
        $(document).ready(function() {
            $('.joinDate').datepicker({
                'autoclose': true,
                'clearBtn': true,
                'todayHighlight': true,
                'format': 'dd/mm/yyyy'
            });
            $('.select2').select2();
            // $('#ticket_id').select2();

            var url = "{{ url('statement/fetch') }}/{{ $type }}/0";
            var onDraw = function() {
                $('input.membarStatusHandler').on('click', function(evt) {
                    evt.stopPropagation();
                    var ele = $(this);
                    var id = $(this).val();
                    var status = "block";
                    if ($(this).prop('checked')) {
                        status = "active";
                    }

                    $.ajax({
                            url: `{{ route('profileUpdate') }}`,
                            type: 'post',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            dataType: 'json',
                            data: {
                                'id': id,
                                'status': status,
                                'actiontype': 'profile'
                            }
                        })
                        .done(function(data) {
                            if (data.status == "success") {
                                notify("Member Updated Successfully", 'success');
                                $('#datatable').dataTable().api().ajax.reload();
                            } else {
                                if (status == "active") {
                                    ele.prop('checked', false);
                                } else {
                                    ele.prop('checked', true);
                                }
                                notify("Something went wrong, Try again.", 'warning');
                            }
                        })
                        .fail(function(errors) {
                            if (status == "active") {
                                ele.prop('checked', false);
                            } else {
                                ele.prop('checked', true);
                            }
                            showError(errors, "withoutform");
                        });
                });
            };
           
                var options = [{
                        "data": "name",
                        'className': "notClick",
                        render: function(data, type, full, meta) {
                            var check = "";
                            var type = "";
                            if (full.status == "active") {
                                check = "checked='checked'";
                            }

                            return `<div class="form-check-size">
                                    <div class="form-check form-switch form-check-inline">
                                        <input type="checkbox" class="form-check-input custom-control-input membarStatusHandler" id="membarStatus_${full.id}" ${check} value="` +
                                full.id + `" actionType="` + type + `">
                                        <label class="custom-control-label" for="membarStatus_${full.id}"></label><br/>
                                       
                                    </div>
                                     <span><b>${full.agentcode}</b> </span>
                                </div>
                        <span style='font-size:13px'>${full.updated_at}</span>`;
                        }
                    },
                    {
                        "data": "name",
                        render: function(data, type, full, meta) {
                            return `<span class="name">Name - ${full.name}</span><br>Mobile - ${full.mobile}<br/>${full.email}`;
                        }
                    },

                    {
                        "data": "name",
                        render: function(data, type, full, meta) {
                            return `<span class="name">${full.company?.companyname}</span><br>${full.company?.website}`;
                        }
                    },
                    {
                        "data": "name",
                        render: function(data, type, full, meta) {

                            return `Role - ${full.role.name}`;
                        }
                    },
                    {
                        "data": "action",
                        render: function(data, type, full, meta) {
                            var out = '';
                            var menu = ``;

                            @if (Myhelper::can(['fund_transfer', 'fund_return']))
                                menu += `<li class="dropdown-header">Action</li>`;
                            @endif
                            @if (Myhelper::can('member_permission_change'))
                                menu +=
                                    `<a href="javascript:void(0)" class="dropdown-item" onclick="getPermission(${full.id})"><i class="icon-cogs"></i> Permission</a>`;
                            @endif



                            out += ` <div class="btn-group d-flex flex-wrap" role="group">
                                <button id="btnGroupDrop1" type="button" class="btn btn-primary btn-sm dropdown-toggle my-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action 
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                    ${menu}
                                </ul>
                            </div>
                            `;
                            return out;
                        }
                    },
                    {
                        "data": "id",
                        render: function(data, type, full, meta) {
                            return `<span>${full?.created_at}</span>`;
                        }
                    },
                ];
           

            datatableSetup(url, options, onDraw);

            $('form#permissionForm').submit(function() {
                var form = $(this);
                $(this).ajaxSubmit({
                    dataType: 'json',
                    beforeSubmit: function() {
                        form.find('button[type="submit"]').html('Please wait...').attr(
                            'disabled', true).addClass('btn-secondary');
                    },
                    complete: function() {
                        form.find('button[type="submit"]').html('Submit').attr('disabled',
                            false).removeClass('btn-secondary');
                    },
                    success: function(data) {
                        if (data.status == "success") {
                            notify('Permission Set Successfully', 'success');
                        } else {
                            notify('Transaction Failed', 'warning');
                        }
                    },
                    error: function(errors) {
                        showError(errors, form);
                    }
                });
                return false;
            });

            $('#selectall').click(function(event) {
                if (this.checked) {
                    $('.case').each(function() {
                        this.checked = true;
                    });
                    $('.selectall').each(function() {
                        this.checked = true;
                    });
                } else {
                    $('.case').each(function() {
                        this.checked = false;
                    });
                    $('.selectall').each(function() {
                        this.checked = false;
                    });
                }
            });

            $('.selectall').click(function(event) {
                if (this.checked) {
                    $(this).closest('tr').find('.case').each(function() {
                        this.checked = true;
                    });
                } else {
                    $(this).closest('tr').find('.case').each(function() {
                        this.checked = false;
                    });
                }
            });

         
            $(".memberForm").validate({
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
                    address: {
                        required: true,
                    },
                    gender: {
                        required: true,
                    },
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
                    address: {
                        required: "Please enter address",
                    },
                    gender: {
                        required: "Please select gender",
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
                    var form = $('form.memberForm');
                    $('form.memberForm').ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('Please wait...').attr(
                                'disabled', true).addClass('btn-secondary');
                        },
                        success: function(data) {
                            form.find('button:submit').html('Add Employe').attr(
                                'disabled',
                                false).removeClass('btn-secondary');
                            if (data.status == "success") {
                                form[0].reset();
                                $('#datatable').dataTable().api().ajax.reload();
                                notify("Member Successfully Created", 'success');
                                $('#addEmployeeCanvas').offcanvas('hide');
                            } else {
                                notify(data.status, 'warning');
                            }
                        },
                        error: function(errors) {
                            form.find('button:submit').html('Add Employe').attr(
                                'disabled',
                                false).removeClass('btn-secondary');
                            notify(errors?.responseJSON?.message ||
                                "Something went wrong",
                                'error');
                        }
                    });
                }
            });
           
        });


        function getPermission(id) {
            if (id.length != '') {
                $.ajax({
                    url: `{{ url('tools/get/permission') }}/` + id,
                    type: 'post',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        $('#permissionForm').find('[name="user_id"]').val(id);
                        $('.case').each(function() {
                            this.checked = false;
                        });
                        $.each(data, function(index, val) {
                            $('#permissionForm').find('input[value=' + val.permission_id + ']')
                                .prop(
                                    'checked', true);
                        });
                        $('#permissionModal').modal('show');
                    },
                    error: function(errors) {
                        notify(errors?.responseJSON?.message || "Something went wrong",
                            'error');
                    }

                });
            }
        }

    </script>
@endpush
