<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/TMDN-PE2-App2/PATHS.PHP");
    
	include "OrderList.php";
	// session_start();
	// // Check if the session is set else redirect to login page
	// if (isset($_SESSION['employee_id'])){}
	
	// else
	// header("Location: login.php");
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

<?php require(COMPONENTSDIR . COMPONENT_HEAD); ?>
    <title>Orders</title>
</head>

<?php require(COMPONENTSDIR . COMPONENT_BODY_TOP); ?>
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
<?php require(COMPONENTSDIR . COMPONENT_BODY_BOTTOM); ?>