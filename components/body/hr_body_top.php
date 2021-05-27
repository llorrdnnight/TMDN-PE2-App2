<?php require("pageTable.php"); ?>

<body>
    <div id="wrapper" class="container-fluid h-100"><!-- full body wrapper -->
        <div class="row h-100">
            <div class="col-12">
                <div class="d-flex flex-column h-100"><!-- content flexbox -->
                    <div class="row">
                        <div class="col-12 p-0">
                            <header class="d-flex flex-row justify-content-between"><!-- insert header here -->
                                <div class="d-flex flex-row align-items-center pt-1">
                                    <div id="header-image-container"><img id="header-image" src=<?= HTMLIMAGES . "LOGO_composite.png"; ?> class="img-fluid"></div>
                                    <h1><a id="header-title" href=<?= basename($_SERVER["PHP_SELF"]); ?>><?= $pageName; ?></a></h1>
                                </div>

                                <div>
                                    <h3 class="pt-1 pr-5"><?= "hrmgr"; //$_SESSION["employee_id"]; ?></h3>
                                </div>
                            </header>
                        </div>
                    </div>

                    <div class="row flex-grow-1">
                        <?php require(COMPONENTSDIR . COMPONENT_HR_NAV); ?><!-- Navbar -->
                        <div class="col-xl-10 col-md-9 p-0"><!-- insert content here -->