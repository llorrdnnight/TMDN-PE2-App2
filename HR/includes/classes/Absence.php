<?php

class Absence{

public static function createAbsence($startDate, $endDate, $reason, $db){

    $startDate = DateTime::createFromFormat("Y-m-d", $startDate);
    $endDate = DateTime::createFromFormat("Y-m-d", $endDate);
    $startDate = $startDate->format("Y-m-d");
    $endDate = $endDate->format("Y-m-d");

    $uid = getUserId();

    $sql = "INSERT INTO absences(employee,startDate,endDate,reason) VALUES(:employee,:startDate, :endDate, :reason)";
    $stmt = $db->prepare($sql);
    
    $stmt->bindParam(":employee", $uid);
    $stmt->bindParam(":startDate", $startDate);
    $stmt->bindParam(":endDate", $endDate);
    $stmt->bindParam(":reason", $reason);

    if($stmt->execute()){
        return true;
    }
    else{
        return false;
    }

}

}

?>