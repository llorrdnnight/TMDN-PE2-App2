<nav id="sidebar-wrapper" class="h-100 col-xl-2 col-md-3 col-12">
    <div class="h-100 d-flex flex-column justify-content-between">
        <ul>
            <li class="collapselink"><a href="#">MAIN NAVIGATION &#9660;</a></li>
            <li><a href=<?= HTMLMANAGEMENT . "orders.php"; ?>>Orders</a></li>
            <li><a href=<?= HTMLMANAGEMENT . "deliveries.php"; ?>>Deliveries</a></li>
            <li><a href=<?= HTMLMANAGEMENT . "lostpackages.php"; ?>>Lost Packages</a></li>
            <li class="collapselink mt-2"><a href="#">COMPLAINTS &#9660;</a></li> <!-- these collapselinks need to be fixed in the js file -->
            <li><a href=<?= HTMLCOMPLAINTS . "statistics.php"; ?>>Statistics</a></li>
            <li><a href=<?= HTMLCOMPLAINTS . "registercomplaint.php"; ?>>Register Complaint</a></li>
            <li><a href=<?= HTMLCOMPLAINTS . "opencomplaints.php"; ?>>Open Complaints</a></li>
            <li><a href=<?= HTMLCOMPLAINTS . "closedcomplaints.php"; ?>>Closed Complaints</a></li>
            <?php
                if (1) // convert to => if $session[admin] etc.
                {
                    $adminPanel = "";
                    $adminPanel .= "<li class='collapselink mt-2'><a href='#'>ADMIN PANEL &#9660;</a></li>";
                    $adminPanel .= "<li><a href=" . HTMLMANAGEMENT . "addUser.php" . ">Add user</a></li>";

                    echo $adminPanel;
                }
            ?>
        </ul>

        <ul>
            <li><a href=<?= HTMLMANAGEMENT . "logout.php"; ?>>Logout</a></li>
        </ul>
    </div>
</nav>