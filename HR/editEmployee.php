<?php
error_reporting(E_ERROR | E_PARSE);
if (!isset($_SESSION)) { session_start(); };
require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php");

include(INCLUDESDIR . "db_config.php");
include(INCLUDESDIR . "authentication.php");
include(COMPONENTSDIR. "navbar.php");
include(PHPCLASSDIR . "Employee.php");


$employee = $_GET['id'];

$url = "http://10.128.30.7:8080/api/employees/".$employee;

$response = file_get_contents($url);
$employee = json_decode($response);


if($_SERVER['REQUEST_METHOD'] == "POST"){

    $fname = $_POST['fname'];
    $lName = $_POST['lname'];
    $mail = $_POST['mail'];
    $phone = $_POST['phone'];
    $admin = $_POST['admin'];
    $password = $_POST['password'];
    $c_password = $_POST['c-password'];
    $salary = $_POST['salary'];


    // make api request


    // notify user by msg


}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit employee | HR</title>
    <link rel="stylesheet" href=<?= HTMLCSS . "reset.css"; ?>>
    <link rel="stylesheet" href=<?= HTMLCSS . "state-messages.css"; ?>>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css">
    <link rel="stylesheet" href=<?= HTMLCSS . "navbar.css"; ?>>
    <link rel="stylesheet" href=<?= HTMLCSS . "search.css"; ?>>
    <script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous">
    </script>
    <script src=<?= HTMLJAVASCRIPT . "notification.js"; ?>></script>


</head>
<body>

    <div class="wrapper">
    <?php echo generateNavigationBar("Edit -  $employee->employeeFirstName $employee->employeeLastName #$employee->id", "/", getEmployeeFirstName()) ?>

        <div class="success-message">
            Employee editing!
        </div>
        <div class="error-message">
            Failed editing employee!
        </div>
        <div class="content">

        <div class="add-modal">
        <h1>Edit</h1>
        <form action="" method="POST">

            <div class="row">
            <label for="">First name</label>
            <input type="text" name="fname" value="<?php echo $employee->employeeFirstName ?>" id="">
            </div>

            <div class="row">
            <label for="">Last name</label>
            <input type="text" name="lname" value="<?php echo $employee->employeeLastName ?>" id="">
            </div>

            <div class="row">
            <label for="">Mail</label>
            <input type="text" name="mail" value="<?php echo $employee->employeeMailAddress ?>" id="">
            </div>

            <div class="row">
            <label for="">Phone number</label>
            <input type="text" name="phone" value="<?php echo $employee->employeePhoneNumber ?>" id="">
            </div>

            <div class="row">
            <label for="">Salary</label>
            <input type="text" name="salary" value="<?php echo $employee->employeeSalary ?>" id="">
            </div>

            <div class="row">
            <label for="">Admin</label>
            <select name="admin" id="">
                <option <?php if($employee->isAdmin == 0){echo "selected=selected";} ?> value="0">No</option>
                <option <?php if($employee->isAdmin == 1){echo "selected=selected";} ?> value="1">Yes</option>

            </select>
            </div>

            <div class="row">
            <input type="submit" value="Add employee">
            </div>



        </form>

    </div>

        </div>
    </div>




</body>
</html>
