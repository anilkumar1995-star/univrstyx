@extends('layouts.app_new')
@section('title', 'Course List')
@section('pagetitle', 'Course List')

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
                            <a href="{{ route('courseView') }}" data-bs-toggle="tooltip" data-bs-placement="top"
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
                                <a href="javascript:void(0)" type="button" class="btn btn-primary ms-2"
                                    data-bs-toggle="modal" data-bs-target="#addCourseModal">
                                    <i class="ti ti-square-rounded-plus ti-sm"></i> Add Course</a>
                                <a href="javascript:void(0)" class="btn btn-primary ms-3"
                                    onclick="openHideModal({{ Auth::id() }})">
                                    <i class="ti ti-square-rounded-plus ti-sm"></i> Hide Free Course
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
                                    <th width="15%">#</th>
                                    <th width="20%">Course Name</th>
                                    <th width="15%">Course Learners</th>
                                    <th width="15%">Course Hours</th>
                                    <th width="15%">Course Image</th>
                                    <th width="10%">Status</th>
                                    <th width="10%">Action</th>
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


<!-- Add/Edit Course Modal -->
<div class="modal" id="addCourseModal" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('addCourse') }}" method="POST" enctype="multipart/form-data" id="courseForm">
                @csrf
                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                <input type="hidden" name="id" id="courseId">

                <div class="modal-body">
                    <div class="row g-3">

                        <h4 class="m-2">Basic Info</h4>

                        <div class="col-md-2">
                            <label for="category">Course Category</label>
                            <select name="course_category" id="category" class="form-control" required>
                                <option value="">--Select--</option>
                                @foreach ($cat as $slug => $name)
                                <option value="{{ $slug }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="course_title">Course Title</label>
                            <input type="text" name="course_title" id="course_title" class="form-control" required
                                placeholder="Enter Title Name">
                        </div>

                        <div class="col-md-3">
                            <label for="learners">Course Learners</label>
                            <input type="number" name="course_learners" id="learners"
                                placeholder="Course Learners" required class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label for="hours">Course Hours of Learning</label>
                            <input type="number" name="course_hours" id="hours"
                                placeholder="Course Hours of Learning" required class="form-control">
                        </div>
                        <div id="course_related_wrapper" class="row g-2">
                            <div class="col-md-4">
                                <label>Course Related</label>
                                <input type="text" name="course_related[]" placeholder="Course Related" required
                                    class="form-control">
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="button" id="add_course_related" class="btn btn-outline-primary btn-sm">+
                                Add Course Related</button>
                        </div>
                        <div class="col-md-4">
                            <label for="course_icon">Course Image</label>
                            <input type="file" name="course_icon" id="course_icon" class="form-control">
                        </div>
                        <div class="col-md-7">
                            <label for="course_description">Course Description</label>
                            <textarea name="course_description" id="course_description" rows="3" required placeholder="Course Description"
                                class="form-control"></textarea>
                        </div>
                        <div class="col-md-3">
                            <label for="free_certificate">Free Certificate</label>
                            <select name="free_certificate" id="free_certificate" class="form-control" required>
                                <option value="">--Select--</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="share">Is Share</label>
                            <select name="is_share" id="share" class="form-control" required>
                                <option value="">--Select--</option>
                                <option value="yes">Yes</option>
                                <option value="no">No</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="enquiry">Helpline Number</label>
                            <input type="number" name="helpline_number" id="enquiry" required
                                placeholder="Helpline Number" class="form-control">
                        </div>
                        <h4>What You Will Learn</h4>
                        <div id="topic-fields-wrapper">
                            <div class="row g-3 topic-group">
                                <div class="col-md-6">
                                    <label>Topic</label>
                                    <input type="text" name="topic[]" class="form-control" placeholder="Topic">
                                </div>
                                <div class="col-md-6">
                                    <label>Topic Heading</label>
                                    <textarea name="topic_headding[]" class="form-control" placeholder="Topic Description"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <label>Topic Content</label>
                                    <textarea class="form-control summernote" name="topic_content[]"></textarea>
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="button"
                                        class="btn btn-danger btn-sm remove-topic-btn">Remove</button>
                                </div>
                            </div>
                        </div>
                        <div class="my-2">
                            <button type="button" class="btn btn-outline-primary btn-sm" id="add-topic-btn">+ Add
                                Topic</button>
                        </div>
                        <h4>Earn And Share Certificates</h4>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="certificate_intro">Certificate Intro</label>
                                <input type="text" name="certificate_intro" required id="certificate_intro"
                                    class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label for="certificate_img">Certificate Image</label>
                                <input type="file" name="certificate_img" id="certificate_img"
                                    class="form-control">
                            </div>
                        </div>

                        <h4>Key Benefit of Course</h4>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="key_benefit">Key Benefits</label>
                                <textarea id="keybenefit" name="keybenefit_content" placeholder="Enter Here..." class="form-control summernote"></textarea>
                            </div>
                        </div>
                        <h4>Whoose Enroll</h4>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="who_enroll">Whoose Enroll</label>
                                <textarea id="who_enroll" name="who_enroll" placeholder="Enter Here..." class="form-control summernote"></textarea>
                            </div>
                        </div>
                        <h4>Why Choose Course</h4>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="why_choose_course">Why Choose Course</label>
                                <textarea id="why_choose_course" name="why_choose_course" placeholder="Enter Here..." class="form-control summernote"></textarea>
                            </div>
                        </div>

                        <h4>Maximize Your Learning Experience</h4>
                        <div id="comparison-feature">
                            <div class="row g-2 comparison-feature">
                                <div class="col-md-3">
                                    <label>Feature Name</label>
                                    <input type="text" name="feature_name[]" class="form-control" required
                                        placeholder="Feature name">
                                </div>
                                <div class="col-md-3">
                                    <label>Free Course</label>
                                    <select name="free_course[]" class="form-control" required>
                                        <option value="">--Select--</option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Paid Course</label>
                                    <select name="paid_course[]" class="form-control" required>
                                        <option value="">--Select--</option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger btn-sm remove-feature">X</button>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="button" id="add-feature" class="btn btn-outline-primary btn-sm">+ Add
                                Feature</button>
                        </div>
                        <div class="col-md-6">
                            <label>Status</label>
                            <select name="status" class="form-control" id="status" required>
                                <label for="status">Status</label>
                                <option value="">--Select--</option>
                                <option value="active">Active</option>
                                <option value="inactive">In Active</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit"
                        data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">
                        Submit Details
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add/Edit Course Modal -->
<div class="modal" id="HideCourseModal" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Show/Hide free Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('addShowHide') }}" method="POST" enctype="multipart/form-data" id="HideForm">
                @csrf
                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                <input type="hidden" name="id" id="courseId">

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label>Show / Hide</label>
                            <select name="show_hide" class="form-control" id="show_hide" required>
                                <label for="show_hide">Status</label>
                                <option value="">--Select--</option>
                                <option value="active">Active</option>
                                <option value="inactive">In Active</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit"
                        data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">
                        Submit Details
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('style')
<style>
    .note-editor {
        width: 100% !important;
        max-width: 100% !important;
    }
