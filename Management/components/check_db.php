<?php
/**
*Check DB
*
* @author Adrian Kapys
* @datetime 2 March 2021
*/

// connect to db
$host = "localhost";
$user = "root";
$password = "";
$db = "testdb";
$link = mysqli_connect($host,$user,$password) or die ("error");
mysqli_select_db($link,$db) or die("error connecting to $db");
// check if the foreign keys have been set
$sql = "SELECT COUNT(*) AS 'check' FROM job;";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result);
$test = $row['check'];

if($test === 0){ // add foreign keys if they weren't set
    $sql = "INSERT INTO department(id,name,head,location)
    VALUES(1,test,test,test);
    INSERT INTO jobdescription(id,general,experience,degree)
    VALUES(1,test,test,test);
    INSERT INTO job(id,name,department,available,description)
    VALUES(1,test,1,test,1);";
    mysqli_query($link,$sql);
}

?>
