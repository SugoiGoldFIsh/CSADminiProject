function initAutocomplete() {
    var map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: 1.3567845767409195, lng: 103.85218546345484 },
        zoom: 13,
        mapTypeId: 'roadmap'
    });
    // Create the search box and link it to the UI element.
    var input = document.getElementById('pac-input');
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function() {
        searchBox.setBounds(map.getBounds());
    });

    //To get the latititude and the longtitude
    var Latitude;
    var Longitude;
    google.maps.event.addListener(map, 'click', function(event) {
        //alert("Latitude: " + event.latLng.lat() + " " + ", longitude: " + event.latLng.lng());
        //Store latitude and longitude into variable
        Latitude = event.latLng.lat();
        Longitude = event.latLng.lng();

        var SerangoondLat = Math.abs(1.3499488990593538 - Latitude);
        var SerangoondLong = Math.abs(103.87345790863037 - Longitude);
        var SerangoonMRTTime = 10;
        if (SerangoondLat < 0.00005 && SerangoondLong < 0.00005) {
            disp.textContent = "Next MRT arrival is in: " + SerangoonMRTTime + " minutes";
        } else {
            disp.textContent = "Click on an MRT station for arrival timing!";
        }
        lat.textContent = Latitude;
        lon.textContent = Longitude;
    });


    var markers = [];
    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    searchBox.addListener('places_changed', function() {
        var places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }

        // Clear out the old markers.
        markers.forEach(function(marker) {
            marker.setMap(null);
        });
        markers = [];

        // For each place, get the icon, name and location.
        var bounds = new google.maps.LatLngBounds();
        places.forEach(function(place) {
            if (!place.geometry) {
                console.log("Returned place contains no geometry");
                return;
            }
            var icon = {
                url: place.icon,
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
                map: map,
                icon: icon,
                title: place.name,
                position: place.geometry.location
            }));

            if (place.geometry.viewport) {
                // Only geocodes have viewport.
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
        });
        map.fitBounds(bounds);
    });
    /*var SideNavBtn = document.createElement("Button");
    SideNavBtn.id = "Side-Nav-Button";
    SideNavBtn.onclick = "openNav()";
    SideNavBtn.value = "Open Sidebar";
    map.appendChild(SideNavBtn);*/
}