<!-- Navigation bar
Dependencies:
include navbar.css
include Employee.php
fontawesome cdn
 -->

<?php

function generateNavigationBar($title, $pathToDashboard, $employeeName){
    return "<div class='nav-bar'>
                <div class='left'>
                    <a href='". $pathToDashboard ."'><i class='fas fa-arrow-left'></i></a>
                    <h1>".$title."</h1>
                </div>
                <div class='right'>
                    <i class='fa fa-user-circle'></i>
                    <span>". $employeeName ."</span>
                </div>
            </div>";
}


?>

