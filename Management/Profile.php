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
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Profile</title>
    <?php 
    $host = "localhost";
    $user = "Webuser";
    $password = "Labo2020";
    $database = "hr";
    ?>
</head>
<body>
    <div class="wrapper">
        <div class="top">
            

            <h1 class="title">Blue Sky Unlimited</h1>
        </div>

        <nav>
            <ul>
                <li>
                    <a href="login.php">logout</a>

                </li>

            </ul>
        </nav>
        
        <div class="content">
            <div>
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
