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
      <div class="card-logout">
          <form action="" method="post">
            <input type="submit" value="Logout">
          </form>
      </div>
</div>
</body>
</html> 
