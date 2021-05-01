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
<title>Dashboard HR</title>
<link rel="stylesheet" href="./css/reset.css">
<link rel="stylesheet" href="./css/dashboard.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">

</head>
<body>
<div class="header">
<h2 class="logo">Dashboard HR</h2>
<img class="img" src="images\Blue Sky Unlimited.png" alt="logo">

</div>
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
      <a href="Vacature.php"><div class="card">
        <div class="container">
          <h4><b>Vacature</b></h4> 
        </div>
      </div></a>
      <a href="absences/create.php"><div class="card">
        <div class="container">
          <h4><b>Sickness report</b></h4> 
        </div>
      </div></a>
      <a href="absences/overview.php"><div class="card">
        <div class="container">
          <h4><b>Sickness overview</b></h4> 
        </div>
      </div></a>
      <div class="card-logout">
        <div class="container">
          <form action="" method="post">
            <input type="submit" value="Logout">
          </form>
        </div>
      </div>
</div>
</body>
</html> 
