@extends('frontend.app')
@section('title', 'Grievance Redressal' )
@section('content')
<style>
    .grievance-banner {
        background: url('{{ asset("frontend/images/grievance-bg.jpg") }}') center/cover no-repeat;
        height: 180px;
        position: relative;
    }

    .grievance-banner::after {
        content: "";
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.65);
    }

    .grievance-banner h1 {
        z-index: 2;
        font-size: 42px;
        font-weight: 600;
    }

    .form-box {
        background: #ffffff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.15);
    }

</style>

<div class="grievance-banner d-flex align-items-center justify-content-center text-white">
    <h1>iUniversity</h1>
</div>

<div class="container py-5">
    <div class="row align-items-start g-4">
        <div class="col-lg-6">
            <h2 class="fw-bold mb-3">Grievance Redressal</h2>

            <div class="ps-3 border-start border-danger border-3">
                <p class="text-muted">
                    iUniversity is committed to resolve grievances within 30 days.
                </p>
                <p class="text-muted">
                    We believe in providing the best Learning Experience and our expert team is always available to help you
                    with any query or grievances.
                </p>

                <p class="text-muted">
                    This is the official page and you can share your queries, feedback, or any concerns you may have about iUniversity or our programs.
                </p>

                <p class="text-muted">
                    Our dedicated team ensures responses within <strong>2 business days</strong>.
                </p>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-box">
                <h4 class="text-center mb-4">Fill the Form</h4>

                <form action="{{ route('grievance.save') }}" enctype="multipart/form-data" method="POST" id="grievanceForm">
                    @csrf
                    <input type="hidden" name="id">
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                    <div class="row g-3">

                        <div class="col-12">
                            <input type="text" class="form-control" name="name" placeholder="Name of Learner">
                        </div>

                        <div class="col-12">
                            <input type="email" class="form-control" name="email" placeholder="Registered Email ID">
                        </div>

                        <div class="col-12">
                            <input type="text" class="form-control" name="mobile" placeholder="Registered Contact Number">
                        </div>

                        <div class="col-12">
                            <input type="text" class="form-control" name="alt_mobile" placeholder="Alternate Contact Number">
                        </div>
                        <div class="col-12">
                            <input type="file" class="form-control" name="attachment">
                        </div>

                        <div class="col-12">
                            <select class="form-select" name="subject">
                                <option value="">Select Type of Concern</option>
                                <option value="technical_issue">Technical Issues</option>
                                <option value="fee_related">Fee Related</option>
                                <option value="course_related">Course Related</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <textarea class="form-control" name="message" rows="4" placeholder="Explain your concern (Max 600 words)"></textarea>
                        </div>

                        <div class="col-12">
                            <button id="grievanceBtn" class="btn btn-danger w-100 py-2 fs-5">Submit</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
@push('script')
<script type="text/javascript">
    $(document).ready(function() {

        $(document).on("submit", "#grievanceForm", function(e) {
            e.preventDefault();

            let form = $(this)[0];
            let btn = $("#grievanceBtn");

            let formData = new FormData(form);

            $.ajax({
                url: $(this).attr("action"),
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
                    if (res.status === "success") {
                        notify(res.message, "success");
                        $("#grievanceForm")[0].reset();
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
                    btn.html("Submit").attr("disabled", false);
                }
            });
        });

    });
</script>


@endpush