@extends('layouts.app_new')
@section('title', 'Primary Color')
@section('pagetitle', 'Primary Color')

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
                            <a href="{{ route('primary.list') }}" data-bs-toggle="tooltip" data-bs-placement="top"
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
                                    data-bs-toggle="modal" data-bs-target="#addPrimaryColorModal">
                                    <i class="ti ti-square-rounded-plus ti-sm"></i> Add Primary Color</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    @include('layouts.pageheader')


                </div>
            </div>
        </div>

        <!-- Add/Edit PrimaryColorModal -->
        <div class="modal" id="addPrimaryColorModal" tabindex="-1" role="dialog" aria-hidden="true"
            data-bs-backdrop="static">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Add Primary Color</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"></span>
                        </button>
                    </div>

                    <form action="{{ route('addPrimaryColor') }}" method="POST" enctype="multipart/form-data" id="primaryColorForm">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                        <input type="hidden" name="id" value="">
                        <div class="modal-body">

                            <div class="row g-3">

                                <div class="col-md-12">
                                    <label for="primary_color">Primary Color</label>
                                    <input type="color" name="primary_color" id="primary_color" value="{{ env('PRIMARY_COLOR', '#eb263d') }}" class="form-control"
                                        required placeholder="Enter Primary Color">
                                </div>


                                <div class="modal-footer">
                                    <button class="btn btn-primary" type="submit"
                                        data-loading-text="<i class='fa fa-spin fa-spinner'></i> Submitting">Submit
                                    </button>
                                </div>
                    </form>
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


        $("#primaryColorForm").validate({
            submitHandler: function() {
                var form = $('form#primaryColorForm');
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
                        if (data.success) {
                            form[0].reset();
                            notify(data.message, 'success');
                            $('#addPrimaryColorModal').modal('hide');
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


    });
</script>
@endpush