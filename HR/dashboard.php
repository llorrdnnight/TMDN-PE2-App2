<?php

session_start();
include './includes/authentication.php';


if(!isLoggedIn()){

  header("Location: login.php");
}


if($_SERVER['REQUEST_METHOD'] == "POST"){

  logoutUser();
  header("Location: login.php");


}


?>


<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard</title>
<link rel="stylesheet" href="./css/reset.css">
<link rel="stylesheet" href="./css/dashboard.css">
</head>
<body>

<h2 class="title">Dashboard</h2>
<div class="center">
    <div class="card">
        <div class="container">
          <h4><b>Account</b></h4> 
        </div>
      </div>
      <div class="card">
        <div class="container">
          <h4><b>Employee list</b></h4> 
        </div>
      </div>
      <div class="card-logout">


          <form action="" method="post">
            <input type="submit" value="Logout">
          </form>

      </div>
</div>
</body>
</html> 
