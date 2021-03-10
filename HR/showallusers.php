<?php

/**
* Info of all Employee
*
* Yannick Fauche
* datetime 28 February 2021
* Employee list
*/

session_start();
include 'connect.php';

echo '<link rel="stylesheet" href ="../css/home.css"></link>';

$sql = "SELECT * FROM employee";
$result = $db->query($sql);

echo"<div><table class='usertable'><th colspan=8>Employees</th>
      <tr id='fix'><td><b>Id</b></td><td><b>Name</b></td><td><b>Lastname</b></td><td><b>Email</b></td><td><b>Phone</b><td><b>Salary</b></td><td><b>birthDate</b></td><td><b>Manage</b></td><tr>";
while($row = $result->fetch_assoc()){

echo"<tr><td>".$row['id']."</td><a href=employee_info.php?employee_id=".$row['id']."<td>".$row['firstName']."</td></a><td>".$row['lastName']."</td><td>".$row['mailAddress']."</td><td>".$row['phoneNumber']."</td><td>".$row['salary']."</td><td>".$row['birthDate']."</td><td><a href=delete.php?delete=".$row['id']."><img class='resize' src='../images/delete.png'></a><a href=manage.php?edit=".$row['id']."> <img class='resize' src='../images/manage.png'></a></td></tr>";

}
echo"</table></div>";
echo '<center><br><a href="useradd.php"><img id="plus" src="../images/adduser.jpg"></a><br><a href="admin.php" class="buttton back"><p class="backtext">Go back</p></a></center>';
 ?>
