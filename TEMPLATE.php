<?php
    if (!isset($_SESSION)) { session_start(); };
    require($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php");
    require(PHPSCRIPTDIR . "error.php");
?>

<?php //require(COMPONENTSDIR . "insert head component here"); ?>
    <!-- Add non-default scripts and links here -->
    <title><!-- Page title --></title>
</head>
<?php //require(COMPONENTSDIR . "insert body component here"); ?>
    <!-- Header title can be set in the pageTable.php file => components/body/ -->
    <!-- Insert body here -->
<?php require(COMPONENTSDIR . COMPONENT_BODY_BOTTOM); ?>