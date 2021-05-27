  
<?php 

$user = "root";
$pass = "";
// try and create a PHP database object
try {
    $db = new PDO('mysql:host=localhost;dbname=testdb', $user, $pass);
    echo "Connected successfully";
} 
  
// handle exception
catch (PDOException $e) {
    echo "Oops something when wrong trying to connect to the database: ".$e->getMessage();
    die();
}


      $sql = "INSERT INTO `department`(`id`, `name`, `head`, `location`) VALUES (2,'Managemant',0,'Belgium')";
      $sql1 = "INSERT INTO `jobdescription`(`id`, `degree`, `experience`, `general`) VALUES (2,'Managemant','5 years of Managemant experience','Are you looking for a job As A web Developer well look no more this is it the job for you all you need is about 2 years of work experience and the job is yours we are looking for someone who is experienced in PHP, Javascrips and Mysql.')";
      $sql2 = "INSERT INTO `job`(`id`, `name`, `department`, `available`, `description`) VALUES (2,'Manager',2,1,2)";
      $sql3 = "INSERT INTO `joboffers`(`id`, `job`, `creationDate`, `description`) VALUES (2,2,2021-03-30,2)";
      $sql4 = "INSERT INTO `department`(`id`, `name`, `head`, `location`) VALUES (3,'Cleaning Service',0,'Belgium')";
      $sql5 = "INSERT INTO `jobdescription`(`id`, `degree`, `experience`, `general`) VALUES (3,'None','None','Are you looking for a cleaning...')";
      $sql6 = "INSERT INTO `job`(`id`, `name`, `department`, `available`, `description`) VALUES (3,'cleaning service',3,1,3)";
      $sql7 = "INSERT INTO `joboffers`(`id`, `job`, `creationDate`, `description`) VALUES (3,3,2021-03-30,3)";
      
      
      $db->query($sql);
      $db->query($sql1);
      $db->query($sql2);
      $db->query($sql3);
      $db->query($sql4);
      $db->query($sql5);
      $db->query($sql6);
      $db->query($sql7);

      

     

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <title>Add Vacature</title>
</head>
<body>
</body>
</html>
