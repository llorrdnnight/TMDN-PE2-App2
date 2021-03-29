<?php 
session_start();
include '../includes/db_config.php';
include '../includes/classes/Absence.php';
include '../includes/classes/Employee.php';
error_reporting(E_ERROR | E_PARSE);
// loadMore variables
$start = 0;
$offset = 10;
// GET vars
$sortDate = null;
$state = null;
$update = null;
$sortDate = $_GET['date'];



// hard coded for sick at this moment
$type = "Sick";


/* POST METHOD for verifying an absence */

if($_SERVER['REQUEST_METHOD'] == "POST"){


    $absence = $_POST['id'];
    if(Absence::verifyAbsence($absence, $db)){

        $updateSuccess = true;
    }

    else{

        $updateFail = true;
    }

}

// function to get amount of days between to dates
function getDaysBetweenDates($startDate, $endDate){

    $startDate = DateTime::createFromFormat("Y-m-d", $startDate);
    $endDate = DateTime::createFromFormat("Y-m-d", $endDate);

    return $endDate->diff($startDate)->format("%a");
}


// check if state get isset

if(isset($_GET['state'])){

    $state = $_GET['state'];

    switch($state){
        case 'verified': $state = 1;
            break;
        case 'pending': $state = 0;
            break;
    }
}

// check if there is an employee queried

if(isset($_GET['employee'])){
    $employee = $_GET['employee'];
    $employeeName = Employee::getEmployeeNameById($employee, $db);
    $absences = Absence::getAbsencesByEmployee($employee,$db);
    // calculate some details about the employee
    $employeeDetails = Employee::getEmployeeById($employee,$db);
    // how many days absent this year
    $holidaysTaken = 0;
    $sicknessDays = 0;
    foreach($absences as $absence){

       
            $sicknessDays += getDaysBetweenDates($absence['startDate'], $absence['endDate']);


        
    }
}

// check if there is a search query
else if(isset($_GET['q'])){
    $search = $_GET['q'];
    $absences = Absence::getAbsencesBySearch($search, $db);
}
// check if there is a date query
else{

if ($sortDate == "today"){
    $today = new DateTime();
    $dateObj = $today;
    $today = $today->format("Y-m-d");
    $absences = Absence::getAbsencesByDate($start,$offset,$today, $state, $db);
    $numberOfRecords = count(Absence::getAbsencesByDate(null,null,$today,$state,$db));

}

else if ($sortDate == "yesterday"){
    $yesterday = new DateTime();
    $yesterday = $yesterday->modify("-1 day");
    $dateObj = $yesterday;
    $yesterday = $yesterday->format("Y-m-d");
    $absences = Absence::getAbsencesByDate($start, $offset,$yesterday, $state, $db);
    $numberOfRecords = count(Absence::getAbsencesByDate(null,null,$yesterday,$state,$db));

}
else if ($sortDate == "tomorrow"){
    $tomorrow = new DateTime();
    $tomorrow->modify("+1 day");
    $dateObj = $tomorrow;
    $tomorrow = $tomorrow->format("Y-m-d");
    $absences = Absence::getAbsencesByDate($start, $offset,$tomorrow, $state, $db);
    $numberOfRecords = count(Absence::getAbsencesByDate(null,null,$tomorrow,$state,$db));

}

else{
    $numberOfRecords = count(Absence::getAllAbsences($db,null,null,$state));
    $absences = Absence::getAllAbsences($db, $start, $offset, $state);
}

}




?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/absences.css">
    <link rel="stylesheet" href="../css/state-messages.css">
    <title>Dashboard - Absences</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script defer src="../js/notification.js"></script>
    <script defer src="../js/absences.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
