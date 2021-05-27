<?php
    if (!isset($_SESSION)) { session_start(); };
    require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php");
    require_once(PHPSCRIPTDIR . "error.php");
    require(MOCKDIR . "orderlist.php");

    if (!isset($_SESSION["employee_id"]))
        header("Location: login.php");

    //Meant for changing prices of services or products we offer.
    //Put on hold because I am not certain we will need or use this. -Jari
?>

<?php require(COMPONENTSDIR . COMPONENT_MANAGEMENTHEAD); ?>
    <title>Pricing</title>
</head>
<?php require(COMPONENTSDIR . COMPONENT_MANAGEMENT_BODY_TOP); ?>
    <!-- Insert content here -->
<?php require(COMPONENTSDIR . COMPONENT_BODY_BOTTOM); ?>
