<!DOCTYPE html>
<html lang="en">

<head>

    <!-- Meta Tags -->
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description"
        content="Streamline your business with our advanced CRM template. Easily integrate and customize to manage sales, support, and customer interactions efficiently. Perfect for any business size">
    <meta name="keywords"
        content="Advanced CRM template, customer relationship management, business CRM, sales optimization, customer support software, CRM integration, customizable CRM, business tools, enterprise CRM solutions">
    <meta name="author" content="Dreams Technologies">
    <meta name="robots" content="index, follow">

    <!-- Title -->
    <title>@yield('title') - {{ @Auth::user()->company->companyname }} | iUniversity</title>

    <!-- Apple Touch Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('') }}assets1/img/apple-touch-icon.png">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('frontend/images/icons/favicon.jpg') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/images/icons/favicon.jpg') }}">

    <!-- JS -->
    <script src="{{ asset('') }}assets1/js/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('') }}assets1/css/bootstrap.css">
    <!-- jQuery UI -->
    <script src="{{ asset('assets1/js/jquery-ui.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('') }}assets1/css/jquery-ui.css" />


    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    {{-- <link rel="stylesheet" href="{{ asset('theme_1/assets/vendor/fonts/fontawesome.css') }}" /> --}}
    <link rel="stylesheet" href="{{ asset('theme_1/assets/vendor/fonts/tabler-icons.css') }}" />
    {{-- <link rel="stylesheet" href="{{ asset('theme_1/assets/vendor/fonts/flag-icons.css') }}" /> --}}

    {{-- <link rel="stylesheet" href="{{ asset('') }}assets1/plugins/tabler-icons/tabler-icons.css"> --}}

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('') }}assets1/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="{{ asset('') }}assets1/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('') }}frontend/css/summernote.min.css">


    <!-- Color Picker CSS -->
    <link rel="stylesheet" href="{{ asset('') }}assets1/plugins/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" href="{{ asset('') }}assets1/plugins/@simonwep/pickr/themes/nano.min.css">

    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{ asset('') }}assets1/css/dataTables.bootstrap5.min.css">


    <!-- Daterangepicker CSS -->
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets1/css/bootstrap-datepicker.min.css') }}">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('') }}assets1/plugins/select2/css/select2.min.css">

    <!-- Bootstrap Tagsinput CSS -->
    <link rel="stylesheet" href="{{ asset('') }}assets1/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css">

    <!-- Datetimepicker CSS -->
    {{-- <link rel="stylesheet" href="{{ asset('') }}assets1/css/bootstrap-datetimepicker.min.css"> --}}

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('') }}assets1/css/style.css">
    <link rel="stylesheet" href="{{ asset('') }}assets/js/core/sweetalert2.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
    {{-- <script src="{{ asset('theme_1/assets/vendor/libs/select2/select2.js') }}"></script> --}}
    <script src="{{ asset('') }}frontend/js/summernote.js"></script>


    <!-- Add this to your HTML file -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css" rel="stylesheet">


    <script src="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.0/min/dropzone.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.0/dropzone.js"></script>

    @stack('style')

    <style>
        .offcanvas.offcanvas-end {
            top: 0;
            right: 0;
            width: var(--bs-offcanvas-width) !important;
        }

        .error {
            color: red !important;
        }

        .datepicker .datepicker-days .table-condensed tfoot {
            text-align: center;
        }

        .datepicker .datepicker-days .table-condensed thead,
        tbody,
        tfoot,
        tr,
        td.day,
        th.dow {
            padding: 5px !important;
            cursor: pointer;
        }

        .datepicker .datepicker-switch {
            text-align: center;
        }
    </style>
    <!-- jQuery -->
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script> --}}

    {{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> --}}
    <link rel="stylesheet" href="{{ asset('') }}assets1/plugins/daterangepicker/daterangepicker.css">

    @if (isset($table) && $table == 'yes')
    <script src="{{ asset('') }}assets1/js/jquery.dataTables.min.js"></script>
    {{-- <script type="text/javascript" src="{{ asset('') }}assets/js/plugins/tables/datatables/datatables.min.js"></script> --}}
    @endif

    @if (env('MAINTENANCE_MODE', false))
    {{ Artisan::call('down') }}
    @endif
    <!-- {{-- <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script> --}} -->
    <!-- <script src="{{ asset('') }}assets1/js/jquery-ui.min.js" type="text/javascript"></script> -->


    <script type="text/javascript">
        $(document).ready(function() {

            $(".sidebar-default a").each(function() {
                if (this.href == window.location.href) {
                    $(this).addClass("active");
                    $(this).parent().addClass("active");
                    $(this).parent().parent().prev().addClass("active");
                    $(this).parent().parent().prev().click();
                }
            });

            $('.select').select2();

            $('#profileImg').hover(function() {
                $('span.changePic').show('400');
            });

            $('.changePic').hover(function() {
                $('span.changePic').show('400');
            }, function() {
                $('span.changePic').hide('400');
            });



            $('#reportExport').click(function() {
                const currentDate = new Date();
                const year = currentDate.getFullYear();
                const month = String(currentDate.getMonth() + 1).padStart(2, '0'); // Months are zero-based
                const day = String(currentDate.getDate()).padStart(2, '0');
                // Create the formatted date string
                const formattedDate = `${year}-${month}-${day}`;

                var type = $(this).attr('product');
                var fromdate = $('#searchForm').find('input[name="from_date"]').val() || formattedDate;
                var todate = $('#searchForm').find('input[name="to_date"]').val() || formattedDate;
                var searchtext = $('#searchForm').find('input[name="searchtext"]').val();
                var agent = $('#searchForm').find('input[name="agent"]').val();
                var status = $('#searchForm').find('[name="status"]').val();
                var product = $('#searchForm').find('[name="product"]').val();

                @if(isset($id))
                agent = "{{ $id }}";
                @endif

                const currentDate1 = new Date(fromdate);
                const year1 = currentDate1.getFullYear();
                const month1 = String(currentDate1.getMonth() + 1).padStart(2,
                    '0'); // Months are zero-based
                const day1 = String(currentDate1.getDate()).padStart(2, '0');
                // Create the formatted date string
                const formattedDate1 = `${year1}-${month1}-${day1}`;

                const currentDate2 = new Date(todate);
                const year2 = currentDate2.getFullYear();
                const month2 = String(currentDate2.getMonth() + 1).padStart(2,
                    '0'); // Months are zero-based
                const day2 = String(currentDate2.getDate()).padStart(2, '0');
                // Create the formatted date string
                const formattedDate2 = `${year2}-${month2}-${day2}`;

                window.location.href = "{{ url('statement/export') }}/" + type + "?fromdate=" +
                    formattedDate1 +
                    "&todate=" + formattedDate2 + "&searchtext=" + searchtext + "&agent=" + agent +
                    "&status=" +
                    status + "&product=" + product;
            });

            Dropzone.options.profileupload = {
                paramName: "profiles", // The name that will be used to transfer the file
                maxFilesize: .5, // MB
                complete: function(file) {
                    this.removeFile(file);
                },
                success: function(file, data) {
                    if (data.status == "success") {
                        $('#profileImg').removeAttr('src');
                        $('#profileImg').attr('src', file.dataURL);
                        notify("Profile Successfully Uploaded", 'success');
                    } else {
                        notify("Something went wrong, please try again.", 'warning');
                    }
                }
            };

            $('.mydate').datepicker({
                'autoclose': true,
                'clearBtn': true,
                'todayHighlight': true,
                'format': 'mm/dd/yyyy'
            });

            $('input[name="from_date"]').datepicker("setDate", getPrevious(new Date(), 0));
            $('input[name="to_date"]').datepicker("setEndDate", getPrevious(new Date(), 0));

            $('input[name="to_date"]').datepicker().on('changeDate', function(e) {
                $('input[name="from_date"]').datepicker('setEndDate', $('input[name="to_date"]').val());
            });

            $('input[name="to_date"]').focus(function() {
                if ($('input[name="from_date"]').val().length == 0) {
                    $('input[name="to_date"]').datepicker('hide');
                    $('input[name="from_date"]').focus();
                }
            });


            $('#formReset').click(function() {
                $('form#searchForm')[0].reset();
                $('form#searchForm').find('[name="from_date"]').datepicker().datepicker("setDate",
                    getPrevious(new Date(), 0));
                $('form#searchForm').find('[name="to_date"]').datepicker().datepicker("setDate",
                    getPrevious(new Date(), 0));
                $('form#searchForm').find('select').val(null).trigger('change')
                $('#formReset').find('button[type="submit"]').html('loading');
                $('#datatable').dataTable().api().ajax.reload();
            });


            $('form#searchForm').submit(function() {
                var fromdate = $(this).find('input[name="from_date"]').val();
                var todate = $(this).find('input[name="to_date"]').val();
                if (fromdate.length != 0 || todate.length != 0) {
                    $('#datatable').dataTable().api().ajax.reload();
                }
                return false;
            });

            $(".navigation-menu a").each(function() {
                alert();
            });

            $('select').change(function(event) {
                var ele = $(this);
                if (ele.val() != '') {
                    $(this).closest('div.form-group').find('p.error').remove();
                }
            });

            $("#editForm").validate({
                rules: {
                    status: {
                        required: true,
                    },
                    txnid: {
                        required: true,
                    },
                    payid: {
                        required: true,
                    },
                    refno: {
                        required: true,
                    }
                },
                messages: {
                    name: {
                        required: "Please select status",
                    },
                    txnid: {
                        required: "Please enter txn id",
                    },
                    payid: {
                        required: "Please enter payid",
                    },
                    refno: {
                        required: "Please enter ref no",
                    }
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    if (element.prop("tagName").toLowerCase() === "select") {
                        error.insertAfter(element.closest(".form-group").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var form = $('#editForm');
                    var id = form.find('[name="id"]').val();
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button[type="submit"]').html('Please wait...').attr(
                                'disabled', true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button[type="submit"]').html('Update').attr(
                                'disabled', false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status == "success") {
                                form.closest('.offcanvas').offcanvas('hide');
                                notify("Task Successfully Completed", 'success');
                                $('#datatable').dataTable().api().ajax.reload();
                            } else {
                                notify(data.status, 'warning');
                            }
                        },
                        error: function(errors) {
                            showError(errors, form);
                        }
                    });
                }
            });

            setTimeout(function() {
                sessionOut();
            }, "{{ $mydata['sessionOut'] }}");

            $(".modal").on('hidden.bs.modal', function() {
                if ($(this).find('form').length) {
                    $(this).find('form')[0].reset();
                }

                if ($(this).find('.select').length) {
                    $(this).find('.select').val(null).trigger('change');
                }
            });

            $("#walletLoadForm").validate({
                rules: {
                    amount: {
                        required: true,
                    }
                },
                messages: {
                    amount: {
                        required: "Please enter amount",
                    },
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    if (element.prop("tagName").toLowerCase() === "select") {
                        error.insertAfter(element.closest(".form-group").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var form = $('#walletLoadForm');
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('loading..').attr('disabled',
                                true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button:submit').html('Submit').attr('disabled',
                                false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status) {
                                form[0].reset();

                                form.closest('.offcanvas').offcanvas('hide');
                                notify("Wallet successfully loaded", 'success');
                                window.location.reload();
                            } else {
                                notify(data.status, 'warning');
                            }
                        },
                        error: function(errors) {
                            showError(errors, form);
                            notify('Something went wrong', 'error');
                        }
                    });
                }
            });

            $("#notifyForm").validate({
                rules: {
                    amount: {
                        required: true,
                    }
                },
                messages: {
                    amount: {
                        required: "Please enter amount",
                    },
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    if (element.prop("tagName").toLowerCase() === "select") {
                        error.insertAfter(element.closest(".form-group").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var form = $('#notifyForm');
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('Please wait...').attr(
                                'disabled',
                                true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button:submit').html('Submit').attr('disabled',
                                false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status) {
                                form[0].reset();

                                form.closest('.modal').modal('hide');
                                notify("Send successfully", 'success');
                            } else {
                                notify(data.status, 'warning');
                            }
                        },
                        error: function(errors) {
                            showError(errors, form);
                            notify('Something went wrong', 'error');
                        }
                    });
                }
            });

            $("#complaintForm").validate({
                rules: {
                    subject: {
                        required: true,
                    },
                    description: {
                        required: true,
                    }
                },
                messages: {
                    subject: {
                        required: "Please select subject",
                    },
                    description: {
                        required: "Please enter your description",
                    },
                },
                errorElement: "p",
                errorPlacement: function(error, element) {
                    if (element.prop("tagName").toLowerCase() === "select") {
                        error.insertAfter(element.closest(".form-group").find(".select2"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler: function() {
                    var form = $('#complaintForm');
                    form.ajaxSubmit({
                        dataType: 'json',
                        beforeSubmit: function() {
                            form.find('button:submit').html('Please wait...').attr(
                                'disabled',
                                true).addClass('btn-secondary');
                        },
                        complete: function() {
                            form.find('button:submit').html('Update').attr('disabled',
                                false).removeClass('btn-secondary');
                        },
                        success: function(data) {
                            if (data.status) {
                                form[0].reset();
                                form.closest('.offcanvas').offcanvas('hide');
                                notify("Complaint successfully submitted", 'success');
                            } else {
                                notify(data.status, 'warning');
                            }
                        },
                        error: function(errors) {
                            showError(errors, form);
                            notify('Something went wrong', 'error');
                        }
                    });
                }
            });
        });


        @if(isset($table) && $table == 'yes')

        function datatableSetup(urls, datas, onDraw = function() {}, ele = "#datatable", element = {}) {
            var options = {
                dom: '<"datatable-scroll"t><"datatable-footer"ip>',
                processing: true,
                serverSide: true,
                ordering: false,
                stateSave: true,
                searching: true,
                columnDefs: [{
                    orderable: false,
                    width: '130px',
                    targets: [0]
                }],
                language: {
                    paginate: {
                        'first': 'First',
                        'last': 'Last',
                        'next': '&rarr;',
                        'previous': '&larr;'
                    }
                },
                drawCallback: function() {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
                },
                preDrawCallback: function() {
                    $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
                },
                ajax: {
                    url: urls,
                    type: "post",
                    data: function(d) {
                        d._token = $('meta[name="csrf-token"]').attr('content');
                        d.fromdate = $('#searchForm').find('[name="from_date"]').val();
                        d.todate = $('#searchForm').find('[name="to_date"]').val();
                        d.searchtext = $('#searchForm').find('[name="searchtext"]').val();
                        d.agent = $('#searchForm').find('[name="agent"]').val();
                        d.status = $('#searchForm').find('[name="status"]').val();
                        d.product = $('#searchForm').find('[name="product"]').val();
                        d.department_id = $('#searchForm').find('[name="department_id"]').val();
                    },
                    beforeSubmit: function() {
                        $('#searchForm').find('button:submit').html('Loading').attr("disabled", true).addClass(
                            'btn-secondary');
                    },
                    complete: function() {
                        $('#searchForm').find('button:submit').html(
                                'Filter &nbsp;  <i class="ti ti-filter-share"></i>').attr("disabled", false)
                            .removeClass('btn-secondary');
                    },
                    error: function(response) {}
                },
                columns: datas
            };

            $.each(element, function(index, val) {
                options[index] = val;
            });

            var DT = $(ele).DataTable(options).on('draw.dt', onDraw);

            return DT;
        }
        @endif

        // function notify(msg, type = "success", notitype = "popup", element = "none") {
        //     if (notitype == "popup") {
        //         let snackbar = new SnackBar;
        //         snackbar.make("message", [
        //             msg,
        //             null,
        //             "bottom",
        //             "right",
        //             "text-" + type
        //         ], 5000);
        //     } else {
        //         element.find('div.alert').remove();
        //         element.prepend(`<div class="alert bg-` + type + ` alert-styled-left">
        //             <button type="button" class="btn-close" data-dismiss="alert"><span></span><span class="sr-only">Close</span></button> ` + msg + `
        //         </div>`);

        //         setTimeout(function() {
        //             element.find('div.alert').remove();
        //         }, 5000);
        //     }
        // }
        function getPrevious(date = new Date(), days = 1) {
            const previous = new Date(date.getTime());
            previous.setDate(date.getDate() - days);

            return previous;
        }

        function showError(errors, form = "withoutform") {
            if (form != "withoutform") {
                $('p.error').remove();
                $('div.alert').remove();
                if (errors.status == 422) {
                    $.each(errors.responseJSON.errors, function(index, value) {
                        form.find('[name="' + index + '"]').closest('div.form-group').append('<p class="error">' +
                            value + '</span>');
                    });
                    form.find('p.error').first().closest('.form-group').find('input').focus();
                    setTimeout(function() {
                        form.find('p.error').remove();
                    }, 5000);
                } else if (errors.status == 400) {
                    if (errors.responseJSON.message) {
                        form.prepend(`<div class="alert bg-danger alert-styled-left">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"><span></span><span class="sr-only">Close</span></button>
                            <span class="text-semibold">Oops !</span> ` + errors.responseJSON.message + `
                        </div>`);
                    } else {
                        form.prepend(`<div class="alert bg-danger alert-styled-left">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"><span></span><span class="sr-only">Close</span></button>
                            <span class="text-semibold">Oops !</span> ` + errors.responseJSON.status + `
                        </div>`);
                    }

                    setTimeout(function() {
                        form.find('div.alert').remove();
                    }, 10000);
                } else {
                    notify(errors.statusText, 'warning');
                }
            } else {
                if (errors.responseJSON.message) {
                    notify(errors.responseJSON.message, 'warning');
                } else {
                    notify(errors.responseJSON.status, 'warning');
                }
            }
        }

        function sessionOut() {
            window.location.href = "{{ route('logout') }}";
        }

        function status(id, type) {
            $.ajax({
                url: `{{ route('statementStatus') }}`,
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'id': id,
                    "type": type
                },
                dataType: 'json',
                beforeSend: function() {
                    swal({
                        title: 'Wait!',
                        text: 'Please wait, we are fetching transaction details',
                        onOpen: () => {
                            swal.showLoading()
                        },
                        allowOutsideClick: () => !swal.isLoading()
                    });
                },
                success: function(data) {
                    if (data.statuscode == "TXN" || data.status == 'success') {
                        if (data.txnStatus == undefined || data.txnStatus == null) {
                            var ot = data.status;
                        } else {
                            var ot = data.txnStatus;

                        }
                        var refno = "Your transaction " + ot;
                        swal({
                            type: 'success',
                            title: "Transaction status",
                            text: refno,
                            onClose: () => {
                                $('#datatable').dataTable().api().ajax.reload();
                            }
                        });
                    } else if (data.statuscode == "TXF" || data.status == 'failed' || data.status ==
                        'reversed') {
                        if (data.txnStatus == undefined || data.txnStatus == null) {
                            var ot = data.status;
                        } else {
                            var ot = data.txnStatus;

                        }
                        var refno = "Your transaction " + ot;
                        swal({
                            type: 'success',
                            title: "Transaction status",
                            text: refno,
                            onClose: () => {
                                $('#datatable').dataTable().api().ajax.reload();
                            }
                        });

                    } else {
                        swal({
                            type: 'warning',
                            title: "Transaction status",
                            text: data.message || "Please try after sometimes",
                            onClose: () => {
                                $('#datatable').dataTable().api().ajax.reload();
                            }
                        });
                    }
                },
                error: function(errors) {
                    swal.close();
                    $('#datatable').dataTable().api().ajax.reload();
                    showError(errors, "withoutform");
                    notify(errors.responseJSON, 'error');

                }
            })

        }

        function editReport(id, refno, txnid, payid, remark, status, actiontype) {
            $('#editModal').find('[name="id"]').val(id);
            $('#editModal').find('[name="status"]').val(status).trigger('change');
            $('#editModal').find('[name="refno"]').val(refno);
            $('#editModal').find('[name="txnid"]').val(txnid);
            if (actiontype == "billpay") {
                $('#editModal').find('[name="payid"]').closest('div.form-group').remove();
            } else {
                $('#editModal').find('[name="payid"]').val(payid);
            }
            $('#editModal').find('[name="remark"]').val(remark);
            $('#editModal').find('[name="actiontype"]').val(actiontype);
            $('#editModal').offcanvas('show');
        }

        function complaint(id, product) {
            $('#complaintModal').find('[name="transaction_id"]').val(id);
            $('#complaintModal').find('[name="product"]').val(product);
            $('#complaintModal').offcanvas('show');
        }

        function notify(text, status) {
            new Notify({
                status: status,
                title: null,
                text: text,
                effect: 'fade',
                customClass: null,
                customIcon: null,
                showIcon: true,
                showCloseButton: true,
                autoclose: true,
                autotimeout: 2000,
                gap: 20,
                distance: 15,
                type: 1,
                position: 'right top'
            })
        }
    </script>
</head>

<body>


    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <div class="preloader">
            <span class="loader"></span>
        </div>

        <!-- Header -->
        @include('layouts/header')
        <!-- /Header -->

        <!-- Sidebar -->
        @include('layouts/sidebar_new')
        <!-- /Sidebar -->

        <!-- Page Wrapper -->
        <div class="page-wrapper">
            @yield('content')
        </div>

        @include('layouts/footer')
        <!-- /Page Wrapper -->

    </div>



    <div class="offcanvas offcanvas-end" id="editModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">

        <div class="offcanvas-header bg-primary">
            <h5 class="text-white" id="exampleModalLabel">Edit Report</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>


    </div>

    <div class="offcanvas offcanvas-end" id="complaintModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">

        <div class="offcanvas-header bg-primary">
            <h5 class="text-white" id="exampleModalLabel">Complaint</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>


    </div>

    <!-- /Main Wrapper -->


    <!-- Bootstrap Core JS -->
    <script src="{{ asset('') }}assets1/js/bootstrap.bundle.min.js"></script>

    <!-- Feather Icon JS -->
    <script src="{{ asset('') }}assets1/js/feather.min.js"></script>

    <!-- Slimscroll JS -->
    <script src="{{ asset('') }}assets1/js/jquery.slimscroll.min.js"></script>

    <!-- Datatable JS -->
    @if (isset($table) && $table == 'yes')
    <script src="{{ asset('') }}assets1/js/dataTables.bootstrap5.min.js"></script>
    @endif
    <!-- Daterangepicker JS -->
    <script src="{{ asset('') }}assets1/js/moment.min.js"></script>
    <script src="{{ asset('') }}assets1/plugins/daterangepicker/daterangepicker.js"></script>

    <!-- Datetimepicker JS -->
    {{-- <script src="{{ asset('') }}assets1/js/bootstrap-datetimepicker.min.js"></script> --}}

    <!-- Bootstrap Tagsinput JS -->
    <script src="{{ asset('') }}assets1/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>

    <!-- Apexchart JS -->
    <script src="{{ asset('') }}assets1/plugins/apexchart/apexcharts.min.js"></script>
    <script src="{{ asset('') }}assets1/plugins/apexchart/chart-data.js"></script>
    <script src="{{ asset('') }}frontend/js/summernote.min.js"></script>
    <!-- Chart JS -->
    <script src="{{ asset('') }}assets1/plugins/peity/jquery.peity.min.js"></script>
    <script src="{{ asset('') }}assets1/plugins/peity/chart-data.js"></script>
    <script src="{{ asset('') }}assets1/js/chart.js"></script>

    <!-- Select2 JS -->
    <script src="{{ asset('theme_1/assets/js/config.js') }}"></script>
    <script src="{{ asset('') }}assets1/plugins/select2/js/select2.min.js"></script>

    <!-- Custom Json Js -->
    <script src="{{ asset('') }}assets1/js/jsonscript.js"></script>

    <!-- Color Picker JS -->
    <script src="{{ asset('') }}assets1/plugins/@simonwep/pickr/pickr.es5.min.js"></script>
    <!-- Summernote CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">

    <!-- Summernote JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>

    <!--- Custom Js -->
    <script src="{{ asset('') }}assets1/js/theme-colorpicker.js"></script>
    <script src="{{ asset('') }}assets1/js/script.js"></script>
    <script src="{{ asset('js/home.js') }}"></script>
    <script src="{{ asset('assets/plugins/apexchart/apexcharts.min.js') }}" type="2627e75a2cda453f4eabbc34-text/javascript"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script type="text/javascript" src="{{ asset('') }}assets/js/core/jquery.validate.min.js"></script>
    <script type="text/javascript" src="{{ asset('') }}assets/js/core/sweetalert2@11.js"></script>
    <!-- JS -->

    {{-- <script src="{{ asset('') }}assets/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script> --}}


    <script src="{{ asset('assets1/js/bootstrap-datepicker.min.js') }}"></script>
    <script type="text/javascript">
        let webbaseurl = window.location.origin;
    </script>
    <!-- Themescript JS -->
    <script src="{{ asset('') }}assets1/js/theme-script.js"></script>
    @stack('script')
</body>

</html>