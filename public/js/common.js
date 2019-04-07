class Firebase {
    constructor() {
        // var config = {
        //     apiKey: "AIzaSyAP971pw7kzJTTYatF0EkWtbJ9rDcCX2vc",
        //     authDomain: "my-project-1500357993095.firebaseapp.com",
        //     databaseURL: "https://my-project-1500357993095.firebaseio.com",
        //     projectId: "my-project-1500357993095",
        //     storageBucket: "my-project-1500357993095.appspot.com",
        //     messagingSenderId: "1068180738247"
        // };
        // this.firebase = firebase.initializeApp(config);
        // this.database = this.firebase.database();
    }

    static getDatabase(){
        var config = {
            apiKey: "AIzaSyAP971pw7kzJTTYatF0EkWtbJ9rDcCX2vc",
            authDomain: "my-project-1500357993095.firebaseapp.com",
            databaseURL: "https://my-project-1500357993095.firebaseio.com",
            projectId: "my-project-1500357993095",
            storageBucket: "my-project-1500357993095.appspot.com",
            messagingSenderId: "1068180738247"
        };
        this.firebase = firebase.initializeApp(config);
        return this.firebase.database();
    }

}

class User extends Firebase {
    static find(userId, callBack) {
        var Ref = super.getDatabase().ref('users/' + userId);
        Ref.once('value', function (response) {
            callBack(response.val());
        });
    }
}


class Comment extends Firebase {
    find(commentId, callback) {
        var _this = this;
        var query = super.database.ref('comments/' + commentId);
        query.once('value', function (response) {
            var data = response.val();
            _this.user_id = data.user_id;
            _this.post_id = data.post_id;
            _this.content = data.content;
            callback(data);
        });
    }

    static where(queryObj, callback = null) {
        let key = Object.keys(queryObj)[0];
        let value = queryObj[key];
        var ref = super.getDatabase().ref('comments');
        ref.orderByChild(key).equalTo(value).on("value", function(data) {
            if(callback) {
                callback(data.val());
            }
        });
    }

    static onListenerChange(callBack){
        var ref = super.getDatabase().ref('comments');
        ref.once("child_added", function(data) {
            callBack(data.val());
        });
    }
}


var R = {}

R.userName = $('meta[name="user-name"]').attr('content');
R.userId = $('meta[name="user-id"]').attr('content');


$(function () {
    $(".popup_close").click(function () {
        $("div.popup").css("display", "none");
    });
    $(".popup_opacity").click(function () {
        $("div.popup").css("display", "none");
    });
});
