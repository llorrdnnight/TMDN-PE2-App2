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

<?php require($_SERVER["DOCUMENT_ROOT"] . "/Management/components/head/head.php"); ?>
    <title>Complaints - Register</title>
</head>
<body>
    <div id="wrapper"> <!-- Page container -->
        <header class="col-lg-12"> <!-- Header class -->
            <h1><a href='registercomplaint.php'>Register Complaint</a></h1>
        </header>

		<div class="container-fluid"> <!-- Nav and content container -->
			<div class="row"> <!-- Row class for nav and content columns -->
                <?php require($_SERVER["DOCUMENT_ROOT"] . "/Management/components/nav.html"); ?>

				<div id="page-content-wrapper" class="col-lg-11"> <!-- Separate wrapper for content -->
                    <?php require($_SERVER["DOCUMENT_ROOT"] . "/Management/components/complaintsnav.html"); ?>
                    
					<div class="container-fluid">
						<div class="col-lg-12">
                            <div id="registercomplaints">
                                <h1>Register New Complaint</h1>

                                <form name="rcform" action="registercomplaint.php" method="POST" class="needs-validation">
                                    <div class="form-row">
                                        <div class="form-group col-lg-6">
                                            <label for="Customer">Customer</label><input name="Customer" type="text" class="form-control" required>
                                            <label for="Category">Category</label><input name="Category" type="text" class="form-control" required>
                                            <label for="ReportedBy">Reported By</label><input name="ReportedBy" type="text" class="form-control">
                                            <label for="Date">Date</label><input name="Date" type="date" class="form-control" required>
                                            <label for="Location">Location</label><input name="Location" type="text" class="form-control mb-3">
                                        </div>

                                        <div class="form-group col-lg-6">

                                            <label for="Phone">Phone</label><input name="Phone" type="number" class="form-control">
                                            <label for="Email">Email</label><input name="Email" type="email" class="form-control">
                                            <label for="Fax">Fax</label><input name="Fax" type="text" class="form-control">
                                            <label for="Description">Description</label><textarea name="Description" id="Description" class="form-control" required></textarea>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="btn-group">
                                            <button class="btn btn-success" type="submit">Submit</button>  
                                            <button class="btn btn-secondary" type="reset">Reset</button>
                                        </div>
                                    </div>
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