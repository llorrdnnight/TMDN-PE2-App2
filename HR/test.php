<?php 

include './includes/db_config.php';
include './includes/authentication.php';
include './includes/sanitize.php';
include './components/navbar.php';

include './includes/classes/Employee.php';


var_dump(Employee::getCurrentWorkSession(2, $db));

?>