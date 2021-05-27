<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php");
    require_once(PHPSCRIPTDIR . "error.php");

error_reporting(E_ERROR | E_PARSE);

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
    global $row;
    $job_id = $_GET["Jobid"];

    $sql = "SELECT degree, experience, general, jobs.name
    FROM job_descriptions
    INNER JOIN jobs  On jobs.description = job_description.id 
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

function printname() {
    global $db;
    global $name;
    $job_id = $_GET["Jobid"];

    $sql = "SELECT degree, experience, general, jobs.name
    FROM job_descriptions
    INNER JOIN jobs  On jobs.description = job_descriptions.id 
    WHERE jobs.id = '$job_id'";


    $result = $db->query($sql);

    foreach($result as $name)
    {
        echo $name["name"];
           
    }
}

function printdegree() {
    global $db;
    global $degree;
    $job_id = $_GET["Jobid"];

    $sql = "SELECT degree, experience, general, jobs.name
    FROM job_descriptions
    INNER JOIN jobs  On jobs.description = job_descriptions.id 
    WHERE jobs.id = '$job_id'";


    $result = $db->query($sql);

    foreach($result as $degree)
    {
        echo $degree["degree"];
           
    }
}
function printexperience() {
    global $db;
    global $experience;
    $job_id = $_GET["Jobid"];

    $sql = "SELECT degree, experience, general, jobs.name
    FROM job_descriptions
    INNER JOIN jobs  On jobs.description = job_descriptions.id 
    WHERE jobs.id = '$job_id'";


    $result = $db->query($sql);

    foreach($result as $experience)
    {
        echo $experience["experience"];
           
    }
}
function printgeneral() {
    global $db;
    global $general;
    $job_id = $_GET["Jobid"];

    $sql = "SELECT degree, experience, general, jobs.name
    FROM job_descriptions
    INNER JOIN jobs  On jobs.description = job_descriptions.id 
    WHERE jobs.id = '$job_id'";


    $result = $db->query($sql);

    foreach($result as $general)
    {
        echo $general["general"];
           
    }
}
function printhours() {
    global $db;
    global $hours;
    $job_id = $_GET["Jobid"];

    $sql = "SELECT degree, experience, general, jobs.name, jobs.hours
    FROM job_descriptions
    INNER JOIN jobs  On jobs.description = job_descriptions.id 
    WHERE jobs.id = '$job_id'";


    $result = $db->query($sql);

    foreach($result as $hours)
    {
        echo $hours["hours"];
           
    }
}
function printprice() {
    global $db;
    global $price;
    $job_id = $_GET["Jobid"];

    $sql = "SELECT degree, experience, general, jobs.name, jobs.pricePerHour
    FROM job_descriptions
    INNER JOIN jobs  On jobs.description = job_descriptions.id 
    WHERE jobs.id = '$job_id'";


    $result = $db->query($sql);

    foreach($result as $price)
    {
        echo $price["pricePerHour"];
           
    }
}
function printbenefit() {
    global $db;
    global $benefit;
    $job_id = $_GET["Jobid"];

    $sql = "SELECT benefits.description
    FROM benefits
    INNER JOIN jobs  On jobs.id = benefits.id 
    WHERE jobs.id = '$job_id'";


    $result = $db->query($sql);

    foreach($result as $benefit)
    {
        echo $benefit["description"];
           
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=<?= HTMLCSS . "vacature.css"; ?>>
    <link rel="stylesheet" href=<?= HTMLCSS . "reset.css"; ?>>
    <link rel="stylesheet" href=<?= HTMLCSS . "navbar.css"; ?>>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.7.0/build/reset-fonts-grids/reset-fonts-grids.css" media="all" /> 
    <link rel="stylesheet" href=<?= HTMLCSS . "resume.css"; ?>>

    <title>Vacature</title>
</head>
<body>

<?php echo generateNavigationBar("Vacature", "/app2/hr/vacature", getEmployeeFirstName()) ?>

<div id="page-content-wrapper" class="col-lg-11">
	<div class="container-fluid">
		<div class="col-lg-12 nopadding">
        <div id="doc2" class="yui-t7">
	<div id="inner">
	
		<div id="hd">
			<div class="yui-gc">
					<h1><?php printname(); ?></h1>
			</div>
		</div>

		<div id="bd">
			<div id="yui-main">
				<div class="yui-b">

					<div class="yui-gf">
						<div class="yui-u first">
							<h2>Degree</h2>
						</div>
						<div class="yui-u">
							<p class="enlarge">
                            <?php printdegree(); ?>
							</p>
						</div>
					</div>
					<div class="yui-gf">
						<div class="yui-u first">
							<h2>Experience</h2>
						</div>
						<div class="yui-u">

                        <p class="enlarge">
                            <?php printexperience(); ?>
							</p>
						</div>
					</div>
                    <div class="yui-gf">
						<div class="yui-u first">
							<h2>Benefits</h2>
						</div>
						<div class="yui-u">

                        <p class="enlarge">
                            <?php printbenefit(); ?>
							</p>
						</div>
					</div>
                    <div class="yui-gf">
						<div class="yui-u first">
							<h2>hours</h2>
						</div>
						<div class="yui-u">

                        <p class="enlarge">
                            <?php printhours(); ?>
							</p>
						</div>
					</div>
                    <div class="yui-gf">
						<div class="yui-u first">
							<h2>Pay/Hour</h2>
						</div>
						<div class="yui-u">

                        <p class="enlarge">
                            <?php printprice(); ?>
							</p>
						</div>
					</div>
					<div class="yui-gf">
						<div class="yui-u first">
							<h2>Description</h2>
						</div>
						<div class="yui-u">
                        <p class="enlarge">
                            <?php printgeneral(); ?>
							</p>
						</div>
					</div>

					
				</div>
			</div>
		</div>

	</div>


</div>
		</div>
	</div> 
</div>
</body>
</html>