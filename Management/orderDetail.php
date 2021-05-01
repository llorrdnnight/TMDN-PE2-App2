<?php
    include "OrderList.php";
    session_start();
    // Check if the session is set else redirect to login page
    if (isset($_SESSION['employee_id'])){}
    
    else
    header("Location: login.php");
    $id = $_GET['id'];
    foreach($orderArr as $order){
        if($order->get_id() == $id){
            $pageOrder = $order;
            break;
        }
    }
    if($pageOrder == null){
        header("Location: /TMDN-PE2-App2/Management/orders.php");
    }

    function printOrderInfo(){
        global $pageOrder;
        echo('<p>Id: ' . $pageOrder->get_id() . '</p>');
        echo('<p>Source: ' . $pageOrder->get_sourceAdd() . '</p>');
        echo('<p>Destination: ' . $pageOrder->get_destAdd() . '</p>');
        echo('<p>Departure Date: ' . $pageOrder->get_departDate() . '</p>');
        if($pageOrder->get_arrivalDate() == null){
            echo('<p>Arrival Date: Not Arrived Yet</p>');
        }
        else{
            echo('<p>Arrival Date: ' . $pageOrder->get_arrivalDate() . '</p>');
        }
        echo('<p>Status: ' . $pageOrder->get_status() . '</p>');
        echo('<p>Price: &euro;' . $pageOrder->get_price() . '</p>');
        if($pageOrder->get_payed()){
            echo('<p>Payed: Yes</p>');
        }
        else {
            echo('<p>Payed: No</p>');
        }
        
    }

    function printCustomerInfo(){
        global $customer;

        echo('<p>Id: ' . $customer->get_id() . '</p>');
        echo('<p>First Name: ' . $customer->get_fName() . '</p>');
        echo('<p>Last Name: ' . $customer->get_lName() . '</p>');
        echo('<p>Date of Birth: ' . $customer->get_dateOB() . '</p>');
        echo('<p>Email: ' . $customer->get_email() . '</p>');
        echo('<p>Phone Number: ' . $customer->get_phone() . '</p>');
        echo('<p>Type: ' . $customer->get_type() . '</p>');
    }

    function printRows(){
        global $packages;

        foreach($packages as $pack){
			echo('<tr>');
				echo('<td>' . $pack->get_id() . '</td>');
				echo('<td>' . $pack->get_name() . '</td>');
				echo('<td>' . $pack->get_quantity() . '</td>');
				echo('<td>' . $pack->get_weight() . '</td>');
			echo("</tr>");
		}
    }
?>
<!DOCTYPE html>
<html lang="en">
<?php require($_SERVER["DOCUMENT_ROOT"] . "/TMDN-PE2-App2/Management/components/head/head.php"); ?>
    <title>Order Detail</title>
</head>

<body>
    <div id="wrapper"> <!-- Page container -->
        <header class="col-lg-12"> <!-- Header class -->
            <h1>Order</h1>
        </header>

		<div class="container-fluid"> <!-- Nav and content container -->
			<div class="row"> <!-- Row class for nav and content columns -->
            <?php require("./components/nav.html"); ?>

				<div id="page-content-wrapper" class="col-lg-11"> <!-- Separate wrapper for content -->
					<div class="container-fluid"> <!-- Insert code after this container -->
                        <div class="row">
                            <div class="col-lg-6">
                                <h3>Order Info</h3>
                                <?php printOrderInfo(); ?>
                            </div>
                            <div class="col-lg-5">
                                <h3>Customer Info</h3>
                                <?php printCustomerInfo(); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-11">
                                <h3>Packages</h3>
                                <table id="packagestable" class="table table-hover table-responsive">
								<thead>
									<tr>
										<th>Id</th>
										<th>Name</th>
										<th>Quantity</th>
										<th>Weight</th>
									</tr>
								</thead>
								<tbody>
									<?php printRows(); ?>
								</tbody>
							</table>
                            </div>
                        </div>
					</div> <!-- End of container -->
				</div>
			</div>
		</div>
    </div>
</body>
</html>