<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
include '../includes/db_config.php';
include '../includes/authentication.php';
include '../includes/sanitize.php';
include '../includes/classes/Absence.php';

if(!isLoggedIn()){
    header("Location: ../dashboard.php");
}

$formError = "";
if($_SERVER['REQUEST_METHOD'] == "POST"){

$startDate = sanitize($_POST['startDate']);
$endDate = sanitize($_POST['endDate']);
$reason = sanitize($_POST['reason']);


if(empty($startDate) || empty($endDate) || empty($reason)){

    $formError = "Fill in all the fields.";
}

else{
    if(Absence::createAbsence($startDate, $endDate, $reason, $db)){
        $success = true;
    }
    else{
        $error = true;
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
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/absences.css">
    <link rel="stylesheet" href="../css/state-messages.css">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../js/notification.js"></script>
</head>
<body>

    <div class="wrapper">
        <?php if($success): ?>
        <div class="success-message">
            <p>Your absence has been filed correctly!</p>
        </div>
        <?php endif; ?>

        <?php if($error): ?>
        <div class="error-message">
            <p>Something went wrong when filing your absence!</p>
        </div>
        <?php endif; ?>
        <div class="nav-bar">
            <h1>File an absence</h1>
        </div>
        <div class="absence-container">
            <form action="" method="POST">

                <div class="row">
                    <label for="">Start date</label>
                    <input type="date" name="startDate" id="">
                </div>
                <div class="row">
                    <label for="">End date</label>
                    <input type="date" name="endDate" id="">
                </div>
                <div class="row">
                    <label for="">Reason of absence</label>
                    <textarea name="reason" id="" cols="30" rows="10"></textarea>
                </div>

                <div class="row">
                    <input type="submit" value="Send">
                </div>

                <?php if(strlen($formError) > 0): ?>
                <div class="row">
                    <p class="formError"><?php echo $formError; ?></p>
                </div>
                <?php endif; ?>
            </form>
            
        </div>
    </div>


    
</body>
</html>