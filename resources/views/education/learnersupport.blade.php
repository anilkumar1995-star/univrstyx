@extends('layouts.app_new')
@section('title', 'Learner Support')
@section('pagetitle', 'Learner Support')

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
                            <a href="{{ route('learnersupport') }}" data-bs-toggle="tooltip" data-bs-placement="top"
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

                                @if (\Myhelper::hasRole('admin') && !$existsupport)
                                <a href="javascript:void(0)" class="btn btn-primary ms-2" data-bs-toggle="modal"
                                    data-bs-target="#addLearnersupportModal">
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
                                    <th> Learner Support Heading</th>
                                    <th> Learner Support Content</th>
                                    <th> Get Started</th>
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
    <div class="modal fade" id="addLearnersupportModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Learner Support Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="addLearnersupportForm" enctype="multipart/form-data" action="{{ route('addLearnerSupport') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    <input type="hidden" name="id">

                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Learner Support Heading</label>
                                <input type="text" name="learner_support_heading" id="learner_support_heading"
                                    placeholder="Enter Learner Support Heading" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Learner Support Content</label>
                                <input type="text" name="learner_support_content" id="learner_support_content"
                                    placeholder="Enter Learner Support Content" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Get Started</label>
                                <input type="text" name="get_started" id="get_started"
                                    placeholder="Enter Get Started Text" class="form-control">
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="mb-0">Learner Support Cards</h5>
                        </div>

                        <div id="supportRepeater">
                            <div class="support-item border rounded p-3 mb-3 position-relative bg-light">
                                <button type="button"
                                    class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 remove-support"
                                    style="display: none;">
                                    <i class="fa-solid fa-times"></i>
                                </button>

                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Number</label>
                                        <input type="text" name="number[]" class="form-control" placeholder="e.g. 1400+">
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label">Title</label>
                                        <input type="text" name="title[]" class="form-control"
                                            placeholder="e.g. Hiring Partners">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Description</label>
                                        <textarea name="description[]" class="form-control" rows="2"
                                            placeholder="Enter Description"></textarea>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Image</label>
                                        <input type="file" name="image[]" class="form-control">
                                    </div>

                                    <div class="col-md-12 text-end mt-2">
                                        <button type="button" class="btn btn-sm btn-success add-more-support">
                                            <i class="fa-solid fa-plus"></i> Add More
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-3">

                        <div class="row g-3">
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
    $("#addLearnersupportForm").validate({
        submitHandler: function() {
            var form = $('form#addLearnersupportForm');
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
                        $('#addLearnersupportModal').modal('hide');
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

    function renderSupportItems(numbers, titles, descriptions, images) {

        $("#supportRepeater").html("");

        numbers.forEach((num, index) => {

            let isLast = index === numbers.length - 1;

            let html = `
        <div class="support-item border rounded p-3 mb-3 position-relative bg-light">

            ${index > 0 ? `
                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 remove-support">
                    <i class="fa-solid fa-times"></i>
                </button>
            ` : ""}

            <div class="row g-3">

                <div class="col-md-3">
                    <label class="form-label">Number</label>
                    <input type="text" name="number[]" class="form-control" required value="${num}">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title[]" class="form-control" required value="${titles[index]}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Description</label>
                    <textarea name="description[]" class="form-control" required>${descriptions[index]}</textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label mt-2">Image</label>
                    <input type="file" name="image[]" class="form-control">
                    <input type="hidden" name="old_image[]" value="${images[index]}">
                    ${images[index] ? `<img src="https://images.incomeowl.in/incomeowl/crm/images/${images[index]}" width="80" class="mt-2">` : ""}
                </div>

                ${isLast ? `
                <div class="col-md-12 text-end mt-2">
                    <button type="button" class="btn btn-sm btn-success add-more-support">
                        <i class="fa-solid fa-plus"></i> Add More
                    </button>
                </div>` : ""}
            </div>
        </div>
        `;

            $("#supportRepeater").append(html);
        });
    }


    function editDetails(id) {

        $.ajax({
            url: "/learnersupport/get/" + id,
            type: "GET",
            success: function(res) {

                let d = res.data;

                $('[name="id"]').val(d.id);
                $('[name="learner_support_heading"]').val(d.learner_support_heading);
                $('[name="learner_support_content"]').val(d.learner_support_content);
                $('[name="get_started"]').val(d.get_started);
                $('[name="status"]').val(d.status);

                renderSupportItems(
                    JSON.parse(d.number),
                    JSON.parse(d.title),
                    JSON.parse(d.description),
                    JSON.parse(d.image)
                );

                $("#addLearnersupportModal").modal('show');
            }
        });
    }


    $(document).ready(function() {
        $(document).on('click', '.add-more-support', function() {

            let html = `
    <div class="support-item border rounded p-3 mb-3 position-relative bg-light">

        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 remove-support">
            <i class="fa-solid fa-times"></i>
        </button>

        <div class="row g-3">

            <div class="col-md-3">
                <label class="form-label">Number</label>
                <input type="text" name="number[]" class="form-control" required>
            </div>

            <div class="col-md-3">
                <label class="form-label">Title</label>
                <input type="text" name="title[]" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Description</label>
                <textarea name="description[]" class="form-control" required></textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label mt-2">Image</label>
                <input type="file" name="image[]" class="form-control">
            </div>

            <div class="col-md-12 text-end mt-2">
                <button type="button" class="btn btn-sm btn-success add-more-support">
                    <i class="fa-solid fa-plus"></i> Add More
                </button>
            </div>

        </div>
    </div>
    `;

            $("#supportRepeater").append(html);

            $('.add-more-support').not(':last').remove();
        });


        $(document).on('click', '.remove-support', function() {

            $(this).closest('.support-item').remove();

            if ($('.support-item').length > 0) {
                $('.add-more-support').remove(); 
                $('.support-item:last .row:last').append(`
            <div class="col-md-12 text-end mt-2">
                <button type="button" class="btn btn-sm btn-success add-more-support">
                    <i class="fa-solid fa-plus"></i> Add More
                </button>
            </div>
        `);
            }
        });
        var url = "{{ url('statement/fetch') }}/learnsupport/0";

        var onDraw = function() {

        };

        var options = [{
                "data": "id",
                render: function(data, type, full, meta) {
                    return `<span>###${meta.row+1}<br/>${full?.created_at}</span>`;
                }
            },
            {
                "data": "learner_support_heading"
            },
            {
                "data": "learner_support_content"
            },
            {
                "data": "get_started"
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

    });
</script>
@endpush