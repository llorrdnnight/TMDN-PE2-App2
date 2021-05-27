<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php");
    require_once(PHPSCRIPTDIR . "error.php");

    $employees = json_decode(file_get_contents("http://10.128.30.7:8080/api/employees"), true);
    $absences = json_decode(file_get_contents("http://10.128.30.7:8080/api/absences"), true);

    //Declare empty array, the default page variable and the number of table rows
    $rows = array();
    $page = 1;
    $maxrows = 11;

    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        $filteredjson = getFilteredArray($absences);
        $totalitems = count($filteredjson);
        $totalpages = ceil($totalitems / $maxrows);

        //If a page is requested and is within the limits of our data array
        if (isset($_GET["Page"]) && $_GET["Page"] < $totalpages + 1)
            $page = $_GET["Page"];

        $rowsleft = $maxrows;
        if ($page * $maxrows > $totalitems)
            $rowsleft = $totalitems - (($page - 1) * $maxrows);

        for ($i = ($page - 1) * $maxrows; $i < $page * $maxrows; $i++)
        {
            if ($rowsleft)
            {
                array_push($rows, $filteredjson[$i]);
                $rowsleft -= 1;
            }
        }
    }
    else
    {
        $totalitems = count($json["TimeOff"]);
        $totalpages = ceil($totalitems / $maxrows);
        $rows = $json["TimeOff"];
    }

    function getFilteredArray($arr)
    {
        $FilteredArray = array();
        $FilterList = array("PickupTime", "Location", "DeliveryID", "Status", "Company", "ReceiptID");

        foreach($FilterList as $Filter)
        {
            if (isset($_GET[$Filter]))
            {
                foreach($arr as $item)
                {
                    if ($item[$Filter] == $_GET[$Filter])
                        array_push($FilteredArray, $item);
                }
            }
        }

        if (count($FilteredArray) > 0)
            return $FilteredArray;
        else
            return $arr;
    }

    function echoLeave($absences, $employees)
    {
        $index = 0;
        foreach ($absences as $leave)
        {
            //Table row
            $row = "";
            $row .= "<tr>";
            $row .= "<td class='col-1'>" . $leave["employeeID"] . "</td>";
            $row .= "<td class='col-1'>" . $employees[$leave["employeeID"] - 1]["employeeFirstName"] . "</td>";
            $row .= "<td class='col-1'>" . $employees[$leave["employeeID"] - 1]["employeeLastName"] . "</td>";
            $row .= "<td class='col-1'>" . $leave["created_at"] . "</td>";
            $row .= "<td class='col-1'>" . $leave["startDate"] . "</td>";
            $row .= "<td class='col-1'>" . $leave["endDate"] . "</td>";
            $row .= "<td class='col-1'>" . "insert type" . "</td>";
            $row .= "<td class='col-1'><a href='editLeave.php?id=" . ($index + 1) . "'><button class='btn btn-success'>Edit</button></a></td>";
            $row .= "<td class='col-1'><button class='btn btn-danger'>Delete</button></td>";
            $row .= "</tr>";

            $index++;
            echo $row;
        }
    }

    function echoPageIndex($totalpages)
    {
        // $FilterLink = "";
        // $FilterList = array("PickupTime", "Location", "DeliveryID", "Status", "Company", "ReceiptID");

        // foreach($FilterList as $Filter)
        // {
        //     if (isset($_GET[$Filter]))
        //         $FilterLink .= '&' . $Filter . '=' . $_GET[$Filter];
        // }

        // for ($i = 0; $i < $totalpages; $i++)
        // {
        //     echo "<li class='page-item'><a class='page-link' href='deliveries.php?Page=" . ($i + 1) . $FilterLink . "'>" . ($i + 1) . "</a></li>";
        //     // else
        //     // echo "<li class='page-item'><a class='page-link' href='deliveries.php?Page=" . ($i + 1) . "'>" . ($i + 1) . "</a></li>";
        // }
    }
?>

<?php require(COMPONENTSDIR . COMPONENT_HRHEAD); ?>
    <title>Leave List</title>
</head>
<?php require(COMPONENTSDIR . COMPONENT_HR_BODY_TOP); ?>
    <?php require(COMPONENTSDIR . COMPONENT_LEAVENAV); ?>

    <table id="leavetable" class="table table-hover table-sm">
        <thead>
            <tr>
                <th>EmployeeID</th>
                <th>Surname</th>
                <th>Firstname</th>
                <th>RequestDate</th>
                <th>From</th>
                <th>Until</th>
                <th>Type</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php echoLeave($absences, $employees); ?>
        </tbody>
    </table>

    <!-- <nav aria-label="Page navigation" class="d-flex justify-content-center">
        <ul class="pagination">
            <li class="page-item"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>
            <?php //echoPageIndex($totalpages); ?>
            <li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>
        </ul>
    </nav> -->
<?php require(COMPONENTSDIR . COMPONENT_BODY_BOTTOM); ?>
