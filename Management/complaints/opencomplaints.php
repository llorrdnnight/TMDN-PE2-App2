<?php
    $json = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/Management/database.json"), true);

    function echoRecords($arr)
    {
        if (isset($_GET["ComplaintID"]))
        {
            //DIT IS ALLEMAAL TIJDELIJK___________________________________________________________________________________

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
                if ($Complaint["ComplaintID"] == $_GET["ComplaintID"])
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
                    $row .= "</tr>";
                    
                    echo $row;
                }
            }
            echo "</table>";
        }
        else
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
                    $row .= "</tr>";
                    
                    echo $row;
                }
            }
            
            echo "</table>";
        }
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

<?php require($_SERVER["DOCUMENT_ROOT"] . "/Management/components/head/head.php"); ?>
    <title>Complaints - Open</title>
</head>
<body>
    <div id="wrapper"> <!-- Page container -->
        <header class="col-lg-12"> <!-- Header class -->
            <h1><a href='opencomplaints.php'>Open Complaints</a></h1>
        </header>

		<div class="container-fluid"> <!-- Nav and content container -->
			<div class="row"> <!-- Row class for nav and content columns -->
                <?php require($_SERVER["DOCUMENT_ROOT"] . "/Management/components/nav.html"); ?>

				<div id="page-content-wrapper" class="col-lg-11"> <!-- Separate wrapper for content -->
                    <nav aria-label="Page navigation" class="d-flex justify-content-center">
                        <ul class="pagination">
                            <li class='page-item'><a class='page-link' href='dashboard.php'>Dashboard</a></li>
                            <li class='page-item'><a class='page-link' href='opencomplaints.php'>Open Complaints</a></li>
                            <li class='page-item'><a class='page-link' href='closedcomplaints.php'>Closed Complaints</a></li>
                            <li class='page-item'><a class='page-link' href='registercomplaint.php'>Register Complaint</a></li>
                        </ul>
                    </nav>

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