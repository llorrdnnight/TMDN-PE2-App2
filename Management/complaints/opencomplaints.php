<?php
    $json = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/Management/database.json"), true);

    function echoRecords($arr)
    {
        $table = "";
        $table .= "<table id='opencomplaintstable' class='table table-hover'><tr>";
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
            if ($Complaint["Status"] == "Open")
            {
                $row = "";
                $row .= "<tr>";
                $row .= "<td class='complaintid'><a href='./editcomplaint.php?ComplaintID=" . $Complaint["ComplaintID"] . "'>" . $Complaint["ComplaintID"] . "</a></td>";
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/Management/style/style.css">
    <title>Open Complaints</title>
</head>
<body>
    <div id="wrapper"> <!-- Page container -->
        <header class="col-lg-12"> <!-- Header class -->
            <h1>Deliveries</h1>
        </header>

		<div class="container-fluid"> <!-- Nav and content container -->
			<div class="row"> <!-- Row class for nav and content columns -->
				<nav id="sidebar-wrapper" class="col-lg-1"> <!-- 1 unit wide column -->
					<ul class="sidebar-nav">
						<li><a href="/Management/deliveries.php">Deliveries</a></li>
						<li><a href="/Management/lostpackages.php">Lost Packages</a></li>
						<li><a href="/Management/complaints/dashboard.php">Complaints</a></li>
						<li>
							<ul>
								<li><a href="/Management/complaints/dashboard.php">Dashboard</a></li>
								<li><a href="/Management/complaints/opencomplaints.php">Open Complaints</a></li>
								<li><a href="/Management/complaints/closedcomplaints.php">Closed Complaints</a></li>
								<li><a href="/Management/complaints/registercomplaint.php">Register Complaint</a></li>
							</ul>
						</li>
					</ul>
				</nav>

				<div id="page-content-wrapper" class="col-lg-11"> <!-- Separate wrapper for content -->
					<div class="container-fluid">
						<div class="col-lg-12 nopadding">
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
					</div>
				</div>
			</div>
		</div>
    </div>
</body>

</html>