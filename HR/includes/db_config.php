<?php
$user = "root";
$pass = "";
// try and create a PHP database object
try {
    $db = new PDO('mysql:host=localhost;dbname=testdb', $user, $pass);
} 
  
// handle exception
catch (PDOException $e) {
    echo "Oops something when wrong trying to connect to the database: ".$e->getMessage();
    die();
}
?>
