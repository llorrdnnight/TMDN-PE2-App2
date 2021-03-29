<?php

include '../db_config.php';
include '../classes/Absence.php';
include '../classes/Employee.php';
error_reporting(E_ERROR | E_PARSE);


function getDaysBetweenDates($startDate, $endDate){

    $startDate = DateTime::createFromFormat("Y-m-d", $startDate);
    $endDate = DateTime::createFromFormat("Y-m-d", $endDate);
    
    return $endDate->diff($startDate)->format("%a");

}

if($_SERVER['REQUEST_METHOD'] == "GET"){

    $start = $_GET['start'];
    $sortDate = $_GET['date'];
    $offset = 10;
    $state = null;


    if(!empty($_GET['state'])){
        $state = $_GET['state'];

        switch($state){
            case 'verified': $state = 1;
                break;
            case 'pending': $state = 0;
                break;
        }
    }

    if(!empty($sortDate)){

        if ($sortDate == "today"){
            $today = new DateTime();
            $dateObj = $today;
            $date = $today->format("Y-m-d");
        }
        
        else if ($sortDate == "yesterday"){
            $yesterday = new DateTime();
            $yesterday = $yesterday->modify("-1 day");
            $dateObj = $yesterday;
            $date = $yesterday->format("Y-m-d");
        }
        else if ($sortDate == "tomorrow"){
            $tomorrow = new DateTime();
            $tomorrow->modify("+1 day");
            $dateObj = $tomorrow;
            $date = $tomorrow->format("Y-m-d");
        }

        $absences = Absence::getAbsencesByDate($start,$offset,$date, $state, $db);

    }

    else{

        $absences = Absence::getAllAbsences($db,$start,$offset,$state);


    }


    foreach($absences as &$absence){

        $days = getDaysBetweenDates($absence['startDate'], $absence['endDate']);
        $name = Employee::getEmployeeNameById($absence['employee'], $db);

        $absence['days'] = $days;
        $absence['name'] = $name;

    }

    echo json_encode($absences);


}



?>