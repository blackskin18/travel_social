<div class="map_box">
    <div class="opacity" id="opacity">
    </div>
    <div class="my_map">
        <div id="map"></div>
        <div class="close_map" id="close_map">
        </div>
    </div>
</div>

<script>
    $(function () {
        $("#btn_create_map").click(function () {
            $("div.map_box").css("display", "block");
        });

        $("#close_map").click(function () {
            $("div.map_box").css("display", "none");
        });
        $("#opacity").click(function () {
            $("div.map_box").css("display", "none");
        });

    });

    var map;
    var geocoder;
    var markerArray = [];
    var directionsDisplay;
    var directionsService;
    var infoWindow;

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 21.0245, lng: 105.84117},
            zoom: 10
        });
        directionsService = new google.maps.DirectionsService;
        directionsDisplay = new google.maps.DirectionsRenderer({
            map: map,
            markerOptions: {
                opacity: 0,
                clickable: false,
            },
            suppressInfoWindows: true,
        });

        infoWindow = makeInfoWindow();
        geocoder = new google.maps.Geocoder();

        google.maps.event.addListener(map, 'click', function (event) {
            var marker = makeMaker(event.latLng);
            markerArray.push(marker);
            var markerInfoHtml = `<div class="marker_info">
                            ${markerArray.length}
                            <input type="" name="lat[]" value="${marker.getPosition().lat()}">
                            <input type="" name="lng[]" value="${marker.getPosition().lng()}">
                            <input type="" name="marker_description[]" class="marker_description">
                            </div>`;
            $("div#marker_info_box").append(markerInfoHtml);


            if (markerArray.length > 1) {
                directions();
            }
        });
    }

    function makeMaker(location) {
        var marker = new google.maps.Marker({
            position: location,
            animation: google.maps.Animation.DROP,
            map: map,
            draggable: true
        });

        marker.addListener('click', function () {
            var index = findIndexOfMarker(location);
            var descriptionMarker = $("div.marker_info").eq(index).find(".marker_description").val();
            infoWindow.close();
            infoWindow.setContent('<div>' +
                '<textarea class="input-border" name="" id="infoWindow" cols="30" rows="3">' +
                descriptionMarker +
                '</textarea>' +
                '</div>');
            infoWindow.open(map, marker);
        });

        marker.addListener('rightclick', function () {
            var index = findIndexOfMarker(location);
            $("div.marker_info").eq(index).remove();

            markerArray.splice(index, 1);
            marker.setMap(null);

            if (markerArray.length > 1) {
                directions();
            }
        });

        marker.addListener('dragend', function () {
            directions();
        });

        return marker;
    }

    function makeInfoWindow() {
        var htmlAppend = '<div>' +
            '<textarea class="input-border" name="" id="infoWindow" cols="30" rows="3"></textarea>' +
            '</div>';
        var localInfoWindow = new google.maps.InfoWindow({
            content: htmlAppend
        });

        localInfoWindow.addListener('domready', function () {
            $("#infoWindow").change(function () {
                var index = findIndexOfMarker(localInfoWindow.getPosition());
                var infoValue = $("#infoWindow").val();

                $("div.marker_info").eq(index).find(".marker_description").val(infoValue);
            });
        });

        return localInfoWindow;
    }

    function findIndexOfMarker (position) {
        var index = markerArray.findIndex(function (marker) {
            return marker.getPosition() === position
        });
        return index;
    }

    function directions() {
        var origin;
        var destination;
        var wayPoint = [];
        var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        for (var i in markerArray) {
            markerArray[i].setLabel(labels[i]);
            if (i == 0) {
                origin = markerArray[i].getPosition();
                continue;
            } else if (i == markerArray.length - 1) {
                destination = markerArray[i].getPosition();
                continue;
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
