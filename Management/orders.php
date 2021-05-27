<?php
    if (!isset($_SESSION)) { session_start(); };
    require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php");
    require_once(PHPSCRIPTDIR . "error.php");

    if (!isset($_SESSION["employee_id"]))
        header("Location: login.php");

    $orders = json_decode(file_get_contents("http://10.128.30.7:8080/api/orders"), true)["data"];

    $rows = array();
    $page = 1;
    $maxrows = 12;
    $index = 0; //too lazy to change the foreach loop down below to an indexed for loop.

    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        $filteredjson = getFilteredArray($orders);
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
        $totalitems = count($orders);
        $totalpages = ceil($totalitems / $maxrows);
        $rows = $orders;
    }

    function getFilteredArray($arr)
    {
        // Deze functie wordt enkel gecalld
        $filteredArray = array();
        $filterList = array("id", "orderNr", "customerId", "totalPrice", "isPaid");

        foreach ($arr as $item) //Push items in filtered array depending on their values
        {
            $push = true;

            // We can compare every value naturally except for DateTime
            if (isset($_GET["created_at"]))
            {
                $itemtime = new DateTime($item["created_at"]);
                $push = $itemtime->format("H:i") == $_GET["created_at"];
            }

            // if (isset($_GET["arrivalTime"]))
            // {
            //     $itemtime = new DateTime($item["arrivalTimeStamp"]);
            //     $push = $itemtime->format("H:i") == $_GET["arrivalTimeStamp"];
            // }

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
        // $filterList = array("shipmentId", "flightId", "parcelTypeId", "priority", "isAllocated");

        // foreach($FilterList as $Filter)
        // {
        //     if (isset($_GET[$Filter]))
        //         $FilterLink .= '&' . $Filter . '=' . $_GET[$Filter];
        // }

        for ($i = 0; $i < $totalpages; $i++)
        {
            echo "<li class='page-item'><a class='page-link' href='orders.php?Page=" . ($i + 1) . $FilterLink . "'>" . ($i + 1) . "</a></li>";
        }
    }
?>

<?php require(COMPONENTSDIR . COMPONENT_MANAGEMENTHEAD); ?>
    <script src=<?= HTMLJAVASCRIPT . "cleanForm.js"; ?>></script>
    <title>Orders</title>
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

            <div class="form-group col-lg-1 col-sm-4">
                <label for="OrderID">OrderID</label>
                <input class="form-control" name="id" type="number">
            </div>

            <div class="form-group col-lg-2 col-sm-4">
                <label for="orderNr">Order Number</label>
                <input class="form-control" name="orderNr" type="text">
            </div>

            <div class="form-group col-lg-2 col-sm-4">
                <label for="customerId">Customer ID</label>
                <input class="form-control" name="customerId" type="number">
            </div>

            <div class="form-group col-lg-2 col-sm-4">
                <label for="totalPrice">Total Price</label>
                <input class="form-control" name="totalPrice" type="number">
            </div>

            <div class="form-group col-lg-2 col-sm-4">
                <label for="isPaid">Paid</label>
                <input class="form-control" name="isPaid" type="number">
            </div>

            <div class="form-group col-lg-2 col-sm-4">
                <label for="created_at">Order Date</label>
                <input class="form-control" name="created_at" type="date">
            </div>

            <?php echo "<input name='Page' type='hidden' value='" . $page . "'>"; ?>
        </div>
    </form>

    <div class="col-12 pt-2 g-0"><!-- Todo: justify page index to bottom of page -->
        <?php if ($totalitems) { ?>
            <table class="table table-hover col-12">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Order Number</th>
                        <th>Cutomer ID</th>
                        <th>Total Price</th>
                        <th>Paid</th>
                        <th>Order Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $order) {
                        ?>
                        <tr>
                            <td><a href='<?= "./orderDetails.php?id=" . $order["id"]; ?>' class="clink"><?= $order["id"]; ?></a></td>
                            <td><?= $order["orderNr"]; ?></td>
                            <td><?= $order["customerId"]; ?></td>
                            <td><?= $order["totalPrice"]; ?></td>
                            <?php
                                if($order["isPaid"] == 1){
                                    echo('<td>&check;</td>');
                                }
                                else {
                                    echo('<td>&#10005;</td>');
                                }
                            ?>
                            <td><?= $order["created_at"]; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php $index++; } else { echo "No orders found."; } ?>

        <nav aria-label="Page navigation" class="d-flex justify-content-center">
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>
                <?php echoPageIndex($totalpages); ?>
                <li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>
            </ul>
        </nav>
    </div>
<?php require(COMPONENTSDIR . COMPONENT_BODY_BOTTOM); ?>
