<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/TMDN-PE2-App2/PATHS.PHP");
    
    //Get temporary database file contents
    $json = json_decode(file_get_contents(MANAGEMENTDIR . "database.json"), true);

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

<?php require(COMPONENTSDIR . COMPONENT_HEAD); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <script src=<?= HTMLJAVASCRIPT . "getGraph.js"?>></script>
    <title>Complaints - Dashboard</title>
</head>
<?php require(COMPONENTSDIR . COMPONENT_BODY_TOP); ?>
    <?php require(COMPONENTSDIR . COMPONENT_COMPLAINTSNAV); ?>

    <div class="container-fluid">
        <div class="row"><div id="test"></div></div>
        <div class="row mb-3 pl-3 pr-3">
            <div id="dashboard-opencomplaints" class="col-lg-6 dashboard-item">
                <?php echoStatistics($json["Complaints"], "OpenComplaintsGraph", "Open"); ?>
            </div>
            
            <div id="dashboard-opencomplaints" class="col-lg-6 dashboard-item">
                <?php echoStatistics($json["Complaints"], "ClosedComplaintsGraph", "Closed"); ?>
            </div>
        </div>

        <div class="row mb-3 pl-3 pr-3">
            <div class="chart-container col-lg-12">
                <canvas id="MonthlyComplaintsGraph" class='canvas graph' style="height: 250px; width: 1600px;"></canvas>
            </div>
        </div>
    </div>
<?php require(COMPONENTSDIR . COMPONENT_BODY_BOTTOM); ?>