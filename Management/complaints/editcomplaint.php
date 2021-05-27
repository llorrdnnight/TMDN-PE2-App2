<?php
    if (!isset($_SESSION)) { session_start(); };
    
    require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php");
    require_once(PHPSCRIPTDIR . "error.php");    
    
    if (!isset($_SESSION["employee_id"]))
        header("Location: ../login.php");  
    
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"]))
    {
        if (!empty($_GET["id"]))
        {
            $id = $_GET["id"];
            $complaints = json_decode(file_get_contents("http://10.128.30.7:8080/api/tickets"), true)["data"];

            $index = in_array_recursive($id, $complaints);
            $complaint = $complaints[$index];
        }
    }
    else
    {
        header("Location: complaints.php");
    }

    function in_array_recursive($needle, $haystack) //We look for the correct id in the array. It is possible an id does not exist. In that case, we exit.
    {
        $index = 0;

        foreach($haystack as $item)
        {
            if ($item["id"] == $needle)
                return $index;
            $index++;
        }

        exit("<h3>The requested index complaint index does not exist.</h3>");
    }

    function putData()
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
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
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
    <title>Complaints - Edit</title>
</head>
<?php require(COMPONENTSDIR . COMPONENT_MANAGEMENT_BODY_TOP); ?>
    <?php require(COMPONENTSDIR . COMPONENT_COMPLAINTSNAV); ?>

    <div class="container-fluid">
        <div class="col-lg-12">
            <div id="editcomplaint">
                <h1>Edit Complaint</h1>
                <form name='ecform'action='editcomplaint.php' method='POST'>
                    <div class='form-row'>
                        <div class="form-group col-lg-6">
                            <label for="id">Complaint ID:</label><input class="form-control" name='id' type="text" value=<?= $complaint["id"]; ?> disabled>
                            <label for="subject">Subject</label><input class="form-control" name="subject" type="text" value=<?= $complaint["subject"]; ?>>
                            <label for="description">Description</label><input class="form-control" name="description" type="text" value=<?= $complaint["description"]; ?>>
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="priority">Priority</label><input class="form-control" name='priority' type="number" value=<?= $complaint["priority"]; ?>>
                            <label for="startDate">Start Date</label><input class="form-control" name='startDate' type="date" value=<?= $complaint["startDate"]; ?>>
                            <label for="endDate">End Date</label><input class="form-control" name='endDate' type="date" value=<?= $complaint["endDate"]; ?>>
                        </div>

                        <div class="form-group col-lg-6">
                            <label for="categoryId">Category ID</label><input class="form-control" name="categoryId" type="text" value=<?= $complaint["categoryId"]; ?>>
                            <label for="stateId">State ID</label><input class="form-control" name="subjectId" type="text" value=<?= $complaint["stateId"]; ?>>
                            <label for="userId">User ID</label><input class="form-control" name="userId" type="text" value=<?= $complaint["userId"]; ?>>
                            <label for="isCustomer">Is Customer?</label><input class="form-control" name="isCustomer" type="text" value=<?= $complaint["isCustomer"]; ?>>
                        </div>                        
                    </div>

                    <div class='form-row'><div class='btn-group col-xl-2 p-0 pr-2'>
                        <button name='Submit' type='submit' class='btn btn-success'>Submit</button>
                        <button name='Reset' type='reset' class='btn btn-secondary'>Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php require(COMPONENTSDIR . COMPONENT_BODY_BOTTOM); ?>