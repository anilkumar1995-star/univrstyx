@extends('layouts.app_new')
@section('title', 'Award')
@section('pagetitle', 'Award')

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
                            <a href="{{ route('awardView') }}" data-bs-toggle="tooltip" data-bs-placement="top"
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
                                    data-bs-target="#addAwardModal">
                                    <i class="ti ti-square-rounded-plus ti-sm"></i>Add Award
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
                                    <th width="20%">#</th>
                                    <th width="20%">Award Title</th>
                                    <th width="20%">Award Heading</th>
                                    <th width="20%">Award Description</th>
                                    <th width="20%">Award Image</th>
                                    <th width="20%">Status</th>
                                    <th width="20%">Action</th>
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
    <div class="modal fade" id="addAwardModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Award Company Details </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="AddAwardForm" enctype="multipart/form-data" action="{{ route('addAward') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    <input type="hidden" name="id">

                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Award Title</label>
                                <input type="text" name="award_title" id="awardTitle" required placeholder="Enter Award Title" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Award Heading</label>
                                <input type="text" name="award_heading" id="awardHeading" required placeholder="Enter Award Heading" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Award Description</label>
                                <input type="text" name="award_description" required id="awardDescription" placeholder="Enter Award Description" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Award Image</label>
                                <input type="file" name="award_image" id="awardImage" class="form-control">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Status</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="">--Select--</option>
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
    $("#AddAwardForm").validate({
        submitHandler: function() {
            var form = $('form#AddAwardForm');
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
                        $('#addAwardModal').modal('hide');
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
    $(document).on('click', '.editAwardBtn', function() {
        const id = $(this).data('id');
        const award_title = decodeURIComponent($(this).data('title'));
        const award_heading = decodeURIComponent($(this).data('heading'));
        const award_description = decodeURIComponent($(this).data('description'));
        const status = decodeURIComponent($(this).data('status'));

        $('#AddAwardForm').find('[name="id"]').val(id);
        $('#AddAwardForm').find('[name="award_title"]').val(award_title);
        $('#AddAwardForm').find('[name="award_heading"]').val(award_heading);
        $('#AddAwardForm').find('[name="award_description"]').val(award_description);
        $('#AddAwardForm').find('[name="status"]').val(status);

        $('#addAwardModal').modal('show');
    });

    $(document).ready(function() {
        var url = "{{ url('statement/fetch') }}/award/0";

        var onDraw = function() {

        };

        var options = [{
                "data": "id",
                render: function(data, type, full, meta) {
                    return `<span>###${meta.row+1}<br/>${full?.created_at}</span>`;
                }
            },
            {
                "data": "award_title"
            },
            {
                "data": "award_heading"
            },
            {
                "data": "award_description"
            },
            {
                "data": "award_image",
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
                    return `
            <button 
                type="button" 
                class="btn btn-primary editAwardBtn"
                data-id="${full.id}"
                data-title="${encodeURIComponent(full.award_title)}"
                data-heading="${encodeURIComponent(full.award_heading)}"
                data-description="${encodeURIComponent(full.award_description)}"
                data-status="${encodeURIComponent(full.status)}"
            >
                Edit
            </button>
        `;
                }
            }


        ];
        datatableSetup(url, options, onDraw);

    });
</script>
@endpush