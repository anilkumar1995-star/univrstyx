@extends('layouts.app_new')
@section('title', 'Header')
@section('pagetitle', 'Header')

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
                                <a href="{{ route('header') }}" data-bs-toggle="tooltip" data-bs-placement="top"
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

                                    @if (\Myhelper::hasRole('admin') && !$existsheader)
                                        <a href="javascript:void(0)" class="btn btn-primary ms-2" data-bs-toggle="modal"
                                            data-bs-target="#addHeaderModal">
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
                                        <th> Header 1</th>
                                        <th> Header 2</th>
                                        <th> Header 3</th>
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
        <div class="modal fade" id="addHeaderModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Instructors Details </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form id="AddHeaderForm" enctype="multipart/form-data" action="{{ route('addHeader') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                        <input type="hidden" name="id">

                        <div class="modal-body">
                            <div class="row g-3"> 
                                <div class="col-md-6">
                                    <label class="form-label">Header Image</label>
                                    <input type="file" name="header_image" id="header_image" placeholder="Enter Header Heading 1" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Header Heading 1</label>
                                    <input type="text" name="header_1" id="header" placeholder="Enter Header Heading 1" class="form-control">
                                </div>
                                 <div class="col-md-6">
                                    <label class="form-label">Header Heading 2</label>
                                    <input type="text" name="header_2" id="header_2" placeholder="Enter Heading 2" class="form-control">
                                </div>
                                 <div class="col-md-6">
                                    <label class="form-label">Header Heading 3</label>
                                    <input type="text" name="header_3" id="header_3" placeholder="Enter Heading 3" class="form-control">
                                </div>
                                 <div class="col-md-6">
                                    <label class="form-label">Footer Image</label>
                                    <input type="file" name="footer_image" id="footer_image" placeholder="Enter Footer Image" class="form-control">
                                </div>
                                
                                 <div class="col-md-6">
                                    <label class="form-label">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
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
      $("#AddHeaderForm").validate({
            submitHandler: function() {
                var form = $('form#AddHeaderForm');
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
                            location.reload();
                         $('#datatable').DataTable().ajax.reload(null, false);
                            notify(data.message, 'success');
                            $('#addHeaderModal').modal('hide');
                        } else {
                            notify(data.message, 'error');
                        }
                    },
                    error: function(errors) {
                        form.find('button:submit').html('Submit').attr(
                            'disabled',
                            false).removeClass('btn-secondary');
                        notify(errors?.responseJSON?.message ||
                            "Something went wrong",
                            'error');
                    }
                });
            }
        });
         function editDetails(id, header_1, header_2,header_3,status) {

            $('#AddHeaderForm').find('[name="id"]').val(id);
            $('#AddHeaderForm').find('[name="header_1"]').val(header_1);
            $('#AddHeaderForm').find('[name="header_2"]').val(header_2);
            $('#AddHeaderForm').find('[name="header_3"]').val(header_3);
            $('#AddHeaderForm').find('[name="status"]').val(status);

            $('#addHeaderModal').modal('show');
        }
        $(document).ready(function() {
           var url = "{{ url('statement/fetch') }}/header/0";

            var onDraw = function() {

            };

            var options = [{
                    "data": "id",
                    render: function(data, type, full, meta) {
                        return `<span>###${meta.row+1}<br/>${full?.created_at}</span>`;
                    }
                },
                {
                    "data": "header_1"
                },
                 {
                    "data": "header_2"
                },
                {
                    "data": "header_3"
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
                      return `<button type="button" class="btn btn-primary" onclick="editDetails('${full.id}', '${full.header_1}', '${full.header_2}', '${full.header_3}', '${full.status}')"> Edit</button>`;
                    }
                }
            ];
            datatableSetup(url, options, onDraw);

        });
   </script>
@endpush
