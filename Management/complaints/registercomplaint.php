<?php
    $json = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/Management/database.json"), true);
    $newComplaint = array();

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $MemVars = array($_POST["OrderID"], $_POST["Category"], $_POST["Customer"], $_POST["Location"], $_POST["ReportedBy"], $_POST["Date"], $_POST["Category"]);

        if (validateForm($MemVars))
        {
            foreach($MemVars as $var)
            {
                array_push($newComplaint, $var);
            }
            
            array_push($json["Complaints"], $newComplaint);
            file_put_contents("database.json", json_encode($json));
            echo "done";
        }
    }
    else
    {

    }

    function validateForm($vars)
    {
        $valid = true;

        foreach ($vars as $var)
        {
            if (!(isset($var) && !empty($var)))
                $valid = false;
        }

        return $valid;
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
    <title>Complaints</title>
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
                            <div id="registercomplaints">
                                <h1>Register New Complaint</h1>

                                <form name="rcform" action="registercomplaint.php" method="POST">
                                    <label for="OrderID">Order ID<input name="OrderID" type="text"></label>
                                    <label for="Category">Category<input name="Category" type="text"></label>
                                    <label for="Customer">Customer<input name="Customer" type="text"></label>
                                    <label for="Location">Location<input name="Location" type="text"></label>
                                    <label for="ReportedBy">Reported By<input name="ReportedBy" type="text"></label>
                                    <label for="Date">Date<input name="Date" type="text"></label>
                                    <label for="Description">Description<textarea name="Description" id="Description"></textarea></label>

                                    <button type="submit">Submit</button>
                                    <button type="reset">Reset</button>
                                </form>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
</body>
</html>