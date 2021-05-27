<?php
use Carbon\Carbon;
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if (!isset($_SESSION)) { session_start(); };
require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php");
require(HRDIR. "vendor/autoload.php");
include(INCLUDESDIR . "authentication.php");
include(INCLUDESDIR . "sanitize.php");
include(COMPONENTSDIR . "navbar.php");
include(PHPCLASSDIR . "Employee.php");

// every employee can access!

$user = "test";
$pass = "1Azerty?!";
$employeeID = getLoggedInEmployee()->id;
// try and create a PHP database object
try {
    $db = new PDO('mysql:host=10.128.63.132;dbname=Bluesky_DB', $user, $pass);
}

// handle exception
catch (PDOException $e) {
    echo "Oops something when wrong trying to connect to the database: ".$e->getMessage();

}



function getSessionsBetweenDates($start, $end, $db){
    $sql = "SELECT count(id) as count FROM timesheets WHERE start BETWEEN '$start' AND '$end'";
    $result = $db->query($sql);

    if($result->rowCount() > 0){

        return $result->fetch(0,1)['count'];

    }
}

function getHoursWorked($start, $end, $db){
    $sql = "SELECT * FROM timesheets WHERE start BETWEEN '$start' AND '$end' ";
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



if($_SERVER['REQUEST_METHOD'] == "POST"){


    if(isset($_POST['startSession'])){

        /* Working session started */

        $now = date_create()->format('Y-m-d H:i:s');

        $stmt = $db->prepare("INSERT INTO timesheets(employee,start) VALUES(:employee, :start)");
        $stmt->bindParam(":employee", getLoggedInEmployee()->id);
        $stmt->bindParam(":start", $now);


        if($stmt->execute()){

        }
        else{
        }

    }


    else if(isset($_POST['stopSession'])){

        /* Working session stopped */
        $id = getLoggedInEmployee()->id;
        $stmt = $db->query("SELECT * FROM timesheets WHERE end IS NULL AND employee = $id");
        $result = $stmt->fetch(0,1);
        $currentSession = $result['id'];

        $now = date_create()->format('Y-m-d H:i:s');

        $stmt = $db->prepare("UPDATE timesheets SET end = :end WHERE id = $currentSession");
        $stmt->bindParam(":end", $now);


        if($stmt->execute()){

        }
        else{
        }

    }


}

// Get working hours for employees
$sql = "SELECT * FROM timesheets WHERE end IS NOT NULL AND employee = $employeeID AND id = (SELECT MAX(id) FROM timesheets WHERE employee = $employeeID AND end IS NOT NULL)";
$result = $db->query($sql);
$lastSession = null;
$currentSession = null;

if($result->rowCount() > 0){
    $lastSession =  $result->fetch(0,1);

}

else{
}

$sql = "SELECT * FROM timesheets WHERE employee = $employeeID AND end IS NULL LIMIT 0,1";
$result = $db->query($sql);

if($result->rowCount() > 0){
    $currentSession = $result->fetch(0,1);
}

else{
}



// calculate some statistics


$startOfWeek = Carbon::now()->startOfWeek()->format('Y-m-d H:i:s');
$endOfWeek = Carbon::now()->endOfWeek()->format('Y-m-d H:i:s');
$startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
$endOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');
$startOfYear = Carbon::now()->startOfYear()->format('Y-m-d H:i:s');
$endOfYear = Carbon::now()->endOfYear()->format('Y-m-d H:i:s');

$hoursWorkedThisWeek = getHoursWorked($startOfWeek, $endOfWeek, $db);
$hoursWorkedThisMonth = getHoursWorked($startOfMonth, $endOfMonth, $db);
$hoursWorkedThisYear = getHoursWorked($startOfYear, $endOfYear, $db);







// $hoursWorkedThisWeek = Employee::getHoursWorkedThisWeek(getLoggedInEmployee()->id, $db);
// $hoursWorkedThisMonth = Employee::getHoursWorkedThisMonth(getLoggedInEmployee()->id, $db);
// $hoursWorkedThisYear = Employee::getHoursWorkedThisYear(getLoggedInEmployee()->id, $db);







?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timesheets | HR</title>
    <link rel="stylesheet" href=<?= HTMLCSS . "reset.css"; ?>>
    <link rel="stylesheet" href=<?= HTMLCSS . "navbar.css"; ?>>
    <link rel="stylesheet" href=<?= HTMLCSS . "timesheets.css"; ?>>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">

</head>
<body>

<div class="wrapper">

    <?php echo generateNavigationBar('Timesheets', '/app2/hr/dashboard', getEmployeeFirstName())?>
    <div class="container">


        <div class="action">
            <form action="" method="POST">
                <input type="submit" <?php if(Employee::hasCurrentWorkSession(getLoggedInEmployee()->id, $db)){echo "disabled='true'";} ?> value="Start working" name="startSession" class="start">
                <input type="submit" <?php if(!Employee::hasCurrentWorkSession(getLoggedInEmployee()->id, $db)){echo "disabled='true'";} ?> value="Stop working" name="stopSession" class="stop">
            </form>
            <span id="clock"></span>
        </div>
        <div class="stats">
            <h1 class="title">Sessions</h1>

            <?php if(isset($currentSession)):
                $start = Carbon::parse($currentSession['start']);
            ?>
            <div class="current">
                <h1>Current session</h1>
                <div class="stat-container">
                <div class="stat">
                        <label for="">Date:</label>
                        <span><?php echo $start->toDateString();?></span>
                    </div>
                    <div class="stat">
                        <label for="">Start time:</label>
                        <span><?php echo $start->toTimeString(); ?></span>
                    </div>
                    <div class="stat">
                        <label for="">Duration:</label>
                        <span><?php echo $start->diffInHours(Carbon::now());?> hours</span>
                    </div>
                </div>
            </div>

            <?php endif; ?>
            <?php if($lastSession !==null):

                $start = Carbon::parse($lastSession['start']);
                $end = Carbon::parse($lastSession['end']);

            ?>


            <div class="last">
            <h1 >Last session</h1>
                <div class="stat-container">
                    <div class="stat">
                        <label for="">Date:</label>
                        <span><?php echo $start->toDateString();?></span>
                    </div>
                    <div class="stat">
                        <label for="">Start time:</label>
                        <span><?php echo $start->toTimeString(); ?></span>
                    </div>
                    <div class="stat">
                        <label for="">End time:</label>
                        <span><?php echo $end->toTimeString(); ?></span>
                    </div>
                    <div class="stat">
                        <label for="">Duration:</label>
                        <span><?php echo $start->diffInHours($end);?> hours</span>
                    </div>

                </div>
            </div>
            <?php endif ?>
            <h1 class="title mar-top-2">Overview</h1>

            <?php if($lastSession !== null): ?>
            <div class="last">
            <h1>This week</h1>
                <div class="stat-container">
                        <?php
                            $startOfWeek = Carbon::now()->startOfWeek()->format('Y-m-d H:i:s');
                            $endOfWeek = Carbon::now()->endOfWeek()->format('Y-m-d H:i:s');
                            $sessionCount = getSessionsBetweenDates($startOfWeek, $endOfWeek, $db);

                        ?>

                    <div class="stat">
                        <label for="">Sessions:</label>
                        <span><?php echo $sessionCount;?></span>
                    </div>
                    <div class="stat">
                        <label for="">Hours worked:</label>
                        <span><?php echo $hoursWorkedThisWeek;?></span>
                    </div>
                </div>
            </div>
            <div class="last">
            <h1>This Month</h1>
                <div class="stat-container">
                    <?php
                        $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s');
                        $endOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s');
                        $sessionCount = getSessionsBetweenDates($startOfMonth, $endOfMonth, $db);

                    ?>

                    <div class="stat">
                        <label for="">Sessions:</label>
                        <span><?php echo $sessionCount;?></span>
                    </div>
                    <div class="stat">
                        <label for="">Hours worked:</label>
                        <span><?php echo $hoursWorkedThisMonth;?></span>
                    </div>
                </div>
            </div>
            <div class="last">
            <h1>This Year</h1>
                <div class="stat-container">
                    <?php
                        $startOfYear = Carbon::now()->startOfYear()->format('Y-m-d H:i:s');
                        $endOfYear = Carbon::now()->endOfYear()->format('Y-m-d H:i:s');
                        $sessionCount = getSessionsBetweenDates($startOfYear, $endOfYear, $db);

                    ?>

                    <div class="stat">
                        <label for="">Sessions:</label>
                        <span><?php echo $sessionCount;?></span>
                    </div>
                    <div class="stat">
                        <label for="">Hours worked:</label>
                        <span><?php echo $hoursWorkedThisYear;?></span>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <p>No sessions found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>


<script>

var clock = document.getElementById('clock');
calculateLiveClock();

function calculateLiveClock(){
    let nowDate = new Date();
    let hours = nowDate.getHours();
    let minutes = nowDate.getMinutes();
    let seconds = nowDate.getSeconds();

    if(minutes < 10){
        minutes = "0"+minutes;
    }
    if(hours < 10){
        hours = "0"+hours;
    }
    if(seconds < 10){
        seconds = "0"+seconds;
    }

    clock.innerHTML = hours+":"+minutes+":"+seconds;
}

setInterval(() => {

calculateLiveClock();

}, 1000);


</script>


</body>
</html>
