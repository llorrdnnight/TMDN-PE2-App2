<?php
    /**
    * Info of a specific Employee
    *
    * @author Levi Nauwelaerts
    * @datetime 25 February 2021
    * @input Employee_id given through the url
    */

    require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php");
    require_once(PHPSCRIPTDIR . "error.php");

    require_once(PHPSCRIPTDIR . "db_config.php");
    require_once(PHPSCRIPTDIR . "sanitize.php");
    require_once(PHPSCRIPTDIR . "authentication.php");

    $error = null;

    //Check the get request for an employee_id, use that id to consult the DB
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $employee_id = sanitize($_GET["employee_id"]);

        $sql = "SELECT * FROM employee WHERE id = $employee_id"; //Telt dit al mee als prepared statement? ik dacht dat er een vraagteken moest staan.
        $stmt = $db->prepare($sql);
        if($stmt->execute()){
        //check if recieved ID is correct
        if($stmt->rowCount() > 0){
            $employee = $stmt->fetch();

            }
        else $error = "No employee for given ID found.";

        }
        else $error = "Execution error";
    }
    else
    {
        header("Location: dashboard.php");
    }
?>

<?php require(COMPONENTSDIR . COMPONENT_HRHEAD); ?>
    <title>Employee Info</title>
</head>
<?php require(COMPONENTSDIR . COMPONENT_HR_BODY_TOP); ?>

    <table class="table table-hover">
        <tr>
            <th>ID</th>
            <!-- Merge firstName + lastName  -->
            <th>Name</th>
            <th>Email</th>
            <th>Phone number</th>
            <th>Salary</th>
            <th>Job</th>
            <th>Birth date</th>
        </tr>
        <tr>
            <?php
                echo "<td>".$employee['id']."</td>";
                echo "<td>".$employee['firstName']." ".$employee['lastName']."</td>";
                echo "<td>".$employee['mailAddress']."</td>";
                echo "<td>".$employee['phoneNumber']."</td>";
                echo "<td>".$employee['salary']."</td>";
                echo "<td>".$employee['job']."</td>";
                echo "<td>".$employee['birthDate']."</td>";
            ?>
        </tr>
    </table>

    <p id="error"><?php echo $error; ?></p>

    <?php //include(COMPONENTSDIR . COMPONENT_FOOTER); ?>
<?php require(COMPONENTSDIR . COMPONENT_BODY_BOTTOM); ?>
