<?php
    $pageTable = array(
        "leave.php" => "Leave",
        "leavelist.php" => "Leave List",
        "newleave.php" => "New Leave",
        "editleave.php" => "Edit Leave",

        "vacature.php" => "Vacature",
        "addvacature.php" => "Add Vacature",
        "vacatureinfo.php" => "Vacature Info",

        "employeeinfo.php" => "Employee Info",
        "showallusers.php" => "User List",
        "adduser.php" => "Add User",
        "login.php" => "Login",

        "orders.php" => "Orders",
        "orderdetails.php" => "Order Info",
        "revenue.php" => "Revenue",
        "pricing.php" => "Pricing",
        "deliveries.php" => "Deliveries",
        "lostpackages.php" => "Lost Packages",

        "statistics.php" => "Statistics",
        "complaints.php" => "Complaints",
        "registercomplaint.php" => "Register Complaint",
        "editcomplaint.php" => "Edit Complaint",

        "template.php" => "Template"
    );

    $pageName = $pageTable[strtolower(basename($_SERVER["PHP_SELF"]))];
?>