<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php");
    require_once(PHPSCRIPTDIR . "error.php");

    $employees = json_decode(file_get_contents("http://10.128.30.7:8080/api/employees"), true);
    $absences = json_decode(file_get_contents("http://10.128.30.7:8080/api/absences"), true);
    $acceptedRequests = getRequestsByAttribute($absences, "approved", 1);
    $nonAcceptedRequests = getRequestsByAttribute($absences, "approved", 0);

    function getRequestsByAttribute($leave, $attribute, $value)
    {
        $arr = array();

        foreach($leave as $request)
        {
            if ($request[$attribute] == $request);
                array_push($arr, $request);
        }

        return $arr;
    }

    function echoMonthlyLeaveReport($employees, $leave)
    {
        //I'll shortly explain what this trainwreck of a function does
        //It generates a table of the employees and their availability for the upcoming 31 days.
        //It does this by iterating over the absences and then fetching the relevant information from the employees.
        //A table is created to show all this information in a clean way.
        //The code has been divided with { and } to hopefully make things more clear.

        //Create DateTime object of today
        $today = new DateTime("now");
        $leaveReportIndex = 0;

        //Set up table and 2 table headers
        //This was all made before I knew you can write HTML "between" php brackets
        {
            $table = "<table class='table table-hover table-sm text-center'>";
            $theadrow1 = "<thead><tr class='table-head'><th>Month</th><th></th>";
            $theadrow2 = "<thead><tr><th>Employee</th><th>Days</th>";
            $tbody = "<tbody>";

            //Set up the 2 table headers which contain <Month, Day> and <EmployeeName, Days> respectively
            for ($i = 0; $i < 31; $i++)
            {
                $theadrow1 .= "<th>" . $today->format("D") . "</th>";
                $theadrow2 .= "<th>" . $today->format("d") . "</th>";

                $today->add(new DateInterval("P1D"));
            }

            //Close off the table headers
            $theadrow1 .= "</tr></thead>";
            $theadrow2 .= "</tr></thead>";

            //And add them to the table
            $table .= $theadrow1;
            $table .= $theadrow2;
        }

        //We redeclare the $today variable because it has been incremented by 31 days.
        $today = new DateTime("now");
        $nextmonth = new DateTime("now");
        $nextmonth->add(new DateInterval("P1M"));

        //Give each cell in the table a red or green color, depending on the availability of the employee
        {
            foreach($leave as $period)
            {
                $dateiterator = new DateTime("now");
                $startdate = new DateTime($period["startDate"]);
                $enddate = new DateTime($period["endDate"]);

                $employee = $employees[$period["employeeID"] - 1];
                $row = "<tr><td>" . $employee["employeeFirstName"] . " " . $employee["employeeLastName"] . "</td>";
                $row .= "<td>" . $startdate->diff($enddate)->format("%a") . "</td>";

                //If the Daterange starts before the end of the interval and ends after today
                if ($startdate <= $nextmonth && $enddate >= $today) //fill row with active and non active days
                {
                    echo "in range";
                    for ($i = 0; $i < 31; $i++)
                    {
                        if ($dateiterator >= $startdate && $dateiterator <= $enddate)
                            $row .= "<td class='bg-danger'></td>";
                        else
                            $row .= "<td class='bg-success'></td>";

                        $dateiterator->add(new DateInterval("P1D"));
                    }
                }
                else //fill row with active days
                {
                    for ($i = 0; $i < 31; $i++)
                    {
                        $row .= "<td class='bg-success'></td>";
                    }
                }

                $tbody .= $row;

                $leaveReportIndex++;
                if ($leaveReportIndex > 12)
                    break;
            }

            $tbody .= "</tbody>";
        }

        $table .= $tbody; //Add generated body to the table
        $table .= "</table>"; //And close it off

        echo $table;
    }
?>

<?php require(COMPONENTSDIR . COMPONENT_HRHEAD); ?>
    <title>Leave</title>
</head>
<?php require(COMPONENTSDIR . COMPONENT_HR_BODY_TOP); ?>
    <?php require(COMPONENTSDIR . COMPONENT_LEAVENAV); ?>

    <div class="row">
        <div class="recentdiv col-12">
            <table id="leave-recent" class="table table-hover table-sm">
                <thead>
                    <tr class="table-head">
                        <th colspan="5">New Leave Requests</th>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Days</th>
                        <th>Request Date</th>
                        <th>Period</th>
                        <th>Approve</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $r = 0;

                        foreach ($nonAcceptedRequests as $period)
                        {
                            $fullName = $employees[$period["employeeID"] - 1]["employeeFirstName"] . " " . $employees[$period["employeeID"] - 1]["employeeLastName"];
                            $dateStart = new DateTime($period["startDate"]);
                            $dateEnd = new DateTime($period["endDate"]);
                    ?>

                    <tr>
                        <td><?= $fullName; ?></td>
                        <td><?= $dateStart->diff($dateEnd)->format("%a"); ?></td>
                        <td><?php $creationDate = new DateTime($period["created_at"]); echo $creationDate->format("Y-m-d"); ?></td>
                        <td><?= $dateStart->format("Y-m-d") . " | " . $dateEnd->format("Y-m-d"); ?></td>
                        <td>&#10003; &#10007;</td>
                    </tr>

                    <?php
                        // TODO: remove this, replace with non approved leave requests
                        $r++;
                        if ($r > 4)
                            break;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="calendar col-12">
            <?php echoMonthlyLeaveReport($employees, $acceptedRequests); ?>
        </div>
    </div>
<?php require(COMPONENTSDIR . COMPONENT_BODY_BOTTOM); ?>
