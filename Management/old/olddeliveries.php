<?php
    //Get temporary database file contents
    $json = json_decode(file_get_contents("database.json"), true);
    $rows = array();

    if ($_SERVER["REQUEST_METHOD"] == "GET") 
    {
        foreach($json["Deliveries"] as $Delivery)
        {
            $add = true;

            if (isset($_GET["PickupTime"]) && !empty($_GET["PickupTime"]))
                if (substr($Delivery["PickupTime"], 0, 5) != $_GET["PickupTime"])
                    $add = false;

            if (isset($_GET["Location"]) && !empty($_GET["Location"]))
                if ($Delivery["Location"] != $_GET["Location"])
                    $add = false;

            if (isset($_GET["DeliveryID"]) && !empty($_GET["DeliveryID"]))
                if ($Delivery["DeliveryID"] != $_GET["DeliveryID"])
                    $add = false;

            if (isset($_GET["Status"]) && !empty($_GET["Status"]))
                if ($Delivery["Status"] != $_GET["Status"])
                    $add = false;

            if (isset($_GET["Company"]) && !empty($_GET["Company"]))
                if ($Delivery["Company"] != $_GET["Company"])
                    $add = false;
    
            if (isset($_GET["ReceiptID"]) && !empty($_GET["ReceiptID"]))
                if ($Delivery["ReceiptID"] != $_GET["ReceiptID"])
                    $add = false;

            if ($add)
                array_push($rows, $Delivery);
        }
    }
    else
    {
        $rows = $json["Deliveries"];
    }

    function echoRows($arr)
    {
        foreach ($arr as $Delivery)
        {
            //Changes the status indicator on the left hand side of the row.
            if ($Delivery["Status"] == "Delivered")
                $tdclass = "class='deliverysuccess'";
            else
                $tdclass = "class='deliveryfailed'";

            $row = "";
            //Header row
            $row .= "<tr class='expandrow'>";
            $row .= "<td " . $tdclass . "></td>";
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

            foreach($Delivery as $key => $value)
            {
                $row .= "<p>" . $key . ": " . $value . "</p>";
            }

            $row .= "</div></td></tr>";

            echo $row;
        }        
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/reset.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./style/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="./scripts/javascript/expandRow.js"></script>
    <script src="./scripts/javascript/cleanForm.js"></script>
    <title>Deliveries</title>
</head>
<body>
    <div class="page-header">Page Header</div>
    
    <div id="content">
        <div id="filter">
            <form id="filterform">
                <button type="submit">Filter</button>
                <button type="reset">Reset</button>

                <table id="filtertable">
                    <tr>
                        <td>
                            <label for="PickupTime">Pickup Time</label>
                            <input name="PickupTime" type="time">
                        </td>
                        <td>
                            <label for="Location">Location</label>
                            <input name="Location" type="text">
                        </td>
                        <td>
                            <label for="DeliveryID">Delivery ID</label>
                            <input name="DeliveryID" type="number">
                        </td>
                        <td>
                            <label for="Status">Status</label>
                            <select name="Status">
                                <option hidden disabled selected value> - </option>
                                <option value="Delivered">Delivered</option>
                                <option value="On Hold">On Hold</option>
                                <option value="Not Delivered">Not Delivered</option>
                            </select>
                        </td>
                        <td>
                            <label for="Company">Company</label>
                            <input name="Company" type="text">
                        </td>
                        <td>
                            <label for="ReceiptID">Receipt ID</label>
                            <input name="ReceiptID" type="number">
                        </td>
                    </tr>
                </table>              
            </form>
        </div>

        <div id="deliveries">
            <table id="deliveriestable">
                <colgroup>
                    <col span="1" style="width: 8px;">
                </colgroup>
                <tr>
                    <th></th>
                    <th>Pickup Time</th>
                    <th>Location</th>
                    <th>Delivery ID</th>
                    <th>Status</th>
                    <th>Company</th>
                    <th>Receipt ID</th>
                </tr>
                <?php echoRows($rows); ?>
                <!-- <tr class="expandrow">
                    <td class="deliverysuccess"></td>
                    <td>x</td>
                    <td>x</td>
                    <td>x</td>
                    <td>x</td>
                    <td>x</td>
                    <td>x</td>
                </tr>
                <tr class="collapserow">
                    <td colspan="7">
                        <div">
                            <p>test</p>
                            <p>test</p>
                            <p>test</p>
                            <p>test</p>
                            <p>test</p>
                            <p>test</p>
                            <p>test</p>
                        </div>
                    </td>
                </tr> -->
            </table>
        </div>
        <h3>↑ expands on click</h3>
    </div>
</body>
</html>