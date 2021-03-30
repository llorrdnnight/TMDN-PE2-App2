<?php
    $json = json_decode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/TMDN-PE2-App2/Management/database.json"), true);

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
                $Details .= "</div></div><div class='form-row'><div class='btn-group col-xl-2 p-0 pr-2'>";
                $Details .= "<button name='Submit' type='submit' class='btn btn-success'>Submit</button><button name='Reset' type='reset' class='btn btn-secondary'>Reset</button>";
                $Details .= "</div></div>";
                $Details .= "</form>";

                echo $Details;
                return;
            }
        }
    }
?>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/TMDN-PE2-App2/Management/components/head/head.php"); ?>
    <title>Complaints - Edit</title>
</head>
<body>
    <div id="wrapper" class="container-fluid h-100"><!-- full body wrapper -->
        <div class="row h-100">
            <div class="col-12">
                <div class="d-flex flex-column h-100"><!-- content flexbox -->
                    <div class="row">
                        <div class="col-12 p-0">
                            <header class="col-lg-12"> <!-- Header class -->
                                <h1>Edit Complaint</h1>
                            </header>
                        </div>
                    </div>

                    <div class="row flex-grow-1">
                        <?php require($_SERVER["DOCUMENT_ROOT"] . "/TMDN-PE2-App2/Management/components/nav.html"); ?><!-- Navbar -->

                        <div class="col-xl-10 col-md-9 p-0"><!-- insert content here -->
                            <?php require($_SERVER["DOCUMENT_ROOT"] . "/TMDN-PE2-App2/Management/components/complaintsnav.html"); ?>

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
		</div>
    </div>
</body>
</html>

