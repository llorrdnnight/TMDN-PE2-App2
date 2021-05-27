<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php");

    include(MOCKDIR . "vacatureList.php");
    include(INCLUDESDIR . "db_config.php");
    include(INCLUDESDIR . "sanitize.php");
    include(INCLUDESDIR . "authentication.php");

    if (!isset($_SESSION)) { session_start(); };

    if(isLoggedIn()){

        // redirect to main page
    }

    $error = null;

    function printRows() {
        global $db;

        $sql = "SELECT job.id, job.name, job.available ,department.name as dpname, department.location
        FROM job
        INNER JOIN department  On job.department = department.id";
        $result = $db->query($sql);

        foreach($result as $row)
        {
            echo '<tr>
                    <td>'.$row["name"].'</td>
                    <td>'.$row["dpname"].'</td>
                    <td>'.$row["location"].'</td>
                    <td>'.$row["available"].'</td>
                    <td><a href="vacatureinfo.php?Jobid='.$row["id"].'">Read More...</a></td>
                </tr>';
        }
    }
?>

<?php require(COMPONENTSDIR . COMPONENT_HEAD); ?>
    <link rel="stylesheet" href=<?= HTMLCSS . "vacature.css"; ?>>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css">
    <title>Vacature</title>
</head>
<body>
    <div class="nav-bar">
        <div class="left">
            <a href="dashboard.php"><i class="fas fa-arrow-left"></i></a>
            <h1>Vacature</h1>
        </div>

        <div class="right">
            <i class="fa fa-user-circle"></i>
            <span>John Doe</span>
        </div>
    </div>

    <div id="page-content-wrapper" class="col-lg-11">
        <div class="container-fluid">
            <div class="col-lg-12 nopadding">
                <table id="orderstable" class="table table-hover table-responsive">
                    <thead>
                        <tr>
                            <th>Job Title</th>
                            <th>Department</th>
                            <th>Location</th>
                            <th>available</th>
                            <th>Info</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php printRows(); ?>
                    </tbody>
                </table>
            </div>
        </div> <!-- End of container -->
    </div>
</body>
</html>
