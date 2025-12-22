@extends('layouts.app_new')
@section('title', 'Contact Us')
@section('pagetitle', 'Contact Us')

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
                            <a href="{{ route('contactus') }}" data-bs-toggle="tooltip" title="Refresh">
                                <i class="ti ti-refresh-dot"></i>
                            </a>
                            <a href="javascript:void(0);" data-bs-toggle="tooltip" title="Collapse" id="collapse-header">
                                <i class="ti ti-chevrons-up"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Card -->
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Contact Us List</h5>
                        @if (\Myhelper::hasRole('admin'))
                        <a href="javascript:void(0)" id="addContactUsBtn" type="button" class="btn btn-primary ms-2"
                            data-bs-toggle="modal" data-bs-target="#addContactUsModal">
                            <i class="ti ti-square-rounded-plus ti-sm"></i> Add Contact Us
                        </a>
                        @endif
                    </div>
                </div>

                <div class="card-body">
                    @include('layouts.pageheader')

                    <div class="table-responsive custom-table">
                        <table class="table" id="datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th width="10%">#</th>
                                    <th>Heading</th>
                                    <th>Description</th>
                                    <th>Button</th>
                                    <th>Status</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit About Us Modal -->
<div class="modal fade" id="addContactUsModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('addContactUs') }}" method="POST" id="contactUsForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id">
                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                <div class="modal-header">
                    <h5 class="modal-title">Add / Edit Contact Us</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <h5 class="text-primary mb-3 border-bottom pb-2">Contct Us Section</h5>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label>Title</label>
                            <input type="text" name="heading" class="form-control"
                                placeholder="Contact Us">
                        </div>

                        <div class="col-md-6">
                            <label>Short Description</label>
                            <textarea name="description" class="form-control" rows="3"
                                placeholder="iUniversity is an online higher education platform..."></textarea>
                        </div>

                        <div class="col-md-6">
                            <label>Button Text</label>
                            <input type="text" name="button_text" class="form-control"
                                placeholder="Talk to a Counsellor">
                        </div>
                        <div class="col-md-6">
                            <label>Button Number</label>
                            <input type="text" name="button_number" class="form-control"
                                placeholder="9999999999">
                        </div>

                        <div class="col-md-6">
                            <label>Image</label>
                            <input type="file" name="contact_image" class="form-control">
                        </div>
                    </div>

                    <hr class="my-4">
                    <h5 class="text-primary mb-3 border-bottom pb-2">Call or Email Section</h5>

                    <div id="program-wrapper">
                        <div class="program-item border rounded p-3 mb-3">
                            <div class="row g-3 align-items-end">

                                <div class="col-md-4">
                                    <label>Text</label>
                                    <input type="text" name="programs[0][text]" class="form-control"
                                        placeholder="Program Related Queries">
                                </div>

                                <div class="col-md-4">
                                    <label>Phone Number</label>
                                    <input type="text" name="programs[0][phone]" class="form-control"
                                        placeholder="1800 210 2020">
                                </div>

                                <div class="col-md-4">
                                    <label>Email</label>
                                    <input type="text" name="programs[0][email]" class="form-control"
                                        placeholder="customercare@iuniversity.com">
                                </div>

                                <div class="col-md-12 text-end mt-2">
                                    <button type="button" class="btn btn-sm btn-danger removeProgramBtn d-none">
                                        Remove
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="button" id="addProgramBtn" class="btn btn-sm btn-outline-primary">
                            + Add Another Program Query
                        </button>
                    </div>

                    <hr class="my-4">
                    <h5 class="text-primary mb-3 border-bottom pb-2">Our Offices</h5>

                    <div id="office-wrapper">
                        <div class="office-item border rounded p-3 mb-3">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label>Office City</label>
                                    <input type="text" name="offices[0][city]" class="form-control"
                                        placeholder="Mumbai">
                                </div>

                                <div class="col-md-4">
                                    <label>Office Image</label>
                                    <input type="file" name="offices[0][image]" class="form-control">
                                </div>

                                <div class="col-md-12">
                                    <label>Address</label>
                                    <textarea name="offices[0][address]" class="form-control" rows="2"
                                        placeholder="3rd Floor, CTS-756 & Fleet Building..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="addOfficeBtn" class="btn btn-outline-primary btn-sm mb-3">
                        + Add Another Office
                    </button>

                    <div class="col-md-4 mt-3">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Submit Details</button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    $(document).ready(function() {

        let programIndex = 1;

        $("#addProgramBtn").click(function() {
            let html = `
        <div class="program-item border rounded p-3 mb-3">
            <div class="row g-3 align-items-end">

                <div class="col-md-4">
                    <label>Text</label>
                    <input type="text" name="programs[${programIndex}][text]" class="form-control"
                        placeholder="Program Related Queries">
                </div>

                <div class="col-md-4">
                    <label>Phone Number</label>
                    <input type="text" name="programs[${programIndex}][phone]" class="form-control"
                        placeholder="1800 210 2020">
                </div>

                <div class="col-md-4">
                    <label>Email</label>
                    <input type="text" name="programs[${programIndex}][email]" class="form-control"
                        placeholder="customercare@iuniversity.com">
                </div>

                <div class="col-md-12 text-end mt-2">
                    <button type="button" class="btn btn-sm btn-danger removeProgramBtn">
                        Remove
                    </button>
                </div>

            </div>
        </div>`;

            $("#program-wrapper").append(html);
            programIndex++;
        });

        $(document).on("click", ".removeProgramBtn", function() {
            $(this).closest(".program-item").remove();
        });

        let officeIndex = 1;

        $("#addOfficeBtn").click(function() {

            let html = `
        <div class="office-item border rounded p-3 mb-3">
            <div class="row g-3">

                <div class="col-md-4">
                    <label>Office City</label>
                    <input type="text" name="offices[${officeIndex}][city]" 
                           class="form-control" placeholder="Mumbai">
                </div>

                <div class="col-md-4">
                    <label>Office Image</label>
                    <input type="file" name="offices[${officeIndex}][image]" class="form-control">
                </div>

                <div class="col-md-12">
                    <label>Address</label>
                    <textarea name="offices[${officeIndex}][address]" 
                              class="form-control" rows="2"
                              placeholder="3rd Floor, CTS-756 & Fleet Building..."></textarea>
                </div>

                <div class="col-md-12 text-end">
                    <button type="button" class="btn btn-sm btn-danger removeOfficeBtn mt-2">
                        Remove
                    </button>
                </div>

            </div>
        </div>`;

            $("#office-wrapper").append(html);
            officeIndex++;
        });


        $(document).on("click", ".removeOfficeBtn", function() {
            $(this).closest(".office-item").remove();
        });

        $('#addContactUsBtn').on('click', function () {

    // RESET FORM
    $('#contactUsForm')[0].reset();

    // CLEAR ID (important for insert mode)
    $('input[name="id"]').val('');

    // Reset Select2 fields if any
    $('select[name="status"]').val('active').trigger('change');

    // RESET PROGRAMS SECTION
    $('#program-wrapper').html(`
        <div class="program-item border rounded p-3 mb-3">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label>Text</label>
                    <input type="text" name="programs[0][text]" class="form-control"
                        placeholder="Program Related Queries">
                </div>

                <div class="col-md-4">
                    <label>Phone Number</label>
                    <input type="text" name="programs[0][phone]" class="form-control"
                        placeholder="1800 210 2020">
                </div>

                <div class="col-md-4">
                    <label>Email</label>
                    <input type="text" name="programs[0][email]" class="form-control"
                        placeholder="customercare@iuniversity.com">
                </div>

                <div class="col-md-12 text-end mt-2">
                    <button type="button" class="btn btn-sm btn-danger removeProgramBtn d-none">Remove</button>
                </div>
            </div>
        </div>
    `);

    // RESET OFFICES SECTION
    $('#office-wrapper').html(`
        <div class="office-item border rounded p-3 mb-3">
            <div class="row g-3">
                <div class="col-md-4">
                    <label>Office City</label>
                    <input type="text" name="offices[0][city]" class="form-control"
                        placeholder="Mumbai">
                </div>

                <div class="col-md-4">
                    <label>Office Image</label>
                    <input type="file" name="offices[0][image]" class="form-control">
                </div>

                <div class="col-md-12">
                    <label>Address</label>
                    <textarea name="offices[0][address]" class="form-control" rows="2"
                        placeholder="3rd Floor, CTS-756 & Fleet Building..."></textarea>
                </div>
            </div>
        </div>
    `);

});


    });

    function editDetails(id) {

        $.ajax({
            url: `contact-us/${id}/edit`,
            type: "GET",
            dataType: "json",

            success: function(response) {

                if (response.status !== "success") {
                    return alert("Error loading data");
                }

                const data = response.data;

                // BASIC FIELDS
                $('input[name="id"]').val(data.id);
                $('input[name="heading"]').val(data.heading);
                $('textarea[name="description"]').val(data.description);
                $('input[name="button_text"]').val(data.button_text);
                $('input[name="button_number"]').val(data.button_number);
                $('select[name="status"]').val(data.status).trigger('change');

                
                $("#program-wrapper").empty();

                if (Array.isArray(data.programs)) {

                    data.programs.forEach((p, i) => {

                        $("#program-wrapper").append(`
                        <div class="program-item border rounded p-3 mb-3">

                            <div class="row g-3">

                                <div class="col-md-4">
                                    <label>Text</label>
                                    <input type="text" name="programs[${i}][text]" class="form-control" value="${p.text}">
                                </div>

                                <div class="col-md-4">
                                    <label>Phone Number</label>
                                    <input type="text" name="programs[${i}][phone]" class="form-control" value="${p.phone}">
                                </div>

                                <div class="col-md-4">
                                    <label>Email</label>
                                    <input type="text" name="programs[${i}][email]" class="form-control" value="${p.email}">
                                </div>

                                <div class="col-md-12 text-end mt-2">
                                    <button type="button" class="btn btn-danger btn-sm removeProgramBtn">
                                        Remove
                                    </button>
                                </div>

                            </div>
                        </div>
                    `);
                    });
                }

                /*---------------------------------------------
                    OFFICES SECTION
                ---------------------------------------------*/
                $("#office-wrapper").empty();

                if (Array.isArray(data.offices)) {

                    data.offices.forEach((o, i) => {

                        $("#office-wrapper").append(`
                        <div class="office-item border rounded p-3 mb-3">

                            <div class="row g-3">

                                <div class="col-md-4">
                                    <label>Office City</label>
                                    <input type="text" name="offices[${i}][city]" class="form-control" value="${o.city}">
                                </div>

                                <div class="col-md-4">
                                    <label>Office Image</label>
                                    <input type="file" name="offices[${i}][image]" class="form-control">

                                    ${o.image ? `
                                        <img src="https://images.incomeowl.in/incomeowl/crm/images/${o.image}"
                                             class="img-fluid rounded mt-2"
                                             width="120">
                                    ` : ""}

                                </div>

                                <div class="col-md-12">
                                    <label>Address</label>
                                    <textarea name="offices[${i}][address]" class="form-control" rows="2">${o.address}</textarea>
                                </div>
                                 <div class="col-md-12 text-end">
                                <button type="button" class="btn btn-sm btn-danger removeOfficeBtn mt-2">
                                    Remove
                                </button>
                            </div>

                            </div>

                        </div>
                    `);
                    });
                }

                // SHOW MODAL
                $("#addContactUsModal").modal("show");
            },

            error: function(err) {
                console.error(err.responseText);
                alert("Error loading data");
            }
        });
    }



    var url = "{{ url('statement/fetch') }}/contactus/0";

    var onDraw = function() {

    };

    var options = [{
            "data": "id",
            render: function(data, type, full, meta) {
                return `<span>###${meta.row+1}<br/>${full?.created_at}</span>`;
            }
        },
        {
            data: "heading",
            render: function(data, type, full, meta) {
                return full.heading ?
                    `<span>${full.heading}</span>` :
                    `<span class="text-muted">N/A</span>`;
            }
        },
        {
            "data": "description",
            render: function(data, type, full, meta) {
                return full.description ?
                    `<span>${full.description}</span>` :
                    `<span class="text-muted">N/A</span>`;
            }
        },

        {
            "data": "button_text",
            render: function(data, type, full, meta) {
                return `<span>${full?.button_text}</span>`;
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
            data: "id",
            render: function(data, type, full) {
                return `
                <button type="button" class="btn btn-sm btn-primary"
                    onclick="editDetails('${full.id}')">
                    <i class="bi bi-pencil"></i> Edit
                </button>`;
            }
        }

    ];
    datatableSetup(url, options, onDraw);



   $("#contactUsForm").validate({
    submitHandler: function() {
        var form = $('form#contactUsForm');
        form.ajaxSubmit({
            dataType: 'json',
            beforeSubmit: function() {
                form.find('button:submit')
                    .html('Please wait...')
                    .attr('disabled', true)
                    .addClass('btn-secondary');
            },
            success: function(data) {

                form.find('button:submit')
                    .html('Submit Details')
                    .attr('disabled', false)
                    .removeClass('btn-secondary');

                if (data.status == "success") {
                    form[0].reset();
                    $('#datatable').DataTable().ajax.reload();
                    notify(data.message, 'success'); 
                    $('#addContactUsModal').modal('hide');
                } else {
                    notify(data.message, 'error'); 
                }
            },
            error: function(errors) {

                form.find('button:submit')
                    .html('Submit Details')
                    .attr('disabled', false)
                    .removeClass('btn-secondary');

                notify(errors?.responseJSON?.message || "Something went wrong", 'error');
            }
        });
    }
});

</script>
@endpush