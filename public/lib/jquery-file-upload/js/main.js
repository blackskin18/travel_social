$(function () {
    'use strict';
    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload({
        xhrFields: {withCredentials: true},
        url: '/post/create'
    });

    $('#fileupload').bind('fileuploadsubmit', function (e, data) {
        // The example input, doesn't have to be part of the upload form:
        var input = $('#input');
        data.formData = {example: input.val()};
        if (!data.formData.example) {
            data.context.find('button').prop('disabled', false);
            input.focus();
            return false;
        }
    });

    // Enable iframe cross-domain access via redirect option:
    // $('#fileupload').fileupload(
    //     'option',
    //     'redirect',
    //     window.location.href.replace(
    //         /\/[^\/]*$/,
    //         '/cors/result.html?%s'
    //     )
    // );
    //
    // if (window.location.hostname === 'blueimp.github.io') {
    //     // Demo settings:
    //     $('#fileupload').fileupload('option', {
    //         url: '//jquery-file-upload.appspot.com/',
    //         // Enable image resizing, except for Android and Opera,
    //         // which actually support image resizing, but fail to
    //         // send Blob objects via XHR requests:
    //         disableImageResize: /Android(?!.*Chrome)|Opera/
    //             .test(window.navigator.userAgent),
    //         maxFileSize: 999000,
    //         acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i
    //     });
    //     // Upload server status check for browsers with CORS support:
    //     if ($.support.cors) {
    //         $.ajax({
    //             url: '//jquery-file-upload.appspot.com/',
    //             type: 'HEAD'
    //         }).fail(function () {
    //             $('<div class="alert alert-danger"/>')
    //                 .text('Upload server currently unavailable - ' +
    //                         new Date())
    //                 .appendTo('#fileupload');
    //         });
    //     }
    // } else {
    //     // Load existing files:
    //     $('#fileupload').addClass('fileupload-processing');
    //     $.ajax({
    //         // Uncomment the following to send cross-domain cookies:
    //         //xhrFields: {withCredentials: true},
    //         url: $('#fileupload').fileupload('option', 'url'),
    //         dataType: 'json',
    //         context: $('#fileupload')[0]
    //     }).always(function () {
    //         $(this).removeClass('fileupload-processing');
    //     }).done(function (result) {
    //         $(this).fileupload('option', 'done')
    //             .call(this, $.Event('done'), {result: result});
    //     });
    // }

    $("#btn_add_image").click(function () {
        $('div.upload-image-box').css('display', 'block');
    });

    $(' div.upload-image-box>div.opacity').click(function () {
        $('div.upload-image-box').css('display', 'none');
    });
    
    $('div.upload-image-popup').click(function (event) {
    });

    $('#btn_submit').click(function () {
        var value = $('#post_description').val();

        var description = `<textarea class="input-border" id="post_description" name="post_description" cols="30" rows="3">`+value+`</textarea>`;
        $('div#input_hidden').append(description);

        $('form#fileupload').submit();
    });

});
