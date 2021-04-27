
<?php
include './includes/db_config.php';
include './includes/sanitize.php';
include "components/check_db.php"; // check if the foreig keys have been set
// add a new user
$msg = "";
$err = FALSE;
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
    $id = 1;

    // add a new user
$password = password_hash("password",PASSWORD_DEFAULT);
$sql = "SELECT * FROM employee;";
$result = mysqli_query($link,$sql);

    while(($row = mysqli_fetch_array($result))){
        if($id == $row['id']){
            $id++;
        }
        if($email == $row['mailAddress']){
            
            $msg = "This email is already in use !";
            $err = TRUE;
        }
    }

if($err == FALSE){
    $sql = "INSERT INTO employee(id,firstName,lastName,mailAddress,password,birthDate,phoneNumber,salary,job,isAdmin) VALUES($id,\"$fName\",\"$lName\",\"$email\",\"$password\",\"2000-03-21\",$pnum,$sal,$job,$admin);";
    $msg = "Query complete";
}
mysqli_query($link,$sql);
mysqli_close($link);
}
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
            <div>
                <h2>Add a new employee</h2>                    
                    <div class="flex-container">
                        <div>
                            <form action="" method="POST">
                                <p>
                                <input type="text" name="fName" id="" placeholder="First Name">
                                <input type="text" name="lName" id="" placeholder="Last Name">
                                <input type="text" name="dob" id="" placeholder="Date of birth">
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
