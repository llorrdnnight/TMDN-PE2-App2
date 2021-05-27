<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php");
    require_once(PHPSCRIPTDIR . "error.php");

    //Get temporary database file contents
    $opencomplaints = json_decode(file_get_contents("http://10.128.30.7:8080/api/tickets"), true)["data"];
    $opencomplaints = getComplaintsByAttribute($opencomplaints, "stateId", 2);

    //Declare empty array, the default page variable and the number of table rows
    $rows = array();
    $page = 1; $maxrows = 11;

    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        $filteredjson = getFilteredArray($opencomplaints);
        $totalitems = count($filteredjson);
        $totalpages = ceil($totalitems / $maxrows);

        //If a page is requested and is within the limits of our data array
        if (isset($_GET["Page"]) && $_GET["Page"] < $totalpages + 1)
            $page = $_GET["Page"];
        else
            $page = 1;

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
        $totalitems = count($openjson);
        $totalpages = ceil($totalitems / $maxrows);
        $rows = $openjson;
    }

    function getFilteredArray($arr)
    {
        $filteredArray = array();
        $filterList = array("id", "subject", "priority", "categoryId", "userId");
        //int, string, int, int, int, date

        foreach ($arr as $item) //Push items in filtered array depending on their values
        {
            $push = true;

            // We can compare every value naturally except for DateTime
            if (isset($_GET["created_at"]))
            {
                $itemtime = new DateTime($item["departureTimeStamp"]);
                $push = $itemtime->format("H:i") == $_GET["departureTime"];
            }

            foreach ($filterList as $filter)
            {
                if (isset($_GET[$filter]))
                    $push = $item[$filter] == $_GET[$filter];
            }

            if ($push)
                array_push($filteredArray, $item);
        }

        if (count($filteredArray))
            return $filteredArray;
        else
            return $arr;
    }

    function getComplaintsByAttribute($Complaints, $Attribute, $Value)
    {
        $arr = array();

        foreach ($Complaints as $Complaint)
        {
            if ($Complaint[$Attribute] == $Value)
                array_push($arr, $Complaint);
        }

        return $arr;
    }

    function echoPageIndex($totalpages)
    {
        echo "return statement in echoPageIndex";
        return;

        //It is required to echo the get variables into each page link
        $FilterLink = "";
        $FilterList = array("id", "subject", "priority", "categoryId", "userId");

        //That is why we iterate over them
        foreach($FilterList as $Filter)
        {
            if (isset($_GET[$Filter]))
                $FilterLink .= '&' . $Filter . '=' . $_GET[$Filter];
        }

        //And put them in each link
        for ($i = 0; $i < $totalpages; $i++)
        {
            echo "<li class='page-item'><a class='page-link' href='opencomplaints.php?Page=" . ($i + 1) . $FilterLink . "'>" . ($i + 1) . "</a></li>";
        }
    }
?>

<?php require(COMPONENTSDIR . COMPONENT_MANAGEMENTHEAD); ?>
    <script src=<?= HTMLJAVASCRIPT . "cleanForm.js"; ?>></script>
    <title>Complaints - Open</title>
