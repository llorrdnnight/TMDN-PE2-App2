<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php");
    require_once(PHPSCRIPTDIR . "error.php");

    $employees = json_decode(file_get_contents("http://10.128.30.7:8080/api/employees"), true);
    $absences = json_decode(file_get_contents("http://10.128.30.7:8080/api/absences"), true);

    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        if (isset($_GET["id"]))
        {
            $absence = $absences[$_GET["id"] - 1];
            $employee = $employees[$absence["employeeID"] - 1];
        }
        else
        {
            header("Location: leave.php");
        }
    }
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $absence = $absences[$_GET["id"] - 1];
        $employee = $employees[$absence["employeeID"] - 1];
        $attributes = ["employeeName", "startDate", "endDate", "reason", "leaveType", "approved"];

        foreach($attributes as $attribute)
        {
            if (isset($_POST[$attribute]))
            {
                $employee[$attribute] = $_POST[$attribute];
            }
        }

        $options = array(
            "http" => array(
                "header"  => "Content-type: application/x-www-form-urlencoded\r\n",
                "method"  => "POST",
                "content" => http_build_query($data)
            )
        );


        $context  = stream_context_create($options);
        var_dump($options);
        //$result = file_get_contents($url, false, $context);
        //if ($result === FALSE) { /* Handle error */ }
            //var_dump($result);

        header("Location: leave.php");
    }
    else
    {
        header("Location: leave.php");
    }

    function getLeaveType($number)
    {
        switch ($number)
        {
            case 1: return "Absence";
            case 2: return "Leave";
            default: return "Other";
        }
    }
?>

<?php require(COMPONENTSDIR . COMPONENT_HRHEAD); ?>
    <title>Edit Leave</title>
    <script src=<?= HTMLJAVASCRIPT . "suggestEmployees.js"; ?>></script>
    <link rel="stylesheet" href=<?= HTMLCSS . "newLeave.css"; ?> type="text/css">
</head>
<?php require(COMPONENTSDIR . COMPONENT_HR_BODY_TOP); ?>
    <?php require(COMPONENTSDIR . COMPONENT_LEAVENAV); ?>

    <div class="container-fluid">
        <div class="col-lg-12">
            <div id="editcomplaint">
                <h1>Edit Leave</h1>
                <form name="elform" action="editLeave.php" method="POST">
                    <div class="form-row">
                        <div class="form-group col-12 col-lg-6">
                            <label for="id">Leave ID:</label><input class="form-control" name='id' type="number" value=<?= $absence["id"]; ?> disabled>
                            <label for="startDate">Start Date</label><input id="employees" class="form-control" name='startDate' type="date" value=<?= $absence["startDate"]; ?>>
                        </div>

                        <div class="form-group col-12 col-lg-6">
                            <label for="subject">Employee ID: </label><input class="form-control" name="subject" type="number" value=<?= $absence["employeeID"]; ?>>
                            <label for="endDate">End Date</label><input class="form-control" name='endDate' type="date" value=<?= $absence["endDate"]; ?>>
                        </div>

                        <div class="form-group col-6 col-lg-12">
                            <label for="reason">Reason</label><input class="form-control" name="reason" type="text" value='<?= $absence["reason"]; ?>'>
                            <label for="leaveType">Leave Type</label><input class="form-control" name="leaveType" type="text" value=<?= getLeaveType($absence["leaveType"]) ?>>
                            <label for="approved">Approved</label><input class="form-control" name="approved" type="text" value=<?= $absence["approved"] == 1 ? "yes" : "no"; ?>>
                            <label for="created_at">Created At</label><input class="form-control" name="created_at" type="date" value=<?= $absence["created_at"]; ?>>
                            <label for="updated_at">Updated At</label><input class="form-control" name="updated_at" type="date" value=<?= $absence["updated_at"]; ?>>
                        </div>

                        <div class='form-group col-6'>
                            <div class="btn-group">
                                <button name='Submit' type='submit' class='btn btn-success'>Submit</button>
                                <button name='Reset' type='reset' class='btn btn-secondary'>Reset</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
