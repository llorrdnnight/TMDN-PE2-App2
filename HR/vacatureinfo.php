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
        global $row;
        $job_id = $_GET["Jobid"]; //check op $_SERVER["REQUEST_METHOD"] == "GET" anders => redirect

        //Also sanitize job id nog even
        $sql = "SELECT degree, experience, general, job.name
        FROM jobdescription
        INNER JOIN job  On job.description = jobdescription.id
        WHERE job.id = '$job_id'";

        $result = $db->query($sql);

        foreach($result as $row)
        {
            echo '<tr>
                <td>'.$row["name"].'</td>
                <td>'.$row["degree"].'</td>
                <td>'.$row["experience"].'</td>
                <td>'.$row["general"].'</td>
            </tr>';
        }
    }
?>

<?php require(COMPONENTSDIR . COMPONENT_HEAD); ?>
    <link rel="stylesheet" href=<?= HTMLCSS . "vacature.css"; ?>>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css">
    <title>Vacature Info</title>
</head>
<body>
    <div class="nav-bar">
        <div class="left">
            <a href="vacature.php"><i class="fas fa-arrow-left"></i></a>
            <h1>Vacature Info</h1>
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
                            <th>degree</th>
                            <th>Experience</th>
                            <th>general</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php printRows(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
