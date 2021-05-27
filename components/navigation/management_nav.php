<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php"); ?><!-- Should normally already be included in every page by default -->

<nav id="sidebar-wrapper" class="h-100 col-xl-2 col-md-3 col-12">
    <div class="h-100 d-flex flex-column justify-content-between">
        <ul>
            <li class="collapselink"><a href="#nav_sub_menu_main" data-toggle="collapse" aria-expanded="true">MAIN NAVIGATION &#9660;</a></li>
            <ul id="nav_sub_menu_main" class="list-unstyled collapse show">
                <li><a href=<?= HTMLMANAGEMENT . "orders.php"; ?>>Orders</a></li>
                <li><a href=<?= HTMLMANAGEMENT . "revenue.php"; ?>>Revenue</a></li>
                <li><a href=<?= HTMLMANAGEMENT . "deliveries.php"; ?>>Deliveries</a></li>
                <li><a href=<?= HTMLMANAGEMENT . "lostPackages.php"; ?>>Lost Packages</a></li>
                <li><a href=<?= HTMLMANAGEMENT . "statistics.php"; ?>>Statistics</a></li>
                
            </ul>

            <li class="collapselink mt-2"><a href="#nav_sub_menu_complaints" data-toggle="collapse" aria-expanded="true">COMPLAINTS &#9660;</a></li>
            <ul id="nav_sub_menu_complaints" class="list-unstyled collapse show">
                <li><a href=<?= HTMLCOMPLAINTS . "statistics.php"; ?>>Statistics</a></li>
                <li><a href=<?= HTMLCOMPLAINTS . "registerComplaint.php"; ?>>Register Complaint</a></li>
                <li><a href=<?= HTMLCOMPLAINTS . "complaints.php"; ?>>Complaints</a></li>
            </ul>

            <?php if (1) { ?>
                <li class="collapselink mt-2"><a href="#nav_sub_menu_admin" data-toggle="collapse" aria-expanded="true">ADMIN &#9660;</a></li>
                <ul id="nav_sub_menu_admin" class="list-unstyled collapse show">
                    <li><a href=<?= HTMLMANAGEMENT . "addUser.php"; ?>>Add user</a></li>
                </ul>
            <?php } ?>
        </ul>

        <ul>
            <li><a href=<?= HTMLMANAGEMENT . "logout.php"; ?>>Log out</a></li>
        </ul>
    </div>
</nav>
