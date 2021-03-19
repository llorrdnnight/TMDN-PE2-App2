<?php
    $json = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/Management/database.json"), true);

    if (isset($_POST["Submit"]))
    {
        print_r($_POST);
    }

    function echoEditableComplaintDetails($Complaints, $ComplaintID)
    {
        foreach($Complaints as $Complaint)
        {
            if ($Complaint["ComplaintID"] == $ComplaintID)
            {
                $Details = "";
                $Details .= "<form name='ecform'action='editcomplaint.php' method='POST'>";
                $Details .= "<div class='form-row'>";
                $Details .= "<div class='form-group col-lg-6'>";
                $Details .= "<label for='ComplaintID'>Complaint ID:</label><input class='form-control' name='OrderID' type='text' value='" . $Complaint["ComplaintID"] . "' disabled>";
                $Details .= "<label for='OrderID'>Order ID</label><input class='form-control' name='OrderID' type='text' value='" . $Complaint["OrderID"] . "'>";
                $Details .= "<label for='Category'>Category</label><input class='form-control' name='Category' type='text' value='" . $Complaint["Category"] . "'>";
                $Details .= "</div><div class='form-group col-lg-6'>";
                $Details .= "<label for='Status'>Status</label><input class='form-control' name='Status' type='text' value='" . $Complaint["Status"] . "'>";
                $Details .= "<label for='Customer'>Customer</label><input class='form-control' name='Customer' type='text' value='" . $Complaint["Customer"] . "'>";
                $Details .= "</div></div><div class='form-row'><div class='btn-group'>";
                $Details .= "<button name='Submit' type='submit' class='btn btn-success'>Submit</button><button name='Reset' type='reset' class='btn btn-secondary'>Reset</button>";
                $Details .= "</div></div>";
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
                    <?php require($_SERVER["DOCUMENT_ROOT"] . "/Management/components/complaintsnav.html"); ?>

					<div class="container-fluid">
						<div class="col-lg-12">
                            <div id="editcomplaint">
                                <h1>Edit Complaint</h1>

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

