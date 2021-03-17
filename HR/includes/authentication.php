<?php 

/*
These are functions used to determine the access level and states of the logged in user

*/

function isAdmin(){
    return $_SESSION['isAdmin'];
}

function getUserId(){
    return $_SESSION['employee_id'];
}
function isLoggedIn(){
    return isset($_SESSION['employee_id']);
}
function logoutUser(){
    session_destroy();
}


?>