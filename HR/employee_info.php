<?php
/**
* Footer to be included into the HR webpages
*
* @author Levi Nauwelaerts
* @datetime 25 February 2021
* @input Employee_id given through the url
*/
 ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php
          echo "<title>Employee info " + $employee_id+ "</title>"
        ?>
        <link rel="stylesheet" href="./css/reset.css">
    </head>
    <body>
        <?php include './components/footer.php';?>
    </body>
    </html>
