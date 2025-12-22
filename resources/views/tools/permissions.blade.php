@extends('layouts.app_new')
@section('title', 'Permissions')
@section('pagetitle', 'Permissions List')
@php
    $table = 'yes';
@endphp

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12 col-xl-12 col-sm-12 order-1 order-lg-2 mb-4 mb-lg-0">
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <h4 class="page-title">@yield('pagetitle')<span class="count-title">All</span></h4>
                        </div>
                        <div class="col-8 text-end">
                            <div class="head-icons">
                                <a href="{{ route('tools', ['type' => 'permissions']) }}" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-original-title="Refresh">
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
                                    <button type="button" class="btn btn-success text-white ms-2" onclick="addrole()">
                                        <i class="ti ti-square-rounded-plus ti-sm"></i> Add New</button>
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
                                        <th class="sorting"> Name</th>
                                        <th class="sorting">Display Name</th>
                                        <th class="sorting">Type</th>
                                        <th class="sorting">Last Updated</th>
                                        <th>Action</th>
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

    <div class="offcanvas offcanvas-end" id="permissionModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="offcanvas-header bg-primary">
            <div class="text-center">
                <h4 class="text-white">Add Permission</h4>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <form id="permissionManager" action="{{ route('toolsstore', ['type' => 'permission']) }}" method="post">
            <div class="offcanvas-body">
                <div class="row">
                    <input type="hidden" name="id">
                    <input type="hidden" name="actiontype" value="bank">
                    {{ csrf_field() }}
                    <div class="form-group col-md-6 my-1">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control my-1" placeholder="Enter Permission Name"
                            required="">
                    </div>
                    <div class="form-group col-md-6 my-1">
                        <label>Display Name</label>
                        <input type="text" name="slug" class="form-control my-1" placeholder="Enter Display Name"
                            required="">
                    </div>
                    <div class="form-group col-md-12 my-1">
                        <label>Type</label>
                        <input type="text" name="type" class="form-control my-1" placeholder="Enter Permission Type"
                            required="">
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="submit"
                    data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit</button>
            </div>
        </form>

    </div>

@endsection

@push('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var url = "{{ url('statement/fetch/permissions/0') }}";
            var onDraw = function() {};
            var options = [{
                    "data": "id",
                    render: function(data, type, full, meta) {
                        return `<span>###${full?.id}<br/>${full?.created_at}</span>`;
                    }
                },
                {
                    "data": "name"
                },
                {
                    "data": "slug"
                },
                {
                    "data": "type"
                },
                {
                    "data": "updated_at"
                },
                {
                    "data": "action",
                    render: function(data, type, full, meta) {
                        return `<button type="button" class="btn btn-info" title="Edit" onclick="editRole(this)"> <i class="ti ti-edit"></i></button>`;
                    }
                },
            ];
            datatableSetup(url, options, onDraw);

            $("#permissionManager").validate({
                rules: {
                    slug: {
                        required: true,
                    },
                    name: {
                        required: true,
                    },
                },
                messages: {
                    mobile: {
                        required: "Please enter role slug",
                    },
                    name: {
                        required: "Please enter role name",
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
                    var form = $('#permissionManager');
                    var id = $('#permissionManager').find("[name='id']").val();
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button[type="submit"]').html('Please wait...').attr(
                                'disabled', true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button[type="submit"]').html('Submit').attr(
                                'disabled', false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                if (id == "new") {
                                    form[0].reset();
                                }
                                notify("Task Successfully Completed", 'success');
                                form.closest('.offcanvas').offcanvas('hide');
                                $('#datatable').dataTable().api().ajax.reload();
                            } else {
                                notify(data.status, 'warning');
                            }
                        },
                        error: function(errors) {
                            showError(errors, form);
                        }
                    });
                }
            });

            $("#permissionModal").on('hidden.bs.offcanvas', function() {
                $('#permissionModal').find('.msg').text("Add");
                $('#permissionModal').find('form')[0].reset();
            });
        });

        function addrole() {
            $('#permissionModal').find('.msg').text("Add");
            $('#permissionModal').find('input[name="id"]').val("new");
            $('#permissionModal').offcanvas('show');
        }

        function editRole(ele) {         
            var id = $(ele).closest('tr').find('td').eq(0).text();
            var name = $(ele).closest('tr').find('td').eq(1).text();
            var slug = $(ele).closest('tr').find('td').eq(2).text();
            var type = $(ele).closest('tr').find('td').eq(3).text();

            $('#permissionModal').find('.msg').text("Edit");
            $('#permissionModal').find('input[name="id"]').val(id);
            $('#permissionModal').find('input[name="name"]').val(name);
            $('#permissionModal').find('input[name="slug"]').val(slug);
            $('#permissionModal').find('input[name="type"]').val(type);
            $('#permissionModal').offcanvas('show');
        }
    </script>
@endpush
