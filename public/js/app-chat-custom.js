$(document).ready(function () {
    $("#addContactForm").validate({
        rules: {
            name: {
                required: true,
            },
            email: {
                required: true,
            },
            mobile: {
                required: true,
                number: true,
                minlength: 10,
                maxlength: 10
            },
            is_visible: {
                required: true,
            },
            status: {
                required: true,
            },
        },
        messages: {
            name: {
                required: "Please Enter  Name",
            },
            email: {
                required: "Please Enter Email",
            },
            mobile: {
                required: "Please enter Mobile number",
                number: "Mobile number should be numeric",
                minlength: "Mobile number should be exact 10 digit",
                maxlength: "Mobile number should be exact 10 digit",
            },
            is_visible: {
                required: "Please select Visibility",
            },
            status: {
                required: "Please select status",
            }
        },
        errorElement: "p",
        errorPlacement: function (error, element) {
            if (element.prop("tagName").toLowerCase() === "select") {
                error.insertAfter(element.closest(".form-group").find(".select2"));
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function () {
            var form = $('#addContactForm');
            form.ajaxSubmit({
                dataType: 'json',
                beforeSubmit: function () {
                    $('#contact_btn').attr('disabled', true).addClass('btn-secondary').removeClass('btn-primary');
                },
                success: function (data) {
                    $('#contact_btn').attr('disabled', false).removeClass('btn-secondary').addClass('btn-primary');
                    if (data?.status == 'success') {
                        form[0].reset();
                        notify(data.message || "Contact Added Successfully", 'success');
                        $('#addContactModal').modal('hide');
                        location.reload();
                    } else {
                        notify(data.message || data.status ||
                            "Something went wrong", 'error');
                    }
                },
                error: function (errors) {
                    $('#contact_btn').attr('disabled', false).removeClass('btn-secondary').addClass('btn-primary');
                    notify(errors.responseJSON.status || errors.responseJSON?.message || "Something went wrong", 'error');
                }
            });
        }
    });

    $("#sendWhatsappTemp").validate({
        submitHandler: function () {
            var form = $('form#sendWhatsappTemp');
            form.ajaxSubmit({
                dataType: 'json',
                beforeSubmit: function () {
                    form.find('button:submit').html('Please wait...').attr(
                        'disabled', true).addClass('btn-secondary');
                },
                success: function (data) {
                    form.find('button:submit').html('Send Whatsapp Template').attr(
                        'disabled',
                        false).removeClass('btn-secondary');
                    if (data.status == "success") {
                        form[0].reset();
                        notify(data?.message || "Send Whatsapp Template Successfully",
                            'success');
                        $('#whatsappTemplateModal').modal('hide');
                        location.reload();
                    } else {
                        notify(data.status, 'error');
                    }
                },
                error: function (errors) {
                    form.find('button:submit').html('Send Whatsapp Template').attr(
                        'disabled', false).removeClass('btn-secondary');
                    notify(errors?.responseJSON?.message ||
                        "Something went wrong",
                        'error');
                }
            });
        }
    });

    $('select[name="template_name"]').on('change', function () {
        const selectedTemplate = $(this).val();

        if (!selectedTemplate) {
            $('#headerVarsContainer, #bodyVarsContainer, #exampleUrlsContainer').html('');
            return;
        }

        $.ajax({
            url: 'chat/template/details',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                template_name: selectedTemplate
            },
            success: function (res) {
                const headerVars = res.header_var ?? [];
                const bodyVars = res.body_var ?? [];
                // const examples = res.examples ?? [];

                // console.log(res, headerVars, bodyVars, examples);

                $('#headerVarsContainer, #bodyVarsContainer, #exampleUrlsContainer').html('');

                // Header Inputs
                headerVars.forEach((val, index) => {
                    $('#headerVarsContainer').append(`
                        <div class="col-sm-6">
                            <label>Header Variable {{${index + 1}}}</label>
                            <input type="text" name="header_var_${index + 1}" value="${val}" class="form-control mb-3" placeholder="Enter header var">
                        </div>
                    `);
                });

                // Body Inputs
                bodyVars.forEach((val, index) => {
                    $('#bodyVarsContainer').append(`
                        <div class="col-sm-6">
                            <label>Body Variable {{${index + 1}}}</label>
                            <input type="text" name="body_var_${index + 1}" value="${val}" class="form-control mb-3" placeholder="Enter body var">
                        </div>
                    `);
                });

                // Example URL Inputs
                // examples.forEach((url, index) => {
                //     $('#exampleUrlsContainer').append(`
                //         <div class="col-sm-6">
                //             <label>Example URL {{${index + 1}}}</label>
                //             <input type="url" name="example_url_${index + 1}" value="${url}" class="form-control mb-3" placeholder="https://www.example.com">
                //         </div>
                //     `);
                // });
            },
            error: function (errors) {
                console.log('Template Not found');
            }
        });
    });
});

function openChat(element) {
    // $(document).on('click', '.open-chat', function () {
    var $this = $(element);
    var name = $this.data('name');
    var email = $this.data('email');
    var mobile = $this.data('mobile');
    var avatar = $this.data('avatar');
    var about = $this.data('about');

    // 1. Show the chat history
    $('#app-chat-history').removeClass('d-none');
    $('#app-chat-conversation').addClass('d-none');

    // 2. Update chat header
    $(`.chat-contact-info h6.user-name`).text(name);
    $(`#contact-${mobile} .chat-contact-info h6`).text(name);
    $(`.chat-contact-info .user-status`).text(about);
    $(`.chat-history-header img`).attr('src', avatar);

    // 3. Update sidebar info
    $('#app-chat-sidebar-right h5').text(name);
    $('#app-chat-sidebar-right .about_desc').text(about);
    $('#app-chat-sidebar-right .chat-sidebar-avatar img').attr('src', avatar);

    // 4. Update personal info section
    $('#app-chat-sidebar-right ul').first().html(`
        <li class="d-flex align-items-center">
            <i class="ti ti-mail icon-md"></i>
            <span class="align-middle ms-2">${email}</span>
        </li>
        <li class="d-flex align-items-center">
            <i class="ti ti-phone-call icon-md"></i>
            <span class="align-middle ms-2">${mobile}</span>
        </li>
    `);
    $('.delete-contact-btn').attr('data-id', mobile);

    appendSentMessage(avatar, mobile);
    // });
}

function appendSentMessage(avatar = '', mobile = '') {

    $.ajax({
        url: '/chat/messages',
        method: 'GET',
        data: {
            mobile: mobile
        },
        success: function (response) {
            let currentTime = '';
            let messagesHtml = '';

            response.messages.forEach(msg => {

                let buttonHtml = '';
                if (msg.buttonJson) {
                    try {
                        const buttons = JSON.parse(msg.buttonJson);
                        buttons.forEach((btn) => {
                            if (btn) {
                                buttonHtml += `<span class="btn btn-light btn-sm m-1"><i class="fa fa-reply"></i> &nbsp;${btn}</span>`;
                            }
                        });
                    } catch (e) {
                        console.error('Button JSON parse error', e);
                    }
                }

                if (msg?.examples && msg?.urlButtonText) {
                    try {
                        const links = JSON.parse(msg.examples);
                        const labels = JSON.parse(msg.urlButtonText);

                        links.forEach((url, index) => {
                            const label = labels[index] || 'Link';
                            buttonHtml += `<a href="${url}" target="_blank" class="btn btn-light btn-sm m-1">
                                <i class="fa fa-external-link"></i> &nbsp;${label}
                            </a>`;
                        });
                    } catch (e) {
                        console.error('URL button parse error', e);
                    }
                }
                switch (msg.status) {
                    case 'submitted':
                        statusIcon = 'ti ti-clock text-muted';
                        statusLabel = 'Submitted';
                        break;
                    case 'sent':
                        statusIcon = 'ti ti-check text-primary';
                        statusLabel = 'Sent';
                        break;
                    case 'delivered':
                        statusIcon = 'ti ti-checks text-secondary';
                        statusLabel = 'Delivered';
                        break;
                    case 'read':
                        statusIcon = 'ti ti-checks text-success';
                        statusLabel = 'Seen';
                        break;
                    default:
                        statusIcon = 'ti ti-clock text-secondary';
                        statusLabel = 'Pending';
                }

                const timePart = msg.created_at.split(" ")[1];
                const [hourStr, minute] = timePart.split(":");

                let hour = parseInt(hourStr);
                const period = hour >= 12 ? "PM" : "AM";
                hour = hour % 12 || 12;

                const currentTime = `${hour}:${minute} ${period}`;

                function replaceVariables(text, varsJson) {
                    const vars = JSON.parse(varsJson || '[]');
                    return text.replace(/\{\{(\d+)\}\}/g, (_, index) => {
                        return vars[index - 1] !== undefined ? vars[index - 1] : `{{${index}}}`;
                    });
                }

                const renderedHeader = msg.headerText ? `<strong>${replaceVariables(msg.headerText, msg.header_var)}</strong><br>` : '';
                const renderedBody = msg.bodyText ? `<span>${replaceVariables(msg.bodyText, msg.body_var)}</span><br>` : '';

                messagesHtml += `
                     <li class="chat-message chat-message-right">
                        <div class="d-flex overflow-hidden rounded w-50">
                           
                            <div class="chat-message-wrapper flex-grow-1">
                                <div class="chat-message-text border shadow-sm">
                                    <div>
                                        <div><h5> ${msg.headerText ? `<strong>${renderedHeader}</strong><br>` : ''}</h5></div>
                                        <div class="mb-1"> ${msg.bodyText ? `<span>${renderedBody}</span><br>` : ''}</div>
                                        <div class="text-muted">${msg.footerText ? `<small>${msg.footerText}</small><br>` : ''}</div>
                                    </div>
                                    <hr>
                                    <center>
                                        <div>
                                            ${buttonHtml}
                                        </div>
                                    </center>
                                    
                                </div>
                                <div class="text-end text-body-secondary mt-1">
                                    <i class="${statusIcon} icon-16px me-1" title="${statusLabel}"></i>
                                    <small>${currentTime}</small>
                                </div>
                            </div>

                            <div class="user-avatar flex-shrink-0 ms-4">
                                <div class="avatar avatar-sm">
                                    <img src="${avatar}" alt="Avatar" class="rounded-circle" />
                                </div>
                            </div>
                        </div>
                       
                                   
                    </li>
                `;

                if (msg.status === 'replied' && msg.reply_text) {
                    const replyTime = new Date(msg.updated_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                    replyHtml = `
                            <li class="chat-message">
                                <div class="d-flex overflow-hidden">
                                    <div class="user-avatar flex-shrink-0 me-4">
                                        <div class="avatar avatar-sm">
                                            <img src="{{asset('')}}theme_1/assets/img/avatars/4.png" alt="Avatar" class="rounded-circle" />
                                        </div>
                                    </div>
                                    <div class="chat-message-wrapper flex-grow-1">
                                        <div class="chat-message-text">
                                            <p class="mb-0">${msg.reply_text}</p>
                                        </div>
                                        <div class="text-body-secondary mt-1">
                                            <small>${replyTime}</small>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        `;
                    messagesHtml += replyHtml;
                }
            });

            $('.chat-history').html(messagesHtml);
            const chatBody = $('.chat-history-body');
            chatBody.scrollTop(chatBody[0].scrollHeight);
        }
    });
}

$(document).on('click', '.delete-contact-btn', function () {
    const contactId = $(this).data('id');

    swal({
        title: 'Are you sure?',
        text: "This will delete from the contact list.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, Delete it!'
    }).then((result) => {
        if (result.value) {
            swal.close();
            $.ajax({
                url: "/chat/contact/delete",
                type: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: contactId
                },
                beforeSend: function () {
                    swal({
                        title: 'Please wait',
                        type: 'warning',
                        text: 'We are working on your request...',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                    })
                },
                success: function (res) {
                    swal.close();
                    if (res.status == 'success') {
                        swal({
                            title: 'Success',
                            type: 'success',
                            text: res.message,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: true
                        }).then(() => {
                            location.reload();
                        })
                    } else {
                        swal({
                            title: 'Failed',
                            type: 'failer',
                            text: res.message,
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: true
                        })
                    }
                },
                error: function () {
                    swal.close();
                    notify('Something went wrong.', 'error');
                }
            });
        }
    });
});

