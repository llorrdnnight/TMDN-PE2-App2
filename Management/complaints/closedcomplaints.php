<?php
    $json = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/Management/database.json"), true);
    if (isset($_GET["ComplaintID"]) && !empty($_GET["ComplaintID"]))
    {

    }
    else
    {

    }

    function echoRecords($arr)
    {
        $table = "";
        $table .= "<table id='opencomplaintstable'><tr>";
        $table .= "<th>Complaint ID</th>";
        $table .= "<th>Order ID</th>";
        $table .= "<th>Category</th>";
        $table .= "<th>Customer</th>";
        $table .= "<th>Location</th>";
        $table .= "<th>Reported by</th>";
        $table .= "<th>Date</th>";
        $table .= "<th>Days open</th></tr>";

        echo $table;

        foreach ($arr as $Complaint)
        {
            if ($Complaint["Status"] == "Closed")
            {
                $row = "";
                $row .= "<tr>";
                $row .= "<td class='complaintid'><a href='./closedcomplaints.php?ComplaintID=" . $Complaint["ComplaintID"] . "'>" . $Complaint["ComplaintID"] . "</a></td>";
                $row .= "<td>" . $Complaint["OrderID"] . "</td>";
                $row .= "<td>" . $Complaint["Category"] . "</td>";
                $row .= "<td>" . $Complaint["Customer"] . "</td>";
                $row .= "<td>" . $Complaint["Location"] . "</td>";
                $row .= "<td>" . $Complaint["Reported By"] . "</td>";
                $row .= "<td>" . $Complaint["Date"] . "</td>";
                $row .= "<td>" . "fill in date diff here" . "</td>";
                $row .= "<td>" . "fill in phone number here" . "</td>";
                $row .= "<td>" . "fill in fax here" . "</td>";
                $row .= "<td>" . "fill in email here" . "</td>";
                
                echo $row;
            }
        }

        echo "</table>";
    }

    function echoComplaintDetails($arr, $ComplaintID)
    {
        foreach($arr as $Complaint)
        {
            if ($Complaint["ComplaintID"] == $ComplaintID)
            {
                foreach ($Complaint as $key => $value)
                {
                    echo $key . ": " . $value . "<br>";
                }
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
    <link rel="stylesheet" type="text/css" href="/Management/style/reset.css">
    <link rel="stylesheet" type="text/css" href="/Management/style/style.css">
    <link rel="stylesheet" type="text/css" href="/Management/style/complaints.css">
    <title>Complaints</title>
</head>
<body>
    <nav>
        <div id="navcategory">
            <button>nav1</button>
            <button>nav2</button>
            <button>nav3</button>
        </div>
        
        <div id="navexit"><button>exit</button></div>
    </nav>

    <header>Complaints</header>
    
    <div id="content">
        <div id="select">
            <button><a href="./complaintsdashboard.php">Dashboard</a></button>
            <button><a href="./registercomplaint.php">Register Complaint</a></button>
            <button><a href="./opencomplaints.php">Open Complaints</a></button>
            <button class="selected"><a href="./closedcomplaints.php">Closed Complaints</a></button>
        </div>

        <div id="opencomplaints">
            <?php 
                if (isset($_GET["ComplaintID"]) && !empty($_GET["ComplaintID"]))
                {
                    echoComplaintDetails($json["Complaints"], $_GET["ComplaintID"]);
                }
                else
                {
                    echoRecords($json["Complaints"]);
                }
            ?>
        </div>
    </div>
</body>
</html>