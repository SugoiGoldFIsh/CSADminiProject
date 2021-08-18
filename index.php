
<?php include('server.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>MRT ARRIVAL TIME - HOME</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="HomePageCSS.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="stationsLatLong.js"></script>
</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
        <img class="navbar-brand" src="ImageFolder/Logo.png">
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="index.php">Home</a></li>
        <li><a href="map.php">MRT Map</a></li>
        <li><a href="about.php">About</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
          <?php  if (isset($_SESSION['username'])) : ?>
            <li> <a href="profile.php"><span class="glyphicon glyphicon-user"> <?php echo $_SESSION['username']; ?> </a></li>
          <?php else: ?>
            <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
          <?php endif ?>
      </ul>
    </div>
  </div>
</nav>
  
    <div class="container-fluid text-center">
    <input id="pac-input" class="controls" type="text" placeholder="Search Box">
  <div class="row content">
    <div id="middle" class="col-sm-8"> 
        <div id="map"></div>
        <Button id="Side-Nav-Button" onclick="openNav()">Open Sidebar</button>
        <Button id="Close-Nav-Button" onclick="closeNav()">Close Sidebar</Button>
        <script>
            function openNav(){
                    document.getElementById("middle").style.width= "80%";
                    document.getElementById("Side-Nav").style.width= "20%";
                    document.getElementById("Side-Nav").style.display= "block";
                }
            function closeNav() {
                    document.getElementById("middle").style.width= "100%";
                    document.getElementById("Side-Nav").style.width= "0%";
                    document.getElementById("Side-Nav").style.display= "none";
            }
        </script>
        <script>
          var stations = {};
          function getMRTtime(code) {
            if (!stations[code] || stations[code] < 1) stations[code] = Math.round(Math.random()*15); 
            stations[code] += Math.round(Math.random()*1-0.9);
            return stations[code];
          }
          function getDistance(lat1, long1, lat2, long2) {
              var dLat = Math.abs(lat1 - lat2);
              var dLong = Math.abs(long1 - long2);
              return dLat + dLong;
          }
            function initAutocomplete() {
                var map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: 1.3567845767409195, lng: 103.85218546345484},
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

                        var minDist = Infinity;
                        var closestStation;
                        for (station of stationsLatLong) {
                          var dist = getDistance(station.lat, station.long, Latitude, Longitude);
                          if (dist < minDist) {
                            minDist = dist;
                            closestStation = station;
                          }
                        }
                        console.log(minDist)
                        //serangoon: 1.3499488990593538, 103.87345790863037
                        //var SerangoonMRTTime = 10;
                        //var SerangoonDistance = getDistance(1.3499488, 103.87345, Latitude, Longitude);
                        var time = getMRTtime(closestStation.code)
                        if (minDist < 0.002) {
                            dispSt.textContent = closestStation.name;
                            disp.textContent = "Next MRT arrival : "+ time +" minutes";
                            document.getElementById("MRTImage").src="ImageFolder/DoverMRT.jpg";
                        } else {
                            dispSt.textContent = "";
                            disp.textContent = "Click on an MRT station for arrival timing!";
                            document.getElementById("MRTImage").src="ImageFolder/BlankImage.jpg";
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
                      }
                       </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC8bbmButzgqA9hMwj5jh-nCkg9usIURFg&amp;libraries=places&amp;callback=initAutocomplete"
         async defer></script>
    </div>
    <div id="Side-Nav" class="col-sm-2 sidenav">
      <div class="well" id="well">
        <img id="MRTImage" src="ImageFolder/BlankImage.jpg" style =" height: auto; width: 100%" >
        <br><br>
        <ul id="unorderedlist">
          <li>Latitude: <span id="lat"></span></li>
          <li>Longitude: <span id="lon"></span> </li>
        </ul>
        <br>
        <span id="dispSt"></span>
        <span id="disp">Click on an MRT for arrival timing!</span>
        <br>
        <?php  if (isset($_SESSION['username'])) : ?>
          <div class="Rating-container">
            <form action="index.php" method="post">
              <div class="star-widget">
                <p id="RateUs" class="RateUs">Rate Our Website!</p>
                <input type="radio" name="rate5" id="rate-5">
                <label for="rate-5" class="fas fa-star"></label>
                <input type="radio" name="rate4" id="rate-4">
                <label for="rate-4" class="fas fa-star"></label>
                <input type="radio" name="rate3" id="rate-3">
                <label for="rate-3" class="fas fa-star"></label>
                <input type="radio" name="rate2" id="rate-2">
                <label for="rate-2" class="fas fa-star"></label>
                <input type="radio" name="rate1" id="rate-1">
                <label for="rate-1" class="fas fa-star"></label>
                <div id="Rating-form" class="Rating-form">
                  <header></header>
                  <div class="textarea"> 
                    <textarea cols="30" name="feedback" placeholder="Describe your experience.."></textarea>
                  </div>
                  <div class="Post-btn">
                    <button type="submit" onclick="alert('Thank You For Your Feedback!');" name="feedback_submit">Post</button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        <?php else: ?>
          <li>
            <a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Log in or sign up to submit ratings and feedback!</a>
          </li>
        <?php endif ?>
      </div>
    </div>
  </div>
</div>
</div>
</body>
</html>

