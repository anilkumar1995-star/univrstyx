@extends('layouts.app_new')
@section('title', 'Slider')
@section('pagetitle', 'Slider')

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
                            <a href="{{ route('slider') }}" data-bs-toggle="tooltip" data-bs-placement="top"
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

                                @if (\Myhelper::hasRole('admin') && !$existslider)
                                <a href="javascript:void(0)" class="btn btn-primary ms-2" data-bs-toggle="modal"
                                    data-bs-target="#addSliderModal">
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
                                    <th> Title</th>
                                    <th> Subtitle</th>
                                    <th> Back Side Image</th>
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
    <div class="modal fade" id="addSliderModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Slider Heading Details </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="AddSliderForm" enctype="multipart/form-data" action="{{ route('addSlider') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    <input type="hidden" name="id">

                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Content Title</label>
                                <input type="text" name="title" id="title" placeholder="Enter Title" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Content Subtitle</label>
                                <input type="text" name="subtitle" id="subtitle" placeholder="Enter Subtitle" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Join Community</label>
                                <input type="text" name="join_community" id="join_community" placeholder="Enter Join Community" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Slider Image Back Side</label>
                                <input type="file" name="back_side_img" id="back_side_img" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Slider Images (Front Side)</label>
                                <input type="file" name="front_side_img[]" id="front_side_img" class="form-control" multiple>
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
    $("#AddSliderForm").validate({
        submitHandler: function() {
            var form = $('form#AddSliderForm');
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
                        $('#addSliderModal').modal('hide');
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

    function editDetails(id, title, subtitle, join_community, status) {

        $('#AddSliderForm').find('[name="id"]').val(id);
        $('#AddSliderForm').find('[name="title"]').val(title);
        $('#AddSliderForm').find('[name="subtitle"]').val(subtitle);
        $('#AddSliderForm').find('[name="join_community"]').val(join_community);
        $('#AddSliderForm').find('[name="status"]').val(status);

        $('#addSliderModal').modal('show');
    }
    $(document).ready(function() {
        var url = "{{ url('statement/fetch') }}/slider/0";

        var onDraw = function() {

        };

        var options = [{
                "data": "id",
                render: function(data, type, full, meta) {
                    return `<span>###${meta.row+1}<br/>${full?.created_at}</span>`;
                }
            },
            {
                "data": "title"
            },
            {
                "data": "subtitle"
            },

            {
                "data": "back_img",
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
                    return `<button type="button" class="btn btn-primary" onclick="editDetails('${full.id}', '${full.title.replace(/'/g, "\\'")}', '${full.subtitle.replace(/'/g, "\\'")}','${full.join_community.replace(/'/g, "\\'")}', '${full.status}')"> Edit</button>`;
                }
            }
        ];
        datatableSetup(url, options, onDraw);

    });
</script>
@endpush