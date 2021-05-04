<?php
use Carbon\Carbon;
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
require '../vendor/autoload.php';
include '../includes/db_config.php';
include '../includes/authentication.php';
include '../includes/sanitize.php';
include '../components/navbar.php';
include '../includes/classes/Employee.php';




if(!isLoggedIn()){
    header("Location: ../dashboard.php");
}



if($_SERVER['REQUEST_METHOD'] == "POST"){



    if(isset($_POST['startSession'])){

        /* Working session started */
        Employee::startWorkSession(getUserId(), $db);

    }


    else if(isset($_POST['stopSession'])){

        /* Working session stopped */
        Employee::stopWorkSession(getUserId(), $db);


    }


}

// Get working hours for employees
$lastSession = Employee::getLastWorkingSession(getUserId(), $db);
if(Employee::getCurrentWorkSession(getUserId(),$db)){
    $currentSession = Employee::getWorkSessionById(Employee::getCurrentWorkSession(getUserId(),$db), $db);
}


// calculate some statistics

$hoursWorkedThisWeek = Employee::getHoursWorkedThisWeek(getUserId(), $db);
$hoursWorkedThisMonth = Employee::getHoursWorkedThisMonth(getUserId(), $db);
$hoursWorkedThisYear = Employee::getHoursWorkedThisYear(getUserId(), $db);







?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timesheets | HR</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/timesheets.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">

</head>
<body>

<div class="wrapper">

    <?php echo generateNavigationBar('Timesheets', '../dashboard.php', Employee::getEmployeeNameById(getUserId(), $db))?>
    <div class="container">
        <div class="action">
            <form action="" method="POST">
                <input type="submit" <?php if(Employee::hasCurrentWorkSession(getUserId(), $db)){echo "disabled='true'";} ?> value="Start working" name="startSession" class="start">
                <input type="submit" <?php if(!Employee::hasCurrentWorkSession(getUserId(), $db)){echo "disabled='true'";} ?> value="Stop working" name="stopSession" class="stop">
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
            <?php if($lastSession): 
                
                $start = Carbon::parse($lastSession['start']);    
                $end = Carbon::parse($lastSession['end']);    

            ?>
        
            <?php endif ?>
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
                    <div class="stat">
                        <label for="">Earned:</label>
                        <span>€<?php echo $start->diffInHours($end) * Employee::getEmployeeSalary(getUserId(), $db);?> EBIT</span>
                    </div>
                </div>
            </div>
            <h1 class="title mar-top-2">Overview</h1>
            
            <div class="last">
            <h1>This week</h1>
                <div class="stat-container">
                        <?php 
                            $startOfWeek = Carbon::now()->startOfWeek()->format('Y-m-d H:i:s'); 
                            $endOfWeek = Carbon::now()->endOfWeek()->format('Y-m-d H:i:s'); 
                            $sessionCount = Employee::getSessionCountBetweenDates(getUserId(),$db,$startOfWeek, $endOfWeek);

                        ?>

                    <div class="stat">
                        <label for="">Sessions:</label>
                        <span><?php echo $sessionCount;?></span>
                    </div>
                    <div class="stat">
                        <label for="">Hours worked:</label>
                        <span><?php echo $hoursWorkedThisWeek;?></span>
                    </div>
                    <div class="stat">
                        <label for="">Money earned:</label>
                        <span>&euro;<?php echo $hoursWorkedThisWeek * Employee::getEmployeeSalary(getUserId(), $db)?></span>
                    </div>
                </div>
            </div>
            <div class="last">
            <h1>This Month</h1>
                <div class="stat-container">
                    <?php 
                        $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s'); 
                        $endOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s'); 
                        $sessionCount = Employee::getSessionCountBetweenDates(getUserId(),$db,$startOfMonth, $endOfMonth);

                    ?>

                    <div class="stat">
                        <label for="">Sessions:</label>
                        <span><?php echo $sessionCount;?></span>
                    </div>
                    <div class="stat">
                        <label for="">Hours worked:</label>
                        <span><?php echo $hoursWorkedThisMonth;?></span>
                    </div>
                    <div class="stat">
                        <label for="">Money earned:</label>
                        <span>&euro;<?php echo $hoursWorkedThisMonth * Employee::getEmployeeSalary(getUserId(), $db)?></span>
                    </div>
                </div>
            </div>
            <div class="last">
            <h1>This Year</h1>
                <div class="stat-container">
                    <?php 
                        $startOfYear = Carbon::now()->startOfYear()->format('Y-m-d H:i:s'); 
                        $endOfYear = Carbon::now()->endOfYear()->format('Y-m-d H:i:s'); 
                        $sessionCount = Employee::getSessionCountBetweenDates(getUserId(),$db,$startOfYear, $endOfYear);

                    ?>

                    <div class="stat">
                        <label for="">Sessions:</label>
                        <span><?php echo $sessionCount;?></span>
                    </div>
                    <div class="stat">
                        <label for="">Hours worked:</label>
                        <span><?php echo $hoursWorkedThisYear;?></span>
                    </div>
                    <div class="stat">
                        <label for="">Money earned:</label>
                        <span>&euro;<?php echo $hoursWorkedThisYear * Employee::getEmployeeSalary(getUserId(), $db)?></span>
                    </div>
                </div>
            </div>
           
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