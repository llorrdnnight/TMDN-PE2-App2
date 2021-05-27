<?php
    if (!isset($_SESSION)) { session_start(); };
    
    require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php");
    require_once(PHPSCRIPTDIR . "error.php");    
    
    if (!isset($_SESSION["employee_id"]))
        header("Location: ../login.php");

    $complaints = json_decode(file_get_contents("http://10.128.30.7:8080/api/tickets"), true)["data"];

    function echoStatistics($complaints, $id, $status)
    {
        $complaintsDiv = "<div class='card'>";
        $complaintsDiv .= "<div class='card-header'>";
        $complaintsDiv .= "<span>" . $status . " complaints</span>";
        $complaintsDiv .= "</div><div class='card-body'>";
        $complaintsDiv .= "<canvas id=" . $id . " class='canvas graph col-lg-8' style='height: 200px;'></canvas>";
        $complaintsDiv .= "</div></div>";

        echo $complaintsDiv;
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

<?php require(COMPONENTSDIR . COMPONENT_MANAGEMENTHEAD); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <script src=<?= HTMLJAVASCRIPT . "getGraph.js"?>></script>
    <title>Complaints - Statistics</title>
</head>
<?php require(COMPONENTSDIR . COMPONENT_MANAGEMENT_BODY_TOP); ?>
    <?php require(COMPONENTSDIR . COMPONENT_COMPLAINTSNAV); ?>

    <div class="container-fluid">
        <div class="h-100 d-flex flex-column justify-content-between">
            <div class="row">
                <div class="col-12 col-md-6">
                    <?php echoStatistics($complaints, "OpenComplaintsGraph", "Open"); ?>
                </div>
                
                <div class="col-12 col-md-6">
                    <?php echoStatistics($complaints, "ClosedComplaintsGraph", "Closed"); ?>
                </div>
            </div>
            
            <div id="bcc" class="row">
                <div class="col-12 mt-3">
                    <div class="card">
                        <div class="card-header text-center">
                            <span>Open and Closed complaints grouped by month</span>
                        </div>
                        <div class="card-body">
                            <div id="barChartContainer">
                                <canvas id="MonthlyComplaintsGraph" class='canvas graph'></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require(COMPONENTSDIR . COMPONENT_BODY_BOTTOM); ?>