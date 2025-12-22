@extends('layouts.app_new')
@section('title', 'Degree List')
@section('pagetitle', 'Degree List')

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
                            <a href="{{ route('degreeView') }}" data-bs-toggle="tooltip" data-bs-placement="top"
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
                                <a href="javascript:void(0)" id="addUniversityBtn" class="btn btn-primary ms-2" data-bs-toggle="modal"
                                    data-bs-target="#addUniversityModal">
                                    <i class="ti ti-square-rounded-plus ti-sm"></i> Add University
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
                                    <th width="10%">#</th>
                                    <th width="15%">Type</th>
                                    <th width="20%">Degree Name</th>
                                    <th width="15%">University Name</th>
                                    <th width="15%">University Icon</th>
                                    <th width="15%">Status</th>
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


    <!-- Add/Edit University Modal -->
    <div class="modal fade" id="addUniversityModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">University Details & Course Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="universityAdd" enctype="multipart/form-data" action="{{ route('university') }}"
                    method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    <input type="hidden" name="id">

                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Select Category <span class="text-danger">*</span></label>
                                <select id="categorySelect" name="degree_category" class="form-select">
                                    <option value="">-- Select Category --</option>
                                    @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        data-types="{{ $cat->degree_category_type }}">
                                        {{ $cat->degree_category }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Select Type <span class="text-danger">*</span></label>
                                <select id="typeSelect" name="type" class="form-select">
                                    <option value="">-- Select Type --</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">New Course </label>
                                <input type="text" name="newcourse_1" class="form-control"
                                    placeholder="Enter New Course Name">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">New Course 2</label>
                                <input type="text" name="newcourse_2" class="form-control"
                                    placeholder="Enter Best Seller">
                            </div>
                            <div class="col-md-4">
                                <label for="bestseller">Best Seller</label>
                                <select name="bestseller" class="form-control" id="bestseller" required>
                                    <option value="">--Select--</option>
                                    <option value="yes">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">University Name <span class="text-danger">*</span></label>
                                <input type="text" name="university_name" class="form-control"
                                    placeholder="Enter University Name" required>
                            </div>
                            <div class="col-md-4">
                                <label>Course Name <span class="text-danger">*</span></label>
                                <input type="text" name="degree_name" class="form-control" required
                                    placeholder="Enter Degree Name">
                            </div>
                            <div class="col-md-3">
                                <label>University Image 1 </label>
                                <input type="file" name="university_icon_1" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label>University Image 2</label>
                                <input type="file" name="university_icon_2" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label>Course Description</label>
                                <textarea name="degree_description" class="form-control" rows="3" placeholder="Enter Degree Description"></textarea>
                            </div>


                            <div class="col-md-3">
                                <label for="degree_duration">Duration In Months <span class="text-danger">*</span></label>
                                <input type="text" name="degree_duration" id="degree_duration" required
                                    placeholder="Enter Degree Duration" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label for="deadline_date">Admission Deadline Date <span class="text-danger">*</span></label>
                                <input type="date" name="deadline_date" id="deadline_date" required
                                    class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label for="learners">Course Learners <span class="text-danger">*</span></label>
                                <input type="number" name="course_learners" id="learners"
                                    placeholder="Course Learners" required class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label for="hours">Course Hours of Learning <span class="text-danger">*</span></label>
                                <input type="number" name="course_hours" id="hours"
                                    placeholder="Course Hours of Learning" required class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label for="enquiry">Helpline Number <span class="text-danger">*</span></label>
                                <input type="number" name="helpline_number" id="enquiry" required
                                    placeholder="Helpline Number" class="form-control">
                            </div>
                            <div class="col-12 mt-3">
                                <h4>Introduction</h4>
                            </div>
                            <div class="col-md-12">
                                <label for="degree_overview">Overview</label>
                                <textarea id="degree_overview" placeholder="Enter Here..." name="degree_overview" class="form-control summernote"></textarea>
                            </div>
                            <div class="col-12 mt-3">
                                <h4>Key Highlights</h4>
                            </div>
                            <div class="col-md-12">
                                <label for="key_highlight">Key Highlight</label>
                                <textarea id="key_highlight" name="key_highlight" placeholder="Enter Here..." class="form-control summernote"></textarea>
                            </div>
                            <div class="col-12 mt-3">
                                <h4>Career Outcome</h4>
                            </div>
                            <div class="col-md-12">
                                <label for="career_outcome">Outcomes</label>
                                <textarea id="career_outcome" placeholder="Enter Here..." name="career_outcome" class="form-control summernote"></textarea>
                            </div>
                            <div class="col-12 mt-3">
                                <h4>Compare Programme</h4>
                            </div>
                            <div class="col-md-12">
                                <label for="compare_degree">Compare Programme</label>
                                <textarea id="compare_degree" placeholder="Enter Here..." name="compare_degree" class="form-control summernote"></textarea>
                            </div>
                            <div class="col-12 mt-3">
                                <h4>Copilot</h4>
                            </div>
                            <div class="col-md-12">
                                <label for="free_copilot">Free Copilot</label>
                                <textarea id="free_copilot" name="free_copilot" placeholder="Enter Here..." class="form-control summernote"></textarea>
                            </div>
                            <div class="col-12 mt-3">
                                <h4>Why should you Choose</h4>
                            </div>
                            <div class="col-md-12">
                                <label for="why_should_choose">Why should You Choose </label>
                                <textarea id="why_should_choose" placeholder="Enter Here..." name="why_should_choose"
                                    class="form-control summernote"></textarea>
                            </div>
                            <div class="col-12 mt-2">
                                <h4 class="mt-3">Transform Your Career</h4>
                            </div>
                            <div class="row" id="transFormWrapper">
                                <div class="col-md-4 mt-3 d-flex align-items-end">
                                    <div class="w-100">
                                        <label for="transform">Transform Your Leadership career</label>
                                        <input type="text" name="transform_career[]"
                                            placeholder="Enter Transform Your Leadership career"
                                            class="form-control" />
                                    </div>
                                    <button type="button" class="btn btn-danger btn-sm ms-2 removeTransform"
                                        style="height:38px;">✖</button>
                                </div>
                            </div>

                            <div class="col-md-12 mt-4 mb-3">
                                <button type="button" id="addtransform" class="btn btn-sm btn-primary">+ Add
                                    More</button>
                            </div>
                            <div class="col-12 mt-3">
                                <h4>Course Fee Details</h4>
                            </div>
                            <div class="col-md-3">
                                <label for="course_starting_at">Course Starting At(Per Month) <span class="text-danger">*</span></label>
                                <input type="text" id="course_starting_at" name="course_starting_at"
                                    placeholder="In INR" class="form-control" required />
                            </div>
                            <div class="col-md-3">
                                <label for="course_total_amount">Course Total Amount <span class="text-danger">*</span></label>
                                <input type="text" id="course_total_amount" name="course_total_amount"
                                    placeholder="Enter Total Amount" class="form-control" required />
                            </div>
                            <div class="row" id="courseInclusionWrapper">
                                <div class="col-md-4 d-flex align-items-end">
                                    <div class="w-100">
                                        <label for="course_inclusions">Course Inclusions</label>
                                        <input type="text" name="course_inclusions[]"
                                            placeholder="Course Inclusions" class="form-control" />
                                    </div>
                                    <button type="button" class="btn btn-danger btn-sm ms-2 removeField"
                                        style="height:38px;">✖</button>
                                </div>
                            </div>

                            <div class="col-md-12 mt-2">
                                <button type="button" id="addCourseInclusion" class="btn btn-sm btn-primary">+ Add
                                    More</button>
                            </div>
                            <div class="card mt-4">
                                <div class="card-header">
                                    <h5>Add FAQs (Multiple Categories + Multiple Questions)</h5>
                                </div>

                                <div class="card-body">
                                    <div id="categoryWrapper">

                                        <!-- CATEGORY BLOCK START -->
                                        <div class="categoryBlock border p-3 mb-4 rounded">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Category Name</label>
                                                <input type="text" name="categories[0][category_name]" class="form-control" placeholder="e.g. Payment, Refund Policy, Privacy Policy">
                                            </div>

                                            <div class="faqGroup">
                                                <h6>Questions</h6>
                                                <div class="faqItem border p-2 mb-2 rounded">
                                                    <input type="text" name="categories[0][questions][]" class="form-control mb-2" placeholder="Enter Question">
                                                    <textarea name="categories[0][answers][]" class="form-control" rows="2" placeholder="Enter Answer"></textarea>
                                                </div>
                                            </div>

                                            <button type="button" class="btn btn-secondary btn-sm addMoreQA mt-2">+ Add More Question</button>
                                            <button type="button" class="btn btn-danger btn-sm removeCategory mt-2 float-end">Remove Category</button>
                                        </div>
                                        <!-- CATEGORY BLOCK END -->

                                    </div>

                                    <div class="text-end">
                                        <button type="button" id="addCategory" class="btn btn-outline-primary mb-3">+ Add Another Category</button><br>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="status">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-control" id="status" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">In Active</option>
                                </select>
                            </div>
                            <!-- <div class="col-md-4" id="degree_highlight_wrapper">
                                                    <label>Degree Highlight Content</label>
                                                    <input type="text" name="degree_highlight_content[]" placeholder="Highlight" required class="form-control">
                                                </div> -->
                            <!-- <div class="col-md-4 d-flex align-items-end">
                                                    <button type="button" id="add_degree_highlight" class="btn btn-outline-primary btn-sm">
                                                        + Add Degree Highlight
                                                    </button>
                                                </div> -->

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

        let categoryIndex = 0;
        $('#addCategory').on('click', function() {
            categoryIndex++;
            let html = `
    <div class="categoryBlock border p-3 mb-4 rounded">
      <div class="mb-3">
        <label class="form-label fw-bold">Category Name</label>
        <input type="text" name="categories[${categoryIndex}][category_name]" class="form-control" placeholder="e.g. Payment, Refund Policy, Privacy Policy">
      </div>

      <div class="faqGroup">
        <h6>Questions</h6>
        <div class="faqItem border p-2 mb-2 rounded">
          <input type="text" name="categories[${categoryIndex}][questions][]" class="form-control mb-2" placeholder="Enter Question">
          <textarea name="categories[${categoryIndex}][answers][]" class="form-control" rows="2" placeholder="Enter Answer"></textarea>
        </div>
      </div>

      <button type="button" class="btn btn-secondary btn-sm addMoreQA mt-2">+ Add More Question</button>
      <button type="button" class="btn btn-danger btn-sm removeCategory mt-2 float-end">Remove Category</button>
    </div>
  `;
            $('#categoryWrapper').append(html);
        });

        $(document).on('click', '.addMoreQA', function() {
            let parent = $(this).closest('.categoryBlock');
            let categoryName = parent.find('input[name^="categories"]').attr('name').match(/\d+/)[0];

            let faqHtml = `
    <div class="faqItem border p-2 mb-2 rounded">
      <input type="text" name="categories[${categoryName}][questions][]" class="form-control mb-2" placeholder="Enter Question">
      <textarea name="categories[${categoryName}][answers][]" class="form-control" rows="2" placeholder="Enter Answer"></textarea>
      <button type="button" class="btn btn-danger btn-sm mt-2 removeFaq">Remove Q/A</button>
    </div>
  `;
            parent.find('.faqGroup').append(faqHtml);
        });

        $(document).on('click', '.removeFaq', function() {
            $(this).closest('.faqItem').remove();
        });

        $(document).on('click', '.removeCategory', function() {
            $(this).closest('.categoryBlock').remove();
        });

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

        // remove field
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

        // remove field
        $(document).on("click", ".removeTransform", function() {
            $(this).closest(".col-md-4").remove();
        });

        $('.summernote').summernote({
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


    let categorySelect = document.getElementById("categorySelect");
    let typeSelect = document.getElementById("typeSelect");

    categorySelect.addEventListener("change", function() {
        let selectedOption = categorySelect.options[categorySelect.selectedIndex];
        let typesJson = selectedOption.getAttribute("data-types");

        // Clear previous types
        typeSelect.innerHTML = '<option value="">-- Select Type --</option>';

        if (typesJson) {
            let types = JSON.parse(typesJson);
            types.forEach(function(type) {
                let option = document.createElement("option");
                option.value = type;
                option.textContent = type.replace(/_/g, " ").replace(/\b\w/g, c => c.toUpperCase());
                typeSelect.appendChild(option);
            });
        }
    });

    var url = "{{ url('statement/fetch') }}/degree/0";

    var onDraw = function() {

    };

    var options = [{
            "data": "id",
            render: function(data, type, full, meta) {
                return `<span>###${meta.row+1}<br/>${full?.created_at}</span>`;
            }
        },
        {
            "data": "type"
        },
        {
            "data": "degree_name"
        },
        {
            "data": "university_name"
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
                return `<button type="button" class="btn btn-primary" onclick="editDetails('${full.id}')"> Edit</button>`;
            }
        }
    ];
    datatableSetup(url, options, onDraw);

    $('#addUniversityBtn').click(function() {
        $('#universityAdd')[0].reset();
        $('#universityAdd').find('input[name="id"]').val('');
        $('#categorySelect').val('').trigger('change');
        $('#typeSelect').empty().append('<option value="">-- Select Type --</option>');
        $('#degree_overview, #key_highlight, #career_outcome, #compare_degree, #free_copilot, #why_should_choose').each(function() {
            $(this).summernote('code', '');
        });

        $('#transFormWrapper').empty().append(`
            <div class="col-md-4 mt-3 d-flex align-items-end">
                <div class="w-100">
                    <label>Transform Your Leadership career</label>
                    <input type="text" name="transform_career[]" placeholder="Enter Transform Your Leadership career" class="form-control" />
                </div>
                <button type="button" class="btn btn-danger btn-sm ms-2 removeTransform" style="height:38px;">✖</button>
            </div>`);

        $('#courseInclusionWrapper').empty().append(`
            <div class="col-md-4 d-flex align-items-end">
                <div class="w-100">
                    <label>Course Inclusions</label>
                    <input type="text" name="course_inclusions[]" placeholder="Course Inclusions" class="form-control" />
                </div>
                <button type="button" class="btn btn-danger btn-sm ms-2 removeField" style="height:38px;">✖</button>
            </div>`);
        $('#addUniversityModal').modal('show');
    });

    function editDetails(id) {
        $('#universityAdd')[0].reset();

        $('#universityAdd').find('input[name="id"]').val('');
        $('#categorySelect').val('').trigger('change');
        $('#typeSelect').empty().append('<option value="">-- Select Type --</option>');
        $('#degree_overview, #key_highlight, #career_outcome, #compare_degree, #free_copilot, #why_should_choose').each(function() {
            $(this).summernote('code', '');
        });
        $('#transFormWrapper').find('.removeTransform').click();
        $('#courseInclusionWrapper').find('.removeField').click();

        $.ajax({
            url: `/university/details/${id}`,
            type: 'GET',
            success: function(res) {
                if (res.success) {
                    let data = res.data;
                    console.log("FAQs Data:", data.faqs);
                    $('#universityAdd').find('input[name="id"]').val(data.id);

                    let categoryName = data.degree_category;
                    $('#categorySelect option').each(function() {
                        if ($(this).text().trim() === categoryName.trim()) {
                            $(this).prop('selected', true);
                        }
                    });
                    $('#categorySelect').trigger('change');

                    $('#typeSelect').empty().append('<option value="' + data.type + '" selected>' + data.type + '</option>');

                    $('#universityAdd').find('input[name="university_name"]').val(data.university_name);
                    $('#universityAdd').find('input[name="degree_name"]').val(data.degree_name);
                    $('#universityAdd').find('input[name="newcourse_1"]').val(data.newcourse_1);
                    $('#universityAdd').find('input[name="newcourse_2"]').val(data.newcourse_2);
                    $('#status').val(data.status).trigger('change');
                    $('#bestseller').val(data.bestseller).trigger('change');
                    $('#universityAdd').find('textarea[name="degree_description"]').val(data.degree_description || '');
                    $('#universityAdd').find('input[name="degree_duration"]').val(data.degree_duration);
                    $('#universityAdd').find('input[name="deadline_date"]').val(data.deadline_date);
                    $('#universityAdd').find('input[name="course_learners"]').val(data.course_learners);
                    $('#universityAdd').find('input[name="course_hours"]').val(data.course_hours);
                    $('#universityAdd').find('input[name="helpline_number"]').val(data.helpline_number);
                    $('#universityAdd').find('input[name="course_starting_at"]').val(data.course_starting_at);
                    $('#universityAdd').find('input[name="course_total_amount"]').val(data.course_total_amount);

                    $('#degree_overview').summernote('code', data.degree_overview || '');
                    $('#key_highlight').summernote('code', data.key_highlight || '');
                    $('#career_outcome').summernote('code', data.career_outcome || '');
                    $('#compare_degree').summernote('code', data.compare_degree || '');
                    $('#free_copilot').summernote('code', data.free_copilot || '');
                    $('#why_should_choose').summernote('code', data.why_should_choose || '');

                    if (data.transform_career && data.transform_career.length > 0) {
                        $('#transFormWrapper').empty();
                        data.transform_career.forEach(function(item) {
                            let html = `
                        <div class="col-md-4 mt-3 d-flex align-items-end">
                            <div class="w-100">
                                <label>Transform Your Leadership career</label>
                                <input type="text" name="transform_career[]" value="${item}" placeholder="Enter Transform Your Leadership career" class="form-control" />
                            </div>
                            <button type="button" class="btn btn-danger btn-sm ms-2 removeTransform" style="height:38px;">✖</button>
                        </div>`;
                            $('#transFormWrapper').append(html);
                        });
                    }

                    if (data.course_inclusions && data.course_inclusions.length > 0) {
                        $('#courseInclusionWrapper').empty();
                        data.course_inclusions.forEach(function(item) {
                            let html = `
                        <div class="col-md-4 d-flex align-items-end">
                            <div class="w-100">
                                <label>Course Inclusions</label>
                                <input type="text" name="course_inclusions[]" value="${item}" placeholder="Course Inclusions" class="form-control" />
                            </div>
                            <button type="button" class="btn btn-danger btn-sm ms-2 removeField" style="height:38px;">✖</button>
                        </div>`;
                            $('#courseInclusionWrapper').append(html);
                        });
                    }
                    if (data.faqs) {
                        let faqsData = typeof data.faqs === "string" ? JSON.parse(data.faqs) : data.faqs;
                        $('#categoryWrapper').empty();

                        faqsData.forEach(function(cat, catIndex) {
                            let faqHtml = `
        <div class="categoryBlock border p-3 mb-4 rounded">
            <div class="mb-3">
                <label class="form-label fw-bold">Category Name</label>
                <input type="text" name="categories[${catIndex}][category_name]" 
                       value="${cat.category_name || ''}" 
                       class="form-control" placeholder="e.g. Payment, Refund Policy, etc.">
            </div>

            <div class="faqGroup">
                <h6>Questions</h6>`;

                            (cat.questions || []).forEach(function(q, qIndex) {
                                faqHtml += `
            <div class="faqItem border p-2 mb-2 rounded">
                <input type="text" name="categories[${catIndex}][questions][]" 
                       value="${q}" class="form-control mb-2" placeholder="Enter Question">
                <textarea name="categories[${catIndex}][answers][]" 
                          class="form-control" rows="2" placeholder="Enter Answer">${(cat.answers && cat.answers[qIndex]) ? cat.answers[qIndex] : ''}</textarea>
            </div>`;
                            });

                            faqHtml += `
            </div>
            <button type="button" class="btn btn-secondary btn-sm addMoreQA mt-2">+ Add More Question</button>
            <button type="button" class="btn btn-danger btn-sm removeCategory mt-2 float-end">Remove Category</button>
        </div>`;

                            $('#categoryWrapper').append(faqHtml);
                        });
                    }


                    $('#addUniversityModal').modal('show');
                } else {
                    notify(res.message || 'University details not found.', 'error');
                }
            },
            error: function(err) {
                console.error("AJAX error:", err);

                let message = 'Something went wrong. Please try again.';
                if (err.responseJSON && err.responseJSON.message) {
                    message = err.responseJSON.message;
                }

                notify(message, 'error');
            }
        });
    }



    $("#universityAdd").validate({
        submitHandler: function() {
            var form = $('form#universityAdd');
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
                        notify(data.message, 'success');
                        $('#datatable').dataTable().api().ajax.reload();
                        $('#addUniversityModal').modal('hide');
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
</script>
@endpush