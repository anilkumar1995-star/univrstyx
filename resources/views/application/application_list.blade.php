@extends('layouts.app_new')
@section('title', 'Application List')
@section('pagetitle', 'Application List')

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
                            <a href="{{ route('application.list') }}" data-bs-toggle="tooltip" data-bs-placement="top"
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
                    <!-- /Filter -->
                    <div class="table-responsive custom-table">
                        <table class="table" id="datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th width="15%">#</th>
                                    <th width="15%">Course Name</th>
                                    <th width="20%">Name</th>
                                    <th width="15%">Father Name</th>
                                    <th width="15%">Gender</th>
                                    <th width="15%">DOB</th>
                                    <th width="15%">Mobile No.</th>
                                    <th width="15%">Email</th>
                                    <th width="15%">City</th>
                                    <th width="15%">Payment Status</th>
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




@endsection

@push('style')
<style>

</style>
@endpush

@push('script')
<script type="text/javascript">
    $(document).ready(function() {

        var url = "{{ url('statement/fetch') }}/applications/0";

        var onDraw = function() {

        };

        var options = [{
                "data": "id",
                render: function(data, type, full, meta) {
                    return `<span>###${meta.row+1}<br/>${full?.created_at}</span>`;
                }
            },
            {
                "data": "course.degree_name",
                "name": "course.degree_name",
                render: function(data, type, full) {
                    return data ? data : '<span class="text-muted">N/A</span>';
                }
            },
            {
                "data": "name"
            },
            {
                "data": "father_name"
            },
            {
                "data": "gender"
            },
            {
                "data": "dob"
            },
            {
                "data": "phone"
            },
            {
                "data": "email"
            },
            {
                "data": "city"
            },
            {
                "data": "payment_status"
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
                render: function(data, type, full) {
                    return `
                        <button type="button" 
                            class="btn btn-primary btn-sm editCourseBtn" 
                            data-id="${full.id}">
                            Edit
                        </button>`;
                }
            }


        ];
        datatableSetup(url, options, onDraw);



    });
</script>
@endpush