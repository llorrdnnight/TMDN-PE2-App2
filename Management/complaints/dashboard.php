<?php
    //Get temporary database file contents
    $json = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/Management/database.json"), true);

    function echoStatistics($arr, $id, $status)
    {
        $Complaints = array();

        foreach($arr as $Complaint)
        {
            if ($Complaint["Status"] == $status)
                array_push($Complaints, $Complaint);
        }

        $ComplaintsDiv = "";
        $ComplaintsDiv .= "<p>Number of " . $status. " Complaints: " . count($Complaints) . "</p>";
        $ComplaintsDiv .= "<p>Open for > 30 days: " . getDaysOpen($Complaints, 1) . "</p>";
        $ComplaintsDiv .= "<canvas id=" . $id . " class='canvas graph col-lg-8'></canvas>";

        echo $ComplaintsDiv;
    }

    function getDaysOpen($Array, $Days)
    {
        $Total = 0;
        $CurrentDate = new Datetime("now");

        foreach ($Array as $Complaint)
        {
            $ComplaintDate = new DateTime($Complaint["Date"]);

            if ($ComplaintDate->diff($CurrentDate)->format("%a") > $Days)
                $Total += 1;
        }

        return $Total;
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <script src="/Management/scripts/javascript/charts.js"></script>
    <title>Dashboard</title>
</head>
<body>
    <div id="wrapper"> <!-- Page container -->
        <header class="col-lg-12"> <!-- Header class -->
            <h1>Dashboard</h1>
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
                        <div class="row mb-3 pl-3 pr-3">
                            <div id="dashboard-opencomplaints" class="col-lg-6 dashboard-item">
                                <?php echoStatistics($json["Complaints"], "OpenComplaintsGraph", "Open"); ?>
                            </div>
                            
                            <div id="dashboard-opencomplaints" class="col-lg-6 dashboard-item">
                                <?php echoStatistics($json["Complaints"], "ClosedComplaintsGraph", "Closed"); ?>
                            </div>
                            
                            <h3 style='clear: left;'>
                                TODO: Add pie chart with number of open complaints, grouped by days open, 7 days => a month => 3 months => 6 months => a year<br>
                                Add bar chart with number of complaints, grouped per month, increases in height with number of complaints etc.<br>
                                Add a list of open and closed complaints mixed, (editable in dashboard page?).
                            </h3>
                        </div>
					</div>
				</div>
			</div>
		</div>
    </div>
</body>
</html>