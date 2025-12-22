$(document).ready(function () {
    let syntaxMap = {
        bold: '**',
        italic: '__',
        strikeThrough: '~~'
    };

    window.formatText = function (type) {
        const marker = syntaxMap[type];
        const textarea = document.getElementById('bodyEditor');
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const fullText = textarea.value;
        let selectedText = fullText.substring(start, end);

        // Toggle formatting
        if (selectedText.startsWith(marker) && selectedText.endsWith(marker)) {
            selectedText = selectedText.slice(marker.length, selectedText.length - marker.length);
        } else {
            selectedText = marker + selectedText + marker;
        }

        // Update textarea
        textarea.value = fullText.substring(0, start) + selectedText + fullText.substring(end);
        textarea.focus();
        textarea.selectionStart = start;
        textarea.selectionEnd = start + selectedText.length;

        updateBodyPreview();
    }

    function parseMarkdownToHTML(text) {
        text = text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;");
        text = text.replace(/\*\*(.+?)\*\*/g, '<b>$1</b>');
        text = text.replace(/__(.+?)__/g, '<i>$1</i>');
        text = text.replace(/~~(.+?)~~/g, '<s>$1</s>');
        text = text.replace(/\n/g, '<br>');
        return text;
    }
    // Button Dynamic Add

    let quickReplyCount = 0;
    let quickReplyVar = 0;
    let urlButtonCount = 0;
    let urlButtonVar = 0;
    let callButtonCount = 0;
    let callButtonVar = 0;

    $('.add-btn-option').on('click', function () {
        const type = $(this).data('type');
        let html = '';
        let previewHtml = '';
        let index = 0;

        $('#previewBtnTrackBtn').html('');

        if (type === 'quick-reply' && quickReplyVar < 5) {
            quickReplyCount++;
            quickReplyVar++;

            html = `
            <div class="mb-3 button-row" data-type="quick-reply" data-index="${quickReplyCount}">
                <label>Quick Reply Buttons ${quickReplyCount}</label>
                <div class="row">
                    <div class="col-5">
                        <input type="text" name="quick_reply_${quickReplyCount}" Value="Reply Button ${quickReplyCount}" class="form-control btn-input" placeholder="Button ${quickReplyCount} Text" data-preview-target="quick-reply-${quickReplyCount}" required>
                    </div>
                    <div class="col-1">
                        <button type="button" class="btn btn-light border-0 remove-btn"><i class="fa fa-times"></i></button>
                    </div>
                </div>
            </div>
        `;

            previewHtml = `<button type="button" class=" btn border-0 text-info fw-bold mx-auto me-1 preview-quick-reply p-0" id="preview-quick-reply-${quickReplyCount}"> <i class="fa-solid fa-reply"></i> &nbsp; Reply Button ${quickReplyCount}</button><hr/>`;
        }

        if (type === 'visit-website' && urlButtonVar < 2) {
            urlButtonCount++;
            urlButtonVar++;

            html = `
            <div class="mb-3 button-row" data-type="visit-website" data-index="${urlButtonCount}">
                <label>URL Button ${urlButtonCount}</label>
                <div class="row">
                    <div class="col-5">
                        <input type="text" name="url_button_text_${urlButtonCount}" required class="form-control btn-url" value="Visit Us ${urlButtonCount}" placeholder="Button Text" data-preview-target="url-${urlButtonCount}">
                    </div>
                    <div class="col-6">
                        <input type="url" name="url_button_url_${urlButtonCount}" required class="form-control btn-url" placeholder="https://example.com" data-preview-target="url-${urlButtonCount}">
                    </div>
                    <div class="col-1">
                        <button type="button" class="btn btn-light border-0 remove-btn"><i class="fa fa-times"></i></button>
                    </div>
                </div>
            </div>
        `;

            previewHtml = `<a href="#" target="_blank" class="text-info fw-bold mx-auto preview-url" id="preview-url-${urlButtonCount}"><i class="fa-solid fa-eye"></i> &nbsp; Visit Us ${urlButtonCount}</a><hr/>`;
        }

        if (type === 'call-number' && callButtonVar < 1) {
            callButtonCount++;
            callButtonVar++;

            html = `
            <div class="mb-3 button-row" data-type="call-number" data-index="${callButtonCount}">
                <label>Call Phone ${callButtonCount}</label>
                <div class="row">
                    <div class="col-3">
                        <input type="text" name="call_button_text" required class="form-control btn-phone" value="Call Us Now" placeholder="Call Button Text" data-preview-target="call-${callButtonCount}">
                    </div>
                    <div class="col-2">
                        <select class="form-select call-code" data-preview-target="call-${callButtonCount}">
                            <option value="+91">+91</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <input type="text" name="call_phone_number" required class="form-control btn-phone" placeholder="Enter phone number" maxlength="10" data-preview-target="call-${callButtonCount}">
                    </div>
                    <div class="col-1">
                        <button type="button" class="btn btn-light border-0 remove-btn"><i class="fa fa-times"></i></button>
                    </div>
                </div>
            </div>
        `;

            previewHtml = `<a href="#" class="text-info fw-bold mx-auto preview-call" id="preview-call-${callButtonCount}"><i class="fa-solid fa-phone"></i> &nbsp; Call Us Now</a><hr/>`;
        }

        $('#buttonDisplayArea').append(html);
        $('#previewBtn').children(':not(.preview-quick-reply):not(.preview-url):not(.preview-call):not(hr)').remove();

        $('#previewBtn').append(previewHtml);
    });

    // Live updates
    $(document).on('input change', '.btn-input, .btn-url, .btn-phone, .call-code', function () {
        const $row = $(this).closest('.button-row');
        const type = $row.data('type');
        const index = $row.data('index');

        if (type === 'quick-reply') {
            const text = $(`input[name="quick_reply_${index}"]`).val() || ` Button ${index}`;
            $(`#preview-quick-reply-${index}`).html(`<i class="fa-solid fa-reply text-info"></i>&nbsp;${text}`);
        }

        if (type === 'visit-website') {
            const text = $(`input[name="url_button_text_${index}"]`).val() || ' Visit';
            const url = $(`input[name="url_button_url_${index}"]`).val() || '#';
            $(`#preview-url-${index}`).html(`<i class="fa-solid fa-eye text-info"></i>&nbsp; ${text}`).attr('href', url);
        }

        if (type === 'call-number') {
            const text = $(`input[name="call_button_text"]`).val() || ' Call';
            const phone = $(`input[name="call_phone_number"]`).val() || '';
            const code = $(`.call-code[data-preview-target="call-${index}"]`).val() || '+91';
            const telHref = `tel:${code}${phone}`;
            $(`#preview-call-${index}`).html(`<i class="fa-solid fa-phone text-info"></i> &nbsp; ${text}`).attr('href', telHref);
        }
    });

    // Remove button block and preview
    $('#buttonDisplayArea').on('click', '.remove-btn', function () {
        const $row = $(this).closest('.button-row');
        const type = $row.data('type');
        const index = $row.data('index');

        if (type === 'quick-reply') quickReplyVar--;
        if (type === 'visit-website') urlButtonVar--;
        if (type === 'call-number') callButtonVar--;

        const previewId = `preview-${type === 'visit-website' ? 'url' : type === 'call-number' ? 'call' : 'quick-reply'}-${index}`;
        const $previewElement = $(`#${previewId}`);

        if ($previewElement.length) {
            const $nextHr = $previewElement.next('hr');
            if ($nextHr.length) {
                $nextHr.remove();
            }
            $previewElement.remove();
        }

        $row.remove();
    });


    // Category Selection
    handleTemplateDisplay($('input[name="category"]:checked').val());


    $('input[name="category"]').on('change', function () {
        const selected = $(this).val();
        handleTemplateDisplay(selected);
    });

    function handleTemplateDisplay(type) {

        // $('#marketingTemplate, #utilityTemplate, #authenticationTemplate').addClass('d-none');
        $('#marketingTemplate, #authenticationTemplate').addClass('d-none');


        if (type === 'Marketing') {
            $('#marketingTemplate').removeClass('d-none');
            $('#utilityTemplate').removeClass('d-none');
        } else if (type === 'Utility') {
            $('#marketingTemplate').removeClass('d-none');
            $('#utilityTemplate').addClass('d-none');
        } else if (type === 'Authentication') {
            $('#authenticationTemplate').removeClass('d-none');
        }
    }


    $('input[name="footer_text"]').on('input', function () {
        $('#previewFooter').text($(this).val());
    });

    // Update Time 
    function updateTime() {
        const now = new Date();
        const hrs = now.getHours().toString().padStart(2, '0');
        const mins = now.getMinutes().toString().padStart(2, '0');
        $('#previewTime').text(`${hrs}:${mins}`);
    }

    updateTime();
    setInterval(updateTime, 60000);


    // Header Type
    $('#headerType').on('change', function () {
        let type = $(this).val();
        let $container = $('#headerInputContainer');
        $container.empty();
        $('#previewHeader').html('');
        $('#headerTextInput').html('');
        headerVariable = '';

        if (type === 'text') {
            $container.append(`<label> Header Text</label><input type="text" name="header_text" id="headerText" maxlength="60" class="form-control" placeholder="Enter Header Text" required> 
                 <button type="button" class="btn border-0 btn-outline-secondary mt-2 float-end" id="addHeaderVariableBtn">+ Add Variable</button>`);
            $container.on('input', '#headerText', function () {
                let val = $(this).val();
                if (headerVariable && !val.includes(headerVariable)) {
                    headerVariable = '';
                }
                $('#previewHeader').text(val.replace(headerVariable, $('#headerVariableValue').val() || headerVariable));
            });
        } else if (type === 'image') {
            $container.append(`<label> Image File</label><input type="file" id="headerImage" name="headerImage"  accept="image/*" class="form-control" placeholder="Select Image File" required>`);
            $('#previewHeader').html(`<img src="your-image.jpg" alt="image" width="100%" style="height: 200px" class="rounded mb-2" />`);
        } else if (type === 'video') {
            $container.append(`<label>Video File</label><input type="file" id="headerVideo" name="headerVideo" class="form-control" accept="video/*" placeholder="Select Video File" required>`);
            $('#previewHeader').html(`<video src="your-video.mp4" width="100%" style="height: 200px" controls class="rounded mb-2"></video>`);
        }

        updateHeaderPreview();
    });



    $(document).on('input change', '#headerText, #headerImage, #headerVideo, #headerType', function () {
        updateHeaderPreview();
    });

    function updateHeaderPreview() {
        let type = $('#headerType').val();
        let $preview = $('#previewHeader');
        $preview.empty();

        if (type === 'text') {
            let text = $('#headerText').val();
            if (headerVariable && headerVariableVal) {
                text = text.replace(headerVariable, headerVariableVal);
            }

            $preview.html(`<h5>${text}</h5>`);

        } else if (type === 'image') {
            let fileInput = $('#headerImage')[0];
            if (fileInput && fileInput?.files && fileInput?.files[0]) {
                let imageUrl = URL.createObjectURL(fileInput.files[0]);
                $preview.html(`<img src="${imageUrl}" class="rounded mb-2" style="width: 100%; height: 200px;" />`);
            }
        } else if (type === 'video') {
            let fileInput = $('#headerVideo')[0];
            if (fileInput && fileInput?.files && fileInput?.files[0]) {
                let videoUrl = URL.createObjectURL(fileInput.files[0]);
                $preview.html(`
                <video controls style="width: 100%; height: 200px;">
                    <source src="${videoUrl}" type="${fileInput.files[0].type}">
                    Your browser does not support the video tag.
                </video>
            `);
            }
        }
    }

    $(document).on('click', '#removeHeaderVar', function () {
        $('#headerVarWrapper').remove();
        let input = $('#headerText');
        input.val(input.val().replace(headerVariable, ''));
        headerVariable = '';
        updateHeaderPreview();
    });

    // Header Dynamic

    let headerVariable = '';
    let headerVariableVal = '';

    $(document).on('click', '#addHeaderVariableBtn', function () {
        if (!headerVariable) {
            headerVariable = variableType === 'number' ? `{{1}}` : `{{x}}`;
            let input = $('#headerText');
            input.val(input.val() + ' ' + headerVariable);
            $('#previewHeader').html(`<h5>${input.val()}</h5>`);


            $('#headerTextInput').append(`
            <div class="mt-2 d-flex align-items-start gap-2" id="headerVarWrapper">
                <input type="text" id="headerVariableValue" name="headerVariableValue" class="form-control w-75" placeholder="Value for ${headerVariable}" maxlength="50" required>
                <button type="button" class="btn btn-secondary boder-0" id="removeHeaderVar"><i class="fa fa-times"></i></button>
            </div>
        `);
        }
    });


    $(document).on('input', '#headerVariableValue', function () {
        headerVariableVal = $(this).val();
        updateHeaderPreview();
    });

    $(document).on('input', '#headerText', function () {
        let input = $(this);
        let val = input.val();


        let matches = val.match(/{{[^}]+}}/g);

        if (matches && matches.length > 1) {

            let firstVar = matches[0];
            val = val.replace(matches.slice(1).join(''), '');
            input.val(val);
            matches = [firstVar];
        }

        if (matches && matches.length === 1) {
            let firstVar = matches[0];


            if (headerVariable !== firstVar) {
                headerVariable = firstVar;
                headerVariableVal = '';


                $('#headerTextInput').html(`
                <div class="mt-2 d-flex align-items-start gap-2" id="headerVarWrapper">
                    <input type="text" id="headerVariableValue" name="headerVariableValue" class="form-control w-75" placeholder="Value for ${headerVariable}" required>
                    <button type="button" class="btn btn-secondary border-0" id="removeHeaderVar"><i class="fa fa-times"></i></button>
                </div>
            `);
            }

        } else {

            headerVariable = '';
            headerVariableVal = '';
            $('#headerVarWrapper').remove();
        }

        updateHeaderPreview();
    });


    // Body Dynamic 

    let varIndex = 1;
    let alphabetIndex = 0;
    const alphabet = 'abcdefghijklmnopqrstuvwxyz'.split('');
    let variableType = $('#variableType').val();
    let varMap = {};
    let maxVars = 26;

    $('#variableType').on('change', function () {
        variableType = $(this).val();
        varIndex = 1;
        alphabetIndex = 0;
        varMap = {};
        $('#variableValues').empty();
        $('#bodyEditor').val('');
        $('#previewMessage').html('');
    });

    function updateBodyPreview() {
        let content = $('#bodyEditor').val();
        Object.keys(varMap).forEach(variable => {
            content = content.replaceAll(variable, varMap[variable] || variable);
        });
        content = parseMarkdownToHTML(content);
        $('#previewMessage').html(content);
    }


    $('#addVariableBtn').on('click', function () {
        if (Object.keys(varMap).length >= maxVars) return;

        let varName = variableType === 'number' ? `{{${varIndex++}}}` : `{{${alphabet[alphabetIndex++]}}}`;
        let currentText = $('#bodyEditor').val();
        $('#bodyEditor').val(currentText + ' ' + varName).trigger('input');
    });


    $('#bodyEditor').on('input', function () {
        let text = $(this).val();


        let pattern = variableType === 'number' ? /{{\d+}}/g : /{{[a-zA-Z]}}/g;
        let matches = text.match(pattern) || [];
        let uniqueMatches = [...new Set(matches)].slice(0, maxVars);


        uniqueMatches.forEach(variable => {
            if (!varMap.hasOwnProperty(variable)) {
                varMap[variable] = '';
                let cleanVar = variable.replace(/[{}]/g, '');
                $('#variableValues').append(`
                <div class="row variable-wrapper mb-2 w-100" id="var-${cleanVar}">
                    <div class="col-10">
                        <label>Value for ${variable}</label>
                        <input type="text" class="form-control var-input" name="variable_var_${cleanVar}"  data-placeholder="${variable}" required/>
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-secondary mt-4 remove-var-btn" data-var="${variable}"><i class="fa fa-times"></i></button>
                    </div>
                </div>
            `);
            }
        });


        Object.keys(varMap).forEach(variable => {
            if (!uniqueMatches.includes(variable)) {
                let cleanVar = variable.replace(/[{}]/g, '');
                $(`#var-${cleanVar}`).remove();
                delete varMap[variable];
            }
        });

        updateBodyPreview();
    });


    $(document).on('input', '.var-input', function () {
        let placeholder = $(this).data('placeholder');
        varMap[placeholder] = $(this).val();
        updateBodyPreview();
    });


    $(document).on('click', '.remove-var-btn', function () {
        const variable = $(this).data('var');
        const cleanVar = variable.replace(/[{}]/g, '');

        $('#bodyEditor').val(function (_, val) {
            return val.replaceAll(variable, '').replace(/\s{2,}/g, ' ').trim();
        }).trigger('input');

        $(`#var-${cleanVar}`).remove();
        delete varMap[variable];
        updateBodyPreview();
    });
});
