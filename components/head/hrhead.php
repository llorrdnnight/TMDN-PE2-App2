<?php require_once($_SERVER["DOCUMENT_ROOT"] . "/app2/PATHS.php"); ?>

<!DOCTYPE html> <!-- Head component for default scripts and links -->
<html lang="en">
<head>
    <meta charset="UTF-8"><!-- Default META tags -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href=<?= HTMLIMAGES . "LOGO_origin.png" ?>>
    <link rel="stylesheet" href=<?= HTMLCSS . CSS_RESET ?>><!-- Link reset before bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"><!-- Link respective style sheet -->
    <link rel="stylesheet" href=<?= HTMLCSS . CSS_HRSTYLE ?>>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src=<?= HTMLJAVASCRIPT . "collapseListItems.js"; ?>></script>
