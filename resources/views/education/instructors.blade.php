@extends('layouts.app_new')
@section('title', 'instructor')
@section('pagetitle', 'instructor')

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
                                <a href="{{ route('instructor') }}" data-bs-toggle="tooltip" data-bs-placement="top"
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

                                    @if (\Myhelper::hasRole('admin'))
                                        <a href="javascript:void(0)" class="btn btn-primary ms-2" data-bs-toggle="modal"
                                            data-bs-target="#addInstructorModal">
                                            <i class="ti ti-square-rounded-plus ti-sm"></i>Add 
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        @include('layouts.pageheader')
                        <!-- /Filter -->
                        <div class="table-responsive custom-table">
                            <table class="table" id="datatable">
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th> Name</th>
                                        <th> Designation</th>
                                        <th> Working At</th>
                                        <th> Description</th>
                                        <th> Linkein Url</th>
                                        <th> Working at Logo</th>
                                        <th> Profile Image</th>
                                        <th> Status</th>
                                        <th> Action</th>
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

        <!-- Add/Edit Hiring Partner Modal -->
        <div class="modal fade" id="addInstructorModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Instructors Details </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form id="AddInstructorForm" enctype="multipart/form-data" action="{{ route('addInstructor') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                        <input type="hidden" name="id">

                        <div class="modal-body">
                            <div class="row g-3"> 
                                <div class="col-md-6">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" id="Name" placeholder="Enter Name" class="form-control">
                                </div>
                                 <div class="col-md-6">
                                    <label class="form-label">Designation</label>
                                    <input type="text" name="designation" id="designation" placeholder="Enter designation" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Working At</label>
                                    <input type="text" name="working_at" id="working_at" placeholder="Enter Working At" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Working logo</label>
                                    <input type="file" name="working_logo" id="working_logo" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Profile Image</label>
                                    <input type="file" name="profile_image" id="profile_image" class="form-control">
                                </div>
                                
                                 <div class="col-md-6">
                                    <label class="form-label">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Linkedin Url</label>
                                    <input type="text" name="linkedin_url" id="linkedin_url" placeholder="Enter LinkedIn url" class="form-control">
                                </div>
                                 <div class="col-md-12">
                                    <label class="form-label">Description</label>
                                   <textarea name="description" id="description" class="form-control" placeholder="Enter Description"></textarea>  
                                 </div>
                                
                               
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-primary" type="submit"
                                data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">
                                Submit
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>


@endsection

@push('style')
    <style>
     
    </style>
@endpush

@push('script')
   <script type="text/javascript">
      $("#AddInstructorForm").validate({
            submitHandler: function() {
                var form = $('form#AddInstructorForm');
                form.ajaxSubmit({
                    dataType: 'json',
                    beforeSubmit: function() {
                        form.find('button:submit').html('Please wait...').attr(
                            'disabled', true).addClass('btn-secondary');
                    },
                    success: function(data) {
                        form.find('button:submit').html('Submit Details').attr(
                            'disabled', false).removeClass('btn-secondary');
                        if (data.status === "success") {
                            form[0].reset();
                         $('#datatable').DataTable().ajax.reload(null, false);
                            notify(data.message, 'success');
                            $('#addInstructorModal').modal('hide');
                        } else {
                            notify(data.message, 'error');
                        }
                    },
                    error: function(errors) {
                        form.find('button:submit').html('Submit Details').attr(
                            'disabled',
                            false).removeClass('btn-secondary');
                        notify(errors?.responseJSON?.message ||
                            "Something went wrong",
                            'error');
                    }
                });
            }
        });
         function editDetails(id, name, linkedin_url, designation, status, working_at,description,) {

            $('#AddInstructorForm').find('[name="id"]').val(id);
            $('#AddInstructorForm').find('[name="name"]').val(name);
            $('#AddInstructorForm').find('[name="linkedin_url"]').val(linkedin_url);
            $('#AddInstructorForm').find('[name="designation"]').val(designation);
            $('#AddInstructorForm').find('[name="status"]').val(status);
            $('#AddInstructorForm').find('[name="working_at"]').val(working_at);
            $('#AddInstructorForm').find('[name="description"]').val(description);

            $('#addInstructorModal').modal('show');
        }
        $(document).ready(function() {
           var url = "{{ url('statement/fetch') }}/instructors/0";

            var onDraw = function() {

            };

            var options = [{
                    "data": "id",
                    render: function(data, type, full, meta) {
                        return `<span>###${meta.row+1}<br/>${full?.created_at}</span>`;
                    }
                },
                {
                    "data": "name"
                },
                 {
                    "data": "designation"
                },
                 {
                    "data": "working_at"
                },
                 {
                    "data": "description"
                },
                  {
                    "data": "linkedin_url"
                },
                {
                    "data": "working_logo",
                    render: function(data, type, full) {
                        if (data && data !== 'null') {
                            return `<a href="#">
                                    <img src="https://images.incomeowl.in/incomeowl/crm/images/${data}" 
                                        style="width:80px; height:80px; object-fit:contain; border:1px solid #ccc;"/>
                                </a>`;
                        } else {
                            return `<a href="#">
                                    <img src="{{ asset('img/noimg.png') }}" 
                                        style="width:50px; height:50px; object-fit:contain; border:1px solid #ccc;"/>
                                </a>`;
                        }
                    }
                },
                 {
                    "data": "profile_image",
                    render: function(data, type, full) {
                        if (data && data !== 'null') {
                            return `<a href="#">
                                    <img src="https://images.incomeowl.in/incomeowl/crm/images/${data}" 
                                        style="width:80px; height:80px; object-fit:contain; border:1px solid #ccc;"/>
                                </a>`;
                        } else {
                            return `<a href="#">
                                    <img src="{{ asset('img/noimg.png') }}" 
                                        style="width:50px; height:50px; object-fit:contain; border:1px solid #ccc;"/>
                                </a>`;
                        }
                    }
                },
                {
                    "data": "status",
                    render: function(data, type, full, meta) {
                        if (full.status == 'inactive') {
                            return `<span class="badge badge-danger">Inactive</span>`;
                        } else {
                            return `<span class="badge badge-success">Active</span>`;
                        }

                    }
                },
                {
                    "data": "action",
                    render: function(data, type, full, meta) {
                        return `<button type="button" class="btn btn-primary" onclick="editDetails('${full.id}','${full.name}', '${full.linkedin_url}','${full.designation}', '${full.status}', '${full.working_at}', '${full.description}')"> Edit</button>`;
                    }
                }
            ];
            datatableSetup(url, options, onDraw);

        });
   </script>
@endpush
