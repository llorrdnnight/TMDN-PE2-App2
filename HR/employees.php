<?php
error_reporting(E_ERROR | E_PARSE);
if (!isset($_SESSION)) { session_start(); };
require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php");

include(INCLUDESDIR . "db_config.php");
include(INCLUDESDIR . "authentication.php");
include(COMPONENTSDIR. "navbar.php");
include(PHPCLASSDIR . "Employee.php");

if(isHR() == false && isManagement() == false){
    header("Location: /portal");
}

$employeeNotFound = false;
$result = file_get_contents("http://10.128.30.7:8080/api/AD/employees");
$employees = json_decode($result);
$filteredEmployees = array();

if($_SERVER['REQUEST_METHOD'] == "GET"){

    if(isset($_GET['search'])){
        // search employee
        foreach($employees as $employee){
            if(str_contains($employee->employeeFirstName, $_GET['search'])){
                array_push($filteredEmployees, $employee);
            }
        }

        if(count($filteredEmployees) == 0){
            $employeeNotFound = true;
        }
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees | HR</title>
    <link rel="stylesheet" href=<?= HTMLCSS . "reset.css"; ?>>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css">
    <link rel="stylesheet" href=<?= HTMLCSS . "navbar.css"; ?>>
    <link rel="stylesheet" href=<?= HTMLCSS . "search.css"; ?>>
    <script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous">
    </script>

</head>
<body>

    <div class="wrapper">
    <a href="/app2/hr/employee/add"><i class="fa fa-plus" id="add"></i></a>
    <?php echo generateNavigationBar("Search Employee", "/app2/hr/dashboard", getEmployeeFirstName()) ?>
        <div class="content">
            <div class="search">
                <form action="" method="get">
                    <div>
                        <i class="fa fa-search"></i>
                        <input placeholder="Search employee..." type="search"  name="search" id="search">
                    </div>
                </form>
            </div>
            <div class="profiles">



                <?php


                if($employeeNotFound):?>

                <p>No employees found for: "<?php echo $_GET['search'] ?>"</p>
                <?php else: ?>

                <?php if(count($filteredEmployees) !== 0){
                    $employees = $filteredEmployees;
                }
                foreach($employees as $employee): ?>
                <a href="/app2/hr/profile?id=<?php echo $employee->id ?>"><div class="profile">
                    <i class="fa fa-user-circle"></i>
                    <span><?php echo $employee->employeeFirstName." ".$employee->employeeLastName; ?></span>
                </div>
                </a>
                <?php endforeach; ?>
                <?php endif;?>
            </div>
        </div>
    </div>




</body>
</html>
