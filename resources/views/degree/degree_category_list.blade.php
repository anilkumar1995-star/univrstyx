@extends('layouts.app_new')
@section('title', 'Degree Category List')
@section('pagetitle', 'Degree Category List')

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
                            <a href="{{ route('degreeCategoryView') }}" data-bs-toggle="tooltip" data-bs-placement="top"
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
                                <a href="javascript:void(0)" class="btn btn-primary ms-2 btn-add-category" data-bs-toggle="modal" data-bs-target="#addDegreeCategoryModal">
                                    <i class="ti ti-square-rounded-plus ti-sm"></i> Add Category
                                </a>
                                <a href="javascript:void(0)" class="btn btn-primary ms-2 btn-add-category" data-bs-toggle="modal" data-bs-target="#addDegreeCategoryTypeModal">
                                    <i class="ti ti-square-rounded-plus ti-sm"></i> Add Sub Category
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
                                    <th width="width:15%">#</th>
                                    <th width="width:15%">Degree Category</th>
                                    <th width="width:15%">Degree Category Slug</th>
                                    <th width="width:15%">Degree Category Type</th>
                                    <th width="width:15%">Degree Category Icon</th>
                                    <th width="width:15%">Status</th>
                                    <th width="width:10%">Action</th>
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
    <div class="modal fade" id="addDegreeCategoryTypeModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sub Category Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="degreeCategoryType" enctype="multipart/form-data" action="{{ route('addDegreeCategoryType') }}"
                    method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    <input type="hidden" name="id">

                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label>Degree Category Type Name</label>
                                <input type="text" name="degree_category_type" class="form-control" required
                                    placeholder="Enter Degree Category Name">
                            </div>
                            <div class="col-md-12 d-none">
                                <label>Degree Category Type Slug</label>
                                <input type="text" name="degree_category_type_slug" class="form-control" required
                                    placeholder="Enter Degree Category Slug" readonly>
                            </div>

                            <div class="col-md-12">
                                <label for="status">Status</label>
                                <select name="status" class="form-control" id="status" required>
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

    <!-- Add/Edit Degree Category Modal -->
    <div class="modal fade" id="addDegreeCategoryModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Degree Category Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="degreeCategory" enctype="multipart/form-data" action="{{ route('addDegreeCategory') }}"
                    method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    <input type="hidden" name="id">

                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label>Degree Category Name</label>
                                <input type="text" name="degree_category" class="form-control" required
                                    placeholder="Enter Degree Category Name">
                            </div>
                            <div class="col-md-12">
                                <label>Degree Category Slug</label>
                                <input type="text" name="degree_category_slug" class="form-control" required
                                    placeholder="Enter Degree Category Slug">
                            </div>
                            <div class="col-md-12">
                                <label for="degree_category_type">Degree Categories Type</label>
                                <select name="degree_category_type[]" id="degree_category_type"
                                    class="form-control select2" multiple required>
                                    @foreach($categoriestype as $category)
                                    <option value="{{ $category->degree_category_type_slug }}">
                                        {{ $category->degree_category_type }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label>Degree Category Icon</label>
                                <input type="file" name="degree_category_icon" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label>Degree Category Icon 2</label>
                                <input type="file" name="degree_category_icon_2" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label for="status">Status</label>
                                <select name="status" class="form-control" id="status" required>
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
</div>


@endsection

@push('style')
<style>
    .note-editor .note-editable {
        font-size: 14px !important;
        line-height: 1.6 !important;
    }
</style>
@endpush

@push('script')
<script type="text/javascript">
    $(document).ready(function() {
        $("#addCourseInclusion").click(function() {
            let newField = `
            <div class="col-md-4 d-flex align-items-end mt-2">
                <div class="w-100">
                    <label for="course_inclusions">Course Inclusions</label>
                    <input type="text" name="course_inclusions[]" class="form-control"/>
                </div>
                <button type="button" class="btn btn-danger btn-sm ms-2 removeField" style="height:38px;">✖</button>
            </div>`;
            $("#courseInclusionWrapper").append(newField);
        });

        $(document).on("click", ".removeField", function() {
            $(this).closest(".col-md-4").remove();
        });
        $("#addtransform").click(function() {
            let newField = `
                  <div class="col-md-4 d-flex align-items-end">
                            <div class="w-100">
                                <label for="transform">Transform Your Leadership career</label>
                                <input type="text" name="transform_career[]" placeholder="Enter Transform Your Leadership career" class="form-control"/>
                            </div>
                            <button type="button" class="btn btn-danger btn-sm ms-2 removeTransform" style="height:38px;">✖</button>
                        </div>`;
            $("#transFormWrapper").append(newField);
        });

        $(document).on("click", ".removeTransform", function() {
            $(this).closest(".col-md-4").remove();
        });

        $('.summernote').summernote({
            height: 250,
            placeholder: 'Write here...',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['font2', ['fontsize', 'fontname', 'color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            fontNames: [
                'Arial', 'Courier New', 'Comic Sans MS', 'Times New Roman', 'Verdana', 'Tahoma',
                'Helvetica'
            ],
            fontNamesIgnoreCheck: [
                'Arial', 'Courier New', 'Comic Sans MS', 'Times New Roman', 'Verdana', 'Tahoma',
                'Helvetica'
            ],
            fontSizes: [
                '8', '9', '10', '11', '12', '14', '16', '18', '20',
                '22', '24', '28', '32', '36', '48', '64', '82', '150'
            ]
        });



        var url = "{{ url('statement/fetch') }}/degreecategory/0";

        var onDraw = function() {

        };

        var options = [{
                "data": "id",
                render: function(data, type, full, meta) {
                    return `<span>###${meta.row+1}<br/>${full?.created_at}</span>`;
                }
            },
            {
                "data": "degree_category"
            },
            {
                "data": "degree_category_slug"
            },
            {
                "data": "degree_category_type"
            },
            {
                "data": "degree_category_icon",
                render: function(data, type, full) {
                    if (data && data !== 'null') {
                        return `<a href="#">
                                    <img src="https://images.incomeowl.in/incomeowl/crm/images/${data}" width="60%" height="60%"/>
                                </a>`;
                    } else {
                        return `<a href="#">
                                    <img src="{{ asset('img/noimg.png') }}" width="60%"/>
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
                    return `<button type="button" class="btn btn-primary" onclick="editDetails(${full.id})">Edit</button>`;
                }
            }

        ];
        datatableSetup(url, options, onDraw);
    });

    $("#degreeCategory").validate({
        submitHandler: function() {
            var form = $('form#degreeCategory');
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
                        $('#datatable').dataTable().api().ajax.reload();
                        notify("Degree Category submitted successfully",
                            'success');
                        $('#addDegreeCategoryModal').modal('hide');
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

    $('.btn-add-category').on('click', function() {
        $('#degreeCategory')[0].reset();
        $('#degreeCategory').find('input[name="id"]').val('');
        $('#degree_category_type').val(null).trigger('change');
        $('#status').val('').trigger('change');
    });

    function editDetails(id) {

        $('#degreeCategory')[0].reset();
        $('#degreeCategory').find('input[name="id"]').val('');

        $('#degree_category_type').val(null).trigger('change');
        $('#status').val('').trigger('change');

        $.ajax({
            url: `/degree-category/details/${id}`,
            type: 'GET',
            success: function(res) {
                if (res.success) {
                    let data = res.data;

                    $('#degreeCategory').find('input[name="id"]').val(data.id);

                    $('#degreeCategory').find('input[name="degree_category"]').val(data.degree_category);
                    $('#degreeCategory').find('input[name="degree_category_slug"]').val(data.degree_category_slug);

                    if (data.degree_category_type && Array.isArray(data.degree_category_type)) {
                        $('#degree_category_type').val(data.degree_category_type).trigger('change');
                    }

                    $('#status').val(data.status).trigger('change');

                    $('.modal-title').text('Edit Degree Category');

                    $('#addDegreeCategoryModal').modal('show');
                } else {
                    alert("Category not found.");
                }
            },
            error: function(err) {
                console.error("AJAX error:", err);
            }
        });
    }

    $("input[name='degree_category_type']").on('keyup change', function() {
        let text = $(this).val().trim();
        let slug = text.toLowerCase()
            .replace(/\s+/g, '_')
            .replace(/[^a-z0-9_]/g, '');
        $("input[name='degree_category_type_slug']").val(slug);
    });

    $("#degreeCategoryType").validate({
        rules: {
            degree_category_type: {
                required: true,
                minlength: 2
            },
            degree_category_type_slug: {
                required: true
            },
            status: {
                required: true
            }
        },
        messages: {
            degree_category_type: {
                required: "Please enter category name",
                minlength: "Category name must be at least 2 characters"
            },
            degree_category_type_slug: {
                required: "Slug is required"
            },
            status: {
                required: "Please select status"
            }
        },
        submitHandler: function(form) {
            $(form).ajaxSubmit({
                dataType: 'json',
                beforeSubmit: function() {
                    $(form).find('button:submit')
                        .html('<i class="fa fa-spin fa-spinner"></i> Submitting')
                        .attr('disabled', true);
                },
                success: function(data) {
                    $(form).find('button:submit')
                        .html('Submit Details')
                        .attr('disabled', false);

                    if (data.status === 'success') {
                        notify("Degree Category added successfully", 'success');
                        form.reset();
                        $('#addDegreeCategoryTypeModal').modal('hide');
                        // Reload your datatable if needed
                        $('#datatable').DataTable().ajax.reload();
                    } else {
                        notify(data.message || "Something went wrong", 'error');
                    }
                },
                error: function(xhr) {
                    $(form).find('button:submit')
                        .html('Submit Details')
                        .attr('disabled', false);

                    let errMsg = xhr?.responseJSON?.message || "Something went wrong";
                    notify(errMsg, 'error');
                }
            });
        }
    });
</script>
@endpush