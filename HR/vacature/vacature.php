<?php
 error_reporting(E_ERROR | E_PARSE);
    require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php");
    require_once(PHPSCRIPTDIR . "error.php");

 require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php");
 include(INCLUDESDIR . "db_config.php"); 
 require_once(PHPSCRIPTDIR . "sanitize.php");
 require_once(PHPSCRIPTDIR . "authentication.php");
 include(COMPONENTSDIR. "navbar.php");

 if (!isset($_SESSION)) { session_start(); };

if(isHR() == false && isManagement() == false){
    header("Location: /portal");
}

$error = null;



function printRows() {
    
    global $db;
    $sql = "SELECT jobs.id, jobs.name, jobs.available ,departments.name as dpname, departments.location
    FROM jobs 
    INNER JOIN departments  On jobs.id = departments.id";
    $result = $db->query($sql);

    foreach($result as $row)
    {
        echo '<tr>
                <td>'.$row["name"].'</td>
                <td>'.$row["dpname"].'</td>
                <td>'.$row["location"].'</td>
                <td>'.($row["available"]? "&#10003" : "X").'</td>
                <td><a href="vacatureinfo?Jobid='.$row["id"].'">Learn More...</a></td>
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
    <link rel="stylesheet" href=<?= HTMLCSS . "reset.css"; ?>>
    <link rel="stylesheet" href=<?= HTMLCSS . "vacature.css"; ?>>
    <link rel="stylesheet" href=<?= HTMLCSS . "navbar.css"; ?>>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
    <title>Vacature</title>
</head>
<body>
<?php echo generateNavigationBar("Vacature", "/app2/hr/dashboard", getEmployeeFirstName()) ?>
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
<a href=<?= HTMLHR . "vacature/addVacature.php"; ?> class="float">
<i class="fa fa-plus my-float"></i>
</a>
</body>
</html>
