<?php
session_start();
// Check if the session is set else redirect to login page
if (isset($_SESSION['employee_id'])){}

else
header("Location: login.php");
    $json = json_decode(file_get_contents("database.json"), true);

    function echoLostPackages($arr)
    {
        $now = new DateTime("now");

        foreach ($arr as $Package)
        {
            $date = new DateTime($Package["Date"]);
            $diff = $now->diff($date);

            $row = "";
            $row .= "<tr>";
            $row .= "<td>" . $Package["PackageID"] . "</td>";
            $row .= "<td><a href='./complaints/opencomplaints.php?ComplaintID=" . $Package["ComplaintID"] . "'>" . $Package["ComplaintID"] . "</a></td>";
            $row .= "<td>" . $Package["OrderID"] . "</td>";
            $row .= "<td>" . $Package["Date"] . "</td>";
            $row .= "<td>" . $Package["Addressee"] . "</td>";
            $row .= "<td>" . $Package["Last Checkpoint"] . "</td>";
            $row .= "<td>" . $diff->format("%d") . "</td>";
            $row .= "</tr>";
            
            echo $row;
        }
    }
?>

<?php require($_SERVER["DOCUMENT_ROOT"] . "/TMDN-PE2-App2/Management/components/head.php"); ?>
    <title>Lost Packages</title>
</head>
<body>
    <div id="wrapper" class="container-fluid h-100"><!-- full body wrapper -->
        <div class="row h-100">
            <div class="col-12">
                <div class="d-flex flex-column h-100"><!-- content flexbox -->
                    <div class="row">
                        <div class="col-12 p-0">
                            <header> <!-- Header class -->
                                <h1>Lost Packages</h1>
                            </header>
                        </div>
                    </div>

                    <div class="row flex-grow-1">
                        <?php require($_SERVER["DOCUMENT_ROOT"] . "/TMDN-PE2-App2/Management/components/nav.html"); ?>

                        <div class="col-xl-10 col-md-9 p-0"><!-- insert content here -->
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
    </div>
</body>
</html>