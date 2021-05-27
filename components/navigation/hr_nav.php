<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php"); ?><!-- Should normally already be included in every page by default -->

<nav id="sidebar-wrapper" class="h-100 col-xl-2 col-md-3 col-12">
    <div class="h-100 d-flex flex-column justify-content-between">
        <ul>
            <li class="collapselink"><a href="#nav_sub_menu_main" data-toggle="collapse" aria-expanded="true">MAIN NAVIGATION &#9660;</a></li>
            <ul id="nav_sub_menu_main" class="list-unstyled collapse show">
                <li><a href=<?= HTMLHR . "dashboard.php"; ?>>Dashboard</a></li>
                <li><a href=<?= HTMLHR . "employeeInfo.php"; ?>>Employee info</a></li>
                <li><a href=<?= HTMLHR . "showAllUsers.php"; ?>>User List</a></li>
            </ul>

            <li class="collapselink"><a href="#nav_sub_menu_absences" data-toggle="collapse" aria-expanded="true">ABSENCES &#9660;</a></li>
            <ul id="nav_sub_menu_absences" class="list-unstyled collapse show">
                <li><a href=<?= HTMLHR . "absences/create.php"; ?>>New Absence</a></li>
                <li><a href=<?= HTMLHR . "absences/overview.php"; ?>>Overview</a></li>
            </ul>
            
            <li class="collapselink"><a href="#nav_sub_menu_leave" data-toggle="collapse" aria-expanded="true">LEAVE &#9660;</a></li>
            <ul id="nav_sub_menu_leave" class="list-unstyled collapse show">
                <li><a href=<?= HTMLHR . "leave/leave.php"; ?>>Overview</a></li>
                <li><a href=<?= HTMLHR . "leave/leavelist.php"; ?>>List</a></li>
                <li><a href=<?= HTMLHR . "leave/newleave.php"; ?>>New Leave</a></li>
            </ul>

            <li class="collapselink"><a href="#nav_sub_menu_vacature" data-toggle="collapse" aria-expanded="true">VACATURE &#9660;</a></li>
            <ul id="nav_sub_menu_vacature" class="list-unstyled collapse show">
                <li><a href=<?= HTMLHR . "vacature/addVacature.php"; ?>>New Vacature</a></li>
                <li><a href=<?= HTMLHR . "vacature/vacature.php"; ?>>Vacature List</a></li>
                <li><a href=<?= HTMLHR . "vacature/vacatureInfo.php"; ?>>Vacature Info</a></li>
            </ul>
        </ul>

        <ul>
            <li><a href=<?= HTMLHR . "logout.php"; ?>>Log out</a></li>
        </ul>
    </div>
</nav>