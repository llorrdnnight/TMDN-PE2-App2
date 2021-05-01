<?php
    $pageTable = array(
        "orders.php" => "Orders",
        "deliveries.php" => "Deliveries",
        "lostpackages.php" => "Lost Packages",

        "statistics.php" => "Statistics",
        "opencomplaints.php" => "Open Complaints",
        "closedcomplaints.php" => "Closed Complaints",
        "registercomplaint.php" => "Register Complaint",
        "editcomplaint.php" => "Edit Complaint",

        "addUser.php" => "Add User"
    );

    $pageName = $pageTable[basename($_SERVER["PHP_SELF"])];
?>

<body>
    <div id="wrapper" class="container-fluid h-100"><!-- full body wrapper -->
        <div class="row h-100">
            <div class="col-12">
                <div class="d-flex flex-column h-100"><!-- content flexbox -->
                    <div class="row">
                        <div class="col-12 p-0">
                            <header><!-- insert header here -->
                                <div id="header-image-container"><img id="header-image" src=<?= HTMLIMAGES . "LOGO_composite.png"; ?> class="img-fluid"></div>
                                <h1><a id="header-title" href=<?= basename($_SERVER["PHP_SELF"]); ?>><?= $pageName; ?></a></h1>
                            </header>
                        </div>
                    </div>

                    <div class="row flex-grow-1">
                        <?php require(COMPONENTSDIR . COMPONENT_NAV); ?><!-- Navbar -->
                        <div class="col-xl-10 col-md-9 p-0"><!-- insert content here -->