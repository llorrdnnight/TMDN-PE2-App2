<?php
if (!isset($_SESSION)) { session_start(); };
// Check if the session is set else redirect to login page

if (!isset($_SESSION["employee_id"]))
    header("Location: login.php");

    // Get year & month
    $date = getdate()["year"] . "-" . getdate()["mon"];

    if(isset($_GET['date']))
        if($_GET['date'] != null)
            $date = $_GET['date'];
?>


<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php"); ?>
<?php require(COMPONENTSDIR . COMPONENT_MANAGEMENTHEAD); ?>

<!-- Used By Charts.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script src=<?= HTMLJAVASCRIPT . "getGraphRev.js"?>></script>
<script type="text/javascript">
    $(document).ready(function()
    {
        setBarChartDataRevYear(document.getElementById("YearlyRevenueGraph"), "<?php echo $date;?>");
        setBarChartDataRevMonth(document.getElementById("MonthlyRevenueGraph"), "<?php echo $date;?>");
    });
</script>

    <title>Revenue</title>
</head>

<?php require(COMPONENTSDIR . COMPONENT_MANAGEMENT_BODY_TOP); ?>

    <div class="container-fluid">
        <div class="row mb-3 mt-3 pl-3 pr-3">
            <div id="test">
                <h5>Date Selection:</h5>
                <form action="./revenue.php" method="get">
                    <input name="date" type="month"/>
                    <input type="submit" value="Sort">
                </form>
            </div>
        </div>

        <div class="row mb-3 pl-3 pr-3">
            <div class="chart-container col-lg-12">
                <canvas id="YearlyRevenueGraph" class='canvas graph' style="height: 800px; width: 1600px;"></canvas>
            </div>
        </div>

        <div class="row mb-3 pl-3 pr-3">
            <div class="chart-container col-lg-12">
                <canvas id="MonthlyRevenueGraph" class='canvas graph' style="height: 800px; width: 1600px;"></canvas>
            </div>
        </div>
    </div>
<?php require(COMPONENTSDIR . COMPONENT_BODY_BOTTOM); ?>
