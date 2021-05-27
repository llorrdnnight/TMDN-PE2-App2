<?php
    if (!isset($_SESSION)) { session_start(); };
    
    require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php");
    require_once(PHPSCRIPTDIR . "error.php");    
    
    if (!isset($_SESSION["employee_id"]))   
        header("Location: ../login.php");

        postData();
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
        }

        //insert form data into postData here
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

    function postData()
    {
        $curl = curl_init();
        $url = "http://10.128.30.7:8080/api/tickets";
        $data = array(
            "subject" => "testTicket", 
            "description" => "testDescription",
            "priority" => 3,
            "startDate" => "1984-06-20 16:17:52",
            "endDate" => "1987-01-04 05:12:27",
            "lockedUntil" => "2019-04-05 06:16:54",
            "lockedById" => 354,
            "categoryId" => 9,
            "assignedEmployeeId" => 272,
            "stateId" => 3,
            "userId" => 5,
            "isCustomer" => 0,
            "created_at" => "2021-05-22T16:03:52.000000Z",
            "updated_at" => "2021-05-22T16:03:52.000000Z"
        );

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        curl_setopt($curl, CURLOPT_POST, 1);                                                            // SET Method as a POST
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);                                                  // Pass user data in POST command
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response  = curl_exec($curl);                                                                  // Execute curl and assign returned data
        curl_close($curl);                                                                              // Close curl

        if (!$response)
            return false;
        
        return true;
    }
?>

<?php require(COMPONENTSDIR . COMPONENT_MANAGEMENTHEAD); ?>
    <title>Complaints - Register</title>
</head>
<?php require(COMPONENTSDIR . COMPONENT_MANAGEMENT_BODY_TOP); ?>
    <?php require(COMPONENTSDIR . COMPONENT_COMPLAINTSNAV); ?>

    <div class="container-fluid">
        <div class="col-lg-12">
            <div id="registercomplaints">
                <h1>Register New Complaint</h1>

                <form name="rcform" action="registercomplaint.php" method="POST" class="needs-validation">
                    <div class="form-row">
                        <div class="form-group col-12 col-lg-4">
                            <label for="subject">Subject</label><input name="subject" type="text" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-12 col-lg-12">
                            <label for="description">Description</label><textarea name="subject" class="form-control" required></textarea>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-12 col-lg-6">
                            <label for="priority">priority</label><input name="subject" type="text" class="form-control" required>
                        </div>

                        <div class="form-group col-12 col-lg-6">
                            <label for="categoryId">Category ID</label><input name="categoryId" type="text" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-12 col-lg-6">
                            <label for="assignedEmployeeId">Assigned Employee</label><input name="assignedEmployeeId" type="number" class="form-control" required>
                        </div>

                        <div class="form-group col-12 col-lg-6">
                            <label for="userId">User ID</label><input name="userId" type="number" class="form-control" required value=<?= $_SESSION["employee_id"]; ?> disabled>
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
<?php require(COMPONENTSDIR . COMPONENT_BODY_BOTTOM); ?>