</head>
<body>



    <div class="wrapper">



        <!-- Error messages -->
        <?php if($updateSuccess): ?>
        <div class="success-message">
            <p>Absence has been verified.</p>
        </div>
        <?php endif; ?>

        <?php if($updateFail): ?>
        <div class="error-message">
            <p>Something went wrong with the verification</p>
        </div>
        <?php endif; ?>


        <div class="nav-bar">
            <div class="left">
                <a href="../dashboard.php"><i class="fas fa-arrow-left"></i></a>
                <?php if($dateObj !== null): ?>
                    <h1 class="title">Sickness - <?php echo $dateObj->format("d").'th of '.$dateObj->format("F").' '.$dateObj->format("Y")?></h1>
                <?php else: ?>
                    <h1 class="title">Sickness</h1>
                <?php endif; ?>            </div>
            <div class="right">
            <i class="fa fa-user-circle"></i>
            <span>John Doe</span>
            </div>
            
        </div>


        <div class="content">

            <div class="inner-content">
            <?php if (isset($employee)): ?>
                    <div class="employee-info">
                        <div class="row">
                                <span>Employee:</span><strong><?php echo $employeeName; ?></strong>
                            </div>
                        <div class="row">
                            <span>Days sick this year:</span><strong><?php echo $sicknessDays; ?></strong>
                        </div>
                        <div class="row">
                            <span>Go to profile <i class="fa fa-user-circle"></i> </span></strong>
                        </div>
                    </div>
                    <?php endif; ?>
                <div class="nav">


                    <div class="left">

                        <div class="filter-box">
                            <div class="row">
                                <a href="./overview.php?&<?php
                                if(isset($_GET['type'])){echo "type=$type";}
                                ?>" class="<?php if(!isset($_GET['date'])){echo "active-toggle";}?>">All</a>
                                <a href="./overview.php?date=yesterday&<?php
                                if(isset($_GET['type'])){echo "type=$type";}
                                ?>" class="<?php if($_GET['date'] == "yesterday"){echo "active";} ?>">Yesterday</a>
                                <a href="./overview.php?date=today&<?php
                                if(isset($_GET['type'])){echo "type=$type";}
                                ?>" class="<?php if($_GET['date'] == "today"){echo "active";} ?>">Today</a>
                                <a href="./overview.php?date=tomorrow&<?php
                                if(isset($_GET['type'])){echo "type=$type";}
                                ?>" class="<?php if($_GET['date'] == "tomorrow"){echo "active";} ?>">Tomorrow</a>
                            </div>
                        </div>


                    </div>

                   

                  
                    <div class="right">
                
                    
                    <div class="searchField">
                        <form action="" method="GET">
                        <input autocomplete="off" type="search" name="q" id="" placeholder="Search employee...">
                        <button type="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </div>

                        <div class="row">
                            <a href="./overview.php?&<?php
                            if(isset($_GET['date'])){echo "date=$sortDate";}
                            ?>" class="<?php if(!isset($_GET['state'])){echo "active-toggle";} ?>">All</a>    
                            <a href="./overview.php?state=verified&<?php
                            if(isset($_GET['date'])){echo "date=$sortDate";}
                            ?>" class="<?php if($_GET['state'] == "verified"){echo "active-toggle";} ?>">Verified</a>
                            <a href="./overview.php?state=pending&<?php
                            if(isset($_GET['date'])){echo "date=$sortDate";}
                            ?>" class="<?php if($_GET['state'] == "pending"){echo "active-toggle";} ?>">Pending</a>

                        </div>

                        
                   
                    </div>
                </div>

                <table>
                        <tr>
                            <td>Employee</th>
                            <td>Start Date</th>
                            <td>End Date</th>
                            <td>Days</th>
                            <td>Verified</td>

                        </tr>

                  
                    <?php foreach($absences as $absence): ?>
                    <tr>
                        <td><a href="overview.php?employee=<?php echo $absence['employee']; ?>"><i class="fa fa-user"> </i><?php echo Employee::getEmployeeNameById($absence['employee'], $db);?></a></td>
                        <td><?php echo $absence['startDate'] ?></td>
                        <td><?php echo $absence['endDate'] ?></td>
                        <td><?php echo getDaysBetweenDates($absence['startDate'],$absence['endDate']); ?></td>
                        <td class="icons">
                        <?php if($absence['state'] == 1): ?>
                        <i class="fa fa-check"></i>
                        <?php else: ?>
                        <form action="overview.php?<?php if(isset($_GET['date'])){echo "date=$sortDate"."&";} if(isset($_GET['state'])){
                            
                            if($_GET['state'] == 0){
                                echo "state=pending&";
                            }
                            else if($_GET['state'] == 1) {
                                echo "state=verified&";
                            }
                        
                        } 

                             if(isset($_GET['employee'])){echo "employee=$employee";}

                            
                            ?>" method="POST">
                            <button type="submit">Verify</button>
                            <input type="hidden" name="id" value="<?php echo $absence['id'] ?>">
                        </form>
                        <?php endif; ?>
                        </td>
                    </tr>
                    
                    <?php endforeach; ?>
                    
                </table>

                <?php if(count($absences) == 0): ?>
                        <p class="emptyTable">There are no absences found for this particular query. 
                <?php endif; ?>

                <?php if($offset < $numberOfRecords): ?>
                <button id="loadMore">Load more</button>
                <?php endif; ?>

                <input type="hidden" id="startValue" value="<?php echo $offset; ?>">

                <input type="hidden" id="numberOfRecords" value="<?php echo $numberOfRecords; ?>">


                <input type="hidden" id="state" value="<?php echo $_GET['state']; ?>">
                <input type="hidden" id="date" value="<?php echo $_GET['date']; ?>">

                <input type="hidden" id="employee" value="<?php echo $_GET['employee']; ?>">



            </div>
        </div>
       
    </div>



</body>
</html>