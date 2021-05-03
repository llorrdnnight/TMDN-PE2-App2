<?php

include "vacatureList.php";

include './includes/db_config.php';
include './includes/sanitize.php';
include './includes/authentication.php';
include './includes/classes/Employee.php';


session_start();

if(!isLoggedIn()){
    header("Location: ./dashboard.php");
}
$error = null;


function printRows() {
    global $db;
    global $row;
    $job_id = $_GET["Jobid"];

    $sql = "SELECT degree, experience, general, job.name
    FROM jobdescription
    INNER JOIN job  On job.description = jobdescription.id 
    WHERE job.id = '$job_id'";


    $result = $db->query($sql);

    foreach($result as $row)
    {
        echo '<tr>
            <td>'.$row["name"].'</td>
            <td>'.$row["degree"].'</td>
            <td>'.$row["experience"].'</td>
            <td>'.$row["general"].'</td>
        </tr>';
}


}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/vacature.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">

    <title>Vacature</title>
</head>
<body>
<div class="nav-bar">
            <div class="left">
                <a href="vacature.php"><i class="fas fa-arrow-left"></i></a>
                <h1>Vacature Info</h1>
            </div>
            <div class="right">
            <i class="fa fa-user-circle"></i>
            <span><?php echo Employee::getEmployeeNameById(getUserId(), $db); ?></span>
            </div>
        </div>
<div id="page-content-wrapper" class="col-lg-11">
	<div class="container-fluid">
		<div class="col-lg-12 nopadding">
			<table class="content-table">
				<thead>
					<tr>
						<th>Job Title</th>
						<th>degree</th>
						<th>Experience</th>
						<th>general</th>
                    </tr>
				</thead>
				<tbody>
					<?php printRows();?>
				</tbody>
			</table>
		</div>
	</div> 
</div>
</body>
</html>