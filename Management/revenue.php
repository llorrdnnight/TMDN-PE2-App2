<?php
session_start();
// Check if the session is set else redirect to login page
if (isset($_SESSION['employee_id'])){}

else
header("Location: login.php");
	$json = json_decode(file_get_contents("MOCK_DATA.json"), true);

    // Fill Arrays with 0's
    $yearProfits = array_fill(1, 12, 0);
    $yearExpenses = array_fill(1, 12, 0);
    $monthProfits = array_fill(1, 31, 0);
    $monthExpenses = array_fill(1, 31, 0);

    // Get year & month
    error_reporting(0);
    if($_GET['date'] != null){
        $sp = explode("-", $_GET['date']);
        $year = $sp[0];
        $month = $sp[1];
    } else {
        $year = getdate()["year"];
        $month = getdate()["mon"];
    }
    error_reporting(E_ALL);

    // Expenses
    foreach($json["Expenses"] as $Expense) {
        $split = date_parse_from_format('d/m/Y', $Expense["date"]);
        if($split['year'] == $year){
            $yearExpenses[$split['month']] += $Expense['price'];

            if($split['month'] == $month){
                $monthExpenses[$split['day']] += $Expense['price'];
            }
        }
    }

    // Profits
    foreach($json["Orders"] as $Profit) {
        $split = date_parse_from_format('d/m/Y', $Profit["date"]);
        if($split['year'] == $year){
            $yearProfits[$split['month']] += $Profit['price'];

            if($split['month'] == $month){
                $monthProfits[$split['day']] += $Profit['price'];
            }
        }
    }?>


<script type="text/javascript">
        // Load the Visualization API and the corechart package.
        google.charts.load('current', {'packages':['bar']});

        // Set a callback to run when the Google Visualization API is loaded.
        google.charts.setOnLoadCallback(drawChart);

        // Callback that creates and populates a data table,
        // instantiates the pie chart, passes in the data and
        // draws it.
        function drawChart() {

            // Create the data table.
            var dataY = google.visualization.arrayToDataTable([
            ['Month', 'Sales', 'Expenses', 'Profit'],
            ['Jan', <?php echo($yearProfits[1] . ',' . $yearExpenses[1] . ',' . $yearProfits[1] -  $yearExpenses[1]); ?>],
            ['Feb', <?php echo($yearProfits[2] . ',' . $yearExpenses[2] . ',' . $yearProfits[2] -  $yearExpenses[2]); ?>],
            ['Mar', <?php echo($yearProfits[3] . ',' . $yearExpenses[3] . ',' . $yearProfits[3] -  $yearExpenses[3]); ?>],
            ['Apr', <?php echo($yearProfits[4] . ',' . $yearExpenses[4] . ',' . $yearProfits[4] -  $yearExpenses[4]); ?>],
            ['May', <?php echo($yearProfits[5] . ',' . $yearExpenses[5] . ',' . $yearProfits[5] -  $yearExpenses[5]); ?>],
            ['Jun', <?php echo($yearProfits[6] . ',' . $yearExpenses[6] . ',' . $yearProfits[6] -  $yearExpenses[6]); ?>],
            ['Jul', <?php echo($yearProfits[7] . ',' . $yearExpenses[7] . ',' . $yearProfits[7] -  $yearExpenses[7]); ?>],
            ['Aug', <?php echo($yearProfits[8] . ',' . $yearExpenses[8] . ',' . $yearProfits[8] -  $yearExpenses[8]); ?>],
            ['Sep', <?php echo($yearProfits[9] . ',' . $yearExpenses[9] . ',' . $yearProfits[9] -  $yearExpenses[9]); ?>],
            ['Oct', <?php echo($yearProfits[10] . ',' . $yearExpenses[10] . ',' . $yearProfits[10] -  $yearExpenses[10]); ?>],
            ['Nov', <?php echo($yearProfits[11] . ',' . $yearExpenses[11] . ',' . $yearProfits[11] -  $yearExpenses[11]); ?>],
            ['Dec', <?php echo($yearProfits[12] . ',' . $yearExpenses[12] . ',' . $yearProfits[12] -  $yearExpenses[12]); ?>]
            ]);

            var dataM = google.visualization.arrayToDataTable([
                ['Day', 'Sales', 'Expenses', 'Profit'],
                <?php
                    for($i = 1; $i <= 31; $i++) {
                        echo('[\'' . $i . '\', ' . $monthProfits[$i] . ', ' . $monthExpenses[$i] . ', ' . $monthProfits[$i] - $monthExpenses[$i] . ']');
                        if($i != 31) {
                            echo(',');
                        }
                    }
                ?>
            ])

            // Set chart options
            var options = {
            vAxis: {format: 'decimal'}
            };

            // Instantiate and draw our chart, passing in some options.
            var chartY = new google.charts.Bar(document.getElementById('chart_div_Y'));
            chartY.draw(dataY, google.charts.Bar.convertOptions(options));

            var chartM = new google.charts.Bar(document.getElementById('chart_div_M'));
            chartM.draw(dataM, google.charts.Bar.convertOptions(options));
        }
    </script>
    
<?php require($_SERVER["DOCUMENT_ROOT"] . "/TMDN-PE2-App2/Management/components/head/head.php"); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Used By Google Charts -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <title>Revenue</title>
</head>

<body>
<div id="wrapper" class="container-fluid h-100"><!-- full body wrapper -->
        <div class="row h-100">
            <div class="col-12">
                <div class="d-flex flex-column h-100"><!-- content flexbox -->
                    <div class="row">
                        <div class="col-12 p-0">
                            <header class="col-lg-12"> <!-- Header class -->
                                <h1>Revenue</h1>
                            </header>
                        </div>
                    </div>


		<div class="row flex-grow-1">
            <?php require($_SERVER["DOCUMENT_ROOT"] . "/TMDN-PE2-App2/Management/components/nav.html"); ?>
				
            <div id="page-content-wrapper" class="col-lg-11"> <!-- Separate wrapper for content -->
					<div class="container-fluid"> <!-- Insert code after this container -->
                        <form action="./revenue.php" method="get">
                            <input name="date" type="month"/>
                            <input type="submit" value="Sort">
                        </form>

						<div class="col-lg-12">
                            <h3>Year - <?php echo($year); ?></h3>
                            <div id="chart_div_Y" style="width: fill; height: 500px;"></div>	
						</div>

                        <hr></hr>

                        <div class="col-lg-12">
                            <h3>Month - <?php echo($month . '/' . $year); ?></h3>
                            <div id="chart_div_M" style="width: fill; height: 500px;"></div>
						</div>
					</div> <!-- End of container -->
				</div>
			</div>

		</div>
    </div>
</body>
</html>