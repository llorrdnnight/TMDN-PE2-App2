<?php
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
?>
