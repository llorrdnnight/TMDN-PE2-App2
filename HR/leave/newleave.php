<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php");
    require_once(PHPSCRIPTDIR . "error.php");

    postData();

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // $employees = json_decode(file_get_contents("http://10.128.30.7:8080/api/employees"), true);
        // $absences = json_decode(file_get_contents("http://10.128.30.7:8080/api/absences"), true);

        // $leaveSize = count($absences);
        // $employeeName = $_POST["employeeName"];
        // $employeeID = findInEmployees($employeeName);
        // $now = gmdate("Y-m-d\TH:i:s\Z");
    }

    function findInEmployees($employeeName)
    {
        return 0;
    }

    function postData()
    {
        $curl = curl_init();
        $url = "http://10.128.30.7:8080/api/tickets";
        $data = array(
            "employeeId" => 20,
            "startDate" => "2019-07-13 04:11:43",
            "endDate" => "2021-04-09 08:48:04",
            "reason" => "dog is sick",
            "leaveType" => 1,
            "approved" => 1,
            "created_at" => "2021-05-22T16:03:55.000000Z",
            "updated_at" => "2021-05-22T16:03:55.000000Z",
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

<?php require(COMPONENTSDIR . COMPONENT_HRHEAD); ?>
    <script src=<?= HTMLJAVASCRIPT . "addRows.js"; ?>></script>
    <script src=<?= HTMLJAVASCRIPT . "suggestEmployees.js"; ?>></script>
    <link rel="stylesheet" href=<?= HTMLCSS . "newLeave.css"; ?> type="text/css">
    <title>Leave List</title>
</head>
<?php require(COMPONENTSDIR . COMPONENT_HR_BODY_TOP); ?>
    <?php require(COMPONENTSDIR . COMPONENT_LEAVENAV); ?>

    <form name="nlform" action="newLeave.php" method="POST" class="needs-validation pt-3 col-lg-12 g-0" autocomplete="off">
        <div class="form-row mb-2">
            <!-- <div class="col-lg-2 mb-0">
                <select id="branch" class="form-control">
                    <option selected disabled>Select Office or Branch</option>
                    <option>test</option>
                </select>
            </div> -->

            <div class="col-lg-2">
                <input id="employees" name="employeeName" type="text" class="form-control" placeholder="Employee">
            </div>

            <div class="col-lg-8"></div>

            <div class="col-lg-2">
                <input type="button" class="btn btn-success form-control" value="submit">
            </div>
        </div>

        <div class="form-row">
            <div class="col-lg-2">
                <input id="Periods" name="Periods" type="text" class="form-control" value="1" disabled>
            </div>

            <div class="col-lg-1">
                <input id="button-addcolumn" class="form-control btn btn-success" type="button" value="Add">
            </div>

            <div class="col-lg-1">
                <input id="button-removecolumn" class="form-control btn btn-danger" type="button" value="Remove">
            </div>

            <div class="col-lg-6"></div>

            <div class="col-lg-2">
                <input type="reset" class="btn btn-secondary form-control" value="reset">
            </div>
        </div>

        <div class="form-row pt-5">
            <table id="table-leave" class="table table-hover">
                <thead>
                    <tr>
                        <th>Row</th>
                        <th>Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Amount Of Days</th>
                        <th>Description (Optional)</th>
                    </tr>
                </thead>
                <tbody id="table-leave-tbody">
                    <tr>
                        <td>1</td>
                        <td>
                            <select>
                                <option selected>Leave</option>
                                <option>Sick</option>
                                <option>Other</option>
                            </select>
                        </td>
                        <td><input type="date"></td>
                        <td><input type="date"></td>
                        <td><input type="text" disabled placeholder="0"></td>
                        <td><input type="text"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </form>
<script>
$(document).ready(function()
{
    var employeeArr = [];

    $.ajax(
        {
            url: "http://10.128.30.7:8080/api/employees",
            dataType: "json",
            success: function(Result)
            {
                Result.forEach(element => {
                    var employeeName = element.employeeFirstName + " " + element.employeeLastName;
                    employeeArr.push(employeeName);
                });

                console.log(employeeArr);
            }
    });

    autocomplete(document.getElementById("employees"), employeeArr);
});
</script>
<?php require(COMPONENTSDIR . COMPONENT_BODY_BOTTOM); ?>
