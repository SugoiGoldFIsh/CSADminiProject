
<?php 
include ('server.php');
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="style.css">
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
        <img class="navbar-brand" src="ImageFolder/Logo.png">
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="index.php">Home</a></li>
        <li><a href="map.php">MRT Map</a></li>
        <li><a href="#">About</a></li>
        <li><a href="#">Projects</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
          <?php  if (isset($_SESSION['username'])) : ?>
            <li class="active"> <a href="profile.php"><span class="glyphicon glyphicon-user" style="text-transform: capitalize;"> <?php echo $_SESSION['username']; ?> </a></li>
          <?php else: ?>
            <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
          <?php endif ?>
        
      </ul>
    </div>
  </div>
</nav>
  
<div class="container-fluid text-center">
<h1 style="text-align:left; text-decoration: black; text-transform: capitalize;"> Welcome <?php echo $_SESSION['username']; ?></h1></br>
<img id="user" src="ImageFolder/user.png" style =" height: 120px; width:120px; float: left" >

<table class="profile">
    <tr><td><span style="text-align:left; text-transform: capitalize;">Username:</span></td><td><?php echo $_SESSION['username']?></td></tr>
    <tr><td><span style="text-align:left; ">Email:</span></td><td><?php echo $_SESSION['email']?></td></tr>
    <tr><td><span style="text-align:left; ">Previous Feedback:</span></td><td><?php echo $_SESSION['feedback']?></br></td></tr>
</table>  
   <p style="color: red; text-align: left; background: transparent; border: 2px solid #B0C4DE; width: 5%; font-weight:Bold ;"><a href="index.php?logout='1'">logout</a> </p>
</div>

<footer class="container-fluid text-center">
  <p>Like and want to support us? Click the link right <a href="donation.php">here</a></p>
</footer>

</body>
</html>

