$(document).ready(function () {
    $('div.image_in_post>a.btn_delete').click(function () {
        var postId = $(this).data('post-id');
        var imageId =  $(this).data('image-id');

        var deleteImageInputElement = `<input type="hidden" name="delete_images[]" value="${imageId}" />`
        $("#edit_post").append(deleteImageInputElement);

        $(this).parent().remove();
    });
});
