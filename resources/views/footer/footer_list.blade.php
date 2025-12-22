@extends('layouts.app_new')
@section('title', 'Footer Support List')
@section('pagetitle', 'Footer Support List')

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
                            <a href="{{ route('footerCategoryView') }}" data-bs-toggle="tooltip" data-bs-placement="top"
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
                                    data-bs-toggle="modal" data-bs-target="#addFooterSupportModal">
                                    <i class="ti ti-square-rounded-plus ti-sm"></i> Add Support</a>

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
                                    <th width="20%">Category</th>
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
<div class="modal" id="addFooterSupportModal" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Support</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('addSupport') }}" method="POST" enctype="multipart/form-data" id="supportForm">
                @csrf
                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                <input type="hidden" name="id" id="courseId">

                <div class="modal-body">
                    <div class="row g-3">

                        <div class="card mt-4">

                            <div id="categoryWrapper">
                                <!-- CATEGORY BLOCK START -->
                                <div class="categoryBlock border p-3 mb-4 rounded">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Category Name</label>
                                        <input type="text" name="categories[0][category_name]" class="form-control"
                                            placeholder="e.g. Payment, Refund Policy, Privacy Policy">
                                    </div>

                                    <div class="faqGroup">
                                        <h6>Questions</h6>
                                        <div class="faqItem border p-2 mb-2 rounded">
                                            <input type="text" name="categories[0][questions][]" class="form-control mb-2"
                                                placeholder="Enter Question">
                                            <textarea name="categories[0][answers][]" class="form-control" rows="2"
                                                placeholder="Enter Answer"></textarea>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-secondary btn-sm addMoreQA mt-2">+ Add More Question</button>
                                </div>
                                <!-- CATEGORY BLOCK END -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Status</label>
                            <select name="status" class="form-control" id="status" required>
                                <label for="status">Status</label>
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

@endpush

@push('script')
<script type="text/javascript">
    $(document).ready(function() {

        $(document).on('click', '.editCourseBtn', function() {
            let id = $(this).data('id');

            $.ajax({
                url: "{{ url('footer/support/edit') }}/" + id,
                type: "GET",
                success: function(res) {
                    if (res.status === 'success') {
                        let data = res.data;
                        let categories = JSON.parse(data.support_heading);

                        // reset form
                        $('#supportForm')[0].reset();
                        $('#courseId').val(data.id);
                        $('#status').val(data.status);
                        $('#categoryWrapper').empty();

                        // populate existing categories
                        categories.forEach((cat, i) => {
                            let categoryHtml = `
                    <div class="categoryBlock border p-3 mb-4 rounded">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Category Name</label>
                            <input type="text" name="categories[${i}][category_name]" class="form-control"
                                value="${cat.category_name}">
                        </div>
                        <div class="faqGroup">
                            <h6>Questions</h6>`;

                            cat.questions.forEach((q, qi) => {
                                categoryHtml += `
                        <div class="faqItem border p-2 mb-2 rounded">
                            <input type="text" name="categories[${i}][questions][]" class="form-control mb-2" value="${q}">
                            <textarea name="categories[${i}][answers][]" class="form-control" rows="2"
                                placeholder="Enter Answer">${cat.answers[qi] ?? ''}</textarea>
                                 <button type="button" class="btn btn-danger btn-sm mt-2 removeFaq">Remove Q/A</button>
                        </div>`;
                            });

                            categoryHtml += `
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm addMoreQA mt-2">+ Add More Question</button>
                    </div>`;

                            $('#categoryWrapper').append(categoryHtml);
                        });

                        $('#modalTitle').text('Edit Support');
                        $('#addFooterSupportModal').modal('show');
                    }
                }
            });
        });
$(document).on('click', '[data-bs-target="#addFooterSupportModal"]', function() {
    $('#supportForm')[0].reset();
    $('#modalTitle').text('Add Support');
    $('#courseId').val('');
    $('#categoryWrapper').html(`
        <div class="categoryBlock border p-3 mb-4 rounded">
            <div class="mb-3">
                <label class="form-label fw-bold">Category Name</label>
                <input type="text" name="categories[0][category_name]" class="form-control"
                    placeholder="e.g. Payment, Refund Policy, Privacy Policy">
            </div>

            <div class="faqGroup">
                <h6>Questions</h6>
                <div class="faqItem border p-2 mb-2 rounded">
                    <input type="text" name="categories[0][questions][]" class="form-control mb-2"
                        placeholder="Enter Question">
                    <textarea name="categories[0][answers][]" class="form-control" rows="2"
                        placeholder="Enter Answer"></textarea>
                </div>
            </div>

            <button type="button" class="btn btn-secondary btn-sm addMoreQA mt-2">+ Add More Question</button>
        </div>
    `);
});


        let categoryIndex = 0;
        $(document).on('click', '.addMoreQA', function() {
            let parent = $(this).closest('.categoryBlock');
            let index = parent.find('input[name^="categories"]').attr('name').match(/\d+/)[0];
            let faqHtml = `
        <div class="faqItem border p-2 mb-2 rounded">
            <input type="text" name="categories[${index}][questions][]" class="form-control mb-2" placeholder="Enter Question">
            <textarea name="categories[${index}][answers][]" class="form-control" rows="2" placeholder="Enter Answer"></textarea>
            <button type="button" class="btn btn-danger btn-sm mt-2 removeFaq">Remove Q/A</button>
        </div>
    `;
            parent.find('.faqGroup').append(faqHtml);
        });

        $(document).on('click', '.removeFaq', function() {
            $(this).closest('.faqItem').remove();
        });

    });

    var url = "{{ url('statement/fetch') }}/footersupport/0";

    var onDraw = function() {

    };

    var options = [{
            "data": "id",
            render: function(data, type, full, meta) {
                return `<span>###${meta.row+1}<br/>${full?.created_at}</span>`;
            }
        },
        {
            "data": "support_heading",
            render: function(data, type, full) {
                if (!data) return '-';
                try {
                    const decoded = JSON.parse(data);
                    if (Array.isArray(decoded) && decoded.length > 0) {
                        // Take first category (can loop if multiple)
                        let cat = decoded[0];
                        return `<b>${cat.category_name}</b>`;
                    }
                    return '-';
                } catch (e) {
                    return '-';
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
            "data": "id",
            render: function(data, type, full) {
                return `
                   <button class="btn btn-primary btn-sm editCourseBtn"
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
                        $('#addFooterSupportModal').modal('hide');
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

    $("#supportForm").validate({
        submitHandler: function() {
            var form = $('form#supportForm');
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
                        notify("Support details submitted successfully",
                            'success');
                        $('#addFooterSupportModal').modal('hide');
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
</script>
@endpush