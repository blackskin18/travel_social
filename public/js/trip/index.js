window.onload = function () {
    var map = new MapCustom();
        map.initMap();
        map.startFollowPosition();
        map.addListenerShowMap("div#position_info");
        $("div.map_box").css("display", "block");

    setInterval(function () {
        navigator.geolocation.getCurrentPosition(function (position) {
            map.setUserMakerPosition(position.coords);
        });
    }, 5000);
}