</style>
@endpush

@push('script')
<script type="text/javascript">
    function openHideModal(userId) {
        $.ajax({
            url: '/course/get-free-course-status/' + userId,
            type: 'GET',
            success: function(res) {
                if (res.status === 'success' && res.data) {
                    $('#courseId').val(res.data.id || '');
                    $('#show_hide').val(res.data.show_hide || '');
                } else {
                    $('#courseId').val('');
                    $('#show_hide').val('');
                }

                var myModal = new bootstrap.Modal(document.getElementById('HideCourseModal'), {
                    backdrop: 'static'
                });
                myModal.show();
            },
            error: function(err) {
                console.error(err);
            }
        });
    }


    $(function() {
        $("#add-comparison").click(function() {
            let clone = $(".comparison-group:first").clone();
            clone.find("input").val("");
            $("#comparison-wrapper").append(clone);
        });

        $(document).on("click", ".remove-comparison", function() {
            if ($(".comparison-group").length > 1) {
                $(this).closest(".comparison-group").remove();
            }
        });
    });
    $(function() {
        $("#add-feature").click(function() {
            let clone = $(".comparison-feature:first").clone();
            clone.find("input").val("");
            $("#comparison-feature").append(clone);
        });

        $(document).on("click", ".remove-feature", function() {
            if ($(".comparison-feature").length > 1) {
                $(this).closest(".comparison-feature").remove();
            }
        });
    });
    $(function() {
        $("#add-faq").click(function() {
            let clone = $(".comparison-faq:first").clone();
            clone.find("input").val("");
            $("#comparison-faq").append(clone);
        });

        $(document).on("click", ".remove-faq", function() {
            if ($(".comparison-faq").length > 1) {
                $(this).closest(".comparison-faq").remove();
            }
        });
    });
    $(document).ready(function() {
        function initSummernote() {
            $('#keybenefit, #who_enroll, #why_choose_course').each(function() {
                if ($(this).data('summernote')) {
                    $(this).summernote('destroy');
                }
                $(this).summernote({
                    height: 200,
                    maxHeight: null,
                    width: '100%',
                    placeholder: 'Write here...',
                    toolbar: [
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['fontsize', 'color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ]
                });
            });
        }

        // $('#summernote').summernote({
        //     height: 200,
        //     width: 900,
        //     placeholder: 'Write here...',
        //     toolbar: [
        //         ['style', ['bold', 'italic', 'underline', 'clear']],
        //         ['font', ['fontsize', 'color']],
        //         ['para', ['ul', 'ol', 'paragraph']],
        //         ['insert', ['link', 'picture', 'video']],
        //         ['view', ['fullscreen', 'codeview', 'help']]
        //     ]
        // });
        // $('#keybenefit').summernote({
        //     height: 200,
        //     width: 900,
        //     placeholder: 'Write here...',
        //     toolbar: [
        //         ['style', ['bold', 'italic', 'underline', 'clear']],
        //         ['font', ['fontsize', 'color']],
        //         ['para', ['ul', 'ol', 'paragraph']],
        //         ['insert', ['link', 'picture', 'video']],
        //         ['view', ['fullscreen', 'codeview', 'help']]
        //     ]
        // });
        // $('#who_enroll').summernote({
        //     height: 200,
        //     width: 900,
        //     placeholder: 'Write here...',
        //     toolbar: [
        //         ['style', ['bold', 'italic', 'underline', 'clear']],
        //         ['font', ['fontsize', 'color']],
        //         ['para', ['ul', 'ol', 'paragraph']],
        //         ['insert', ['link', 'picture', 'video']],
        //         ['view', ['fullscreen', 'codeview', 'help']]
        //     ]
        // });
        // $('#why_choose_course').summernote({
        //     height: 200,
        //     width: 800,
        //     placeholder: 'Write here...',
        //     toolbar: [
        //         ['style', ['bold', 'italic', 'underline', 'clear']],
        //         ['font', ['fontsize', 'color']],
        //         ['para', ['ul', 'ol', 'paragraph']],
        //         ['insert', ['link', 'picture', 'video']],
        //         ['view', ['fullscreen', 'codeview', 'help']]
        //     ]
        // });

        $("#add_course_related").click(function() {
            let field = `
            <div class="col-md-4 mt-2 d-flex align-items-start">
            <label>Course Related</label><br>
                <input type="text" name="course_related[]" placeholder="Course Related" required class="form-control me-2">
                <button type="button" class="btn btn-danger btn-sm remove-course-related">X</button>
            </div>
        `;
            $("#course_related_wrapper").append(field);
        });

        $(document).on("click", ".remove-course-related", function() {
            $(this).closest('.col-md-4').remove();
        });

        $('#add-topic-btn').on('click', function() {
            let topicFields = `
        <div class="row g-3 topic-group">
            <div class="col-md-6">
                <label for="topic">Topic</label>
                <input type="text" name="topic[]" class="form-control" placeholder="Topic">
            </div>
            <div class="col-md-6">
                <label for="topic_headding">Topic Heading</label>
                <textarea name="topic_headding[]" class="form-control" placeholder="Topic Description"></textarea>
            </div>
            <div class="col-md-12">
                <label for="topic_content">Topic Content</label>
                <textarea class="summernote" name="topic_content[]"></textarea>
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-sm remove-topic-btn">Remove</button>
            </div>
        </div>
    `;

            $('#topic-fields-wrapper').append(topicFields);

            $('.summernote').summernote({
                height: 200,
                width: 900,
                placeholder: 'Write here...',
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['fontsize', 'color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });


        $(document).on('click', '.remove-topic-btn', function() {
            $(this).closest('.topic-group').remove();
        });

        var url = "{{ url('statement/fetch') }}/course/0";

        var onDraw = function() {

        };

        var options = [{
                "data": "id",
                render: function(data, type, full, meta) {
                    return `<span>###${meta.row+1}<br/>${full?.created_at}</span>`;
                }
            },
            {
                "data": "course_title"
            },
            {
                "data": "course_learners"
            },
            {
                "data": "course_hours"
            },
            {
                "data": "course_icon",
                render: function(data, type, full) {
                    if (data && data !== 'null') {
                        return `<a href="#">
                                    <img src="https://images.incomeowl.in/incomeowl/crm/images/${data}" 
                                        style="width:50px; height:50px; object-fit:cover; border:1px solid #ccc;"/>
                                </a>`;
                    } else {
                        return `<a href="#">
                                    <img src="{{ asset('img/noimg.png') }}" 
                                        style="width:50px; height:50px; object-fit:cover; border:1px solid #ccc;"/>
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
                render: function(data, type, full) {
                    return `
                        <button type="button" 
                            class="btn btn-primary btn-sm editCourseBtn" 
                            data-id="${full.id}">
                            Edit
                        </button>`;
                }
            }


        ];
        datatableSetup(url, options, onDraw);

         $("#HideForm").validate({
            submitHandler: function() {
                var form = $('form#HideForm');
                form.ajaxSubmit({
                    dataType: 'json',
                    beforeSubmit: function() {
                        form.find('button:submit').html('Please wait...').attr(
                            'disabled', true).addClass('btn-secondary');
                    },
                    success: function(data) {
                        form.find('button:submit').html('Submit Details').attr(
                            'disabled',
                            false).removeClass('btn-secondary');
                        if (data.status == "success") {
                            form[0].reset();
                            $('#datatable').DataTable().ajax.reload();
                            notify(data.message,
                                'success');
                            $('#HideCourseModal').modal('hide');
                        } else {
                            notify(data.status, 'error');
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

        $("#courseForm").validate({
            submitHandler: function() {
                var form = $('form#courseForm');
                form.ajaxSubmit({
                    dataType: 'json',
                    beforeSubmit: function() {
                        form.find('button:submit').html('Please wait...').attr(
                            'disabled', true).addClass('btn-secondary');
                    },
                    success: function(data) {
                        form.find('button:submit').html('Submit Details').attr(
                            'disabled',
                            false).removeClass('btn-secondary');
                        if (data.status == "success") {
                            form[0].reset();
                            $('#datatable').DataTable().ajax.reload();
                            notify("Course details submitted successfully",
                                'success');
                            $('#addCourseModal').modal('hide');
                        } else {
                            notify(data.status, 'error');
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

        $("#courseCategory").validate({
            submitHandler: function() {
                var form = $('form#courseCategory');
                form.ajaxSubmit({
                    dataType: 'json',
                    beforeSubmit: function() {
                        form.find('button:submit').html('Please wait...').attr(
                            'disabled', true).addClass('btn-secondary');
                    },
                    success: function(data) {
                        form.find('button:submit').html('Submit Details').attr(
                            'disabled', false).removeClass('btn-secondary');

                        if (data.success) {
                            form[0].reset();
                            location.reload();
                            notify(data.message, 'success');
                            $('#addCourseCategoryModal').modal('hide');
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
    });
    $(document).on('click', '.editCourseBtn', function() {
        let id = $(this).data('id');

        $('#courseForm')[0].reset();
        $('#topic-fields-wrapper').empty();
        $('#course_related_wrapper').empty();
        $('#comparison-feature').empty();
        $('#keybenefit').summernote('code', '');
        $('#who_enroll').summernote('code', '');
        $('#why_choose_course').summernote('code', '');

        $.ajax({
            url: `/course/details/${id}`,
            type: 'GET',
            success: function(res) {
                if (res.success) {
                    let course = res.data;

                    $('#courseForm').find('[name="id"]').val(course.id);
                    $('#courseForm').find('[name="course_category"]').val(course.course_category)
                        .trigger('change');
                    $('#courseForm').find('[name="course_title"]').val(course.course_title);
                    $('#courseForm').find('[name="course_learners"]').val(course.course_learners);
                    $('#courseForm').find('[name="course_hours"]').val(course.course_hours);
                    $('#courseForm').find('[name="status"]').val(course.status);
                    $('#courseForm').find('[name="course_description"]').val(course
                        .course_description);
                    $('#courseForm').find('[name="helpline_number"]').val(course.helpline_number);
                    $('#courseForm').find('[name="free_certificate"]').val(course.free_certificate)
                        .trigger('change');
                    $('#courseForm').find('[name="is_share"]').val(course.is_share).trigger(
                        'change');
                    $('#courseForm').find('[name="certificate_intro"]').val(course
                        .certificate_intro);

                    $('#keybenefit').summernote('code', course.keybenefit_content ?? '');
                    $('#why_choose_course').summernote('code', course.why_choose_course ?? '');
                    $('#who_enroll').summernote('code', course.who_enroll ?? '');

                    if (course.course_related) {
                        course.course_related.forEach(r => {
                            $('#course_related_wrapper').append(`
                             <div class="col-md-4 mt-2 d-flex align-items-start">
                                <label>Course Related</label><br>
                                    <input type="text" name="course_related[]" placeholder="Course Related" value="${r}" required class="form-control me-2">
                                    <button type="button" class="btn btn-danger btn-sm remove-course-related">X</button>
                                </div>                      
                        `);
                        });
                    }

                    if (res.topics) {
                        res.topics.forEach(t => {
                            let topicHtml = `
                            <div class="row g-3 topic-group mb-3">
                                <div class="col-md-6">
                                    <label>Topic</label>
                                    <input type="text" name="topic[]" value="${t.topic ?? ''}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label>Topic Heading</label>
                                    <textarea name="topic_headding[]" class="form-control">${t.topic_headding ?? ''}</textarea>
                                </div>
                                <div class="col-md-12">
                                    <label>Topic Content</label>
                                    <textarea class="summernote" name="topic_content[]">${t.topic_content ?? ''}</textarea>
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger btn-sm remove-topic-btn">Remove</button>
                                </div>
                            </div>
                        `;
                            $('#topic-fields-wrapper').append(topicHtml);
                        });

                        $('#topic-fields-wrapper .summernote').each(function() {
                            if ($(this).data('summernote')) $(this).summernote('destroy');
                            $(this).summernote({
                                height: 200,
                                width: 900
                            });
                        });
                    }

                    if (res.features) {
                        res.features.forEach(f => {
                            let featureHtml = `
                            <div class="row g-2 comparison-feature mb-2">
                                <div class="col-md-3">
                                    <label>Feature Name</label>
                                    <input type="text" name="feature_name[]" class="form-control" value="${f.feature_name ?? ''}" required>
                                </div>
                                <div class="col-md-3">
                                    <label>Free Course</label>
                                    <select name="free_course[]" class="form-control" required>
                                        <option value="">--Select--</option>
                                        <option value="yes" ${f.free_course == 'yes' ? 'selected' : ''}>Yes</option>
                                        <option value="no" ${f.free_course == 'no' ? 'selected' : ''}>No</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Paid Course</label>
                                    <select name="paid_course[]" class="form-control" required>
                                        <option value="">--Select--</option>
                                        <option value="yes" ${f.paid_course == 'yes' ? 'selected' : ''}>Yes</option>
                                        <option value="no" ${f.paid_course == 'no' ? 'selected' : ''}>No</option>
                                    </select>
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger btn-sm remove-feature">X</button>
                                </div>
                            </div>
                        `;
                            $('#comparison-feature').append(featureHtml);
                        });
                    }

                    $('#modalTitle').text('Edit Course');
                    $('#addCourseModal').modal('show');
                }
            }
        });
    });
    $(document).on('click', '.btn-primary.ms-2', function() {

        $('#courseForm')[0].reset();
        $('#courseId').val('');

        $('#topic-fields-wrapper').empty();
        $('#course_related_wrapper').empty();
        $('#comparison-feature').empty();
        $('#course_related_wrapper').append(`
        <div class="col-md-4">
            <label>Course Related</label>
            <input type="text" name="course_related[]" placeholder="Course Related" required class="form-control">
        </div>
    `);
        let featureHtml = `
        <div class="row g-2 comparison-feature mb-2">
            <div class="col-md-3">
                <label>Feature Name</label>
                <input type="text" name="feature_name[]" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label>Free Course</label>
                <select name="free_course[]" class="form-control" required>
                    <option value="">--Select--</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>
            <div class="col-md-3">
                <label>Paid Course</label>
                <select name="paid_course[]" class="form-control" required>
                    <option value="">--Select--</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-sm remove-feature">X</button>
            </div>
        </div>
    `;
        $('#comparison-feature').append(featureHtml);
        let topicHtml = `
        <div class="row g-3 topic-group mb-3">
            <div class="col-md-6">
                <label>Topic</label>
                <input type="text" name="topic[]" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Topic Heading</label>
                <textarea name="topic_headding[]" class="form-control"></textarea>
            </div>
            <div class="col-md-12">
                <label>Topic Content</label>
                <textarea class="summernote" name="topic_content[]"></textarea>
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-sm remove-topic-btn">Remove</button>
            </div>
        </div>
    `;

        $('#topic-fields-wrapper').append(topicHtml);
        $('#topic-fields-wrapper .summernote').last().summernote({
            height: 200,
            width: 900
        });

        $('#keybenefit').summernote('code', '');
        $('#who_enroll').summernote('code', '');
        $('#why_choose_course').summernote('code', '');
        $('#keybenefit, #who_enroll, #why_choose_course').each(function() {
            if ($(this).data('summernote')) {
                $(this).summernote('destroy');
            }
            $(this).summernote({
                height: 200,
                width: 900
            });
        });

        $('#modalTitle').text('Add Course');

        $('#addCourseModal').modal('show');
    });







    function deleteSyllabus(id) {
        $('#deleteSyllabusModal').modal('show');
        $('#confirmDelete').off('click').on('click', function() {
            $.ajax({
                url: "{{ route('syllabusDelete') }}",
                type: 'POST',
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status == 'success') {
                        notify('Syllabus deleted successfully', 'success');
                        loadSyllabusCards();
                    } else {
                        notify(response.message || 'Failed to delete syllabus', 'error');
                    }
                    $('#deleteSyllabusModal').modal('hide');
                },
                error: function(xhr, status, error) {
                    console.error('Error deleting syllabus:', error);
                    notify('Something went wrong', 'error');
                    $('#deleteSyllabusModal').modal('hide');
                }
            });
        });
    }
</script>
@endpush