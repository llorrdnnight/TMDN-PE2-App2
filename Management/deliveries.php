<?php
    //Get temporary database file contents
    $json = json_decode(file_get_contents("database.json"), true);
    $filteredjson = getFilteredArray($json["Deliveries"]);

    $rows = array();
    $page = 1; $maxrows = 13;

    $totalitems = count($filteredjson);
    $totalpages = ceil($totalitems / $maxrows);

    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
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
                $add = true;
                
                //This is now done in the getFilteredArray function, but the value checking is not implemented yet.
                // if (isset($_GET["PickupTime"]) && !empty($_GET["PickupTime"]))
                //     if (substr($json["Deliveries"][$i]["PickupTime"], 0, 5) != $_GET["PickupTime"])
                //         $add = false;
                
                // if (isset($_GET["Location"]) && !empty($_GET["Location"]))
                //     if ($json["Deliveries"][$i]["Location"] != $_GET["Location"])
                //         $add = false;
                
                // if (isset($_GET["DeliveryID"]) && !empty($_GET["DeliveryID"]))
                //     if ($json["Deliveries"][$i]["DeliveryID"] != $_GET["DeliveryID"])
                //         $add = false;
                
                // if (isset($_GET["Status"]) && !empty($_GET["Status"]))
                //     if ($json["Deliveries"][$i]["Status"] != $_GET["Status"])
                //         $add = false;
                
                // if (isset($_GET["Company"]) && !empty($_GET["Company"]))
                //     if ($json["Deliveries"][$i]["Company"] != $_GET["Company"])
                //         $add = false;
                
                // if (isset($_GET["ReceiptID"]) && !empty($_GET["ReceiptID"]))
                //     if ($json["Deliveries"][$i]["ReceiptID"] != $_GET["ReceiptID"])
                //         $add = false;
                
                if ($add)
                {
                    array_push($rows, $filteredjson[$i]);
                    $rowsleft -= 1;
                }
            }
        }
    }
    else
    {
        $rows = $json["Deliveries"];
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
                    if ($item[$Filter] == $_GET[$Filter])
                        array_push($FilteredArray, $item);
            }   
        }

        if (count($FilteredArray) > 0)
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
            // else
            // echo "<li class='page-item'><a class='page-link' href='deliveries.php?Page=" . ($i + 1) . "'>" . ($i + 1) . "</a></li>";
        }
    }
?>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/Management/components/head/head.php"); ?>
<?php require($_SERVER["DOCUMENT_ROOT"] . "/Management/components/head/head-deliveries-bottom.html"); ?>
<body>
    <div id="wrapper" class="container-fluid h-100"> <!-- Page container -->
        <div class="row">
            <header class="col-lg-12"> <!-- Header class -->
                <h1><a href='deliveries.php'>Deliveries</a></h1>
            </header>
        </div>

        <div class="row"> <!-- Row class for nav and content columns -->
            <?php require("./components/nav.html"); ?>

            <div id="page-content-wrapper" class="col-xl-11 col-lg-10"> <!-- Separate wrapper for content -->
                <form id="deliveryfilter" class="col-lg-12 g-0">
                    <div>
                        <div class="btn-group">
                            <button class="btn btn-success" type="submit">Filter</button>
                            <button class="btn btn-secondary" type="reset">Reset</button>
                        </div>
                    </div>

                    <div class="form-row mb-3">
                        <div class="col-lg-2 col-sm-4">
                            <label for="PickupTime">Pickup Time</label>
                            <input class="form-control" name="PickupTime" type="time">
                        </div>

                        <div class="col-lg-2 col-sm-4">
                            <label for="Location">Location</label>
                            <input class="form-control" name="Location" type="text">
                        </div>

                        <div class="col-lg-2 col-sm-4">
                            <label for="DeliveryID">Delivery ID</label>
                            <input class="form-control" name="DeliveryID" type="number">
                        </div>

                        <div class="col-lg-2 col-sm-4">
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

                <div class="col-lg-12 g-0">
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
            </div>
        </div>
    </div>
</body>
</html>