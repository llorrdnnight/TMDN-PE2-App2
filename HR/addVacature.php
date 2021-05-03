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


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/vacature.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">

    <title>Add Vacature</title>
</head>
<body>
        <div class="nav-bar">
            <div class="left">
                <a href="Vacature.php"><i class="fas fa-arrow-left"></i></a>
                <h1>Add Vacature</h1>
            </div>
            <div class="right">
            <i class="fa fa-user-circle"></i>
            <span><?php echo Employee::getEmployeeNameById(getUserId(), $db); ?></span>
            </div>
        </div>
    <div class="add-container">
            <form action="" method="POST">
                         
                <div class="row">
                    <label for="">Job Title</label><br>
                    <input type="text" placeholder="title" name="" id="title">
                </div>
                <div class="row">
                    <label for="">Department</label><br>
                    <input type="text" placeholder="HR" name="" id="department">
                </div>
                <div class="row">
                    <label for="">Location</label><br>
                    <input type="text" placeholder="Belgium" name="" id="location">
                </div>
                <div class="row">
                    <label for="">Job creation Date</label><br>
                    <input type="date" name="endDate" id="end">
                </div>
                <div class="row">
                    <label for="">Is this Job Available ?<input type="checkbox" name="" id="available"></label>
                </div>
                <div class="row">
                    <label for="">Degree</label><br>
                    <input type="text" placeholder="E-ICT Batchler" name="" id="degree">
                </div>
                <div class="row">
                    <label for="">Experience</label><br>
                    <input type="textarea" placeholder="2 years junior developer" name="" id="experience">
                </div>
                <div class="row" id="reason">
                    <label for="">General Job Description</label><br>
                    <textarea name="reason" placeholder="give a general description of the job" id="description" cols="30" rows="2" spellcheck="false"></textarea>
                </div>
                <div class="row">
                    <input type="submit" value="Send" id="sentBtn">
                </div>
            </form>
            
        </div>
</body>
