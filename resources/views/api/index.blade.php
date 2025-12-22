@extends('layouts.app_new')
@section('title', 'Api List')
@section('pagetitle', 'Api List')

@php
    $table = 'yes';
@endphp

@section('content')
    <div class="content">
        <div class="row">
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-4">
                    <h4 class="page-title">@yield('pagetitle')<span class="count-title">All</span></h4>
                    </div>
                    <div class="col-8 text-end">
                        <div class="head-icons">
                            <a href="{{ route('apilog') }}" data-bs-toggle="tooltip" data-bs-placement="top"
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
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header justify-content-between">
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
                                        <th class="sorting">Id</th>
                                        <th class="sorting">URL</th>
                                        <th class="sorting">Request</th>
                                        <th class="sorting">Response</th>
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


@endsection

@push('style')
@endpush
@push('script')
    <script type="text/javascript">
        $(document).ready(function() {

            var url = "{{ url('statement/fetch') }}/apilogs/0";
            var onDraw = function() {};

            var options = [{
                    "data": "id",
                    render: function(data, type, full, meta) {
                        return `<span>###${full?.id}<br/>${full?.created_at}</span>`;
                    }
                },
                {
                    "data": "url",
                    render: function(data, type, full, meta) {
                        return `<span>${full?.url}</span>`;
                    }
                },
                {
                    "data": "request",
                    render: function(data, type, full, meta) {
                        return `<span>${full?.request}</span>`;
                    }
                },
                {
                    "data": "response",
                    render: function(data, type, full, meta) {
                        return `<span>${full?.response}</span>`;
                    }
                },
            ];
            datatableSetup(url, options, onDraw, '#datatable', {
                searching: true,
                columnDefs: [{
                    orderable: false,
                    searchable: false,
                    width: '80px',
                    targets: [0]
                }]
            });


        });
    </script>
@endpush
