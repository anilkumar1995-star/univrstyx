@extends('layouts.app_new')
@section('title', 'Announcements')
@section('pagetitle', 'Announcements')

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
                            <a href="{{ route('Notification') }}" data-bs-toggle="tooltip" data-bs-placement="top"
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

                                @if (\Myhelper::hasRole('admin') && !$existsnotice)
                                <a href="javascript:void(0)" class="btn btn-primary ms-2" data-bs-toggle="modal"
                                    data-bs-target="#addNoticeModal">
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
                                    <th> Header Heading</th>
                                    <th> Heading 2</th>
                                    <th> Description</th>
                                    <th> Button text</th>
                                    <th> Footer Content</th>
                                    <th> Image</th>
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

    <!-- Add/Edit Announcements Modal -->
    <div class="modal fade" id="addNoticeModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">

                <div class="modal-header bg-purple opacity-75 rounded-top-4">
                    <h5 class="modal-title text-white fw-semibold">
                        📢 Announcement Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <form id="AddNoticeForm" enctype="multipart/form-data"
                    action="{{ route('addNotification') }}" method="post">
                    @csrf

                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    <input type="hidden" name="id">

                    <div class="modal-body p-4">
                        <div class="mb-4">

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Header Heading </label>
                                    <input type="text" name="header_1" class="form-control"
                                        placeholder="Enter Header heading">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Image</label>
                                    <input type="file" name="notice_image" id="notice_image" class="form-control">
                                    <small class="text-muted">PNG / JPG (354*100)</small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Heading</label>
                                    <input type="text" name="heading_2" class="form-control"
                                        placeholder="Main heading">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Description</label>
                                    <input type="text" name="description" class="form-control"
                                        placeholder="Enter Description">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Button Text</label>
                                    <input type="text" name="btn_text" class="form-control"
                                        placeholder="Enter Button Text">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Footer Content</label>
                                    <input type="text" name="footer_content" class="form-control"
                                        placeholder="Enter Footer Content">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="active"> Active</option>
                                        <option value="inactive"> Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="modal-footer bg-light rounded-bottom-4">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button class="btn btn-primary px-4" type="submit">
                                <i class="ti ti-device-floppy me-1"></i> Submit
                            </button>
                        </div>

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
    $("#AddNoticeForm").validate({
        submitHandler: function() {
            var form = $('form#AddNoticeForm');
            form.ajaxSubmit({
                dataType: 'json',
                beforeSubmit: function() {
                    form.find('button:submit').html('Please wait...').attr(
                        'disabled', true).addClass('btn-secondary');
                },
                success: function(data) {
                    form.find('button:submit').html('Submit').attr(
                        'disabled', false).removeClass('btn-secondary');
                    if (data.status === "success") {
                        location.reload();
                        $('#datatable').DataTable().ajax.reload(null, false);
                        notify(data.message, 'success');
                        $('#addNoticeModal').modal('hide');
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

    function editDetails(id, header_1, heading_2, description, btn_text,footer_content,status) {

        $('#AddNoticeForm').find('[name="id"]').val(id);
        $('#AddNoticeForm').find('[name="header_1"]').val(header_1);
        $('#AddNoticeForm').find('[name="heading_2"]').val(heading_2);
        $('#AddNoticeForm').find('[name="description"]').val(description);
        $('#AddNoticeForm').find('[name="btn_text"]').val(btn_text);
        $('#AddNoticeForm').find('[name="footer_content"]').val(footer_content);
        $('#AddNoticeForm').find('[name="status"]').val(status);

        $('#addNoticeModal').modal('show');
    }
    $(document).ready(function() {
        var url = "{{ url('statement/fetch') }}/announcements/0";

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
                "data": "heading_2"
            },
             {
                "data": "description"
            },
            
            {
                "data": "btn_text"
            },
              {
                "data": "footer_content"
            },
            {
                "data": "notice_image",
                render: function(data, type, full) {
                    if (data && data !== 'null') {
                        return `<a href="#">
                                    <img src="https://images.incomeowl.in/incomeowl/crm/images/${data}" 
                                        style="width:150px; height:50px;"/>
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
                    return `<button type="button" class="btn btn-primary" onclick="editDetails('${full.id}', '${full.header_1}', '${full.heading_2}', '${full.description}', '${full.btn_text}', '${full.footer_content}', '${full.status}')"> Edit</button>`;
                }
            }
        ];
        datatableSetup(url, options, onDraw);

    });
</script>
@endpush