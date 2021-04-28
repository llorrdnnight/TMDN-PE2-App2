<?php

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




}



?>