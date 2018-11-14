<style>
    .map_box {
        width: 100%;
        height: 100%;
        background-color: #1d2124;
        opacity: 0.4;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 101;
        display: none;
    }

    .my_map {
        width: 35em;
        height: 35em;
        border: 3px solid black;
        border-radius: 15px;
        position: fixed;
        top: 5em;
        left: 25em;
        z-index: 102;
        display: none;
    }

    #map {
        width: 100%;
        height: 100%;
        border-radius: 15px;
    }

    .close_map {
        width: 5%;
        height: 5%;
        background: black;
        position: absolute;
        border-radius: 50%;
        top: -2%;
        left: 98%;
    }

</style>
<div class="map_box">
</div>
<div class="my_map">
    <div id="map"></div>
    <div class="close_map">

    </div>
</div>
<script>
    var map;
    var geocoder;
    var markerArray = [];
    var directionsDisplay;
    var directionsService;

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 21.0245, lng: 105.84117},
            zoom: 10
        });

        directionsService = new google.maps.DirectionsService;
        directionsDisplay = new google.maps.DirectionsRenderer({
            map: map,
            markerOptions: {
                opacity: 0
            },
            draggable: true,
        });

        geocoder = new google.maps.Geocoder();

        google.maps.event.addListener(map, 'click', function (event) {
            var marker = makeMaker(event.latLng);
            markerArray.push(marker);

            directions()
        });
    }

    function makeMaker(location) {
        return new google.maps.Marker({
            position: location,
            animation: google.maps.Animation.DROP,
            map: map,
            draggable: true
        });
    }

    function directions() {
        var origin;
        var destination;
        var wayPoint = [];

        for (var i in markerArray) {
            console.log(i);
            if (i == 0) {
                origin = markerArray[i].getPosition();
            } else if (i == markerArray.length - 1) {
                destination = markerArray[i].getPosition();
            } else {
                wayPoint.push({
                    location: markerArray[i].getPosition()
                });
            }
        }
        displayRoute(origin, destination, wayPoint, directionsService, directionsDisplay);
    }

    function displayRoute(origin, destination, wayPoint, service, display) {
        service.route({
            origin: origin,
            destination: destination,
            waypoints: wayPoint,
            travelMode: 'DRIVING',
            avoidTolls: true
        }, function (response, status) {
            if (status === 'OK') {
                display.setDirections(response);
            } else {
                alert('Could not display directions due to: ' + status);
            }
        });
    }

</script>
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDlkPRpU8Qk221zsdBOpn8cVl_WDSBtIWk&callback=initMap"
    async defer></script>
