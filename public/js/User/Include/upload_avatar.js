$(function () {
    var $image = $('#image1');
    var options = {
        aspectRatio: 1 / 1,
        minCropBoxWidth: 500,
        minContainerWidth: 500,
        crop: function (event) {
        }
    }
    $image.cropper(options);

    // Import image
    $("#change_avatar").click(function () {
        var $inputImage = $('#input_change_avatar');
        $inputImage.change(function () {
            var files = this.files;
            var file;
            if (!$image.data('cropper')) {
                return;
            }
            if (files && files.length) {
                file = files[0];
                if (/^image\/\w+$/.test(file.type)) {
                    uploadedImageName = file.name;
                    uploadedImageType = file.type;

                    uploadedImageURL = URL.createObjectURL(file);
                    $image.cropper('destroy').attr('src', uploadedImageURL).cropper(options);
                    $inputImage.val('');
                } else {
                    window.alert('Please choose an image file.');
                }
            }
            $("#change_avatar_box").css("display", "block");
            $(".popup_content").css("zIndex", 200);
        });
    });
    $("#submit_change_avatar").click(function () {
        var a = $image.cropper('getCroppedCanvas', {
            width: 160,
            height: 90,
            minWidth: 256,
            minHeight: 256,
            maxWidth: 4096,
            maxHeight: 4096,
            fillColor: '#fff',
            imageSmoothingEnabled: false,
            imageSmoothingQuality: 'high',
        });
        a.toBlob((blob) => {
            const formData = new FormData();
            formData.append('file', blob);
            formData.append('_token', '{{csrf_token()}}');
            $.ajax('/user/change_avatar', {
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    var response = jQuery.parseJSON(response);
                    $("div.avatar img").attr("src", window.location.origin + '/' + response.data.src_avatar);
                    $(".popup").css('display', 'none');

                },
                error() {
                    console.log('Upload error');
                },
            });
        });
    });
})
