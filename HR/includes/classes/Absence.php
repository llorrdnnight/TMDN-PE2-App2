<?php

class Absence{


public static function verifyAbsence($id, $db){


$sql = "UPDATE absences SET state = 1 WHERE id = :id";

$stmt = $db->prepare($sql);
$stmt->bindParam(":id", $id);

if($stmt->execute()){

    return true;
}

else{
    return false;
}



}

public static function createAbsence($startDate, $endDate, $reason, $db, $state = 0){

    $startDate = DateTime::createFromFormat("Y-m-d", $startDate);
    $endDate = DateTime::createFromFormat("Y-m-d", $endDate);
    $startDate = $startDate->format("Y-m-d");
    $endDate = $endDate->format("Y-m-d");

    $uid = getUserId();

    $sql = "INSERT INTO absences(employee,startDate,endDate,reason,state) VALUES(:employee,:startDate, :endDate, :reason, :state)";
    $stmt = $db->prepare($sql);
    
    $stmt->bindParam(":employee", $uid);
    $stmt->bindParam(":startDate", $startDate);
    $stmt->bindParam(":endDate", $endDate);
    $stmt->bindParam(":reason", $reason);
    $stmt->bindParam(":state", $state);


    if($stmt->execute()){
        return true;
    }
    else{
        return false;
    }

}


public static function getAllAbsences($db, $start = null, $offset = null, $state = null){


    if(is_null($start) && is_null($offset)){

        $sql = "SELECT * FROM absences ORDER BY startDate desc, state asc";

        if(!is_null($state)){
            $sql = "SELECT * FROM absences WHERE state = $state ORDER BY startDate desc, state asc";
        }

      
    }

    else{

        $sql = "SELECT * FROM absences ORDER BY startDate desc, state asc LIMIT $start, $offset";

        if(!is_null($state)){
            $sql = "SELECT * FROM absences WHERE state = '$state' ORDER BY startDate desc, state asc LIMIT $start, $offset";
        }
        
    }


    $result = $db->query($sql);
    return $result->fetchAll();

  
    

}

public static function getAbsencesByDate($start = null, $offset = null,$date,$state,$db){


    if(!is_null($start) && !is_null($offset)){

        $sql = "SELECT * FROM absences WHERE startDate <= :date AND endDate > :date order by state asc LIMIT $start, $offset ";

        if(!is_null($state)){

            $sql = "SELECT * FROM absences WHERE startDate <= :date AND endDate > :date AND state = :state order by state asc LIMIT $start, $offset ";

    }
    }


    else{

        $sql = "SELECT * FROM absences WHERE startDate <= :date AND endDate > :date order by state asc ";

        if(!is_null($state)){

            $sql = "SELECT * FROM absences WHERE startDate <= :date AND endDate > :date AND state = :state order by state asc ";

    }

    }

    

    $stmt = $db->prepare($sql);
    $stmt->bindParam(":date", $date);
    $stmt->bindParam(":state", $state);


    if($stmt->execute()){
        return $stmt->fetchAll();
    }
    else{
        return false;
    }
}


public static function getAbsencesByEmployee($start = null, $offset = null,$employee,$db){

    $sql = "";
    if(is_null($start) && is_null($offset)){

        $sql = "SELECT * FROM absences WHERE employee = :employee order by state";

    }

    else{

        $sql = "SELECT * FROM absences WHERE employee = :employee order by state LIMIT $start, $offset";

    }

    $stmt = $db->prepare($sql);
    $stmt->bindParam(":employee", $employee);

    if($stmt->execute()){
        return $stmt->fetchAll();
    }
    else{
        return false;
    }
}


public static function getAbsencesBySearch($start = null, $offset = null,$q, $db){


    $sql = "";

    if(is_null($start) && is_null($offset)){

        $sql = "SELECT * FROM absences WHERE employee IN(SELECT id FROM employee WHERE CONCAT(firstName, ' ', lastName) LIKE :q)";

    }

    else{

        $sql = "SELECT * FROM absences WHERE employee IN(SELECT id FROM employee WHERE CONCAT(firstName, ' ', lastName) LIKE :q) LIMIT $start, $offset";
    }

    $stmt = $db->prepare($sql);
    $q = $q.'%';
    $stmt->bindParam(":q", $q);

    if($stmt->execute()){
        return $stmt->fetchAll();
    }
    else{
        return false;
    }  
}

}

?>