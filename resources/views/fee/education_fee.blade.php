@extends('frontend.app')
@section('title', 'Course Fee')
@section('pagetitle', 'Course Fee')

@php
$table = 'yes';
@endphp


@section('content')
<div class="container">
    <div class="row justify-content-center border-0 rounded-4 my-5">
        <div class="col-lg-8 col-md-10 col-12">
            <div class="card shadow-sm">

                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 d-flex align-items-center">
                        <i class="ti ti-receipt me-2 fs-4"></i>
                        Education Fee Payment
                    </h5>
                </div>

                <div class="card-body border p-4">

                    <form id="billpayForm" action="{{ route('billpay') }}" method="post">
                        {{ csrf_field() }}

                        <input type="hidden" name="type" value="getbilldetails">
                        <input type="hidden" name="operatorType" value="educationfees">
                        <input type="hidden" name="refId">
                        <input type="hidden" name="billId">
                        <input type="hidden" name="mode" value="online">

                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <span class="fw-semibold">State</span>
                                <select class="form-select" id="stateSelect">
                                    <option value="">Select State</option>

                                </select>
                            </div>

                            <div class="col-md-6 mb-2">
                                <span class="fw-semibold">City</span>
                                <select class="form-select" id="citySelect">
                                    <option value="">Select City</option>
                                    <option value="all">All City</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-12 mb-2">
                                <span class="fw-semibold">
                                    College / University
                                </span>
                                <select class="form-select form-select" name="provider_id" onchange="SETTITLE()" required id="mySelect">
                                    <option value="">Select College</option>
                                    @foreach ($providers as $provider)
                                    <option value="{{ $provider->id }}">
                                        {{ $provider->name }} ({{ strtoupper($provider->billerCoverage) }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 col-12 mb-2">
                                <span class="fw-semibold">
                                    Mobile Number
                                </span>
                                <input type="text"
                                    class="form-control form-control"
                                    name="mobileNo"
                                    placeholder="Enter mobile number"
                                    maxlength="10">
                            </div>
                        </div>

                        <!-- Dynamic Bill Fields -->
                        <div class="billdata"></div>

                        <hr class="my-4">

                        <!-- Footer -->
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div class="bg-success-subtle px-3 py-2 rounded-3 d-flex align-items-center">
                                <small class="text-success fw-semibold d-inline-flex align-items-center">
                                    <i class="ti ti-shield-lock me-1"></i> Secure Payment
                                </small>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit"
                                    class="btn btn-outline-primary px-4"
                                    id="fetch">
                                    <i class="ti ti-search me-1"></i> Fetch Bill
                                </button>

                                <button type="submit"
                                    class="btn btn-success px-4 submit-button"
                                    id="pay">
                                    <i class="ti ti-credit-card me-1"></i> Pay Now
                                </button>
                            </div>
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
        $('#mySelect').select2();

        loadStates();

        function loadStates() {
            $.ajax({
                url: "{{ url('billpay/states') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(states) {

                    let html = '<option value="">Select State</option>';
                    html += '<option value="all">All India</option>';

                    states.forEach(function(state) {
                        html += `<option value="${state}">${state}</option>`;
                    });

                    $('#stateSelect').html(html);
                }
            });
        }



        $('#stateSelect').on('change', function() {

            $('.billdata').empty();
            $('#fetch').show();
            $('#pay').hide();

            let state = $(this).val();

            let cityHtml = '<option value="">Select City</option>';
            cityHtml += '<option value="all">All City</option>';

            $('#citySelect').html(cityHtml).prop('disabled', false);
            $('#mySelect').val(null).trigger('change').prop('disabled', true);

            if (!state) return;

            if (state === 'all') {
                $('#mySelect').prop('disabled', false);
                return;
            }

            // Load cities
            $.ajax({
                url: "{{ url('billpay/cities') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    state: state
                },
                success: function(cities) {
                    cities.forEach(function(city) {
                        $('#citySelect').append(
                            `<option value="${city}">${city}</option>`
                        );
                    });
                }
            });
        });


        $('#citySelect').on('change', function() {

            $('.billdata').empty();

            $('#fetch').show();
            $('#pay').hide();

            let state = $('#stateSelect').val();
            let city = $(this).val();

            $('#mySelect').val(null).trigger('change');

            if (state && city) {
                $('#mySelect').prop('disabled', false);
            } else {
                $('#mySelect').prop('disabled', true);
            }
        });

        $('#fetch, #pay').on('click', function() {
            $("#billpayForm").valid();
        });


        $('#print').click(function() {
            $('#receipt').find('.modal-body').print();
        });

        $('#mySelect').select2({
            width: '100%',
            ajax: {
                url: "{{ url('billpay/providersByName') }}",
                type: 'post',
                minimumInputLength: 2,
                data: function(params) {
                    return {
                        searchname: params.term,
                        type: 'educationfees',
                        state: $('#stateSelect').val(),
                        city: $('#citySelect').val(),
                        page: params.page || 1,
                        _token: '{{ csrf_token() }}'
                    };
                },

                processResults: function(item, params) {
                    let billerlist = [];

                    if (item.providers) {
                        for (let data of item.providers) {
                            billerlist.push({
                                "id": data.id,
                                "text": data.name + '\xa0\xa0\xa0\xa0\xa0' + "-\xa0\xa0Coverage :\xa0\xa0" + data.billerCoverage.toUpperCase()
                            })

                        }
                    }
                    // console.log(billerlist);
                    return {
                        results: billerlist,
                    };
                },
                cache: true
            }
        });

        $("#billpayForm").validate({
            rules: {
                provider_id: {
                    required: true,
                },
                amount: {
                    required: true,
                    number: true,
                    min: 10
                },
                biller: {
                    required: true
                },
                duedate: {
                    required: true,
                },
            },
            messages: {
                provider_id: {
                    required: "Please select operator",
                },
                amount: {
                    required: "Please enter amount",
                    number: "Amount should be numeric",
                },
                biller: {
                    required: "Please enter biller name",
                },
                duedate: {
                    required: "Please enter biller duedate",
                }
            },
            errorElement: "p",
            errorClass: "text-danger mt-1",
            errorPlacement: function(error, element) {
                if (element.prop("tagName").toLowerCase() === "select") {
                    error.insertAfter(element.next('.select2'));
                } else {
                    error.insertAfter(element);
                }
                setTimeout(function() {
                    error.fadeOut(300, function() {
                        $(this).remove();
                    });
                }, 5000);

            },

            submitHandler: function() {
                var form = $('#billpayForm');
                var id = form.find('[name="id"]').val();
                var type = form.find('[name="type"]').val();

                form.ajaxSubmit({
                    dataType: 'json',
                    beforeSubmit: function() {

                        // if (type == "getbilldetails") {
                        swal({
                            title: 'Wait!',
                            text: 'We are fetching bill details',
                            onOpen: () => {
                                swal.showLoading()
                            },
                            allowOutsideClick: () => !swal.isLoading()
                        });
                        // }
                    },
                    complete: function() {
                        swal.close();
                    },
                    success: function(data) {

                        swal.close();
                        if (data.statuscode == "TXN") {
                            // console.log(data);
                            const today = new Date().toISOString().split('T')[0];
                            $('#billpayForm').find('[name="type"]').val("payment");
                            $('#billpayForm').find('[name="refId"]').val(data.data.refId);
                            $('#billpayForm').find('[name="mode"]').val(data.data.mode);
                            $('#billpayForm').find('[name="billId"]').val(data.data.billId);
                            $('.billdata').append(`
                              <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label class="fw-semibold">Consumer Name</label>
                                    <input type="text" name="customerName" value="` + data.data.customerName + `" class="form-control" placeholder="Enter name" readonly required="">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="fw-semibold">Due Date</label>
                                    <input type="text" name="dueDate" value="` + data.data.dueDate + `" class="form-control" readonly placeholder="Enter due date" required="">
                                </div>
                               <div class="col-md-6 mb-2">
                                    <label class="fw-semibold">Bill Date</label>
                                    <input type="text"name="billDate" value="${data?.data?.billDate ?? today}"class="form-control"  placeholder="Enter Bill Date">

                                </div>
                                
                                    <input type="hidden" name="billNumber" value="` + data.data.billNumber + `" class="form-control" placeholder="Enter due date" required="">
                                    <input type="hidden" name="billerId" value="` + data.data.billerId + `" class="form-control" placeholder="Enter due date" required="">
                                
                                <div class="col-md-6 mb-2">
                                    <label class="fw-semibold">Amount</label>
                                    <input type="text" name="amount" value="` + data.data.amount + `" class="form-control" placeholder="Enter amount" required="">
                                </div>
    
                                  </div>
                                `);
                            lockMoreDetailsOnly();

                            $('#fetch').hide();
                            $('#pay').show();

                        } else if (data.status == "success" || data.status == "pending" || data.status == "failed") {
                            // console.log('elseif')
                            form[0].reset();
                            $('#billpayForm').find('[name="type"]').val("getbilldetails");
                            form.find('select').select2().val(null).trigger('change');
                            getbalance();
                            notify("Billpayment Successfully Submitted", 'success');

                            // swal({
                            //     title: 'Success',
                            //     text: "Billpayment Successfully Submitted",
                            //     type: 'success',
                            //     onClose: () => {
                            window.location.href = "{{ url('billpayrecipt') }}/" + data.data.id;
                            //     }
                            // });                        

                        } else {
                            notify(data.message || data.status || "Something went wrong", 'error');
                        }
                    },
                    error: function(errors) {
                        swal.close();
                        // showError(errors, form);
                        notify(errors.responseJSON.status || errors.responseJSON || "Something went wrong", 'error');
                        $('#fetch').html('Fetch');
                        $('#pay').html('Pay');
                    }
                });
            }
        });
    });

    function lockMoreDetailsOnly() {

        $('.moredetails-wrapper')
            .find('input:not([type="hidden"])')
            .prop('readonly', true);
        $('.moredetails-wrapper')
            .find('select')
            .prop('disabled', true);
    }

    function SETTITLE() {
        var providerid = $('[name="provider_id"]').val();
        // console.log(providerid);
        if (providerid != '' && providerid != null && providerid != 'null') {
            $.ajax({
                    url: "{{ route('getprovider') }}",
                    type: 'post',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        swal({
                            title: 'Wait!',
                            text: 'We are fetching bill details',
                            onOpen: () => {
                                swal.showLoading()
                            },
                            allowOutsideClick: () => !swal.isLoading()
                        });
                    },
                    data: {
                        "provider_id": providerid
                    }
                })
                .done(function(data) {
                    swal.close();
                    $('#fetch').show();
                    $('#billpayForm').find('[name="type"]').val("getbilldetails");
                    $('.billdata').empty();
                    // $.each(data.paramname, function(i, val) {
                    //     var html = '<div>';
                    //     html += '<div class="form-group mb-2">';
                    //     html += '<label>' + data.paramname[i] + '</label>';
                    //     html += '<input type="text" name="number' + i + '" class="form-control" placeholder="Enter ' + data.paramname[i] + '">';
                    //     html += '</div>';
                    //     html += '</div>';


                    //     // alert(html)
                    //     $('.billdata').append(html);
                    // });
                    moredetails(data)
                    if (data.fetchOption == "NOT_SUPPORTED") {
                        $('#billpayForm').find('[name="type"]').val("payment");
                        $('.billdata').append(`
                                <div class="form-group mb-2">
                                    <label>Consumer Name</label>
                                    <input type="text" name="biller" class="form-control" placeholder="Enter name" required="">
                                </div>   
                                <div class="form-group mb-2">
                                    <label>Amount</label>
                                    <input type="text" name="amount"  class="form-control" placeholder="Enter amount" required="">
                            </div>
                            <div class="form-group mb-2">
                                    <label>Email ID</label>
                                    <input type="text" name="email"  class="form-control" placeholder="Enter Email ID" required="">
                                </div>
                            `);
                        $('#fetch').hide();
                        $('#pay').show();
                    }

                })
                .fail(function(errors) {
                    swal.close();
                    showError(errors, $('#billpayForm'));
                });
        }




        function moredetails(item) {

            let html = '<div class="row moredetails-wrapper">';
            let i = 0;

            let params = item.customerReqParam;
            if (typeof params === 'string') {
                params = JSON.parse(params);
            }

            params.forEach(p => {

                if (typeof p === 'string') {
                    p = JSON.parse(p);
                }

                if (p.visibility === false) return;

                let required = p.optional === false ? 'required' : '';
                let label = p.customParamName;

                html += `<div class="col-md-6 col-12">`;

                if (Array.isArray(p.values) && p.values.length > 0) {

                    html += `
                <div class="mb-2">
                    <span class="fw-semibold">${label}</span>
                    <select class="form-select form-select"
                            name="number${i}"
                            ${required}>
                        <option value="">Select ${label}</option>
                        ${p.values.map(val => `
                            <option value="${val}">${val}</option>
                        `).join('')}
                    </select>
                </div>
            `;

                } else {

                    let inputType = (p.dataType === 'NUMERIC') ? 'number' : 'text';

                    html += `
                <div class="mb-2">
                    <span class="fw-semibold">${label}</span>
                    <input type="${inputType}"
                        name="number${i}"
                        class="form-control"
                        placeholder="Enter ${label}"
                        minlength="${p.minLength ?? ''}"
                        maxlength="${p.maxLength ?? ''}"
                        pattern="${p.regex ?? ''}"
                        ${required}>
                </div>
            `;
                }

                html += `</div>`;
                i++;
            });

            html += '</div>';

            $('.billdata').html(html);
        }


    }
</script>








<!-- <script type="text/javascript">
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
</script> -->
@endpush