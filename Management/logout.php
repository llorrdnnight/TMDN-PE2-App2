<?php
session_start();
if(isset($_SESSION['employee_id'])){
    session_unset();
    session_destroy();
    header("Location: login.php");
}
else{
    // session_unset();
    // session_destroy();
    // header("Location: login.php");
}
?>