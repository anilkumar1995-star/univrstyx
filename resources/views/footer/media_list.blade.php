@extends('layouts.app_new')
@section('title', 'Media List')
@section('pagetitle', 'Media List')

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
                            <a href="{{ route('ourpresencemedia') }}" data-bs-toggle="tooltip" data-bs-placement="top"
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
                                    data-bs-toggle="modal" data-bs-target="#addMediaModal">
                                    <i class="ti ti-square-rounded-plus ti-sm"></i> Add Media</a>

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
                                    <th width="20%">Media Name</th>
                                    <th width="20%">Media Description</th>
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
<div class="modal" id="addMediaModal" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add Media</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('addMedia') }}" method="POST" enctype="multipart/form-data" id="mediaForm">
                @csrf
                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                <input type="hidden" name="id">

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label>Media Name</label>
                            <input type="text" name="media_name" placeholder="Eg. The Economic Times" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Media Description</label>
                            <input type="text" name="media_description" placeholder="Description" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Media Date</label>
                            <input type="date" name="media_date" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Status</label>
                            <select name="status" class="form-control" id="status">
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

    function editDetails(id, media_name, media_description, media_date, status) {
    // Reset form
    $('#mediaForm')[0].reset();

    // Fill values
    $('#mediaForm').find('[name="id"]').val(id);
    $('#mediaForm').find('[name="media_name"]').val(media_name);
    $('#mediaForm').find('[name="media_description"]').val(media_description);
    $('#mediaForm').find('[name="media_date"]').val(media_date);
    $('#mediaForm').find('[name="status"]').val(status);

    // Change modal title and button
    $('#modalTitle').text('Edit Media');
    $('#mediaForm button[type="submit"]').text('Update Details');

    // Show modal
    $('#addMediaModal').modal('show');
}
$('#addMediaModal').on('hidden.bs.modal', function() {
    $('#mediaForm')[0].reset();
    $('#mediaForm').find('[name="id"]').val('');
    $('#modalTitle').text('Add Media');
    $('#mediaForm button[type="submit"]').text('Submit Details');
});

    $(document).ready(function() {


    });

    var url = "{{ url('statement/fetch') }}/footermedia/0";

    var onDraw = function() {

    };

    var options = [{
            "data": "id",
            render: function(data, type, full, meta) {
                return `<span>###${meta.row+1}<br/>${full?.created_at}</span>`;
            }
        },
        {
            "data": "media_name",
            render: function(data, type, full, meta) {
                return full.media_name ?
                    `<span>${full.media_name}</span>` :
                    `<span class="text-muted">N/A</span>`;
            }
        },

        {
            "data": "media_description",
            render: function(data, type, full, meta) {
                return `<span>${full?.media_description}</span>`;
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
            <button type="button" class="btn btn-sm btn-primary"
                onclick="editDetails(
                    '${full.id}',
                    '${(full.media_name || '').replace(/'/g, "\\'")}',
                    '${(full.media_description || '').replace(/'/g, "\\'")}',
                    '${(full.media_date || '')}',
                    '${full.status}'
                )">
                Edit
            </button>
        `;
    }
}



    ];
    datatableSetup(url, options, onDraw);

    // $("#HideForm").validate({
    //     submitHandler: function() {
    //         var form = $('form#HideForm');
    //         form.ajaxSubmit({
    //             dataType: 'json',
    //             beforeSubmit: function() {
    //                 form.find('button:submit').html('Please wait...').attr(
    //                     'disabled', true).addClass('btn-secondary');
    //             },
    //             success: function(data) {
    //                 form.find('button:submit').html('Submit Details').attr(
    //                     'disabled',
    //                     false).removeClass('btn-secondary');
    //                 if (data.status == "success") {
    //                     form[0].reset();
    //                     $('#datatable').DataTable().ajax.reload();
    //                     notify(data.message,
    //                         'success');
    //                     $('#addFooterSupportModal').modal('hide');
    //                 } else {
    //                     notify(data.status, 'error');
    //                 }
    //             },
    //             error: function(errors) {
    //                 form.find('button:submit').html('Submit Details').attr(
    //                     'disabled',
    //                     false).removeClass('btn-secondary');
    //                 notify(errors?.responseJSON?.message ||
    //                     "Something went wrong",
    //                     'error');
    //             }
    //         });
    //     }
    // });

    $("#mediaForm").validate({
        submitHandler: function() {
            var form = $('form#mediaForm');
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
                        notify("Media details submitted successfully",
                            'success');
                        $('#addMediaModal').modal('hide');
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