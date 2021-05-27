<?php
use Carbon\Carbon;
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php");
include(INCLUDESDIR . "authentication.php");
include(INCLUDESDIR . "sanitize.php");
require(HRDIR. "vendor/autoload.php");
include(PHPCLASSDIR . "Absence.php");
include(PHPCLASSDIR . "Employee.php");
include(COMPONENTSDIR . "navbar.php");
if(isHR() == false && isManagement() == false){
    header("Location: /portal");
}
$success = false;

$user = "test";
$pass = "1Azerty?!";
// try and create a PHP database object
try {
    $db = new PDO('mysql:host=10.128.63.132;dbname=Bluesky_DB', $user, $pass);
}

// handle exception
catch (PDOException $e) {
    echo "Oops something when wrong trying to connect to the database: ".$e->getMessage();

}



function getHoursWorked($start, $end, $db, $employee){
    $sql = "SELECT * FROM timesheets WHERE start BETWEEN '$start' AND '$end' AND employee = $employee ";
    $result = $db->query($sql);


if($result->rowCount() > 0){
    $records = $result->fetchAll();
    $totalAmountWorked = 0;
    foreach($records as $record){
        $start = Carbon::parse($record['start']);
        $end = Carbon::parse($record['end']);
        $diff = abs($start->diffInHours($end));
        $totalAmountWorked += $diff;
    }
        return $totalAmountWorked;
}
}






if(isset($_GET['employee'])){
    $employee = $_GET['employee'];
    $result = $db->query("SELECT * FROM timesheets WHERE employee = $employee");
    $absences = $result->fetchAll();


    $startOfWeek = Carbon::now()->startOfWeek()->format('Y-m-d H:i:s');
    $endOfWeek = Carbon::now()->endOfWeek()->format('Y-m-d H:i:s');
    $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
    $endOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');
    $startOfYear = Carbon::now()->startOfYear()->format('Y-m-d H:i:s');
    $endOfYear = Carbon::now()->endOfYear()->format('Y-m-d H:i:s');

    $hoursWorkedThisWeek = getHoursWorked($startOfWeek, $endOfWeek, $db, $employee);
    $hoursWorkedThisMonth = getHoursWorked($startOfMonth, $endOfMonth, $db,$employee);
    $hoursWorkedThisYear = getHoursWorked($startOfYear, $endOfYear, $db,$employee);
}
else if(isset($_GET['q'])){
    $q = $_GET['q'];
    $stmt = $db->query("SELECT * FROM timesheets WHERE employee IN(SELECT id FROM employees WHERE CONCAT(employeeFirstName, ' ', employeeLastName) LIKE '%".$q."%')");
    $absences = $stmt->fetchAll();

}
else{
    $result = $db->query("SELECT * FROM timesheets");
    $absences = $result->fetchAll();
}




?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timesheets overview - HR</title>
    <link rel="stylesheet" href=<?= HTMLCSS . "reset.css"; ?>>
    <link rel="stylesheet" href=<?= HTMLCSS . "navbar.css"; ?>>
    <link rel="stylesheet" href=<?= HTMLCSS . "state-messages.css"; ?>>
    <link rel="stylesheet" href=<?= HTMLCSS . "absences.css"; ?>>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css">
    <script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous">
    </script>
    <script src=<?= HTMLJAVASCRIPT . "notification.js"; ?>></script>
</head>
<body>
    <div class="wrapper">

    <?php echo generateNavigationBar("Timesheets overview", "app2/hr/dashboard", getEmployeeFirstName()) ?>



    <div class="content">
        <div class="navigation">
            <div>
                    <form action="" method="GET">
                    <i class="fa fa-search"></i>
                    <input type="search" placeholder="Search employee..." name="q" id="">
                </form>
            </div>
        </div>


        <div class="inner">
        <?php if(isset($employee) || isset($q)): ?>
        <div class="banner">


            <?php if(isset($employee)): ?>
            <?php


                $url = "http://10.128.30.7:8080/api/AD/employees?id=$employee";
                $response = file_get_contents($url);
                $result = json_decode($response);
                $employeeNameAD = $result->employeeFirstName. " ".$result->employeeLastName;


            ?>
            <div class="info">
              <a href="/app2/hr/timesheets/overview" class="fa fa-arrow-left"></a></i><span>Timesheets for: </span><span><?php echo $employeeNameAD; ?></span>
            </div>
            <div class="info">
                <span>Hours this week: </span><span><?php echo $hoursWorkedThisWeek; ?></span>
            </div>
            <div class="info">
                <span>Hours this Month: </span><span><?php echo $hoursWorkedThisMonth; ?></span>
            </div>
            <div class="info">
                <span>Hours this Year: </span><span><?php echo $hoursWorkedThisYear; ?></span>
            </div>
            <?php elseif(isset($q)):?>
                <div class="info">
              <a href="/app2/hr/timesheets/overview" class="fa fa-arrow-left"></a></i><span>Timesheet search for: </span><span><?php echo $q; ?></span>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
            <table>
                <tr>
                    <td>Employee</td>
                    <td>Start date</td>
                    <td>End date</td>
                    <td>Hours</td>

                </tr>

                <?php


                foreach($absences as $absence):


                    $id = $absence['employee'];
                    $url = "http://10.128.30.7:8080/api/AD/employees?id=$id";
                    $response = file_get_contents($url);
                    $result = json_decode($response);
                    $employeeNameAD = $result->employeeFirstName. " ".$result->employeeLastName;

                ?>
                <tr>

                    <?php if(isset($employee)): ?>
                    <td><a href="/app2/hr/timesheets/overview?employee=<?php echo $id ?>"><?php echo $employeeNameAD; ?></a></td>
                    <?php else: ?>
                    <td><a href="/app2/hr/timesheets/overview?employee=<?php echo $id ?>"><?php echo $employeeNameAD; ?></a></td>
                    <?php endif; ?>
                    <td><?php echo explode(" ", $absence['start'])[0] ?></td>
                    <td><?php echo explode(" ", $absence['end'])[0] ?></td>
                    <td>
                     <?php

                     $start = Carbon::parse($absence['start']);
                     $end = Carbon::parse($absence['end']);
                     echo $end->diff($start)->format('%h hour(s) and %m minute(s)');


                     ?>

                    </td>



                </tr>



                <?php endforeach;
                ?>



            </table>
            <?php
             if(count($absences) == 0):
            ?>
            <p style="text-align:center;margin-top: 1rem; font-weight: 600">No records found for this particular query.</p>
            <?php endif; ?>
        </div>
    </div>


    </div>

</body>
</html>
