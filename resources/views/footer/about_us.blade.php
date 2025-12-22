@extends('layouts.app_new')
@section('title', 'About Us')
@section('pagetitle', 'About Us')

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
                            <a href="{{ route('aboutus') }}" data-bs-toggle="tooltip" title="Refresh">
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
                        <h5 class="mb-0">About Us List</h5>
                        @if (\Myhelper::hasRole('admin'))
                        <a href="javascript:void(0)" id="addAboutUsBtn" type="button" class="btn btn-primary ms-2"
                            data-bs-toggle="modal" data-bs-target="#addAboutUsModal">
                            <i class="ti ti-square-rounded-plus ti-sm"></i> Add About Us
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
<div class="modal fade" id="addAboutUsModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('addAboutUs') }}" method="POST" enctype="multipart/form-data" id="aboutUsForm">
                @csrf
                <input type="hidden" name="id">
                <input type="hidden" name="user_id" value="{{ Auth::id() }}">


                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add / Edit About Us</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control" placeholder="eg. About Us ">
                        </div>
                        <div class="col-md-6">
                            <label>Main Heading(eg. Meet Our Founders)</label>
                            <input type="text" name="main_heading" class="form-control" placeholder="eg. Meet Our Founders">
                        </div>
                        <!-- Hero Section -->
                        <h5 class="mt-3 mb-2 text-primary border-bottom pb-2">Hero Section</h5>
                        <div class="col-md-6">
                            <label>Heading</label>
                            <input type="text" name="heading" class="form-control" placeholder="We are South Asia’s Premier Higher EdTech Platform.">
                        </div>

                        <div class="col-md-6">
                            <label>Short Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Empowering over 10 million learners globally..."></textarea>
                        </div>

                        <div class="col-md-6">
                            <label>Button Text</label>
                            <input type="text" name="button_text" class="form-control" placeholder="Talk to a career expert">
                        </div>
                        <div class="col-md-6">
                            <label>Button Number</label>
                            <input type="number" name="button_number" class="form-control" placeholder="eg. 98765 43210">
                        </div>

                        <div class="col-md-6">
                            <label>Image</label>
                            <input type="file" name="hero_image" class="form-control">
                        </div>

                        <!-- Founders Section -->
                        <h5 class="mt-4 mb-2 text-primary border-bottom pb-2">Founders Section</h5>

                        <div id="founders-wrapper">
                            <div class="founder-item border rounded p-3 mb-3">
                                <div class="row g-3 align-items-end">
                                    <div class="col-md-4">
                                        <label>Founder Image</label>
                                        <input type="file" name="founders[0][image]" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Founder Name</label>
                                        <input type="text" name="founders[0][name]" class="form-control" placeholder="Ronnie Screwvala">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Founder Role</label>
                                        <input type="text" name="founders[0][role]" class="form-control" placeholder="Co-Founder & Chairperson">
                                    </div>
                                    <div class="col-md-12">
                                        <label>Award / Description</label>
                                        <input type="text" name="founders[0][award]" class="form-control" placeholder="Named in ‘Asia’s 25 Most Powerful People’ by Fortune Magazine">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="button" id="addFounderBtn" class="btn btn-sm btn-outline-primary">
                                + Add Another Founder
                            </button>
                        </div>

                        <div class="col-md-4 mt-4">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        Submit Details
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $(document).ready(function() {

        $('#addAboutUsModal').on('hidden.bs.modal', function() {
            $('#aboutUsForm')[0].reset();
            $('#founders-wrapper').empty();
            founderIndex = 0;

            $('#founders-wrapper').append(`
            <div class="founder-item border rounded p-3 mb-3">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label>Founder Image</label>
                        <input type="file" name="founders[0][image]" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label>Founder Name</label>
                        <input type="text" name="founders[0][name]" class="form-control" placeholder="Ronnie Screwvala">
                    </div>
                    <div class="col-md-4">
                        <label>Founder Role</label>
                        <input type="text" name="founders[0][role]" class="form-control" placeholder="Co-Founder & Chairperson">
                    </div>
                    <div class="col-md-12">
                        <label>Award / Description</label>
                        <input type="text" name="founders[0][award]" class="form-control" placeholder="Named in ‘Asia’s 25 Most Powerful People’ by Fortune Magazine">
                    </div>
                </div>
            </div>
        `);
        });

    });

    function editDetails(id) {
        $.ajax({
            url: `about-us/${id}/edit`,
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.status === "success") {
                    const data = response.data;
                    $('input[name="id"]').val(data.id);
                    $('input[name="title"]').val(data.title);
                    $('input[name="main_heading"]').val(data.main_heading);
                    $('input[name="heading"]').val(data.heading);
                    $('textarea[name="description"]').val(data.description);
                    $('input[name="button_text"]').val(data.button_text);
                    $('input[name="button_number"]').val(data.button_number);
                    $('select[name="status"]').val(data.status).trigger('change');


                    $('#founders-wrapper').empty();

                    if (Array.isArray(data.founders) && data.founders.length > 0) {
                        data.founders.forEach((f, i) => {
                            $('#founders-wrapper').append(`
              <div class="founder-item border rounded p-3 mb-3">
                <div class="row g-3 align-items-end">
                  <div class="col-md-4">
                    <label>Founder Image</label>
                    <input type="file" name="founders[${i}][image]" class="form-control">
                  </div>
                  <div class="col-md-4">
                    <label>Founder Name</label>
                    <input type="text" name="founders[${i}][name]" class="form-control" value="${f.name || ''}">
                  </div>
                  <div class="col-md-3">
                    <label>Founder Role</label>
                    <input type="text" name="founders[${i}][role]" class="form-control" value="${f.role || ''}">
                  </div>
                  <div class="col-md-12">
                    <label>Award / Description</label>
                    <input type="text" name="founders[${i}][award]" class="form-control" value="${f.award || ''}">
                  </div>
                  <div class="col-md-12 text-end">
                    <button type="button" class="btn btn-danger btn-sm remove-founder">Remove</button>
                  </div>
                </div>
              </div>
            `);
                        });
                    }

                    $('#addAboutUsModal').modal('show');

                } else {
                    alert(response.message || 'Unable to load data');
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('Error loading data');
            }
        });
    }




    let founderIndex = 1;

    $('#addFounderBtn').on('click', function() {
        let newFounder = `
    <div class="founder-item border rounded p-3 mb-3 position-relative">
      <!-- Remove Button -->
      <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 remove-founder" title="Remove Founder">
        <i class="fa fa-times"></i>
      </button>

      <div class="row g-3 align-items-end mt-2">
        <div class="col-md-4">
          <label>Founder Image</label>
          <input type="file" name="founders[${founderIndex}][image]" class="form-control">
        </div>
        <div class="col-md-4">
          <label>Founder Name</label>
          <input type="text" name="founders[${founderIndex}][name]" class="form-control" placeholder="Founder Name">
        </div>
        <div class="col-md-4">
          <label>Founder Role</label>
          <input type="text" name="founders[${founderIndex}][role]" class="form-control" placeholder="Co-Founder">
        </div>
        <div class="col-md-12">
          <label>Award / Description</label>
          <input type="text" name="founders[${founderIndex}][award]" class="form-control" placeholder="Award / Recognition">
        </div>
      </div>
    </div>`;

        $('#founders-wrapper').append(newFounder);
        founderIndex++;
    });

    $(document).on('click', '.remove-founder', function() {
        $(this).closest('.founder-item').remove();
    });


    var url = "{{ url('statement/fetch') }}/aboutus/0";

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

    $("#aboutUsForm").validate({
        submitHandler: function() {
            var form = $('form#aboutUsForm');
            form.ajaxSubmit({
                dataType: 'json',
                beforeSubmit: function() {
                    form.find('button:submit').html('Please wait...').attr('disabled', true).addClass('btn-secondary');
                },
                success: function(data) {
                    form.find('button:submit').html('Submit Details').attr('disabled', false).removeClass('btn-secondary');
                    if (data.status == "success") {
                        form[0].reset();
                        $('#datatable').DataTable().ajax.reload();
                        notify("About Us details saved successfully", 'success');
                        $('#addAboutUsModal').modal('hide');
                    } else {
                        notify(data.status, 'error');
                    }
                },
                error: function(errors) {
                    form.find('button:submit').html('Submit Details').attr('disabled', false).removeClass('btn-secondary');
                    notify(errors?.responseJSON?.message || "Something went wrong", 'error');
                }
            });
        }
    });
</script>
@endpush