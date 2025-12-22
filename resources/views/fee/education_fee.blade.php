@extends('frontend.app')
@section('title', 'Course Fee')
@section('pagetitle', 'Course Fee')

@php
$table = 'yes';
@endphp


@section('content')
<div class="container mb-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <h2 class="text-center mb-3">Fee Payment</h2>
            <p class="text-center text-muted">Pay your tuition or other university fees online quickly and securely.</p>

            <!-- Fee Payment Form -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-4 text-center">Fee Details</h5>

                    <form id="feeAdd" enctype="multipart/form-data" action="{{ route('billPayment') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                        <input type="hidden" name="id">
                        <input type="hidden" name="categoryname" value="Education Fees">

                        <div class="col-md-12">
                            <label class="form-label">Select College</label>
                            <select name="biller_id" id="billerDropdown" required class="form-control">
                                <option value="">-- Select College --</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Student Mobile</label>
                            <input type="number" name="customer_mobile" id="customerMobile" required placeholder="Enter Mobile Number" class="form-control">
                        </div>

                        <!-- Dynamic Fields placeholder -->
                        <div id="dynamicFields" class="row g-3 mt-3"></div>
                        <div id="dataFields" class="row g-3 mt-3"></div>

                        <div class="mt-4">
                            <button class="btn btn-primary w-100" id="fetchBtn" type="button">Fetch Details</button>
                            <button class="btn btn-success w-100 d-none mt-3" id="payBtn" type="submit">Pay Now</button>
                        </div>
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

        let categoryName = "Education Fees";

        if (categoryName !== "") {
            $.ajax({
                url: "{{ route('addFee') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    user_id: "{{ Auth::id() }}",
                    categoryname: categoryName
                },
                beforeSend: function() {
                    $("#billerDropdown").html('<option>Loading...</option>');
                    $("#dynamicFields").html("");
                    $("#dataFields").html("");
                    $("#payBtn").addClass("d-none");
                },
                success: function(res) {
                    if (res.success && res.billers) {
                        let options = '<option value="">-- Select College --</option>';
                        $.each(res.billers, function(i, biller) {
                            options += `<option value="${biller.billerId}">${biller.billerName}</option>`;
                        });
                        $("#billerDropdown").html(options);
                        $("#billerDropdown").select2({
                            placeholder: "-- Select College --",
                            allowClear: false,
                            width: '100%'
                        });
                    } else {
                        $("#billerDropdown").html('<option>No Colleges found</option>');
                    }
                },
                error: function() {
                    $("#billerDropdown").html('<option>Error loading colleges</option>');
                }
            });
        } else {
            $("#billerDropdown").html('<option value="">-- Select College --</option>');
        }

        // 2. On change of college dropdown to fetch details
        $(document).on("change", "#billerDropdown", function() {
            let billerId = $(this).val();

            if (billerId !== "") {
                $.ajax({
                    url: "{{ route('getBillerDetails') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        user_id: "{{ Auth::id() }}",
                        biller_id: billerId
                    },
                    beforeSend: function() {
                        $("#billerInfo").html("Loading biller details...");
                        $("#dynamicFields").html("");
                        $("#dataFields").html("");
                        $("#payBtn").addClass("d-none");
                        $("#fetchBtn").removeClass("d-none").attr("disabled", false).html("Fetch Details");
                    },
                    success: function(res) {
                        if (res.success) {
                            let b = res.biller;

                            if (b.customParamResp && b.customParamResp.length > 0) {
                                b.customParamResp.forEach(param => {
                                    let required = param.optional ? "" : "required";
                                    let type = (param.dataType === "NUMERIC") ? "number" : "text";

                                    $("#dynamicFields").append(`
                                    <div class="col-md-6">
                                        <label class="form-label">${param.customParamName}</label>
                                        <input type="${type}" name="dynamicFields[${param.customParamName}]" class="form-control" minlength="${param.minLength}" maxlength="${param.maxLength}" ${required} placeholder="Enter ${param.customParamName}">
                                    </div>
                                `);
                                });
                            }
                            $("#billerInfo").html("Biller details loaded.");
                        } else {
                            $("#billerInfo").html("No details found.");
                        }
                    },
                    error: function() {
                        $("#billerInfo").html("Error loading biller details.");
                    }
                });
            } else {
                $("#billerInfo").html("Select a biller to see details...");
                $("#dynamicFields").html("");
            }
        });

        // 3. Fetch Details button click
        $(document).on("click", "#fetchBtn", function(e) {
            e.preventDefault();
            let form = $("#feeAdd");

            if (!form[0].checkValidity()) {
                form[0].reportValidity();
                return false;
            }

            $.ajax({
                url: "{{ route('fetchFee') }}",
                type: "POST",
                data: form.serialize(),
                beforeSend: function() {
                    $("#fetchBtn").html("<i class='fa fa-spin fa-spinner'></i> Please wait...").attr("disabled", true);
                },
                success: function(res) {
                    $("#fetchBtn").html("Fetch Details").attr("disabled", false);

                    if (res.success) {
                        let billData = res.billById?.data?.billerResponse;
                        let billStatus = res.billById?.status;
                        let errorMsg = res.billById?.data?.genericResponse?.message;

                        if (billStatus === "FAILURE") {
                            notify(errorMsg || "Bill fetch failed", "error");
                            return;
                        }

                        if (billData) {
                            $("#dataFields").html(`
                            <input type="text" name="billid" value="${billData.billId}" hidden>
                            <input type="text" name="biller_id" value="${billData.billerId}" hidden>

                            <div class="col-md-6">
                                <label class="form-label">Customer Name</label>
                                <input type="text" name="customer_name" class="form-control" value="${billData.customerName}" readonly style="background-color: rgba(214, 234, 234, 0.94); color: black;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Bill Number</label>
                                <input type="text" name="bill_number" class="form-control" value="${billData.billNumber}" readonly style="background-color: rgba(214, 234, 234, 0.94); color: black;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Bill Amount</label>
                                <input type="text" name="bill_amount" class="form-control" value="${billData.amount}" readonly style="background-color: rgba(214, 234, 234, 0.94); color: black;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Bill Date</label>
                                <input type="text" name="bill_date" class="form-control" value="${billData.billDate}" readonly style="background-color: rgba(214, 234, 234, 0.94); color: black;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Due Date</label>
                                <input type="text" name="due_date" class="form-control" value="${billData.dueDate}" readonly style="background-color: rgba(214, 234, 234, 0.94); color: black;">
                            </div>
                        `);
                            $("#dynamicFields").find("input, select, textarea").each(function() {
                                $(this).attr("readonly", true);
                                $(this).attr("disabled", true);
                                $(this).css({
                                    "background-color": "rgba(214, 234, 234, 0.94) !important",
                                    "color": "black !important",
                                    "cursor": "not-allowed"
                                });
                            });
                            $("#customerMobile").attr("readonly", true);
                            $("#customerMobile").removeAttr("disabled");
                            $("#customerMobile").addClass("readonly-field");
                            $("#fetchBtn").addClass("d-none");
                            $("#payBtn").removeClass("d-none");

                            notify("Bill details fetched successfully!", "success");
                        } else {
                            notify("No bill data found.", "warning");
                        }
                    } else {
                        notify("Something went wrong.", "error");
                    }
                },
                error: function(xhr) {
                    $("#fetchBtn").html("Fetch Details").attr("disabled", false);
                    let msg = xhr.responseJSON?.message || "Something went wrong while fetching!";
                    notify(msg, "error");
                }
            });
        });

        // 4. Form submission using validation and ajaxSubmit
        $("#feeAdd").validate({
            submitHandler: function() {
                var form = $("#feeAdd");
                form.ajaxSubmit({
                    dataType: 'json',
                    beforeSubmit: function() {
                        $("#payBtn").html("<i class='fa fa-spin fa-spinner'></i> Processing...").attr("disabled", true);
                    },
                    success: function(data) {
                        if (data.status === "success") {
                            form[0].reset();
                            notify(data.message, "success");
                            $("#payBtn").html("Pay Now").attr("disabled", false);
                        } else {
                            notify(data.message, "error");
                        }
                    },
                    error: function(errors) {
                        notify(errors?.responseJSON?.message || "Something went wrong", "error");
                    }
                });
            }
        });

    });
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