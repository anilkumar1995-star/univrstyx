@extends('layouts.app_new')
@section('title', 'Disclaimer')
@section('pagetitle', 'Disclaimer')

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
                            <a href="{{ route('disclaimer') }}" data-bs-toggle="tooltip" data-bs-placement="top"
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

                                @if (\Myhelper::hasRole('admin')&& !$existdisclaimer)
                                <a href="javascript:void(0)" class="btn btn-primary ms-2" data-bs-toggle="modal"
                                    data-bs-target="#addDisclaimerModal">
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
                                    <th> Disclaimer </th>
                                    <th> Helpline Number </th>
                                    <th> Email </th>
                                    <th> Copyright </th>
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
    <div class="modal fade" id="addDisclaimerModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Disclaimer Details </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="AddDisclaimerForm" enctype="multipart/form-data" action="{{ route('addDisclaimer') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    <input type="hidden" name="id">

                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Disclaimer</label>
                                <textarea class="form-control" name="disclaimer" id="disclaimer"></textarea>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Helpline Number</label>
                                <input type="number" class="form-control" name="helpline" placeholder="Enter helpline Number" id="helpline">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Email Id</label>
                                <input type="email" class="form-control" name="email" placeholder="Enter email Id" id="email">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Copyright</label>
                                <input type="text" class="form-control" name="copyright" id="copyright">
                            </div>
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
    $("#AddDisclaimerForm").validate({
        submitHandler: function() {
            var form = $('form#AddDisclaimerForm');
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
                        $('#addDisclaimerModal').modal('hide');
                    } else {
                        notify(data.message, 'error');
                    }
                },
                error: function(errors) {
                    form.find('button:submit').html('Submit').attr(
                        'disabled',
                        false).removeClass('btn-secondary');
                    notify(errors?.responseJSON?.message ||
                        "Something went wrong",
                        'error');
                }
            });
        }
    });

    function editDetails(id, disclaimer, copyright, status, helpline, email) {

        $('#AddDisclaimerForm').find('[name="id"]').val(id);
        $('#AddDisclaimerForm').find('[name="disclaimer"]').val(disclaimer);
        $('#AddDisclaimerForm').find('[name="copyright"]').val(copyright);
        $('#AddDisclaimerForm').find('[name="status"]').val(status);
        $('#AddDisclaimerForm').find('[name="helpline"]').val(helpline);
        $('#AddDisclaimerForm').find('[name="email"]').val(email);

        $('#addDisclaimerModal').modal('show');
    }
    $(document).ready(function() {
        var url = "{{ url('statement/fetch') }}/disclaimer/0";

        var onDraw = function() {

        };

        var options = [{
                "data": "id",
                render: function(data, type, full, meta) {
                    return `<span>###${meta.row+1}<br/>${full?.created_at}</span>`;
                }
            },
            {
                data: "disclaimer",
                render: function(data, type, full, meta) {
                    if (!data) return '';
                    const maxLength = 50;
                    return data.length > maxLength ?
                        data.substr(0, maxLength) + '...' :
                        data;
                }
            },
            {
                "data": "helpline"
            },
            {
                "data": "email"
            },
            {
                "data": "copyright"
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
                    return `<button type="button" class="btn btn-primary" onclick="editDetails('${full.id}',  \`${full.disclaimer ? full.disclaimer.replace(/`/g, '\\`') : ''}\`,  \`${full.copyright ? full.copyright.replace(/`/g, '\\`') : ''}\`,'${full.status}','${full.helpline}','${full.email}')"> Edit</button>`;
                }
            }
        ];
        datatableSetup(url, options, onDraw);

    });
</script>
@endpush