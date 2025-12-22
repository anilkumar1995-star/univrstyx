@extends('layouts.app_new')
@section('title', 'Programme List')
@section('pagetitle', 'Programme List')

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
                            <a href="{{ route('showProgramme') }}" data-bs-toggle="tooltip" data-bs-placement="top"
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
                                <a href="javascript:void(0)" class="btn btn-primary ms-2" id="addProgrammeBtn" data-bs-toggle="modal"
                                    data-bs-target="#addProgrammeModal">
                                    <i class="ti ti-square-rounded-plus ti-sm"></i> Add Programme
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
                                    <th width="20%">#</th>
                                    <th width="25%">Degree Title</th>
                                    <th width="25%">Programme Icon</th>
                                    <th width="15%">Status</th>
                                    <th width="15%">Action</th>
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

    <!-- Add/Edit Programme Modal -->
    <div class="modal fade" id="addProgrammeModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Programmes Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="programmeAdd" enctype="multipart/form-data" action="{{ route('programme') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    <input type="hidden" name="id">

                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Select Category</label>
                                <select id="categorySelect" name="degree_category" class="form-select">
                                    <option value="">-- Select Category --</option>
                                    @foreach ($cat as $cats)
                                    <option value="{{ $cats->id }}"
                                        data-types="{{ $cats->degree_category_type }}">
                                        {{ $cats->degree_category }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Title<span class="text-danger">*</span></label>
                                <input type="text" name="degree_title" class="form-control"
                                    placeholder="Enter Title Name" required>
                            </div>
                            <div class="col-md-4">
                                <label>Description</label>
                                <textarea name="degree_description" class="form-control" rows="3" placeholder="Enter Degree Description"></textarea>
                            </div>
                            <div class="row" id="degreeInclusionWrapper">
                                <div class="col-md-4 d-flex align-items-end">
                                    <div class="w-100">
                                        <label for="degree_inclusions">Inclusions</label>
                                        <input type="text" name="degree_inclusions[]"
                                            placeholder="Degree Inclusions" class="form-control" />
                                    </div>
                                    <button type="button" class="btn btn-danger btn-sm ms-2 removeField"
                                        style="height:38px;">✖</button>
                                </div>
                            </div>
                            <div class="col-md-12 mt-2">
                                <button type="button" id="addDegreeInclusion" class="btn btn-sm btn-primary">+ Add
                                    More</button>
                            </div>
                            <div class="col-md-4">
                                <label> Image</label>
                                <input type="file" name="programme_icon" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="enquiry">Helpline Number</label>
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
                                <h4>Why should you Choose</h4>
                            </div>
                            <div class="col-md-12">
                                <label for="why_should_choose">Why should You Choose </label>
                                <textarea id="why_should_choose" placeholder="Enter Here..." name="why_should_choose"
                                    class="form-control summernote"></textarea>
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
                            <div class="col-md-6">
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
        $("#addDegreeInclusion").click(function() {
            let newField = `
            <div class="col-md-4 d-flex align-items-end mt-2">
                <div class="w-100">
                    <label for="degree_inclusions">Inclusions</label>
                    <input type="text" name="degree_inclusions[]" class="form-control"/>
                </div>
                <button type="button" class="btn btn-danger btn-sm ms-2 removeField" style="height:38px;">✖</button>
            </div>`;
            $("#degreeInclusionWrapper").append(newField);
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

    });


    let categorySelect = document.getElementById("categorySelect");
    let typeSelect = document.getElementById("typeSelect");

    categorySelect.addEventListener("change", function() {
        let selectedOption = categorySelect.options[categorySelect.selectedIndex];
        let typesJson = selectedOption.getAttribute("data-types");

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

    var url = "{{ url('statement/fetch') }}/programmes/0";

    var onDraw = function() {

    };

    var options = [{
            "data": "id",
            render: function(data, type, full, meta) {
                return `<span>###${meta.row+1}<br/>${full?.created_at}</span>`;
            }
        },
        {
            "data": "degree_title"
        },
        {
            "data": "programme_icon",
            render: function(data, type, full) {
                if (data && data !== 'null') {
                    return `<a href="#">
                                    <img src="https://images.incomeowl.in/incomeowl/crm/images/${data}" width="12%" height="12%"/>
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
                return `<button type="button" class="badge btn btn-primary" onclick="editDetails('${full.id}')"> Edit</button>`;
            }
        }
    ];
    datatableSetup(url, options, onDraw);


    $('#addProgrammeBtn').click(function() {
        $('#programmeAdd')[0].reset();

        $('#programmeAdd').find('input[name="id"]').val('');

        $('#degree_overview, #key_highlight, #career_outcome, #compare_degree, #free_copilot, #why_should_choose').each(function() {
            $(this).summernote('code', '');
        });

        $('#degreeInclusionWrapper').empty();
         $('#degreeInclusionWrapper').append(`
        <div class="col-md-4 mb-2">
            <label>Inclusion</label>
            <input type="text" name="degree_inclusion[]" class="form-control" placeholder="Degree Inclusion" required>
        </div>
    `);

        $('#categorySelect').val('').trigger('change');
        $('#programmeAdd').find('select[name="status"]').val('').trigger('change');
        $('#programmeAdd').find('input[name="degree_title"]').val('');
        $('#programmeAdd').find('textarea[name="degree_description"]').val('');
        $('#programmeAdd').find('input[name="helpline_number"]').val('');

        $('#addProgrammeModal').modal('show');
    });



    function editDetails(id) {
        $('#programmeAdd')[0].reset();

        $('#degree_overview, #key_highlight, #career_outcome, #compare_degree, #free_copilot, #why_should_choose').each(function() {
            $(this).summernote('code', '');
        });

        $('#degreeInclusionWrapper').empty();

        $.ajax({
            url: `/programme/details/${id}`,
            type: 'GET',
            success: function(res) {
                if (res.success) {
                    let data = res.data;

                    $('#programmeAdd').find('input[name="id"]').val(data.id);

                    let categoryName = data.degree_category;

                    $('#categorySelect option').each(function() {
                        if ($(this).text().trim() === categoryName.trim()) {
                            $(this).prop('selected', true);
                        }
                    });
                    $('#categorySelect').trigger('change');

                    $('#programmeAdd').find('input[name="degree_title"]').val(data.degree_title);
                    $('#programmeAdd').find('textarea[name="degree_description"]').val(data.degree_description || '');
                    $('#programmeAdd').find('input[name="helpline_number"]').val(data.helpline_number);
                    $('#programmeAdd').find('select[name="status"]').val(data.status).trigger('change');

                    $('#degree_overview').summernote('code', data.degree_overview || '');
                    $('#key_highlight').summernote('code', data.key_highlight || '');
                    $('#career_outcome').summernote('code', data.career_outcome || '');
                    $('#compare_degree').summernote('code', data.compare_degree || '');
                    $('#free_copilot').summernote('code', data.free_copilot || '');
                    $('#why_should_choose').summernote('code', data.why_should_choose || '');

                    if (Array.isArray(data.degree_inclusions) && data.degree_inclusions.length > 0) {
                        data.degree_inclusions.forEach(function(item) {
                            let html = `
                        <div class="col-md-4 d-flex align-items-end mt-2">
                            <div class="w-100">
                                <label>Inclusions</label>
                                <input type="text" name="degree_inclusions[]" value="${item}" class="form-control" />
                            </div>
                            <button type="button" class="btn btn-danger btn-sm ms-2 removeField" style="height:38px;">✖</button>
                        </div>`;
                            $('#degreeInclusionWrapper').append(html);
                        });
                    }

                    $('#degreeInclusionWrapper').off('click', '.removeField').on('click', '.removeField', function() {
                        $(this).closest('.col-md-4').remove();
                    });

                    $('#addProgrammeModal').modal('show');
                } else {
                    alert(res.message);
                }
            },
            error: function(err) {
                console.error(err);
                alert('Something went wrong while fetching programme details.');
            }
        });
    }



    $("#programmeAdd").validate({
        submitHandler: function() {
            var form = $('form#programmeAdd');
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
                        $('#datatable').DataTable().ajax.reload();
                        notify(data.message, 'success');
                        $('#addProgrammeModal').modal('hide');
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