</head>
<?php require(COMPONENTSDIR . COMPONENT_MANAGEMENT_BODY_TOP); ?>
    <?php require(COMPONENTSDIR . COMPONENT_COMPLAINTSNAV); ?>

    <form id="complaintsfilter" class="col-lg-12">
        <div>
            <div class="btn-group col-xl-2 p-0 pr-2">
                <button class="btn btn-success" type="submit">Filter</button>
                <button class="btn btn-secondary" type="reset">Reset</button>
            </div>
        </div>

        <div class="form-row mb-3 pt-2">
            <div class="col-lg-1 col-sm-4">
                <label for="ComplaintID">ComplaintID</label>
                <input class="form-control" name="id" type="number">
            </div>

            <div class="col-lg-3 col-sm-6">
                <label for="subject">Subject</label>
                <input class="form-control" name="subject" type="text">
            </div>

            <div class="col-lg-1 col-sm-4">
                <label for="priority">Priority</label>
                <input class="form-control" name="priority" type="number">
            </div>

            <div class="col-lg-1 col-sm-4">
                <label for="stateId">State ID</label>
                <input class="form-control" name="stateId" type="number">
            </div>

            <div class="col-lg-1 col-sm-4">
                <label for="categoryId">Category ID</label>
                <input class="form-control" name="categoryId" type="number">
            </div>

            <div class="col-lg-1 col-sm-4">
                <label for="userId">Employee ID</label>
                <input class="form-control" name="employeeId" type="number">
            </div>

            <div class="col-lg-2 col-sm-4">
                <label for="created_at">Created At</label>
                <input class="form-control" name="created_at" type="date">
            </div>

            <div class="col-lg-2 col-sm-4">
                <label for="daysOpen">Days Open</label>
                <input class="form-control" name="daysOpen" type="number">
            </div>

            <?php echo "<input name='Page' type='hidden' value='" . $page . "'>"; ?>
        </div>
    </form>

    <div class="col-lg-12 pt-2">
        <div id="opencomplaints">
            <table id='opencomplaintstable' class='table table-hover'><tr>
                <thead>
                    <tr class="d-flex">
                        <th class="col-1">Complaint ID</th>
                        <th class="col-3">Subject</th>
                        <th class="col-1">Priority</th>
                        <th class="col-1">State ID</th>
                        <th class="col-1">Category ID</th>
                        <th class="col-1">Employee ID</th>
                        <th class="col-2">Created At</th>
                        <th class="col-2">Days open</th></tr>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if (isset($_GET["id"]) && !empty($_GET["id"]))
                        {
                            foreach ($rows as $complaint)
                            {
                                if ($complaint["id"] == $_GET["id"]) { ?>
                                    <tr>
                                        <td class="complaintid col-1"><a href='<?= "./editcomplaint.php?id=" . $complaint["id"]; ?>'><?= $complaint["id"]; ?></a></td>
                                        <td class="col-3"><?= $complaint["subject"]; ?></td>
                                        <td class="col-1"><?= $complaint["priority"]; ?></td>
                                        <td class="col-1"><?= $complaint["stateId"]; ?></td>
                                        <td class="col-1"><?= $complaint["categoryId"]; ?></td>
                                        <td class="col-1"><?= $complaint["assignedEmployeeId"]; ?></td>
                                        <td class="col-2"><?= $complaint["created_at"]; ?></td>
                                        <td class="col-2"><?= "insert days open here"; ?></td>
                                    </tr>
                                <?php }
                            }
                        }
                        else
                        {
                            foreach ($rows as $complaint) { ?>
                                <!-- $Date = new DateTime($complaint["Date"]); -->
                                <!-- $Now = new DateTime("now"); -->
                                <!-- $DaysOpen =  $Now->diff($Date)->days; -->

                                <tr class="d-flex">
                                    <td class="complaintid col-1"><a href='<?= "./editcomplaint.php?id=" . $complaint["id"]; ?>'><?= $complaint["id"]; ?></a></td>
                                    <td class="col-3"><?= $complaint["subject"]; ?></td>
                                    <td class="col-1"><?= $complaint["priority"]; ?></td>
                                    <td class="col-1"><?= $complaint["stateId"]; ?></td>
                                    <td class="col-1"><?= $complaint["categoryId"]; ?></td>
                                    <td class="col-1"><?= $complaint["assignedEmployeeId"]; ?></td>
                                    <td class="col-2"><?= $complaint["created_at"]; ?></td>
                                    <td class="col-2"><?= "insert days open here"; ?></td>
                                </tr>
                            <?php }
                        }
                    ?>
                </tbody>
            </table>

            <nav aria-label="Page navigation" class="d-flex justify-content-center">
                <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>
                    <?php echoPageIndex($totalpages); ?>
                    <li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>
                </ul>
            </nav>
        </div>
    </div>
<?php require(COMPONENTSDIR . COMPONENT_BODY_BOTTOM); ?>
