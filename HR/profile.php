<?php
error_reporting(E_ERROR | E_PARSE);
if (!isset($_SESSION)) { session_start(); };
require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php");

include(INCLUDESDIR . "db_config.php");
include(INCLUDESDIR . "authentication.php");
include(COMPONENTSDIR. "navbar.php");
include(PHPCLASSDIR . "Employee.php");


if(isHR() == false && isManagement() == false){
    header("Location: /portal");
}


if(isset($_GET['id'])){
    $employee = $_GET['id'];
}
else{
    $employee = getLoggedInEmployee()->id;
}

if($employee > 15){$employee--;}


$url = "http://10.128.30.7:8080/api/AD/employees?id=".$employee;

$response = file_get_contents($url);
$employee = json_decode($response);


$groupsStr = $employee->memberOf[0];
$startCN = strpos($groupsStr, 'CN=') + 3;
$endCN = strpos($groupsStr, ',');
$employee->employeeDepartment = substr($groupsStr, $startCN, $endCN-$startCN);


if($_SERVER['REQUEST_METHOD'] == "POST"){

   // disable employee
   if(isset($_POST['disabled'])){
       $state = 0;
   }
   else if(isset($_POST['enabled'])){
       $state = 1;
   }

   $opts = array(
    'http'=>array(
      'method'=>"GET",
      'header'=>"Accept-language: en\r\n" .
                "Cookie: access_token=".$_COOKIE['access_token']."\r\n"
    )
    );

   $context = stream_context_create($opts);


   $response = file_get_contents("http://10.128.30.7/common/php/disableEmployee.php?id=$employee->id&enabled=$state", false, $context);
   $result = json_decode($response);

    if($result->success == true){
        if($state == 1){
            $addSuccess = true;
        }

        else{
            $addFailure = true;
        }


    }

    $url = "http://10.128.30.7:8080/api/AD/employees?id=".$employee->id;

    $response = file_get_contents($url);
    $employee = json_decode($response);


    $groupsStr = $employee->memberOf[0];
    $startCN = strpos($groupsStr, 'CN=') + 3;
    $endCN = strpos($groupsStr, ',');
    $employee->employeeDepartment = substr($groupsStr, $startCN, $endCN-$startCN);


}







?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | HR</title>
    <link rel="stylesheet" href=<?= HTMLCSS . "reset.css"; ?>>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css">
    <link rel="stylesheet" href=<?= HTMLCSS . "navbar.css"; ?>>
    <link rel="stylesheet" href=<?= HTMLCSS . "profile.css"; ?>>
    <link rel="stylesheet" href=<?= HTMLCSS . "state-messages.css"; ?>>
    <script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous">
    </script>
    <script src=<?= HTMLJAVASCRIPT . "notification.js"; ?>></script>


</head>
<body>

    <div class="wrapper">
    <?php echo generateNavigationBar("Profile", "/app2/hr/dashboard", getEmployeeFirstName()) ?>
        <div class="content">

            <?php if($addSuccess):?>
            <div class="success-message">
                Employee enabled!
            </div>
            <?php endif; ?>
            <?php if($addFailure):?>
            <div class="error-message">
                Employee disabled!
            </div>
            <?php endif; ?>

            <div class="profile-card">
                <div class="header">
                    <i class="fa fa-user-circle"></i>
                    <span><?php echo $employee->employeeFirstName." ".$employee->employeeLastName; ?></span>
                    <!-- TODO -->
                    <span><?php echo $employee->employeeDepartment; ?></span>
                    <!-- TODO -->
                </div>

                <div class="content">

                    <div class="info">
                        <div class="row">
                            <i class="fa fa-phone"></i><span><?php echo $employee->employeePhoneNumber?></span>
                        </div>
                        <div class="row">
                            <i class="fa fa-envelope"></i><span><?php echo $employee->employeeMailAddress?></span>
                        </div>
                        <div class="row">
                            <i class="fa fa-user"></i><span><?php echo $employee->username?></span>
                        </div>

                    </div>

                    <div class="links">

                        <?php if($employee->id > 15){$employee->id--;} ?>

                        <a href="/app2/hr/timesheets/overview?employee=<?php echo $employee->id ?>" class="link">Timesheets</a>
                        <a href="/app2/hr/absences/overview?employee=<?php echo $employee->id ?>" class="link">Absences</a>
                    </div>
                </div>
                <div class="edit-account">
                    <form action="" method="POST">
                    <?php if($employee->enabled == 1): ?>
                    <input type="submit" name="disabled" value="Disable account">
                    <?php else: ?>
                    <input type="submit" class="green" name="enabled" value="Enable account">
                    <?php endif; ?>
                    </form>
                </div>
            </div>

        </div>
    </div>

</body>
</html>
