@extends('layouts.app_new')
@section('title', 'Grievance List')
@section('pagetitle', 'Grievance List')

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
                            <a href="{{ route('grievance.list') }}" data-bs-toggle="tooltip" data-bs-placement="top"
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
                                    <th width="15%">#</th>
                                    <th width="15%">Name</th>
                                    <th width="20%">Email</th>
                                    <th width="15%">Mobile</th>
                                    <th width="15%">Alternate Mobile</th>
                                    <th width="15%">Subject</th>
                                    <th width="15%">Message</th>
                                    <th width="15%">Reply Message</th>
                                    <th width="15%">Attchment</th>
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
</div>

<div class="modal fade" id="replyModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reply to Grievance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form id="replyForm">
                    @csrf
                    <input type="hidden" name="id" id="grievance_id">

                    <div class="mb-3">
                        <label class="form-label">Student Message</label>
                        <textarea class="form-control" id="student_message" rows="3" readonly></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Reply Message</label>
                        <textarea class="form-control" name="reply_message" id="reply_message" rows="4"
                            placeholder="Write your reply..."></textarea>
                    </div>

                    <button type="submit" id="replySubmitBtn" class="btn btn-primary">Submit Reply</button>
                </form>

            </div>

        </div>
    </div>
</div>



@endsection

@push('script')
<script type="text/javascript">
    $(document).ready(function() {

        $(document).on("click", ".editCourseBtn", function() {
            let id = $(this).data("id");

            $.ajax({
                url: "{{ url('grievance/get') }}/" + id,
                type: "GET",
                success: function(res) {
                    $("#grievance_id").val(res.id);
                    $("#student_message").val(res.message);
                    $("#reply_message").val(res.reply_message ?? '');
                    $("#replyModal").modal("show");
                }
            });
        });

        $(document).on("submit", "#replyForm", function(e) {
            e.preventDefault();

            let form = $(this)[0];
            let btn = $("#replySubmitBtn");
            let formData = new FormData(form);

            $.ajax({
                url: "{{ route('grievance.reply') }}",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,

                beforeSend: function() {
                    btn.html("<i class='fa fa-spinner fa-spin'></i> Please wait...")
                        .attr("disabled", true);
                },

                success: function(res) {

                    if (res.success === true) {

                        notify("Reply sent successfully!", "success");

                        let modalEl = document.getElementById("replyModal");
                        let modal = bootstrap.Modal.getInstance(modalEl);

                        if (!modal) modal = new bootstrap.Modal(modalEl);

                        modal.hide();

                        $("#replyForm")[0].reset();

                        $("#datatable").DataTable().ajax.reload(null, false);

                    } else {
                        notify("Something went wrong", "error");
                    }
                },

                error: function(xhr) {
                    if (xhr.status === 422) {
                        let err = xhr.responseJSON.errors;
                        let first = Object.values(err)[0][0];
                        notify(first, "error");

                    } else if (xhr.status === 404) {
                        notify(xhr.responseJSON.message, "error");

                    } else {
                        notify("Server error", "error");
                    }
                },

                complete: function() {
                    btn.html("Submit Reply").attr("disabled", false);
                }
            });
        });

        var url = "{{ url('statement/fetch') }}/grievance/0";

        var onDraw = function() {

        };

        var options = [{
                "data": "id",
                render: function(data, type, full, meta) {
                    return `<span>###${meta.row+1}<br/>${full?.created_at}</span>`;
                }
            },

            {
                "data": "name"
            },
            {
                "data": "email"
            },
            {
                "data": "mobile"
            },
            {
                "data": "alt_mobile",
                render: function(data, type, full) {
                    return data ? data : '<span class="text-muted">N/A</span>';
                }
            },
            {
                "data": "subject"
            },
            {
                "data": "message"
            },
            {
                "data": "reply_message",
                render: function(data, type, full) {
                    return data ? data : '<span class="text-muted">N/A</span>';
                }
            },
            {
                "data": "attachment",
                render: function(data, type, full) {
                    if (data && data !== 'null') {
                        return `<a href="#">
                                    <img src="https://images.incomeowl.in/incomeowl/crm/images/${data}" />
                                </a>`;
                    } else {
                        return `<a href="#">
                                    <img src="{{ asset('img/noimg.png') }}"/>
                                </a>`;
                    }
                }
            },
            {
                "data": "status",
                render: function(data, type, full, meta) {
                    if (full.status == 'pending') {
                        return `<span class="badge badge-warning">Pending</span>`;
                    } else {
                        return `<span class="badge badge-success">Resolved</span>`;
                    }

                }
            },
            {
                data: "action",
                render: function(data, type, full) {

                    @if(Myhelper::hasRole(['admin']))
                    return `<button type="button" 
                    class="btn btn-primary btn-sm editCourseBtn" 
                    data-id="${full.id}">Reply</button>`;
                    @else
                    return `N/A`;
                    @endif

                }
            }

        ];
        datatableSetup(url, options, onDraw);
    });
</script>
@endpush