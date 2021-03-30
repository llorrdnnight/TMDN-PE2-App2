<?php
    //Get temporary database file contents
    $json = json_decode(file_get_contents("database.json"), true);

    //Declare empty array, the default page variable and the number of table rows
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
    <script src="./scripts/javascript/expandRow.js"></script>
    <script src="./scripts/javascript/cleanForm.js"></script>
    <title>Deliveries</title>
</head>
<body>
    <div id="wrapper" class="container-fluid h-100"><!-- full body wrapper -->
        <div class="row h-100">
            <div class="col-12">
                <div class="d-flex flex-column h-100"><!-- content flexbox -->
                    <div class="row">
                        <div class="col-12 p-0">
                            <header><!-- insert header here -->
                                <h1 class="pl-2"><a href='deliveries.php'>Deliveries</a></h1>
                            </header>
                        </div>
                    </div>

                    <div class="row flex-grow-1">
                        <?php require($_SERVER["DOCUMENT_ROOT"] . "/Management/components/nav.html"); ?><!-- Navbar -->
                        <div class="col-xl-10 col-md-9 p-0"><!-- insert content here -->
                            <form id="deliveryfilter" class="col-lg-12 pt-3 g-0">
                                <div>
                                    <div class="btn-group col-xl-2 p-0 pr-2">
                                        <button class="btn btn-success" type="submit">Filter</button>
                                        <button class="btn btn-secondary" type="reset">Reset</button>
                                    </div>
                                </div>

                                <div class="form-row mb-3 pt-2">
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

                            <div class="col-lg-12 g-0 pt-2">
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
            </div>
        </div>
    </div>
</body>
</html>