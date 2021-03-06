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
                $tdclass = "delivered";
			elseif ($Delivery["Status"] == "On Hold")
				$tdclass = "onhold";
            else
                $tdclass = "notdelivered";

            $row = "";
            $row .= "<tr class='expandrow'>";
            $row .= "<td class='deliverystatus " . $tdclass . " w-10'></td>";
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
<?php require("./includes/header.html"); ?>
<?php require("./includes/head-deliveries-bottom.html"); ?>

<body>
    <div id="wrapper"> <!-- Page container -->
        <header class="col-lg-12"> <!-- Header class -->
            <h1>Deliveries</h1>
        </header>

		<div class="container-fluid"> <!-- Nav and content container -->
			<div class="row"> <!-- Row class for nav and content columns -->
                <?php require("./includes/nav.html"); ?>

				<div id="page-content-wrapper" class="col-lg-11"> <!-- Separate wrapper for content -->
					<div class="container-fluid"> <!-- Insert code after this container -->
						<form id="deliveryfilter" class="col-lg-12 nopadding">
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
										<option hidden disabled selected value> - </option>
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
							</div>
						</form>

						<div class="col-lg-12 nopadding">
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
									<?php echoRows($rows); ?>
								</tbody>
							</table>
						</div>
					</div> <!-- End of container -->
				</div>
			</div>
		</div>
    </div>
</body>
</html>