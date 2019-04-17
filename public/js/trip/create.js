window.onload = function () {
    var myMap = new MapCustom();
    $("#btn_create_map").click(function () {
        myMap.initMap();
        myMap.addListenerCreatePost("div#marker_info_box");
        $("div.map_box").css("display", "block");
    });
};
