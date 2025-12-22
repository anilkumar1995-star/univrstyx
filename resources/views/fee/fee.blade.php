@extends('frontend.app')
@section('title', 'Course Fee')
@section('pagetitle', 'Course Fee')

@php
$table = 'yes';
@endphp

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <h2 class="text-center mb-3 fw-bold">Fee Payment</h2>
            <p class="text-center text-muted mb-4">
                Pay your fees online quickly and securely.
            </p>

            <!-- Fee Payment Cards -->
            <div class="row g-4 justify-content-center">

                <div class="col-md-3 col-sm-6">
                    <a href="{{ route('school.fee') }}" class="text-decoration-none text-dark">
                        <div class="card text-center shadow-sm border-0 h-100 bg-info bg-opacity-25" style="cursor: pointer;">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                <img src="{{ asset('frontend/images/verticals/MBA.webp') }}"
                                    alt="School Fee"
                                    class="img-fluid mb-3"
                                    style="max-width: 100px;">
                                <h6 class="fw-semibold text-black">School Fee</h6>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Tuition Fee -->
                <div class="col-md-3 col-sm-6">
                    <a href="{{ route('tution.fee') }}" class="text-decoration-none text-dark">
                        <div class="card text-center shadow-sm bg-warning bg-opacity-25" style="cursor: pointer;">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                <img src="{{ asset('frontend/images/verticals/Doctorate.webp') }}"
                                    alt="Tuition Fee"
                                    class="img-fluid mb-3"
                                    style="max-width: 100px;">
                                <span class="fw-semibold text-black">Tuition Fee</span>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- College Fee -->
                <div class="col-md-3 col-sm-6">
                    <a href="{{ route('college.fee') }}" class="text-decoration-none text-dark">
                        <div class="card text-center shadow-sm bg-success h-100 bg-opacity-25" style="cursor: pointer;">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                <img src="{{ asset('frontend/images/verticals/Management.webp') }}"
                                    alt="College Fee"
                                    class="img-fluid mb-3"
                                    style="max-width: 100px;">
                                <h6 class="fw-semibold text-dark">College Fee</h6>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Hostel Fee -->
                <div class="col-md-3 col-sm-6">
                    <a href="{{ route('hostel.fee') }}" class="text-decoration-none text-dark">
                        <div class="card text-center shadow-sm bg-danger bg-opacity-25" style="cursor: pointer;">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                <img src="{{ asset('frontend/images/verticals/Law.webp') }}"
                                    alt="Hostel Fee"
                                    class="img-fluid mb-3"
                                    style="max-width: 100px;">
                                <span class="fw-semibold text-black">Hostel Fee</span>
                            </div>
                        </div>
                    </a>
                </div>
 <div class="col-md-3 col-sm-6">
                <a href="{{ route('hobby.fee') }}" class="text-decoration-none text-dark">
                    <div class="card text-center shadow-sm bg-danger bg-opacity-25" style="cursor: pointer;">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center">
                            <img src="{{ asset('frontend/images/verticals/Law.webp') }}"
                                alt="Hostel Fee"
                                class="img-fluid mb-3"
                                style="max-width: 100px;">
                            <span class="fw-semibold text-black">Hobby Class</span>
                        </div>
                    </div>
                </a>
            </div>
             <div class="col-md-3 col-sm-6">
                <a href="{{ route('daycare.fee') }}" class="text-decoration-none text-dark">
                    <div class="card text-center shadow-sm bg-danger bg-opacity-25" style="cursor: pointer;">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center">
                            <img src="{{ asset('frontend/images/verticals/Law.webp') }}"
                                alt="Hostel Fee"
                                class="img-fluid mb-3"
                                style="max-width: 100px;">
                            <span class="fw-semibold text-black">Day Care</span>
                        </div>
                    </div>
                </a>
            </div>
             <div class="col-md-3 col-sm-6">
                <a href="{{ route('education.fee') }}" class="text-decoration-none text-dark">
                    <div class="card text-center shadow-sm bg-danger bg-opacity-25" style="cursor: pointer;">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center">
                            <img src="{{ asset('frontend/images/verticals/Law.webp') }}"
                                alt="Hostel Fee"
                                class="img-fluid mb-3"
                                style="max-width: 100px;">
                            <span class="fw-semibold text-black">Education Fee</span>
                        </div>
                    </div>
                </a>
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
    // $(document).ready(function() {

    //     let categoryName = "Education Fees";

    //     if (categoryName !== "") {
    //         $.ajax({
    //             url: "{{ route('addFee') }}",
    //             type: "POST",
    //             data: {
    //                 _token: "{{ csrf_token() }}",
    //                 user_id: "{{ Auth::id() }}",
    //                 categoryname: categoryName
    //             },
    //             beforeSend: function() {
    //                 $("#billerDropdown").html('<option>Loading...</option>');
    //                 $("#dynamicFields").html("");
    //                 $("#dataFields").html("");
    //                 $("#payBtn").addClass("d-none");
    //             },
    //             success: function(res) {
    //                 if (res.success && res.billers) {
    //                     let options = '<option value="">-- Select College --</option>';
    //                     $.each(res.billers, function(i, biller) {
    //                         options += `<option value="${biller.billerId}">${biller.billerName}</option>`;
    //                     });
    //                     $("#billerDropdown").html(options);
    //                     $("#billerDropdown").select2({
    //                         placeholder: "-- Select College --",
    //                         allowClear: false,
    //                         width: '100%'
    //                     });
    //                 } else {
    //                     $("#billerDropdown").html('<option>No Colleges found</option>');
    //                 }
    //             },
    //             error: function() {
    //                 $("#billerDropdown").html('<option>Error loading colleges</option>');
    //             }
    //         });
    //     } else {
    //         $("#billerDropdown").html('<option value="">-- Select College --</option>');
    //     }

    //     // 2. On change of college dropdown to fetch details
    //     $(document).on("change", "#billerDropdown", function() {
    //         let billerId = $(this).val();

    //         if (billerId !== "") {
    //             $.ajax({
    //                 url: "{{ route('getBillerDetails') }}",
    //                 type: "POST",
    //                 data: {
    //                     _token: "{{ csrf_token() }}",
    //                     user_id: "{{ Auth::id() }}",
    //                     biller_id: billerId
    //                 },
    //                 beforeSend: function() {
    //                     $("#billerInfo").html("Loading biller details...");
    //                     $("#dynamicFields").html("");
    //                     $("#dataFields").html("");
    //                     $("#payBtn").addClass("d-none");
    //                     $("#fetchBtn").removeClass("d-none").attr("disabled", false).html("Fetch Details");
    //                 },
    //                 success: function(res) {
    //                     if (res.success) {
    //                         let b = res.biller;

    //                         if (b.customParamResp && b.customParamResp.length > 0) {
    //                             b.customParamResp.forEach(param => {
    //                                 let required = param.optional ? "" : "required";
    //                                 let type = (param.dataType === "NUMERIC") ? "number" : "text";

    //                                 $("#dynamicFields").append(`
    //                                 <div class="col-md-6">
    //                                     <label class="form-label">${param.customParamName}</label>
    //                                     <input type="${type}" name="dynamicFields[${param.customParamName}]" class="form-control" minlength="${param.minLength}" maxlength="${param.maxLength}" ${required} placeholder="Enter ${param.customParamName}">
    //                                 </div>
    //                             `);
    //                             });
    //                         }
    //                         $("#billerInfo").html("Biller details loaded.");
    //                     } else {
    //                         $("#billerInfo").html("No details found.");
    //                     }
    //                 },
    //                 error: function() {
    //                     $("#billerInfo").html("Error loading biller details.");
    //                 }
    //             });
    //         } else {
    //             $("#billerInfo").html("Select a biller to see details...");
    //             $("#dynamicFields").html("");
    //         }
    //     });

    //     // 3. Fetch Details button click
    //     $(document).on("click", "#fetchBtn", function(e) {
    //         e.preventDefault();
    //         let form = $("#feeAdd");

    //         if (!form[0].checkValidity()) {
    //             form[0].reportValidity();
    //             return false;
    //         }

    //         $.ajax({
    //             url: "{{ route('fetchFee') }}",
    //             type: "POST",
    //             data: form.serialize(),
    //             beforeSend: function() {
    //                 $("#fetchBtn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").attr("disabled", true);
    //             },
    //             success: function(res) {
    //                 $("#fetchBtn").html("Fetch Details").attr("disabled", false);

    //                 if (res.success) {
    //                     let billData = res.billById?.data?.billerResponse;
    //                     let billStatus = res.billById?.status;
    //                     let errorMsg = res.billById?.data?.genericResponse?.message;

    //                     if (billStatus === "FAILURE") {
    //                         notify(errorMsg || "Bill fetch failed", "error");
    //                         return;
    //                     }

    //                     if (billData) {
    //                         $("#dataFields").html(`
    //                         <input type="text" name="billid" value="${billData.billId}" hidden>
    //                         <input type="text" name="biller_id" value="${billData.billerId}" hidden>

    //                         <div class="col-md-6">
    //                             <label class="form-label">Customer Name</label>
    //                             <input type="text" name="customer_name" class="form-control" value="${billData.customerName}" readonly style="background-color: rgba(214, 234, 234, 0.94); color: black;">
    //                         </div>
    //                         <div class="col-md-6">
    //                             <label class="form-label">Bill Number</label>
    //                             <input type="text" name="bill_number" class="form-control" value="${billData.billNumber}" readonly style="background-color: rgba(214, 234, 234, 0.94); color: black;">
    //                         </div>
    //                         <div class="col-md-6">
    //                             <label class="form-label">Bill Amount</label>
    //                             <input type="text" name="bill_amount" class="form-control" value="${billData.amount}" readonly style="background-color: rgba(214, 234, 234, 0.94); color: black;">
    //                         </div>
    //                         <div class="col-md-6">
    //                             <label class="form-label">Bill Date</label>
    //                             <input type="text" name="bill_date" class="form-control" value="${billData.billDate}" readonly style="background-color: rgba(214, 234, 234, 0.94); color: black;">
    //                         </div>
    //                         <div class="col-md-6">
    //                             <label class="form-label">Due Date</label>
    //                             <input type="text" name="due_date" class="form-control" value="${billData.dueDate}" readonly style="background-color: rgba(214, 234, 234, 0.94); color: black;">
    //                         </div>
    //                     `);
    //                         $("#dynamicFields").find("input, select, textarea").each(function() {
    //                             $(this).attr("readonly", true);
    //                             $(this).attr("disabled", true);
    //                             $(this).css({
    //                                 "background-color": "rgba(214, 234, 234, 0.94) !important",
    //                                 "color": "black !important",
    //                                 "cursor": "not-allowed"
    //                             });
    //                         });
    //                         $("#customerMobile").attr("readonly", true);
    //                         $("#customerMobile").removeAttr("disabled");
    //                         $("#customerMobile").addClass("readonly-field");
    //                         $("#fetchBtn").addClass("d-none");
    //                         $("#payBtn").removeClass("d-none");

    //                         notify("Bill details fetched successfully!", "success");
    //                     } else {
    //                         notify("No bill data found.", "warning");
    //                     }
    //                 } else {
    //                     notify("Something went wrong.", "error");
    //                 }
    //             },
    //             error: function(xhr) {
    //                 $("#fetchBtn").html("Fetch Details").attr("disabled", false);
    //                 let msg = xhr.responseJSON?.message || "Something went wrong while fetching!";
    //                 notify(msg, "error");
    //             }
    //         });
    //     });

    //     // 4. Form submission using validation and ajaxSubmit
    //     $("#feeAdd").validate({
    //         submitHandler: function() {
    //             var form = $("#feeAdd");
    //             form.ajaxSubmit({
    //                 dataType: 'json',
    //                 beforeSubmit: function() {
    //                     $("#payBtn").html("<i class='fa fa-spin fa-spinner'></i> Processing...").attr("disabled", true);
    //                 },
    //                 success: function(data) {
    //                     if (data.status === "success") {
    //                         form[0].reset();
    //                         notify(data.message, "success");
    //                         $("#payBtn").html("Pay Now").attr("disabled", false);
    //                     } else {
    //                         notify(data.message, "error");
    //                     }
    //                 },
    //                 error: function(errors) {
    //                     notify(errors?.responseJSON?.message || "Something went wrong", "error");
    //                 }
    //             });
    //         }
    //     });

    // });
</script>
@endpush