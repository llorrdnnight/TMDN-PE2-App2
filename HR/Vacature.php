<?php

include "vacatureList.php";

include './includes/db_config.php';
include './includes/sanitize.php';
include './includes/authentication.php';
include './includes/classes/Employee.php';

session_start();

if(isLoggedIn()){

    // redirect to main page
}

$error = null;

function printRows() {
    global $db;

    $sql = "SELECT job.id, job.name, job.available ,department.name as dpname, department.location
    FROM job 
    INNER JOIN department  On job.department = department.id";
    $result = $db->query($sql);

    foreach($result as $row)
    {
        echo '<tr>
                <td>'.$row["name"].'</td>
                <td>'.$row["dpname"].'</td>
                <td>'.$row["location"].'</td>
                <td>'.$row["available"].'</td>
                <td><a href="vacatureinfo.php?Jobid='.$row["id"].'">Read More...</a></td>
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
    <link rel="stylesheet" href="./css/vacature.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">

    <title>Vacature</title>
</head>
<body>
<div class="nav-bar">
            <div class="left">
                <a href="dashboard.php"><i class="fas fa-arrow-left"></i></a>
                <h1>Vacature</h1>
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
						<th>Department</th>
						<th>Location</th>
						<th>available</th>
                        <th>Info</th>
                    </tr>
				</thead>
				<tbody>
					<?php printRows(); ?>
				</tbody>
			</table>
		</div>
	</div> <!-- End of container -->
</div>
<a href="addVacature.php" class="float">
<i class="fa fa-plus my-float"></i>
</a>
</body>
</html>