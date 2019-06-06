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
    var that = this;
    this.map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 21.0245, lng: 105.84117},
        zoom: 10
    });

    // var trafficLayer = new google.maps.TrafficLayer();
    // trafficLayer.setMap(this.map);

    var geocoder = new google.maps.Geocoder();
    document.getElementById('map_search_position').addEventListener('click', function() {
        that.geocodeAddress(geocoder, that.map);
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

MapCustom.prototype.geocodeAddress = function(geocoder, resultsMap) {
    var address = document.getElementById('address').value;
    geocoder.geocode({'address': address}, function(results, status) {
        if (status === 'OK') {
            resultsMap.setCenter(results[0].geometry.location);
        } else {
            alert('Geocode was not successful for the following reason: ' + status);
        }
    });
}

MapCustom.prototype.addListenerCreatePost = function (infoBoxSelector) {
    var that = this;
    this.listener = this.map.addListener('click', function (event) {
        var marker = that.makePostionMarker({lat: event.latLng.lat(), lng: event.latLng.lng()}, infoBoxSelector, that.CREATE);
        var markerInfoHtml = `<div class="marker_info">
                            <input type="hidden" name="lat[]" class="lat_position" value="${marker.getPosition().lat()}">
                            <input type="hidden" name="lng[]" class="lng_position" value="${marker.getPosition().lng()}">
                            <input type="hidden" name="marker_description[]" class="marker_description">
                            <input type="hidden" name="time_arrive[]" class="time_arrive">
                            <input type="hidden" name="time_leave[]" class="time_leave">
                            </div>`;
        $("div#marker_info_box").append(markerInfoHtml);
        console.log(markerInfoHtml)
    });

    var sumMarkers = $("div#marker_info_box > div").length;
    for (var i = 0; i < sumMarkers; i++) {
        var lat = parseFloat($("div.marker_info").eq(i).find("input.lat_position").val());
        var lng = parseFloat($("div.marker_info").eq(i).find("input.lng_position").val());
        this.makePostionMarker({lat: lat, lng: lng}, infoBoxSelector, this.CREATE);
    }
}


MapCustom.prototype.addListenerShowMap = function (infoBoxSelector) {
    var sumMarkers = $(infoBoxSelector + " > div.marker_info").length;
    for (var i = 0; i < sumMarkers; i++) {
        var lat = parseFloat($(infoBoxSelector + ">div.marker_info").eq(i).find("input.lat_position").val());
        var lng = parseFloat($(infoBoxSelector + ">div.marker_info").eq(i).find("input.lng_position").val());

        this.makePostionMarker({lat: lat, lng: lng}, infoBoxSelector, this.SHOW);
    }
}


MapCustom.prototype.makePostionMarker = function (location, infoBoxSelector, type) {
    var that = this;
    var marker = new google.maps.Marker({
        position: location,
        animation: google.maps.Animation.DROP,
        map: this.map,
        draggable: true
    });


    marker.addListener('click', function () {
        var index = that.findIndexOfMarker(location);

        var descriptionMarker = $(infoBoxSelector + ">div.marker_info").eq(index).find(".marker_description").val();
        var timeArrivePosition = $(infoBoxSelector + ">div.marker_info").eq(index).find(".time_arrive").val();
        var timeLeavePosition = $(infoBoxSelector + ">div.marker_info").eq(index).find(".time_leave").val();
        console.log(timeArrivePosition, timeLeavePosition);
        that.infoWindow.close();

        if (type === that.CREATE) {
            var content = `<div>
                    <textarea class="input-border" name="" id="infoWindow" cols="30" rows="3">${descriptionMarker}</textarea><br>
                    <label class="small">Thời gian bắt đầu:</label>
                    <input type="datetime-local" class="form-control" id="info_window_time_arrive" value="${timeArrivePosition}"><br>
                    <label class="small">Thời gian kết thúc:</label>
                    <input type="datetime-local" class="form-control" id="info_window_time_leave" value="${timeLeavePosition}">
                </div>`;
        } else {
            var content = `<div>
                    <textarea class="input-border" name="" id="infoWindow" cols="30" rows="3" disabled>${descriptionMarker}</textarea><br>`;
            if(timeArrivePosition) {
                content += `<label class="small">Thời gian bắt đầu</label>
                <input type="datetime-local" name="time_arrive" class="form-control" id="info_window_time_arrive" value="${timeArrivePosition}" disabled><br>`
            }
            if(timeLeavePosition) {
                content += `<label class="small">Thời gian kết thúc</label>
                    <input type="datetime-local" name="time_leave" class="form-control" id="info_window_time_leave" value="${timeLeavePosition}" disabled>`
            };
            content += `</div>`;
        }

        that.infoWindow.setContent(content);
        that.infoWindow.open(that.map, marker);
    });

    if (type == this.CREATE) {
        marker.addListener('rightclick', function () {
            var index = that.findIndexOfMarker(location);
            $("div.marker_info").eq(index).remove();

            that.markerArray.splice(index, 1);
            marker.setMap(null);

            if (that.markerArray.length > 1) {
                that.directions();
            } else if (that.markerArray.length === 1) {
                that.directionsDisplay.setMap(null);
            }
        });

        marker.addListener('dragend', function () {
            var index = that.findIndexOfMarker({
                lat: marker.position.lat(),
                lng: marker.position.lng()
            });
            console.log(index);
            console.log($(infoBoxSelector + ">div.marker_info").eq(index));
             $(infoBoxSelector + ">div.marker_info").eq(index).find(".lat_position").val(marker.position.lat());
             $(infoBoxSelector + ">div.marker_info").eq(index).find(".lng_position").val(marker.position.lng());
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
    var htmlAppend = `<div>
                    <textarea class="input-border" name="" id="infoWindow" cols="30" rows="3" disabled></textarea><br>
                    <label class="small">Thời gian bắt đầu</label>
                    <input type="datetime-local" name="time_arrive" id="info_window_time_arrive" ><br>
                    <label class="small">Thời gian kết thúc</label>
                    <input type="datetime-local" name="time_leave" id="info_window_time_leave">
                </div>`;
    var localInfoWindow = new google.maps.InfoWindow({
        content: htmlAppend
    });

    var infoWindowListener = function() {
        var index = that.findIndexOfMarker({
            lat: localInfoWindow.getPosition().lat(),
            lng: localInfoWindow.getPosition().lng()
        });
        var infoValue = $("#infoWindow").val();
        var timeArrive = $("#info_window_time_arrive").val();
        var timeLeave = $("#info_window_time_leave").val();

        $("div#marker_info_box > div.marker_info").eq(index).find(".marker_description").val(infoValue);
        $("div#marker_info_box > div.marker_info").eq(index).find(".time_arrive").val(timeArrive);
        console.log($("div#marker_info_box > div.marker_info").eq(index).find(".time_arrive"));
        $("div#marker_info_box > div.marker_info").eq(index).find(".time_leave").val(timeLeave);
    };

    localInfoWindow.addListener('domready', function () {
        $("#infoWindow").change(infoWindowListener);
        $("#info_window_time_arrive").change(infoWindowListener);
        $("#info_window_time_leave").change(infoWindowListener);
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

// -----------------------------------------------------follow position
MapCustom.prototype.startFollowPosition = function() {
    var _this = this;
    navigator.geolocation.getCurrentPosition(function (response) {
        var position = response.coords;
        _this.map.setCenter( {lat: position.latitude, lng: position.longitude});
        _this.makeMemberMaker(position);
    });
}


MapCustom.prototype.makeMemberMaker = function(position) {
    var _this = this;
    this.friend = {};
    var memberRef = R.firebaseDB.ref('trip/' + R.trip.id +'/user');
    memberRef.on('value', function (response) {
        let users = response.val();
        console.log(users);
        for(let i in users) {
            if(i === R.userId) {
                if(!_this.userMaker) {
                    _this.userMaker = _this.makeMaker({lat: users[i].lat, lng: users[i].lng}, "marker-current-user.png");
                } else {
                    _this.userMaker.setPosition({lat: users[i].lat, lng: users[i].lng});
                }
            } else {
                if(!_this.friend[i]) {
                    _this.friend[i] = _this.makeMaker({lat: users[i].lat, lng: users[i].lng}, "marker-friend-1.png");
                } else {
                    _this.friend[i].setPosition({lat: users[i].lat, lng: users[i].lng});
                }
            }
            // if(i == R.trip.user_id){
            //     // là host
            //     if(i == R.userId) {
            //         // là user
            //         if(!_this.userMaker) {
            //             _this.userMaker = _this.makeMaker({lat: users[i].lat, lng: users[i].lng}, "UH");
            //         }
            //     } else {
            //         if(!_this.host) {
            //             _this.host = _this.makeMaker({lat: users[i].lat, lng: users[i].lng}, "H");
            //         } else {
            //             _this.host.setPosition({lat: users[i].lat, lng: users[i].lng});
            //         }
            //     }
            // } else {
            //     if(i == R.userId) {
            //         if(!_this.userMaker) {
            //             _this.userMaker = _this.makeMaker({lat: position.latitude, lng: position.longitude}, "UM");
            //         }
            //     } else {
            //         if(!_this.member[i]) {
            //             _this.member[i] = _this.makeMaker({lat: users[i].lat, lng: users[i].lng}, "M");
            //         } else {
            //             _this.member[i].setPosition({lat: users[i].lat, lng: users[i].lng});
            //         }
            //     }
            // }
        }
    });
}

MapCustom.prototype.setUserMakerPosition = function(position) {
    this.updatePositionInServer(position);
    if (this.userMaker) {
        this.userMaker.setPosition({lat: position.latitude, lng: position.longitude});
    }
}

MapCustom.prototype.makeMaker = function(position, icon) {
    let iconImage = window.location.origin + "/asset/icon/" + icon;

    let marker = new google.maps.Marker({position: position,
        map: this.map,
        icon: iconImage,
        draggable: true
    });
    // marker.setLabel(label);
    return marker;
}

MapCustom.prototype.updatePositionInServer = function(position) {
    R.firebaseDB.ref('trip/' + R.trip.id + '/user/'+R.userId).set({
        lat: position.latitude,
        lng: position.longitude,
        name: R.userName
    });
}
