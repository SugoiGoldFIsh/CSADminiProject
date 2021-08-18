
<?php 
  session_start(); 
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
        unset($_SESSION['email']);
  	header("location: index.php");
  }
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
    /* Remove the navbar's default margin-bottom and rounded borders */ 
    .navbar {
      margin-bottom: 0;
      border-radius: 0;
    }
    
    /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
    .row.content {height: 675px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      padding-top: 20px;
      background-color: #f1f1f1;
      height: 100%;
      width: 20%
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
      display: none;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
                .row.content {height:auto;}
    }
    
    #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #description {
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
      }

      #infowindow-content .title {
        font-weight: bold;
      }

      .pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
      }

      #pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
      }

      .pac-controls {
        display: inline-block;
        padding: 5px 11px;
      }

      .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }
      
      #pac-input { 
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 0px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 400px; 
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }
      #middle {height:100%; width: 80%}
      #well {height: 100%;width: 100%;}
      
  </style>
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
      <a class="navbar-brand" href="#">Logo</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
          <li class="active"><a href="index.php">Home</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Projects</a></li>
        <li><a href="#">Contact</a></li>

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
        <script>
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
                        alert("Latitude: " + event.latLng.lat() + " " + ", longitude: " + event.latLng.lng());
                        //Store latitude and longitude into variable
                        Latitude = event.latLng.lat();
                        Longitude = event.latLng.lng();
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
    <div class="col-sm-4 sidenav">
        <div class="well" id="well">
          <img src="DoverMRT.jpg" style =" height: auto; width: 100%" >
      </div>
    </div>
  </div>
</div>

<footer class="container-fluid text-center">
  <p>Footer Text</p>
</footer>

</body>
</html>
