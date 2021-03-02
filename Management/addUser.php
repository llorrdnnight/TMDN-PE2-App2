<?php
/**
*Page to add a new user.
*
* @author Adrian Kapys
* @datetime 2 March 2021
*/

include "components/check_db.php"; // check if the foreig keys have been set
// add a new user
$password = password_hash("password",PASSWORD_DEFAULT);
$sql = "SELECT COUNT(*) AS 'id' FROM employee;";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result);
$id = $row['id'] + 1;
$sql = "INSERT INTO employee(id,firstName,lastName,mailAddress,password,birthDate,phoneNumber,salary,job,isAdmin) VALUES($id,\"Jeff\",\"Bruh\",\"test1@gmail.com\",\"$password\",\"2000-03-21\",0488421323,69420,1,\"yes\");";
mysqli_query($link,$sql);
mysqli_close($link);
?>
