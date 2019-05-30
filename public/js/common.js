let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': CSRF_TOKEN
    }
});

var R = {}
var config = {
    apiKey: "AIzaSyAP971pw7kzJTTYatF0EkWtbJ9rDcCX2vc",
    authDomain: "my-project-1500357993095.firebaseapp.com",
    databaseURL: "https://my-project-1500357993095.firebaseio.com",
    projectId: "my-project-1500357993095",
    storageBucket: "my-project-1500357993095.appspot.com",
    messagingSenderId: "1068180738247"
};
R.userName = $('meta[name="user-name"]').attr('content');
R.userId = $('meta[name="user-id"]').attr('content');
R.userAvatar = $('meta[name="user-avatar"]').attr('content');
R.firebase = firebase.initializeApp(config);
R.firebaseDB = R.firebase.database();
R.firebaseMessaging = R.firebase.messaging();

$(function () {
    $(".popup_close").click(function () {
        $("div.popup").css("display", "none");
    });
    $(".popup_opacity").click(function () {
        $("div.popup").css("display", "none");
    });

    $("#btn_search_friend").click(function () {
        let searchText = $("#search_input").val();
        window.location.href = window.location.origin + '/search/friend?search_text='+searchText;
    });

});
