<?php
	include "OrderList.php";
	session_start();
	// Check if the session is set else redirect to login page
	if (isset($_SESSION['employee_id'])){}
	
	else
	header("Location: login.php");
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
				echo('<td>' . '<a href="/TMDN-PE2-App2/Management/orderDetail.php?id=' . $order->get_id() . '">More Info</a>' . '</td>');
			echo("</tr>");
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<?php require($_SERVER["DOCUMENT_ROOT"] . "/TMDN-PE2-App2/Management/components/head/head.php"); ?>
</head>

<body>
<div id="wrapper" class="container-fluid h-100"><!-- full body wrapper -->
        <div class="row h-100">
            <div class="col-12">
                <div class="d-flex flex-column h-100"><!-- content flexbox -->
                    <div class="row">
                        <div class="col-12 p-0">
                            <header class="col-lg-12"> <!-- Header class -->
                                <h1>Orders</h1>
                            </header>
                        </div>
                    </div>

		<div class="row flex-grow-1">
            <?php require($_SERVER["DOCUMENT_ROOT"] . "/TMDN-PE2-App2/Management/components/nav.html"); ?>

			<div class="col-xl-10 col-md-9 p-0"><!-- insert content here -->
					<div class="container-fluid"> <!-- Insert code after this container -->
						<div class="col-lg-12 nopadding">
							<table id="orderstable" class="table table-hover">
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