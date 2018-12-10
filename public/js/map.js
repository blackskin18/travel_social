$(function () {
    var myMap = new MapCustom();

    $("#btn_create_map").click(function () {
        // initMap();
        myMap.initMap();
        myMap.addListenerCreatePost("div#marker_info_box");
        $("div.map_box").css("display", "block");
    });


    $(".btn_show_map").click(function () {
        let articleId = $(this).data('post-id');
        // 'article_info_position_''
        myMap.initMap();
        myMap.addListenerShowMap("div#article_info_position_" + articleId);
        $("div.map_box").css("display", "block");
    });

});


function MapCustom() {
    this.map = null;
    this.geocoder = null;
    this.markerArray = [];
    this.directionsDisplay = null;
    this.directionsService = null;
    this.infoWindow = null;
    this.listener = null;
    this.SHOW = 0;
    this.CREATE = 1
}

MapCustom.prototype.initMap = function () {
    this.map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 21.0245, lng: 105.84117},
        zoom: 10
    });

    for (var i = 0; i < this.markerArray.length; i++) {
        this.markerArray[i].setMap(null);
    }
    this.markerArray = [];
    this.directionsService = new google.maps.DirectionsService;
    this.directionsDisplay = new google.maps.DirectionsRenderer({
        map: this.map,
        markerOptions: {
            opacity: 0,
            clickable: false,
        },
        suppressInfoWindows: true,
    });

    this.infoWindow = this.makeInfoWindow();
    this.geocoder = new google.maps.Geocoder();
};

MapCustom.prototype.addListenerCreatePost = function (infoBoxSelector) {
    var that = this;
    this.listener = this.map.addListener('click', function (event) {
        var marker = that.makeMarker({lat: event.latLng.lat(), lng: event.latLng.lng()}, infoBoxSelector, that.CREATE);
        var markerInfoHtml = `<div class="marker_info">
                            ${that.markerArray.length}
                            <input type="" name="lat[]" class="lat_position" value="${marker.getPosition().lat()}">
                            <input type="" name="lng[]" class="lng_position" value="${marker.getPosition().lng()}">
                            <input type="" name="marker_description[]" class="marker_description">
                            </div>`;
        $("div#marker_info_box").append(markerInfoHtml);
    });

    var sumMarkers = $("div#marker_info_box > div").length;
    for (var i = 0; i < sumMarkers; i++) {
        var lat = parseFloat($("div.marker_info").eq(i).find("input.lat_position").val());
        var lng = parseFloat($("div.marker_info").eq(i).find("input.lng_position").val());
        this.makeMarker({lat: lat, lng: lng}, infoBoxSelector, this.CREATE);
    }
}


MapCustom.prototype.addListenerShowMap = function (infoBoxSelector) {
    var sumMarkers = $(infoBoxSelector + " > div.marker_info").length;
    for (var i = 0; i < sumMarkers; i++) {
        var lat = parseFloat($(infoBoxSelector + ">div.marker_info").eq(i).find("input.lat_position").val());
        var lng = parseFloat($(infoBoxSelector + ">div.marker_info").eq(i).find("input.lng_position").val());


        this.makeMarker({lat: lat, lng: lng}, infoBoxSelector, this.SHOW);
    }
}


MapCustom.prototype.makeMarker = function (location, infoBoxSelector, type) {
    var that = this;
    var marker = new google.maps.Marker({
        position: location,
        animation: google.maps.Animation.DROP,
        map: this.map,
        draggable: true
    });

    marker.addListener('click', function () {
        var index = that.findIndexOfMarker(location);
        // console.log(index);
        // var index = that.markerArray.findIndex(function (marker) {
        //     return marker.getPosition().lat() === location.lat && marker.getPosition().lng() === location.lng
        // });
        console.log(parseFloat(that.markerArray[0].getPosition().lng().toFixed(6)) , parseFloat(location.lng.toFixed(6)));
        // console.log(index);
        var descriptionMarker = $(infoBoxSelector + ">div.marker_info").eq(index).find(".marker_description").val();
        that.infoWindow.close();

        if (type === that.CREATE) {
            var content = '<div>' +
                '<textarea class="input-border" name="" id="infoWindow" cols="30" rows="3">' +
                descriptionMarker +
                '</textarea>' +
                '</div>';

        } else {
            var content = '<div>' +
                '<textarea class="input-border" name="" id="infoWindow" cols="30" rows="3" disabled>' +
                descriptionMarker +
                '</textarea>' +
                '</div>';
        }

        that.infoWindow.setContent(content);
        that.infoWindow.open(that.map, marker);
    });

    if (type == this.CREATE) {
        marker.addListener('rightclick', function () {
            var index = this.findIndexOfMarker(location);
            $("div.marker_info").eq(index).remove();

            that.markerArray.splice(index, 1);
            marker.setMap(null);

            if (markerArray.length > 1) {
                directions();
            }
        });

        marker.addListener('dragend', function () {
            that.directions();
        });

    }

    this.markerArray.push(marker);

    if (this.markerArray.length > 1) {
        this.directions();
    }
    return marker;
}

MapCustom.prototype.makeInfoWindow = function () {
    var that = this;
    var htmlAppend = '<div>' +
        '<textarea class="input-border" name="" id="infoWindow" cols="30" rows="3"></textarea>' +
        '</div>';
    var localInfoWindow = new google.maps.InfoWindow({
        content: htmlAppend
    });

    localInfoWindow.addListener('domready', function () {
        $("#infoWindow").change(function () {
            var index = that.findIndexOfMarker({
                lat: localInfoWindow.getPosition().lat(),
                lng: localInfoWindow.getPosition().lng()
            });
            var infoValue = $("#infoWindow").val();

            $("div#marker_info_box > div.marker_info").eq(index).find(".marker_description").val(infoValue);
        });
    });

    return localInfoWindow;
}


MapCustom.prototype.findIndexOfMarker = function (position) {
    var index = this.markerArray.findIndex(function (marker) {
        return parseFloat(marker.getPosition().lat().toFixed(6)) === parseFloat(position.lat.toFixed(6)) &&
            parseFloat(marker.getPosition().lng().toFixed(6)) === parseFloat(position.lng.toFixed(6))
    });
    return index;
}


MapCustom.prototype.directions = function (position) {
    this.directionsDisplay.setMap(this.map);
    var origin;
    var destination;
    var wayPoint = [];
    var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    for (var i in this.markerArray) {
        this.markerArray[i].setLabel(labels[i]);
        if (i == 0) {
            origin = this.markerArray[i].getPosition();
            continue;
        } else if (i == this.markerArray.length - 1) {
            destination = this.markerArray[i].getPosition();
            continue;
        } else {
            wayPoint.push({
                location: this.markerArray[i].getPosition()
            });
        }
    }
    this.displayRoute(origin, destination, wayPoint, this.directionsService, this.directionsDisplay);
}


MapCustom.prototype.displayRoute = function (origin, destination, wayPoint, service, display) {
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
