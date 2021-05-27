<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php"); ?>

<nav aria-label="Page navigation" class="row d-flex justify-content-center pt-3">
    <ul class="pagination">
        <li class='page-item'><a class='page-link' href=<?= HTMLLEAVE . "leave.php"; ?>>Overview</a></li>
        <li class='page-item'><a class='page-link' href=<?= HTMLLEAVE . "newleave.php"; ?>>New Leave Request</a></li>
        <li class='page-item'><a class='page-link' href=<?= HTMLLEAVE . "leavelist.php"; ?>>Leave Listing</a></li>
    </ul>
</nav>
