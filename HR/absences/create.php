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
    <title>Dashboard - File an absence</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../js/notification.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
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
            <div class="left">
                <a href="../dashboard.php"><i class="fas fa-arrow-left"></i></a>
                <h1>File an absence</h1>
            </div>
            <div class="right">
            <i class="fa fa-user-circle"></i>
            <span>John Doe</span>
            </div>
            
        </div>
        <div class="absence-container">
            <form action="" method="POST">
                <div class="rt">
                    <p class="rt-error"></p>
                </div>                
                <div class="row">
                    <label for="">Start date</label>
                    <input type="date" name="startDate" value="<?php echo date("Y-m-d") ?>" id="start">
                </div>
                <div class="row">
                    <label for="">Days of absence</label>
                    <input type="text" value="1" name="" id="days">
                </div>
                <div class="row">
                    <label for="">End date</label>
                    <input type="date" name="endDate" id="end">
                </div>
                <div class="row">
                    <label for="">Reason of absence</label>
                    <textarea name="reason" id="" cols="30" rows="10" spellcheck="false"></textarea>
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


<script defer>



// show no error message at beginning
$(".rt").fadeOut(0);
// setup variables
startDate =  new Date($("#start").val());
endDate = new Date();

// set endDate = startDate + 1 @ startup
endDate.setDate(startDate.getDate() +  parseInt($("#days").val()));
$("#end").val(toStringDate(endDate));

// modifies a data object to a string
function toStringDate(date){

    let day = date.getDate();
    let month = date.getMonth() + 1;
    let year = date.getFullYear();

    if(day < 10){
        day = "0"+day;
    }
    if(month < 10){
        month = "0"+month;
    }
    date = ""+year+"-"+month+"-"+day+"";
    return date;
}


// shows an error message
function showErrorMessage(selector, msg, time){

    $(".rt-error").text(msg);
    $(selector).fadeIn(500);
    setTimeout(() => {
        $(selector).fadeOut(500);
    }, time);
}

var daysAbsence = $("#days");

$("#start").change(() => {
    // start vars
    let startDate =  new Date($("#start").val());
    let endDate = new Date($("#end").val());
    let today = new Date();
    // start date < today -> show error
    if (startDate < today){
        $("#start").val(toStringDate(today));
        $(".rt-error").text("You cannot file an absence in the past!")
        showErrorMessage(".rt", "You cannot file an absence in the past!", 3000);
    }
    // find the difference in days between 2 dates
    const diffTime = Math.abs(endDate - startDate);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
    // if diffdays is not a number - put empty string in days of absence
    if(isNaN(diffDays)){
    $("#days").val("");
    }
    // else put the calculated value
    else{
        $("#days").val(diffDays);
    }
    // if start and end date are equal -> show message -> adjust endDate so endDate = startDate + 1 day
    if (endDate.getDay() == startDate.getDay() && endDate.getMonth() == startDate.getMonth() && endDate.getFullYear() == startDate.getFullYear() ){
    console.log("they are equal");
    endDate.setDate(startDate.getDate() +  1);
    $("#days").val(1);
    $("#end").val(toStringDate(endDate));
    showErrorMessage(".rt", "You absence cannot last 0 days", 3000);
}

});


// if days change
$("#days").change(() => {

// calculate end date
startDate =  new Date($("#start").val());
endDate = new Date();
endDate.setDate(startDate.getDate() +  parseInt($("#days").val()));
// adjust endate input
$("#end").val(toStringDate(endDate));

});

$("#end").change(() => {
// get dates
let startDate =  new Date($("#start").val());
let endDate = new Date($("#end").val());

// end date cannot be < then start date
if (endDate < startDate){
    // if case -> endDate = startDate + 1 -> show error
    endDate.setDate(startDate.getDate() +  1);
    $("#end").val(toStringDate(endDate));
    showErrorMessage(".rt", "You cannot file an absence in the past!", 3000);
}

// if start and end date are equal -> show message -> adjust endDate so endDate = startDate + 1 day
if (endDate.getDay() == startDate.getDay() && endDate.getMonth() == startDate.getMonth() && endDate.getFullYear() == startDate.getFullYear() ){
    console.log("they are equal");
    endDate.setDate(startDate.getDate() +  1);
    $("#days").val(1);
    $("#end").val(toStringDate(endDate));
    showErrorMessage(".rt", "You absence cannot last 0 days", 3000);
}

// calculate difference in days between the two dates
const diffTime = Math.abs(startDate - endDate);
const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 

// adjust days input
if(isNaN(diffDays)){
    $("#days").val("");
}
else{
    $("#days").val(diffDays);
}
});

</script>


</body>
</html>