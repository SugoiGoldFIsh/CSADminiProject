<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'registration');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO users (username, email, password) 
  			  VALUES('$username', '$email', '$password')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
    $_SESSION['email'] = $email;
    $_SESSION['feedback'] = "";
  	header('location: index.php');
  }
}
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
  	array_push($errors, "Username is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
  	$password = md5($password);
  	$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  	$results = mysqli_query($db, $query);
  	if (mysqli_num_rows($results) == 1) {
          $values = mysqli_fetch_array($results);
  	  $_SESSION['username'] = $username;
          $_SESSION['email'] = $values['email'];
          $_SESSION['feedback'] = $values['feedback'];
  	  $_SESSION['success'] = "You are now logged in";
  	  header('location: index.php');
  	}else {
  		array_push($errors, "Wrong username/password combination");
  	}
  }
}
if (isset($_POST['feedback_submit'])) {
        $feedback = mysqli_real_escape_string($db, $_POST['feedback']);
        $username = $_SESSION['username'];
  	$query_feedback = "UPDATE users SET feedback = '$feedback' WHERE username='$username'";
          mysqli_query($db, $query_feedback);
          $_SESSION['feedback'] = $feedback;
  	} else {
  		//array_push($errors, "Please login");
}

  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
        unset($_SESSION['email']);
        unset($_SESSION['feedback']);
  	header("location: index.php");
  }
  
  if (isset($_POST['update'])) {
    $username = $_SESSION['username'];
    $query_update = "SELECT * FROM users WHERE username='$username'";
    $results = mysqli_query($db, $query_update);
    $values = mysqli_fetch_array($results);
    $password1=$values['password'];
    $password_1 = md5(mysqli_real_escape_string($db, $_POST['password_1']));
    $password_2 = md5(mysqli_real_escape_string($db, $_POST['password_2']));
    if ($password_1 != $password1) {
      array_push($errors, "The two passwords do not match");
    } else {
      $sql = "UPDATE users SET password='$password_2' WHERE username='$username'";
      mysqli_query($db, $sql);
      $_SESSION['message'] = "passsword Updated";
      header('location: index.php');
    }
  }
  
  if (isset($_POST['rate1'])) {
        $rate='1';
        $username = $_SESSION['username'];
  	$query_rating = "UPDATE users SET rating = '$rate' WHERE username='$username'";
          mysqli_query($db, $query_rating);
  	}

  if (isset($_POST['rate2'])) {
        $rate='2';
        $username = $_SESSION['username'];
  	$query_rating = "UPDATE users SET rating = '$rate' WHERE username='$username'";
          mysqli_query($db, $query_rating);
  	}
        
  if (isset($_POST['rate3'])) {
        $rate='3';
        $username = $_SESSION['username'];
  	$query_rating = "UPDATE users SET rating = '$rate' WHERE username='$username'";
          mysqli_query($db, $query_rating);
  	}
        
  if (isset($_POST['rate4'])) {
        $rate='4';
        $username = $_SESSION['username'];
  	$query_rating = "UPDATE users SET rating = '$rate' WHERE username='$username'";
          mysqli_query($db, $query_rating);
  	}
        
  if (isset($_POST['rate5'])) {
        $rate='5';
        $username = $_SESSION['username'];
  	$query_rating = "UPDATE users SET rating = '$rate' WHERE username='$username'";
          mysqli_query($db, $query_rating);
  	}
        
?>