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

<?php require($_SERVER["DOCUMENT_ROOT"] . "/Management/components/head/head.php"); ?>
    <title>Complaints - Edit</title>
</head>
<body>
    <div id="wrapper"> <!-- Page container -->
        <header class="col-lg-12"> <!-- Header class -->
            <h1>Edit Complaint</h1>
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

