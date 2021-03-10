<?php
	include "OrderList.php";

	function printRows() {
		global $orderArr;
		
		foreach($orderArr as $order){
			echo('<tr>');
				echo('<td>' . $order->get_id() . '</td>');
				echo('<td>' . $order->get_sourceAdd() . '</td>');
				echo('<td>' . $order->get_destAdd() . '</td>');
				echo('<td>' . $order->get_departDate() . '</td>');
				echo('<td>' . $order->get_customerId() . '</td>');
				echo('<td>' . $order->get_status() . '</td>');
				echo('<td> &euro;' . $order->get_price() . '</td>');
				if($order->get_payed()){
					echo('<td>&check;</td>');
				}
				else {
					echo('<td>&#10005;</td>');
				}
				echo('<td>' . '<a href="/Management/orderDetail.php?id=' . $order->get_id() . '">More Info</a>' . '</td>');
			echo("</tr>");
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
    <title>Orders</title>
</head>

<body>
    <div id="wrapper"> <!-- Page container -->
        <header class="col-lg-12"> <!-- Header class -->
            <h1>Orders</h1>
        </header>

		<div class="container-fluid"> <!-- Nav and content container -->
			<div class="row"> <!-- Row class for nav and content columns -->
				<nav id="sidebar-wrapper" class="col-lg-1"> <!-- 1 unit wide column -->
					<ul class="sidebar-nav">
						<li><a href="/Management/orders.php">Orders</a></li>
						<li><a href="/Management/deliveries.php">Deliveries</a></li>
						<li><a href="/Management/lostpackages.php">Lost Packages</a></li>
						<li><a href="/Management/complaints/dashboard.php">Complaints</a></li>
						<li>
							<ul>
								<li><a href="/Management/complaints/dashboard.php">Dashboard</a></li>
								<li><a href="/Management/complaints/opencomplaints.php">Open Complaints</a></li>
								<li><a href="/Management/complaints/closedcomplaints.php">Closed Complaints</a></li>
								<li><a href="/Management/complaints/registercomplaint.php">Register Complaint</a></li>
							</ul>
						</li>
					</ul>
				</nav>

				<div id="page-content-wrapper" class="col-lg-11"> <!-- Separate wrapper for content -->
					<div class="container-fluid"> <!-- Insert code after this container -->
						<div class="col-lg-12 nopadding">
							<table id="orderstable" class="table table-hover table-responsive">
								<thead>
									<tr>
										<th>Id</th>
										<th>Source</th>
										<th>Destination</th>
										<th>Date</th>
										<th>Customer</th>
										<th>Status</th>
										<th>Price</th>
										<th>Payed</th>
										<th>More Info</th>
									</tr>
								</thead>
								<tbody>
									<?php printRows(); ?>
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