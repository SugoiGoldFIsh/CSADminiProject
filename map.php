
<?php 
include 'server.php';
 
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>MRT ARRIVAL TIME - MAP</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="HomePageCSS.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
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
        <li class="active"><a href="map.php">MRT Map</a></li>
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
  <div class="row content">
    <div id="middle" class="col-sm-8"> 
        <iframe id="map" style="width:100%; height:100%; border:none;" src="https://angyongen.github.io/Singapore-MRT-Network/"></div>
    </div>
    <div id="Side-Nav" class="col-sm-2 sidenav">
    </div>
</div>
</div>
</body>
</html>

