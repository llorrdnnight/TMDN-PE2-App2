<?php
// session_start();
// // Check if the session is set else redirect to login page
// if (isset($_SESSION['employee_id'])){}

// else
// header("Location: login.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/TMDN-PE2-App2/PATHS.PHP");
    
    //Get temporary database file contents
    $json = json_decode(file_get_contents("database.json"), true);
    $rows = array();
    $page = 1; 
    $maxrows = 12;

    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        $filteredjson = getFilteredArray($json["Deliveries"]);
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
        $totalitems = count($json["Deliveries"]);
        $totalpages = ceil($totalitems / $maxrows);
        $rows = $json["Deliveries"];
    }

    function getFilteredArray($arr)
    {
        // Deze functie wordt enkel gecalld 
        $FilteredArray = array();
        $FilterList = array("Location", "DeliveryID", "Status", "Company", "ReceiptID");

        foreach ($arr as $item)
        {
            $push = true;

            // We can compare every value naturally except for DateTime
            if (isset($_GET["PickupTime"]))
            {
                $itemtime = new DateTime($item["PickupTime"]);
                $push = $itemtime->format("H:i") == $_GET["PickupTime"];
            }

            foreach ($FilterList as $Filter)
            {
                if (isset($_GET[$Filter]))
                    $push = $item[$Filter] == $_GET[$Filter];
            }

            if ($push)
                array_push($FilteredArray, $item);
        }
        
        if (count($FilteredArray))
            return $FilteredArray;
        else
            return $arr;
    }

    function echoDeliveries($Deliveries)
    {
        foreach ($Deliveries as $Delivery)
        {
            //Row status colour
            if ($Delivery["Status"] == "Delivered")
                $tdclass = "delivered";
            elseif ($Delivery["Status"] == "On Hold")
                $tdclass = "onhold";
            else
                $tdclass = "notdelivered";

            //Table row
            $row = "";
            $row .= "<tr class='expandrow'>";
            $row .= "<td class='deliverystatus " . $tdclass . " w-1'></td>";
            $row .= "<td>" . $Delivery["PickupTime"] . "</td>";
            $row .= "<td>" . $Delivery["Location"] . "</td>";
            $row .= "<td>" . $Delivery["DeliveryID"] . "</td>";
            $row .= "<td>" . $Delivery["Status"] . "</td>";
            $row .= "<td>" . $Delivery["Company"] . "</td>";
            $row .= "<td>" . $Delivery["ReceiptID"] . "</td>";
            $row .= "</tr>";

            //Details row
            $row .= "<tr class='collapserow'>";
            $row .= "<td colspan='7'>";
            $row .= "<div>";

            //Small dropdown menu for delivery details. Needs to include more information.
            foreach($Delivery as $key => $value)
            {
                $row .= "<p>" . $key . ": " . $value . "</p>";
            }

            $row .= "</div></td></tr>";

            echo $row;
        }
    }

    function echoPageIndex($totalpages)
    {
        $FilterLink = "";
        $FilterList = array("PickupTime", "Location", "DeliveryID", "Status", "Company", "ReceiptID");

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

<?php require(COMPONENTSDIR . COMPONENT_HEAD); ?>
    <script src=<?= HTMLJAVASCRIPT . "expandrow.js"; ?>></script>
    <script src=<?= HTMLJAVASCRIPT . "cleanForm.js"; ?>></script>
    <title>Deliveries</title>
</head>
<?php require(COMPONENTSDIR . COMPONENT_BODY_TOP); ?>
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
                <label for="PickupTime">Pickup Time</label>
                <input class="form-control" name="PickupTime" type="time">
            </div>

            <div class="form-group col-lg-2 col-sm-4">
                <label for="Location">Location</label>
                <input class="form-control" name="Location" type="text">
            </div>

            <div class="form-group col-lg-2 col-sm-4">
                <label for="DeliveryID">Delivery ID</label>
                <input class="form-control" name="DeliveryID" type="number">
            </div>

            <div class="form-group col-lg-2 col-sm-4">
                <label for="Status">Status</label>
                <select class="form-control" name="Status">
                    <option hidden disabled selected value>-</option>
                    <option value="Delivered">Delivered</option>
                    <option value="On Hold">On Hold</option>
                    <option value="Not Delivered">Not Delivered</option>
                </select>
            </div>

            <div class="col-lg-2 col-sm-4">
                <label for="Company">Company</label>
                <input class="form-control" name="Company" type="text">
            </div>

            <div class="col-lg-2 col-sm-4">
                <label for="ReceiptID">Receipt ID</label>
                <input class="form-control" name="ReceiptID" type="number">
            </div>

            <?php echo "<input name='Page' type='hidden' value='" . $page . "'>"; ?>
        </div>
    </form>

    <div class="col-12 g-0 pt-2">
        <table id="deliveriestable" class="table table-hover table-responsive">
            <thead>
                <tr>
                    <th></th>
                    <th>Pickup Time</th>
                    <th>Location</th>
                    <th>Delivery ID</th>
                    <th>Status</th>
                    <th>Company</th>
                    <th>Receipt ID</th>
                </tr>
            </thead>
            <tbody>
                <?php echoDeliveries($rows); ?>
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
<?php require(COMPONENTSDIR . COMPONENT_BODY_BOTTOM); ?>