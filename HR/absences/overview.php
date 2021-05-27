<?php
    if (!isset($_SESSION)) { session_start(); };
    
    require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php");
    require_once(PHPSCRIPTDIR . "error.php");    
    
    if (!isset($_SESSION["employee_id"]))
        header("Location: login.php");
    
    require_once(PHPSCRIPTDIR . "authentication.php");
    require_once(PHPSCRIPTDIR . "sanitize.php"); 
    require_once(PHPCLASSDIR . "Absence.php");
    require_once(PHPCLASSDIR . "Employee.php");
    require_once(COMPONENTSDIR . "navbar.php");

    if(isHR() == false && isManagement() == false){
        header("Location: /portal");
    }
    $success = false;

    $user = "test";
    $pass = "1Azerty?!";
    // try and create a PHP database object
    try {
        $db = new PDO('mysql:host=10.128.63.132;dbname=Bluesky_DB', $user, $pass);
    } 
    
    // handle exception
    catch (PDOException $e) {
        echo "Oops something when wrong trying to connect to the database: ".$e->getMessage();
        
    }



    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['verify'])){
            $id = $_POST['absence'];
            $db->query("UPDATE absences SET approved = 1 WHERE id = $id")->fetchAll();
            $success = true;

        }
        else if(isset($_POST['unverify'])){
            $id = $_POST['absence'];
            $db->query("UPDATE absences SET approved = 0 WHERE id = $id")->fetchAll();
            $success = true;


        }
    }




    if(isset($_GET['employee'])){
        $employee = $_GET['employee'];
        $result = $db->query("SELECT * FROM absences WHERE employeeID = $employee");
        $absences = $result->fetchAll();
    }
    else if(isset($_GET['q'])){
        $q = $_GET['q'];
        $stmt = $db->query("SELECT * FROM absences WHERE employeeID IN(SELECT id FROM employees WHERE CONCAT(employeeFirstName, ' ', employeeLastName) LIKE '%".$q."%')");
        $absences = $stmt->fetchAll();

    }
    else{
        $result = $db->query("SELECT * FROM absences");
        $absences = $result->fetchAll();
    }




?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absences overview - HR</title>
    <link rel="stylesheet" href=<?= HTMLCSS . "reset.css"; ?>>
    <link rel="stylesheet" href=<?= HTMLCSS . "navbar.css"; ?>>
    <link rel="stylesheet" href=<?= HTMLCSS . "state-messages.css"; ?>>
    <link rel="stylesheet" href=<?= HTMLCSS . "absences.css"; ?>>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css">
    <script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous">
    </script>
    <script src=<?= HTMLJAVASCRIPT . "notification.js"; ?>></script>
</head>
<body>
    <div class="wrapper">

    <?php echo generateNavigationBar("Absences overview", "app2/hr/dashboard", getEmployeeFirstName()) ?>


    
    <?php if($success):?>
            <div class="success-message">
                Absence updated!
            </div>
            <?php endif; ?>

    <div class="content">
        <div class="navigation">
            <div>
                    <form action="" method="GET">
                    <i class="fa fa-search"></i>
                    <input type="search" placeholder="Search employee..." name="q" id="">
                </form>
            </div>
        </div>

        
        <div class="inner">
        <?php if(isset($employee) || isset($q)): ?>
        <div class="banner">

        
            <?php if(isset($employee)): ?>
            <?php 
                
                // $id = $employee;
                // $result = $db->query("SELECT * FROM employees WHERE id = $id");
                // $temp = $result->fetch(0,1);
                // $employeeName = $temp['employeeFirstName']. " ". $temp['employeeLastName']    
                $url = "http://10.128.30.7:8080/api/AD/employees?id=$employee";
                $response = file_get_contents($url);
                $result = json_decode($response);
                $employeeNameAD = $result->employeeFirstName. " ".$result->employeeLastName; 

                
            ?>
            <div class="info">
              <a href="/app2/hr/absences/overview" class="fa fa-arrow-left"></a></i><span>Absences for: </span><span><?php echo $employeeNameAD; ?></span>
            </div>
            <?php elseif(isset($q)):?>
                <div class="info">
              <a href="/app2/hr/absences/overview" class="fa fa-arrow-left"></a></i><span>Absences search for: </span><span><?php echo $q; ?></span>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
            <table>
                <tr>
                    <td>Employee</td>
                    <td>Start date</td>
                    <td>End date</td>
                    <td>Approved</td>

                </tr>
                <?php foreach($absences as $absence): 


                    $id = $absence['employeeID'];
                    $result = $db->query("SELECT * FROM employees WHERE id = $id");
                    $temp = $result->fetch(0,1);
                    $employeeName = $temp['employeeFirstName']. " ". $temp['employeeLastName']
                    
                ?>
                <tr>
                    <?php if(isset($employee)): ?>
                    <td><a href="/app2/hr/absences/overview?employee=<?php echo $id ?>"><?php echo $employeeNameAD; ?></a></td>
                    <?php else: ?>
                    <td><a href="/app2/hr/absences/overview?employee=<?php echo $id ?>"><?php echo $employeeName; ?></a></td>
                    <?php endif; ?>
                    <td><?php echo explode(" ", $absence['startDate'])[0] ?></td>
                    <td><?php echo explode(" ", $absence['endDate'])[0] ?></td>
                    <td>
                        <?php if($absence['approved'] == 0): ?>
                            <form action="" method="POST">
                                <input type="submit" name="verify" value="Verify">
                                <input type="hidden" name="absence" value="<?php echo $absence['id']; ?>">
                            </form>
                        <?php else: ?>
                            <form action="" method="POST">
                                <input type="submit"  class="unverify" name="unverify" value="Unverify">
                                <input type="hidden" name="absence" value="<?php echo $absence['id']; ?>">
                            </form>

                        <?php endif; ?>
                
                    </td>

                </tr>

                <?php endforeach; ?>
            </table>
        </div>
    </div>


    </div>
    
</body>
</html>