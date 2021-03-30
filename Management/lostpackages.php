<?php
session_start();
// Check if the session is set else redirect to login page
if (isset($_SESSION['employee_id'])){}

else
header("Location: login.php");
    $json = json_decode(file_get_contents("database.json"), true);

    function echoLostPackages($arr)
    {
        foreach ($arr as $Package)
        {
            $row = "";
            $row .= "<tr>";
            $row .= "<td>" . $Package["PackageID"] . "</td>";
            $row .= "<td><a href='./complaints/opencomplaints.php?ComplaintID=" . $Package["ComplaintID"] . "'>" . $Package["ComplaintID"] . "</a></td>";
            $row .= "<td>" . $Package["OrderID"] . "</td>";
            $row .= "<td>" . $Package["Date"] . "</td>";
            $row .= "</tr>";
            
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
    <link rel="stylesheet" type="text/css" href="./style/reset.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./style/style.css">
    <title>Lost Packages</title>
</head>
<body>
    <div id="wrapper"> <!-- Page container -->
        <header class="col-lg-12"> <!-- Header class -->
            <h1>Lost Packages</h1>
        </header>

		<div class="container-fluid"> <!-- Nav and content container -->
			<div class="row"> <!-- Row class for nav and content columns -->
                <?php require($_SERVER["DOCUMENT_ROOT"] . "/TMDN-PE2-App2/Management/components/nav.html"); ?>

				<div id="page-content-wrapper" class="col-lg-11"> <!-- Separate wrapper for content -->
					<div class="container-fluid">
                        <div id="lostpackages">
                            <table id="lostpackagestable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Package ID</th>
                                        <th>Complaint ID</th>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Addressee</th>
                                        <th>Last Checkpoint</th>
                                        <th>Days Lost</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echoLostPackages($json["LostPackages"]); ?>
                                </tbody>
                            </table>
                        </div>
					</div>
				</div>
			</div>
		</div>
    </div>
</body>
</html>