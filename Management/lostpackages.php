<?php
    if (!isset($_SESSION)) { session_start(); };
    require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php");
    require_once(PHPSCRIPTDIR . "error.php");

    if (!isset($_SESSION["employee_id"]))
        header("Location: login.php");

    $json = json_decode(file_get_contents(MOCKDIR . "database.json"), true);

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
            $row .= "<td><a href='" . COMPLAINTSDIR . "complaints.php?id=" . $Package["ComplaintID"] . "'>" . $Package["ComplaintID"] . "</a></td>";
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

<?php require(COMPONENTSDIR . COMPONENT_MANAGEMENTHEAD); ?>
    <title>Lost Packages</title>
</head>
<?php require(COMPONENTSDIR . COMPONENT_MANAGEMENT_BODY_TOP); ?>
    <div id="lostpackages">
        <table id="lostpackagestable" class="table table-sm table-hover">
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
<?php require(COMPONENTSDIR . COMPONENT_BODY_BOTTOM); ?>
