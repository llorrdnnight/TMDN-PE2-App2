<?php
    //Get temporary database file contents
    $json = json_decode(file_get_contents("../database.json"), true);
    $closedjson = getComplaintsByAttribute($json["Complaints"], "Status", "Closed");

    //Declare empty array, the default page variable and the number of table rows
    $rows = array();
    $page = 1; $maxrows = 12;

    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        $filteredjson = getFilteredArray($closedjson);
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
        $totalitems = count($closedjson);
        $totalpages = ceil($totalitems / $maxrows);
        $rows = $closedjson;
    }

    function getFilteredArray($arr)
    {
        $FilteredArray = array();
        $FilterList = array("ComplaintID", "OrderID", "Category", "Customer", "Location", "ReportedBy", "Date");
        
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

    function echoComplaints($Complaints)
    {
        foreach ($Complaints as $Complaint)
        {
            $Date = new DateTime($Complaint["Date"]);
            $Now = new DateTime("now");
            $DaysOpen =  $Now->diff($Date)->days;

            $row = "";
            $row .= "<tr>";
            $row .= "<td class='complaintid'><a href='./editcomplaint.php?ComplaintID=" . $Complaint["ComplaintID"] . "'>" . $Complaint["ComplaintID"] . "</a></td>";
            $row .= "<td>" . $Complaint["OrderID"] . "</td>";
            $row .= "<td>" . $Complaint["Category"] . "</td>";
            $row .= "<td>" . $Complaint["Customer"] . "</td>";
            $row .= "<td>" . $Complaint["Location"] . "</td>";
            $row .= "<td>" . $Complaint["Reported By"] . "</td>";
            $row .= "<td>" . $Complaint["Date"] . "</td>";
            $row .= "<td>" . $DaysOpen . "</td>";
            $row .= "</tr>";
            
            echo $row;
        }
    }

    function echoComplaintDetails($Complaints, $ComplaintID)
    {
        foreach ($Complaints as $Complaint)
        {
            if ($Complaint["ComplaintID"] == $_GET["ComplaintID"])
            {
                $row = "";
                $row .= "<tr>";
                $row .= "<td class='complaintid'><a href='./editcomplaint.php?ComplaintID=" . $Complaint["ComplaintID"] . "'>" . $Complaint["ComplaintID"] . "</a></td>";
                $row .= "<td>" . $Complaint["OrderID"] . "</td>";
                $row .= "<td>" . $Complaint["Category"] . "</td>";
                $row .= "<td>" . $Complaint["Customer"] . "</td>";
                $row .= "<td>" . $Complaint["Location"] . "</td>";
                $row .= "<td>" . $Complaint["Reported By"] . "</td>";
                $row .= "<td>" . $Complaint["Date"] . "</td>";
                $row .= "<td>" . "fill in date diff here" . "</td>";
                $row .= "</tr>";
                
                echo $row;
                return;
            }
        }
    }

    function echoPageIndex($totalpages)
    {
        //It is required to echo the get variables into each page link
        $FilterLink = "";
        $FilterList = array("PickupTime", "Location", "DeliveryID", "Status", "Company", "ReceiptID");

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

<?php require($_SERVER["DOCUMENT_ROOT"] . "/Management/components/head/head.php"); ?>
<?php require($_SERVER["DOCUMENT_ROOT"] . "/Management/components/head/head-opencomplaints-bottom.php"); ?>
<body>
    <div id="wrapper"> <!-- Page container -->
        <header class="col-lg-12"> <!-- Header class -->
            <h1><a href='opencomplaints.php'>Open Complaints</a></h1>
        </header>

		<div class="container-fluid"> <!-- Nav and content container -->
			<div class="row"> <!-- Row class for nav and content columns -->
                <?php require($_SERVER["DOCUMENT_ROOT"] . "/Management/components/nav.html"); ?>

				<div id="page-content-wrapper" class="col-lg-11"> <!-- Separate wrapper for content -->
                    <?php require($_SERVER["DOCUMENT_ROOT"] . "/Management/components/complaintsnav.html"); ?>

                    <form id="complaintsfilter" class="col-lg-12 g-0">
                        <div>
                            <div class="btn-group">
                                <button class="btn btn-success" type="submit">Filter</button>
                                <button class="btn btn-secondary" type="reset">Reset</button>
                            </div>
                        </div>

                        <div class="form-row mb-3">
                            <div class="col-lg-2 col-sm-4">
                                <label for="ComplaintID">ComplaintID</label>
                                <input class="form-control" name="ComplaintID" type="number">
                            </div>

                            <div class="col-lg-2 col-sm-4">
                                <label for="OrderID">OrderID</label>
                                <input class="form-control" name="OrderID" type="number">
                            </div>

                            <!-- Does not work yet -->
                            <div class="col-lg-2 col-sm-4">
                                <label for="Category">Category</label>
                                <select class="form-control" name="Category">
                                    <option hidden disabled selected value>-</option>
                                </select>
                            </div>

                            <!-- Same story -->
                            <div class="col-lg-2 col-sm-4">
                                <label for="Customer">Customer</label>
                                <input class="form-control" name="Customer" type="text">
                            </div>

                            <div class="col-lg-2 col-sm-4">
                                <label for="Location">Location</label>
                                <input class="form-control" name="Location" type="text">
                            </div>

                            <div class="col-lg-2 col-sm-4">
                                <label for="Date">Date</label>
                                <input class="form-control" name="Date" type="date">
                            </div>

                            <?php echo "<input name='Page' type='hidden' value='" . $page . "'>"; ?>
                        </div>
                    </form>

                    <div class="col-lg-12 nopadding">
                        <div id="opencomplaints">
                            <table id='opencomplaintstable' class='table table-hover'><tr>
                                <thead>
                                    <tr>
                                        <th>Complaint ID</th>
                                        <th>Order ID</th>
                                        <th>Category</th>
                                        <th>Customer</th>
                                        <th>Location</th>
                                        <th>Reported by</th>
                                        <th>Date</th>
                                        <th>Days open</th></tr>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        if (isset($_GET["ComplaintID"]) && !empty($_GET["ComplaintID"]))
                                            echoComplaintDetails($json["Complaints"], $_GET["ComplaintID"]);
                                        else
                                            echoComplaints($rows);
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
				</div>
			</div>
		</div>
    </div>
</body>

</html>