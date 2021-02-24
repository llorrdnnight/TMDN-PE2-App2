<?php
/**
 * @author Greg De Vuyst
 */

include './includes/db_config.php';
include './includes/sanitize.php';

$error = null;

// if post request has been sent
if($_SERVER['REQUEST_METHOD'] == "POST"){

    // retrieve the POST variables and sanitize them
    $email = sanitize($_POST['email']);
    $password = sanitize($_POST['password']);

    
    $sql = "SELECT * FROM employee WHERE mailAddress = :mail";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':mail', $email);
    if($stmt->execute()){
        // check if employee with given email exists
        if($stmt->rowCount() > 0){
            $employee = $stmt->fetch();
            $hashed_password = $employee['password'];
            // compare hashed password with input password
            if(password_verify($password, $hashed_password)){
                // add a session variable with the employee's ID
                $_SESSION['employee_id'] = $employee['id'];
                // store the access level of the employee
                $_SESSION['admin'] = ($employee['isAdmin'] == 1)? true: false;
                // redirect the user to the dashboard
            }
            else{
                // invalid password
                $error = "Incorrect password";
            }
           
        }
        else{
            $error = "Incorrect email address";
        }
    }
    else{
        $error = "Execution error";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Login</title>
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/login.css">
</head>
<body>

    <div class="wrapper">

        <!-- The login box -->
        <div class="login-modal">
            <h1>HR - Login</h1>
            <form action="" method="POST">
                <input type="text" name="email" id="" placeholder="E-mail">
                <input type="password" name="password" id="" placeholder="Password">
                <input type="submit" value="Login">
                <p id="error"><?php echo $error; ?></p>
            </form>

        </div>

    </div>
    
</body>
</html>