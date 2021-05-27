<?php
if (!isset($_SESSION)) { session_start(); };
// Check if the session is set else redirect to login page
require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php"); 

if (isset($_SESSION['employee_id'])){}
else
header("Location: login.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <link rel="stylesheet" href=<?= HTMLCSS . CSS_RESET;?>>
    <link rel="stylesheet" href="../css/common.css"/>
    <link rel="stylesheet" href="../css/style.css"/>


</head>
<body>
    <div class="wrapper">
            <nav class="navbar navbar-expand-lg navbar-dark">
            <img src= <?= HTMLIMAGES . "LOGO_composite.png"; ?> alt="Logo Blue Sky" class="nav-logo"/>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div id="nav-content" class="desktop">
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav" style="font-size: 20px;">
                        <li class="nav-item active">
                            <a class="nav-link" href="dashboard.php">Dashboard <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div id="nav-content" class="mobile">
                <div class="collapse navbar-collapse" id="navbar">
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="dashboard.php">Dashboard <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Network</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Partners</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Company</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#">Language</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">New</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Search</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="content">
                    <div class="flex-container">
                        <div>
                        <h2>Personal info</h2>
                        <?php
                        // open connection to db and fetch data for logged in user
                        $id = $_SESSION['employee_id'];
                        $data = json_decode(file_get_contents("http://10.128.30.7:8080/api/employees"), true);

                        foreach ($data as $user){
                            if($user['id'] == $id)
                            $loggedIn = $user;
                        }
                        if($loggedIn['employeeIsAdmin'])
                        $admin = "True";
                        else
                        $admin = "False";
                        echo("<tr>
                            <p>Name :" .$loggedIn['employeeFirstName']."  " .$loggedIn['employeeLastName']."</p>
                            <p>Email :".$loggedIn['employeeMailAddress']."</p>
                            <p>Phone :".$loggedIn['employeePhoneNumber']."</p>
                            <p>Birthdate :".$loggedIn['employeeBirthDate']."</p>
                            <p>Salary :".$loggedIn['employeeSalary']."</p>
                            <p>Job ID :".$loggedIn['employeeJobID']. "</p>
                            <P>Is Admin ? :".$admin. "</p>
                            </tr>");
                            ?>
                        </div>

            </div>
        </div>
    </div>

</body>
</html>
