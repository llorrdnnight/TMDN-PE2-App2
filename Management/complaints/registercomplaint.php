<?php
session_start();
// Check if the session is set else redirect to login page
if (isset($_SESSION['employee_id'])){}

else
header("Location: login.php");
    $json = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/TMDN-PE2-App2/Management/database.json"), true);
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

<?php require($_SERVER["DOCUMENT_ROOT"] . "/TMDN-PE2-App2/Management/components/head/head.php"); ?>
    <title>Complaints - Register</title>
</head>
<body>
    <div id="wrapper"> <!-- Page container -->
        <header class="col-lg-12"> <!-- Header class -->
            <h1><a href='registercomplaint.php'>Register Complaint</a></h1>
        </header>

		<div class="container-fluid"> <!-- Nav and content container -->
			<div class="row"> <!-- Row class for nav and content columns -->
                <?php require($_SERVER["DOCUMENT_ROOT"] . "/TMDN-PE2-App2/Management/components/nav.html"); ?>

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