@extends('layouts.app_new')
@section('title', 'Homepage Settings')
@section('pagetitle', 'Homepage Settings')

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
                            <a href="{{ route('homepage.list') }}"><i class="ti ti-refresh-dot"></i></a>
                            <a href="javascript:void(0);" id="collapse-header"><i class="ti ti-chevrons-up"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-sm-12">
                            <div class="d-flex align-items-center justify-content-sm-end">
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
                                @if (\Myhelper::hasRole('admin') && !$settingExists)
                                <a href="javascript:void(0)" class="btn btn-primary ms-2"
                                    data-bs-toggle="modal"
                                    data-bs-target="#addSettingModal">
                                    <i class="ti ti-square-rounded-plus ti-sm"></i>Add
                                </a>
                                @endif


                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @include('layouts.pageheader')
                    <div class="table-responsive custom-table">
                        <table class="table" id="datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Trending</th>
                                    <th>Trending Subtitle</th>
                                    <th>Verticals</th>
                                    <th>Verticals Subtitle</th>
                                    <th>Free Courses</th>
                                    <th>Free Courses Subtitle</th>
                                    <th>Testimonials</th>
                                    <th>Testimonials Subtitle</th>
                                    <th>Awards</th>
                                    <th>Support</th>
                                    <th>Support Subtitle</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="addSettingModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Homepage Settings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form id="HomeSettingForm" action="{{ route('homepage.settings.save') }}" method="post">
                    @csrf
                    <input type="hidden" name="id">
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Emp. Partner Heading (1)</label>
                                <input type="text" name="partner_heading_1" id="headingContent1" placeholder="Enter Heading Content 1" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Emp. Partner Heading (2)</label>
                                <input type="text" name="partner_heading_2" id="headingContent2" placeholder="Enter Heading Content 2" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Trending Title</label>
                                <input type="text" class="form-control" name="trending_title">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Trending Subtitle</label>
                                <input type="text" class="form-control" name="trending_subtitle">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Free Courses Title</label>
                                <input type="text" class="form-control" name="free_courses_title">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Free Courses Subtitle</label>
                                <input type="text" class="form-control" name="free_courses_subtitle">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Verticals Title</label>
                                <input type="text" class="form-control" name="verticals_title">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Verticals Subtitle</label>
                                <input type="text" class="form-control" name="verticals_subtitle">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Testimonials Title</label>
                                <input type="text" class="form-control" name="testimonials_title">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Testimonials Subtitle</label>
                                <input type="text" class="form-control" name="testimonials_subtitle">
                            </div>
                             <div class="col-md-6">
                                    <label class="form-label">Instructor Heading(1)</label>
                                    <input type="text" name="instructor_heading_1" id="instructor_heading_1" placeholder="Enter Heading_1" class="form-control">
                                </div>
                                 <div class="col-md-6">
                                    <label class="form-label">Instructor Subtitle</label>
                                    <input type="text" name="instructor_subtitle" id="instructor_subtitle" placeholder="Enter Subtitle_1" class="form-control">
                                </div>
                                 <div class="col-md-6">
                                    <label class="form-label">Instructor Heading(2)</label>
                                    <input type="text" name="instructor_heading_2" id="instructor_heading_2" placeholder="Enter Heading_2" class="form-control">
                                </div>

                            <div class="col-md-6">
                                <label class="form-label">Awards Title</label>
                                <input type="text" class="form-control" name="awards_title">
                            </div>
                            <div class="col-md-6">
                            <label>Media Heading</label>
                            <input type="text" name="media_heading" class="form-control" placeholder="eg. Our Presence Media">
                        </div>

                            <div class="col-md-6">
                                <label class="form-label">Support Title</label>
                                <input type="text" class="form-control" name="support_title">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Support Subtitle</label>
                                <input type="text" class="form-control" name="support_subtitle">
                            </div>
                             <div class="col-md-6">
                                <label class="form-label">Building Careers</label>
                                <input type="text" class="form-control" name="building_careers">
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
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

</div>
@endsection

@push('script')
<script>
    $("#HomeSettingForm").validate({
        submitHandler: function() {
            var form = $('form#HomeSettingForm');
            form.ajaxSubmit({
                dataType: 'json',
                beforeSubmit: function() {
                    form.find('button:submit').html('Please wait...').attr('disabled', true);
                },
                success: function(data) {
                    form.find('button:submit').html('Submit').attr('disabled', false);
                    if (data.status === "success") {
                        $('#datatable').DataTable().ajax.reload(null, false);
                        notify(data.message, 'success');
                        $('#addSettingModal').modal('hide');
                    } else {
                        notify(data.message, 'error');
                    }
                }
            });
        }
    });

    function editSetting(full) {
        Object.keys(full).forEach(function(key) {
            $('#HomeSettingForm').find('[name="' + key + '"]').val(full[key]);
        });
        $('#addSettingModal').modal('show');
    }

    $(document).ready(function() {

        var url = "{{ url('statement/fetch') }}/homepagesettings/0";
        var onDraw = function() {

        };
        var options = [{
                "data": "id",
                render: function(data, type, full, meta) {
                    return `<span>###${meta.row+1}<br/>${full?.created_at}</span>`;
                }
            },
            {
                data: "trending_title"
            },
            {
                data: "trending_subtitle"
            },
            {
                data: "verticals_title"
            },
            {
                data: "verticals_subtitle"
            },
            {
                data: "free_courses_title"
            },
            {
                data: "free_courses_subtitle"
            },
            {
                data: "testimonials_title"
            },
            {
                data: "testimonials_subtitle"
            },
            {
                data: "awards_title"
            },
            {
                data: "support_title"
            },
            {
                data: "support_subtitle"
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
                data: null,
                render: function(data, type, full) {
                    return `<button class="btn btn-primary" onclick='editSetting(${JSON.stringify(full)})'>Edit</button>`;
                }
            }
        ];

        datatableSetup(url, options, onDraw);
    });
</script>
@endpush