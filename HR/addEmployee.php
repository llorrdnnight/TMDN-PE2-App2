<?php
    if (!isset($_SESSION)) { session_start(); };
error_reporting(E_ERROR | E_PARSE);
require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php");

include(INCLUDESDIR . "db_config.php");
include(INCLUDESDIR . "authentication.php");
include(COMPONENTSDIR. "navbar.php");
include(PHPCLASSDIR . "Employee.php");

    require_once(PHPSCRIPTDIR . "db_config.php"); 
    require_once(PHPSCRIPTDIR . "authentication.php");
    require_once(COMPONENTSDIR. "/navigation/navbar.php");
    require_once(PHPCLASSDIR . "Employee.php");

    $addSuccess = false;
    $addFailure = false;

    // get the groups
    $url = "http://10.128.30.7:8080/api/AD/departments";
    $response = file_get_contents($url);
    $groups = json_decode($response);

    $opts = array(
        'http'=>array(
        'method'=>"GET",
        'header'=>"Accept-language: en\r\n" .
                    "Cookie: access_token=".$_COOKIE['access_token']."\r\n"
        )
    );

    $context = stream_context_create($opts);

    if($_SERVER['REQUEST_METHOD'] == "POST"){


if($_SERVER['REQUEST_METHOD'] == "POST"){

    $fname = $_POST['fname'];
    $lName = $_POST['lname'];
    $group = $_POST['group'];



    // add the employee

    $url = "http://10.128.30.7/common/php/addEmployee.php?employeeFirstName=$fname&employeeLastName=$lName";

    $result = file_get_contents($url, false, $context);

        else{
            $addFailure = true;
        }

        // notify user by msg



    // add group to employee

    $url = "http://10.128.30.7/common/php/addUserToGroupDN.php?userdn=$dn&group=CN=$group,OU=TEST,DC=test,DC=local";
    $response = file_get_contents($url, false, $context);
    $result = json_decode($response);

    if($result->success == true){
        $addSuccess = true;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Employee | HR</title>
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
    <?php echo generateNavigationBar("Add Employee", "/app2/hr/dashboard", getEmployeeFirstName()) ?>

        <?php if($addSuccess):?>
        <div class="success-message">
            Employee created!
        </div>
        <?php endif; ?>
        <?php if($addFailure):?>
        <div class="error-message">
            Failed creating employee!
        </div>
        <?php endif; ?>
        <div class="content single">

        <div class="add-modal">
        <h1>New employee</h1>
        <form action="" method="POST">

            <div class="row">
            <label for="">First name</label>
            <input type="text" name="fname" id="">
            </div>

            <div class="row">
            <label for="">Last name</label>
            <input type="text" name="lname" id="">
            </div>

            <div class="row">
            <label for="">Department</label>
            <select name="group" id="">
            <?php foreach($groups as $group): ?>
                <option value="<?php echo $group->name; ?>"><?php echo $group->name; ?></option>
            <?php endforeach; ?>
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
