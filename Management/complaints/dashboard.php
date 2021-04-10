<?php
session_start();
// Check if the session is set else redirect to login page
if (isset($_SESSION['employee_id'])){}

else
header("Location: login.php");
    //Get temporary database file contents
    $json = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/TMDN-PE2-App2/Management/database.json"), true);

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
        $ComplaintsDiv .= "<canvas id=" . $id . " class='canvas graph col-lg-8' style='height: 200px;'></canvas>";

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

<?php require($_SERVER["DOCUMENT_ROOT"] . "/TMDN-PE2-App2/Management/components/head/head.php"); ?>
<?php require($_SERVER["DOCUMENT_ROOT"] . "/TMDN-PE2-App2/Management/components/head/head-dashboard-bottom.html"); ?>
<body>
    <div id="wrapper"> <!-- Page container -->
        <header class="col-lg-12"> <!-- Header class -->
            <h1><a href="./dashboard.php">Dashboard</a></h1>
        </header>

		<div class="container-fluid"> <!-- Nav and content container -->
			<div class="row"> <!-- Row class for nav and content columns -->
                <?php require("../components/nav.html"); ?>

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
                        <div class="row mb-3 pl-3 pr-3">
                            <div id="dashboard-opencomplaints" class="col-lg-6 dashboard-item">
                                <?php echoStatistics($json["Complaints"], "OpenComplaintsGraph", "Open"); ?>
                            </div>
                            
                            <div id="dashboard-opencomplaints" class="col-lg-6 dashboard-item">
                                <?php echoStatistics($json["Complaints"], "ClosedComplaintsGraph", "Closed"); ?>
                            </div>
                            
                            <!-- <h3 style='clear: left;'>
                                TODO: Add pie chart with number of open complaints, grouped by days open, 7 days => a month => 3 months => 6 months => a year<br>
                                Add bar chart with number of complaints, grouped per month, increases in height with number of complaints etc.<br>
                                Add a list of open and closed complaints mixed, (editable in dashboard page?).
                            </h3> -->
                        </div>
                        <div class="row mb-3 pl-3 pr-3">
                            <div class="chart-container col-lg-12">
                                <canvas id="test" class='canvas' style="height: 250px; width: 1600px;"></canvas>
                            </div>
                        </div>
					</div>
				</div>
			</div>
		</div>
    </div>
</body>
</html>