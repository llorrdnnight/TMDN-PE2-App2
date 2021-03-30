<?php
    //Get temporary database file contents
    $json = json_decode(file_get_contents("TEMPDB.json"), true);

    //Declare empty array, the default page variable and the number of table rows
    $rows = array();
    $page = 1; 
    $maxrows = 12;

    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        $filteredjson = getFilteredArray($json["TimeOff"]);
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

    function echoLeave($TimeOff, $Employees)
    {
        foreach ($TimeOff as $Leave)
        {
            //Table row
            $row = "";
            $row .= "<tr>";
            $row .= "<td class='col-1'>" . $Leave["EmployeeID"] . "</td>";
            $row .= "<td class='col-1'>" . $Employees[$Leave["EmployeeID"]]["Surname"] . "</td>";
            $row .= "<td class='col-1'>" . $Employees[$Leave["EmployeeID"]]["Firstname"] . "</td>";
            $row .= "<td class='col-1'>" . $Leave["RequestDate"] . "</td>";
            $row .= "<td class='col-1'>" . $Leave["Daterange"][0] . "</td>";
            $row .= "<td class='col-1'>" . $Leave["Daterange"][0] . "</td>";
            $row .= "<td class='col-1'>" . "insert type" . "</td>";
            $row .= "<td class='col-1'><button class='btn btn-success'>Edit</button></td>";
            $row .= "<td class='col-1'><button class='btn btn-danger'>Delete</button></td>";
            $row .= "</tr>";

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/HR/css/reset.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/HR/css/test.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script><!-- Jquery -->
    <title>Verlof</title>
</head>
<body>
    <div id="wrapper" class="container-fluid h-100"><!-- full body wrapper -->
        <div class="row h-100">
            <div class="col-12">
                <div class="d-flex flex-column h-100"><!-- content flexbox -->
                    <div class="row">
                        <div class="col-12 p-0">
                            <header><!-- insert header here -->
                                <h1 class="pl-2"><a href='deliveries.php'>Verlof</a></h1>
                            </header>
                        </div>
                    </div>

                    <div class="row flex-grow-1">
                        <div class="col-lg-12 g-0 pt-2">
                            <?php require($_SERVER["DOCUMENT_ROOT"] . "/HR/components/leavenav.php"); ?>

                            <table id="leavetable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>EmployeeID</th>
                                        <th>Surname</th>
                                        <th>Firstname</th>
                                        <th>RequestDate</th>
                                        <th>From</th>
                                        <th>Until</th>
                                        <th>Type</th>
                                        <th>x</th>
                                        <th>x</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echoLeave($rows, $json["Employees"]); ?>
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