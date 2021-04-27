<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/TMDN-PE2-App2/PATHS.PHP");

    $json = json_decode(file_get_contents(MANAGEMENTDIR . "database.json"), true);

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

<?php require(COMPONENTSDIR . COMPONENT_HEAD); ?>
    <title>Complaints - Edit</title>
</head>
<?php require(COMPONENTSDIR . COMPONENT_BODY_TOP); ?>
    <?php require(COMPONENTSDIR . COMPONENT_COMPLAINTSNAV); ?>

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
<?php require(COMPONENTSDIR . COMPONENT_BODY_BOTTOM); ?>