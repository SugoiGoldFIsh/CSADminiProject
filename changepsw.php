<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Changing Password</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Register</h2>
  </div>
	
    <form method="post" action="changepsw.php">
  	<?php include('errors.php'); ?>

  	<div class="input-group">
  	  <label>Old Password</label>
  	  <input type="password" name="password_1">
  	</div>
  	<div class="input-group">
  	  <label>Confirm new password</label>
  	  <input type="password" name="password_2">
  	</div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="update">Change</button>
  	</div>
  	
  </form>
</body>
</html>