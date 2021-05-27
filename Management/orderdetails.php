<?php
    if (!isset($_SESSION)) { session_start(); };
    require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php");
    require_once(PHPSCRIPTDIR . "error.php");

    if (!isset($_SESSION["employee_id"]))
        header("Location: login.php");

    $id = $_GET["id"];

    $order = json_decode(file_get_contents("http://10.128.30.7:8080/api/orders/" . $id), true);
    $customer = json_decode(file_get_contents("http://10.128.30.7:8080/api/orders/" . $id . "/customer"), true)[0];
    $shipments = json_decode(file_get_contents("http://10.128.30.7:8080/api/orders/" . $id . "/shipments"), true);

    if($order == null){
        header("Location: /app2/Management/orders.php");
    }

    function printOrderInfo($order){
        echo('<li class="list-group-item">Id: ' . $order["id"] . '</li>');
        echo('<li class="list-group-item">Order Number: ' . $order["orderNr"] . '</li>');
        echo('<li class="list-group-item">Order Date: ' . $order["created_at"] . '</li>');
        echo('<li class="list-group-item">Price: ' . $order["totalPrice"] . '</li>');
        echo('<li class="list-group-item">Extra Info: ' . $order["extraInfo"] . '</li>');
        if($order["isPaid"]){
            echo('<li class="list-group-item">Paid: Yes</li>');
        }
        else {
            echo('<li class="list-group-item">Paid: No</li>');
        }
        echo('<li class="list-group-item">Last Updated: ' . $order["updated_at"] . '</li>');


    }

    function printCustomerInfo($customer){
        echo('<li class="list-group-item">Id: ' . $customer["id"] . '</li>');
        echo('<li class="list-group-item">First Name: ' . $customer["firstName"] . '</li>');
        echo('<li class="list-group-item">Last Name: ' . $customer["lastName"] . '</li>');
        echo('<li class="list-group-item">Email: ' . $customer["email"] . '</li>');
        echo('<li class="list-group-item">Phone Number: ' . $customer["phoneNumber"] . '</li>');
    }

    function echoRows($shipments){
        foreach($shipments as $ship){
            $addresses = json_decode(file_get_contents('http://10.128.30.7:8080/api/orders/' . $_GET["id"] . '/shipments/' . $ship["id"] . '/addresses'), true);

			echo('<tr>');
				echo('<td>' . $ship["id"] . '</td>');
                foreach($addresses as $address){
                    echo('<td>' . $address[0]["addressNumber"] . " " . $address[0]["addressStreet"] . "<br>"
                     . $address[0]["addressZip"] . " " . $address[0]["addressPlace"] . "<br>"
                     . $address[0]["addressCountry"] . '</td>');
                }
			echo("</tr>");
		}
    }
?>

<?php require(COMPONENTSDIR . COMPONENT_MANAGEMENTHEAD); ?>
    <title>Order Detail</title>
</head>
<?php require(COMPONENTSDIR . COMPONENT_MANAGEMENT_BODY_TOP); ?>
    <div class="row m-3 p-0 justify-content-around">
        <div class="col-5">
            <div class="card">
                <div class="card-header bg-blue">
                    <span>Order Information</span>
                </div>

                <ul class="list-group list-group-flush">
                    <?php
                        printOrderInfo($order);
                    ?>
                </ul>
            </div>
        </div>
        <div class="col-5">
            <div class="card">
                <div class="card-header bg-blue">
                    <span>Customer Information</span>
                </div>

                <ul class="list-group list-group-flush">
                    <?php
                        printCustomerInfo($customer);
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="row m-3 mt-5 p-0">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Shipment ID</th>
                    <th>Departure Adress</th>
                    <th>Destination Address</th>
                </tr>
            </thead>
            <tbody>
                <?php echoRows($shipments); ?>
            </tbody>
        </table>
    </div>
<?php require(COMPONENTSDIR . COMPONENT_BODY_BOTTOM); ?>
