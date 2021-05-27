<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php");
require_once(PHPSCRIPTDIR . "error.php");
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include(INCLUDESDIR . "authentication.php");
include(COMPONENTSDIR . "navbar.php");

if(isHR() == false && isManagement() == false){
    header("Location: /portal");
}

if (!isset($_SESSION)) { session_start(); };


if($_SERVER['REQUEST_METHOD'] == "POST"){ // ?
  setcookie("access_token", "", time() - 3600);
}


?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard HR</title>
<link rel="stylesheet" href=<?= HTMLCSS . "reset.css"; ?>>
<link rel="stylesheet" href=<?= HTMLCSS . "navbar.css"; ?>>
<link rel="stylesheet" href=<?= HTMLCSS . "dashboard.css"; ?>>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">

</head>
<body>
<div class="header">
<img class="img" src=<?= HTMLIMAGES . "LOGO_composite.png"; ?> alt="logo">
<h2 class="logo">Dashboard HR</h2>
</div>
<div class="center">
    <a href=<?= HTMLHR . "employees"; ?>><div class="card">
    <div class="container">
          <h4><b>Employee</b></h4>
        </div>
      </div></a>
      <a href=<?= HTMLHR . "timesheets"; ?>><div class="card">
        <div class="container">
          <h4><b>Timesheet</b></h4>
        </div>
      </div></a>
      <a href=<?= HTMLHR . "vacature"; ?>><div class="card">
        <div class="container">
          <h4><b>Vacature</b></h4>
        </div>
      </div></a>
      <a href=<?= HTMLHR . "absences/create"; ?>><div class="card">
        <div class="container">
          <h4><b>Sickness report</b></h4>
        </div>
      </div></a>
      <a href=<?= HTMLHR . "absences/overview"; ?>><div class="card">
        <div class="container">
          <h4><b>Sickness overview</b></h4>
        </div>
      </div></a>
      <a><div class="card-logout">
        <div class="container">
          <form action="" method="post">
            <input type="submit" value="Logout">
          </form>
        </div>
      </div></a>
</div>
</body>
</html>
