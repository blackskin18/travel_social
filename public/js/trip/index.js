window.onload = function () {
    var firebaseToken = $("input#firebase_token").val();

    R.firebase.auth().signInWithCustomToken(firebaseToken).then(function (respone) {
        console.log(respone);
        var map = new MapCustom();
        map.initMap();
        map.startFollowPosition();
        map.addListenerShowMap("div#position_info");
        // $("div.map_box").css("display", "block");

        setInterval(function () {
            navigator.geolocation.getCurrentPosition(function (position) {
                map.setUserMakerPosition(position.coords);
            });
        }, 5000);
    }).catch(function(error) {
        // Handle Errors here.
        var errorCode = error.code;
        var errorMessage = error.message;
        if (errorCode === 'auth/invalid-custom-token') {
            alert('The token you provided is not valid.');
        } else {
            console.error(error);
        }
    });
}
