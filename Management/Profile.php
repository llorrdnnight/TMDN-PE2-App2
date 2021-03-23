<?php
session_start();
// Check if the session is set else redirect to login page
if (isset($_SESSION['employee_id'])){}

else
header("Location: login.php")
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/reset.css"/>
    <link rel="stylesheet" href="css/common.css"/>
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="stylesheet" href="css/bootstrap.css"/>

</head>
<body>
    <div class="wrapper">
            <nav class="navbar navbar-expand-lg navbar-dark">
            <img src="images/LOGO_composite.png" alt="Logo Blue Sky" class="nav-logo"/>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div id="nav-content" class="desktop">
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav" style="font-size: 17px;">
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
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav" style="font-size: 20px;">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Email <span class="sr-only">(current)</span></a>
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
                    </ul>
                </div>
            </div>
            <div id="nav-content" class="mobile">
                <div class="collapse navbar-collapse" id="navbar">
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">Email <span class="sr-only">(current)</span></a>
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
                <h2>Personal info</h2>                    
                    <div class="flex-container">
                        <div>
                        <?php
                        // open connection to db and fetch data for logged in user
                        $id = $_SESSION['employee_id'];
                        $host = "localhost";
                        $user = "root";
                        $password = "";
                        $db = "testdb";
                        $sql = "SELECT * FROM employee WHERE id = $id";
                        $link = mysqli_connect($host, $user,$password) or die("Error: no connection");
                        mysqli_select_db($link,$db) or die("Error: db could not be opened");
                        $result = mysqli_query($link,$sql);
                        while($row = mysqli_fetch_array($result))
                        {
                            echo("<tr>
                                <p>Name :" .$row['firstName']."  " .$row['lastName']."</p>
                                <p>Email :".$row['mailAddress']."</p>
                                <p>Phone :".$row['phoneNumber']."</p>
                                <p>Birthdate :".$row['birthDate']."</p>
                                <p>Salary :".$row['salary']."</p>
                                </tr>");
                                $jobid = $row['job'];

                        }
                            ?>
                        </div>

            </div>
          
            <div>
                <h2>Job function</h2>  
                <div class="flex-container">
                    <div>
                    <?php
                        // fetch data for logged in user

                        $sql = "SELECT name FROM job WHERE id = $jobid";
                        $result = mysqli_query($link,$sql);
                        while($row = mysqli_fetch_array($result))
                        {
                            echo("<tr>
                                <p>job :" .$row['name']."</p>
                                </tr>");

                        }
                        mysqli_close($link);
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
        include "components/footer.php";    // footer by Levi
        ?> 
</body>
</html>
