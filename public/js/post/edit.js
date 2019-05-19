$(document).ready(function () {
    var myMap = new MapCustom();

    $("#btn_create_map").click(function () {
        // initMap();
        myMap.initMap();
        myMap.addListenerCreatePost("div#marker_info_box");
        $("div.map_box").css("display", "block");
    });

    $('div.image_in_post>a.btn_delete').click(function () {
        var postId = $(this).data('post-id');
        var imageId =  $(this).data('image-id');

        var deleteImageInputElement = `<input type="hidden" name="delete_images[]" value="${imageId}" />`
        $("#form_edit_post").append(deleteImageInputElement);

        $(this).parent().remove();
    });

    $("#btn_submit_form").click(function () {
        $(this).off('click');
        $(this).prepend(`<span class="spinner-border spinner-border-sm"></span>`);
        $("#form_edit_post").submit();
    });
});
