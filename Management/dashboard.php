<?php
    if (!isset($_SESSION)) { session_start(); };
    require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php");
    require_once(PHPSCRIPTDIR . "error.php");
    require_once(PHPSCRIPTDIR . "authentication.php");

    if(!isLoggedIn())
        header("Location: login.php");

    if($_SERVER['REQUEST_METHOD'] == "POST")
        header("Location: logout.php"); //automatically redirects to login
?>

<!-- change this to include the default header please. -->
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard Management</title>
<link rel="stylesheet" href='<?= HTMLCSS . "reset.css"; ?>'>
<link rel="stylesheet" href='<?= HTMLCSS . "dashboard.css"; ?>'>
</head>
<body>
    <div class="header">
        <h2 class="logo">Dashboard Management</h2>
        <img class="img" src="images\Blue Sky Unlimited.png" alt="logo">
    </div>

    <div class="center">
        <a href="Profile.php">
            <div class="card">
                <div class="container">
                    <h4><b>Account</b></h4>
                </div>
            </div>
        </a>

        <a href="#">
            <div class="card">
                <div class="container">
                    <h4><b>Employee list</b></h4>
                </div>
            </div>
        </a>

        <a href="deliveries.php">
            <div class="card">
                <div class="container">
                    <h4><b>Orders</b></h4>
                </div>
            </div>
        </a>

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
