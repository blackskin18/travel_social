window.onload = function () {
    class MapService {
        init(position) {
            this.map = new google.maps.Map(
                document.getElementById('map'), {zoom: 4, center:{lat: position.latitude, lng: position.longitude}});
            this.database = Firebase.getDatabase();
        }

        makeUserMaker(position) {
            var uluru = {lat: position.latitude, lng: position.longitude};
            this.userMaker = new google.maps.Marker({position: uluru, map: this.map, draggable: true});
        }

        setUserMakerPosition(position) {
            this.userMaker.setPosition({lat: position.latitude, lng: position.longitude});
            this.updatePositionInServer(position);
        }

        updatePositionInServer(position) {
            this.database.ref('trip/' + 1 + '/user/'+R.userId).set({
                lat: position.latitude,
                lng: position.longitude,
                name: R.userName
            });
        }

        // setFriendMaker(friends)
    }

    var map = new MapService();
    navigator.geolocation.getCurrentPosition(function (position) {
        map.init(position.coords);
        map.makeUserMaker(position.coords);
    });

    setInterval(function () {
        navigator.geolocation.getCurrentPosition(function (position) {
            map.setUserMakerPosition(position.coords);
        });
    }, 5000);
}
