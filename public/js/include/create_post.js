$(function () {
    var myMap = new MapCustom();

    $("#btn_create_map").click(function () {
        // initMap();
        myMap.initMap();
        myMap.addListenerCreatePost("div#marker_info_box");
        $("div.map_box").css("display", "block");
    });

    // $(".btn_show_map").click(function () {
    //     let articleId = $(this).data('post-id');
    //     myMap.initMap();
    //     myMap.addListenerShowMap("div#article_info_position_" + articleId);
    //     $("div.map_box").css("display", "block");
    // });

    $("#btn_create_trip").click(function () {
        $("#create_trip_box").toggle("slow", function () {
            $("#check_create_trip").prop('checked', true);
        });
    })
});
