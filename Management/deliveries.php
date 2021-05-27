<?php
    if (!isset($_SESSION)) { session_start(); };
    
    require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php");
    require_once(PHPSCRIPTDIR . "error.php");    
    
    if (!isset($_SESSION["employee_id"]))
        header("Location: login.php");
    
    $deliveries = json_decode(file_get_contents("http://10.128.30.7:8080/api/parcels"), true)["data"];
    $shipments = json_decode(file_get_contents("http://10.128.30.7:8080/api/shipments"), true)["data"];
    $flights = json_decode(file_get_contents("http://10.128.30.7:8080/api/flights"), true)["data"];

    $rows = array();
    $page = 1; 
    $maxrows = 12;
    $index = 0; //too lazy to change the foreach loop down below to an indexed for loop.

    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        $filteredjson = getFilteredArray($deliveries);
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
        $totalitems = count($deliveries);
        $totalpages = ceil($totalitems / $maxrows);
        $rows = $deliveries;
    }

    function getFilteredArray($arr)
    {
        // Deze functie wordt enkel gecalld 
        $filteredArray = array();
        $filterList = array("shipmentId", "flightId", "parcelTypeId", "priority", "isAllocated");
        //num, num, num, string, date, date, bool

        foreach ($arr as $item) //Push items in filtered array depending on their values
        {
            $push = true;

            // We can compare every value naturally except for DateTime
            if (isset($_GET["deptTime"]))
            {
                $itemtime = new DateTime($item["created_at"]);
                $push = $itemtime->format("H:i") == $_GET["createdAt"];
            }

            if (isset($_GET["arrivalTime"]))
            {
                $itemtime = new DateTime($item["updated_at"]);
                $push = $itemtime->format("H:i") == $_GET["updatedAt"];
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

    function echoPageIndex($totalpages)
    {
        $FilterLink = "";
        $FilterList = array("shipmentId", "flightId", "parcelTypeId", "priority", "isAllocated");

        foreach($FilterList as $Filter)
        {   
            if (isset($_GET[$Filter]))
                $FilterLink .= '&' . $Filter . '=' . $_GET[$Filter];
        }

        for ($i = 0; $i < $totalpages; $i++)
        {   
            echo "<li class='page-item'><a class='page-link' href='deliveries.php?Page=" . ($i + 1) . $FilterLink . "'>" . ($i + 1) . "</a></li>";
        }
    }
?>

<?php require(COMPONENTSDIR . COMPONENT_MANAGEMENTHEAD); ?>
    <script src=<?= HTMLJAVASCRIPT . "expandrow.js"; ?>></script>
    <script src=<?= HTMLJAVASCRIPT . "cleanForm.js"; ?>></script>
    <title>Deliveries</title>
</head>
<?php require(COMPONENTSDIR . COMPONENT_MANAGEMENT_BODY_TOP); ?>
    <form id="deliveryfilter" class="col-lg-12 pt-3 g-0">
        <div>
            <div class="btn-group col-xl-2 col-8 p-0 pr-2">
                <button class="btn btn-success" type="submit">Filter</button>
                <button class="btn btn-secondary" type="reset">Reset</button>
            </div>
            <div class="col-xl-2 col-4 p-0 pl-2 float-right">
                <span><?php echo "Total items: " . $totalitems ?></span>
            </div>
        </div>

        <div class="form-row pt-2">
            <div class="form-group col-lg-2 col-sm-4">
                <label for="shipmentId">Order ID</label>
                <input class="form-control" name="shipmentId" type="number">
            </div>

            <div class="form-group col-lg-2 col-sm-4">
                <label for="flightId">Flight ID</label>
                <input class="form-control" name="flightId" type="number">
            </div>

            <div class="form-group col-lg-2 col-sm-4">
                <label for="parcelTypeId">Package Type ID</label>
                <input class="form-control" name="parcelTypeId" type="number">
            </div>

            <div class="form-group col-lg-2 col-sm-4">
                <label for="priority">Priority</label>
                <input class="form-control" name="priority" type="text">
            </div>

            <div class="form-group col-lg-2 col-sm-4">
                <label for="createdAt">Created At</label>
                <input class="form-control" name="createdAt" type="date">
            </div>

            <div class="form-group col-lg-2 col-sm-4">
                <label for="updatedAt">Updated At</label>
                <input class="form-control" name="updatedAt" type="date">
            </div>
            <?php echo "<input name='Page' type='hidden' value='" . $page . "'>"; ?>
        </div>
    </form>

    <div class="col-12 pt-2 g-0"><!-- Todo: justify page index to bottom of page -->
        <?php if ($totalitems) { ?>
            <table id="deliveriestable" class="table table-hover table-responsive">
                <thead>
                    <tr>
                        <th></th>
                        <th>Order ID</th>
                        <th>Flight ID</th>
                        <th>Package Type ID</th>
                        <th>Priority</th>
                        <th>Creation Date</th>
                        <th>Last Updated On</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $delivery) {
                        switch ($shipments[$delivery["shipmentId"] - 1]["statusId"] % 2)
                        {
                            case 1: $tdclass = "delivered"; break;
                            case 2: $tdclass = "onhold"; break;
                            case 3: $tdclass = "notdelivered"; break;
                            default: $tdclass = "notdelivered"; break;; 
                        }
                    ?>

                        <tr class="expandrow">
                            <td class='<?= "deliverystatus w-1 " . $tdclass; ?>'></td>
                            <td><?= $delivery["shipmentId"]; ?></td>
                            <td><?= $delivery["flightId"]; ?></td>
                            <td><?= $delivery["parcelTypeId"]; ?></td>
                            <td><?= $delivery["priority"]; ?></td>
                            <td><?= $delivery["created_at"]; ?></td>
                            <td><?= $delivery["updated_at"]; ?></td>
                        </tr>

                        <tr class="collapserow">
                            <td colspan="7">
                                <div class="row m-0 p-0">         
                                    <div class="col-6">
                                        <div class="card">
                                            <div class="card-header bg-blue">
                                                <span>Shipment Information</span>
                                            </div>
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">Departure Time Stamp: <?= gmdate("Y-m-d\TH:i:s\Z", $shipments[$index]["departureTimeStamp"]); ?></li>
                                                <li class="list-group-item">Departure Time Stamp: <?= gmdate("Y-m-d\TH:i:s\Z", $shipments[$index]["arrivalTimeStamp"]); ?></li>
                                            </ul>
                                        </div>

                                        <div class="card mt-3">
                                            <div class="card-header bg-blue">
                                                <span>Package Information</span>
                                            </div>
                                            <ul class="list-group list-group-item-flush">
                                                <li class="list-group-item">Height: <?= $delivery["height"]; ?></li>
                                                <li class="list-group-item">Width: <?= $delivery["width"]; ?></li>
                                                <li class="list-group-item">Length: <?= $delivery["length"]; ?></li>
                                                <li class="list-group-item">Weight: <?= $delivery["weight"]; ?></li>
                                            </ul>
                                        </div>
                                    </div>    

                                    <div class="col-6">
                                        <div class="card">
                                            <div class="card-header bg-blue">
                                                <span>Flight Information</span>
                                            </div>

                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">Flight number: <?= $flights[$index]["flightNumber"]; ?></li>
                                                <li class="list-group-item">Departure Airport: <?= $flights[$index]["depAirport"]; ?></li>
                                                <li class="list-group-item">Destination Airport: <?= $flights[$index]["destAirport"]; ?></li>
                                                <li class="list-group-item">Reserved Weight: <?= $flights[$index]["reservedWeight"]; ?></li>
                                                <li class="list-group-item">Reserved Volume: <?= $flights[$index]["reservedVolume"]; ?></li>
                                                <li class="list-group-item">Airline: <?= $flights[$index]["airlineName"]; ?></li>
                                                <li class="list-group-item">Last Updated On: <?= $flights[$index]["updated_at"]; ?></li>
                                            </ul>
                                        </div>
                                    </div>  
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php $index++; } else { echo "No deliveries found."; } ?>

        <nav aria-label="Page navigation" class="d-flex justify-content-center">
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>
                <?php echoPageIndex($totalpages); ?>
                <li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>
            </ul>
        </nav>
    </div>
<?php require(COMPONENTSDIR . COMPONENT_BODY_BOTTOM); ?>