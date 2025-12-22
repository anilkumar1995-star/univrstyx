@extends('frontend.app')
@section('title', 'Course Fee')
@section('pagetitle', 'Course Fee')

@php
$table = 'yes';
@endphp

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">

            <div class="card shadow-sm bg-light border-0">
                <div class="card-body p-4 text-center">
                    <img src="{{ asset('frontend/images/verticals/Law.webp') }}" 
                         alt="Hobby Class" 
                         class="img-fluid mb-3" 
                         style="max-width: 120px;">
                    
                    <h3 class="fw-bold mb-3">Hobby Class Fee Payment</h3>
                    <p class="text-muted mb-4">Fill student details and pay your hobby class fee securely.</p>

                    <form action="{{ route('submit.fee') }}" id="hobbyForm" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="hobby_fee">
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                        <input type="hidden" name="id">

                        <div class="mb-3 text-start">
                            <label for="student_name" class="form-label">Student Name</label>
                            <input type="text" name="student_name" id="student_name" class="form-control" required>
                        </div>

                        <div class="mb-3 text-start">
                            <label for="dob" class="form-label">Date of Birth</label>
                            <input type="date" name="dob" id="dob" class="form-control" required>
                        </div>

                        <div class="mb-3 text-start">
                            <label for="mobile" class="form-label">Mobile Number</label>
                            <input type="tel" name="mobile" id="mobile" class="form-control" required>
                        </div>

                        <div class="mb-3 text-start">
                            <label for="email" class="form-label">Email (Optional)</label>
                            <input type="email" name="email" id="email" class="form-control">
                        </div>

                        <div class="mb-3 text-start">
                            <label for="class_name" class="form-label">Hobby Class Name</label>
                            <input type="text" name="class_name" id="class_name" class="form-control" required>
                        </div>

                        <div class="mb-3 text-start">
                            <label for="amount" class="form-label">Fee Amount (₹)</label>
                            <input type="number" name="amount" id="amount" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-danger w-100 py-2 fw-bold">
                            Pay Hobby Fee
                        </button>
                    </form>
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