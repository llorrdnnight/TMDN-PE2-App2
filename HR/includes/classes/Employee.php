<?php

use Carbon\Carbon;


class Employee{


public static function getEmployeeNameById($id, $db){

    $stmt = $db->prepare("SELECT * FROM employee WHERE id = :id");
    $stmt->bindParam(":id", $id);

    if($stmt->execute()){
        $rows = $stmt->fetchAll();
        return "".$rows[0]['firstName']." ".$rows[0]['lastName'];
    }
    else{
        return false;
    }

}

public static function getEmployeeSalary($employee, $db){

    $sql = "SELECT hourlyRate FROM employee WHERE id = $employee";
    $result = $db->query($sql);


    if($result->rowCount() > 0){
        return $result->fetch(0,1)['hourlyRate'];
    }

    else{
        return false;
    }

}

public static function getEmployeesByName($name, $db){

    $stmt = $db->prepare("SELECT * FROM employee WHERE firstName = :name");
    $stmt->bindParam(":name", $name);
    
    if($stmt->execute()){
        return $stmt->fetchAll();
        
    }
    else{
        return false;
    }
    
}


public static function getEmployeeById($id, $db){

    $stmt = $db->prepare("SELECT * FROM employee WHERE id = :id");
    $stmt->bindParam(":id", $id);

    if($stmt->execute()){
        return $stmt->fetch(0,1);
    }
    else{
        return false;
    }

}


public static function startWorkSession($employee_id, $db){

    if(self::hasCurrentWorkSession($employee_id,$db)){
        return 'cannot start new session, because other session in progress';
    }
    $now = date_create()->format('Y-m-d H:i:s');

    $stmt = $db->prepare("INSERT INTO workinghours(employee,start) VALUES(:employee, :start)");
    $stmt->bindParam(":employee", $employee_id);
    $stmt->bindParam(":start", $now);

    
    if($stmt->execute()){
        return true;
        
    }
    else{
        return false;
    }


}

public static function getWorkSessionById($id,$db){

$sql = "SELECT * FROM workinghours WHERE id = $id";
$result = $db->query($sql);

if($result->rowCount() > 0){
    return $result->fetch(0,1);
}

else{
    return false;
}
}

public static function getCurrentWorkSession($employee,$db){

$sql = "SELECT id FROM workinghours WHERE employee = $employee AND end IS NULL LIMIT 0,1";
$result = $db->query($sql);

if($result->rowCount() > 0){
    return $result->fetch(0,1)['id'];
}

else{
    return false;
}



}


public static function hasCurrentWorkSession($employee, $db){

    $sql = "SELECT id FROM workinghours WHERE employee = $employee AND end IS NULL LIMIT 0,1";
    $result = $db->query($sql);

    if($result->rowCount() > 0){
        return true;
    }

    else{
        return false;
    }

}



public static function stopWorkSession($employee_id, $db){

    $currentSession = self::getCurrentWorkSession($employee_id, $db);
    if(!$currentSession){
        return 'no current session found';
    }
    $now = date_create()->format('Y-m-d H:i:s');

    $stmt = $db->prepare("UPDATE workinghours SET end = :end WHERE id = $currentSession");
    $stmt->bindParam(":end", $now);

    
    if($stmt->execute()){
        return true;
        
    }
    else{
        return false;
    }


}

public static function getLastWorkingSession($employee, $db){

    $sql = "SELECT * FROM workinghours WHERE end IS NOT NULL AND employee = $employee AND id = (SELECT MAX(id) FROM workinghours WHERE employee = $employee AND end IS NOT NULL)";
    $result = $db->query($sql);


    if($result->rowCount() > 0){
        return $result->fetch(0,1);
    }

    else{
        return false;
    }

}


public static function getHoursWorkedThisWeek($employee, $db){

    $startOfWeek = Carbon::now()->startOfWeek()->format('Y-m-d H:i:s'); 
    $endOfWeek = Carbon::now()->endOfWeek()->format('Y-m-d H:i:s'); 

    $sql = "SELECT * FROM workinghours WHERE start BETWEEN '$startOfWeek' AND '$endOfWeek' ";
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
    
    else{
        return false;
    }
    
}


public static function getHoursWorkedThisMonth($employee, $db){

    $startOfWeek = Carbon::now()->startOfMonth()->format('Y-m-d H:i:s'); 
    $endOfWeek = Carbon::now()->endOfMonth()->format('Y-m-d H:i:s'); 

    $sql = "SELECT * FROM workinghours WHERE start BETWEEN '$startOfWeek' AND '$endOfWeek' ";
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
    
    else{
        return false;
    }
    
}

public static function getHoursWorkedThisYear($employee, $db){

    $startOfWeek = Carbon::now()->startOfYear()->format('Y-m-d H:i:s'); 
    $endOfWeek = Carbon::now()->endOfYear()->format('Y-m-d H:i:s'); 

    $sql = "SELECT * FROM workinghours WHERE start BETWEEN '$startOfWeek' AND '$endOfWeek' ";
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
    
    else{
        return false;
    }
    
}

public static function getSessionCountBetweenDates($employee, $db, $start, $end){

    $sql = "SELECT count(id) as count FROM workinghours WHERE start BETWEEN '$start' AND '$end'";
    $result = $db->query($sql);

    if($result->rowCount() > 0){
    
        return $result->fetch(0,1)['count'];
        
    }


}

}













?>