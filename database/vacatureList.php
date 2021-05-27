<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php");
    require_once(PHPSCRIPTDIR . "error.php");
    require_once(PHPCLASSDIR . "Vacature.php");

    $vacArr = array(
        new vacature(1, "WerkMan Gezocht", "HR", True, "Work... Work... Work..."),
        new vacature(2, "WerkMan Gezocht", "HR", True, "Work... Work... Work..."),
        new vacature(3, "WerkMan Gezocht", "HR", True, "Work... Work... Work..."),
        new vacature(4, "WerkMan Gezocht", "HR", True, "Work... Work... Work..."),
        new vacature(5, "WerkMan Gezocht", "HR", True, "Work... Work... Work..."),
        new vacature(6, "WerkMan Gezocht", "HR", True, "Work... Work... Work..."),
    );
?>
