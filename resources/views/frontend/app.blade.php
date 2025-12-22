<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title', 'iUniversity ® India’s Leading Online Learning Platform')</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="TemplatesJungle">
    <meta name="keywords" content="Online Store">
    <meta name="description" content="">
    <link rel="icon" type="image/png" href="{{ asset('frontend/images/icons/favicon.jpg') }}">

    <link rel="stylesheet" href="{{ asset('') }}frontend/css/vendor.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}frontend/css/style.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}frontend/css/theme.css.php">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}frontend/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}frontend/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}frontend/css/summernote.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}frontend/css/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('') }}frontend/css/intlTelInput.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/simple-notify@0.5.5/dist/simple-notify.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">



    <script>
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

    @include('frontend.header')

    @yield('content')

    @include('frontend.footer')

    <style>
        #userMenu+.dropdown-menu {
            min-width: 90px !important;
            font-size: 13px !important;
            padding: 4px 0 !important;
        }

        #userMenu+.dropdown-menu .dropdown-item {
            padding: 4px 8px !important;
            font-size: 13px !important;
        }

        .paradetail {
            max-height: 300px;
            overflow: hidden;
            transition: max-height 1s ease;
        }

        .paradetail.expanded {
            max-height: none;
        }

        .para {
            max-height: 85px;
            overflow: hidden;
            transition: max-height 1s ease;
        }

        .para.expanded {
            max-height: none;
        }

        #loanModal .nav-pills .nav-link {
            border-radius: 0;
            padding: 12px 16px;
            color: #333;
            background: #f8f9fa;
        }

        #loanModal .nav-pills .nav-link.active {
            background-color: #fdecec;
            color: #d9534f;
            border-left: 3px solid #d9534f;
        }

        #loanModal .accordion-button {
            background: #fff;
            box-shadow: none;
            font-weight: 500;
            padding-left: 1.25rem !important;
        }

        #loanModal .accordion-button:not(.collapsed) {
            color: #d9534f;
            background-color: #fff8f8;
        }

        #loanModal .table {
            margin-bottom: 0;
        }

        .compare-text {
            overflow-x: auto;
            /* horizontal scroll enable */
            overflow-y: hidden;
            /* vertical scroll disable (optional) */
            display: block;
            max-width: 100%;
        }

        .compare-text table {
            width: 100%;
            border-collapse: collapse;
        }

        .compare-text img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        .sidebar {
            background-color: #fff;
            border: 1px solid #e6e6e6;
            border-radius: 12px;
            padding: 20px;
        }

        .filter-group h6 {
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }

        .form-check-label {
            font-size: 13px;
            color: #555;
        }

        .course-card {
            background: #fff;
            border: 1px solid #e6e6e6;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .course-logo {
            width: 60px;
            height: 60px;
            background: #f3f3f3;
            border-radius: 6px;
        }

        .course-title {
            font-weight: 600;
            font-size: 16px;
            color: #222;
            margin: 0;
        }

        .course-info {
            font-size: 13px;
            color: #555;
        }

        .tag {
            background: #f3f3f3;
            color: #333;
            border-radius: 12px;
            padding: 4px 10px;
            font-size: 12px;
            margin-right: 6px;
        }

        .btn-outline-dark {
            border-color: #e6e6e6;
            color: #333;
        }

        .btn-outline-dark:hover {
            background: #f5f5f5;
            color: #000;
        }

        .btn-danger {
            background-color: #e93535;
            border: none;
        }

        .btn-danger:hover {
            background-color: #d32f2f;
        }

        .pagination .page-link {
            border-radius: 50%;
            color: #333;
            border: 1px solid #e6e6e6;
            width: 36px;
            height: 36px;
            text-align: center;
            line-height: 34px;
        }

        .pagination .active>.page-link {
            background-color: #e93535;
            border: none;
            color: #fff;
        }

        .awards-slider {
            display: flex;
            gap: 40px;
            overflow: hidden;
            scroll-behavior: smooth;
        }

        .award-card {
            flex: 0 0 320px;
            background: #fff;
            margin: 0 10px;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 20px;
            transition: transform 0.9s ease;
        }

        .award-card:hover {
            transform: translateY(-5px);
        }

        .award-card img {
            width: 100px;
            height: 100px;
            object-fit: contain;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        .award-card h5 {
            font-weight: 600;
            margin-bottom: 8px;
        }

        .award-card p {
            font-size: 14px;
            color: #555;
            margin: 0;
        }

        @keyframes scrollAwards {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }

        .awards-scroll-wrapper {
            display: flex;
            width: max-content;
            animation: scrollAwards 10s linear infinite;
        }

        .awards-container {
            overflow: hidden;
            position: relative;
            width: 100%;
        }

        body {
            padding-top: 50px;
        }

        .header-top {
            background: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            z-index: 1050;
            position: fixed;
        }
    </style>

    <script src="{{ asset('') }}frontend/js/jquery-1.11.0.min.js"></script>
    <script src="{{ asset('') }}frontend/js/plugins.js"></script>
    <script src="{{ asset('') }}frontend/js/script.js"></script>
    <script src="{{ asset('') }}frontend/js/select2.min.js"></script>
    <script src="{{ asset('') }}frontend/js/summernote.js"></script>
    <script src="{{ asset('') }}frontend/js/summernote.min.js"></script>
    <script src="{{ asset('') }}frontend/js/owl.carousel.min.js"></script>

    <script src="{{ asset('') }}frontend/js/intlTelInput-jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        $("#mobile_code").intlTelInput({
            initialCountry: "in",
            separateDialCode: true,
        });
        flatpickr("#callback_date", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",   
            time_24hr: true,         
            minDate: "today"          
        });
    </script>

    <script>
        $(document).ready(function() {
            var videoModal = document.getElementById("videoModal");
            if (videoModal) {
                var videoPlayer = document.getElementById("videoPlayer");
                var videoTitle = document.getElementById("videoModalLabel");

                videoModal.addEventListener("show.bs.modal", function(event) {
                    var button = event.relatedTarget;
                    if (!button) return;

                    var videoUrl = button.getAttribute("data-video") || "";
                    var title = button.getAttribute("data-title") || "Video";

                    videoPlayer.src = videoUrl + "?autoplay=1&mute=1";
                    videoTitle.textContent = title;
                });

                videoModal.addEventListener("hidden.bs.modal", function() {
                    videoPlayer.src = "";
                });
            }
        });
        $(document).on('click', '.search-btn', function(e) {
            e.preventDefault();

            var query = $(this).closest('div').find('.search-input').val().trim();

            if (query !== '') {
                var searchUrl = "{{ url('search') }}" + "?query=" + encodeURIComponent(query);
                window.location.href = searchUrl;
            } else {
                notify('Please enter something to search!', 'error');
            }
        });
    </script>
    <script>
        $(document).ready(function() {

            $('#btnFinalize').on('click', function() {
                let data = {
                    _token: "{{ csrf_token() }}",
                    programme_id: $('#modalProgrammeId').val(),
                    full_name: $('#full_name').val().trim(),
                    mobile: $('#mobile').val().trim(),
                    qualification: $('#qualification').val().trim(),
                    institute: $('#institute').val().trim(),
                    remarks: $('#remarks').val().trim(),
                    amount: $('#amount').val()
                };

                if (data.full_name === '' || data.mobile === '') {
                    $('#applyAlert').html('<div class="alert alert-danger">Please fill required fields.</div>');
                    return;
                }

                $.ajax({
                    url: "{{ url('save-application') }}",
                    type: "POST",
                    data: data,
                    beforeSend: function() {
                        $('#btnFinalize').prop('disabled', true).text('Processing...');
                        $('#applyAlert').html('');
                    },
                    success: function(response) {
                        $('#btnFinalize').prop('disabled', false).text('Proceed to Payment');

                        if (response.success && response.payment_url) {
                            $('#applyAlert').html('<div class="alert alert-success">Redirecting to payment...</div>');
                            setTimeout(() => {
                                window.location.href = response.payment_url;
                            }, 1000);
                        } else {
                            $('#applyAlert').html('<div class="alert alert-danger">' + response.message + '</div>');
                        }
                    },
                    error: function() {
                        $('#btnFinalize').prop('disabled', false).text('Proceed to Payment');
                        $('#applyAlert').html('<div class="alert alert-danger">Something went wrong. Please try again.</div>');
                    }
                });
            });

        });
    </script>

    <script>
        const shareBtn = $('.shareBtn');

        shareBtn.on('click', async function(e) {
            e.preventDefault();

            if (navigator.share) {
                try {
                    await navigator.share({
                        title: document.title,
                        text: 'Check out this page!',
                        url: window.location.href
                    });
                    console.log('Shared successfully');
                } catch (err) {
                    console.error('Error sharing:', err);
                }
            } else {
                notify('Your browser does not support sharing. You can copy the URL manually: ' + window.location.href, 'error');
            }
        });
        $('.moreless-button').click(function() {
            $(this).prev('.moretext').slideToggle();
            if ($(this).text().trim() === "Read More") {
                $(this).text("Read Less");
            } else {
                $(this).text("Read More");
            }
        });
    </script>
    <script>
        $('.paradetail').each(function() {
            const content = $(this);
            const btn = content.next('.toggle-btn');
            if (content[0].scrollHeight > content.outerHeight()) {
                btn.show();
            }

            btn.on('click', function() {
                content.toggleClass('expanded');
                $(this).text(content.hasClass('expanded') ? 'Read Less' : 'Read More');
            });
        });
        $('.para').each(function() {
            const content = $(this);
            const btn = content.next('.toggle-btn');
            if (content[0].scrollHeight > content.outerHeight()) {
                btn.show();
            }

            btn.on('click', function() {
                content.toggleClass('expanded');
                $(this).text(content.hasClass('expanded') ? 'Read Less' : 'Read More');
            });
        });
    </script>

    <script>
        $(document).ready(function() {

            setTimeout(function() {
                var myModal = new bootstrap.Modal(document.getElementById('updateModal'));
                myModal.show();
            }, 3000);


            var currentStep = 1;
            var userMobile = '';

            function displayStep(stepNumber) {
                $(".step").hide();
                $(".step-" + stepNumber).show();
                currentStep = stepNumber;

                if (stepNumber === 3) {
                    resetStep3();
                } else if (stepNumber === 4) {
                    resetStep4();
                } else if (stepNumber === 5) {
                    resetStep5();
                }
            }

            displayStep(1);

            // ---------------- Step 1 ----------------
            $("#mobile_code").on('keyup change', function() {
                $("#btnSubmit").prop("disabled", false);
            });

            $("#btnSubmit").click(function(e) {
                e.preventDefault();
                userMobile = $("#mobile_code").val().trim();

                $.ajax({
                    url: "{{ route('send.otp') }}",
                    type: "POST",
                    data: {
                        mobile: userMobile,
                        _token: "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                        $("#btnSubmit").text('Sending...');
                        $("#btnSubmit").prop("disabled", true);
                    },
                    success: function(res) {
                        notify(res.message, 'success');
                        $("#displayMobile").text(userMobile);
                        window.userExists = res.exists;
                        displayStep(2);
                        $('.otp-number-input').val('').first().focus();
                        $(".otp-verify-btn").prop("disabled", false);
                        startCountdown();
                        $("#btnSubmit").text('Continue');
                        $("#btnSubmit").prop("disabled", false);
                    },
                    error: function(xhr) {
                        var errMsg = 'Server error';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errMsg = xhr.responseJSON.message;
                        }
                        notify(errMsg, 'error');
                        $("#btnSubmit").text('Continue');
                        $("#btnSubmit").prop("disabled", false);
                    }
                });
            });




            $("#editMobile").click(function(e) {
                e.preventDefault();
                displayStep(1);
            });

            // ---------------- Step 2 ----------------
            $(document).on('input', '.otp-number-input', function() {
                var $this = $(this);
                $this.val($this.val().replace(/\D/g, ''));
                if ($this.val().length === 1) {
                    $this.next('.otp-number-input').focus();
                }
                $(".otp-verify-btn").prop("disabled", false);
            });

            $(document).on('keydown', '.otp-number-input', function(e) {
                if (e.key === "Backspace" && $(this).val() === '') {
                    $(this).prev('.otp-number-input').focus();
                }
            });

            $(document).on('click', '.otp-verify-btn', function(e) {
                e.preventDefault();
                var otpCode = '';
                $('.otp-number-input').each(function() {
                    otpCode += $(this).val();
                });

                $.ajax({
                    url: "{{ route('verify.otp') }}",
                    type: "POST",
                    data: {
                        phone: userMobile,
                        otp: otpCode,
                        _token: "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                        $(".otp-verify-btn").text('Verifying...');
                        $(".otp-verify-btn").prop("disabled", true);
                    },
                    success: function(res) {
                        if (res.status === 'TXN') {
                            notify(res.message, 'success');
                            let redirectUrl = $("#redirect_url").val() || "{{ url('/student-dashboard') }}";
                            if (res.exists) {
                                window.location.href = redirectUrl;
                            } else {
                                displayStep(3);
                            }
                        } else {
                            notify(res.message || 'Something went wrong', 'error');
                        }
                    },

                    error: function(xhr) {
                        var errMsg = 'Server error';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errMsg = xhr.responseJSON.message;
                        }
                        notify(errMsg, 'error');
                    },
                    complete: function() {
                        $(".otp-verify-btn").text('Verify OTP');
                        $(".otp-verify-btn").prop("disabled", false);
                    }
                });
            });

            $(document).on('click', '.save-step-btn', function(e) {
                e.preventDefault();

                $.ajax({
                    url: "{{ route('save.step') }}",
                    type: "POST",
                    data: {
                        phone: userMobile,
                        name: $("#FullName").val(),
                        email: $("#Fullemail").val(),
                        qualification: $("#highest_qualification").val(),
                        interest: $("#area_of_interest").val(),
                        updates: $("#flexCheckChecked").is(":checked"),
                        _token: "{{ csrf_token() }}"
                    },
                    beforeSend: function() {
                        $(".save-step-btn").text('Please Wait...');
                        $(".save-step-btn").prop("disabled", true);
                    },
                    success: function(res) {
                        if (res.success) {
                            displayStep(4);

                        } else {
                            notify(res.message || 'Something went wrong', 'error');
                        }
                    },
                    error: function(xhr) {
                        var errMsg = 'Server error';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errMsg = xhr.responseJSON.message;
                        }
                        notify(errMsg, 'error');
                    },
                    complete: function() {
                        $(".save-step-btn").text('Continue');
                        checkStep3Fields();
                    }
                });
            });
            $(document).on('click', '.skipbtn', function() {
                window.location.href = "{{ url('/') }}";
            });

            $(document).on('click', '.step-4', function(e) {
                e.preventDefault();
                displayStep(5);
            });


            $(document).on('click', '.final-step', function(e) {
                e.preventDefault();

                var form = $("#step5Form");
                var url = form.attr('action');
                var token = form.find('input[name="_token"]').val();

                var formData = form.serialize();

                $.ajax({
                    url: url,
                    type: "POST",
                    data: formData,
                    beforeSend: function() {
                        $(".final-step").text('Submitting...');
                        $(".final-step").prop("disabled", true);
                    },
                    success: function(res) {
                        if (res.success) {
                            notify(res.message, 'success');
                            $('#stepmodal').modal('hide');
                            setTimeout(function() {
                                window.location.href = res.redirect_url;
                            }, 200);
                        } else {
                            notify(res.message || 'Something went wrong', 'error');
                        }
                    },
                    error: function(xhr) {
                        var errMsg = 'Server error';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errMsg = xhr.responseJSON.message;
                        }
                        notify(errMsg, 'error');
                    },
                    complete: function() {
                        $(".final-step").text('Submit');
                        $(".final-step").prop("disabled", false);
                    }
                });
            });



            // ---------------- OTP Resend ----------------
            var countdownInterval;

            function startCountdown() {
                var seconds = 60;
                var counter = $("#counter");
                if (countdownInterval) {
                    clearInterval(countdownInterval);
                }

                $("#verifiBtn").html(counter);
                counter.text("0:" + (seconds < 10 ? "0" : "") + seconds);

                countdownInterval = setInterval(function() {
                    seconds--;
                    if (seconds >= 0) {
                        counter.text("0:" + (seconds < 10 ? "0" : "") + seconds);
                    } else {
                        clearInterval(countdownInterval);
                        $("#verifiBtn").html('<a href="#" style="color: blue;" id="resendOtp">Resend</a>');
                    }
                }, 1000);
            }

            $(document).on('click', '#resendOtp', function(e) {
                e.preventDefault();

                $("#btnSubmit").click();

                startCountdown();
            });
            // ---------------- Previous Step ----------------
            $(".prev-step").click(function(e) {
                e.preventDefault();
                if (currentStep > 1) {
                    displayStep(currentStep - 1);
                }
            });

            // ---------------- Step 3 ----------------
            function resetStep3() {
                $('#submitbutton').prop('disabled', true);
                $('#FullName').val('');
                $('#Fullemail').val('');
                // $(".step-3 select").val('');
                $('#flexCheckChecked').prop('checked', false);
                checkStep3Fields();

                $('.fillDetail, select').off('keyup change').on('keyup change', function() {
                    checkStep3Fields();
                });
            }

            function checkStep3Fields() {
                let allFilled = true;
                $(".step-3 .fillDetail, .step-3 select").each(function() {
                    let val = $(this).val();
                    if (val === null || val.trim() === '') {
                        allFilled = false;
                        return false;
                    }
                });
                $('#submitbutton').prop('disabled', !allFilled);
            }

            // ---------------- Step 4 ----------------
            function resetStep4() {
                $(".step-4 .fillDetail, .step-4 select").val('');
                checkStep4Fields();
                $(".step-4 .fillDetail, .step-4 select").off('keyup change').on('keyup change', function() {
                    checkStep4Fields();
                });
            }

            function checkStep4Fields() {
                let allFilled = true;
                $(".step-4 .fillDetail, .step-4 select").each(function() {
                    let val = $(this).val();
                    if (val === null || val.trim() === '') {
                        allFilled = false;
                        return false;
                    }
                });
                $(".step-4 .next-step").prop('disabled', !allFilled);
            }

            // ---------------- Step 5 ----------------
            function resetStep5() {
                $(".step-5 .fillDetail, .step-5 select").each(function() {
                    this.selectedIndex = 0;
                });
                checkStep5Fields();
                $(".step-5 .fillDetail, .step-5 select").off('keyup change').on('keyup change', function() {
                    checkStep5Fields();
                });
            }


            function checkStep5Fields() {
                let allFilled = true;
                $(".step-5 .fillDetail, .step-5 select").each(function() {
                    let val = $(this).val();
                    if (val === null || val.trim() === '') {
                        allFilled = false;
                        return false;
                    }
                });
                $(".step-5 .btn-primary").prop('disabled', !allFilled);
            }

        });
    </script>

    <script>
        $('.product-slider').owlCarousel({
            loop: true,
            margin: 30,
            autoplay: true,
            nav: false,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 3
                }
            }
        })
    </script>
    <script>
        // $('.brandEmployee').owlCarousel({
        //     loop: true,
        //     margin: 20,
        //     autoplay: true,
        //     nav: false,
        //     autoplayTimeout: 1000,
        //     autoplaySpeed: 1000,
        //     fluidSpeed: true,
        //     responsive: {
        //         0: {
        //             items: 2
        //         },
        //         600: {
        //             items: 4
        //         },
        //         1000: {
        //             items: 8
        //         }
        //     }
        // });

        $('.brandEmployee').owlCarousel({
            loop: true,
            margin: 30,
            autoplay: false,
            nav: false,
            dots: false,
            responsive: {
                0: {
                    items: 2
                },
                600: {
                    items: 4
                },
                1000: {
                    items: 8
                }
            }
        });

        let $stage = $('.brandEmployee .owl-stage');
        $stage.append($stage.html());




        $('.brandPartner').owlCarousel({
            loop: true,
            margin: 30,
            autoplay: true,
            nav: false,
            autoplayTimeout: 1000,
            autoplaySpeed: 1000,
            fluidSpeed: true,
            responsive: {
                0: {
                    items: 2
                },
                600: {
                    items: 4
                },
                1000: {
                    items: 8
                }
            }
        })
    </script>


    <script>
        $('.Popular-course').owlCarousel({
            loop: true,
            margin: 0,
            autoplay: true,
            dots: false,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 3
                }
            }
        });
        $('.chatgpt-course').owlCarousel({
            loop: false,
            margin: 0,
            dots: false,
            autoplay: true,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 3
                }
            }
        });
        $('.InstructorSlider').owlCarousel({
            loop: true,
            margin: 0,
            dots: false,
            autoplay: true,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 3
                }
            }
        });

        $('.trending-course').owlCarousel({
            loop: true,
            margin: 0,
            dots: false,
            autoplay: true,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 3
                }
            }
        });

        $('.testimonials-theme').owlCarousel({
            loop: true,
            margin: 30,
            dots: false,
            autoplay: true,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 3
                }
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $(".menu-item").hover(
                function() {
                    $('.mainBody').addClass("result_hover");
                },
                function() {
                    $('.mainBody').removeClass("result_hover");
                }
            );
        })
    </script>
    @stack('script')
</body>

</html>