@extends('frontend.app')
@section('title', 'Course Fee')
@section('pagetitle', 'Course Fee')

@php
$table = 'yes';
@endphp

@section('content')
<div class="container mb-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">

            <h2 class="text-center mb-4">Exam Fee Payment</h2>
            <p class="text-center text-muted mb-4">
                Fill student details and pay your exam fee securely.
            </p>

            <form action="{{ route('submit.fee') }}" id="examForm" method="POST">
                <input type="hidden" name="type" value="exam_fee">
                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                <input type="hidden" name="id">
                @csrf

                <div class="card shadow-sm p-4 mb-4">
                    <h5 class="mb-3 text-center">Student & Exam Details</h5>
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label for="student_unique_id" class="form-label">Student Unique ID</label>
                            <input type="text" name="student_unique_id" id="student_unique_id" class="form-control"  required>
                        </div>

                        <div class="col-md-6">
                            <label for="student_name" class="form-label">Student Name</label>
                            <input type="text" name="student_name" id="student_name" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="dob" class="form-label">Date of Birth</label>
                            <input type="date" name="dob" id="dob" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="exam_name" class="form-label">Exam Name</label>
                            <input type="text" name="exam_name" id="exam_name" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="mobile" class="form-label">Mobile Number</label>
                            <input type="tel" name="mobile" id="mobile" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">Email (Optional)</label>
                            <input type="email" name="email" id="email" class="form-control">
                        </div>

                        <div class="col-md-12">
                            <label for="college_name" class="form-label">School / College / University</label>
                            <input type="text" name="college_name" id="college_name" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="amount" class="form-label">Exam Fee Amount (₹)</label>
                            <input type="number" name="amount" id="amount" class="form-control" required>
                        </div>

                        <div class="col-md-12 mt-3">
                            <button type="submit" id="feeBtn" class="btn btn-primary w-100 py-2">Pay Exam Fee</button>
                        </div>

                    </div>
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
        $(document).on("submit", "#examForm", function(e) {
            e.preventDefault();
            let form = $(this);
            let btn = $("#feeBtn");

            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: form.serialize(),
                beforeSend: function() {
                    btn.html("<i class='fa fa-spin fa-spinner'></i> Please wait...").attr("disabled", true);
                },
                success: function(res) {
                    if (res.status == 'success') {
                        notify(res.message, "success");
                        form[0].reset();
                    }
                },
                error: function(xhr) {
                    if (xhr.status == 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMsg = Object.values(errors).flat().join("\n");
                        notify(errorMsg, "error");
                    } else {
                        notify("Something went wrong", "error");
                    }
                },
                complete: function() {
                    btn.html("Pay Exam Fee").attr("disabled", false);
                }
            });
        });

    });
</script>
@endpush