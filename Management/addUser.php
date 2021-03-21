
<?php
include './includes/db_config.php';
include './includes/sanitize.php';
include "components/check_db.php"; // check if the foreig keys have been set
// add a new user
$msg = null;
// if post request has been sent
if($_SERVER['REQUEST_METHOD'] == "POST"){
    // retrieve the POST variables and sanitize them
    $fName = sanitize($_POST['fName']);
    $lName = sanitize($_POST['lName']);
    $email = sanitize($_POST['email']);
    $password = sanitize($_POST['password']);
    $bod = $_POST['dob'];
    $pnum = $_POST['pnum'];
    $sal = $_POST['sal'];
    $job = $_POST['job'];
    $admin = $_POST['admin'];

    // add a new user
$password = password_hash("password",PASSWORD_DEFAULT);
$sql = "SELECT COUNT(*) AS 'id' FROM employee;";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result);
$id = $row['id'] + 1;
$sql = "INSERT INTO employee(id,firstName,lastName,mailAddress,password,birthDate,phoneNumber,salary,job,isAdmin) VALUES($id,\"$fName\",\"$lName\",\"$email\",\"$password\",\"2000-03-21\",$pnum,$sal,$job,$admin);";
mysqli_query($link,$sql);
mysqli_close($link);
$msg = " Query done!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Add User</title>

    <?php 
    // this piece of code is redundant
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
                    <a href="">palceholder</a>
                </li>
                <li>
                    <a href="">palceholder</a>
                </li>
                <li>
                    <a href="">palceholder</a>
                </li>
                <li>
                    <a href="">palceholder</a>
                </li>
                <li>
                    <a href="">palceholder</a>
                </li>
                <li>
                    <a href="login.php">logout</a>
                </li>
            </ul>
        </nav>
        
        <div class="content">
            <div>
                <h2>Add a new employee</h2>                    
                    <div class="flex-container">
                        <div>
                            <form action="" method="POST">
                                <p>
                                <input type="text" name="fName" id="" placeholder="First Name">
                                <input type="text" name="lName" id="" placeholder="Last Name">
                                <input type="date" name="dob" id="" placeholder="Date of birth">
                                </p>
                                <p>
                                <input type="text" name="email" id="" placeholder="E-mail">
                                <input type="tel" name="pnum" id="" placeholder="Phonenumber">
                                <input type="password" name="password" id="" placeholder="password">
                                </p>
                                <p>
                                <input type="text" name="sal" id="" placeholder="Salary">
                                <input type="text" name="job" id="" placeholder="Job ID (1 for now)">
                                <input type="hidden" name="admin" id="" value = 0>
                                <input type="checkbox" name="admin" id="" value= 1>
                                <label for="admin">Admin</label>
                                </p>
                                <input type="submit" value="Save">
                                <p id="error"><?php echo $msg; ?></p>
                            </form>
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
