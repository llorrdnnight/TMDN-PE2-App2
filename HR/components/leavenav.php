<?php require($_SERVER["DOCUMENT_ROOT"] . "/TMDN-PE2-App2/HR/php/PATH.php"); ?>

<nav aria-label="Page navigation" class="row d-flex justify-content-center">
    <ul class="pagination">
        <li class='page-item'><a class='page-link' href=<?= LEAVEPATH . "/leave.php"; ?>>Dashboard</a></li>
        <li class='page-item'><a class='page-link' href=<?= LEAVEPATH . "/newleave.php"; ?>>Nieuwe verlof aanvraag</a></li>
        <li class='page-item'><a class='page-link' href=<?= LEAVEPATH . "/leavelist.php"; ?>>List</a></li>
    </ul>
</nav>