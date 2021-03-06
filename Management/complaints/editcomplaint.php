<?php
    $json = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/Management/database.json"), true);

    if (isset($_POST["Submit"]))
    {
        print_r($_POST);
    }

    function echoEditableComplaintDetails($arr, $ComplaintID)
    {
        foreach($arr as $Complaint)
        {
            if ($Complaint["ComplaintID"] == $ComplaintID)
            {
                $Details = "";
                $Details .= "<form name='ecform' method='POST'>";
                $Details .= "<label for='ComplaintID'>Complaint ID: <input name='OrderID' type='text' value='" . $Complaint["ComplaintID"] . "' disabled></label>";
                $Details .= "<label for='OrderID'>Order ID<input name='OrderID' type='text' value='" . $Complaint["OrderID"] . "'></label>";
                $Details .= "<label for='Category'>Category<input name='Category' type='text' value='" . $Complaint["Category"] . "'></label>";
                $Details .= "<label for='Status'>Status<input name='Status' type='text' value='" . $Complaint["Status"] . "'></label>";
                $Details .= "<label for='Customer'>Customer<input name='Customer' type='text' value='" . $Complaint["Customer"] . "'></label>";
                $Details .= "<button name='Submit' type='submit'>Submit</button><button name='Reset' type='reset'>Reset</button>";
                $Details .= "</form>";
                echo $Details;

                return;
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Edit Complaint</title>
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
                            <div id="editcomplaint">
                                <?php 
                                    if (isset($_GET["ComplaintID"]) && !empty($_GET["ComplaintID"]))
                                        echoEditableComplaintDetails($json["Complaints"], $_GET["ComplaintID"]);
                                    else
                                        header("Location: opencomplaints.php");
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

